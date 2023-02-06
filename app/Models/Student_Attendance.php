<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student_Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'STD_ID',
        'SESSION_ID',
        'CLASS_ID',
        'SECTION_ID',
        'ATTEN_DATE',
        'ATTEN_STATUS',
        'USER_ID',
        'CAMPUS_ID',
        'REMARKS'
    ];
}
