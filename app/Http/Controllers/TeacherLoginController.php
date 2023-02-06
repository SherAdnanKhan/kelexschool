<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelex_employee;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\teacherloginRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeacherLoginController extends Controller
{
    public function login_employee(teacherloginRequest $request)
    {
      $USERNAME = $request->input('EMP_NO');
      $PASSWORD = $request->input('PASSWORD');
 
      $employee = Kelex_employee::where('USERNAME', '=',$USERNAME)->first();
      if (!$employee)
     {
         return response()->json();
     }
      if (!Hash::check($PASSWORD, $employee->PASSWORD))
       {
         return response()->json();
      }
      $campus=DB::table('kelex_campuses')->where('CAMPUS_ID','=',$employee['CAMPUS_ID'])->first();
      $schoolname=$campus->SCHOOL_NAME;
      if($campus->TYPE=='school')
      {
          $class='Class';
          $Session='Session';
          $Section='Section';
          $campusname='School';
      }
      else
      {
          $class='Program';
          $Session='Batch';
          $Section='Semester';
          $campusname='University';
      }
        Session::put([
            'CAMPUS_ID'=>$employee['CAMPUS_ID'],
            'is_teacher'=>true,
            'EMP_ID'=>$employee['EMP_ID'],
            'class'=>$class,
            'session'=>$Session,
            'section'=>$Section,
            'campusname'=>$campusname,
            'schoolname'=> $schoolname
            ]);
        return response()->json(['url'=>url('teacher/dashboard')]);
     
    }
    public function logout_employee(Request $request)
    {
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect('/');
    }
    public function dashboard()
    {   
        return view('teacher_dashboard');
    }

}
