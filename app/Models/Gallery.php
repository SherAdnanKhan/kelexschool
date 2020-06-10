<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use HasSlug, SoftDeletes;
    
    protected $fillable = [
        'title', 'slug', 'created_by'
    ];
    protected $hidden = [ 'deleted_at', 'deleted_by' ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->usingSeparator('-');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'gallery_id', 'id');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'image');
    }

    public function favGalleries()
    {
        return $this->belongsToMany(User::class, 'user_fav_galleries');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function privacy()
    {
        return $this->morphOne(UserPrivacy::class, 'privacy');
    }
    
}
