<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    protected $fillable = [ 'feed', 'parent_id', 'created_by', 'feel_color' ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function parent()
    {
        return $this->belongsTo(Feed::class,'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'image');
    }

    public function comments()
    {
        return $this->hasMany(FeedComment::class)->orderBy('created_at', 'DESC');
    }

    public function limited_comments()
    {
        return $this->hasMany(FeedComment::class)->orderBy('created_at', 'DESC')->limit(4);
    }
}
