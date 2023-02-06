<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSprvfsIO extends Model
{
    protected $table = 'user_sprfvs_selections';
    protected $fillable = [ 'status', 'privacy_type_id', 'created_to', 'created_by' ];

    protected $hidden = [ 'created_at', 'updated_at' ];
}
