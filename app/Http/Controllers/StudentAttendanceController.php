<?php

namespace App\Http\Controllers;
use DateTime;
use DatePeriod;
use DateInterval;
use App\Models\Kelex_class;
use Illuminate\Http\Request;
use App\Models\Kelex_section;
use App\Models\Kelex_sessionbatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelex_students_session;
use Illuminate\Support\Facades\Session;
use App\Models\Kelex_student_attendance;
use App\Models\Kelex_student_application;
use App\Http\Requests\StudentApplicationRequest;

class StudentAttendanceController extends Controller
{
    public function student_attendance()
    {

        $campus_id = Auth::user()->CAMPUS_ID;
        $class= Kelex_class::where('CAMPUS_ID',$campus_id)->get();
        $section= Kelex_section::where('CAMPUS_ID',$campus_id)->get();
        $session= Kelex_sessionbatch::where('CAMPUS_ID',$campus_id)->get();
        // dd($class);
        return view("Admin.StudentsAttendance.std_attendance_view")->with(['classes'=>$class,'sections'=>$section,'sessions'=>$session]);
    }
    public function get_stds_for_attendance(Request $request)
    {
        $update = null; 
        $sectionID = $request->section_id;
        $classID = $request->class_id;
        $sessionID = $request->session_id;
        $date = date('Y-m-d',strtotime($request->date));
        $campus_id = Auth::user()->CAMPUS_ID;
        $check = DB::table('kelex_student_attendances')
                        ->where('CLASS_ID','=', $classID)
                        ->where('SECTION_ID' ,'=',$sectionID)
                        ->where('SESSION_ID','=',$sessionID)
                        ->where('CAMPUS_ID','=', $campus_id)
                        ->where('ATTEN_DATE' ,'=', $date)
                        ->get()->toArray();
        if(count($check)>0):
            $record = DB::table('kelex_student_attendances')
            ->leftJoin('kelex_students', 'kelex_students.STUDENT_ID', '=', 'kelex_student_attendances.STD_ID')
            ->leftJoin('kelex_students_sessions', 'kelex_students_sessions.STUDENT_ID', '=', 'kelex_students.STUDENT_ID')
            ->where('kelex_student_attendances.SECTION_ID', '=',$sectionID)
            ->where('kelex_student_attendances.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
            ->where('kelex_student_attendances.CLASS_ID', '=',$classID)
            ->where('kelex_student_attendances.ATTEN_DATE', '=',$date)
            ->select('kelex_students.*','kelex_student_attendances.ATTEN_STATUS','kelex_student_attendances.STD_ATTENDANCE_ID')
            ->get()->toArray();
            $data['update'] = 1;
            $data['record'] = $record;
        else:
            $record = DB::table('kelex_students')
            ->leftJoin('kelex_students_sessions', 'kelex_students_sessions.STUDENT_ID', '=', 'kelex_students.STUDENT_ID')
            ->where('kelex_students_sessions.SECTION_ID', '=',$sectionID)
            ->where('kelex_students_sessions.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
            ->where('kelex_students_sessions.CLASS_ID', '=',$classID)
            ->where('kelex_students_sessions.SESSION_ID', '=', $sessionID)
            ->select('kelex_students.*')
            ->get()->toArray();
            $data['update'] = 0;
            $data['record'] = $record;
         endif;
        return $data;
    }

    public function save_students_attendance(Request $request)
    {

       $student_ids = $request->student_ids;
       $attendance = $request->atten_status;
       $remarks = $request->remarks;
       $campus_id = Auth::user()->CAMPUS_ID;
       $userid =  Auth::user()->id;
       $update = $request->update;
       $attendance_ids = $request->attendance_ids;
       for ($i=0; $i <count($student_ids) ; $i++) {
           $data = [
               'STD_ID' => $student_ids[$i],
               'ATTEN_STATUS' => $attendance[$i],
               'REMARKS' => $remarks[$i],
               'ATTEN_DATE' => date('Y-m-d',strtotime($request->date)),
               'CLASS_ID' => $request->class_id,
               'SECTION_ID' => $request->section_id,
               'SESSION_ID' => $request->session_id,
               'CAMPUS_ID' => $campus_id,
               'USER_ID' =>$userid,
           ];
        //    $where = [

        //    ];

           if($update == 0):
                Kelex_student_attendance::create($data);
           else:
                $where = [
                    'STD_ATTENDANCE_ID' => $attendance_ids[$i],
                ];
                Kelex_student_attendance::where($where)->update($data);
           endif;

       }
       return ['status'=> 'Students Attendance record Saved Successfully'];
    }

    public function non_present_students()
    {
        $campus_id = Auth::user()->CAMPUS_ID;
        $class= Kelex_class::where('CAMPUS_ID',$campus_id)->get();
        $section= kelex_section::where('CAMPUS_ID',$campus_id)->get();
        $session= Kelex_sessionbatch::where('CAMPUS_ID',$campus_id)->get();
        // dd($class);
        return view("Admin.StudentsAttendance.non_present_students")->with(['classes'=>$class,'sections'=>$section,'sessions'=>$session]);
    }
    public function getNonPresentStudents(Request $request)
    {
        // dd($request->all());
        $sectionID = $request->section_id;
        $classID = $request->class_id;
        $sessionID = $request->session_id;
        $fromdate = date('Y-m-d',strtotime($request->fromdate));
        $todate = date('Y-m-d',strtotime($request->todate));
        $campus_id = Auth::user()->CAMPUS_ID;
            $record = DB::table('kelex_student_attendances')
            ->join('kelex_students', 'kelex_students.STUDENT_ID', '=', 'kelex_student_attendances.STD_ID')
            ->join('kelex_students_sessions', 'kelex_students_sessions.STUDENT_ID', '=', 'kelex_students.STUDENT_ID')
            ->join('kelex_sections', 'kelex_sections.Section_id', '=', 'kelex_students_sessions.SECTION_ID')
            ->join('kelex_classes', 'kelex_classes.Class_id', '=', 'kelex_students_sessions.CLASS_ID')
            ->where('kelex_students_sessions.SECTION_ID', '=',$sectionID)
            ->where('kelex_students_sessions.CLASS_ID', '=',$sessionID)
            ->where('kelex_students_sessions.SESSION_ID', '=',$sessionID)
            ->where('kelex_students_sessions.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
            ->where('kelex_student_attendances.ATTEN_STATUS', '=','A')
            ->whereBetween('kelex_student_attendances.ATTEN_DATE', [$fromdate,$todate])
            ->select('kelex_students.STUDENT_ID','kelex_students.REG_NO','kelex_students.NAME','kelex_students.NAME','kelex_students.FATHER_NAME','kelex_classes.Class_name','kelex_sections.Section_name','kelex_student_attendances.ATTEN_STATUS','kelex_student_attendances.STD_ATTENDANCE_ID')
            ->get()
            ->toArray();
            return $record;
    }
//Student Application start here
    public function StudentApplication(Request $request)
{
    return view('Admin.StudentsAttendance.student_application');
}
public function AddApplication(StudentApplicationRequest $request)
{
    $matchdates=0;
    $results= Kelex_student_application::where('CAMPUS_ID', Session::get('CAMPUS_ID'))->
    where('STUDENT_ID',Session::get('STUDENT_ID'))->get()->toArray();
    // dd($result-);
    if(count($results))
    {
    foreach($results as $result){
    $requestdates=$this->twoDatesRange($request->START_DATE, $request->END_DATE);
    $dates = $this->twoDatesRange($result['START_DATE'], $result['END_DATE']);
    for($i=0;$i<count($dates);$i++)
    {
        for($j=0;$j<count($requestdates);$j++)
        {
        if($dates[$i]==$requestdates[$j] && $result['APPLICATION_STATUS']!=='2')
        {
        $matchdates+=1;
        }
    }
    }
    }
}
    if($matchdates==0)
    {
       Kelex_student_application::create(['STUDENT_ID'=>Session::get('STUDENT_ID'),'APPLICATION_STATUS'=>'0',
      'APPLICATION_DESCRIPTION'=>$request->APPLICATION_DESCRIPTION,'APPLICATION_TYPE'=>$request->APPLICATION_TYPE,
      'START_DATE'=>$request->START_DATE,'END_DATE'=>$request->END_DATE,'CAMPUS_ID'=>Session::get('CAMPUS_ID')]);
      return response()->json(true);
    }
    else
    {
        return response()->json(false);
    }

}
public function ViewApplication(Request $request)
{
    $application=Kelex_student_application::where('STUDENT_ID',Session::get('STUDENT_ID'))->
    where('CAMPUS_ID', Session::get('CAMPUS_ID'))->get();

    return view('Admin.StudentsAttendance.view_application_student')->with('application',$application);

}
public function ViewApplicationbyadmin(Request $request)
{
    // dd($this->twoDatesRange('2020-01-01','2020-02-07'));
    $application=Kelex_student_application::where('APPLICATION_STATUS',null)->get();


    $todayapplicationlog=Kelex_student_application::orderBy('START_DATE', 'ASC')->get();

    $application=Kelex_student_application::where('APPLICATION_STATUS',"0")->
    where('CAMPUS_ID', Session::get('CAMPUS_ID'))->get();
    return view('Admin.StudentsAttendance.check_application_admin')->with(['applications'=>$application,'todayapplog'=>$todayapplicationlog]);

}
public function actionApplicationbyadmin(Request $request)
{


    $application=Kelex_student_application::where('APPLICATION_STATUS',"0")->
    where('STD_APPLICATION_ID',$request->STD_APPLICATION_ID)
    ->where('CAMPUS_ID', Session::get('CAMPUS_ID'))->get();
    if(count($application)!=="0"){
   $result= Kelex_student_application::find($request->STD_APPLICATION_ID);
   $result->APPLICATION_STATUS= $request->APPLICATION_STATUS;
   $result->APPROVED_AT=date('Y-m-d');
   $result->USER_ID = Session::get('user_id');
   $result->save();
    if($request->APPLICATION_STATUS='1')
    {
    $dates = $this->twoDatesRange($result->START_DATE, $result->END_DATE);
    $currentstudent= Kelex_students_session::where('STUDENT_ID',$request->studentid)
    ->where('CAMPUS_ID', Session::get('CAMPUS_ID'))->first();
    for($i=0;$i<count($dates);$i++)
    {
            Kelex_student_attendance::firstOrCreate(
            ['STD_ID' => $currentstudent->STUDENT_ID, 'ATTEN_DATE' => date('Y-m-d',strtotime($dates[$i]))],
            ['STD_ID' => $currentstudent->STUDENT_ID,
            'ATTEN_STATUS' => $result->APPLICATION_TYPE,
            'REMARKS' => "decided by application",
            'ATTEN_DATE' => date('Y-m-d',strtotime($dates[$i])),
            'CLASS_ID' => $currentstudent->CLASS_ID,
            'SECTION_ID' => $currentstudent->SECTION_ID,
            'SESSION_ID' => $currentstudent->SESSION_ID,
            'CAMPUS_ID' => Session::get('CAMPUS_ID'),
            'USER_ID' =>Session::get('user_id'),
        ]);


    }
}

    return response()->json(true);
    }

    return response()->json(false);



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

}
