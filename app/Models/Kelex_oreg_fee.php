<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelex_oreg_fee extends Model
{
    use HasFactory;
    protected $fillable = ['SESSION_ID','CLASS_ID','REGFEE','CAMPUS_ID','USER_ID'];
    protected $primaryKey = 'ONLINEREGID';
    protected $softDelete = true;
}
