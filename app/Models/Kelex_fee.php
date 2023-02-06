<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelex_fee extends Model
{
    use HasFactory;
    protected $fillable = [
        'CAMPUS_ID' ,
        'SESSION_ID',
        'USER_ID',
        'CLASS_ID' ,
        'SECTION_ID',
        'MONTHS' ,
        'FEE_DATA' ,
        'FEE_AMOUNT',
        'DUE_DATE',
        'STATUS'
    ];
}
