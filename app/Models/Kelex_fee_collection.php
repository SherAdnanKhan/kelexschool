<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelex_fee_collection extends Model
{
    use HasFactory;
    protected $fillable = [
        'PAID_AMOUNT',
        'SESSION_ID',
        'REMAING',
        'STUDENT_ID',
        'FEE_ID',
        'USER_ID',
        'AMOUNT',
        'CAMPUS_ID',
        'PAYMENT_STATUS',
        'PAYMENT_TYPE',
    ];
}
