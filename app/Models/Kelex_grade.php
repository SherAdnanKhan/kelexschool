<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelex_grade extends Model
{
    protected $fillable = ['GRADE_NAME','FROM_MARKS','TO_MARKS','CAMPUS_ID','USER_ID'];
    protected $primaryKey = 'GRADE_ID';
    protected $softDelete = true;
}
