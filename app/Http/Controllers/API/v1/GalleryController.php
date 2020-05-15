<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Database\QueryException;
use Validator;
use App\Models\Gallery;
use App\Models\Post;
use App\Models\UserFavGallery;

class GalleryController extends BaseController
{
    public function getMyGalleries()
    {
        $user = Auth::guard('api')->user();
        $galleries = Gallery::with('posts.image', 'image')->where('created_by', $user->id)->get();

        return $this->sendResponse($galleries, 'My all galleries');
    }

    public function show($slug)
    {
        $gallery = Gallery::where('slug', $slug)->first();
        if (!isset($gallery)) {
            return $this->sendError('Invalid Gallery', ['error'=>'No Gallery Exists', 'message' => 'No gallery exists']);
        }
        
        $posts = Post::where('gallery_id', $gallery->id)->get();
        return $this->sendResponse($posts, 'Gallery posts');
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
            $input = $request->all();
            $input['user_id'] = $user->id;
            $art = UserFavGallery::create($input);

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Mark into Fave Successfully.');

    }


}
