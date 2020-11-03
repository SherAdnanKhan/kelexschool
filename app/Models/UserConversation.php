<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserConversation extends Model
{
    protected $table = 'users_conversations';
    protected $fillable = [ 'conversation_id', 'user_id', 'is_deleted', 'last_deleted_at' ];

}
