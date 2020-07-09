<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Validator;
use Auth;
use App\Models\Post;
use App\Models\Image;
use App\Models\Gallery;
use App\Models\PrivacyPage;
use App\Models\UserSprvfsIO;


class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'title' => 'required',
            'gallery_id' => 'required',
            'image' => env('IMAGE_TYPE_SIZE', '1000'),
            'video' => env('DOCUMENT_SIZE', '2000'),
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        try {
            $gallery = Gallery::findOrFail($request->gallery_id);
            if ($gallery->created_by != $user->id) {
                return $this->sendError('Invalid Gallery', ['error'=>'Unauthorised Gallery', 'message' => 'Please post into your gallery']);
            }
            $post = new Post;
            $post->title = $request->title;
            $post->gallery_id = $request->gallery_id;
            $post->art_id = $request->art_id ? $request->art_id : null;
            $post->description = $request->description ? $request->description : null;
            $post->created_by = $user->id;
            $post->save(); 
            $gallery->touch();

            if($request->has('image')) {
                $image_recived = $this->uploadImage($request->image, "posts/");
                $image = new Image();
                $image->title = $image_recived['image_name'];
                $image->path = $image_recived['image_path'];
                $image->image_type = 'App\Models\Post';
                $image->image_id = $post->id;
                $image->created_by = $user->id;
                $image->save();

                //update post type 
                $post->update(['post_type' => 1]);
            }

            if($request->has('video')) {
                $image_recived = $this->uploadImage($request->video, "posts/videos/");
                $image = new Image();
                $image->title = $image_recived['image_name'];
                $image->path = $image_recived['image_path'];
                $image->image_type = 'App\Models\Post';
                $image->image_id = $post->id;
                $image->created_by = $user->id;
                $image->save();

                //update post type 
                $post->update(['post_type' => 2]);
            }

            $returnData['post'] = $post;
            $returnData['post']['image'] = $image;

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Exhibit Added');
    }

    public function makeStroke(Request $request)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $validator = Validator::make($request->all(), [
            'post_id' => 'required',
        ]);
   
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        try {
            $hasStroke = $user->strokePosts()->where('id', $request->post_id)->exists();
            if ($hasStroke) {
                return $this->sendError('Already Stoke Post', ['error'=>'Already Stroke Post', 'message' => 'You already stroke this post']);
            }
            
            $user->strokePosts()->attach($request->post_id);

        }catch(QueryException $ex) {
            return $this->sendError('Query Exception Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Mark Stroke Successfully.');
    }

    public function unStroke(Request $request)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $validator = Validator::make($request->all(), [
            'post_id' => 'required',
        ]);
   
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        try {
            $hasStroke = $user->strokePosts()->where('id', $request->post_id)->exists();
            if (!$hasStroke) {
                return $this->sendError('None Stoke Post', ['error'=>'None Stroke Post', 'message' => 'You didn\'t stroke this post before']);
            }
            
            $user->strokePosts()->detach($request->post_id);

        }catch(QueryException $ex) {
            return $this->sendError('Query Exception Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Mark UnStroke Successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $returnData = $other_privacy = [];
        $my_user = Auth::guard('api')->user();
        $is_sprfvs = 0;
        $post = Post::where('slug', $slug)->with('image', 'user.art.parent', 'user.avatars')->withCount('strokeUsers')->first();
        if (!isset($post)) {
            return $this->sendError('Invalid Post', ['error'=>'No Post Exists', 'message' => 'No post exists']);
        }
        $returnData['post'] = $post;
        $returnData['has_stroke'] = $hasStroke = $my_user->strokePosts()->where('id', $post->id)->exists();
        
        $other_posts = Post::with('image', 'user.art.parent', 'user.avatars')->where([ ['gallery_id', '=', $post->gallery_id], ['id', '!=', $post->id] ])->get();
        $returnData['other_posts'] = $other_posts;
        //Check if sprfvs already 
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
        $returnData['is_sprfvs'] = $is_sprfvs;
        //crtiques page
        
        $returnData['other_privacy'] = $other_privacy = $this->CheckPrivacyPage($is_sprfvs, $my_user->id, $post->user->id, 3);
        return $this->sendResponse($returnData, 'Post');
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

    public function ncomm($slug, Request $request)
    {
        $returnData = [];
        $post = Post::where('slug', $slug)->with('image', 'user.art.parent', 'user.avatars')->withCount('strokeUsers')->first();
        if (!isset($post)) {
            return $this->sendError('Invalid Post', ['error'=>'No Post Exists', 'message' => 'No post exists']);
        }
        $returnData['ncom_posts'] = $posts = Post::where('art_id', $post->art_id)
                                            ->orWhere('title', 'LIKE','%'.$post->title.'%')
                                            ->orWhere('description', 'LIKE','%'.$post->title.'%')
                                            ->with('image', 'user.art.parent', 'user.avatars')
                                            ->orderBy('created_at', 'DESC')->paginate(env('PAGINATE_LENGTH', 15));
        return $this->sendResponse($returnData, 'Post Ncomm');
    }
}
