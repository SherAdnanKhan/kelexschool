<?php

namespace App\Http\Controllers;

use DateTime;
use DatePeriod;
use DateInterval;
use Illuminate\Http\Request;
use App\Models\Kelex_employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelex_staff_attendance;
use App\Models\Kelex_staff_application;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\TeacherSearchRequest;
use App\Http\Requests\TeacherApplicationRequest;

class TeacherAttendanceController extends Controller
{

    public function Teacher_attendance()
    {
        return view("Admin.TeacherAttendance.tchr_Attendance_view");
    }


    public function get_tchrall_for_attendance(TeacherSearchRequest $request)
    {
        $update = null;
        $date = date('Y-m-d',strtotime($request->alldate));
        $campus_id = Auth::user()->CAMPUS_ID;
        $check = DB::table('kelex_staff_attendances')
                        ->where(['CAMPUS_ID'=> $campus_id,'ATTEN_DATE' => $date])
                        ->get()->toArray();
        if(count($check)>0):
        $record=DB::table('kelex_staff_attendances')
        ->leftJoin('kelex_employees', 'kelex_employees.EMP_ID', '=', 'kelex_staff_attendances.EMP_ID')
        ->where('kelex_staff_attendances.CAMPUS_ID', '=',Session::get('CAMPUS_ID'))
        ->where('kelex_staff_attendances.ATTEN_DATE' ,'=', $date)
         ->select('kelex_employees.*','kelex_staff_attendances.ATTEN_STATUS','kelex_staff_attendances.TCHR_ATTENDANCE_ID')
        ->get()->toArray();
        $data['update'] = 1;
        $data['record'] = $record;
        else:
         $record=DB::table('kelex_employees')->
         where('CAMPUS_ID','=',Session::get('CAMPUS_ID'))->get()->toArray();
         $data['update'] = 0;
         $data['record'] = $record;
        endif;
        return response()->json($data);

    }
    public function save_teachers_attendance(Request $request)
    {
       $teachers_id = $request->teachersid;
       $attendance = $request->atten_status;
       $remarks = $request->remarks;
       $campus_id = Auth::user()->CAMPUS_ID;
       $userid =  Auth::user()->id;
       $update = $request->update;
       $attendance_ids = $request->attendance_ids;
       for ($i=0; $i <count($teachers_id) ; $i++) { 
           $data = [
               'EMP_ID' => $teachers_id[$i],
               'ATTEN_STATUS' => $attendance[$i],
               'REMARKS' => $remarks[$i],
               'ATTEN_DATE' => date('Y-m-d',strtotime($request->date)),
               'CAMPUS_ID' => $campus_id,
               'USER_ID' =>$userid,
           ];
        //    $where = [
               
        //    ];
       

           if($update == 0):
                Kelex_staff_attendance::create($data);
           else:
                $where = [
                    'TCHR_ATTENDANCE_ID' => $attendance_ids[$i],
                ];
                Kelex_staff_attendance::where($where)->update($data);
           endif;
           
       }
       return ['status'=> 'Teacher Attendance record Saved Successfully'];
    }

    public function TeacherApplication(Request $request)
    {
        return view('Admin.TeacherAttendance.teacher_application');
    }
    public function AddApplication(TeacherApplicationRequest $request)
    {
        $matchdates=0;
        $results= Kelex_staff_application::where('CAMPUS_ID', Session::get('CAMPUS_ID'))->
        where('EMP_ID',Session::get('EMP_ID'))->get()->toArray();
        if(count($results))
        {
        foreach($results as $result){

        $requestdates=$this->twoDatesRange($request->START_DATE, $request->END_DATE);
        $dates = $this->twoDatesRange($result['START_DATE'], $result['END_DATE']);
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
           Kelex_staff_application::create(['EMP_ID'=>Session::get('EMP_ID'),'APPLICATION_STATUS'=>'0',
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
        $application=Kelex_staff_application::where('EMP_ID',Session::get('EMP_ID'))->
        where('CAMPUS_ID', Session::get('CAMPUS_ID'))->get();
    
        return view('Admin.TeacherAttendance.view_application_teacher')->with('application',$application);
    
    }


    public function ViewApplicationbyadmin(Request $request)
    {
        // $dates = $this->twoDatesRange('2020-04-04', '2020-04-06'); dd($dates);
    
        $todayapplicationlog=Kelex_staff_application::orderBy('START_DATE', 'ASC')->get();
            
        $application=Kelex_staff_application::where('APPLICATION_STATUS',"0")->
        where('CAMPUS_ID', Session::get('CAMPUS_ID'))->get();
        return view('Admin.TeacherAttendance.check_application_admin')->with(['applications'=>$application,'todayapplog'=>$todayapplicationlog]);
    
    }
    public function actionApplicationbyadmin(Request $request)
    {
     
        $application=Kelex_staff_application::where('APPLICATION_STATUS',"0")->
        where('STAFF_APP_ID',$request->STAFF_APP_ID)
        ->where('CAMPUS_ID', Session::get('CAMPUS_ID'))->get();
        if(count($application)!=='0'){
       $result= Kelex_staff_application::find($request->STAFF_APP_ID);
       $result->APPLICATION_STATUS= $request->APPLICATION_STATUS;
       $result->APPROVED_AT=date('Y-m-d');
       $result->USER_ID = Session::get('user_id');
       $result->save();
        if($request->APPLICATION_STATUS='1')
        {
        $dates = $this->twoDatesRange($result->START_DATE, $result->END_DATE);
        $currentemployee= Kelex_employee::where('EMP_ID',$request->EMP_ID)
        ->where('CAMPUS_ID', Session::get('CAMPUS_ID'))->first();
        for($i=0;$i<count($dates);$i++)
        {
            Kelex_staff_attendance::firstOrCreate(
                ['EMP_ID' => $currentemployee->EMP_ID, 'ATTEN_DATE' => date('Y-m-d',strtotime($dates[$i]))],
                ['EMP_ID' => $currentemployee->EMP_ID,
                'ATTEN_STATUS' => $result->APPLICATION_TYPE,
                'REMARKS' => "decided by application",
                'ATTEN_DATE' => date('Y-m-d',strtotime($dates[$i])),
                'CAMPUS_ID' => Session::get('CAMPUS_ID'),
                'USER_ID' =>Session::get('user_id'),]);
    
    
         }
        }
        return response()->json(true);
        }
    
        return response()->json(false);
    
    
    
    }
    
    function twoDatesRange($start, $end, $format = 'Y-m-d') {
        $arr = array();
        $interval = new DateInterval('P1D');
    
        $realEnd = new DateTime($end);
        $realEnd->add($interval);
    
        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);
    
        foreach($period as $date) { 
            $arr[] = $date->format($format); 
        }
    
        return $arr;
    }
}