<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelex_campus extends Model
{
    use HasFactory;
    protected $primaryKey = 'CAMPUS_ID';
    protected $softDelete = true;
}
