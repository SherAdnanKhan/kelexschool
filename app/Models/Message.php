<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Message extends Model
{
    use SoftDeletes;

    protected $fillable = [ 'message', 'conversation_id', 'created_by', 'feel_id'];
    protected $dates = [ 'deleted_at' ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function feel()
    {
        return $this->belongsTo(Feel::class, 'feel_id');
    }
    public function messagesLogs() 
    {
        return $this->hasMany(ConversationLog::class, 'message_id', 'id')->where('user_id', \Auth::guard('api')->user()->id);
    }

    public function userMessageLog()
    {
        return $this->hasMany(ConversationLog::class, 'message_id', 'id')->where('user_id', \Auth::guard('api')->user()->id);
    }

    public function conversationLog()
    {
        return $this->hasOne(ConversationLog::class, 'message_id', 'id')->where(['call_start'=>null ,'call_end'=>null])->where( 'status' , '!=' , '2')->latest();
    }
}
