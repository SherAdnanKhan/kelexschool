<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Database\QueryException;
use Validator;
use App\Models\Gallery;
use App\Models\Post;
use App\Models\Image;
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

    public function store(Request $request)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'image' => env('IMAGE_TYPE_SIZE', '1000')
        ]);
   
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        
        try {
            $gallery = new Gallery();
            $gallery->title = $request->title;
            $gallery->created_by = $user->id;
            $gallery->save();

            if($request->has('image')) {
                $image_recived = $this->uploadImage($request->image, "galleries/");
                $image = new Image();
                $image->title = $image_recived['image_name'];
                $image->path = $image_recived['image_path'];
                $image->image_type = 'App\Models\Gallery';
                $image->image_id = $gallery->id;
                $image->created_by = $user->id;
                $image->save();
                
                //update gallery
                $returnData['gallery'] = $gallery = Gallery::with('image')->find($gallery->id);
               
            }

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Gallery Created');
        
    }

    public function show($slug)
    {
        $returnData = $faved_user_ids = [];
        $user = Auth::guard('api')->user();
        $gallery = Gallery::where('slug', $slug)->first();
        if (!isset($gallery)) {
            return $this->sendError('Invalid Gallery', ['error'=>'No Gallery Exists', 'message' => 'No gallery exists']);
        }
        $posts = Post::with('image', 'comments.user.avatars', 'has_stroke', 'user.avatars')->withCount('strokeUsers')->where('gallery_id', $gallery->id)->get();
        $faved_users = UserFavGallery::where('gallery_id', $gallery->id)->get();
        foreach($faved_users as $faved_user) {
            array_push($faved_user_ids, $faved_user->user_id);            
        }
        $gallery_faved_users = User::with('avatars')->whereIn('id', $faved_user_ids)->get();
        $returnData['posts'] = $posts;
        $returnData['has_faved'] = $has_faved = $user->favGalleries()->where('id', $gallery->id)->exists();
        $returnData['faved_users'] = $gallery_faved_users;

        return $this->sendResponse($returnData, 'Gallery posts');
    }

    public function update($gallery_id, Request $request)
    {   
        $returnData = [];
        $user = Auth::guard('api')->user();
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'image' => env('IMAGE_TYPE_SIZE', '1000')
        ]);
   
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        
        try {
            $gallery = Gallery::with('image')->find($gallery_id);
            if (!isset($gallery)) {
                return $this->sendError('Invalid Gallery', ['error'=>'No Gallery Exists', 'message' => 'No gallery exists']);
            }
            if ($gallery->created_by != $user->id) {
                return $this->sendError('Unauthorized Gallery', ['error'=>'Unauthorized Gallery', 'message' => 'Yoh have no rights to update this gallery']);
            }
            $gallery->title = $request->title;
            $gallery->update();
            if($request->has('image')) {
                if(isset($gallery->image)) {
                    $image = Image::where([ ['image_type', 'App\Models\Gallery'], ['image_id', $gallery->id] ])->first();
                    $image_recived = $this->uploadImage($request->image, "galleries/");
                    $image->title = $image_recived['image_name'];
                    $image->path = $image_recived['image_path'];
                    $image->update();
                }else {
                    //return "No Image";
                    $image_recived = $this->uploadImage($request->image, "galleries/");
                    $image = new Image();
                    $image->title = $image_recived['image_name'];
                    $image->path = $image_recived['image_path'];
                    $image->image_type = 'App\Models\Gallery';
                    $image->image_id = $gallery->id;
                    $image->created_by = $user->id;
                    $image->save();
                }
            }
            //update gallery
            $returnData['gallery'] = $gallery = Gallery::with('image')->find($gallery_id);

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Gallery Update');
        
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
            
            $users = User::with([
                    'galleries' => function($query) {
                        $query->Has('posts', '>', 0);
                    },
                    'galleries.image', 
                    'galleries.posts' => function($query) {
                        $query->where('post_type', '!=', 2);
                    },
                    'galleries.posts.image', 'art.parent', 'avatars'])
                    ->Has('galleries.posts', '>', 0)
                    ->where('art_id', $user->art_id)
                    ->where('id', '!=', $user->id)
                    ->get();
    
            if($users->count() == 0) {
                $users = User::with([
                        'galleries' => function($query) {
                        $query->Has('posts', '>', 0);
                        },
                        'galleries.image',
                        'galleries.posts' => function($query) {
                            $query->where('post_type', '!=', 2);
                        },
                        'galleries.posts.image', 'art.parent', 'avatars'])
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

    public function deleteImage($gallery_id)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $gallery = Gallery::with('image')->find($gallery_id);
        if (!isset($gallery)) {
            return $this->sendError('Invalid Gallery', ['error'=>'No Gallery Exists', 'message' => 'No gallery exists']);
        }
        if ($gallery->created_by != $user->id) {
            return $this->sendError('Unauthorized Gallery', ['error'=>'Unauthorized Gallery', 'message' => 'Yoh have no rights to update this gallery']);
        }
        if(isset($gallery->image)) {
            $image = Image::where([ ['image_type', 'App\Models\Gallery'], ['image_id', $gallery->id] ])->first();
            $image->delete();
        }
        $returnData['gallery'] = $gallery = Gallery::with('image')->find($gallery_id);
        return $this->sendResponse($returnData, 'Gallery Image Removed');
    }

    public function favedUsers(Request $request)
    {
        $returnData = [];
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $user_fav_galleries = User::with('favGalleries.image', 'favGalleries.user.avatars')->find($request->user_id);
        if (!isset($user_fav_galleries)) {
            return $this->sendError('Not a user', ['error'=>'Not a user', 'message' => 'not a user']);
        }

        $returnData['user_faved_galleries'] = $user_fav_galleries;
        return $this->sendResponse($returnData, 'User all faved galleries');

    }


}
