<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelex_exam_assign extends Model
{
   
    protected $fillable = ['PAPER_ID','EMP_ID','DUEDATE','STATUS','CAMPUS_ID','USER_ID'];
    protected $primaryKey = 'ASSIGN_ID';
    protected $softDelete = true;
}
