<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Validator;
use Auth;
use App\Models\User;
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
        $user = Auth::guard('api')->user();

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($user_slug)
    {
        $returnData = $userIds = [];
        $user = Auth::guard('api')->user();
        array_push($userIds, $user->id);
        $user_chatable_check = User::with('avatars', 'art.parent')->where('slug', $user_slug)->first();
        if( !$user_chatable_check ) {
            return $this->sendError('Invalid User', ['error'=>'Unauthorized User', 'message' => 'No user exists']);
        }
        $returnData['user'] = $user_chatable_check; 
        array_push($userIds, $user_chatable_check->id);
        // Check conversation exists
        $hasConversation = Conversation::with('messages.user.avatars')->whereHas('participants', function($query) use ($userIds) {
            $query->whereIn('user_id', $userIds);
        })->first();
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
