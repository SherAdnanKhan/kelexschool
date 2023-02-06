<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConversationLog extends Model
{
    use SoftDeletes;
    public $table = 'conversations_logs';

    protected $fillable = [ 'message_id', 'conversation_id', 'user_id', 'status', 'call_start', 'call_end', 'read_at', 'feel_id'];
    protected $dates = [ 'deleted_at' ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function feel()
    {
        return $this->belongsTo(Feel::class, 'feel_id');
    }
    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }

    public function message()
    {
        return $this->belongsTo(Message::class, 'message_id');
    }
}
