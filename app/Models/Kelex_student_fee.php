<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelex_student_fee extends Model
{
    use HasFactory;
    protected $fillable = ['FEE_ID','STUDENT_ID','STATUS'];
}
