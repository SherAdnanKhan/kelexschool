<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Auth;
use App\Models\Gallery;
use App\Models\Post;

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

}
