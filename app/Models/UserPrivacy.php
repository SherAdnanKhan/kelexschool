<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPrivacy extends Model
{
    protected $table = 'user_privacy';

    protected $hidden = [
        'privacy_type', 'created_at', 'updated_at'
    ];
}
