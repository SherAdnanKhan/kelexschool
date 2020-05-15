<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Validator;
use Auth;
use App\Models\Image;
use App\Models\User;
use App\Models\Fav;

class StudioController extends BaseController
{
    public function getMyStudio() 
    {
        $returnData = [];
        $auth_user = Auth::guard('api')->user();
        $user = User::with('avatars', 'art.parent')->withCount('posts')->find($auth_user->id);
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
            'avatar' => 'required|image|max:2000'
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
        $returnData = [];
        $user = User::with('avatars', 'galleries.image', 'art.parent')->withCount('posts')->where('slug', $slug)->first();
        if (!isset($user)) {
            return $this->sendError('Invalid User', ['error'=>'No User Exists', 'message' => 'No user exists']);
        }
        $returnData['user'] = $user;
        $fav_by_count = Fav::where('faved_to', $user->id)->get()->count();
        $fav_to_count = Fav::where('faved_by', $user->id)->get()->count();
        $returnData['fav_by_count'] = $fav_by_count;
        $returnData['favs_count'] = $fav_to_count;
        
        return $this->sendResponse($returnData, 'User studio');
        
    }

    
}
