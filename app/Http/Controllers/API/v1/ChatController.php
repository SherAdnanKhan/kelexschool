<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Validator;
use Auth;
use App\Models\UserBlock;
use App\Models\User;
use App\Models\Message;
use App\Models\MessageLog;
use App\Models\Conversation;
use App\Models\UserConversation;
use App\Models\UserSprvfsIO;
use Carbon\Carbon;
use Storage;
use Image;

class ChatController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        //$user_with_conversation = User::with('conversations')->find($user->id);
        $deleted_conversation_ids = $this->getDeletedConversationIds($user->id);
        $conversations = Conversation::with('lastMessage.user.avatars', 'participants.avatars', 'participants.feel', 'participants.art.parent', 'conversationStatus')
        ->whereHas('participants', function($query) use ($user) {
          $query->where('user_id', $user->id);
        })
        ->whereNotIn('id', $deleted_conversation_ids)
        ->withCount('unreadMessagesLogs')
        ->orderBy('updated_at', 'desc')
        ->paginate(15);

        $returnData['conversations'] = $conversations;

        return $this->sendResponse($returnData, 'User conversation list');
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($user_slug, $chat_type = null, Request $request)
    {
        $returnData = $userIds = $conversation_all_ids =[];
        $is_sprfvs = 0;
        $user = Auth::guard('api')->user();
        if(isset($chat_type) ) {
          $hasConversation = Conversation::with('participants.avatars', 'participants.feel', 'conversationStatus')->findOrFail($user_slug);
          $hasConversation['messages'] = Message::with('messagesLogs.feel', 'user.avatars', 'user.feel', 'feel')->where('conversation_id', $hasConversation->id)->orderBy('created_at', 'DESC')->paginate(env('PAGINATE_LENGTH', 15));
          $returnData['conversation'] = $hasConversation;
        }else {
          array_push($userIds, $user->id);
          $user_chatable_check = User::with('feel', 'avatars', 'art.parent')->where('slug', $user_slug)->first();
          if( !$user_chatable_check ) {
            return $this->sendError('Invalid User', ['error'=>'Unauthorized User', 'message' => 'No user exists']);
          }
          $returnData['user'] = $user_chatable_check; 
          array_push($userIds, $user_chatable_check->id);
          // Check conversation exists
          $coverations_all = Conversation::withCount('participants')->whereHas('participants', function($query) use ($user) {
            $query->where('user_id', $user->id);
          })->get('id');
          foreach ($coverations_all as $coveration) {
            if($coveration->participants_count == 2) {
              array_push($conversation_all_ids, $coveration->id);
            }
          }
          $hasConversation = Conversation::with('participants.avatars', 'participants.feel', 'conversationStatus')->whereHas('participants', function($query) use ($user_chatable_check, $user) {
            $query->where('user_id', $user_chatable_check->id);
          })->whereIn('id', $conversation_all_ids)->first();
        }
        if( !$hasConversation ) {
            $conversation = Conversation::create(['name', 'room_com']);
            $conversation->participants()->attach($userIds);

            $new_conversation = Conversation::with('participants.avatars', 'participants.feel')->find($conversation->id);
            $new_conversation['messages'] = Message::with('messagesLogs.feel', 'user.avatars', 'user.feel', 'feel')->where('conversation_id', $conversation->id)->orderBy('created_at', 'DESC')->paginate(env('PAGINATE_LENGTH', 15));
            $returnData['conversation'] = $new_conversation;
            if($new_conversation->participants->count() == 2) {
              foreach($new_conversation->participants as $participant){
                if($participant->id != $user->id) {
                  $returnData['is_blocked'] = $this->CheckUserBlocked($user->id, $participant->id);
                  $returnData['is_viewable'] = $this->CheckUserViewable($user->id, $participant->id);
                  $returnData['is_muted'] = $this->CheckUserMute($user->id, $participant->id);

                  //Check if sprfvs already 
                  $check_user_sprfvs = UserSprvfsIO::where([
                    ['created_to',  $participant->id], 
                    ['privacy_type_id', 3], 
                    ['created_by', $user->id]
                    ])->first();
                  if(isset($check_user_sprfvs)) {
                    if($check_user_sprfvs->status == 1) {
                      $is_sprfvs = 1;
                    }
                    else {
                      $is_sprfvs = 2;
                    }
                  }
                  $returnData['is_sprfvs'] = $is_sprfvs;
                  $returnData['strq_privacy'] = $other_privacy = $this->CheckPrivacyPage($is_sprfvs, $user->id, $participant->id, 1);
                }
              }
            }
        }
        else {
            $coversation_id = $hasConversation->id;
            if($hasConversation->conversationStatus) {
              $hasConversation['messages'] = Message::with('messagesLogs.feel', 'user.avatars', 'user.feel', 'feel')->where([ ['conversation_id', $coversation_id], ['created_at', '>', $hasConversation->conversationStatus->updated_at] ])->orderBy('created_at', 'DESC')->paginate(env('PAGINATE_LENGTH', 15));
            }else {
              $hasConversation['messages'] = Message::with('messagesLogs.feel', 'user.avatars', 'user.feel', 'feel')->where([ ['conversation_id', $coversation_id] ])->orderBy('created_at', 'DESC')->paginate(env('PAGINATE_LENGTH', 15));
            }
            
            $messages_logs = MessageLog::where('conversation_id', $hasConversation->id)->where('user_id', $user->id)->update(['status' => 1]);
            $returnData['conversation'] = $hasConversation;
            if($hasConversation->participants->count() == 2) {
              foreach($hasConversation->participants as $participant){
                if($participant->id != $user->id) {
                  $returnData['is_blocked'] = $this->CheckUserBlocked($user->id, $participant->id);
                  $returnData['is_viewable'] = $this->CheckUserViewable($user->id, $participant->id);
                  $returnData['is_muted'] = $this->CheckUserMute($user->id, $participant->id);

                  //Check if sprfvs already 
                  $check_user_sprfvs = UserSprvfsIO::where([
                    ['created_to',  $participant->id], 
                    ['privacy_type_id', 3], 
                    ['created_by', $user->id]
                    ])->first();
                  if(isset($check_user_sprfvs)) {
                    if($check_user_sprfvs->status == 1) {
                      $is_sprfvs = 1;
                    }
                    else {
                      $is_sprfvs = 2;
                    }
                  }
                  $returnData['is_sprfvs'] = $is_sprfvs;
                  $returnData['strq_privacy'] = $other_privacy = $this->CheckPrivacyPage($is_sprfvs, $user->id, $participant->id, 1);
                }
              }
            }
        }
        
        return $this->sendResponse($returnData, 'User Conversation Created');

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $returnData = [];
        $my_user = Auth::guard('api')->user();

        $validator = Validator::make($request->all(), [
            'message' => 'min:1',
            'conversation_id' => 'required',
            'user_id' => 'required'
        ]);
        if ($validator->fails()){
          return $this->sendError('Validation Error.', $validator->errors());       
        }
        $user = User::with('avatars')->findOrFail($request->user_id);
        try {
            $hasConversation = Conversation::with('messages.user.avatars', 'messages.user.feel')->whereHas('participants', function($query) use ($user) {
              $query->where('user_id', $user->id);
            })->find($request->conversation_id);
            if (!$hasConversation) {
              return $this->sendError('Invalid Conversation', ['error'=>'Unauthorised Chat Part', 'message' => 'Please send into your respected']);
            }
            $message = new Message;
            $message->message = $request->message;
            $message->conversation_id = $request->conversation_id;
            $message->feel_id = $user->feel_id;
            $message->created_by = $user->id;
            $message->type = isset($request->message_type) ? $request->message_type : 0;
            $message->url = isset($request->url) ? $request->url : null; 
            $message->save(); 
            
            //update conversation update time
            $hasConversation->touch();

            //deleted chat updation remove from is_deleted
            $deleted_conversation = UserConversation::where([ ['conversation_id', $request->conversation_id], ['user_id', $my_user->id] ])->first();
            if(isset($deleted_conversation)) {
              $deleted_conversation->is_deleted = 0;
              $deleted_conversation->update();
            }

            foreach($hasConversation->participants as $participant) {
                if($participant->id != $user->id) {
                    $participant_user = User::find($participant->id);
                    $message_log = new MessageLog;
                    $message_log->conversation_id = $request->conversation_id;
                    $message_log->message_id = $message->id;
                    $message_log->user_id = $participant->id;
                    $message_log->feel_id = $participant_user->feel_id;
                    $message_log->save();
                }
            }

            $newly_mesage = Message::with('messagesLogs.feel', 'user.avatars', 'user.feel', 'feel')->find($message->id);
            $returnData['message'] = $newly_mesage;
            $returnData['user'] = $user;

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Chat Message sent');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $hasConversation = Conversation::whereHas('participants', function($query) use ($user) {
          $query->where('user_id', $user->id);
        })->find($id);

        if (!$hasConversation) {
          return $this->sendError('Invalid Conversation', ['error'=>'Unauthorised Chat Part', 'message' => 'Please send into your respected']);
        }
        try {
          $returnData['conversation'] = $hasConversation;
          $returnData['messages'] = Message::with('messagesLogs.feel', 'user.avatars', 'user.feel', 'feel')->where('conversation_id', $hasConversation->id)->orderBy('created_at', 'DESC')->paginate(env('PAGINATE_LENGTH', 15));
        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Chat Message Update');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function groupChat(Request $request)
    {
      $returnData = [];
      $user = Auth::guard('api')->user();
      $validator = Validator::make($request->all(), [
        'user_ids' => 'required|array',
      ]);
      if ($validator->fails()){
        return $this->sendError('Validation Error.', $validator->errors());       
      }
      try {
        $conversation = Conversation::create(['name', 'room_com']);
        $conversation->participants()->attach($user->id);
        $conversation->participants()->attach($request->user_ids);
        $new_conversation = Conversation::with('participants.avatars', 'participants.feel')->find($conversation->id);
        $new_conversation['messages'] = Message::with('messagesLogs.feel', 'user.avatars', 'user.feel', 'feel')->where('conversation_id', $conversation->id)->orderBy('created_at', 'DESC')->paginate(env('PAGINATE_LENGTH', 15));
        $returnData['conversation'] = $new_conversation;
      }catch(QueryException $ex) {
        return $this->sendError('Validation Error.', $ex->getMessage(), 200);
      }catch(\Exception $ex) {
        return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
      }
      return $this->sendResponse($returnData, 'Group chat created');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = Auth::guard('api')->user();
      $returnData = [];
      try {
          $conversation = Conversation::whereHas('participants', function($query) use ($user) {
            $query->where('user_id', $user->id);
          })->find($id);
          if (!$conversation) {
            return $this->sendError('No record', ['error'=>'No record of chat', 'message' => 'There is no such chat found']);
          }
          //check already deleted
          $user_conversation_check = UserConversation::where([['conversation_id', $conversation->id], ['user_id', $user->id]])->first();
          if ($user_conversation_check) {
            if ($user_conversation_check->is_deleted == 1) {
              return $this->sendError('Already deleted', ['error'=>'Already deleted chat', 'message' => 'This chat is already deleted']);
            }else {
              $user_conversation_check->is_deleted = 1;
              $user_conversation_check->last_deleted_at = Carbon::now();
              $user_conversation_check->update();
            }
          }
          else {
            $user_conversation = new UserConversation();
            $user_conversation->conversation_id = $conversation->id;
            $user_conversation->user_id = $user->id;
            $user_conversation->save();
          }

      }catch(QueryException $ex) {
          return $this->sendError('Validation Error.', $ex->getMessage(), 200);
      }catch(\Exception $ex) {
          return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
      }
      return $this->sendResponse($returnData, 'chat deleted sucessfully');
    }

    public function destroyMessage($id)
    {
        $user = Auth::guard('api')->user();
        try {
            $message_check = Message::find($id);
            if (!$message_check) {
              return $this->sendError('No record', ['error'=>'No record of message', 'message' => 'There is no such message found']);

            }
            if ($message_check->created_by != $user->id) {
              return $this->sendError('Unauthoirzed', ['error'=>'Unauthorized message', 'message' => 'You are not allowed to delete this message']);
            }

            $message_check->delete(); 

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse([], 'Message deleted sucessfully');
    }

    public function addPeopleToChat($conversation_id, Request $request)
    {
      $returnData = [];
      $user = Auth::guard('api')->user();
      $validator = Validator::make($request->all(), [
        'user_ids' => 'required|array',
      ]);
      if ($validator->fails()){
        return $this->sendError('Validation Error.', $validator->errors());       
      }
      $conversation = Conversation::with('participants')->withCount('participants')->find($conversation_id);
      if (!isset($conversation)){
        return $this->sendError('Invalid Conversation', ['error'=>'No chat exists', 'message' => 'No chat exsits']);
      }
      try {
        //return $conversation->participants_count;
        if($conversation->participants_count == 2) {
          $new_conversation = Conversation::create(['name', 'room_com']);
          foreach ($conversation->participants as $participant) {
            $new_conversation->participants()->attach($participant->id);
          }
          $new_conversation->participants()->attach($request->user_ids);
          $conversation_id = $new_conversation->id;
        }
        else {
          $conversation_id = $conversation->id;
          foreach ($request->user_ids as $user_id_add) {
            if (! $conversation->participants->contains($user_id_add)) {
              $conversation->participants()->attach($user_id_add);
            }
          }
        }
        
        $new_conversation = Conversation::with('participants.avatars', 'participants.feel')->find($conversation_id);
        $new_conversation['messages'] = Message::with('messagesLogs.feel', 'user.avatars', 'user.feel', 'feel')->where('conversation_id', $conversation_id)->orderBy('created_at', 'DESC')->paginate(env('PAGINATE_LENGTH', 15));
        $returnData['conversation'] = $new_conversation;
      }catch(QueryException $ex) {
        return $this->sendError('Validation Error.', $ex->getMessage(), 200);
      }catch(\Exception $ex) {
        return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
      }
      return $this->sendResponse($returnData, 'Participant Added');
    }
    
    public function uploadOnChat(Request $request)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $file_type = "document";
        $supported_image = ["jpg","jpeg","gif","png","bmp"];
        $supported_video = ["mp4", "m4a", "m4v", "f4v", "f4a", "m4b", "m4r", "f4b", "mov", "3gp", "3gp2", "3g2", "3gpp", "3gpp2", "ogg", "oga", "ogv", "ogx", "wmv", "wma", "asf*", "webm", "flv", "MTS", "mpg", "mkv", "mpeg"];

        $directory = 'chats/uploads/';
        if (!isset($request->file_upload)) {
            return $this->sendError('No file', ['error'=>'No file', 'message' => 'Please send attachement to upload']);
        }
        $validator = Validator::make($request->all(), [
            'file_upload' => env('DOCUMENT_SIZE', '2000'),
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $file = $request->file_upload;
        try {
            $fileNameStore = time();
            $extension = $file->getClientOriginalExtension();
            $uuid = $this->generateRandomString();
            $imageName = $uuid.'-'.$fileNameStore.'.'.$extension;
            $fileName = pathinfo($file)['filename'];
            if(!isset($fileName) || $fileName= ' ') {
                pathinfo($file)['filename'] = $uuid;
            }
            //$file = $_FILES['file_upload'];
            //dd($_FILES['file_upload']);

            if(in_array($extension,$supported_image)) {
                $file_type = "image";
                $directory = 'chats/images/';
            }
            else if (in_array($extension, $supported_video)) {
                $file_type = "video";
                $directory = 'chats/videos/';
            }
            else {
                $file_type = "document";
                $directory = 'chats/uploads/';
            }

            Storage::disk('s3')->put($directory.$imageName,  fopen($file, 'r+'), 'public');
            $document_path = Storage::disk('s3')->url($directory.$imageName);
        
            $returnData['path'] = $document_path;
            $returnData['doc_type'] = $file_type;
            $returnData['doc_name'] = $imageName; 
        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        
        return $this->sendResponse($returnData, 'File Uploaded');

    }

    public function readMessage($message_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $user = User::find($request->user_id);
        if (!isset($user)) {
            return $this->sendError('Invalid User', ['error'=>'No User Exists', 'message' => 'No User exists']);
        }

        $message = Message::with('messagesLogs.feel', 'feel')->find($message_id);
        if (!isset($message)) {
            return $this->sendError('Invalid Message', ['error'=>'No Message Exists', 'message' => 'No Message exists']);
        }

        try {
            $messages_logs = MessageLog::where([ ['message_id', $message_id], ['user_id', $request->user_id] ])->first();
            if (!isset($messages_logs)) {
                return $this->sendError('Invalid Message', ['error'=>'No Message Exists', 'message' => 'No Message exists']);
            }
            $messages_logs->status = 1;
            $messages_logs->read_at = now();
            $messages_logs->update();

            $message = Message::with('messagesLogs.feel', 'feel')->find($message_id);
            $returnData['message'] = $message;
        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        
        return $this->sendResponse($returnData, 'Message Status read');
    }
    public function readAllMessage(Request $request)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $validator = Validator::make($request->all(), [
            'conversation_id' => 'required'
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $hasConversation = Conversation::with('messages.user.avatars')->whereHas('participants', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->find($request->conversation_id);

        if (!$hasConversation) {
            return $this->sendError('Invalid Conversation', ['error'=>'Unauthorised Chat Part', 'message' => 'Please send into your respected']);
        }
        try {
            $messages_logs = MessageLog::where('conversation_id', $hasConversation->id)->where('user_id', $user->id)->update(['status' => 1]);
        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Chat Message Read All');
        
    }

    public function unreadCount()
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $user = User::withCount('unreadMessages')->find($user->id);
        $returnData['user_unread_count'] = $user->unread_messages_count;

        return $this->sendResponse($returnData, 'User unread counts');

    }

    public function privacyCheckChat()
    {
      # code...
    }
}
