<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelex_employee extends Model
{
    use HasFactory;
    protected $primaryKey = 'EMP_ID';
    use HasFactory;
    protected $fillable = ['EMP_NO','EMP_NAME','USERNAME','FATHER_NAME','GENDER','CNIC','DESIGNATION_ID','QUALIFICATION','EMP_TYPE','ADDRESS','PASSWORD','EMP_IMAGE','CREATED_BY','JOINING_DATE','LEAVING_DATE','EMP_DOB','ALLOWANCESS','ADDED_BY','CAMPUS_ID'];
}
