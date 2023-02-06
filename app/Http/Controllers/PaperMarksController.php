<?php

namespace App\Http\Controllers;

use App\Models\Kelex_exam;
use App\Models\Kelex_class;
use Illuminate\Http\Request;
use App\Models\Kelex_exam_paper;
use App\Models\Kelex_paper_mark;
use App\Models\Kelex_sessionbatch;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RollNoRequest;
use App\Models\Kelex_paper_attendance;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Exam_CheckRequest;
use App\Http\Requests\Print_ResultRequest;
use App\Http\Requests\Exam_MarkSearchRequest;

class PaperMarksController extends Controller
{


    public function paper(){
        $class= Kelex_class::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
        $getexam = Kelex_exam::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
        $session = Kelex_sessionbatch::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
        return view('Admin.Examination.paper_mark_teacher')->with(['gexam'=>$getexam,'sessions'=>$session,'classes'=>$class]);
    }
    public function getsubjects(Request $request){
        // dd($request->CLASS_ID);
        $data= DB::table('kelex_exam_papers')
        ->leftJoin('kelex_exams', 'kelex_exams.EXAM_ID', '=', 'kelex_exam_papers.EXAM_ID')
        ->leftJoin('kelex_exam_assigns', 'kelex_exam_assigns.PAPER_ID', '=', 'kelex_exam_papers.PAPER_ID')
        ->leftJoin('kelex_subjects', 'kelex_subjects.SUBJECT_ID', '=', 'kelex_exam_papers.SUBJECT_ID')
        ->where('kelex_exam_papers.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
        ->where('kelex_exam_assigns.EMP_ID','=',Session::get('EMP_ID'))
        ->where('kelex_exam_papers.SECTION_ID','=',$request->SECTION_ID)
        ->where('kelex_exam_papers.CLASS_ID','=', $request->CLASS_ID)
        ->where('kelex_exam_papers.SESSION_ID','=',$request->SESSION_ID)
        ->where('kelex_exam_papers.EXAM_ID','=',$request->EXAM_ID)
        ->select('kelex_subjects.*','kelex_exam_papers.*')
        ->get()->toArray();
       
        return response()->json($data);
       }

       public function getsubjectadmin(Request $request){
        // dd($request->CLASS_ID);
        $data= DB::table('kelex_exam_papers')
        ->leftJoin('kelex_exams', 'kelex_exams.EXAM_ID', '=', 'kelex_exam_papers.EXAM_ID')
        ->leftJoin('kelex_subjects', 'kelex_subjects.SUBJECT_ID', '=', 'kelex_exam_papers.SUBJECT_ID')
        ->where('kelex_exam_papers.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
        ->where('kelex_exam_papers.SECTION_ID','=',$request->SECTION_ID)
        ->where('kelex_exam_papers.CLASS_ID','=', $request->CLASS_ID)
        ->where('kelex_exam_papers.SESSION_ID','=',$request->SESSION_ID)
        ->where('kelex_exam_papers.EXAM_ID','=',$request->EXAM_ID)
        ->select('kelex_subjects.*','kelex_exam_papers.*')
        ->get()->toArray();
       
        return response()->json($data);
       }
       public function getpaperid(Request $request){
        // dd($request->all());
        $data= DB::table('kelex_exam_papers')
        ->leftJoin('kelex_exam_assigns', 'kelex_exam_assigns.PAPER_ID', '=', 'kelex_exam_papers.PAPER_ID')
        ->where('kelex_exam_papers.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
        ->where('kelex_exam_papers.SECTION_ID','=',$request->SECTION_ID)
        ->where('kelex_exam_papers.CLASS_ID','=', $request->CLASS_ID)
        ->where('kelex_exam_papers.SESSION_ID','=',$request->SESSION_ID)
        ->where('kelex_exam_papers.EXAM_ID','=',$request->EXAM_ID)
        ->where('kelex_exam_papers.SUBJECT_ID','=',$request->SUBJECT_ID)
        ->select('kelex_exam_assigns.PAPER_ID','kelex_exam_papers.DATE')->first();
        //dd($data);
        return response()->json($data);
       }
    public function Search_Student(Exam_MarkSearchRequest $request)
    {
        $data['result']= DB::table('kelex_students_sessions')
        ->leftJoin('kelex_students', 'kelex_students.STUDENT_ID', '=', 'kelex_students_sessions.STUDENT_ID')
        ->leftJoin('kelex_paper_marks', 'kelex_paper_marks.STUDENT_ID', '=', 'kelex_students_sessions.STUDENT_ID')
        ->where('kelex_students_sessions.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
        ->where('kelex_students_sessions.SECTION_ID','=',$request->SECTION_ID)
        ->where('kelex_students_sessions.CLASS_ID','=', $request->CLASS_ID)
        ->where('kelex_students_sessions.SESSION_ID','=',$request->SESSION_ID)
        ->where('kelex_paper_marks.EXAM_ID','=',$request->EXAM_ID)
        ->where('kelex_paper_marks.SUBJECT_ID','=',$request->SUBJECT_ID)
        ->select('kelex_students.*','kelex_paper_marks.*')
        ->get()->toArray();
        
        if(count($data['result'])==0)
        {
            $data['result'] = DB::table('kelex_students_sessions')
            ->leftJoin('kelex_students', 'kelex_students.STUDENT_ID', '=', 'kelex_students_sessions.STUDENT_ID')
            ->where('kelex_students_sessions.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
            ->where('kelex_students_sessions.SECTION_ID','=',$request->SECTION_ID)
            ->where('kelex_students_sessions.CLASS_ID','=', $request->CLASS_ID)
            ->where('kelex_students_sessions.SESSION_ID','=',$request->SESSION_ID)
            ->select('kelex_students.*')
            ->get()->toArray();
        }
        $data['subjectid']=$request->SUBJECT_ID;
        return response()->json($data);
    }
     public function  Add_marks(Request $request)
     {
        $TOB_MARKS= $request->TOB_MARKS;
        $VOB_MARKS= $request->VOB_MARKS;
        $REMARKS= $request->REMARKS;
        $STUDENT_ID=$request->STUDENT_ID;
        //dd($STUDENT_ID);
        for($i=0;$i<count($STUDENT_ID);$i++)
        {
        $Result= Kelex_paper_mark::updateOrCreate(
          ['PAPER_ID' => $request->PAPER_ID,'STUDENT_ID'=>$STUDENT_ID[$i],'SUBJECT_ID'=>$request->SUBJECT_ID, 'EXAM_ID'=>$request->EXAM_ID],
          ['PAPER_ID' => $request->PAPER_ID,
          'STUDENT_ID'=>$STUDENT_ID[$i],
          'SESSION_ID'=>$request->SESSION_ID,
          'CLASS_ID'=>$request->CLASS_ID,
          'SECTION_ID'=>$request->SECTION_ID,
          'SUBJECT_ID'=>$request->SUBJECT_ID,
          'EXAM_ID'=>$request->EXAM_ID,
          'TOB_MARKS'=>$TOB_MARKS[$i],
          'VOB_MARKS'=>$VOB_MARKS[$i],
          'REMARKS'=>$REMARKS[$i],
          'STATUS'=>'2',
          'CAMPUS_ID' => Session::get('CAMPUS_ID'),
          'USER_ID' =>Session::get('EMP_ID'),
      ]);
        }
  
      //dd($Result);
   return response()->json(true);
         }

// PAPER ATTENDANCE COTROLLER FUNCTION START HERE


public function Paperattendance(){
    $class= Kelex_class::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
    $getexam = Kelex_exam::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
    $session = Kelex_sessionbatch::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
    return view('Admin.Examination.paper_attendance')->with(['gexam'=>$getexam,'sessions'=>$session,'classes'=>$class]);
}
public function Search_attendance(Exam_MarkSearchRequest $request)
{
    $data['result']= DB::table('kelex_paper_marks')
    ->leftJoin('kelex_students', 'kelex_students.STUDENT_ID', '=', 'kelex_paper_marks.STUDENT_ID')
    ->leftJoin('kelex_students_sessions', 'kelex_students_sessions.STUDENT_ID', '=', 'kelex_paper_marks.STUDENT_ID')
    ->leftJoin('kelex_exam_papers', 'kelex_exam_papers.SECTION_ID', '=', 'kelex_paper_marks.SECTION_ID')
    ->leftJoin('kelex_paper_attendances', 'kelex_paper_attendances.STD_ID', '=', 'kelex_students_sessions.STUDENT_ID')
    ->where('kelex_paper_marks.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
    ->where('kelex_paper_marks.EXAM_ID','=',$request->EXAM_ID)
    ->where('kelex_paper_marks.SUBJECT_ID','=',$request->SUBJECT_ID)
    ->where('kelex_paper_marks.SECTION_ID','=',$request->SECTION_ID)
    ->where('kelex_paper_marks.CLASS_ID','=', $request->CLASS_ID)
    ->where('kelex_paper_marks.SESSION_ID','=',$request->SESSION_ID)
    ->where('kelex_paper_attendances.EXAM_ID','=',$request->EXAM_ID)
    ->where('kelex_paper_attendances.SUBJECT_ID','=',$request->SUBJECT_ID)
    ->where('kelex_paper_attendances.SECTION_ID','=',$request->SECTION_ID)
    ->where('kelex_paper_attendances.CLASS_ID','=', $request->CLASS_ID)
    ->where('kelex_paper_attendances.SESSION_ID','=',$request->SESSION_ID)
    ->where('kelex_exam_papers.EXAM_ID','=',$request->EXAM_ID)
    ->where('kelex_exam_papers.SUBJECT_ID','=',$request->SUBJECT_ID)
    ->where('kelex_exam_papers.SECTION_ID','=',$request->SECTION_ID)
    ->where('kelex_exam_papers.CLASS_ID','=', $request->CLASS_ID)
    ->where('kelex_exam_papers.SESSION_ID','=',$request->SESSION_ID)
    ->where('kelex_paper_marks.STATUS','=','2')
    ->select('kelex_students.*','kelex_paper_marks.*','kelex_exam_papers.*','kelex_paper_attendances.*')
    ->get()->toArray();
    //dd($data['result']);
    $data['grade']= DB::table('kelex_grades')->where('kelex_grades.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->get()->toArray();
    $data['subjectid']=$request->SUBJECT_ID;
    if(count($data['result'])>0)
    {
        return response()->json($data);
    }
    $data['result']= DB::table('kelex_students_sessions')
    ->leftJoin('kelex_students', 'kelex_students.STUDENT_ID', '=', 'kelex_students_sessions.STUDENT_ID')
    ->leftJoin('kelex_paper_marks', 'kelex_paper_marks.STUDENT_ID', '=', 'kelex_students_sessions.STUDENT_ID')
    ->where('kelex_students_sessions.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
    ->where('kelex_students_sessions.SECTION_ID','=',$request->SECTION_ID)
    ->where('kelex_students_sessions.CLASS_ID','=', $request->CLASS_ID)
    ->where('kelex_students_sessions.SESSION_ID','=',$request->SESSION_ID)
    ->where('kelex_paper_marks.EXAM_ID','=',$request->EXAM_ID)
    ->where('kelex_paper_marks.SUBJECT_ID','=',$request->SUBJECT_ID)
    ->select('kelex_students.*','kelex_paper_marks.*')
    ->get()->toArray();
  //  dd($data['result']);
    return response()->json($data);
}
public function  Add_attendance(Request $request)
{
   $ATTEN_STATUS= $request->ATTEN_STATUS;
   $REMARKS= $request->REMARKS;
   $STUDENT_ID=$request->STD_ID;
   //dd($request->PAPER_ID);
   for($i=0;$i<count($STUDENT_ID);$i++)
   {
   $Result= Kelex_paper_attendance::updateOrCreate(
     ['PAPER_ID' => $request->PAPER_ID,'STD_ID'=>$STUDENT_ID[$i],'SUBJECT_ID'=>$request->SUBJECT_ID, 'EXAM_ID'=>$request->EXAM_ID],
     ['PAPER_ID' => $request->PAPER_ID,
     'STD_ID'=>$STUDENT_ID[$i],
     'SESSION_ID'=>$request->SESSION_ID,
     'CLASS_ID'=>$request->CLASS_ID,
     'SECTION_ID'=>$request->SECTION_ID,
     'SUBJECT_ID'=>$request->SUBJECT_ID,
     'EXAM_ID'=>$request->EXAM_ID,
     'ATTEN_DATE'=>$request->ATTEN_DATE,
     'ATTEN_STATUS'=>$ATTEN_STATUS[$i],
     'REMARKS'=>$REMARKS[$i],
     'CAMPUS_ID' => Session::get('CAMPUS_ID'),
     'USER_ID' =>Session::get('EMP_ID'),
 ]);
   }

 //dd($Result);
return response()->json(true);
    }



public function View_marks(){
   
}
public function Search_result(Exam_MarkSearchRequest $request)
{
    $data['result']= DB::table('kelex_students_sessions')
    ->leftJoin('kelex_students', 'kelex_students.STUDENT_ID', '=', 'kelex_students_sessions.STUDENT_ID')
    ->leftJoin('kelex_paper_marks', 'kelex_paper_marks.STUDENT_ID', '=', 'kelex_students_sessions.STUDENT_ID')
    ->where('kelex_students_sessions.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
    ->where('kelex_students_sessions.SECTION_ID','=',$request->SECTION_ID)
    ->where('kelex_students_sessions.CLASS_ID','=', $request->CLASS_ID)
    ->where('kelex_students_sessions.SESSION_ID','=',$request->SESSION_ID)
    ->where('kelex_paper_marks.STATUS','=','1')
    ->where('kelex_paper_marks.EXAM_ID','=',$request->EXAM_ID)
    ->where('kelex_paper_marks.SUBJECT_ID','=',$request->SUBJECT_ID)
    ->select('kelex_students.*','kelex_paper_marks.*')
    ->get()->toArray();
    if(count($data['result'])>0)
    {
        $data='';
        return response()->json($data);
    }
     //dd($request->SUBJECT_ID);
    $data['result']= DB::table('kelex_paper_marks')
    ->leftJoin('kelex_students', 'kelex_students.STUDENT_ID', '=', 'kelex_paper_marks.STUDENT_ID')
    ->leftJoin('kelex_students_sessions', 'kelex_students_sessions.STUDENT_ID', '=', 'kelex_paper_marks.STUDENT_ID')
    ->leftJoin('kelex_exam_papers', 'kelex_exam_papers.SECTION_ID', '=', 'kelex_paper_marks.SECTION_ID')
    ->where('kelex_paper_marks.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
    ->where('kelex_paper_marks.EXAM_ID','=',$request->EXAM_ID)
    ->where('kelex_paper_marks.SUBJECT_ID','=',$request->SUBJECT_ID)
    ->where('kelex_paper_marks.SECTION_ID','=',$request->SECTION_ID)
    ->where('kelex_paper_marks.CLASS_ID','=', $request->CLASS_ID)
    ->where('kelex_paper_marks.SESSION_ID','=',$request->SESSION_ID)
    ->where('kelex_exam_papers.EXAM_ID','=',$request->EXAM_ID)
    ->where('kelex_exam_papers.SUBJECT_ID','=',$request->SUBJECT_ID)
    ->where('kelex_exam_papers.SECTION_ID','=',$request->SECTION_ID)
    ->where('kelex_exam_papers.CLASS_ID','=', $request->CLASS_ID)
    ->where('kelex_exam_papers.SESSION_ID','=',$request->SESSION_ID)
    ->where('kelex_paper_marks.STATUS','=','2')
    ->select('kelex_students.*','kelex_paper_marks.*','kelex_exam_papers.*')
    ->get()->toArray();
  //  dd($data['result']);
    $data['grade']= DB::table('kelex_grades')->where('kelex_grades.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->get()->toArray();
    $data['subjectid']=$request->SUBJECT_ID;
    return response()->json($data);
}
    public function PublishResult(Request $request)
    {
        
        $data= Kelex_exam_paper::Where('PAPER_ID','=',$request->PAPER_ID)->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
        ->update(['PUBLISHED'=>'2','USER_ID'=>Session::get('user_id')]);
        return response()->json(true);
     }
//roll no controller
public function print_roll_no(RollNoRequest $request)
{
    $result= DB::table('kelex_students_sessions')
    ->leftJoin('kelex_students', 'kelex_students.STUDENT_ID', '=', 'kelex_students_sessions.STUDENT_ID')
    ->where('kelex_students_sessions.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
    ->where('kelex_students_sessions.SECTION_ID','=',$request->SECTION_ID)
    ->where('kelex_students_sessions.CLASS_ID','=', $request->CLASS_ID)
    ->where('kelex_students_sessions.SESSION_ID','=',$request->SESSION_ID)
    ->select('kelex_students.*','kelex_students_sessions.ROLL_NO')
    ->get()->toArray();
   // dd($result);
    $data= DB::table('kelex_exam_papers')
    ->leftJoin('kelex_subjects', 'kelex_exam_papers.SUBJECT_ID', '=', 'kelex_subjects.SUBJECT_ID')
    ->where('kelex_exam_papers.SECTION_ID','=',$request->SECTION_ID)
    ->where('kelex_exam_papers.CLASS_ID','=', $request->CLASS_ID)
    ->where('kelex_exam_papers.SESSION_ID','=',$request->SESSION_ID)
    ->where('kelex_exam_papers.EXAM_ID','=',$request->EXAM_ID)
    ->where('kelex_exam_papers.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
    ->select('kelex_subjects.SUBJECT_NAME','kelex_subjects.SUBJECT_CODE','kelex_exam_papers.DATE','kelex_exam_papers.TIME')
    ->get()->toArray();

    $Exam= DB::table('kelex_exams')
    ->where('EXAM_ID','=',$request->EXAM_ID)
    ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->first();
    // dd($Exam);
 
    return view('Admin.Examination.rollprint')->with(['data'=>$data,'Exam'=>$Exam,'result'=>$result]);
  
}
public function PrintResult(){
    $class= Kelex_class::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
    $getexam = Kelex_exam::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
    $session = Kelex_sessionbatch::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
    return view('Admin.Examination.printresult')->with(['gexam'=>$getexam,'sessions'=>$session,'classes'=>$class]);
}



public function ResultPrint(RollNoRequest $request)
{
    $result= DB::table('kelex_students_sessions')
    ->leftJoin('kelex_students', 'kelex_students.STUDENT_ID', '=', 'kelex_students_sessions.STUDENT_ID')
    ->where('kelex_students_sessions.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
    ->where('kelex_students_sessions.SECTION_ID','=',$request->SECTION_ID)
    ->where('kelex_students_sessions.CLASS_ID','=', $request->CLASS_ID)
    ->where('kelex_students_sessions.SESSION_ID','=',$request->SESSION_ID)
    ->select('kelex_students.*','kelex_students_sessions.*')
    ->get()->toArray();
   // dd($result);
    // $data= DB::table('kelex_exam_papers')
    // ->leftJoin('kelex_subjects', 'kelex_exam_papers.SUBJECT_ID', '=', 'kelex_subjects.SUBJECT_ID')
    // ->where('kelex_exam_papers.SECTION_ID','=',$request->SECTION_ID)
    // ->where('kelex_exam_papers.CLASS_ID','=', $request->CLASS_ID)
    // ->where('kelex_exam_papers.SESSION_ID','=',$request->SESSION_ID)
    // ->where('kelex_exam_papers.EXAM_ID','=',$request->EXAM_ID)
    // ->where('kelex_exam_papers.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
    // ->select('kelex_subjects.SUBJECT_NAME','kelex_subjects.SUBJECT_CODE','kelex_exam_papers.DATE','kelex_exam_papers.TIME')
    // ->get()->toArray();

    $Exam= DB::table('kelex_exams')
    ->where('EXAM_ID','=',$request->EXAM_ID)
    ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->first();
    // dd($Exam);
    $class= Kelex_class::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();


    $record =  DB::table('kelex_paper_marks')
    ->leftJoin('kelex_exams', 'kelex_exams.EXAM_ID', '=', 'kelex_paper_marks.EXAM_ID')
    ->leftJoin('kelex_exam_papers', 'kelex_paper_marks.PAPER_ID', '=', 'kelex_exam_papers.PAPER_ID')
    ->leftJoin('kelex_subjects', 'kelex_subjects.SUBJECT_ID', '=', 'kelex_paper_marks.SUBJECT_ID')
    ->leftJoin('kelex_students_sessions', 'kelex_paper_marks.STUDENT_ID', '=', 'kelex_students_sessions.STUDENT_ID')
    ->where('kelex_paper_marks.SECTION_ID','=',$request->SECTION_ID)
    ->where('kelex_paper_marks.CLASS_ID','=', $request->CLASS_ID)
    ->where('kelex_paper_marks.SESSION_ID','=',$request->SESSION_ID)
    ->where('kelex_paper_marks.EXAM_ID','=',$request->EXAM_ID)
    ->where('kelex_paper_marks.STATUS', '=','2')
    ->where('kelex_exam_papers.PUBLISHED', '=','2')
    ->select('kelex_paper_marks.*', 'kelex_exams.EXAM_NAME',
    'kelex_subjects.SUBJECT_NAME','kelex_exam_papers.*')
    ->get()->toArray();
   // dd($record);
    $grade= DB::table('kelex_grades')->where('kelex_grades.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->get()->toArray();
     //dd($record);
    return view('Admin.Examination.print_result_template')->with(['Exam'=>$Exam,'result'=>$result,'classes'=>$class,'record'=>$record,'grades'=>$grade]);
  
}
public function IndexDateSheet(){
    $class= Kelex_class::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
    $getexam = Kelex_exam::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
    $session = Kelex_sessionbatch::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
    return view('Admin.Examination.Index_Date_Sheet')->with(['gexam'=>$getexam,'sessions'=>$session,'classes'=>$class]);
}


    }



