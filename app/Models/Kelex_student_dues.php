<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelex_student_dues extends Model
{
    use HasFactory;
    protected $fillable = [
        'STUDENT_ID',
        'FEE_ID',
        'USER_ID',
        'AMOUNT',
        'CAMPUS_ID',
        'TYPE'
    ];
}
