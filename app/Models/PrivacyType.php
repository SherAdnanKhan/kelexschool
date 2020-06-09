<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivacyType extends Model
{
    protected $fillable = [ 'name', 'description' ];
    protected $hidden = [ 'created_at', 'deleted_at', 'updated_at' ];
    protected $dates = [ 'deleted_at' ];
}
