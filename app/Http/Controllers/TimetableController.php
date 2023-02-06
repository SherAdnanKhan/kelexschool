<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\Kelex_class;
use Illuminate\Http\Request;
use App\Models\Kelex_timetable;
use App\Services\CalendarService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelex_subjectgroupname;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\SavetimetableRequest;
use App\Services\CalendarServiceForStudent;
use App\Services\CalendarServiceForTeacher;
use App\Http\Requests\SearchtimetableRequest;

class TimetableController extends Controller
{
    public function index(){
        $campus_id = Auth::user()->CAMPUS_ID;
        $class= Kelex_class::where('CAMPUS_ID',$campus_id)->get();
        $Kelex_subjectgroupname= Kelex_subjectgroupname::where('CAMPUS_ID',$campus_id)->get();
        // dd($class);
        return view("Admin.Academics.add-timetable")->with(['classes'=>$class,'subjectgroups'=>$Kelex_subjectgroupname]);
    
    }
    public function Searchtimetable(SearchtimetableRequest $request){
        // dd($request->all());
        $data['subject'] = DB::table('kelex_subjectgroups')
        ->leftJoin('kelex_sections', 'kelex_subjectgroups.SECTION_ID', '=', 'kelex_sections.Section_id')
        ->leftJoin('kelex_classes', 'kelex_subjectgroups.CLASS_ID', '=', 'kelex_classes.Class_id')
        ->leftJoin('kelex_subjects', 'kelex_subjects.SUBJECT_ID', '=', 'kelex_subjectgroups.SUBJECT_ID')
        ->where('kelex_subjectgroups.SECTION_ID', '=',$request->SECTION_ID)
        ->where('kelex_subjectgroups.CLASS_ID', '=',$request->CLASS_ID)
        ->where('kelex_subjectgroups.GROUP_ID', '=',$request->GROUP_ID)
        ->where('kelex_sections.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
        ->select('kelex_sections.Section_name', 'kelex_classes.Class_name','kelex_subjectgroups.*' ,'kelex_subjects.SUBJECT_NAME')
        ->orderBy('kelex_sections.section_id', 'asc')
        ->get()->toArray();
        $data['timetable']= $data['teacher']=DB::table('kelex_timetables')->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
        ->where('SECTION_ID', '=',$request->SECTION_ID)
        ->where('CLASS_ID', '=',$request->CLASS_ID)
        ->where('GROUP_ID', '=',$request->GROUP_ID)
        ->where('DAY', '=',$request->day)
        ->get()->toArray();
        $data['teacher']=DB::table('kelex_employees')->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->where('EMP_TYPE', '=', '1')->get()->toArray();
        $data['SECTION_ID']=$request->SECTION_ID;
        $data['CLASS_ID']=$request->CLASS_ID;
        $data['GROUP_ID']=$request->GROUP_ID;
        $data['DAY']=$request->day;
      
        return response()->json($data);
    
    }
    public function Savetimetable(SavetimetableRequest $request){
     // dd($request->all());
     DB::enableQueryLog();
     $date1 = $request->TIMEFROM;
     $DAY= $request->DAY;
     $GROUP_ID= $request->GROUP_ID;
     $SECTION_ID= $request->SECTION_ID;
      for($j=0;$j<count($date1);$j++){
      if(isset($request->TIMETABLE_ID[$j])){

        $result[$j]=  Kelex_timetable::where('DAY',$request->DAY)->where('TIMETABLE_ID','!=', $request->TIMETABLE_ID[$j])
        ->where('CAMPUS_ID', Session::get('CAMPUS_ID'))
        ->where('GROUP_ID', $request->GROUP_ID)
        ->where('SECTION_ID', $request->SECTION_ID)
        ->whereTime(
         'TIMEFROM', '<=',Carbon::parse($request->TIMETO[$j])->addMinutes(1)->format('H:i:s')
         
       ) ->whereTime(
        'TIMETO', '>=',Carbon::parse($request->TIMEFROM[$j])->addMinutes(1)->format('H:i:s')
        
      )->count();
        }
     else{
       $result[$j]= Kelex_timetable::where('DAY',$request->DAY)
       ->where('CAMPUS_ID', Session::get('CAMPUS_ID'))
       ->where('GROUP_ID', $request->GROUP_ID)
       ->where('SECTION_ID', $request->SECTION_ID)
       ->whereTime(
        'TIMEFROM', '<=',Carbon::parse($request->TIMETO[$j])->format('H:i:s')
        
      ) ->whereTime(
       'TIMETO', '>=',Carbon::parse($request->TIMEFROM[$j])->format('H:i:s')
       
     )->count();
    }
  }
 //dd($result);
     //  dd(DB::getQueryLog());
      for($res=0;$res<count($result);$res++){
       if($result[$res]>0)
       {
        return response()->json(false);
       }
      }
    //     $date1 = $request->TIMEFROM;
    //     for($j=0;$j<count($date1);$j++)
    //     {
    //     for($i=0;$i<count($result);$i++)
    //     {
    //     //  dump($request->TIMEFROM[$j] && $result[$i]->TIMETO <=  $request->TIMETO[$j]);
    //      // dd($result[$i]->TIMEFROM >= $request->TIMEFROM[$j] && $result[$i]->TIMEFROM);
    //     if ($result[$i]->TIMEFROM >= $request->TIMEFROM[$j] && $result[$i]->TIMEFROM <=  $request->TIMETO[$j] || $result[$i]->TIMETO >= $request->TIMEFROM[$j] && $result[$i]->TIMETO <=  $request->TIMETO[$j]) {
             
    //       return response()->json(false);
    //     }

    //     }   
    //    }
    // }

       $EMP_ID=$request->EMP_ID;
       $SUBJECT_ID=$request->SUBJECT_ID;
       $TIMEFROM=$request->TIMEFROM;
       $TIMETO=$request->TIMETO;
   
       for($i=0;$i<count($SUBJECT_ID);$i++){
      if(isset($request->TIMETABLE_ID[$i]))
      {
       Kelex_timetable::updateOrCreate(
        ['TIMETABLE_ID'=>$request->TIMETABLE_ID[$i]],
        ['EMP_ID'=>$EMP_ID[$i],'GROUP_ID'=>$request->GROUP_ID,'CLASS_ID'=>$request->CLASS_ID,
       'SECTION_ID'=>$request->SECTION_ID,'SUBJECT_ID'=>$SUBJECT_ID[$i],'DAY'=>$request->DAY,'TIMEFROM'=> Carbon::parse($TIMEFROM[$i])->format('H:i'),
       'TIMETO'=>Carbon::parse($TIMETO[$i])->format('H:i'),'CAMPUS_ID'=>Auth::user()->CAMPUS_ID,'USER_ID'=>Auth::user()->id]);
        }
        else
      {
      $king=  Kelex_timetable::Create(['EMP_ID'=>$EMP_ID[$i],'GROUP_ID'=>$request->GROUP_ID,'CLASS_ID'=>$request->CLASS_ID,
         'SECTION_ID'=>$request->SECTION_ID,'SUBJECT_ID'=>$SUBJECT_ID[$i],'DAY'=>$request->DAY,'TIMEFROM'=> Carbon::parse($TIMEFROM[$i])->format('H:i'),
         'TIMETO'=>Carbon::parse($TIMETO[$i])->format('H:i'),'CAMPUS_ID'=>Auth::user()->CAMPUS_ID,'USER_ID'=>Auth::user()->id]);
        }
      
       // all good
   } 
  // dd($king);
       return response()->json(true);
    
    }
    public function deletetimetable(Request $request)
    {
      $result=  DB::table('kelex_timetables')->where('TIMETABLE_ID',$request->T_ID)
        ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->delete();
                 return response()->json(true);
            }

      public function searchingtimetable(){
        $campus_id = Auth::user()->CAMPUS_ID;
        $class= Kelex_class::where('CAMPUS_ID',$campus_id)->get();
        $Kelex_subjectgroupname= Kelex_subjectgroupname::where('CAMPUS_ID',$campus_id)->get();
        // dd($class);
        return view("Admin.Academics.search-timetable")->with(['classes'=>$class,'subjectgroups'=>$Kelex_subjectgroupname]);
    
    }
    public function showtimetable(CalendarService $calendarService,Request $request)
    {
      $data['WEEK_DAYS'] = [
        '1' => 'Monday',
        '2' => 'Tuesday',
        '3' => 'Wednesday',
        '4' => 'Thursday',
        '5' => 'Friday',
        '6' => 'Saturday',
        '7' => 'Sunday',
    ];
   $data['calendarData'] = $calendarService->generateCalendarData($data['WEEK_DAYS'] ,$request);
     
     // dd($data);
      return response()->json($data);
                      
    }     
    public function showtimetableStudent(CalendarServiceForStudent $calendarService)
    {
      $WEEK_DAYS = [
        '1' => 'Monday',
        '2' => 'Tuesday',
        '3' => 'Wednesday',
        '4' => 'Thursday',
        '5' => 'Friday',
        '6' => 'Saturday',
        '7' => 'Sunday',
    ];
   $calendarData = $calendarService->generateCalendarData($WEEK_DAYS,Session::get('STUDENT_ID'));
     
    return view("Admin.Academics.show_timetable_student")->with(['WEEK_DAYS'=>$WEEK_DAYS,'calendarData'=>$calendarData]);
                     
    }    
    public function showtimetableTeacher(CalendarServiceForTeacher $calendarService)
    {
      $WEEK_DAYS = [
        '1' => 'Monday',
        '2' => 'Tuesday',
        '3' => 'Wednesday',
        '4' => 'Thursday',
        '5' => 'Friday',
        '6' => 'Saturday',
        '7' => 'Sunday',
    ];
   $calendarData = $calendarService->generateCalendarData($WEEK_DAYS ,Session::get('EMP_ID'));
     
     return view("Admin.Academics.show_timetable_teacher")->with(['WEEK_DAYS'=>$WEEK_DAYS,'calendarData'=>$calendarData]);
                      
    }      

}
