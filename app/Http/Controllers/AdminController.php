<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserInfo;
use App\Models\Kelex_campus;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
   

    public function index(){
         
      $campus =  kelex_campus::all();
     return view('Admin.superAdmin.superAdmin')->with('campuses',$campus);
    }
}
