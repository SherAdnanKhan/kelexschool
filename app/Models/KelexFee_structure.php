<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelexFee_structure extends Model
{
    use HasFactory;
    protected $fillable = ['SESSION_ID', 'CAMPUS_ID', 'USER_ID','CLASS_ID','SECTION_ID','FEE_CATEGORY_ID','CATEGORY_AMOUNT'];
    protected $primaryKey = 'FEE_STRUCTURE_ID';
    protected $softDelete = true;
}
