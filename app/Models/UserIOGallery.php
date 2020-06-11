<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserIOGallery extends Model
{
    protected $table = 'user_io_galleries';
    protected $fillable = [ 'gallery_id', 'user_id' ];

    protected $hidden = [ 'created_at', 'updated_at' ];
}
