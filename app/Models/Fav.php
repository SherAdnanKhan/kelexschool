<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fav extends Model
{
    protected $fillable = [
        'faved_by', 'faved_to'
    ];
}
