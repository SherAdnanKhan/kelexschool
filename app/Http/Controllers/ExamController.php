<?php

namespace App\Http\Controllers;

use DateTime;
use DatePeriod;
use KelexClass;
use DateInterval;
use App\Models\Kelex_exam;
use App\Models\Kelex_class;
use App\Models\Kelex_grade;
use Illuminate\Http\Request;
use App\Models\Kelex_subject;
use App\Models\Kelex_employee;
use App\Models\Kelex_exam_paper;
use App\Models\Kelex_exam_assign;
use App\Http\Requests\Kelex_exams;
use App\Models\Kelex_paper_upload;
use App\Models\Kelex_sessionbatch;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Kelex_grades;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ExamPaperRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Exam_paperRequest;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\Exam_SearchRequest;
use App\Http\Requests\PaperUploadRequest;
use App\Http\Requests\paper_uploadRequest;
use App\Http\Requests\SaveTeacherUploadRequest;

class ExamController extends Controller
{
// Add Exam Controller Function start here

    public function index_exam(Request $request)
    {


        $getexam = Kelex_exam::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
        $session = Kelex_sessionbatch::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
      
        return view('Admin.Examination.add_exams')->with(['gexam'=>$getexam,'sessions'=>$session]);

    }
    public function add_exam(kelex_exams $request)
    {
        $matchdates=0;
        $results= DB::table('kelex_exams')
        ->where('EXAM_ID','!=', $request->input('EXAM_ID'))
        ->where('SESSION_ID','=', $request->input('SESSION_ID'))
        ->where('kelex_exams.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->get()->toArray();
        if(count($results))
    {
        foreach($results as $result){
        $requestdates=$this->twoDatesRange($request->START_DATE, $request->END_DATE);
        if(count($requestdates)==0)
        {
            return response()->json('wrongselect');
        }
        $marks = $this->twoDatesRange($result->START_DATE, $result->END_DATE);
        //dd($marks);
        for($i=0;$i<count($marks);$i++)
        {
            for($j=0;$j<count($requestdates);$j++)
            {
            if($marks[$i]==$requestdates[$j])
            {
            $matchdates+=1;
            }
        }
        }
        }
    }
        if($matchdates==0)
        {
            $exKelex_exam = new Kelex_exam();
            $exKelex_exam->EXAM_NAME=$request->input('EXAM_NAME');
            $exKelex_exam->START_DATE=$request->input('START_DATE');
            $exKelex_exam->END_DATE=$request->input('END_DATE');
            $exKelex_exam->SESSION_ID=$request->input('SESSION_ID');
            $exKelex_exam->CAMPUS_ID= Auth::user()->CAMPUS_ID;
            $exKelex_exam->USER_ID = Auth::user()->id;
            $exKelex_exam->save();
           
          return response()->json(true);
        }
        else
        {
            return response()->json(false);
        }
         

    }
    public function edit_exam(Request $request)
    {

        $currentSB= DB::table('kelex_exams')->where(['EXAM_ID' => $request->EXAM_ID])
        ->where('kelex_exams.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->get();
       echo json_encode($currentSB);

    }

    public function update_exam(kelex_exams $request)
    {

        $matchdates=0;
        $results= DB::table('kelex_exams')
        ->where('EXAM_ID','!=', $request->input('EXAM_ID'))
        ->where('SESSION_ID','=', $request->input('SESSION_ID'))
        ->where('kelex_exams.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->get()->toArray();
        if(count($results))
    {
        foreach($results as $result){
        $requestdates=$this->twoDatesRange($request->START_DATE, $request->END_DATE);
        if(count($requestdates)==0)
        {
            return response()->json('wrongselect');
        }
        $dates = $this->twoDatesRange($result->START_DATE, $result->END_DATE);
        for($i=0;$i<count($dates);$i++)
        {
            for($j=0;$j<count($requestdates);$j++)
            {
            if($dates[$i]==$requestdates[$j])
            {
            $matchdates+=1;
            }
        }
        }
        }
    }
        if($matchdates==0)
        {
        DB::table('kelex_exams')
        ->where('EXAM_ID', $request->input('EXAM_ID'))
        ->where('kelex_exams.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
        ->update(['EXAM_NAME' => $request->input('EXAM_NAME'),
        'START_DATE' => $request->input('START_DATE'),
        'END_DATE' => $request->input('END_DATE'),
        'SESSION_ID' => $request->input('SESSION_ID')]);
          return response()->json(true);
        }
        else
        {
            return response()->json(false);
        }
    
    }
    public function delete_exam(Request $request)
    {
        $id=$request->input('EXAM_ID');
        DB::table('kelex_exams')->where('EXAM_ID',$request->input('EXAM_ID'))
        ->where('kelex_exams.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->delete();

                 return response()->json($id);
    }
    function twoDatesRange($start, $end, $format = 'Y-m-d')
    {
        $arr = array();
        $interval = new DateInterval('P1D');

        $realEnd = new DateTime($end);
        $realEnd->add($interval);

        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

        foreach ($period as $date) {
            $arr[] = $date->format($format);
        }

        return $arr;
    }
    public function index_exampaper(Request $request)
    {
        $class= Kelex_class::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
        $getexam = Kelex_exam::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
        $session = Kelex_sessionbatch::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
        $Subject = Kelex_subject::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
        $teacher= Kelex_employee::where('EMP_TYPE','1')->where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
        return view('Admin.Examination.add_exams_paper')->with(['gexam'=>$getexam,'subjects'=>$Subject,'sessions'=>$session,'classes'=>$class,'teachers'=>$teacher]);

    }
    public function view_exam_paper(Exam_SearchRequest $request){
        $record['record'] =  DB::table('kelex_exam_papers')
        ->leftJoin('kelex_exams', 'kelex_exams.EXAM_ID', '=', 'kelex_exam_papers.EXAM_ID')
        ->leftJoin('kelex_sections', 'kelex_sections.Section_id', '=', 'kelex_exam_papers.SECTION_ID')
        ->leftJoin('kelex_classes', 'kelex_classes.Class_id', '=', 'kelex_exam_papers.CLASS_ID')
        ->leftJoin('kelex_sessionbatches', 'kelex_sessionbatches.SB_ID', '=', 'kelex_exam_papers.SESSION_ID')
        ->leftJoin('kelex_subjects', 'kelex_subjects.SUBJECT_ID', '=', 'kelex_exam_papers.SUBJECT_ID')
        ->where('kelex_exam_papers.SECTION_ID', '=',$request->SECTION_ID)
        ->where('kelex_exam_papers.CLASS_ID', '=',$request->CLASS_ID)
        ->where('kelex_exam_papers.SESSION_ID', '=',$request->SESSION_ID)
        ->where('kelex_exam_papers.CAMPUS_ID',Session::get('CAMPUS_ID'))
        ->select('kelex_exam_papers.*', 'kelex_subjects.SUBJECT_NAME','kelex_exams.EXAM_NAME',
        'kelex_sections.Section_name','kelex_classes.Class_name','kelex_sessionbatches.SB_NAME')
        ->groupBy('kelex_exam_papers.DATE')
        ->get()->toArray();
        $record['SECTION_ID']=$request->SECTION_ID;
        $record['CLASS_ID']=$request->CLASS_ID;
        $record['SESSION_ID']=$request->SESSION_ID;
        return response()->json($record);
    }
    public function add_exam_paper(Exam_paperRequest $request){
     
        $matchdates=0;
        $data= DB::table('kelex_exam_papers')
        ->where('DATE', '=',$request->DATE)
        ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->get()->toArray();

        $subject= DB::table('kelex_exam_papers')
        ->where('SECTION_ID', '=',$request->SECTION_ID)
        ->where('CLASS_ID', '=',$request->CLASS_ID)
        ->where('SESSION_ID', '=',$request->SESSION_ID)
        ->where('SUBJECT_ID','=',$request->SUBJECT_ID)
        ->where('EXAM_ID','=',$request->EXAM_ID)
        ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->get()->toArray();

        if(count($data)>0)
        {
            return response()->json('datematch');
        }
        
        if(count($subject)>0)
        {
            return response()->json('subjectexist');
        }

        $results= DB::table('kelex_exams')
        ->where('EXAM_ID','=', $request->input('EXAM_ID'))
        ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->get()->toArray();
        //dd($results);
        if(count($results))
    {
        foreach($results as $result)
    {
        $dates = $this->twoDatesRange($result->START_DATE, $result->END_DATE);
        for($i=0;$i<count($dates);$i++)
        {
            if($dates[$i]==$request->DATE)
            {
            $matchdates+=1;
            }
        }
    }
    }
        if($matchdates>0)
    {   
        $data= Kelex_exam_paper::create(['EXAM_ID'=>$request->EXAM_ID,'SECTION_ID'=>$request->SECTION_ID,'SUBJECT_ID'=>$request->SUBJECT_ID,'CLASS_ID'=>$request->CLASS_ID,'TIME'=>$request->TIME
        ,'DATE'=>$request->DATE,'TOTAL_MARKS'=>$request->TOTAL_MARKS,'PASSING_MARKS'=>$request->PASSING_MARKS,'VIVA'=>$request->VIVA,'VIVA_MARKS'=>$request->VIVA_MARKS,
        'SESSION_ID'=>$request->SESSION_ID,'PUBLISHED'=>'1','CAMPUS_ID'=>Session::get('CAMPUS_ID'),'USER_ID'=>Auth::user()->id]);
        
        return response()->json(true);
     }

     return response()->json(false);


    }
    
    public function edit_exam_paper(Request $request)
    {
        $data= Kelex_exam_paper::where('PAPER_ID',$request->PAPER_ID)->where('CAMPUS_ID',Session::get('CAMPUS_ID'))->first();
        return response()->json($data);
    }
    public function update_exam_paper(Exam_paperRequest $request){
     
        $matchdates=0;
        $data= DB::table('kelex_exam_papers')
        ->where('PAPER_ID','!=',$request->PAPER_ID)
        ->where('DATE', '=',$request->DATE)
        ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->get()->toArray();
       
        if(count($data)>0)
        {
            return response()->json('datematch');
        }
        $subject= DB::table('kelex_exam_papers')
        ->where('PAPER_ID','!=',$request->PAPER_ID)
        ->where('SECTION_ID', '=',$request->SECTION_ID)
        ->where('CLASS_ID', '=',$request->CLASS_ID)
        ->where('SESSION_ID', '=',$request->SESSION_ID)
        ->where('SUBJECT_ID','=',$request->SUBJECT_ID)
        ->where('EXAM_ID','=',$request->EXAM_ID)
        ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->get()->toArray();
     
        if(count($subject)>0)
        {
            return response()->json('subjectexist');
        }
        $results= DB::table('kelex_exams')
        ->where('EXAM_ID','=', $request->input('EXAM_ID'))
        ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->get()->toArray();
        //dd($results);
        if(count($results))
    {
        foreach($results as $result)
    {
        $dates = $this->twoDatesRange($result->START_DATE, $result->END_DATE);
        for($i=0;$i<count($dates);$i++)
        {
            if($dates[$i]==$request->DATE)
            {
            $matchdates+=1;
            }
        }
    }
    }
        if($matchdates>0)
    {   
        $data= Kelex_exam_paper::Where('PAPER_ID','=',$request->PAPER_ID)->update(['EXAM_ID'=>$request->EXAM_ID,'SECTION_ID'=>$request->SECTION_ID,'SUBJECT_ID'=>$request->SUBJECT_ID,'CLASS_ID'=>$request->CLASS_ID,'TIME'=>$request->TIME
        ,'DATE'=>$request->DATE,'TOTAL_MARKS'=>$request->TOTAL_MARKS,'PASSING_MARKS'=>$request->PASSING_MARKS,'VIVA'=>$request->VIVA,'VIVA_MARKS'=>$request->VIVA_MARKS,
        'SESSION_ID'=>$request->SESSION_ID,'CAMPUS_ID'=>Session::get('CAMPUS_ID'),'USER_ID'=>Auth::user()->id]);
        
        return response()->json(true);
     }

     return response()->json(false);


    }
   
    public function get_assign_exam_paper(ExamPaperRequest $request)
    {
    $status= Kelex_exam_assign::where('PAPER_ID',$request->PAPER_IDs)->where('CAMPUS_ID',Session::get('CAMPUS_ID'))->first();
// dd($status);
    return response()->json($status);
      
    }
    public function assign_exam_paper(Request $request)
    {
      //  dd($request->PAPER_ID);
       $status= Kelex_exam_assign::where('PAPER_ID',$request->PAPER_ID)->where('CAMPUS_ID',Session::get('CAMPUS_ID'))
       ->select('STATUS')->first();
     
       if($status!=null)
       {
       if($status['STATUS']=='2')
       {
        return response()->json(false);
       }
    }
   $Result= Kelex_exam_assign::updateOrCreate(
        ['PAPER_ID' => $request->PAPER_ID],
        ['PAPER_ID' => $request->PAPER_ID,
        'EMP_ID'=>$request->EMP_ID,
        'DUEDATE'=>$request->DUEDATE,
        'STATUS'=>'1',
        'CAMPUS_ID' => Session::get('CAMPUS_ID'),
        'USER_ID' =>Session::get('user_id'),
    ]);
    //dd($Result);

    
         return response()->json(true);
    }



// grade controller function start here

public function index_grade(Request $request)
{


    $getgrade = Kelex_grade::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
  
    return view('Admin.Examination.add_grades')->with('gGRADE',$getgrade);

}
public function add_grade(Kelex_grades $request)
{
    $matchmarks=0;
    $results= DB::table('kelex_grades')
    ->where('GRADE_ID','!=', $request->input('GRADE_ID'))
    ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->get()->toArray();
    if(count($results))
{
    foreach($results as $result){
    $requestmarks=range($request->FROM_MARKS,$request->TO_MARKS);
    if(count($requestmarks)==0)
    {
        return response()->json('wrongselect');
    }
    $marks = range($result->FROM_MARKS,$result->TO_MARKS);
    //dd($marks);
    for($i=0;$i<count($marks);$i++)
    {
        for($j=0;$j<count($requestmarks);$j++)
        {
        if($marks[$i]==$requestmarks[$j])
        {
        $matchmarks+=1;
        }
    }
    }
    }
}
    if($matchmarks==0)
    {
        $exKelex_grade = new Kelex_grade();
        $exKelex_grade->GRADE_NAME=$request->input('GRADE_NAME');
        $exKelex_grade->FROM_MARKS=$request->input('FROM_MARKS');
        $exKelex_grade->TO_MARKS=$request->input('TO_MARKS');
        $exKelex_grade->CAMPUS_ID= Auth::user()->CAMPUS_ID;
        $exKelex_grade->USER_ID = Auth::user()->id;
        $exKelex_grade->save();
       
      return response()->json(true);
    }
    else
    {
        return response()->json(false);
    }
     

}
public function edit_grade(Request $request)
{

    $currentSB= DB::table('kelex_grades')->where(['GRADE_ID' => $request->GRADE_ID])
    ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->get();
   echo json_encode($currentSB);

}

public function update_grade(Kelex_grades $request)
{

    $matchgrade=0;
    $results= DB::table('kelex_grades')
    ->where('GRADE_ID','!=', $request->input('GRADE_ID'))
    ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->get()->toArray();
    if(count($results))
{
    foreach($results as $result){
    $requestmarks= range($request->FROM_MARKS,$request->TO_MARKS);
    if(count($requestmarks)==0)
    {
        return response()->json('wrongselect');
    }
    $marks = range($result->FROM_MARKS,$result->TO_MARKS);
    for($i=0;$i<count($marks);$i++)
    {
        for($j=0;$j<count($requestmarks);$j++)
        {
        if($marks[$i]==$requestmarks[$j])
        {
        $matchgrade+=1;
        }
    }
    }
    }
}
    if($matchgrade==0)
    {
    DB::table('kelex_grades')
    ->where('GRADE_ID', $request->input('GRADE_ID'))
    ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
    ->update(['GRADE_NAME' => $request->input('GRADE_NAME'),
    'FROM_MARKS' => $request->input('FROM_MARKS'),
    'TO_MARKS' => $request->input('TO_MARKS')]);
      return response()->json(true);
    }
    else
    {
        return response()->json(false);
    }

}
public function index_result(Request $request)
{
    $class= Kelex_class::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
    $getexam = Kelex_exam::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
    $session = Kelex_sessionbatch::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
    $Subject = Kelex_subject::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
    return view('Admin.Examination.publish_result')->with(['gexam'=>$getexam,'subjects'=>$Subject,'sessions'=>$session,'classes'=>$class]);

}
public function ExamResult()
{
    $record =  DB::table('kelex_paper_marks')
    ->leftJoin('kelex_exams', 'kelex_exams.EXAM_ID', '=', 'kelex_paper_marks.EXAM_ID')
    ->leftJoin('kelex_exam_papers', 'kelex_paper_marks.PAPER_ID', '=', 'kelex_exam_papers.PAPER_ID')
    ->leftJoin('kelex_subjects', 'kelex_subjects.SUBJECT_ID', '=', 'kelex_paper_marks.SUBJECT_ID')
    ->where('kelex_paper_marks.STUDENT_ID', '=',Session::get('STUDENT_ID'))
    ->where('kelex_paper_marks.STATUS', '=','2')
    ->where('kelex_exam_papers.PUBLISHED', '=','2')
    ->where('kelex_exam_papers.CAMPUS_ID',Session::get('CAMPUS_ID'))
    ->select('kelex_paper_marks.*', 'kelex_exams.EXAM_NAME',
    'kelex_subjects.SUBJECT_NAME','kelex_exam_papers.*')
    ->groupBy('kelex_exam_papers.PAPER_ID')
    ->get()->toArray();
   // dd($record);
    $grade= DB::table('kelex_grades')->where('kelex_grades.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->get()->toArray();
     //dd($record);
return view('Admin.Examination.Exam_marks_student')->with(['record'=>$record,'grades'=>$grade]);

}
public function index_examrollno(){
    $class= Kelex_class::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
    $getexam = Kelex_exam::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
    $session = Kelex_sessionbatch::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
    return view('Admin.Examination.print_rollno')->with(['gexam'=>$getexam,'sessions'=>$session,'classes'=>$class]);
}

// Assign Paper to teacher for uploading paper controller start here


public function index_paperassign(Request $request)
{
    $paper= DB::table('kelex_paper_uploads')
    ->leftJoin('kelex_sections', 'kelex_sections.Section_id', '=', 'kelex_paper_uploads.SECTION_ID')
    ->leftJoin('kelex_employees', 'kelex_employees.EMP_ID', '=', 'kelex_paper_uploads.EMP_ID')
    ->leftJoin('kelex_classes', 'kelex_classes.Class_id', '=', 'kelex_paper_uploads.CLASS_ID')
    ->leftJoin('kelex_sessionbatches', 'kelex_sessionbatches.SB_ID', '=', 'kelex_paper_uploads.SESSION_ID')
    ->leftJoin('kelex_subjects', 'kelex_subjects.SUBJECT_ID', '=', 'kelex_paper_uploads.SUBJECT_ID')
    ->where('kelex_paper_uploads.CAMPUS_ID',Session::get('CAMPUS_ID'))
    ->select('kelex_employees.EMP_NAME', 'kelex_subjects.SUBJECT_NAME','kelex_paper_uploads.*',
    'kelex_sections.Section_name','kelex_classes.Class_name','kelex_sessionbatches.SB_NAME')->get();
    $class= Kelex_class::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
    $getexam = Kelex_exam::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
    $session = Kelex_sessionbatch::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
    $Subject = Kelex_subject::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
    $teacher= Kelex_employee::where('EMP_TYPE','1')->where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
    return view('Admin.Examination.index_paperassign')->with(['gexam'=>$getexam,'subjects'=>$Subject,'sessions'=>$session,'classes'=>$class,'teachers'=>$teacher,'papers'=>$paper]);

}

public function getpapersubject(Request $request)
{
    $record['record'] =  DB::table('kelex_exam_papers')
    ->leftJoin('kelex_subjects', 'kelex_subjects.SUBJECT_ID', '=', 'kelex_exam_papers.SUBJECT_ID')
    ->where('kelex_exam_papers.SECTION_ID', '=',$request->SECTION_ID)
    ->where('kelex_exam_papers.CLASS_ID', '=',$request->CLASS_ID)
    ->where('kelex_exam_papers.SESSION_ID', '=',$request->SESSION_ID)
    ->where('kelex_exam_papers.EXAM_ID', '=',$request->EXAM_ID)
    ->where('kelex_exam_papers.CAMPUS_ID',Session::get('CAMPUS_ID'))
    ->select('kelex_subjects.*','kelex_exam_papers.PAPER_ID')
    ->get()->toArray();
    return response()->json($record);
}

public function assign_paper_teacher(paper_uploadRequest $request)
    {
       // dd($request->all());
        $explode_id = array_map('intval', explode('.', $request->SUBJECT_ID));
        $SUBJECT_ID=$explode_id[0];
        $PAPER_ID=$explode_id[1];
       
       $status= Kelex_paper_upload::where('PAPER_ID',$PAPER_ID)->where('CAMPUS_ID',Session::get('CAMPUS_ID'))
       ->select('UPLOADSTATUS')->first();
     
       if($status!=null)
       {
       if($status['UPLOADSTATUS']=='2')
       {
        return response()->json(false);
       }
    }
    $EMP_ID=$request->EMP_ID;
    for($emp=0;$emp<count($EMP_ID);$emp++)
    {
   $Result= Kelex_paper_upload::updateOrCreate(
        ['PAPER_ID' => $PAPER_ID,'EMP_ID' => $EMP_ID[$emp]],
        ['PAPER_ID' => $PAPER_ID,
        'EMP_ID'=>$EMP_ID[$emp],
        'DUEDATE'=>$request->DUEDATE,
        'UPLOADSTATUS'=>'1','SESSION_ID'=>$request->SESSION_ID,'CLASS_ID'=>$request->CLASS_ID,
        'SUBJECT_ID'=>$request->SUBJECT_ID,
        'SECTION_ID'=>$request->SECTION_ID,
        'CAMPUS_ID' => Session::get('CAMPUS_ID'),
        'USER_ID' =>Session::get('user_id'),
    ]);
   }
    //dd($Result);

    
         return response()->json(true);
    }
    
    public function getDownload($UPLOADFILE)
{
    //PDF file is stored under project/public/download/info.pdf
    $image_path =public_path()."/upload/".Session::get('CAMPUS_ID').'/Paper'.'/'.$UPLOADFILE;
    return Response::download($image_path);
}
public function UploadPaperTeacher()
{
    $class= Kelex_class::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
    $getexam = Kelex_exam::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
    $session = Kelex_sessionbatch::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
    $Subject = Kelex_subject::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
    return view('Admin.Examination.paperupload_byteacher')->with(['gexam'=>$getexam,'subjects'=>$Subject,'sessions'=>$session,'classes'=>$class]);

}
public function need_to_upload(SaveTeacherUploadRequest $request)
{
    $paper= DB::table('kelex_paper_uploads')
    ->leftJoin('kelex_sections', 'kelex_sections.Section_id', '=', 'kelex_paper_uploads.SECTION_ID')
    ->leftJoin('kelex_classes', 'kelex_classes.Class_id', '=', 'kelex_paper_uploads.CLASS_ID')
    ->leftJoin('kelex_sessionbatches', 'kelex_sessionbatches.SB_ID', '=', 'kelex_paper_uploads.SESSION_ID')
    ->leftJoin('kelex_subjects', 'kelex_subjects.SUBJECT_ID', '=', 'kelex_paper_uploads.SUBJECT_ID')
    ->where('kelex_paper_uploads.SECTION_ID', '=',$request->SECTION_ID)
    ->where('kelex_paper_uploads.CLASS_ID', '=',$request->CLASS_ID)
    ->where('kelex_paper_uploads.SESSION_ID', '=',$request->SESSION_ID)
    ->where('kelex_paper_uploads.SUBJECT_ID', '=',$request->SUBJECT_ID)
    ->where('kelex_paper_uploads.CAMPUS_ID',Session::get('CAMPUS_ID'))
    ->where('kelex_paper_uploads.EMP_ID','=',Session::get('EMP_ID'))
    ->select('kelex_subjects.SUBJECT_NAME','kelex_paper_uploads.*',
    'kelex_sections.Section_name','kelex_classes.Class_name','kelex_sessionbatches.SB_NAME')->get();
    return response()->json($paper);
}
public function upload_paper(PaperUploadRequest $request)
{
    $uploadfile = $request->file('UPLOADFILE');
    $img=Kelex_paper_upload::where('PAPER_MARKING_ID',$request->PAPER_MARKING_ID)
                            ->where('CAMPUS_ID', Session::get('CAMPUS_ID'))->first();
    $my_image =$img['UPLOADFILE'];
    if(!empty($uploadfile)):
    $image_path =public_path()."/upload/".Session::get('CAMPUS_ID').'/Paper'.'/'.$my_image;   
    if(File::exists($image_path)) {  
    File::delete($image_path);
    }

    $my_uploadfile = rand() . '.' . $uploadfile->getClientOriginalExtension();
    $uploadfile->move(public_path('upload/'.Session::get('CAMPUS_ID').'/Paper'), $my_uploadfile);
    endif;

    DB::table('kelex_paper_uploads')
    ->where('PAPER_MARKING_ID', $request->input('PAPER_MARKING_ID'))
    ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
    ->update(['UPLOADSTATUS' => '2',
    'UPLOADFILE' => $my_uploadfile]);

    return response()->json(true);
}


}
