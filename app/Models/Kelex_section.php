<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kelex_section extends Model
{
    use HasFactory;
    protected $fillable = ['SUBJECT_NAME','SUBJECT_CODE','TYPE','CAMPUS_ID','USER_ID'];
    protected $primaryKey = 'Section_id';
    protected $softDelete = true;
}

