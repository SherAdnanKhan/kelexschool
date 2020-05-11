<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasSlug, SoftDeletes;
    
    protected $fillable = [
        'title', 'slug', 'description', 'created_by', 'gallery_id'
    ];
    protected $hidden = [ 'deleted_by' ];
    protected $dates = [ 'deleted_at' ];

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
}
