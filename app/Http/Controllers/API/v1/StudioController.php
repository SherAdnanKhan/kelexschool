<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Validator;
use Auth;
use App\Models\Image;
use App\Models\User;
use App\Models\UserPrivacy;
use App\Models\UserFavGallery;
use App\Models\UserSprvfsIO;
use App\Models\PrivacyPage;
use App\Models\UserIOGallery;
use App\Models\Fav;
use App\Models\Gallery;
use App\Models\UserBlock;

class StudioController extends BaseController
{
    public function getMyStudio() 
    {
        $returnData = [];
        $auth_user = Auth::guard('api')->user();
        $user = User::with('avatars', 'feel', 'art.parent')->withCount('posts')->find($auth_user->id);
        $returnData['user'] = $user;
        $fav_by_count = Fav::where('faved_to', $user->id)->get()->count();
        $fav_to_count = Fav::where('faved_by', $user->id)->get()->count();
        $returnData['fav_by_count'] = $fav_by_count;
        $returnData['favs_count'] = $fav_to_count;
        
        return $this->sendResponse($returnData, 'My studio');
    }

    public function updateMyCubicImage(Request $request) 
    {
        $returnData = [];
        $user = Auth::guard('api')->user();
        $validator = Validator::make($request->all(), [
            'avatar' => "required|max:".env('IMAGE_TYPE_SIZE','1000').""
        ]);
   
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        try {
                if($request->has('image_id')) {
                    $image = Image::find($request->image_id);
                    $image_recived = $this->uploadImage($request->avatar, "artists/");
                    // $returnData['image'] = $image_recived;
                    $image->title = $image_recived['image_name'];
                    $image->path = $image_recived['image_path'];
                    $image->updated_by  = $user->id;
                    $image->update();

                }else {
                    $image_recived = $this->uploadImage($request->avatar, "artists/");
                    // $returnData['image'] = $image_recived;
                    $image = new Image();
                    $image->title = $image_recived['image_name'];
                    $image->path = $image_recived['image_path'];
                    $image->image_type = 'App\Models\User';
                    $image->image_id = $user->id;
                    $image->created_by = $user->id;
                    $image->updated_by  = $user->id;
                    $image->deleted_by = $user->id;
                    $image->save();
                }

                $avatar = Image::where('image_type', 'App\Models\User')->where('created_by', $user->id)->get();
                $returnData['avatars'] = $avatar; 
                
        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Studio Updated');

    }

    public function deleteMyCubicImage($id)
    {
        try {
            $user = Auth::guard('api')->user();
            $image = Image::where('id', $id)->where('image_type', 'App\Models\User')->first();
            if (!isset($image)) {
                return $this->sendError('Invalid Image Id', ['error'=>'No Image Exists', 'message' => 'No image exists']);
            }else {
                if ($image->created_by != $user->id) {
                    return $this->sendError('Invalid Image Id', ['error'=>'Unauthorized Image', 'message' => 'No image exists']);
                }
            }

            $image->delete();

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse([], 'Avatar image deleted');
    }

    public function getUserStudio($slug)
    {
        $returnData = $gallery_privacy = $other_privacy = $gallery_invites_only = [];
        $is_allowed = $is_sprfvs = 0;
        $my_user = Auth::guard('api')->user();
        $user = User::with('avatars', 'feel', 'galleries.image', 'galleries.privacy', 'galleries.posts.image' ,'art.parent')->withCount('posts')->where('slug', $slug)->first();
        if (!isset($user)) {
            return $this->sendError('Invalid User', ['error'=>'No User Exists', 'message' => 'No user exists']);
        }
        $returnData['user'] = $user;
        $fav_by_count = Fav::where('faved_to', $user->id)->get()->count();
        $fav_to_count = Fav::where('faved_by', $user->id)->get()->count();
        $returnData['fav_by_count'] = $fav_by_count;
        $returnData['favs_count'] = $fav_to_count;
        $returnData['has_faved'] = $has_faved = Fav::where([ ['faved_by', $my_user->id], ['faved_to', $user->id] ])->exists();

        //is_blocked user
        $returnData['is_blocked'] = $this->CheckUserBlocked($my_user->id, $user->id);
        $returnData['is_viewable'] = $this->CheckUserViewable($my_user->id, $user->id);
        $returnData['is_muted'] = $this->CheckUserMute($my_user->id, $user->id);

        //privacy settings of user
        $user_privacy_settings = UserPrivacy::where('user_id', $user->id)->get();
        
        //Check if sprfvs already 
        $check_user_sprfvs = UserSprvfsIO::where([
            ['created_to',  $user->id], 
            ['privacy_type_id', 3], 
            ['created_by', $my_user->id]
            ])->first();
        if(isset($check_user_sprfvs)) {
            if($check_user_sprfvs->status == 1) {
                $is_sprfvs = 1;
            }
            else {
                $is_sprfvs = 2;
            }
        }

        //count of user sprfvs
        $count_user_sprfvs = UserSprvfsIO::where([
            ['created_to',  $user->id], 
            ['privacy_type_id', 3], 
            ['status', 1]
            ])->get()->count();
        $returnData['sprfvs_count'] =  $count_user_sprfvs;
        $returnData['is_sprfvs'] = $is_sprfvs;

        //Gallery privacy allowed user 
        foreach($user->galleries as $user_gallery) {
            $is_allowed = 0;
            if(!isset($user_gallery->privacy) || $user_gallery->privacy == null) {
                array_push($gallery_privacy, [
                    'gallery_id' => $user_gallery->id,
                    'is_allowed' => 1
                ]);
            }else {
                if ($user_gallery->privacy->privacy_type_id == 1) {
                    array_push($gallery_privacy, [
                        'gallery_id' => $user_gallery->id,
                        'is_allowed' => 1
                    ]);
                }
                else if ($user_gallery->privacy->privacy_type_id == 2) {
                    $user_fav_gallery = UserFavGallery::where('gallery_id', $user_gallery->id)->where('user_id', $my_user->id)->first();
                    if (isset($user_fav_gallery)) {
                        array_push($gallery_privacy, [
                            'gallery_id' => $user_gallery->id,
                            'is_allowed' => 1
                        ]);
                    }
                    else {
                        array_push($gallery_privacy, [
                            'gallery_id' => $user_gallery->id,
                            'is_allowed' => 0
                        ]);
                    }
                }
                else if ($user_gallery->privacy->privacy_type_id == 3 ) {
                    if ($is_sprfvs == 1) {
                        array_push($gallery_privacy, [
                            'gallery_id' => $user_gallery->id,
                            'is_allowed' => 1
                        ]);
                    }else {
                        array_push($gallery_privacy, [
                            'gallery_id' => $user_gallery->id,
                            'is_allowed' => 0
                        ]);
                    }
                    
                }
                else if ($user_gallery->privacy->privacy_type_id == 4) {
                    $user_invite_only = UserIOGallery::where([ ['user_id', $my_user->id], ['gallery_id', $user_gallery->id] ])->first();
                        if (isset($user_invite_only)) {
                            array_push($gallery_privacy, [
                                'gallery_id' => $user_gallery->id,
                                'is_allowed' => 1
                            ]);
                        }
                        else {
                            array_push($gallery_privacy, [
                                'gallery_id' => $user_gallery->id,
                                'is_allowed' => 0
                            ]);
                        }
                }
                else {
                    array_push($gallery_privacy, [
                        'gallery_id' => $user_gallery->id,
                        'is_allowed' => 0
                    ]);
                }
                
            }

        }
        $returnData['gallery_privacy'] = $gallery_privacy;

        //other privacy
        $other_pages = PrivacyPage::all();
        foreach($other_pages as $other_page) {
            $user_page_privacy = UserPrivacy::where([ ['user_id', $user->id], ['privacy_type', 'App\Models\PrivacyPage'], ['privacy_id', $other_page->id] ])->first();

            if(!isset($user_page_privacy)) {
                array_push($other_privacy, [
                    'privacy_page' => $other_page->name,
                    'is_allowed' => 1
                ]);
            }else {
                if ($user_page_privacy->privacy_type_id == 1) {
                    array_push($other_privacy, [
                        'privacy_page' => $other_page->name,
                        'is_allowed' => 1
                    ]);
                }
                else if ($user_page_privacy->privacy_type_id == 2) {
                    $check_fav = Fav::where([ ['faved_by', $user->id], ['faved_to', $my_user->id] ])->first();
                    if (isset($check_fav)) {
                        array_push($other_privacy, [
                            'privacy_page' => $other_page->name,
                            'is_allowed' => 1
                        ]);
                    }
                    else {
                        array_push($other_privacy, [
                            'privacy_page' => $other_page->name,
                            'is_allowed' => 0
                        ]);
                    }
                }
                else if ($user_page_privacy->privacy_type_id == 3) {
                    if ($is_sprfvs == 1) {
                        array_push($other_privacy, [
                            'privacy_page' => $other_page->name,
                            'is_allowed' => 1
                        ]);
                    }else {
                        array_push($other_privacy, [
                            'privacy_page' => $other_page->name,
                            'is_allowed' => 0
                        ]);
                    }
                        
                }
                else if ($user_page_privacy->privacy_type_id == 4) {
                    $user_srfvs = UserSprvfsIO::where([
                        ['created_to',  $my_user->id], 
                        ['privacy_type_id', $user_page_privacy->privacy_type_id], 
                        ['created_by', $user->id],
                        ])->first();
                        if (isset($user_srfvs)) {
                            array_push($other_privacy, [
                            'privacy_page' => $other_page->name,
                            'is_allowed' => 1
                            ]);
                            
                        }
                        else {
                            array_push($other_privacy, [
                                'privacy_page' => $other_page->name,
                                'is_allowed' => 0
                            ]);
                        }
                }
                else {
                    array_push($other_privacy, [
                        'privacy_page' => $other_page->name,
                        'is_allowed' => 0
                    ]);
                }
                
            }
        }
        $returnData['other_privacy'] = $other_privacy;

        //check galleries inviteonly 
        $my_galleries = Gallery::where('created_by', $my_user->id)->get();
       //return $my_galleries;
        foreach ($my_galleries as $my_gallery) {
            $check_gallery_io = UserIOGallery::where([ ['user_id', $user->id], ['gallery_id', $my_gallery->id] ])->first();
            if(isset($check_gallery_io)) {
                array_push($gallery_invites_only, $my_gallery->id);
            }
        }

        $returnData['gallery_invited_list'] = $gallery_invites_only;
        return $this->sendResponse($returnData, 'User studio');
        
    }

    
}
