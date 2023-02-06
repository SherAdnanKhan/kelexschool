<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelex_class extends Model
{
    use HasFactory;
    protected $fillable = ['Class_name','CAMPUS_ID','USER_ID'];
    protected $primaryKey = 'CLASS_ID';
    protected $softDelete = true;
}

