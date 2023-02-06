<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelex_timetable extends Model
{
    use HasFactory;
    protected $fillable = ['EMP_ID','GROUP_ID','CLASS_ID','SECTION_ID','SUBJECT_ID','DAY','TIMEFROM','TIMETO','CAMPUS_ID','USER_ID'];
    protected $primaryKey = 'TIMETABLE_ID';
    protected $softDelete = true;
    protected $casts = [
        'TIMEFROM' => 'datetime:H:i',
        'TIMETO' => 'datetime:H:i',
    ];
}
