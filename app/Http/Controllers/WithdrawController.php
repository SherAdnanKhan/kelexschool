<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kelex_class;
use Illuminate\Http\Request;
use App\Models\Kelex_student;
use App\Models\Kelex_sessionbatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelex_students_session;
use App\Models\Kelex_withdraw_student;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\KelexWidthdrawStudent;

class WithdrawController extends Controller
{
    public function show()
    {

    $class= Kelex_class::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
    $session= Kelex_sessionbatch::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
    return view('Admin.WithdrawManagement.withdraw_student')->with(['classes'=>$class,'sessions'=>$session]);
    }
    public function delete_student(Request $request)
    {
       $studentdata= Kelex_students_session::where('STUDENT_ID',$request->input('STUDENT_ID'))
        ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->first();

        //dd($studentdata);
        Kelex_withdraw_student::create(['STATUS'=>'1',
        'STUDENT_ID'=>$studentdata['STUDENT_ID'],'SESSION_ID'=>$studentdata['SESSION_ID'],
        'CLASS_ID'=>$studentdata['CLASS_ID'],'SECTION_ID'=>$studentdata['SECTION_ID'],'WITHDRAW_DATE'=>Carbon::today(),
        'CAMPUS_ID' => Session::get('CAMPUS_ID'),'USER_ID' =>Auth::user()->id]);
        Kelex_students_session::where('STUDENT_ID',$request->input('STUDENT_ID'))
        ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->delete();
        Kelex_student::where('STUDENT_ID',$request->input('STUDENT_ID'))
        ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->delete();
        $explode_id = array_map('intval', explode('.', $request->input('SECTION_ID')));
        $SECTION_ID=$explode_id[0];
        $CLASS_ID=$explode_id[1];
        //dd($CLASS_ID);
        $studentid= Kelex_students_session::where('CLASS_ID', $CLASS_ID)
        ->where('SECTION_ID', $SECTION_ID)
        ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->
        select('STUDENT_ID')->get()->toArray();
            for ($i = 0; $i < count($studentid); $i++)
            { 
                DB::table('kelex_students_sessions')
                ->where('STUDENT_ID', $studentid[$i]['STUDENT_ID'])
                ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
                ->update(['ROLL_NO' => $i+1]);
            }
           // dd($result);
        
        return response()->json();
    }
    public function show_withdraw_students()
    {
        $class= Kelex_class::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
        $session= Kelex_sessionbatch::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
        return view('Admin.WithdrawManagement.students_withdrawal_record')->with(['classes'=>$class,'sessions'=>$session]);
    }
    public function fetch_withdraw_student_data(KelexWidthdrawStudent $request)
    {

     $explode_id = array_map('intval', explode('.', $request->SECTION_ID));
     $SECTION_ID=$explode_id[0];
     $CLASS_ID=$explode_id[1];
       $result=  DB::table('kelex_withdraw_students')
        ->leftJoin('kelex_students', 'kelex_withdraw_students.STUDENT_ID', '=', 'kelex_students.STUDENT_ID')
        ->where('kelex_withdraw_students.SECTION_ID', '=',$SECTION_ID)
        ->where('kelex_withdraw_students.CLASS_ID', '=',$CLASS_ID)
        ->where('kelex_withdraw_students.SESSION_ID', '=',$request->SESSION_ID)
        ->where('kelex_students.deleted_at', '!=',NULL)
        ->where('kelex_withdraw_students.CAMPUS_ID','=', Session::get('CAMPUS_ID'))
        ->select('kelex_students.*')
        ->get()->toArray();
        //dd($result);
        return response()->json($result);
    }
    public function roll_back_student(Request $request)
    {
     $rollback_student=  Kelex_withdraw_student::where('STUDENT_ID',$request->input('STUDENT_ID'))
     ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->first();
     
     $rollno= DB::table('kelex_students_sessions')
     ->where('CAMPUS_ID',Auth::user()->CAMPUS_ID)
     ->max('ROLL_NO');

     $rollno = ( $rollno == NULL) ? 1 : $rollno+1;
     Kelex_students_session::Create([
        'SESSION_ID'=>$rollback_student['SESSION_ID'],
        'CLASS_ID'=>$rollback_student['CLASS_ID'],
        'IS_ACTIVE'=>'1',
        'SECTION_ID'=>$rollback_student['SECTION_ID'],
        'STUDENT_ID'=>$rollback_student['STUDENT_ID'],
        'ROLL_NO'=> $rollno,
        'CAMPUS_ID'=>Auth::user()->CAMPUS_ID,
        'USER_ID'=> Auth::user()->id
     ]);
     $rollback_student=  Kelex_student::withTrashed()->where('STUDENT_ID',$rollback_student['STUDENT_ID'])
     ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->restore();

        $rollback_student=  Kelex_withdraw_student::where('STUDENT_ID',$request->input('STUDENT_ID'))
        ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->delete();
        return response()->json();
    }

}

