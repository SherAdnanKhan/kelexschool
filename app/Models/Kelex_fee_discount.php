<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelex_fee_discount extends Model
{
    use HasFactory;
    protected $primaryKey = 'DISCOUNT_ID';
    protected $fillable = ['STUDENT_ID', 'FEE_CAT_ID', 'DISCOUNT', 'USER_ID', 'CAMPUS_ID'];
}
