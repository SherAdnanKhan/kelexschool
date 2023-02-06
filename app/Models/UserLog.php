<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    protected $table = 'user_logs';
    protected $fillable = [ 'activity_type', 'activity_id', 'description', 'user_id' ];
    protected $hidden = [ 'deleted_at', 'updated_at' ];
    protected $dates = [ 'deleted_at' ];
}
