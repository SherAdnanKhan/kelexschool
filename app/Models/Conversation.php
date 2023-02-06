<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;

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
    public function lastMessage()
    {
        return $this->hasOne(Message::class, 'conversation_id', 'id')
                ->Where(function ($query) {
                    $query
                    ->orWhere('created_by', '!=', \Auth::guard('api')->user()->id)
                    ->orWhere('type', '!=', '4');
                })
                ->latest();
    }
    public function participants()
    {
        return $this->belongsToMany(User::class, 'participants');
    }

    public function unreadMessagesLogs()
    {
        //dd(\Auth::guard('api')->user()->id);
        return $this->hasMany(ConversationLog::class, 'conversation_id')->where('status', 0)->where('user_id', \Auth::guard('api')->user()->id);
    }

    public function deleteCheck()
    {
        return $this->hasOne(UserConversation::class, 'conversation_id', 'id')->where('user_id', \Auth::guard('api')->user()->id);
    }
    public function conversationStatus()
    {
        return $this->hasOne(UserConversation::class, 'conversation_id', 'id')->where('user_id', \Auth::guard('api')->user()->id);
    }
    
}
