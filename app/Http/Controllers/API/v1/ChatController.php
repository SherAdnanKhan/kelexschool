<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Validator;
use Auth;
use App\Models\User;
use App\Models\Message;
use App\Models\MessageLog;
use App\Models\Conversation;
use Storage;
use Image;

class ChatController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        //$user_with_conversation = User::with('conversations')->find($user->id);
        $conversations = Conversation::with('messages.user.avatars', 'participants.avatars', 'participants.art.parent', 'messages.userMessageLog')
        ->whereHas('participants', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->withCount('unreadMessagesLogs')
        ->get();

        $returnData['conversations'] = $conversations;

        return $this->sendResponse($returnData, 'User conversation list');
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($user_slug)
    {
        $returnData = $userIds = $conversation_all_ids =[];
        $user = Auth::guard('api')->user();
        array_push($userIds, $user->id);
        $user_chatable_check = User::with('avatars', 'art.parent')->where('slug', $user_slug)->first();
        if( !$user_chatable_check ) {
            return $this->sendError('Invalid User', ['error'=>'Unauthorized User', 'message' => 'No user exists']);
        }
        $returnData['user'] = $user_chatable_check; 
        array_push($userIds, $user_chatable_check->id);
        // Check conversation exists
        $coverations_all = Conversation::whereHas('participants', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get('id');
        foreach ($coverations_all as $coveration) {
            array_push($conversation_all_ids, $coveration->id);
        }
        //return $conversation_all_ids;
        $hasConversation = Conversation::with('messages.user.avatars', 'participants.avatars', 'messages.messagesLogs')->whereHas('participants', function($query) use ($user_chatable_check) {
            $query->where('user_id', $user_chatable_check->id);
        })->whereIn('id', $conversation_all_ids)->first();
        //dd($hasConversation);
        
        if( !$hasConversation ) {
            $conversation = Conversation::create(['name', 'room_com']);
            $conversation->participants()->attach($userIds);

            $new_conversation = Conversation::with('messages.user.avatars')->find($conversation->id);
            $returnData['conversation'] = $new_conversation;
        }
        else {
            $messages_logs = MessageLog::where('conversation_id', $hasConversation->id)->where('user_id', $user->id)->update(['status' => 1]);
            $returnData['conversation'] = $hasConversation;
        }
        return $this->sendResponse($returnData, 'User One to one Conversation');

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
        //$user = Auth::guard('api')->user();

        $validator = Validator::make($request->all(), [
            // 'message' => 'required',
            'conversation_id' => 'required',
            'user_id' => 'required'
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $user = User::with('avatars')->findOrFail($request->user_id);
        try {
            $hasConversation = Conversation::with('messages.user.avatars')->whereHas('participants', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->find($request->conversation_id);
            if (!$hasConversation) {
                return $this->sendError('Invalid Conversation', ['error'=>'Unauthorised Chat Part', 'message' => 'Please send into your respected']);
            }
            $message = new Message;
            $message->message = $request->message;
            $message->conversation_id = $request->conversation_id;
            $message->feel_color = $user->feel_color;
            $message->created_by = $user->id;
            $message->type = isset($request->message_type) ? $request->message_type : 0;
            $message->url = isset($request->url) ? $request->url : null; 
            $message->save(); 

            foreach($hasConversation->participants as $participant) {
                if($participant->id != $user->id) {
                    $participant_user = User::find($participant->id);
                    $message_log = new MessageLog;
                    $message_log->conversation_id = $request->conversation_id;
                    $message_log->message_id = $message->id;
                    $message_log->user_id = $participant->id;
                    $message_log->feel_color = $participant_user->feel_color;
                    $message_log->save();
                }
            }

            $newly_mesage = Message::with('messagesLogs', 'user.avatars')->find($message->id);
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
    public function show($id)
    {
        $user = Auth::guard('api')->user();
        $hasConversation = Conversation::with('messages.user.avatars')->whereHas('participants', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->find($id);

        if (!$hasConversation) {
            return $this->sendError('Invalid Conversation', ['error'=>'Unauthorised Chat Part', 'message' => 'Please send into your respected']);
        }
        try {
            $messages_logs = MessageLog::where('conversation_id', $hasConversation->id)->where('user_id', $user->id)->update(['status', 1]);
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
    public function edit($id)
    {
        //
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
        //
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
        //dd($message_id);
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

        $message = Message::with('messagesLogs')->find($message_id);
        if (!isset($message)) {
            return $this->sendError('Invalid Message', ['error'=>'No Message Exists', 'message' => 'No Message exists']);
        }

        try {
            $messages_logs = MessageLog::where('message_id', $message_id)->where('user_id', $request->user_id)->update(['status' => 1]);
            $returnData['message'] = $message;
        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        
        return $this->sendResponse($returnData, 'Message Status read');
    }

    public function unreadCount()
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $user = User::withCount('unreadMessages')->find($user->id);
        $returnData['user_unread_count'] = $user->unread_messages_count;

        return $this->sendResponse($returnData, 'Message Status read');

    }
}
