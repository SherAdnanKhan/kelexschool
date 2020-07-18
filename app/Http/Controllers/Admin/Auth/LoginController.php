<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Admin\BaseController;
use Illuminate\Http\Request;
use Auth;

class LoginController extends BaseController
{

    protected $redirectTo = '/admin/dashboard';

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLogin(Request $request) {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $returnData = [];
        $credentials = $request->only('email', 'password'); 
        if(Auth::guard('admin')->attempt($request->only('email','password'),$request->filled('remember'))){
            $returnData = $user = Auth::user(); 
            return $this->sendResponse($returnData, 'Logged in Sucessfully');
        }
        return $this->sendError('Validation Error', ['error'=>'Unauthorised', 'message' => 'Incorrect Email or Password']); 
             
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return  redirect('/admin');
    }

    
}
