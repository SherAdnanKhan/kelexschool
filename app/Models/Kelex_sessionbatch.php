<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelex_sessionbatch extends Model
{
    use HasFactory;
    protected $fillable = ['SB_NAME','START_DATE','END_DATE','TYPE','CAMPUS_ID','USER_ID'];
    protected $primaryKey = 'SB_ID';
    protected $softDelete = true;
}

