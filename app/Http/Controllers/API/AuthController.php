<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Validator;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class AuthController extends BaseController
{
    use SendsPasswordResetEmails;
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $returnData = [];
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ]);
   
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        try {
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $input['last_login'] = now();
            $user = User::create($input);
            \Mail::to($request->email)->send(new \App\Mail\WelcomeMail());
            $returnData['token'] =  $user->createToken('User Register')->accessToken;
            $returnData['user'] =  $user;
        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'User register successfully.');
    }


    public function login(Request $request)
    {
        $returnData = [];
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
   
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        try {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
                $user = Auth::user(); 
                $returnData['token'] =  $user->createToken('User Login')-> accessToken; 
                $returnData['user'] = $user;
       
                return $this->sendResponse($returnData, 'User login successfully.');
            } 
            else{ 
                return $this->sendError('Invalid Email or Password.', ['error'=>'Unauthorised']);
            } 
        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }

    }
    
    public function sendResetLinkEmail(Request $request)
    {
        $returnData = [];
        $reset_details = [];
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
   
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        try {
            $user = User::where('email', $request->email)->first();
            if (isset($user)) {
                $new_password = substr(md5(uniqid(rand(),1)),3,10);
                $reset_details['first_name'] = $user->first_name;
                $reset_details['last_name'] = $user->last_name;
                $reset_details['email'] = $request->email;
                $reset_details['new_password'] = $new_password;
                $user->password = \Hash::make($new_password);
                $user->update();
                if(env('APP_ENV') != 'local') {
                    \Mail::to($request->email)->send(new \App\Mail\ResetPasswordMail($reset_details));
                }
                
                return $this->sendResponse($returnData, 'Your password has been reset, check your e-mail to receive temporary password');
            }else {
                return $this->sendError('Invalid Account.', 'Sorry, Your email doesn\'t exists in our record');
            }
        }catch(Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
    }

    public function changePassword(Request $request)
    {
        $returnData = [];
        $user_auth_check = Auth::guard('api')->check();
        if (!$user_auth_check) {
            return $this->sendError('Unauthorized', 'Please Login to proceed');
        }
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        try {
            $auth_user = auth('api')->user();
            $user = User::where('email', $auth_user->email)->first();
            if (!\Hash::check($request->old_password, $auth_user->password)) {
                return $this->sendError('Invalid Old Password', 'Please enter correct password');
            }
            $user->password = \Hash::make($request->password);
            $user->update();

        }catch(Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Password Updated');
    }


}
