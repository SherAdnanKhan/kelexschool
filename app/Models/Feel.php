<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feel extends Model
{
    protected $fillable = [ 'name', 'image_path', 'color' ];
    protected $hidden = [ 'updated_at' ];

}
