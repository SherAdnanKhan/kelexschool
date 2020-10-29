<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMute extends Model
{
    protected $table = 'user_mute';
    protected $fillable = [ 'mute_to', 'mute_by'];

}
