<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserFeel;
use Auth;
use Validator;

class UserController extends BaseController
{
    public function getAllUsers()
    {
        $users = User::all();
        return $this->sendResponse($users, 'all users list');
    }
    
    public function searchUsers(Request $request)
    {
        $returnData = [];
        try {
            if($request->has('name')) {
                $users = User::with(['avatars', 'feel', 'art.parent', 'postsImagesRandom' => function($query) {
                    return $query->limit(4);
                }])->where('username', 'LIKE', '%'.$request->name.'%')->get();
            }else {
              $users = User::with(['avatars', 'feel', 'art.parent', 'postsImagesRandom' => function($query) {
                return $query->limit(4);
                }])->all();  
            }
            $returnData['users'] = $users;

        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);
        }
        return $this->sendResponse($returnData, 'Artist Search result');
    }

    public function updateUserFeel(Request $request)
    {
        $user = Auth::guard('api')->user();
        $validator = Validator::make($request->all(), [
            'feel_id' => 'required',
        ]);
   
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        try {
            $user->feel_id = $request->feel_id;
            $user->update();

            $user_feel = new UserFeel();
            $user_feel->user_id = $user->id;
            $user_feel->feel = 'red';
            $user_feel->feel_id = $request->feel_id;
            $user_feel->save();

            $return_user = User::with(['avatars', 'feel'])->find($user->id);
            $returnData['user'] = $return_user;
        }catch(QueryException $ex) {
            return $this->sendError('Query Exception Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'User feel Successfully.');
    }

    public function updateUserBio(Request $request)
    {
        $user = Auth::guard('api')->user();
        $validator = Validator::make($request->all(), [
            'bio' => 'required',
        ]);
   
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        try {
            $user->bio = $request->bio;
            $user->update();

            $return_user = User::with('avatars', 'feel')->find($user->id);
            $returnData['user'] = $return_user;
        }catch(QueryException $ex) {
            return $this->sendError('Query Exception Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'User bio Successfully.');

    }

    public function getAllUserFeel(Request $request)
    {
        $user = Auth::guard('api')->user();
        $returnData = [];

        $user_feel_list = UserFeel::with('feel')->where('user_id', $user->id)->paginate(env('PAGINATE_LENGTH', 15));
        $returnData['user_feel_list'] = $user_feel_list;
        return $this->sendResponse($returnData, 'User feel list.');
    }
}
