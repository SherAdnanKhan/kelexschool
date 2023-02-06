<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelex_student_application extends Model
{
    use HasFactory;
    protected $fillable = [
        'STUDENT_ID',
        'APPLICATION_DESCRIPTION',
        'APPLICATION_TYPE',
        'START_DATE',
        'END_DATE',
        'APPROVED_AT',
        'APPLICATION_STATUS',
        'CAMPUS_ID',
        'REMARKS',
        'USER_ID'
    ];
    protected $primaryKey = "STD_APPLICATION_ID";
}
