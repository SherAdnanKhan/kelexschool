<?php

namespace App\Traits;

use App\Models\Kelex_campus;
use App\Models\Kelex_employee;
use App\Models\Kelex_oreg_fee;

trait SchoolTrait
{
    public function getcampusdetails($url)
    {

        $campus= Kelex_campus::where('SCHOOL_WEBSITE',$url)->first();

        return $campus;
    }
    public function getemployeedetails($campus)
    {
        $employee= Kelex_employee::where('CAMPUS_ID',$campus['CAMPUS_ID'])->get();

        return $employee;
    }
    public function getClasses($campus)
    {
        $class= Kelex_oreg_fee::where('CAMPUS_ID',$campus['CAMPUS_ID'])->get();

        return $class;
    }


}
?>
