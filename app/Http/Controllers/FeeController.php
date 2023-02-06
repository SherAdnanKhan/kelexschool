<?php

namespace App\Http\Controllers;

use KelexClass;
use App\Models\Kelex_fee;
use App\Models\Kelex_bank;
use App\Models\Kelex_class;
use App\Models\Kelex_month;
use App\Traits\SmsAPItrait;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\kelex_section;
use App\Models\Kelex_student;
use App\Models\Kelex_fee_type;
use App\Models\General_setting;
use App\Models\Kelex_student_fee;
use App\Models\Kelex_fee_category;
use App\Models\Kelex_fee_discount;
use App\Models\Kelex_sessionbatch;
use App\Models\Kelex_student_dues;
use App\Models\KelexFee_structure;
use Illuminate\Support\Facades\DB;
use App\Models\Kelex_fee_collection;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\FeetypeRequest;
use App\Models\Kelex_students_session;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\FeeCategoryRequest;
use App\Http\Requests\reg_feeRequest;
use App\Models\Kelex_oreg_fee;
use App\Traits\NumberFormater;

class FeeController extends Controller
{
    use SmsAPItrait,NumberFormater;
    public function __construct()
    {
       //echo  $this->numberFormat('3339229095'); die;
    }
// FEE CATEROGORY CONTROLLER START HERE
    public function index_feecategory()
    {

        $getfeecat = DB::table('kelex_fee_categories')
                                // ->join('kelex_sections', 'kelex_sections.Section_id', '=', 'kelex_fee_categories.SECTION_ID')
                                // ->join('kelex_classes', 'kelex_classes.Class_id', '=', 'kelex_fee_categories.CLASS_ID')
                                // ->select('kelex_fee_categories.*','kelex_classes.*','kelex_sections.*')
                                ->where('kelex_fee_categories.CAMPUS_ID','=',Session::get('CAMPUS_ID'))
                                -> orderBy('FEE_CAT_ID', 'desc')
                                ->get()->toArray();
        // $class= Kelex_class::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
        $data = ['getfeecat'=>$getfeecat];
        return view('Admin.FeesManagement.add_feecaterogry')->with($data);

    }
    public function add_feecategory(FeeCategoryRequest $request)
    {
        // dd($request);
           $feecategory = new Kelex_fee_category();
           $feecategory->CLASS_ID=$request->input('CLASS_ID');
           $feecategory->SECTION_ID=$request->input('SECTION_ID');
           $feecategory->SHIFT=$request->input('SHIFT');
           $feecategory->CATEGORY=$request->input('CATEGORY');
           $feecategory->CAMPUS_ID= Session::get('CAMPUS_ID');
           $feecategory->USER_ID = Auth::user()->id;
           if ($feecategory->save()) {
                 return response()->json($feecategory);
            }

    }

    public function get_fee_categories(Request $request)
    {
        // dd($request->all());
        $getfeecat = DB::table('kelex_fee_categories')
                    ->join('kelex_sections', 'kelex_sections.Section_id', '=', 'kelex_fee_categories.SECTION_ID')
                    ->join('kelex_classes', 'kelex_classes.Class_id', '=', 'kelex_fee_categories.CLASS_ID')
                    ->where('kelex_fee_categories.SECTION_ID','=',$request->section_id)
                    ->where('kelex_fee_categories.CLASS_ID','=',$request->class_id)
                    ->where('kelex_fee_categories.CAMPUS_ID','=',Session::get('CAMPUS_ID'))
                    ->select('FEE_CAT_ID','CATEGORY')
                    ->get()->toArray();
        return  $getfeecat;
    }

    public function edit_feecategory(Request $request)
    {

        $currentFC['record']= DB::table('kelex_fee_categories')->where(['FEE_CAT_ID' => $request->feecatid])
        ->where('CAMPUS_ID','=',Session::get('CAMPUS_ID'))
        ->get();
        $fetchcid= $currentFC['record'][0]->CLASS_ID;
        $fetchsid= $currentFC['record'][0]->SECTION_ID;
        $currentFC['classes']= Kelex_class::all();
        $currentFC['sections']= kelex_section::where('Section_id',$fetchsid)
        ->where('CAMPUS_ID','=',Session::get('CAMPUS_ID'))->
        select('Section_id','Section_name')->first();
       echo json_encode($currentFC);

    }
    public function update_feecategory(FeeCategoryRequest $request)
    {

         DB::table('kelex_fee_categories')
        ->where('FEE_CAT_ID', $request->input('FEE_CAT_ID'))
        ->where('CAMPUS_ID','=',Session::get('CAMPUS_ID'))->
        update([
        'SECTION_ID' => $request->input('SECTION_ID'),
        'SHIFT' => $request->input('SHIFT'),
        'CATEGORY' => $request->input('CATEGORY')
        ]);

        $selectFC= DB::table('kelex_fee_categories')->where('FEE_CAT_ID',$request->input('FEE_CAT_ID'))->
        where('CAMPUS_ID','=',Session::get('CAMPUS_ID'))
        ->get();

        return response()->json($selectFC);
    }
// FEE CATEROGORY CONTROLLER END HERE



// FEE type CONTROLLER START HERE
    public function fee_type()
    {
        $sessions = Kelex_sessionbatch::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
        $feecategory = Kelex_fee_category::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
        $getfeecat = DB::table('kelex_fee_types')
                                ->join('kelex_sections', 'kelex_sections.Section_id', '=', 'kelex_fee_types.SECTION_ID')
                                ->join('kelex_classes', 'kelex_classes.Class_id', '=', 'kelex_fee_types.CLASS_ID')
                                ->join('kelex_sessionbatches', 'kelex_sessionbatches.SB_ID', '=', 'kelex_fee_types.SESSION_ID')
                                ->join('kelex_fee_categories', 'kelex_fee_categories.FEE_CAT_ID', '=', 'kelex_fee_types.FEE_CAT_ID')
                                ->where('kelex_fee_types.CAMPUS_ID','=',Session::get('CAMPUS_ID'))->
                                select('kelex_fee_categories.CATEGORY','kelex_classes.Class_name','kelex_sections.Section_name',
                                'kelex_sessionbatches.SB_NAME','kelex_fee_types.*')
                                ->get()->toArray();

        $class= Kelex_class::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
        $data = ['sessions' => $sessions,'classes'=>$class,'getfeecat'=>$getfeecat,'feecategory'=> $feecategory];
        return view('Admin.FeesManagement.fee_type')->with($data);
    }
    public function get_fee_type($session_id,$class_id,$section_id,$fee_cat_id)
    {
        // dd($session_id);
        $getfeecat = DB::table('kelex_fee_types')
                        ->join('kelex_sessionbatches', 'kelex_sessionbatches.SB_ID', '=', 'kelex_fee_types.SESSION_ID')
                            ->where('kelex_fee_types.CAMPUS_ID','=',Session::get('CAMPUS_ID'))
                            ->where('kelex_fee_types.CLASS_ID','=',$class_id)
                            ->where('kelex_fee_types.SECTION_ID','=',$section_id)
                            ->where('kelex_fee_types.FEE_CAT_ID','=',$fee_cat_id)
                            ->select('kelex_fee_types.*')
                            ->get()
                            ->toArray();
                            return $getfeecat;
    }



    public function add_fee_type(FeetypeRequest $request)
    {
        // dd($request->all());
        $result= DB::table('kelex_fee_types')
            ->where('CLASS_ID','=', $request->input('CLASS_ID'))
            ->where('SECTION_ID','=',$request->input('SECTION_ID'))
            ->where('SESSION_ID','=',$request->input('SESSION_ID'))
            ->where('FEE_CAT_ID', $request->input('FEE_CAT_ID'))
            ->where('FEE_TYPE', $request->input('FEE_TYPE'))->
            where('CAMPUS_ID','=',Session::get('CAMPUS_ID'))
            ->select('kelex_fee_types.FEE_CAT_ID')
            ->get()->toArray();
        if(count($result) == 0)
        {
            $data = ['CLASS_ID'=>$request->CLASS_ID,
                    'SESSION_ID'=>$request->SESSION_ID,
                    'SECTION_ID'=>$request->SECTION_ID,
                    'FEE_CAT_ID'=>$request->FEE_CAT_ID,
                    'CAMPUS_ID'=> Session::get('CAMPUS_ID'),
                    'CREATED_BY'=> Auth::user()->id,'SHIFT'=>$request->SHIFT,
                    'FEE_TYPE'=>$request->input('FEE_TYPE')];

        $feetype= Kelex_fee_type::create($data);
        return response()->json();
        }
        else
        {
            return response()->json("Record Already Existed");
        }
    }
    public function edit_fee_type(Request $request)
    {

        $editfeedata= DB::table('kelex_fee_types')->where('FEE_ID', $request->FEE_ID)
        ->where('CAMPUS_ID','=',Session::get('CAMPUS_ID'))
        ->first();
       echo json_encode($editfeedata);

    }
    public function update_subjectgroup(FeetypeRequest $request)
    {
        $result= DB::table('kelex_fee_types')
        ->where('FEE_ID','!=',$request->FEE_ID)
        ->where('CLASS_ID','=', $request->input('CLASS_ID'))
        ->where('SECTION_ID','=',$request->input('SECTION_ID'))
        ->where('SESSION_ID','=',$request->input('SESSION_ID'))
        ->where('FEE_CAT_ID', $request->input('FEE_CAT_ID'))
        ->where('CAMPUS_ID','=',Session::get('CAMPUS_ID'))
        ->select('kelex_fee_types.FEE_ID')
        ->get()->toArray();
        if(count($result) == 0)
        {

            $feetype= Kelex_fee_type::where('FEE_ID', $request->FEE_ID)
            ->where('CAMPUS_ID','=',Session::get('CAMPUS_ID'))->
            update(['CLASS_ID'=>$request->CLASS_ID,'SESSION_ID'=>$request->SESSION_ID,
            'SECTION_ID'=>$request->SECTION_ID,
            'FEE_CAT_ID'=>$request->FEE_CAT_ID,'CAMPUS_ID'=> Session::get('CAMPUS_ID'),
            'UPDATE_BY'=> Auth::user()->id,
            'SHIFT'=>$request->SHIFT,
            'FEE_TYPE'=>$request->FEE_TYPE]);
            return response()->json();
            }
            else
            {
                return response()->json("Another Record Already Existed");
            }
    }

    public function add_fee_structure(Request $request)
    {
        // dd
    }

    public function fee_structure()
    {
        $sessions = Kelex_sessionbatch::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
        $feecategory = Kelex_fee_category::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
        $getfeeStructure = DB::table('kelex_fee_types')
                                ->join('kelex_sections', 'kelex_sections.Section_id', '=', 'kelex_fee_types.SECTION_ID')
                                ->join('kelex_classes', 'kelex_classes.Class_id', '=', 'kelex_fee_types.CLASS_ID')
                                ->join('kelex_sessionbatches', 'kelex_sessionbatches.SB_ID', '=', 'kelex_fee_types.SESSION_ID')
                                ->join('kelex_fee_categories', 'kelex_fee_categories.FEE_CAT_ID', '=', 'kelex_fee_types.FEE_CAT_ID')
                                ->where('kelex_fee_types.CAMPUS_ID', '=',Session::get('CAMPUS_ID'))
                                ->select('kelex_fee_categories.CATEGORY','kelex_classes.Class_name','kelex_sections.Section_name',
                                'kelex_sessionbatches.SB_NAME','kelex_fee_types.*')
                                ->get()->toArray();


        $class= Kelex_class::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
        // dd($getfeecat);
          $data = ['sessions' => $sessions,'classes'=>$class, 'getfeeStructure'=> $getfeeStructure,'feecategory'=> $feecategory];
        //   dd($data);
        return view('Admin.FeesManagement.fee_structure')->with($data);
    }

    public function fee_define_new($session_id = null)
    {

        $fee_cat = Kelex_fee_category::all()->where('CAMPUS_ID', Auth::user()->CAMPUS_ID);
        $sessions = Kelex_sessionbatch::all()->where('CAMPUS_ID', Auth::user()->CAMPUS_ID);
        $record = DB::table('kelex_sections')
        ->join('kelex_classes', 'kelex_classes.Class_id', '=', 'kelex_sections.Class_id')
        ->LeftJoin('kelex_fee_structures', 'kelex_fee_structures.SECTION_ID', '=', 'kelex_sections.Section_id')
        ->leftJoin('kelex_sessionbatches', 'kelex_sessionbatches.SB_ID', '=', 'kelex_fee_structures.SESSION_ID')
        ->where('kelex_sections.CAMPUS_ID', '=', Auth::user()->CAMPUS_ID)
        ->select(
            'kelex_classes.Class_name',
            'kelex_classes.Class_id',
            'kelex_sections.Section_name',
            'kelex_sections.Section_id',
            'kelex_fee_structures.*'
        )
        ->get()->toArray();
        $sessionID =  isset($record[0]->SESSION_ID) ?  $record[0]->SESSION_ID : null;
        // dd($record);
        $data = ['sessions' => $sessions,  'record' => $record,'fee_cat' => $fee_cat,'sessionID' =>$sessionID];
        // dd($data);
        return view('Admin.FeesManagement.fee_define_new')->with($data);
    }

    public function apply_fee_structure(Request $request)
    {
        // error_reporting(E_ALL ^ E_NOTICE);
        $session_id = $request->SESSION_ID;
        $record = $request->record; //dd($record);

       foreach ($record as $key => $value) {
            $ammount_array = [];
        if(isset($value['cat_amount']) AND !empty($value['cat_amount']) AND $value['cat_amount'] != null):
            for ($i=0; $i < count($value['cat_amount']); $i++) {
              $ammount_array[][$value['cat_id'][$i]] = $value['cat_amount'][$i] ;
            }
        endif;
         $data = [
             'SESSION_ID' => $session_id,
             'CAMPUS_ID' => Auth::user()->CAMPUS_ID,
             'USER_ID' => Auth::user()->id,
             'CLASS_ID' => $value['class_id'],
             'SECTION_ID' => $value['section_id'],
             'FEE_CATEGORY_ID' => isset($value['cat_id']) ? json_encode($value['cat_id']) : null ,
             'CATEGORY_AMOUNT' => json_encode($ammount_array)
         ];

         if($value['fee_structure_id'] == null OR $value['fee_structure_id'] == ""):
             KelexFee_structure::create($data);
         else:
             KelexFee_structure::where('FEE_STRUCTURE_ID',$value['fee_structure_id'])->update($data);
         endif;
         unset($ammount_array);
       }
       return response()->json(array('type' => 1,'response' => 'Fee Structure record Saved Successfully.'));
    }

    public function apply_fee()
    {
        $sessions = Kelex_sessionbatch::all()->where('CAMPUS_ID', Auth::user()->CAMPUS_ID);
        $classes = Kelex_class::all()->where('CAMPUS_ID', Auth::user()->CAMPUS_ID);
        // $months =
        $type = (Session::get('CAMPUS')->TYPE == 'L_instuition') ? 2 : 1;
        $months = Kelex_month::orderBy('NUMBER','ASC')->where('TYPE' ,$type)->get(); //print_r($months); die;
        // dd(Auth::user());
        $months = json_decode(json_encode($months,true));
        $months = array_chunk($months,6);
        $data = ['sessions' => $sessions,  'classes' => $classes,'months'=>$months];
        return view('Admin.FeesManagement.apply_fee_view')->with($data);

    }
    public function get_section_fee_category($session_id,$class_id,$section_id)
    {
        $record = KelexFee_structure::select('CATEGORY_AMOUNT','FEE_CATEGORY_ID')->where(['CAMPUS_ID'=> Auth::user()->CAMPUS_ID,'SECTION_ID' => $section_id])->first();
        $cat_ids = json_decode($record->FEE_CATEGORY_ID,true);// dd($cat_ids);
        $category = Kelex_fee_category::whereIn('FEE_CAT_ID',$cat_ids)->select('CATEGORY')->get();
        $checkWhere = [
            'CAMPUS_ID' => Auth::user()->CAMPUS_ID,
            'SESSION_ID'=> $session_id,
            'CLASS_ID' => $class_id,
            'section_id' => $section_id,

        ];
        $check_record = Kelex_fee::select('FEE_ID','FEE_DATA','MONTHS')->whereYear('created_at','=',date('Y'))->where($checkWhere)->get();
        $old_record = [];
        // dd($checkWhere);
        if(count($check_record) > 0 ):
            $check_record = json_decode(json_encode($check_record, true));
            $old_record['fee_id'] = $check_record[0]->FEE_ID;
            $old_record['months'] = json_decode($check_record[0]->MONTHS);
            $old_record['feedata'] = json_decode($check_record[0]->FEE_DATA);
        endif;
        $data['check_record'] = $old_record;
        $data['FEE_AMOUNT'] = json_decode($record->CATEGORY_AMOUNT, true); //dd($old_record);
        $data['category'] = json_decode(json_encode($category,true));
        $data['category'] = array_column($data['category'],'CATEGORY'); //dd($data);
        return $data;

    }
    public function apply_fee_on_sections(Request $request)
    {
        $section_id = $request->section_id; //dd($request->all());
        $class_id = $request->class_id;
        $session_id = $request->session_id;
        $fee_category = $request->category;
        $months = $request->months;
        $due_date = $request->due_date;
        $where = [
            'SESSION_ID' => $session_id,
            // 'CLASS_ID' => $class_id,
            'SECTION_ID' => $section_id
        ];
        $student_ids = Kelex_students_session::where($where)
                            ->select('STUDENT_ID')
                            ->get(); //dd($student_ids);
        $student_ids = json_decode(json_encode($student_ids,true));
        if(empty($student_ids)):
            return ['type' => 0,'response' => 'No Students found. Fee Applying Failed.'];
            die;
        endif;
        $student_ids = array_column($student_ids,'STUDENT_ID');
        $fee_structure = KelexFee_structure::where($where)->select('FEE_CATEGORY_ID','CATEGORY_AMOUNT')->get();
        $fee_structure = json_decode(json_encode($fee_structure,true));
        // $fee_cat_ids_from_structure = json_decode(array_column($fee_structure, "FEE_CATEGORY_ID")[0]);
        $fee_cat_amount_from_structure = json_decode(array_column($fee_structure, "CATEGORY_AMOUNT")[0],true);
        $fee_structure_data = [];
        $fee_detail_array = [];
        foreach($fee_cat_amount_from_structure as $key => $value):
            foreach($value as $k => $val):
                $fee_structure_data[$k] = $val;
            endforeach;
        endforeach;
        foreach($fee_category as $key => $value):
            array_push($fee_detail_array,['FEE_CATEGORY_ID' => $value, 'FEE_CATEGORY_AMOUNT'=> $fee_structure_data[$value] ]);
        endforeach;
        $fee_data = [
            'CAMPUS_ID' => Auth::user()->CAMPUS_ID,
            'USER_ID' => Auth::user()->id,
            // 'STUDENT_ID' => $student_ids[$i],
            'SESSION_ID' => $session_id,
            'CLASS_ID' => $class_id,
            'SECTION_ID' => $section_id,
            'MONTHS' => json_encode($months),
            'FEE_DATA' => json_encode($fee_detail_array),
            'FEE_AMOUNT' => array_sum(array_column($fee_detail_array, 'FEE_CATEGORY_AMOUNT')),
            'DUE_DATE' => $due_date,
            'STATUS' => '0',
        ];
        // dd($fee_data);
         Kelex_fee::create($fee_data);
         $fee_id  = Kelex_fee::orderBy('FEE_ID', 'DESC')->first()->FEE_ID; //dd($student_ids);
        for($i = 0; $i<count($student_ids);$i++):
            $student_fee = [
                'FEE_ID' => $fee_id,
                'STUDENT_ID' => $student_ids[$i],

            ];
            Kelex_student_fee::create($student_fee);
        endfor;
        return ['type' =>1,'response' => 'Fee Applied Successfully..'];
    }

    public function fee_voucher()
    {
        $sessions = Kelex_sessionbatch::all()->where('CAMPUS_ID', Auth::user()->CAMPUS_ID);
        $classes = Kelex_class::all()->where('CAMPUS_ID', Auth::user()->CAMPUS_ID);

        $data = ['sessions' => $sessions,  'classes' => $classes];
        return view('Admin.FeesManagement.print_fee_voucher')->with($data);
    }
    public function get_section_fee($session_id,$class_id,$section_id,$type)
    {
        // dd($this->sms(['1',2]));
        $record = Kelex_fee::where('SESSION_ID',$session_id)
            ->where('CLASS_ID' , $class_id)
            ->where('STATUS', '0')
             ->where('SECTION_ID', $section_id)
            ->where('CAMPUS_ID' , Auth::user()->CAMPUS_ID)
             ->get();
        // dd($record);
        $record = json_decode(json_encode($record,true)); //dd($record);
        if(empty($record)):
            return redirect()->route('fee-voucher')->with('msg', 'No Fee Record Found for required Selections');
            die;
        endif;
        $fee_data_months_arr = [];
        $fee_data = [];
        $complete_fee_details = [];
        foreach($record as $key => $value):
            $fee_data[] = $value->FEE_DATA;
            $fee_data_months_arr[] =  json_decode($value->MONTHS);
        endforeach;
        $inst_type = (trim(session('CAMPUS')->TYPE) == "school" ) ? 1 : 2;
        $months = DB::table('kelex_months')
                                ->where('TYPE',$inst_type)
                                ->whereIn('NUMBER',$fee_data_months_arr[0])
                                ->orderBy('NUMBER','ASC')
                                ->pluck('MONTH');
        $fee_details = [];
        foreach($fee_data as $key => $val):
            $fee_details[] = json_decode($val);

        endforeach;

        $std_record = DB::table('kelex_student_fees')
                            ->leftjoin('kelex_fees','kelex_fees.FEE_ID','=', 'kelex_student_fees.FEE_ID')
                            ->leftjoin('kelex_students_sessions', 'kelex_students_sessions.STUDENT_ID', '=', 'kelex_student_fees.STUDENT_ID')
                            ->leftjoin('kelex_students', 'kelex_students.STUDENT_ID', '=', 'kelex_student_fees.STUDENT_ID')
                            ->select('kelex_students.NAME','kelex_students.FATHER_NAME','kelex_students_sessions.*','kelex_students.REG_NO','kelex_fees.*')
                            ->where('kelex_fees.FEE_ID',$record[0]->FEE_ID)
                            ->get();
                            //  dd($std_record);
        $std_record = json_decode(json_encode($std_record),true);
    //    dd($std_record);
        $i = 0;
        foreach ($fee_details as $k => $v) :
            foreach ($v as  $n => $m) :
                $fee_category_data = Kelex_fee_category::select('CATEGORY','FEE_CAT_ID')
                ->where(['FEE_CAT_ID' => $m->FEE_CATEGORY_ID])
                    ->get();
                $fee_category = $fee_category_data[0]->CATEGORY;
                $complete_fee_details[$i]['fee_category_id'] = $fee_category_data[0]->FEE_CAT_ID;
                $complete_fee_details[$i]['fee_category'] = $fee_category;
                $complete_fee_details[$i]['fee_amount'] = $m->FEE_CATEGORY_AMOUNT;
                $i++;
            endforeach;
        endforeach;
        $discount = 0;
        for ($i=0;$i<count($std_record); $i++):
            // print_r($std_record[$i]);
            for ($j =0; $j <count($complete_fee_details);$j++) {

                $checkdiscount =  DB::table('kelex_fee_discounts')
                                    ->where(['STUDENT_ID'=> $std_record[$i]['STUDENT_ID'],'FEE_CAT_ID' =>  $complete_fee_details[$j]['fee_category_id']  ])
                                     ->select('DISCOUNT')
                                    ->first();

                 if($checkdiscount!=null){


                $getdis=$checkdiscount->DISCOUNT;

                $discount = ($checkdiscount == null) ? $discount : $checkdiscount;
                $complete_fee_details[$j]['fee_amount'] = $complete_fee_details[$j]['fee_amount'] -$getdis  ;

                }
                $checkBalance = DB::table('kelex_student_dues')
                    ->where('STUDENT_ID', $std_record[$i]['STUDENT_ID'])
                    // ->where('TYPE', '1')
                    ->orderBy('id','DESC')
                    ->first();
            $complete_fee_details[$j]['prev_type'] = (isset($checkBalance)) ? $checkBalance->TYPE : null;
                $complete_fee_details[$j]['prev_balance'] = (isset($checkBalance)) ? $checkBalance->AMOUNT : 0;
            }
            $std_record[$i]['student_fee_months'] = $months;
            $std_record[$i]['student_fees'] = $complete_fee_details;

        endfor;
        $bank = Kelex_bank::where(['CAMPUS_ID' => Session::get('CAMPUS_ID'),'IS_ACTIVE' => '1'])->first();
        // $bank = Kelex_bank::all();
        // dd(Session::get('CAMPUS_ID'));
        $class= Kelex_class::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
        $Section= Kelex_Section::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
        $Session= kelex_sessionbatch::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
        $terms = General_setting::where('CAMPUS_ID', Session::get('CAMPUS_ID'))->first(); //dd($terms->FEE_TERMS_CONDETIONS);
        switch ($type) {
            case '1':
                $view = 'Admin.FeesManagement.print_fee_slip_1';
                break;
            case '2':
                $view = 'Admin.FeesManagement.print_fee_slip_2';
                break;

            case '3':
                $view = 'Admin.FeesManagement.print_fee_slip_3';
                break;
        }
        $data = [
            'record' => $std_record,
            'class' => $class,
            'Section' => $Section,
            'Session' => $Session,
            'bank' => $bank,
            'terms'=>$terms
        ];
        // dd($record);
        return view($view)->with($data);

    }

    public function get_student_fee($session_id,$class_id,$section_id)
    {
        $where = [
            'CAMPUS_ID' => Auth::user()->CAMPUS_ID,
            'SESSION_ID' => $session_id,
            'CLASS_ID' => $class_id,
            'SECTION_ID' => $section_id
        ];
        // dd($where);
       $data = KelexFee_structure::where($where)->select('CATEGORY_AMOUNT')->get()[0]->CATEGORY_AMOUNT; //dd($data);
       $data = json_decode(json_encode($data,true),true);
    //    dd($data);
       $data = json_decode($data);;
       $fee_data = [];
        $i = 0;
       foreach($data as $k => $v):

           foreach($v as $key => $val):
               $category = Kelex_fee_category::where('FEE_CAT_ID', $key)->select('CATEGORY')->get()[0]->CATEGORY;
                $fee_data[$i]['FEE_CATEGORY_ID'] =  $key;
                $fee_data[$i]['FEE_CATEGORY'] = $category;
                $fee_data[$i]['CATEGORY_AMOUNT'] =  $val;
            // echo $i;
                $i++;
           endforeach;
       endforeach;
       return $fee_data;
    }
/////////////// Fee Collection //////////////////////////
    public function student_fee_collection_view()
    {
        $sessions = Kelex_sessionbatch::all()->where('CAMPUS_ID', Auth::user()->CAMPUS_ID);
        $classes = Kelex_class::all()->where('CAMPUS_ID', Auth::user()->CAMPUS_ID);

        $data = ['sessions' => $sessions,  'classes' => $classes];
        return view('Admin.FeesManagement.fee_collection_view')->with($data);
    }
    public function get_fee_collection_data($sessionID,$class_id,$section_id)
    {
        $where  = [
            'kelex_fees.SESSION_ID' => $sessionID,
            'kelex_fees.CLASS_ID' => $class_id,
            'kelex_fees.SECTION_ID' => $section_id,
            'kelex_fees.CAMPUS_ID' => Session::get('CAMPUS_ID'),
            'kelex_fees.STATUS' => '0',
        ]; //dd($where);
        $std_record = DB::table('kelex_student_fees')
            ->leftjoin('kelex_fees', 'kelex_fees.FEE_ID', '=', 'kelex_student_fees.FEE_ID')
            ->leftjoin('kelex_students_sessions', 'kelex_students_sessions.STUDENT_ID', '=', 'kelex_student_fees.STUDENT_ID')
            ->leftjoin('kelex_students', 'kelex_students.STUDENT_ID', '=', 'kelex_student_fees.STUDENT_ID')
            ->select('kelex_students.NAME', 'kelex_students.FATHER_NAME', 'kelex_students_sessions.*', 'kelex_students.REG_NO', 'kelex_fees.*')
            ->where($where)
            ->get();
            $std_record = json_decode(json_encode($std_record),true);
            foreach($std_record as $key => $value):
                // $std_record[$key]['total_amount'] = $value['']
                $due = Kelex_student_dues::where('STUDENT_ID',$value['STUDENT_ID'])
                    // ->where('')
                    ->orderBy('id','DESC')
                    ->first();
            $std_record[$key]['total_amount'] = (isset($due)) ? $value['FEE_AMOUNT'] + $due->AMOUNT :    $value['FEE_AMOUNT'];
            endforeach;
            return $std_record;

    }
    public function fee_collection(Request $request)
    {
        // dd(Session::all());
       $student_id = $request->student_id;
       $paidAmount = $request->paidAmount;
        $fee_id = $request->fee_id;
        for($i=0;$i<count($student_id);$i++):
            $amount = $request->amount;
            $remaining = (float) $amount[$i] - (float) $paidAmount[$i];
            $data = [
                'CAMPUS_ID' => Session::get('CAMPUS_ID'),
                'USER_ID' => Auth::user()->id,
                'SESSION_ID' => $request->session_id,
                'CLASS_ID' => $request->class_id,
                'SECTION_ID' => $request->section_id,
                'STUDENT_ID' => $student_id[$i],
                'PAID_AMOUNT' => $paidAmount[$i],
                'FEE_ID' => $fee_id,
                'REMAINING'    => $remaining,
                'PAYMENT_TYPE' => '1',
                'PAYMENT_STATUS' => '1',
            ];

            // print_r($data);
            // Kelex_fee_collection::create($data);
           $type = ($remaining < 0) ? '2': '1';
           $balanceArr = [
               'STUDENT_ID' => $student_id[$i],
               'FEE_ID' => $fee_id,
               'AMOUNT' => $remaining,
               'TYPE' => $type,
               'CAMPUS_ID' => Session::get('CAMPUS_ID'),
               'USER_ID' => Auth::user()->id,
           ];
           if($remaining < 0 OR $remaining >0):
              Kelex_student_dues::create($balanceArr);
           endif;
        endfor;
        Kelex_fee::where(['FEE_ID' => $fee_id])->update(['STATUS' => '1']);
        return ['type' => 1,'response' => 'Record Saved Successfully..'];
    }

    ////////////////////////Family Accounts //////
    public function family_accounts()
    {
        $sessions = Kelex_sessionbatch::all()->where('CAMPUS_ID', Auth::user()->CAMPUS_ID);
        $classes = Kelex_class::all()->where('CAMPUS_ID', Auth::user()->CAMPUS_ID);

        $data = ['sessions' => $sessions,  'classes' => $classes];
        return view('Admin.FeesManagement.family_accounts')->with($data);
    }
    /////// Get Family Accounts ///
    function get_family_accounts($sessionID)
    {
        $result =  DB::table('kelex_students')
            ->leftJoin('kelex_students_sessions', 'kelex_students_sessions.STUDENT_ID', '=', 'kelex_students.STUDENT_ID')
            ->where('kelex_students_sessions.SESSION_ID', '=', $sessionID)
            ->where('kelex_students.FATHER_CNIC','!=','NULL')
            ->where('kelex_students_sessions.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
            ->select('kelex_students.FATHER_CNIC', 'kelex_students.FATHER_NAME')
            ->distinct()
            ->get()->toArray();
        $result = json_decode(json_encode($result),true);
        foreach($result as $key=> $row):
            $students = DB::table('kelex_students')
                ->leftJoin('kelex_students_sessions', 'kelex_students_sessions.STUDENT_ID', '=', 'kelex_students.STUDENT_ID')
                ->leftJoin('kelex_classes', 'kelex_students_sessions.CLASS_ID', '=', 'kelex_classes.Class_id')
                ->leftJoin('kelex_sections', 'kelex_classes.Class_id', '=', 'kelex_sections.Class_id')
                ->where('kelex_students_sessions.SESSION_ID', '=', $sessionID)
                ->where('kelex_students_sessions.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
                ->select( 'kelex_students.NAME', 'kelex_classes.Class_name', 'kelex_sections.Section_name')
                            ->where('FATHER_CNIC',$row['FATHER_CNIC'])
                            ->get();
            $result[$key]['data'] = $students;
        endforeach;

        return response()->json($result);
    }
    ///////////////////// FEE register //////
    public function fee_register()
    {
        $sessions = Kelex_sessionbatch::all()->where('CAMPUS_ID', Auth::user()->CAMPUS_ID);
        $classes = Kelex_class::all()->where('CAMPUS_ID', Auth::user()->CAMPUS_ID);

        $where  = [
            // 'kelex_fees.SESSION_ID' => $sessionID,
            // 'kelex_fees.CLASS_ID' => $class_id,
            // 'kelex_fees.SECTION_ID' => $section_id,
            'kelex_fees.CAMPUS_ID' => Session::get('CAMPUS_ID'),
            // 'kelex_fees.STATUS' => '0',
        ]; //dd($where);
        $record = DB::table('kelex_student_fees')
        ->leftjoin('kelex_fees', 'kelex_fees.FEE_ID', '=', 'kelex_student_fees.FEE_ID')
        ->leftjoin('kelex_students_sessions', 'kelex_students_sessions.STUDENT_ID', '=', 'kelex_student_fees.STUDENT_ID')
        ->leftjoin('kelex_classes', 'kelex_classes.Class_id', '=', 'kelex_students_sessions.CLASS_ID')
        ->leftjoin('kelex_sections', 'kelex_sections.Section_id', '=', 'kelex_students_sessions.SECTION_ID')
        ->leftjoin('kelex_students', 'kelex_students.STUDENT_ID', '=', 'kelex_student_fees.STUDENT_ID')
        ->leftjoin('kelex_student_dues', 'kelex_student_dues.STUDENT_ID', '=', 'kelex_student_fees.STUDENT_ID')
        ->select('kelex_students.NAME', 'kelex_students.FATHER_NAME', 'kelex_classes.Class_name', 'kelex_sections.Section_name', 'kelex_students_sessions.*', 'kelex_students.REG_NO', 'kelex_fees.*', 'kelex_student_dues.*')
        ->where($where)
        ->groupBy('kelex_student_fees.STUDENT_FEE_ID')
        ->orderBy('kelex_student_fees.STUDENT_FEE_ID','DESC')
            ->get();
        $data = ['sessions' => $sessions,  'classes' => $classes,'record' => $record];
        return view('Admin.FeesManagement.fee_register')->with($data);
    }

// Online Registration Fee controller method start here
public function index_fee_reg()
{

    $campus_id = Auth::user()->CAMPUS_ID;
    $class= Kelex_class::where('CAMPUS_ID',$campus_id)->get();
    $session= Kelex_sessionbatch::where('CAMPUS_ID',$campus_id)->get();
    $data = DB::table('kelex_oreg_fees')
    ->leftjoin('kelex_classes', 'kelex_classes.Class_id', '=', 'kelex_oreg_fees.CLASS_ID')
    ->leftjoin('kelex_sessionbatches', 'kelex_sessionbatches.SB_ID', '=', 'kelex_oreg_fees.SESSION_ID')
    ->select('kelex_sessionbatches.SB_NAME','kelex_classes.Class_name', 'kelex_oreg_fees.*')->get();
    // dd($class);
    return view("Admin.FeesManagement.Online_reg_fee")->with(['classes'=>$class,'sessions'=>$session,'datas'=>$data]);
}
public function search_reg_fee(Request $request)
{
    $result= Kelex_oreg_fee::where('SESSION_ID',$request->SESSION_ID)->where('CLASS_ID',$request->CLASS_ID)
        ->where('CAMPUS_ID', Auth::user()->CAMPUS_ID)->first();

    // dd($class);
    return response()->json($result);
}
public function apply_reg_fee(reg_feeRequest $request)
{
    $Result= Kelex_oreg_fee::updateOrCreate(
        ['SESSION_ID' => $request->SESSION_ID,'CLASS_ID' => $request->CLASS_ID],
        ['SESSION_ID' => $request->SESSION_ID,
        'CLASS_ID' => $request->CLASS_ID,
        'REGFEE'=>$request->REGFEE,
        'CAMPUS_ID' => Session::get('CAMPUS_ID'),
        'USER_ID' =>Session::get('user_id'),
    ]);
    // dd($class);
    return response()->json(true);
}


}
