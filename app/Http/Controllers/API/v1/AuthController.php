<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Validator;
use App\Models\User;
use App\Models\Image;
use App\Models\Gallery;
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
        $image_received =[];
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'avatar' => env('IMAGE_TYPE_SIZE', '1000')
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

            if($request->has('avatar')) {
                $image_received = $this->uploadImage($request->avatar, "artists/");
                $image = new Image();
                $image->title = $image_received['image_name'];
                $image->path = $image_received['image_path'];
                $image->image_type = 'App\Models\User';
                $image->image_id = $user->id;
                $image->created_by = $user->id;
                $image->save();
            }

            $user = User::with(['avatars', 'feel', 'art.parent'])->find($user->id);               
            $returnData['user'] =  $user;

            //default galleries on registration
            $galleries = config('constants.galleries');
            foreach($galleries as $gallery) {
                $new_gallery = new Gallery();
                $new_gallery->title = $gallery;
                $new_gallery->created_by = $user->id;
                $new_gallery->save();
            }
            
            ///\Mail::to($request->email)->send(new \App\Mail\WelcomeMail());

            //generate otp to newly registered users
            $verification_code =  $this->GenerateVerificationCode($user->id);
            $returnData['verification_code'] = $verification_code;


        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'User register successfully.');
    }


    public function login(Request $request)
    {
        $returnData = [];
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
   
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        try {
            $field = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            if (Auth::attempt([$field => $request->email, 'password' => $request->password])){ 
                $user = Auth::user();
                $user = User::with(['avatars', 'feel', 'art.parent'])->find($user->id);               
                $avatar = Image::where('image_type', 'App\Models\User')->where('created_by', $user->id)->get();
                $returnData['token'] =  $user->createToken('User Login')-> accessToken; 
                $returnData['user'] = $user;
                if(!isset($user->verification_code)) {
                    $verification_code =  $this->GenerateVerificationCode($user->id);
                    $returnData['verification_code'] = $verification_code;
                }
       
                return $this->sendResponse($returnData, 'User login successfully.');
            } 
            else{ 
                return $this->sendError('Validation Error', ['error'=>'Unauthorized', 'message' => 'Incorrect Email or Password']);
            } 
        }catch(QueryException $ex) {
            return $this->sendError('Validation Error.', $ex->getMessage(), 200);
        }catch(\Exception $ex) {
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
                    \Mail::to($request->email)->send(new \App\Mail\ResetPasswordMail($reset_details));
                return $this->sendResponse($returnData, 'Your password has been reset, check your e-mail to receive temporary password');
            }else {
                return $this->sendError('Invalid Account', ['error'=>'Invalid Account', 'message' => 'Sorry, Your email doesn\'t exists in our record']);
            }
        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
    }

    public function changePassword(Request $request)
    {
        $returnData = [];
        $user_auth_check = Auth::guard('api')->check();
        if (!$user_auth_check) {
            return $this->sendError('Unauthorized', ['error'=>'Unauthorized', 'message' => 'Please login before']);
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
                return $this->sendError('Invalid Old Password', ['error'=>'Invalid Old Password', 'message' => 'Please enter correct password'] );
            }
            $user->password = \Hash::make($request->password);
            $user->update();

        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }
        return $this->sendResponse($returnData, 'Password Updated');
    }

    public function GenerateVerificationCode($user_id)
    {
        $verification_code = mt_rand(10000,99999);
        $current_date_time = date('Y-m-d H:i:s');
        $verification_code_expiry = date("Y-m-d H:i:s",strtotime("+30 minutes", strtotime($current_date_time)));
        $user = User::find($user_id);
        
        $user->verification_code = $verification_code;
        $user->verification_code_expiry = $verification_code_expiry;
        $user->save();
        $emailData['email'] = $user->email;
        $emailData['verification_code'] = $verification_code;

        //send email a code
        \Mail::to($user->email)->send(new \App\Mail\VerificationCodeMail($emailData));
        return $verification_code;

    }

    public function sendEmail()
    {
        $verification_code = mt_rand(10000,99999);
        $current_date_time = now();
        return $current_date_time;
        //\Mail::to('sarahsajjad93@gmail.com')->send(new \App\Mail\WelcomeMail());
    }

    public function VerifyAccount(Request $request)
    {
        $user = Auth::user();
        $returnData = [];

        $validator = Validator::make($request->all(), [
            'verification_code' => 'required|max:5',
        ]);
        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        try {
            if($user->verification_code == $request->verification_code) {
                if(!isset($user->email_verified_at)) {
                    $updateUser = User::find($user->id);
                    $updateUser->email_verified_at = now();
                    $updateUser->save();

                    \Mail::to($request->email)->send(new \App\Mail\WelcomeMail());
                }
                
            }
            else {
                return $this->sendError('Invalid Verification code', ['error'=>'Invalid or Expired Code', 'message' => 'Please enter correct code'] );
            }

            $user = User::with(['avatars', 'feel', 'art.parent'])->find($user->id);
            $returnData['user'] = $user;
            return $this->sendResponse($returnData, 'Account is Verified');

        }catch(\Exception $ex) {
            return $this->sendError('Unknown Error', $ex->getMessage(), 200);       
        }

    }

    public function ResendVerificationCode()
    {
        $user = Auth::user();
        $returnData = [];
        if(!isset($user->verification_code)) {
            $verification_code =  $this->GenerateVerificationCode($user->id);
            $returnData['verification_code'] = $verification_code;
        }else {
            return $this->sendError('Verified Account ', ['error'=>'Already Verified Account', 'message' => 'Your account is already verified']);
        }

        return $this->sendResponse($returnData, 'Email sent to associated account');

    }


}
