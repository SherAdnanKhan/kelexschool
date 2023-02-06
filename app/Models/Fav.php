<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fav extends Model
{
    public $table = 'users_favs';
    protected $fillable = [
        'faved_by', 'faved_to'
    ];
}
