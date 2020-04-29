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
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
   
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        try {
            $user = User::where('email', $request->email)->first();
            if (isset($user)) {
                $response = $this->broker()->sendResetLink(
                    $this->credentials($request)
                );
                return $this->sendResponse($returnData, 'Email Sent');
            }else {
                return $this->sendError('Invalid Account.', 'No account associated with this email');
            }
        }catch(Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
    }

    public function resetPassword(Request $request)
    {
        $returnData = [];
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        try {
            $token_check = PasswordReset::where('email', $request->email)->first();
            if (!$token_check) {
                return $this->sendError('Invalid/Expired Token.', 'Token Expired or Invalid');
            }else {
                $user = User::where('email', $token_check->email)->first();
                $user->password = \Hash::make($request->password);
                $user->update();
                $token_check->delete();
            }
        }catch(Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Password Updated');
    }


}
