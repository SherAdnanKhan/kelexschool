<?php

namespace App\Http\Controllers;

use App\Models\Kelex_campus;
use App\Models\Kelex_employee;
use Illuminate\Http\Request;
use App\Models\Kelex_student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TempController extends Controller
{
    public function updatestudents()
    {
       $students= Kelex_student::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
       $campus= Kelex_campus::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->first();
       $campusname=$campus->SCHOOL_NAME[0];
       $campusid=$campus->CAMPUS_ID;
       foreach($students as $student){
        $username= $campusname.''.$campusid.'_'.substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 9);
       $success= DB::table('kelex_students')->where('CAMPUS_ID',Session::get('CAMPUS_ID'))->where('STUDENT_ID',$student->STUDENT_ID)
        ->update(['USERNAME' => $username]); 
       }
    }
    public function updateteachers()
    {
       $teachers= Kelex_employee::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
       $campus= Kelex_campus::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->first();
       $campusname=$campus->SCHOOL_NAME[0];
       $campusid=$campus->CAMPUS_ID;
       //dd($teachers);
       foreach($teachers as $teacher){
        $username= $campusname.'T'.$campusid.'_'.substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 9);
       $success= DB::table('kelex_employees')->where('CAMPUS_ID',Session::get('CAMPUS_ID'))->where('EMP_ID',$teacher->EMP_ID)
        ->update(['USERNAME' => $username]); 
       }
    
    dd($success);
    }

}
