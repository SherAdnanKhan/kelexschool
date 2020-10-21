<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserFeel;
use App\Models\Fav;
use App\Models\UserSprvfsIO;
use App\Models\UserReport;
use App\Models\UserBlock;
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
        $validator = Validator::make($request->all(), [
            'name' => 'min:1|regex:/(^[A-Za-z0-9 ]+$)+/'
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $returnData = $users =[];
        $my_user = Auth::guard('api')->user();
        try {
            if($request->has('name')) {
                $users = User::with(['avatars', 'feel', 'art.parent', 'privacyStrq',  'postsImagesRandom' => function($query) {
                    return $query->limit(4);
                }])->where('username', 'LIKE', '%'.$request->name.'%')->get();
            }else {
              $users = User::with(['avatars', 'feel', 'art.parent', 'privacyStrq', 'postsImagesRandom' => function($query) {
                return $query->limit(4);
                }])->all();  
            }
            
            foreach($users as $user) {
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
                //check privacy
                if(!isset($user->privacyStrq)) {
                    $user->privacyStrq = [ 'is_allowed' => 1 ];
                }else {
                    if ($user->privacyStrq->privacy_type_id == 1) {
                        $user->privacyStrq = [ 'is_allowed' => 1 ];
                    }
                    else if ($user->privacyStrq->privacy_type_id == 2) {
                        $check_fav = Fav::where([ ['faved_by', $user->id], ['faved_to', $my_user->id] ])->first();
                        if (isset($check_fav)) {
                            $user->privacyStrq = [ 'is_allowed' => 1 ];
                        }
                        else {
                            $user->privacyStrq = [ 'is_allowed' => 0 ];
                        }
                    }
                    else if ($user->privacyStrq->privacy_type_id == 3) {
                        if ($is_sprfvs == 1) {
                            $user->privacyStrq = [ 'is_allowed' => 1 ];
                        }else {
                            $user->privacyStrq = [ 'is_allowed' => 0 ];
                        }
                    }
                    else if ($user->privacyStrq->privacy_type_id == 4) {
                        $user_srfvs = UserSprvfsIO::where([
                            ['created_to',  $my_user->id], 
                            ['privacy_type_id', $user->privacyStrq->privacy_type_id], 
                            ['created_by', $user->id],
                            ])->first();
                            if (isset($user_srfvs)) {
                                $user->privacyStrq = [ 'is_allowed' => 1 ];
                            }
                            else {
                                $user->privacyStrq = [ 'is_allowed' => 0 ];
                            }
                    }
                    else {
                        $user->privacyStrq = [ 'is_allowed' => 0 ];
                    }
                    
                }
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

    public function updateUserName(Request $request)
    {
        $user = Auth::guard('api')->user();
        $validator = Validator::make($request->all(), [
            'username' => 'required',
        ]);
   
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        try {
            $check_name_already = User::where('username', $request->username)->first();
            if(isset($check_name_already)) {
                if($check_name_already->id == $user->id) {
                    $user->username = $request->username;
                    $user->update();
                }else {
                    return $this->sendError('user name is already taken', ['error'=>'User name already taken', 'message' => 'User name already taken']);
                }
            }else {
                $user->username = $request->username;
                $user->update();
            }
            $return_user = User::with('avatars', 'feel')->find($user->id);
            $returnData['user'] = $return_user;
        }catch(QueryException $ex) {
            return $this->sendError('Query Exception Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'User name updated Successfully.');

    }

    public function getAllUserFeel(Request $request)
    {
        $user = Auth::guard('api')->user();
        $returnData = [];

        $user_feel_list = UserFeel::with('feel')->where('user_id', $user->id)->paginate(env('PAGINATE_LENGTH', 15));
        $returnData['user_feel_list'] = $user_feel_list;
        return $this->sendResponse($returnData, 'User feel list.');
    }

    public function updateStatusOnline($status)
    {
        $user = Auth::guard('api')->user();
        $returnData = [];
        try {
            $user->online = $status;
            $user->last_login = now();
            $user->update();

            $user = User::with(['avatars', 'feel', 'art.parent'])->find($user->id); 
        }catch(QueryException $ex) {
            return $this->sendError('Query Exception Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }              
        $returnData['user'] =  $user;

        return $this->sendResponse($returnData, 'User update online status');        
    }

    public function reportUser(Request $request)
    {
        $user = Auth::guard('api')->user();
        $returnData = [];
        $validator = Validator::make($request->all(), [
            'report_user_id' => 'required',
            'reason' => 'required',
        ]);
   
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        try {

            $report_user = User::find($request->report_user_id);
            if (!isset($report_user)) {
                return $this->sendError('Invalid User', ['error'=>'No User Exists', 'message' => 'No user exists']);
            }

            $report = new UserReport();
            $report->report_to = $request->report_user_id;
            $report->report_by = $user->id;
            $report->reason = $request->reason;
            $report->save();

            //email to reported user
            $emailData['by_user'] = $by_user = User::with('avatars')->findOrFail($user->id);
            $emailData['to_user'] = $to_user = User::with('avatars')->findOrFail($request->report_user_id);
            $emailData['report_reason'] = $request->reason;
            $emailData['logo'] = env('FRONT_APP_URL', 'https://staging.meuzm.com/').'assets/images/LogoIconGold.png';

            \Mail::to($report_user->email)->send(new \App\Mail\ReportUserMail($emailData));


        }catch(QueryException $ex) {
            return $this->sendError('Query Exception Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }              
        $returnData['report'] =  $report;

        return $this->sendResponse($returnData, 'User is Reported');   
    }

    public function blockUser(Request $request)
    {
        $user = Auth::guard('api')->user();
        $returnData = [];
        $validator = Validator::make($request->all(), [
            'block_user_id' => 'required',
        ]);
   
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        try {

            $block_user = User::find($request->block_user_id);
            if (!isset($block_user)) {
                return $this->sendError('Invalid User', ['error'=>'No User Exists', 'message' => 'No user exists']);
            }

            $blocked_user_check = UserBlock::where([
                ['block_to', $request->block_user_id], 
                ['block_by', $user->id]
                ])->first();
            if(isset($blocked_user_check)) {
                return $this->sendError('Already Blocked Users', ['error'=>'User is already blocked', 'message' => 'User is already blocked']);
            }

            $block = new UserBlock();
            $block->block_to = $request->block_user_id;
            $block->block_by = $user->id;
            $block->save();

        }catch(QueryException $ex) {
            return $this->sendError('Query Exception Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }              
        $returnData['report'] =  $block;

        return $this->sendResponse($returnData, 'User is Blocked');   
    }
}
