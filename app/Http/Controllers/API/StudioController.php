<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Validator;
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
                    $returnData['image'] = $image_recived;
                    $image->title = $image_recived['image_name'];
                    $image->path = $image_recived['image_path'];
                    $image->updated_by  = $user->id;
                    $image->update();

                }else {
                    $image_recived = $this->uploadImage($request->avatar, "artists/");
                    $returnData['image'] = $image_recived;
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
                
        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Studio Updated');

    }
}
