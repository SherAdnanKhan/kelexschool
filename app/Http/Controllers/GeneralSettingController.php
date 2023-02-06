<?php

namespace App\Http\Controllers;

use App\Models\Kelex_campus;
use Illuminate\Http\Request;
use App\Models\General_setting;
use App\Models\Kelex_sessionbatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GeneralSettingController extends Controller
{
  public function fee_terms(Request $request)
  {
      if(!empty( $request->all() ) ):
        $data = [
            'FEE_TERMS_CONDETIONS' => $request->terms,
            'USER_ID' =>  Auth::user()->id,
            'CAMPUS_ID' => Session::get('CAMPUS_ID'),
        ];
        // dd($data);
       General_setting::updateOrCreate(['SETTING_ID'=> $request->setting_id],$data);
       return ['type'=>1,'response'=> 'record Updated successfully'];
      endif;
      $fee_terms = General_setting::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->first();
      $data['fee_terms'] = $fee_terms;
      return view('Admin.Settings.fee_terms')->with($data);
  }
  public function index_campus_settings()
    {
      $session= Kelex_sessionbatch::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
      $campus= Kelex_campus::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->first();
      return view('Admin.Settings.campus_settings')->with(['campus'=>$campus,'sessions'=>$session]);

    }
    public function update_campus_settings(Request $request)
    {
      if($request->hasFile('LOGO_IMAGE'))
      {
      $image = $request->file('LOGO_IMAGE');
      $my_image = rand() . '.' . $image->getClientOriginalExtension();
      $image->move(public_path('upload'), $my_image);
      $affected = DB::table('kelex_campuses')
      ->where('LOGO_IMAGE', $request->input('LOGO_IMAGE'))
      ->update(["LOGO_IMAGE"=>$my_image]);
      }
      
  $affected = DB::table('kelex_campuses')
            ->where('CAMPUS_ID', $request->input('CAMPUS_ID'))
            ->update(["SCHOOL_NAME"=>$request->input("SCHOOL_NAME"),
            "SCHOOL_ADDRESS"=>$request->input("SCHOOL_ADDRESS"),
            "PHONE_NO"=>$request->input("PHONE_NO"),
            "MOBILE_NO"=>$request->input("MOBILE_NO"),
            "SCHOOL_REG"=>$request->input("SCHOOL_REG"),
            "USER_ID"=> Auth::user()->id,
            "CURRENT_SESSION"=>   $request->input("SESSION_ID"),
            ]);

      if (!is_null( $affected)) {
        return response()->json(true);
      }
  else
  {
      return response()->json(false);
  }

    }
}
