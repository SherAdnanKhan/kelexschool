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

        $returnData ['user_galleries'] = $user_galleries;
        $returnData ['privacy_types'] = $privacy_types;
        $returnData ['user_other_pages'] = $privacy_pages;
        return $this->sendResponse($returnData, 'User privacies');
        
    }

    public function store(Request $request)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();

        $validator = Validator::make($request->all(), [
            'privacy_type_id' => 'required',
            'privacy_type' => 'required',
            'privacy_id' => 'required'

        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        try {
            if ($request->privacy_type == 'gallery') {
                $privacy_type = 'App\Models\Gallery';
            }
            else {
                $privacy_type = 'App\Models\PrivacyPage';
            }
            $privacy_check = UserPrivacy::where([
                ['user_id',  $user->id], 
                ['privacy_type', $privacy_type], 
                ['privacy_id', $request->privacy_id]
                ])->first();
            if(isset($privacy_check)) {
                $privacy_check->update(['privacy_type_id' => $request->privacy_type_id]);
                $returnData['privacy'] = $privacy_check;
            }else {
                $user_privacy = new UserPrivacy();
                $user_privacy->privacy_type_id = $request->privacy_type_id;
                $user_privacy->user_id = $user->id;
                $user_privacy->privacy_id = $request->privacy_id;
                $user_privacy->privacy_type = $privacy_type;
                $user_privacy->save();
                $returnData['privacy'] = $user_privacy;
            }

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Privacy updated');
    }
}
