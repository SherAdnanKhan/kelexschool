<?php

namespace App\Http\Controllers;

use App\Models\Kelex_bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class KelexBanksController extends Controller
{
    public function index()
    {
        $data['record'] = Kelex_bank::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->orderBy('IS_ACTIVE','DESC')->get(); //dd($data);
        return view('Admin.banks.main')->with($data);
    }
    public function add_bank(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'acc_number' => 'required',
            'acc_title' => 'required',
            // 'logo' => 'required'
        ]);
        $checkWhere = [
            'NAME' => $request->name,
            'ACC_NUMBER' => $request->acc_number,
            'CAMPUS_ID' => Auth::user()->CAMPUS_ID,
        ];
        $check =Kelex_bank::where($checkWhere)->first();
        $check = json_decode(json_encode($check),true);
        if(isset($check) ):
            return ['type' => 0,'Record Already exist..'];
            die;
        endif;
        if(isset($request->is_active) AND $request->is_active == "1"):
        Kelex_bank::where(['CAMPUS_ID' => Auth::user()->CAMPUS_ID])
                    ->update(['IS_ACTIVE' => '0']);
        endif;
        $image = $request->file('logo');
        $my_image = null;
        if (!empty($image)) :
            $request->validate([
                'logo' => 'required|mimes:jpg,jpeg,png|max:2048'
            ]);
            $my_image = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/banks/' . Auth::user()->CAMPUS_ID), $my_image);
        endif;
        $data = [
            'NAME' => $request->name,
            'ACC_NUMBER' => $request->acc_number,
            'ACC_TITLE' => $request->acc_title,
            'LOGO' => $my_image,
            'IS_ACTIVE' => (isset($request->is_active)) ? $request->is_active : '0',
            'CAMPUS_ID' => Auth::user()->CAMPUS_ID,
            'USER_ID' => Auth::user()->id
        ];
       Kelex_bank::create($data);
       return ['type' => 1, 'response' => 'Recoord Added Successfully..'];
    }
    public function edit_bank($id)
    {
        return Kelex_bank::find($id);
    }
    public function update_bank(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'acc_number' => 'required',
            'acc_title' => 'required',
            // 'logo' => 'required'
        ]);
        $checkWhere = [
            'NAME' => $request->name,
            'ACC_NUMBER' => $request->acc_number,
            'CAMPUS_ID' => Auth::user()->CAMPUS_ID,
        ];
        $check = DB::table('kelex_banks')->where($checkWhere)->where( 'BANK_ID','!=',$request->BANK_ID)->get();

        $check = json_decode(json_encode($check), true);
        if (isset($check) AND !empty($check)) :
            return ['type' => 0, 'response' => 'Record Already exist..'];
            die;
        endif;
        if (isset($request->is_active) and $request->is_active == "1") :
            Kelex_bank::where(['CAMPUS_ID' => Auth::user()->CAMPUS_ID])
                ->update(['IS_ACTIVE' => '0']);
        endif;
        $image = $request->file('logo');
        $my_image = null;
        if (!empty($image)) :
            $request->validate([
                'logo' => 'required|mimes:jpg,jpeg,png|max:2048'
            ]);
            $image_path = public_path() . "/upload/banks/" . Auth::user()->CAMPUS_ID . '/' . $request->old_logo;  // Value is not URL but directory file path

            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            $my_image = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/banks/' . Auth::user()->CAMPUS_ID), $my_image);
        endif;
        // dd($request->bank_id);
        // $update = Kelex_bank ::find($request->bank_id);
        // $update->NAME = $request->name;
        // $update->ACC_NUMBER = $request->acc_number;
        // $update->ACC_TITLE = $request->acc_title;
        // $update->LOGO = ($my_image != null) ? $my_image : $request->old_logo;
        // $update->IS_ACTIVE =  (isset($request->is_active)) ? $request->is_active : '0';
        // $update->CAMPUS_ID =  Auth::user()->CAMPUS_ID;
        // $update->USER_ID = Auth::user()->id;
        // $update->save();
        $data = [
            'NAME' => $request->name,
            'ACC_NUMBER' => $request->acc_number,
            'ACC_TITLE' => $request->acc_title,
            'LOGO' => ($my_image != null) ? $my_image : $request->old_logo,
            'IS_ACTIVE' => (isset($request->is_active)) ? $request->is_active : '0',
            'CAMPUS_ID' => Auth::user()->CAMPUS_ID,
            'USER_ID' => Auth::user()->id,
        ];
        // dd($data);

        $update = Kelex_bank::where('BANK_ID',$request->BANK_ID)->update($data);
        // echo $update->toSql();
        // dd($update);
        return ['type' => 1, 'response' => 'Recoord updated Successfully..'];
    }
}
