<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Auth;
use App\Models\Gallery;

class GalleryController extends BaseController
{
    public function getMyGalleries()
    {
        $user = Auth::guard('api')->user();
        $galleries = Gallery::where('created_by', $user->id)->get();

        return $this->sendResponse($galleries, 'My all galleries');
    }

}
