<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Storage;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasSlug;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'username', 'email', 'password', 'slug', 'last_login'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['first_name', 'last_name'])
            ->saveSlugsTo('slug')
            ->usingSeparator('-');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function avatars()
    {
        return $this->morphMany(Image::class, 'image');
    }

    // public function avatars()
    // {
    //     return $this->hasMany(Image::class, 'created_by', 'id')->where('image_type', 'App\Models\User');
    // }
    
    public function art()
    {
        return $this->belongsTo(Art::class, 'art_id');
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'created_by', 'id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'created_by', 'id');
    }

    public function postsImagesRandom()
    {
        return $this->hasMany(Image::class, 'created_by', 'id')->where('image_type', 'App\Models\Post');
    }

    public function favGalleries()
    {
        return $this->belongsToMany(Gallery::class, 'user_fav_galleries');
    }

    public function strokePosts()
    {
        return $this->belongsToMany(Post::class, 'user_stroke_posts');
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'participants');
    }

    public function unreadMessages()
    {
        return $this->hasMany(MessageLog::class, 'user_id')->where('status', 0);
    }

}
