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
use App\Models\UserSprvfsIO;
use App\Models\UserIOGallery;

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

    public function addUserToSprfvs(Request $request)
    {
        $returnData = [];
        $validator = Validator::make($request->all(), [
            'privacy_type_id' => 'required',
            'user_id' => 'required',
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        try {
            $returnData['privacy'] = $this->commonAddUserToPrivacy($request); 

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Privacy updated');
    }

    public function commonAddUserToPrivacy($request)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();

        if ($request->privacy_type_id == 3) {
            $status = '0';
        }
        else {
            $status = '1';
        }
        $privacy_check = UserSprvfsIO::where([
            ['created_to',  $request->user_id], 
            ['privacy_type_id', $request->privacy_type_id], 
            ['created_by', $user->id]
            ])->first();
        if(isset($privacy_check)) {
            //$privacy_check->update(['privacy_type_id' => $request->privacy_type_id]);
            $returnData = $privacy_check;
        }else {
            $user_privacy = new UserSprvfsIO();
            $user_privacy->privacy_type_id = $request->privacy_type_id;
            $user_privacy->created_by = $user->id;
            $user_privacy->created_to = $request->user_id;
            $user_privacy->status = $status;
            $user_privacy->save();
            $returnData = $user_privacy;
        }

        return $returnData;
    }

    public function addUserToInviteOnly(Request $request)
    {
        $returnData = [];

        $validator = Validator::make($request->all(), [
            'privacy_type_id' => 'required',
            'user_id' => 'required',
            'gallery_id' => 'required'
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        try {
            $gallery = Gallery::find($request->gallery_id);
            if (!isset($gallery)) {
                return $this->sendError('Invalid Gallery', ['error'=>'No Gallery Exists', 'message' => 'No gallery exists']);
            }
            $returnData['privacy'] = $this->commonAddUserToPrivacy($request);
            
            $check_gallery_io = UserIOGallery::where([ ['user_id', $request->user_id], ['gallery_id', $request->gallery_id] ])->first();
            if(isset($check_gallery_io)) {
                return $this->sendError('Already Gallery', ['error'=>'Already Gallery Exists', 'message' => 'already gallery exists']);
            }

            $gallery_inviteonly = new UserIOGallery();
            $gallery_inviteonly->gallery_id = $request->gallery_id;
            $gallery_inviteonly->user_id = $request->user_id;
            $gallery_inviteonly->save();

            $returnData['gallery_invite_only'] = $gallery_inviteonly;

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Privacy updated');
    }

    public function approveSprfvs(Request $request)
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $validator = Validator::make($request->all(), [
            'privacy_type_id' => 'required',
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        try {
                $privacy_check = UserSprvfsIO::where([
                    ['created_to',  $user->id], 
                    ['privacy_type_id', $request->privacy_type_id], 
                    ['created_by', $request->user_id]
                    ])->first();
                if(!isset($privacy_check)) {
                    return $this->sendError('No User selected', ['error'=>'No user as sprfvs', 'message' => 'No user as SPRFS']);
                }
                $privacy_check->update(['status' => 1]);
                $returnData['privacy'] = $privacy_check;
        
        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Privacy updated');
        
    }


}
