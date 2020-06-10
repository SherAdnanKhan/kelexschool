<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Validator;
use Auth;
use App\Models\Gallery;
use App\Models\PrivacyType;
use App\Models\UserPrivacy;
use App\Models\PrivacyPage;

class PrivacyController extends BaseController
{
    public function index()
    {
        $returnData = $gallery_privacy = $other_pages_privacy = [];
        $user = Auth::guard('api')->user();
        $user_galleries = Gallery::with('privacy')->where('created_by', $user->id)->get();
        $privacy_types = PrivacyType::all();
        $privacy_pages = PrivacyPage::with('privacy')->get();
        // foreach( $user_galleries as $user_gallery) {
        //     $gallery = [];
        //     $gallery_select = $user_gallery;
        //     $selected_privacy = UserPrivacy::where('privacy_type', 'App\Models\Gallery')->where('privacy_id', $user_gallery->id)->get();
        //     if (isset($selected_privacy)) {
        //         $gallery_select['selected_privacy'] = null;
        //     } 
        //     else {
        //         $gallery_select['selected_privacy'] = $selected_privacy->privacy_type_id;
        //     }

        //     array_push($gallery_privacy, $gallery_select);
            
        // }
        $returnData ['user_galleries'] = $user_galleries;
        $returnData ['privacy_types'] = $privacy_types;
        $returnData ['user_other_pages'] = $privacy_pages;
        return $this->sendResponse($returnData, 'User privacies');

        //dd($user_galleries);

        
    }
}
