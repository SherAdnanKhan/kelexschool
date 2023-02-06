<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';
    protected $fillable = [ 'feedback', 'created_by' ];
    protected $hidden = [ 'created_at', 'updated_at' ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'image');
    }
}
