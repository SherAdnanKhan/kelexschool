<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Image extends Model
{
    protected $fillable = [
        'path', 'title'
    ];
}
