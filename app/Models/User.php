<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Storage;
use Carbon\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, HasSlug;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'username', 'email', 'password', 'slug', 'last_login', 'dob'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'deleted_at', 'verification_code', 'verification_code_expiry'
    ];

    protected $dates = [
        'last_login'
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


    public function getLastLoginAttribute($value)
    {
        return (new Carbon($value))->diffForHumans(['options' => Carbon::JUST_NOW | Carbon::ONE_DAY_WORDS | Carbon::TWO_DAY_WORDS]);
        //return Carbon::createFromFormat('Y-m-d H:i:s', $value);
    }

    public function avatars()
    {
        return $this->morphMany(Image::class, 'image');
    }

    public function avatar()
    {
        return $this->morphOne(Image::class, 'image');
    }

    public function art()
    {
        return $this->belongsTo(Art::class, 'art_id');
    }

    public function feel()
    {
        return $this->belongsTo(Feel::class, 'feel_id');
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'created_by', 'id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'created_by', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'created_by', 'id');
    }

    public function notify()
    {
        return $this->morphMany(Notification::class, 'notifyable');
    }
    
    public function feeds()
    {
        return $this->hasMany(Feed::class, 'created_by', 'id');
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

    public function strokeFeeds()
    {
        return $this->belongsToMany(Feed::class, 'user_stroke_feeds');
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'participants');
    }

    public function unreadMessages()
    {
        return $this->hasMany(ConversationLog::class, 'user_id')->where('status', 0);
    }

    public function userFeels()
    {
        return $this->hasMany(userFeels::class, 'user_id');
    }
    public function privacyPages()
    {
        return $this->belongsToMany(UserPrivacy::class, 'user_id')->where('privacy_type', 'App\Models\PrivacyPage');
    }

    public function privacyStrq()
    {
        return $this->hasOne(UserPrivacy::class, 'user_id')->where('privacy_type', 'App\Models\PrivacyPage')->where('privacy_id', 1);
    }

}
