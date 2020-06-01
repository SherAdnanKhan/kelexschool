<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Validator;
use Auth;
use App\Models\User;
use App\Models\Message;
use App\Models\Conversation;

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
        $conversations = Conversation::with('messages.user.avatars', 'participants')->whereHas('participants', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

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
        $hasConversation = Conversation::with('messages.user.avatars')->whereHas('participants', function($query) use ($user_chatable_check) {
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
        $user = Auth::guard('api')->user();

        $validator = Validator::make($request->all(), [
            'message' => 'required',
            'conversation_id' => 'required',
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

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

            $returnData['message'] = $message;

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
        //
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
}
