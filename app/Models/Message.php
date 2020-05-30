<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Message extends Model
{
    use SoftDeletes;

    protected $fillable = [ 'message', 'conversation_id', 'created_by'];
    protected $dates = [ 'deleted_at' ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
