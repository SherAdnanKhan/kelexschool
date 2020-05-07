<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use Auth;
use App\Models\Image;

class StudioController extends BaseController
{
    public function getMyStudio()
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $avatar = Image::where('image_type', 'App\Models\User')->where('created_by', $user->id)->get();
        $returnData['user'] = $user;
        $returnData['avatars'] = $avatar;
        //implement after favs module
        $returnData['favs_count'] = 0;
        $returnData['favs_by_count'] = 0;
        return $this->sendResponse($returnData, 'My studio');
    }
}
