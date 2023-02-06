<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelex_exam extends Model
{
    use HasFactory;
    protected $fillable = ['EXAM_NAME','START_DATE','END_DATE','SESSION_ID','CAMPUS_ID','USER_ID'];
    protected $primaryKey = 'EXAM_ID';
    protected $softDelete = true;
}
