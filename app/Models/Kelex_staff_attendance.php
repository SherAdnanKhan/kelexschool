<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelex_staff_attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'EMP_ID',
        'ATTEN_DATE',
        'ATTEN_STATUS',
        'USER_ID',
        'CAMPUS_ID',
        'REMARKS'
    ];
}
