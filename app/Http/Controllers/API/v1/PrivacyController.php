<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Validator;
use Auth;
use App\Models\Gallery;
use App\Models\User;
use App\Models\PrivacyType;
use App\Models\UserPrivacy;
use App\Models\PrivacyPage;
use App\Models\UserSprvfsIO;
use App\Models\UserIOGallery;
use App\Models\UserFavGallery;

class PrivacyController extends BaseController
{
    public function index()
    {
        $returnData = $gallery_privacy = $other_pages_privacy = [];
        $user = Auth::guard('api')->user();
        $user_galleries = Gallery::with('image', 'privacy')->where('created_by', $user->id)->get();
        $privacy_types = PrivacyType::all();
        $privacy_pages = PrivacyPage::with('privacy')->get();

        $returnData ['user_galleries'] = $user_galleries;
        $returnData ['privacy_types'] = $privacy_types;
        $returnData ['user_other_pages'] = $privacy_pages;
        return $this->sendResponse($returnData, 'User privacies');
        
    }

    public function getFaveList($privacy_type_id, $status)
    {
        $returnData = $user_list_ids = [];
        $my_user = Auth::guard('api')->user();
        if( $privacy_type_id == 3 ) {
            $user_lists = UserSprvfsIO::where([
                ['status',  $status], 
                ['privacy_type_id', $privacy_type_id],
                ['created_to', $my_user->id] 
                ])->get(); 
            foreach($user_lists as $user_list) {
                array_push($user_list_ids, $user_list->created_by);
            }
        }else {
            $user_lists = UserSprvfsIO::where([
                ['status',  $status], 
                ['privacy_type_id', $privacy_type_id],
                ['created_to', $my_user->id] 
                ])->get(); 
            foreach($user_lists as $user_list) {
                array_push($user_list_ids, $user_list->created_by);
            }
        }
        
        $returnData['faves'] = $all_faved_users = User::with('avatars', 'art.parent', 'galleries')->whereIn('id', $user_list_ids)->get();
        return $this->sendResponse($returnData, 'users lists');
        
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
            $to_user = User::with('avatars')->findOrFail($request->user_id);
            $returnData['privacy'] = $this->commonAddUserToPrivacy($request); 
            $emailData = $this->EmailData($request->user_id);
            \Mail::to($to_user->email)->send(new \App\Mail\SprfvsRequestMail($emailData));
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
            $other_user = User::findOrFail($request->user_id);
            $returnData['privacy'] = $this->commonAddUserToPrivacy($request);
            
            $check_gallery_io = UserIOGallery::where([ ['user_id', $request->user_id], ['gallery_id', $request->gallery_id] ])->first();
            if(isset($check_gallery_io)) {
                return $this->sendError('Already Gallery', ['error'=>'Already Gallery Exists', 'message' => 'already gallery exists']);
            }

            $gallery_inviteonly = new UserIOGallery();
            $gallery_inviteonly->gallery_id = $request->gallery_id;
            $gallery_inviteonly->user_id = $request->user_id;
            $gallery_inviteonly->save();
            $emailData = $this->EmailData($request->user_id);
            $emailData['gallery_name'] = $gallery->title;
            \Mail::to($other_user->email)->send(new \App\Mail\InviteOnGalleryMail($emailData));
            $returnData['gallery_invite_only'] = $gallery_inviteonly;
        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Privacy updated');
    }

    public function uninviteUserToInviteOnly(Request $request)
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
            $check_gallery_io = UserIOGallery::where([ ['user_id', $request->user_id], ['gallery_id', $request->gallery_id] ])->first();
            if(!isset($check_gallery_io)) {
                return $this->sendError('Not intvited', ['error'=>'No invited to this gallery', 'message' => 'Please invite to gallery first']);
            }
            $check_gallery_io->delete();

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Privacy updated');
    }

    public function approveSprfvs(Request $request)
    {
        $returnData = $emailData=[];
        $user = Auth::guard('api')->user();
        $validator = Validator::make($request->all(), [
            'privacy_type_id' => 'required',
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        try {
            $other_user = User::findOrFail($request->user_id);
            $privacy_check = UserSprvfsIO::where([
                ['created_to',  $user->id], 
                ['privacy_type_id', $request->privacy_type_id], 
                ['created_by', $request->user_id]
                ])->first();
            if(!isset($privacy_check)) {
                return $this->sendError('No User selected', ['error'=>'No user as sprfvs', 'message' => 'No user as SPRFS']);
            }
            $privacy_check->update(['status' => 1]);

            //add to users fave gallery list
            $galleries = Gallery::where('created_by', $request->user_id)->get();
            foreach($galleries as $gallery) {
                $user_fav_gallery = UserFavGallery::where('gallery_id', $gallery->id)->where('user_id', $request->user_id)->first();
                if (!isset($user_fav_gallery)) {
                    $user->favGalleries()->attach($gallery->id); 
                }
            }
            $returnData['privacy'] = $privacy_check;
            $emailData['to_user'] = $by_user = User::with('avatars')->findOrFail($other_user->id);
            $emailData['by_user'] = $to_user = User::with('avatars')->findOrFail($user->id);
            $emailData['logo'] = env('FRONT_APP_URL', 'https://staging.meuzm.com/').'assets/images/LogoIconGold.png';

            //$emailData = $this->EmailData($user->id);
            \Mail::to($other_user->email)->send(new \App\Mail\SprfvsApprovedMail($emailData));
        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Privacy updated');
        
    }

    public function rejectSprfvs(Request $request)
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
                $privacy_check->delete();

                //add to users fave gallery list
                $galleries = Gallery::where('created_by', $request->user_id)->get();
                foreach($galleries as $gallery) {
                    $user_fav_gallery = UserFavGallery::where('gallery_id', $gallery->id)->where('user_id', $request->user_id)->first();
                    if (!isset($user_fav_gallery)) {
                        $user->favGalleries()->detach($gallery->id); 
                    }
                }
                // /$returnData['privacy'] = $privacy_check;
        
        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Privacy updated');
        
    }

    public function EmailData($other_user_id)
    {
      $returnData = [];
      $returnData['to_user'] = $to_user = User::with('avatars')->findOrFail($other_user_id);
      $returnData['by_user'] = $by_user = User::with('avatars')->findOrFail(Auth::guard('api')->user()->id);
      $returnData['logo'] = env('FRONT_APP_URL', 'https://staging.meuzm.com/').'assets/images/LogoIconGold.png';

      return $returnData;
    }


}
