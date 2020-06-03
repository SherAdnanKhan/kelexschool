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
        $conversations = Conversation::with('messages.user.avatars', 'participants.avatars', 'participants.art.parent', 'unreadMessagesLogs')
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
        $hasConversation = Conversation::with('messages.user.avatars', 'participants.avatars')->whereHas('participants', function($query) use ($user_chatable_check) {
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
            'message' => 'required',
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
            $message->created_by = $user->id;
            $message->save(); 

            foreach($hasConversation->participants as $participant) {
                if($participant->id != $user->id) {
                    $message_log = new MessageLog;
                    $message_log->conversation_id = $request->conversation_id;
                    $message_log->message_id = $message->id;
                    $message_log->user_id = $participant->id;
                    $message_log->save();
                }
            }

            $returnData['message'] = $message;
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
    
    public function uploadImageOnChat(Request $request)
    {
        $returnData = [];
        $directory = 'chats/images/';
        $user = Auth::guard('api')->user();

        $validator = Validator::make($request->all(), [
            'image' => 'image|max:3000|required|dimensions:min_width=100,min_height=100'
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $file = $request->image;
        try {
            $fileNameStore = time();
            $extension = $file->getClientOriginalExtension();
            $uuid = $this->generateRandomString();
            $imageName = $uuid.'-'.$fileNameStore.'.'.$extension;
            $imageNameThumb = $uuid.'-'.$fileNameStore.'-thumbnail.'.$extension;
            $image = $file;
            //$thumbnail = Image::make($file)->resize(100, 100)->save($imageNameThumb);
            $thumbnail = Image::make($file)->resize(300, null, function ($constraint) {$constraint->aspectRatio();});

            Storage::disk('s3')->put($directory.$imageName, file_get_contents($image), 'public');
            $image_path = Storage::disk('s3')->url($directory.$imageName);

            Storage::disk('s3')->put($directory.$imageNameThumb, $thumbnail->stream()->__toString(), 'public');
            $image_path_thumbnail = Storage::disk('s3')->url($directory.$imageNameThumb);

            $returnData['image'] = ['image_path' => $image_path, 'image_name' => $imageName, 'image_thumbnail' => $image_path_thumbnail];
            

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Image Uploaded');
    }
    
}
