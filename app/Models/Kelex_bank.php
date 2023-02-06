<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelex_bank extends Model
{
    use HasFactory;
    protected $fillable = [
        'NAME',
        'ACC_TITLE',
        'ACC_NUMBER',
        'IS_ACTIVE',
        'LOGO',
        'CAMPUS_ID',
        'USER_ID'
    ];
    protected $primaryKey = 'BANK_ID';
    protected $softDelete = true;
}
