<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Database\QueryException;
use Validator;
use App\Models\Gallery;
use App\Models\Post;
use App\Models\User;
use App\Models\UserFavGallery;

class GalleryController extends BaseController
{
    public function getMyGalleries()
    {
        $user = Auth::guard('api')->user();
        $galleries = Gallery::with('privacy', 'posts.image', 'image')->withCount('posts')->where('created_by', $user->id)->get();

        return $this->sendResponse($galleries, 'My all galleries');
    }

    public function show($slug)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $gallery = Gallery::where('slug', $slug)->first();
        if (!isset($gallery)) {
            return $this->sendError('Invalid Gallery', ['error'=>'No Gallery Exists', 'message' => 'No gallery exists']);
        }
        
        $posts = Post::with('image')->where('gallery_id', $gallery->id)->get();
        $returnData['posts'] = $posts;
        $returnData['has_faved'] = $has_faved = $user->favGalleries()->where('id', $gallery->id)->exists();
        return $this->sendResponse($returnData, 'Gallery posts');
    }

    public function make_fav(Request $request)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $validator = Validator::make($request->all(), [
            'gallery_id' => 'required',
        ]);
   
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        try {
            $user_fav_gallery = UserFavGallery::where('gallery_id', $request->gallery_id)->where('user_id', $user->id)->first();
            if (isset($user_fav_gallery)) {
                return $this->sendError('Already faved Gallery', ['error'=>'Already faved Gallery', 'message' => 'you Already faved this Gallery']);
            }
            
            $user->favGalleries()->attach($request->gallery_id);

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Mark into Fave Successfully.');

    }

    public function make_unfav(Request $request)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $validator = Validator::make($request->all(), [
            'gallery_id' => 'required',
        ]);
   
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        try {
            
            $user_fav_gallery = UserFavGallery::where('gallery_id', $request->gallery_id)->where('user_id', $user->id)->first();
            if (!isset($user_fav_gallery)) {
                return $this->sendError('Invalid Gallery', ['error'=>'No Gallery Exists', 'message' => 'No gallery exists']);
            }
            $user->favGalleries()->detach($request->gallery_id);
            

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Mark into Unfav Successfully.');

    }

    public function recommendedGalleries() 
    {
        $returnData = $user_with_same_arts = [];

        $user = Auth::guard('api')->user();
        try {
            
            $users = User::with(['galleries' => function($query) {
                $query->Has('posts', '>', 0);
                },'galleries.image', 'galleries.posts.image', 'art.parent', 'avatars'])
                    ->Has('galleries.posts', '>', 0)
                    ->where('art_id', $user->art_id)
                    ->where('id', '!=', $user->id)
                    ->get();
    
            if($users->count() == 0) {
                $users = User::with(['galleries' => function($query) {
                    $query->Has('posts', '>', 0);
                    },'galleries.image', 'galleries.posts.image', 'art.parent', 'avatars'])
                        ->Has('galleries.posts', '>', 0)
                        ->where('id', '!=', $user->id)
                        ->get()->random(1);
            }
            foreach ($users as $other_user) {
                $galleries = $other_user->galleries;
                $galery_index = 0;
                foreach ($galleries as $gallery) {
                    $other_user->galleries[$galery_index]['has_faved'] = $has_faved = $user->favGalleries()->where('id', $gallery->id)->exists();
                    $galery_index++;
                }
            }
            

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        
        
        return $this->sendResponse($users, 'All Recommended user galleries');
    }


}
