<?php

namespace App\Http\Controllers;

use App\Models\Kelex_class;
use Illuminate\Http\Request;
use App\Models\Kelex_sessionbatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CertificateController extends Controller
{
    public function index_slc()
    {
        $class= Kelex_class::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
        $session= Kelex_sessionbatch::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();
        return view('Admin.CertificateManagement.index_SLC')->with(['classes'=>$class,'sessions'=>$session]);
      
    }
    public function print_slc($STUDENT_ID)
    {
        $SLCDATA=  DB::table('kelex_withdraw_students')
        ->leftJoin('kelex_students', 'kelex_withdraw_students.STUDENT_ID', '=', 'kelex_students.STUDENT_ID')
        ->where('kelex_withdraw_students.CAMPUS_ID','=', Session::get('CAMPUS_ID'))
        ->where('kelex_withdraw_students.STUDENT_ID','=', $STUDENT_ID)
        ->select('kelex_students.*','kelex_withdraw_students.WITHDRAW_DATE','kelex_withdraw_students.CLASS_ID','kelex_withdraw_students.STD_WITHDRAW_ID')
        ->first();

        $class= Kelex_class::where('CAMPUS_ID',Session::get('CAMPUS_ID'))->get();

        return view('Admin.CertificateManagement.print_SLC')->with(['SLCDATA'=>$SLCDATA,'classes'=>$class]);
      
    }
 
}
