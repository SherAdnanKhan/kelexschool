<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelex_exam_paper extends Model
{
    use HasFactory;
    protected $fillable = ['EXAM_ID','SUBJECT_ID','PUBLISHED','CLASS_ID','TIME','DATE','SECTION_ID','TOTAL_MARKS','PASSING_MARKS','VIVA','VIVA_MARKS','SESSION_ID','CAMPUS_ID','USER_ID'];
    protected $primaryKey = 'PAPER_ID';
    protected $softDelete = true;
}
