<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Validator;
use Auth;
use App\Models\Feed;
use App\Models\FeedComment;
use App\Models\Image;
use App\Models\User;

class MzFlashController extends BaseController
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

        $feeds = Feed::with('user.avatars', 'image', 'parent.user.avatars', 'limited_comments.user.avatars')
                ->withCount('comments', 'strokeUsers', 'has_stroke')
                ->where('created_by', $user->id)
                ->paginate(env('PAGINATE_LENGTH', 15));
        $returnData['feeds'] = $feeds;
        return $this->sendResponse($returnData, 'All feeds');

    }

    public function otherFeed($slug)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $other_user = User::where('slug', $slug)->first();
        if(!isset($other_user)) {
            return $this->sendError('Invalid User', ['error'=>'No User Exists', 'message' => 'No user exists']);
        }
        $feeds = Feed::with('user.avatars', 'image', 'parent.user.avatars', 'limited_comments.user.avatars')
                ->withCount('comments', 'strokeUsers', 'has_stroke')
                ->where('created_by', $other_user->id)
                ->paginate(env('PAGINATE_LENGTH', 15));
        $returnData['feeds'] = $feeds;
        return $this->sendResponse($returnData, 'All feeds');
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
        $image = null;

        $validator = Validator::make($request->all(), [
            'feed' => 'max:200',
            'image' => env('IMAGE_TYPE_SIZE', '1000'),
            'video' => env('DOCUMENT_SIZE', '2000'),
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        try {
            if (isset($request->feed_id)) {
                $isFeed = Feed::find($request->feed_id);
                if(!isset($isFeed)) {
                    return $this->sendError('Invalid Feed', ['error'=>'Unauthorised Feed', 'message' => 'Please add correct feed']);
                }
            }
            $feedtype = 0;
            if($request->has('image')) {
                $feedtype  = 1;
            }
            else if ($request->has('video')) {
                $feedtype  = 2;
            }
            $feed = new Feed;
            $feed->feed = $request->feed;
            $feed->parent_id = $request->feed_id ? $request->feed_id : null;
            $feed->feed_type = $feedtype;
            $feed->feel_color = $user->feel_color;
            $feed->created_by = $user->id;
            $feed->save(); 

            if($request->has('image') || $request->has('video')) {
                if ($request->has('image')) {
                    $image_recived = $this->uploadImage($request->image, "feeds/");
                }

                if ($request->has('video')) {
                    $image_recived = $this->uploadImage($request->video, "feeds/");
                }
                
                $image = new Image();
                $image->title = $image_recived['image_name'];
                $image->path = $image_recived['image_path'];
                $image->image_type = 'App\Models\Feed';
                $image->image_id = $feed->id;
                $image->created_by = $user->id;
                $image->save();
            }
            $new_feed = Feed::with('user.avatars', 'image', 'parent.user.avatars', 'limited_comments.user.avatars')->withCount('comments', 'strokeUsers', 'has_stroke')->find($feed->id);
            $returnData['feed'] = $new_feed;
            //$returnData['feed']['image'] = $image;

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Feed Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function favesFeeds(Request $request)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $faved_users_ids = $this->UserFavesIds($user->id);
        $feeds = Feed::with('user.avatars', 'image', 'parent.user.avatars', 'limited_comments.user.avatars')
                ->withCount('comments', 'strokeUsers', 'has_stroke')
                ->whereIn('created_by', $faved_users_ids)
                ->orderBy('created_at', 'DESC')
                ->paginate(env('PAGINATE_LENGTH', 15));
        
        $returnData['user_faves_feeds'] = $feeds;
        return $this->sendResponse($returnData, 'User Faves Feed List');
    }

    public function collectiveFeeds(Request $request)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $faved_users_ids = $this->UserFavesIds($user->id);
        array_push($faved_users_ids, $user->id);
        $feeds = Feed::with('user.avatars', 'image', 'parent.user.avatars', 'limited_comments.user.avatars')
                ->withCount('comments', 'strokeUsers', 'has_stroke')
                ->whereIn('created_by', $faved_users_ids)
                ->orderBy('created_at', 'DESC')
                ->paginate(env('PAGINATE_LENGTH', 15));
        
        $returnData['user_faves_feeds'] = $feeds;
        return $this->sendResponse($returnData, 'User Collective Faves Feed List');
    }

    public function sprfvsFeeds(Request $request)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $faved_users_ids = $this->UserSprfvsIds($user->id);
        $feeds = Feed::with('user.avatars', 'image', 'parent.user.avatars', 'limited_comments.user.avatars')
                ->withCount('comments', 'strokeUsers', 'has_stroke')
                ->whereIn('created_by', $faved_users_ids)
                ->orderBy('created_at', 'DESC')
                ->paginate(env('PAGINATE_LENGTH', 15));
        
        $returnData['user_faves_feeds'] = $feeds;
        return $this->sendResponse($returnData, 'User SPRFVs Feed List');
    }

    public function faveSprfvsFeeds(Request $request)
    {
        $returnData = $collective_users_ids = [];
        $user = Auth::guard('api')->user();
        $faved_users_ids = $this->UserFavesIds($user->id);
        $collective_users_ids = $sprfvs_users_ids = $this->UserSprfvsIds($user->id);
        foreach($faved_users_ids as $faved_user_id) {
          if(array_key_exists($faved_user_id, $collective_users_ids)) {
            array_push($collective_users_ids, $faved_user_id);
          }
        } 
        $feeds = Feed::with('user.avatars', 'image', 'parent.user.avatars', 'limited_comments.user.avatars')
                ->withCount('comments', 'strokeUsers', 'has_stroke')
                ->whereIn('created_by', $collective_users_ids)
                ->orderBy('created_at', 'DESC')
                ->paginate(env('PAGINATE_LENGTH', 15));
        $returnData['user_faves_feeds'] = $feeds;
        return $this->sendResponse($returnData, 'User faves and SPRFVs Feed List');
		}
		
		public function faveSprfvsUsers(Request $request)
		{
        $returnData = $collective_users_ids = [];
        $user = Auth::guard('api')->user();
        $faved_users_ids = $this->UserFavesIds($user->id);
        $collective_users_ids = $sprfvs_users_ids = $this->UserSprfvsIds($user->id);
        foreach($faved_users_ids as $faved_user_id) {
            if(array_key_exists($faved_user_id, $collective_users_ids)) {
            array_push($collective_users_ids, $faved_user_id);
            }
        }
        $returnData['faves'] = $all_faved_users = User::with('avatars', 'art.parent')->whereIn('id', $collective_users_ids)->get();
        return $this->sendResponse($returnData, 'User faves and SPRFVs List');
		}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($feed_id, Request $request)
    {
      $returnData = [];
      $returnData['feed'] = $feed = Feed::with('user.avatars', 'image', 'parent.user.avatars')->withCount('comments', 'strokeUsers', 'has_stroke')->find($feed_id);
      if(!isset($feed)) {
        return $this->sendError('Invalid Feed', ['error'=>'Unauthorised Feed', 'message' => 'Please add correct feed']);
      }
      $returnData['comments'] = $comments = FeedComment::with('user.avatars')->where('feed_id', $feed_id)->orderBy('created_at', 'DESC')->paginate(env('PAGINATE_LENGTH', 15));
      return $this->sendResponse($returnData, 'Feed with comment');
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

    public function commentStore(Request $request)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();

        $validator = Validator::make($request->all(), [
            'comment' => 'required|max:200',
            'feed_id' => 'required'
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        try {
            $feed = Feed::find($request->feed_id);
            if (!isset($feed)) {
                return $this->sendError('Invalid Feed', ['error'=>'No Feed Exists', 'message' => 'No feed exists']);
            }
            $feed_comment = new FeedComment;
            $feed_comment->comment = $request->comment;
            $feed_comment->created_by = $user->id;
            $feed_comment->feed_id = $request->feed_id;
            $feed_comment->save(); 

            $new_feed_comment = FeedComment::with('user.avatars')->find($feed_comment->id);
            $returnData['feed_comment'] = $new_feed_comment;

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Feed Comment Added');
        
    }
    public function makeStroke(Request $request)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $validator = Validator::make($request->all(), [
            'feed_id' => 'required',
        ]);
   
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        try {
            $hasStroke = $user->strokeFeeds()->where('id', $request->feed_id)->exists();
            if ($hasStroke) {
                return $this->sendError('Already Stoke Feed', ['error'=>'Already Stroke Feed', 'message' => 'You already stroke this feed']);
            }
            
            $user->strokeFeeds()->attach($request->feed_id);

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
            'feed_id' => 'required',
        ]);
   
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        try {
            $hasStroke = $user->strokeFeeds()->where('id', $request->feed_id)->exists();
            if (!$hasStroke) {
                return $this->sendError('None Stoke Feed', ['error'=>'None Stroke Feed', 'message' => 'You didn\'t stroke this feed before']);
            }
            
            $user->strokeFeeds()->detach($request->feed_id);

        }catch(QueryException $ex) {
            return $this->sendError('Query Exception Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Mark UnStroke Successfully.');
    }
}
