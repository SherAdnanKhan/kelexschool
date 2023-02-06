<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelex_paper_mark extends Model
{
    use HasFactory;
    protected $fillable = ['STATUS','STUDENT_ID','EXAM_ID','PAPER_ID','SECTION_ID','SUBJECT_ID','CLASS_ID','TOB_MARKS','REMARKS','VOB_MARKS','TOTAL_MARKS','SESSION_ID','CAMPUS_ID','USER_ID'];
    protected $primaryKey = 'MARKS_ID';
    protected $softDelete = true;
}
