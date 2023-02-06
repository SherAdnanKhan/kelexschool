<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelex_staff_application extends Model
{
    protected $fillable = [
        'EMP_ID',
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
    protected $primaryKey = "STAFF_APP_ID";
    use HasFactory;
}
