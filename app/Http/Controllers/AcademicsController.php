<?php

namespace App\Http\Controllers;

use \stdClass;
use App\Category;
use App\Models\Kelex_class;
use Illuminate\Http\Request;
use App\Models\Kelex_section;
use App\Models\Kelex_subject;
use App\Http\Requests\sbnrequest;
use App\Models\Kelex_sessionbatch;
use App\Models\Kelex_subjectgroup;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\classrequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\sectionrequest;
use App\Http\Requests\subjectrequest;
use App\Models\Kelex_students_session;
use App\Models\Kelex_subjectgroupname;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\subjectgrouprequest;
use App\Http\Requests\session_batchrequest;

class AcademicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //section controller function
    public function index_section(Request $request)
    {
        $data = DB::table('kelex_sections')
        ->leftJoin('kelex_classes', 'kelex_sections.Class_id', '=', 'kelex_classes.Class_id')
        ->where('kelex_sections.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
        ->select('kelex_sections.*', 'kelex_classes.Class_name')
        ->orderBy('kelex_sections.section_id', 'asc')
        ->get();

        $class= Kelex_class::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();

        return view('Admin.Academics.add_section')->with(['gsection'=>$data,'classes'=>$class]);

    }
    public function add_section(sectionrequest $request)
    {
        $section= new Kelex_section();
        $section-> Section_name=$request->input('Section_name');
        $section-> Class_id=$request->input('Classes_id');
        $section-> CAMPUS_ID= Auth::user()->CAMPUS_ID;
        $section-> USER_ID = Auth::user()->id;
        $section->save();

           $data = DB::table('kelex_sections')
            ->leftJoin('kelex_classes', 'kelex_sections.Class_id', '=', 'kelex_classes.Class_id')
            ->where('kelex_sections.Section_id', '=',$section->Section_id)
            ->where('kelex_sections.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
            ->select('kelex_sections.*', 'kelex_classes.Class_name')
            ->orderBy('kelex_sections.section_id', 'asc')
            ->get();

                 return response()->json($data);


    }
    public function edit_section(Request $request)
    {

        $currentsection= DB::table('kelex_sections')->where(['Section_id' => $request->sectionid])
        ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
        ->get();
       echo json_encode($currentsection);

    }
    public function update_section(sectionrequest $request)
    {
         DB::table('kelex_sections')
        ->where('Section_id', $request->input('sectionid'))
        ->update(['Section_Name' => $request->input('Section_name'),'Class_id' => $request->input('Classes_id')]);
        $data = DB::table('kelex_sections')
        ->leftJoin('kelex_classes', 'kelex_sections.Class_id', '=', 'kelex_classes.Class_id')
        ->where('kelex_sections.section_id', '=',$request->sectionid)
        ->where('kelex_sections.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
        ->select('kelex_sections.*', 'kelex_classes.Class_name')
        ->orderBy('kelex_sections.section_id', 'asc')
        ->get();

        return response()->json($data);
    }
    public function delete_section(Request $request)
    {
        $id=$request->input('sectionid');
        DB::table('kelex_sections')->where('Section_id',$id)
        ->where('kelex_sections.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->delete();

                 return response()->json($id);
            }

    //CLASS CONTROLLER ROUTES

        public function index_class(Request $request)
        {
            $getclass = Kelex_class::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();

                return view('Admin.Academics.add_class')->with('gclass',$getclass);

        }
        public function add_class(classrequest $request)
        {

                $class= new Kelex_class();
                $class->class_name=$request->input('class_name');
                $class->CAMPUS_ID= Auth::user()->CAMPUS_ID;
                $class->USER_ID = Auth::user()->id;
                if ($class->save()) {
                        return response()->json($class);
                }

        }
        public function edit_class(Request $request)
        {

            $currentclass= DB::table('kelex_classes')->where(['class_id' => $request->classid])
            ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
            ->get();
            echo json_encode($currentclass);

        }
        public function update_class(classrequest $request)
        {

            DB::table('kelex_classes')
            ->where('class_id', $request->input('classid'))
            ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
            ->update(['class_Name' => $request->input('class_name')]);

            $classhthis= DB::table('kelex_classes')->where('class_id',$request->input('classid'))
            ->where('kelex_sections.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
            ->get();

            return response()->json($classhthis);
        }
        public function delete_class(Request $request)
        {
            $id=$request->input('classid');
            DB::table('kelex_classes')->where('class_id',$request->input('classid'))
            ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->delete();

                        return response()->json($id);
        }

    //SUBJECT GROUP NAME controller function

    public function index_sgroup(Request $request)
    {
        $subjectgroup = Kelex_subjectgroupname::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();

            return view('Admin.Academics.add_groupname')->with('subjectgroup',$subjectgroup);

    }
    public function add_sgroup(sbnrequest $request)
    {

           $subject_group_name= new Kelex_subjectgroupname();
           $subject_group_name->GROUP_NAME=$request->input('GROUP_NAME');
           $subject_group_name->CAMPUS_ID= Auth::user()->CAMPUS_ID;
           $subject_group_name->USER_ID = Auth::user()->id;
           if ($subject_group_name->save()) {
                 return response()->json($subject_group_name);
            }

    }
    public function edit_sgroup(Request $request)
    {

        $currentSBG= DB::table('Kelex_subjectgroupnames')->where(['GROUP_ID' => $request->GROUP_ID])
        ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->get();
       echo json_encode($currentSBG);

    }
    public function update_sgroup(sbnrequest $request)
    {

         DB::table('Kelex_subjectgroupnames')
        ->where('GROUP_ID', $request->input('GROUP_ID'))
        ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
        ->update(['GROUP_NAME' => $request->input('GROUP_NAME')]);

        $SBNthis= DB::table('Kelex_subjectgroupnames')->where('GROUP_ID',$request->input('GROUP_ID'))
        ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
        ->get();

        return response()->json($SBNthis);
    }

    #Subject Group Controller Functions

    public function index_subjectgroup(Request $request)
    {
        $data['classes']= Kelex_class::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
        $subject= Kelex_subject::select('SUBJECT_ID','SUBJECT_NAME')
        ->where('CAMPUS_ID', Session::get('CAMPUS_ID'))->get()->toArray();
        foreach($subject as $row)
        {
            $subjects[$row['SUBJECT_ID']] = $row['SUBJECT_NAME'];
        }
        $data['subjects'] =  $subject;
        $data['subjectgroupnames'] = Kelex_subjectgroupname::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
        $data['sessions'] = Kelex_sessionbatch::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();

        $data['subjectgroup'] = [];
        $record =  DB::table('kelex_subjectgroups')
        ->leftJoin('kelex_subjectgroupnames', 'kelex_subjectgroups.GROUP_ID', '=', 'kelex_subjectgroupnames.GROUP_ID')
        ->leftJoin('kelex_sections', 'kelex_sections.Section_id', '=', 'kelex_subjectgroups.SECTION_ID')
        ->leftJoin('kelex_classes', 'kelex_classes.Class_id', '=', 'kelex_subjectgroups.CLASS_ID')
        ->leftJoin('kelex_sessionbatches', 'kelex_sessionbatches.SB_ID', '=', 'kelex_subjectgroups.SESSION_ID')
        ->where('kelex_subjectgroups.CAMPUS_ID','=', Session::get('CAMPUS_ID'))
        ->select('kelex_subjectgroups.id','kelex_subjectgroupnames.GROUP_NAME','kelex_subjectgroups.SECTION_ID',
        'kelex_subjectgroups.SUBJECT_ID','kelex_subjectgroups.CLASS_ID','kelex_subjectgroups.SESSION_ID',
        'kelex_sections.Section_name','kelex_classes.Class_name','kelex_sessionbatches.SB_NAME')
        ->groupBy('kelex_subjectgroups.SECTION_ID')
        ->get()->toArray();
   $record = json_decode(json_encode($record), true);
        
         $subjectArr = [];
        foreach($record as $key => $row):
                $subjectArr=  DB::table('kelex_subjectgroups')
                    ->leftJoin('kelex_sections', 'kelex_sections.Section_id', '=', 'kelex_subjectgroups.SECTION_ID')
                    ->leftJoin('kelex_classes', 'kelex_classes.Class_id', '=', 'kelex_subjectgroups.CLASS_ID')
                    ->leftJoin('kelex_subjects', 'kelex_subjects.SUBJECT_ID', '=', 'kelex_subjectgroups.SUBJECT_ID')
                    ->leftJoin('kelex_sessionbatches', 'kelex_sessionbatches.SB_ID', '=', 'kelex_subjectgroups.SESSION_ID')
                    ->where('kelex_subjectgroups.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
                    ->where('kelex_subjectgroups.SECTION_ID','=',$row['SECTION_ID'])
                    ->where('kelex_subjectgroups.CLASS_ID','=',$row['CLASS_ID'])
                    ->where('kelex_subjectgroups.SESSION_ID','=',$row['SESSION_ID'])
                    ->select('kelex_subjects.SUBJECT_NAME')
                    ->get()->toArray();

                $record[$key]['subjects'] =  implode("<br>",array_column($subjectArr,'SUBJECT_NAME'));
            ;
        endforeach;
        //dd($data);
        $data['subjectgroup'] = $record;
        return view('Admin.Academics.add_subject_group',$data);
    }


    public function add_subjectgroup(subjectgrouprequest $request)
    {
            $result= DB::table('kelex_subjectgroups')
            ->where('GROUP_ID','=', $request->input('GROUP_ID'))
            ->where('CLASS_ID','=', $request->input('CLASS_ID'))
            ->where('SECTION_ID','=',$request->input('SECTION_ID'))
            ->where('SESSION_ID','=',$request->input('SESSION_ID'))
            ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
            ->whereIn('SUBJECT_ID', $request->input('subjectgroup'))
            ->select('kelex_subjectgroups.SUBJECT_ID')
            ->get()->toArray();
            // dd($result);
        $check = [];
        if(count($result) == 0)
        {
             $check = $request->input('subjectgroup');
        }else{
            $subjectIDs = array_column($result,'SUBJECT_ID');
            $subject = $request->input('subjectgroup');

            $check = ($subjectIDs > $subject) ? array_diff($subjectIDs, $subject) : array_diff($subject, $subjectIDs);
            // dd ($subjectIDs, $subject,$check);

        }
        $check = array_values($check);
        if(empty($check)):
            return response()->json([false]);
        else:
            for ($i=0; $i < count($check); $i++):
                $subjectgroup= new Kelex_subjectgroup();
                $subjectgroup->GROUP_ID=$request->input('GROUP_ID');
                $subjectgroup->CLASS_ID=$request->input('CLASS_ID');
                $subjectgroup->SECTION_ID=$request->input('SECTION_ID');
                $subjectgroup->SUBJECT_ID=$check[$i];
                $subjectgroup->SESSION_ID=$request->input('SESSION_ID');
                $subjectgroup->CAMPUS_ID= Auth::user()->CAMPUS_ID;
                $subjectgroup->USER_ID = Auth::user()->id;
                $subjectgroup->save();
            endfor;
        endif;

        return response()->json(true);


    }
    public function edit_subjectgroup(Request $request)
    {

        $sessionGPdata= DB::table('kelex_subjectgroups')->where(['id' => $request->sessionGPID])
        ->where('kelex_subjectgroups.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
        ->first();


        $subjectgroups['EditSBdata']=$sessionGPdata;
       echo json_encode($subjectgroups);

    }
    public function update_subjectgroup(subjectgrouprequest $request)
    {
        $id=$request->input('id');
        $result= DB::table('kelex_subjectgroups')
        ->Where('id','!=',$id)
        ->where('SECTION_ID','=',$request->input('SECTION_ID'))
        ->where('CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
        ->select('kelex_subjectgroups.SUBJECT_ID')
        ->get()->toArray();
    $check = [];
    if(count($result) == 0)
    {
         $check = $request->input('subjectgroups');
    }else{
        $subjectIDs = array_column($result,'SUBJECT_ID');
        $subject = $request->input('subjectgroups');

        $check = ($subjectIDs > $subject) ? array_diff($subjectIDs, $subject) : array_diff($subject, $subjectIDs);
        // dd ($subjectIDs, $subject,$check);

    }

    $check = array_values($check);
    if(empty($check)||count($result)!=0):
        return response()->json([false]);
    else:
        for ($i=0; $i < count($check); $i++):
            $subjectgroup= Kelex_subjectgroup::find($id);
            $subjectgroup->GROUP_ID=$request->input('GROUP_ID');
            $subjectgroup->CLASS_ID=$request->input('CLASS_ID');
            $subjectgroup->SECTION_ID=$request->input('SECTION_ID');
            $subjectgroup->SUBJECT_ID=$check[$i];
            $subjectgroup->SESSION_ID=$request->input('SESSION_ID');
            $subjectgroup->CAMPUS_ID= Auth::user()->CAMPUS_ID;
            $subjectgroup->USER_ID = Auth::user()->id;
            $subjectgroup->save();
        endfor;
    endif;

    return response()->json(true);



    }

     #Subject Controller Functions

     public function index_subject(Request $request)
     {


         $getsubject = Kelex_subject::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();

             return view('Admin.Academics.add_subject')->with('gsubject',$getsubject);

     }
     public function add_subject(subjectrequest $request)
     {
            $campus=Session::get('CAMPUS');

            $subject= new Kelex_subject();
            $subject->SUBJECT_NAME=$request->input('subject_name');
            $subject->SUBJECT_CODE=$request->input('subject_code');
            if($campus->TYPE=='L_instuition'){
            $subject->TYPE='0';
            }
            else
            {
            $subject->TYPE='1';
            }

            $subject->CAMPUS_ID= Auth::user()->CAMPUS_ID;
            $subject->USER_ID = Auth::user()->id;
            if ($subject->save()) {
                  return response()->json($subject);
             }

     }
     public function edit_subject(Request $request)
     {

         $currentclass= DB::table('kelex_subjects')->where(['SUBJECT_ID' => $request->subjectid])
         ->where('kelex_subjects.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
         ->get();
        echo json_encode($currentclass);

     }
     public function update_subject(subjectrequest $request)
     {

          DB::table('kelex_subjects')
         ->where('SUBJECT_ID', $request->input('subject_id'))
         ->where('kelex_subjects.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
         ->update(['SUBJECT_NAME' => $request->input('subject_name'),
         'SUBJECT_CODE' => $request->input('subject_code')
         ]);

         $selectsubject= DB::table('kelex_subjects')->where('SUBJECT_ID',$request->input('subject_id'))
         ->get();

         return response()->json($selectsubject);
     }
     public function delete_subject(Request $request)
     {
         $id=$request->input('subjectid');
         DB::table('kelex_subjects')->where('SUBJECT_ID',$request->input('subjectid'))
         ->where('kelex_subjects.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->delete();

                  return response()->json($id);
     }

    #Session-batch Controller Functions
    public function index_sessionbatch(Request $request)
    {


        $getsession = Kelex_sessionbatch::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();

            return view('Admin.Academics.add_session_batch')->with('gsession',$getsession);

    }
    public function add_sessionbatch(session_batchrequest $request)
    {
           $sessionbatch = new Kelex_sessionbatch();
           $sessionbatch->SB_NAME=$request->input('sb_name');
           $sessionbatch->START_DATE=$request->input('start_date');
           $sessionbatch->END_DATE=$request->input('end_date');
           $sessionbatch->TYPE=$request->input('type');
           $sessionbatch->CAMPUS_ID= Auth::user()->CAMPUS_ID;
           $sessionbatch->USER_ID = Auth::user()->id;
           if ($sessionbatch->save()) {
                 return response()->json($sessionbatch);
            }

    }
    public function edit_sessionbatch(Request $request)
    {

        $currentSB= DB::table('kelex_sessionbatches')->where(['SB_ID' => $request->sessionid])
        ->where('kelex_sessionbatches.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->get();
       echo json_encode($currentSB);

    }
    public function update_sessionbatch(session_batchrequest $request)
    {

         DB::table('kelex_sessionbatches')
        ->where('SB_ID', $request->input('sb_id'))
        ->where('kelex_sessionbatches.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
        ->update(['SB_NAME' => $request->input('sb_name'),
        'START_DATE' => $request->input('start_date'),
        'END_DATE' => $request->input('end_date'),
        'TYPE' => $request->input('type')
        ]);

        $selectSB= DB::table('kelex_sessionbatches')->where('SB_ID',$request->input('sb_id'))
        ->where('kelex_sessionbatches.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
        ->get();

        return response()->json($selectSB);
    }
    public function delete_sessionbatch(Request $request)
    {
        $id=$request->input('sessionid');
        DB::table('kelex_sessionbatches')->where('SB_ID',$request->input('sessionid'))
        ->where('kelex_sessionbatches.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))->delete();

                 return response()->json($id);
    }


}

