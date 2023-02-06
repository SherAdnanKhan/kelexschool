<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class NonTeachingController extends Controller
{
    public function index_staff()
    {
            return view('Admin/HRManagement/add_staff_with_permissions');
    }


    public function store_staff(StaffRequest $request)
    {
        $result=User::where('id','!=',$request->id)->
        where('email','=',$request->email)->
        where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();

        if(count($result)>0)
        {
            return response()->json(false);
        }
        else
        {
    $permission= json_encode($request->role_per);
    $staff= new User();
        $staff->username=$request->username;
        $staff->email=$request->email;
        $staff->CAMPUS_ID=Auth::user()->CAMPUS_ID;
        $staff->password=Hash::Make($request->password);
        $staff->permissions=$permission;
        $staff->save();
        return response()->json(true);
    }
}
    public function show_all_staff()
    {
            $user=User::where('isadmin',false)->
            where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
            return view('Admin/HRManagement/view_staff_with_permissions')->with('staffs',$user);
    }
    public function edit_staff(Request $request)
    {
            $edituser=User::where('id',$request->id)->
            where('CAMPUS_ID',Session::get('CAMPUS_ID'))->first();

            return view('Admin/HRManagement/edit_staff_with_permissions')->with(['staff'=>$edituser]);
    }
    public function update_staff(Request $request)
    {
            $result=User::where('id','!=',$request->id)->
            where('email','=',$request->email)->get();
            if(count($result)>0)
            {
                return response()->json(false);
            }
            else
            {
                $permission= json_encode($request->role_per);
                $staff=User::find($request->id);
                $staff->username=$request->username;
                $staff->email=$request->email;
                $staff->permissions=$permission;
                $staff->save();
                return response()->json(true);

            }
    }
}

