<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class General_setting extends Model
{
    use HasFactory;
    protected $primaryKey = 'SETTING_ID';
    protected $fillable = ['FEE_TERMS_CONDETIONS', 'CAMPUS_ID', 'USER_ID'];
}
