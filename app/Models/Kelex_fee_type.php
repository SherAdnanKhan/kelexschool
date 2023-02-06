<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelex_fee_type extends Model
{
    use HasFactory;
    protected $fillable = ['CLASS_ID','SECTION_ID','FEE_CAT_ID','SHIFT','SESSION_ID','CAMPUS_ID','CREATED_BY','UPDATE_BY','FEE_TYPE'];
}
