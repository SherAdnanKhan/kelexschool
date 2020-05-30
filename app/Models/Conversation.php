<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Conversation extends Model
{
    use HasSlug;

    protected $fillable = [ 'name' ];
    protected $hidden = [ 'created_at', 'updated_at' ];


    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['name'])
            ->saveSlugsTo('name')
            ->usingSeparator('-');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'conversation_id', 'id');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'participants');
    }
}
