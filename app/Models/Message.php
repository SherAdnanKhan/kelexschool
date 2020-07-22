<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Message extends Model
{
    use SoftDeletes;

    protected $fillable = [ 'message', 'conversation_id', 'feel_color', 'created_by', 'feel_id'];
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
        return $this->hasMany(MessageLog::class, 'message_id', 'id');
    }

    public function userMessageLog()
    {
        return $this->hasMany(MessageLog::class, 'message_id', 'id')->where('user_id', \Auth::guard('api')->user()->id);
    }
}
