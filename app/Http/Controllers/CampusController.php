<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Kelex_campus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\campusrequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CampusController extends Controller
{
    public function __construct()
    {
       // $this->middleware(['auth','verified']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

         $cities = getCities() ? getCities() : array();
        return view("Admin.Campuses.add_campus")->with('cities',$cities);
    }

    public function showcampus()
    {
        $cities = getCities() ? getCities() : [];
        $campus = kelex_campus::all();
    return view('Admin.Campuses.view_campuses')->with(['campuses'=>$campus,'cities'=>$cities]);
    }


    public function store(campusrequest $request)
    {
       $result= Kelex_campus::where('SCHOOL_EMAIL',$request->input("schoolemail"))->get()->Toarray();
       if(count($result)==0){
       $permission= json_encode($request->role_per);
        $image = $request->file('schoollogo');
        $my_image =null;
        if(!empty($image)):
            $my_image = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload'), $my_image);
        endif;
        $website = parse_url($request->input("schoolwebsite"))['host'];
        $billingdate= Carbon::parse( $request->input("billingdate"));
        $agreementdate= Carbon::parse($request->input("agreementdate"));

        $kelexcampus= new Kelex_campus();
        $kelexcampus->SCHOOL_NAME=      $request->input("schoolname");
        $kelexcampus->SCHOOL_ADDRESS=   $request->input("schooladdress");
        $kelexcampus->PHONE_NO=     $request->input("phoneno");
        $kelexcampus->MOBILE_NO=    $request->input("mobileno");
        $kelexcampus->LOGO_IMAGE=  $my_image;
        $kelexcampus->SCHOOL_REG=   $request->input("schoolregistration");
        $kelexcampus->SCHOOL_WEBSITE=   $website;
        $kelexcampus->SCHOOL_EMAIL= $request->input("schoolemail");
        $kelexcampus->CONTROLLLER=  "abc";
        $kelexcampus->USER_ID= Auth::user()->id;
        $kelexcampus->CITY_ID=  $request->input("city");
        $kelexcampus->TYPE= $request->input("instuition");
        $kelexcampus->BILLING_CHARGE= $request->input("billingcharges") ;
        $kelexcampus->BILLING_DISCOUNT=	   $request->input("discount");
        $kelexcampus->DUE_DATE=   $billingdate;
        $kelexcampus->STATUS=   $request->input("status");
        $kelexcampus->SMS_ALLOWED=	$request->input("smsstatus");
        $kelexcampus->AGREEMENT=   $request->input("Aggreement");
        $kelexcampus->AGREEMENT_DATE= $agreementdate;
        if ($kelexcampus->save()) {
            $campusID = $kelexcampus->CAMPUS_ID;
            $user= new User();
            $user->username=$kelexcampus->SCHOOL_EMAIL;
            $user->password=Hash::Make("admin");
            $user->CAMPUS_ID=$kelexcampus->CAMPUS_ID;
            $user->isadmin=true;
            $user->email=$kelexcampus->SCHOOL_EMAIL;
            $user->permissions=$permission;
            $user->save();
            return response()->json(array('status' => 1,'response' => 'Campus Created Sucessfully..'));
        }
    }
        else
        {
            return response()->json(array('status' => 0,'response' => 'Email Already Exist..'));
        }

    }
    public function getcampusdata(Request $request){
        $currentcampus = DB::table('kelex_campuses')->where(['CAMPUS_ID' => $request->campusid])
        ->get();



       echo json_encode($currentcampus);
    }
    public function updatecampusdata(campusrequest $request)
    {
        $result= Kelex_campus::where('SCHOOL_EMAIL',$request->input("schoolemail"))
        ->where('CAMPUS_ID','!=',$request->input('campusid'))->get()->Toarray();
        if(count($result)==0){

        if($request->hasFile('schoollogo'))
        {
        $image = $request->file('schoollogo');
        $my_image = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('upload'), $my_image);
        $affected = DB::table('kelex_campuses')
        ->where('CAMPUS_ID', $request->input('campusid'))
        ->update(["LOGO_IMAGE"=>$my_image]);
        }
        $billingdate= Carbon::parse( $request->input("billingdate"));
        $agreementdate= Carbon::parse($request->input("agreementdate"));
        $website = parse_url($request->input("schoolwebsite"))['host'];

    $affected = DB::table('kelex_campuses')
              ->where('CAMPUS_ID', $request->input('campusid'))
              ->update(["SCHOOL_NAME"=>$request->input("schoolname"),
              "SCHOOL_ADDRESS"=>$request->input("schooladdress"),
              "PHONE_NO"=>$request->input("phoneno"),
              "MOBILE_NO"=>$request->input("mobileno"),
              "SCHOOL_REG"=>$request->input("schoolregistration"),
              "SCHOOL_WEBSITE"=>   $website,
              "SCHOOL_EMAIL"=>   $request->input("schoolemail"),
              "CONTROLLLER"=>  "abc",
              "USER_ID"=> Auth::user()->id,
              "CITY_ID"=>  $request->input("city"),
              "TYPE"=> $request->input("instuition"),
              "BILLING_CHARGE"=> $request->input("billingcharges") ,
              "BILLING_DISCOUNT"=>	   $request->input("discount"),
              "DUE_DATE"=>$billingdate,
              "STATUS"=>   $request->input("status"),
              "SMS_ALLOWED"=>	$request->input("smsstatus"),
              "AGREEMENT"=>   $request->input("Aggreement"),
              "AGREEMENT_DATE"=> $agreementdate,
              ]);

        if (!is_null( $affected)) {
          return response()->json(true);
        }
    }
    else
    {
        return response()->json(false);
    }
}
    public function deletecampusdata(Request $request)
    {
        $id=$request->input('dcampusid');
        DB::table('kelex_campuses')->where('CAMPUS_ID',$id)->delete();

        return response()->json($id);

    }

}
