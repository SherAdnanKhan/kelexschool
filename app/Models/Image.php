<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Image extends Model
{
    protected $fillable = [
        'path', 'title'
    ];
    protected $hidden = [
        'image_type', 'image_id', 'updated_by', 'deleted_by', 'created_at', 'updated_at'
    ];

    public function image()
    {
        return $this->morphTo();
    }
}
