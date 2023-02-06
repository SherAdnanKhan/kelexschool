<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelex_paper_attendance extends Model
{
    use HasFactory;
    
    protected $fillable = ['STATUS','STD_ID','EXAM_ID','PAPER_ID','SECTION_ID','SUBJECT_ID','CLASS_ID','ATTEN_STATUS','ATTEN_DATE',
    'REMARKS','SESSION_ID','CAMPUS_ID','USER_ID'];
    protected $primaryKey = 'STD_ATTENDANCE_ID';
    protected $softDelete = true;
}
