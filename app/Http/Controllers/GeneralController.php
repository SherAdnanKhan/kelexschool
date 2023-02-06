<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelex_sessionbatch;
use App\Models\Kelex_class;
use App\Models\Kelex_section;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GeneralController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');;

    }
    //
    public function getSections($classID)
    {
        $campus_id = Auth::user()->CAMPUS_ID;
        $where['CAMPUS_ID'] = $campus_id;
        $where['CLASS_ID'] = $classID;
       $sections = DB::table('kelex_sections')->where($where)->select('Section_id','Section_name')->get();
       return $sections;
    }
    public function getClasses()
    {
        $campus_id = Auth::user()->CAMPUS_ID;
        $where['CAMPUS_ID'] = $campus_id;
       $classess = DB::table('kelex_classes')->where($where)->select('Class_id','Class_name')->get();
       return $classess;
    }
}


