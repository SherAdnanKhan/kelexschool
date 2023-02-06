<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasSlug, SoftDeletes;
    
    protected $fillable = [
        'title', 'slug', 'description', 'created_by', 'gallery_id', 'post_type', 'shares', 'reports', 'parent_id'
    ];
    protected $hidden = [ 'deleted_by', 'deleted_at', 'updated_at', 'updated_by' ];
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

    public function art()
    {
        return $this->belongsTo(Art::class, 'art_id');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'image');
    }

    public function strokeUsers()
    {
        return $this->belongsToMany(User::class, 'user_stroke_posts');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function gallery()
    {
        return $this->belongsTo(Gallery::class, 'gallery_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    public function getCommentsCountAttribute ()
    {
        return $this->comments()->count();
    }

    public function has_stroke()
    {
        return $this->belongsToMany(User::class, 'user_stroke_posts')->where('user_id', \Auth::guard('api')->user()->id);
    }

    public function notify()
    {
        return $this->morphMany(Notification::class, 'notifyable');
    }
    public function vaults()
    {
        return $this->morphMany(Vault::class, 'vault');
    }
    public function is_vault()
    {
        return $this->hasOne(Vault::class, 'vaultable_id')->where('user_id', \Auth::guard('api')->user()->id);
    }
}
