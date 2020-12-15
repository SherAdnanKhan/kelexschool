<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Validator;
use Auth;
use App\Models\UserSprvfsIO;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($post_id)
    {
        $my_user = Auth::guard('api')->user();
        $is_sprfvs = 0;
        $post = Post::with('user')->findOrFail($post_id);
        $returnData['comments'] = $comments = Comment::with('user.avatars', 'user.feel')->where('post_id', $post_id)->get();
        if(isset($my_user)) {
            $check_user_sprfvs = UserSprvfsIO::where([
                ['created_to',  $post->user->id], 
                ['privacy_type_id', 3], 
                ['created_by', $my_user->id]
                ])->first();
            if(isset($check_user_sprfvs)) {
                if($check_user_sprfvs->status == 1) {
                    $is_sprfvs = 1;
                }
                else {
                    $is_sprfvs = 2;
                }
            }
            $returnData['other_privacy'] = $other_privacy = $this->CheckPrivacyPage($is_sprfvs, $my_user->id, $post->user->id, 3);
        }

        return $this->sendResponse($returnData, 'comments');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'comment' => 'required',
            'post_id' => 'required',
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        try {
            $post = Post::findOrFail($request->post_id);
            
            $comment = new Comment;
            $comment->description = $request->comment;
            $comment->post_id = $request->post_id;
            $comment->created_by = $user->id;
            $comment->save(); 

            $comment_return = Comment::with('user.avatars', 'user.feel')->find($comment->id);
            $returnData['comment'] = $comment_return;

            $post = Post::find($request->post_id);
            $type='CRITIQES';
           $result= $this->generateNotification($user->id, $post->created_by,$post,$type);

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Comment Added');
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
