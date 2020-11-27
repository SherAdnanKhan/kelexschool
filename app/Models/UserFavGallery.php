<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFavGallery extends Model
{
    public $timestamps = false;
    protected $fillable = [ 'user_id', 'gallery_id' ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
