<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelex_withdraw_student extends Model
{
    use HasFactory;
    protected $fillable = ['SESSION_ID','CLASS_ID','SECTION_ID','STATUS','STUDENT_ID','WITHDRAW_DATE','CAMPUS_ID','USER_ID'];
    protected $primaryKey = 'STD_WITHDRAW_ID';
    protected $softDelete = true;
}
