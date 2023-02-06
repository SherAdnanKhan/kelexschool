<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelex_fee_category extends Model
{
    protected $primaryKey = 'FEE_CAT_ID';
    use HasFactory;
    protected $fillable = ['CLASS_ID','SECTION_ID','CATEGORY','SHIFT','CAMPUS_ID','USER_ID'];
}
