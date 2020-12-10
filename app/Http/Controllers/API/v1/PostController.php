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
use App\Models\Conversation;
use App\Models\Message;
use App\Models\MessageLog;
use App\Models\User;
use App\Models\Feed;
use App\Models\UserFavGallery;
use App\Models\Notification;

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
        $returnData = $faved_user_slugs = [];
        $user = Auth::guard('api')->user();
        $post_type = 0;

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'gallery_id' => 'required',
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        try {
            $gallery = Gallery::findOrFail($request->gallery_id);
            if ($gallery->created_by != $user->id) {
                return $this->sendError('Invalid Gallery', ['error'=>'Unauthorised Gallery', 'message' => 'Please post into your gallery']);
            }
            
            if($request->doc_type == "image") {
                $post_type  = 1;
            }
            else if ($request->doc_type == "video") {
                $post_type  = 2;
            }

            $post = new Post;
            $post->title = $request->title;
            $post->gallery_id = $request->gallery_id;
            $post->art_id = $request->art_id ? $request->art_id : null;
            $post->description = $request->description ? $request->description : null;
            $post->created_by = $user->id;
            $post->post_type = $post_type;
            $post->save(); 
            $gallery->touch();

            if($request->has('doc_type')) {

                $image = new Image();
                $image->title = $request->doc_name;;
                $image->path = $request->doc_path;;
                $image->image_type = 'App\Models\Post';
                $image->image_id = $post->id;
                $image->created_by = $user->id;
                $image->save();
            }

            $returnData['post'] = $post;
            $returnData['post']['image'] = $image;

            //fave gallery users
            $faved_users = UserFavGallery::with('user')->where('gallery_id', $gallery->id)->get();
            foreach($faved_users as $faved_user) {
                //check if user is muted
                $is_muted = $this->CheckUserMute($faved_user->user->id, $user->id);
                if($is_muted == false) {
                    array_push($faved_user_slugs, $faved_user->user->slug);
                }  
            }

            $returnData['faved_users_slug'] = $faved_user_slugs;

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
            if (!$hasStroke) {
                //return $this->sendError('Already Stoke Post', ['error'=>'Already Stroke Post', 'message' => 'You already stroke this post']);
                $user->strokePosts()->attach($request->post_id);
            }
            
            //$user->strokePosts()->attach($request->post_id);

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
    
        $is_sprfvs = $is_vault = 0;
        $post = Post::where('slug', $slug)->with('image', 'art.parent', 'user.art.parent', 'user.avatars', 'user.feel')->withCount('strokeUsers', 'comments')->first();
        if (!isset($post)) {
            return $this->sendError('Invalid Post', ['error'=>'No Post Exists', 'message' => 'No post exists']);
        }
        $returnData['post'] = $post;
        
        $other_posts = Post::with('image', 'user.art.parent', 'user.avatars', 'user.feel')->where([ ['gallery_id', '=', $post->gallery_id], ['id', '!=', $post->id] ])->get();
        $returnData['other_posts'] = $other_posts;
        //if auth exsists
        if (isset($my_user)) {
            $returnData['has_stroke'] = $hasStroke = $my_user->strokePosts()->where('id', $post->id)->exists();
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
            $is_vault = $post->is_vault()->count();
            $returnData['is_sprfvs'] = $is_sprfvs;
            $returnData['is_vault'] = $is_vault;
            
            //crtiques page
            $returnData['other_privacy'] = $other_privacy = $this->CheckPrivacyPage($is_sprfvs, $my_user->id, $post->user->id, 3);
        }
        
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
        
        $user = Auth::guard('api')->user();
        $returnData = $image = [];

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'gallery_id' => 'required'
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $post = Post::with('image')->find($id);
        $post_type = $post->post_type;
        if (!isset($post)) {
            return $this->sendError('Invalid Post', ['error'=>'No Post Exists', 'message' => 'No post exists']);
        }
        if($post->created_by != $user->id) {
            return $this->sendError('Unauthorized Post', ['error'=>'Unauthorized post', 'message' => 'This post is unauthorized to you']);
        }

        try {
            $gallery = Gallery::findOrFail($request->gallery_id);
            if ($gallery->created_by != $user->id) {
                return $this->sendError('Invalid Gallery', ['error'=>'Unauthorised Gallery', 'message' => 'Please post into your gallery']);
            }

            if($request->doc_type == "image") {
                $post_type  = 1;
            }
            else if ($request->doc_type == "video") {
                $post_type  = 2;
            }
            $post->title = $request->title;
            $post->gallery_id = $request->gallery_id;
            $post->art_id = $request->art_id ? $request->art_id : null;
            $post->description = $request->description ? $request->description : null;
            $post->post_type = $post_type;
            $post->update(); 

            if($request->has('doc_type')) {
                $old_image = Image::where('image_type', 'App\Models\Post')->where('image_id', $post->id)->delete(); 
                $image = new Image();
                $image->title = $request->doc_name;
                $image->path = $request->doc_path;
                $image->image_type = 'App\Models\Post';
                $image->image_id = $post->id;
                $image->created_by = $user->id;
                $image->save();
            }

            $postupdated = Post::with('image')->find($id);
            $returnData['post'] = $postupdated;

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Exhibit Added');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $my_user = Auth::guard('api')->user();

        $post = Post::findOrFail($id);
        if (!isset($post)) {
            return $this->sendError('Invalid Post', ['error'=>'No Post Exists', 'message' => 'No post exists']);
        }

        if($post->created_by != $my_user->id) {
            return $this->sendError('Unauthorized Post', ['error'=>'Unauthorized post', 'message' => 'This post is unauthorized to you']);
        }
        $post->delete();
        return $this->sendResponse([], 'Post Deleted Sucessfully');
    }

    public function ncomm($slug, Request $request)
    {
        $returnData = [];
        $post = Post::where('slug', $slug)->with('image', 'user.art.parent', 'user.avatars', 'user.feel')->withCount('strokeUsers')->first();
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

    public function share($id, Request $request)
    {
        $user = Auth::guard('api')->user();
        $returnData = [];
        $post = Post::with('image')->find($id);
        if (!isset($post)) {
            return $this->sendError('Invalid Post', ['error'=>'No Post Exists', 'message' => 'No post exists']);
        }
        //share post on chat as a message
        if($request->has('send_to')) {
            $conversation_all_ids = $userIds = [];
            $user = Auth::guard('api')->user();
            $coverations_all = Conversation::withCount('participants')->whereHas('participants', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get('id');
            foreach ($coverations_all as $coveration) {
                if($coveration->participants_count == 2) {
                    array_push($conversation_all_ids, $coveration->id);
                }
            }

            $hasConversation = Conversation::with('participants.avatars', 'participants.feel')->whereHas('participants', function($query) use ($request) {
                $query->where('user_id', $request->send_to);
            })->whereIn('id', $conversation_all_ids)->first();
            
            if (!$hasConversation) {
                $conversation = Conversation::create(['name', 'room_com']);
                $conversation->participants()->attach([$user->id, $request->send_to]);
                $hasConversation = Conversation::with('participants.avatars', 'participants.feel')->find($conversation->id);
            }
            $url = env('FRONT_APP_URL', 'https://staging.meuzm.com/')."dashboard/viewpost/".$post->slug;

            $message = new Message;
            $message->message = $url;
            $message->conversation_id = $hasConversation->id;
            $message->feel_id = $user->feel_id;
            $message->created_by = $user->id;
            $message->type = 0;
            $message->url = null; 
            $message->save();

            $hasConversation->touch();
            foreach($hasConversation->participants as $participant) {
                if($participant->id != $user->id) {
                    $participant_user = User::find($participant->id);
                    $message_log = new MessageLog;
                    $message_log->conversation_id = $hasConversation->id;
                    $message_log->message_id = $message->id;
                    $message_log->user_id = $participant->id;
                    $message_log->feel_id = $participant_user->feel_id;
                    $message_log->save();
                }
            }
            //return $url;
        }
        // $post->increment('shares');
        // $post->update();


        $this->NotificationStore('App\Models\Post', $post->id, 'Post shared', $user->id);

        return $this->sendResponse($returnData, 'Post shared');
    }

    public function report($id)
    {
        $user = Auth::guard('api')->user();
        $returnData = [];
        $post = Post::with('image')->find($id);
        if (!isset($post)) {
            return $this->sendError('Invalid Post', ['error'=>'No Post Exists', 'message' => 'No post exists']);
        }
        $post->increment('reports');
        $post->update();

        $this->NotificationStore('App\Models\Post', $post->id, 'Post report', $user->id);

        return $this->sendResponse($returnData, 'Post report');
    }

    public function critiqueStatus($id, Request $request)
    {
        $user = Auth::guard('api')->user();
        $returnData = [];
        $post = Post::with('image')->find($id);
        if (!isset($post)) {
            return $this->sendError('Invalid Post', ['error'=>'No Post Exists', 'message' => 'No post exists']);
        }
        if($post->created_by != $user->id) {
            return $this->sendError('Unauthorized Post', ['error'=>'Unauthorized post', 'message' => 'This post is unauthorized to you']);
        }

        $validator = Validator::make($request->all(), [
            'critiques_status' => 'required',
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $post->critiques_status = $request->critiques_status;
        $post->update();

        $returnData['post'] = Post::with('image')->find($id);
        return $this->sendResponse($returnData, 'Post Crtiquies status update');
    }

    public function repost(Request $request)
    {
        $returnData = $image = [];
        $user = Auth::guard('api')->user();

        $validator = Validator::make($request->all(), [
            'gallery_id' => 'required',
            'post_id' => 'required',
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        try {
            $gallery = Gallery::findOrFail($request->gallery_id);
            if ($gallery->created_by != $user->id) {
                return $this->sendError('Invalid Gallery', ['error'=>'Unauthorised Gallery', 'message' => 'Please post into your gallery']);
            }
            $post = Post::with('image')->find($request->post_id);
            if (!isset($post)) {
                return $this->sendError('Invalid Post', ['error'=>'No Post Exists', 'message' => 'No post exists']);
            }
            $post_new = new Post;
            $post_new->title = $post->title;
            $post_new->gallery_id = $request->gallery_id;
            $post_new->art_id = $post->art_id;
            $post_new->description = $post->description;
            $post_new->created_by = $user->id;
            $post_new->parent_id = $post->id;
            $post_new->post_type = $post->post_type;
            $post_new->save(); 
            //return $post;

            if(isset($post->image) && !empty($post->image)) {
                $image = new Image();
                $image->title = $post->image->title;
                $image->path = $post->image->path;
                $image->image_type = 'App\Models\Post';
                $image->image_id = $post_new->id;
                $image->created_by = $user->id;
                $image->save();
            }

            $returnData['post'] = $post_new;
            $returnData['post']['image'] = $image;

            //generate notification
            $notification = new Notification();
            $notification->type = 'REPOST EXHIBIT';
            $notification->notifyable_type = 'App\Models\Post';
            $notification->notifyable_id = $post_new->id;
            $notification->sender_id = $user->id;
            $notification->receiver_id = $post->created_by;
            $notification->save();



        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Exhibit Reposted');
    }

    public function toMzflash(Request $request)
    {
        $returnData = $image = [];
        $user = Auth::guard('api')->user();

        $validator = Validator::make($request->all(), [
            'post_id' => 'required',
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        try {
            $post = Post::with('image')->find($request->post_id);
            if (!isset($post)) {
                return $this->sendError('Invalid Post', ['error'=>'No Post Exists', 'message' => 'No post exists']);
            }
            
            $feed = new Feed;
            $feed->feed = $post->title." ".$post->description;
            $feed->parent_id = null;
            $feed->feed_type = $post->post_type;
            $feed->feel_id = $user->feel_id;
            $feed->created_by = $user->id;
            $feed->save(); 

            if(isset($post->image) && !empty($post->image)) {
                $image = new Image();
                $image->title = $post->image->title;
                $image->path = $post->image->path;
                $image->image_type = 'App\Models\Feed';
                $image->image_id = $feed->id;
                $image->created_by = $user->id;
                $image->save();
            }

            $returnData['feed'] = $feed;

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Exhibit Reposted to Feed');
    }
}
