<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivacyPage extends Model
{
    protected $table = 'privacy_pages';
    protected $fillable = [ 'name' ];
    protected $hidden = [ 'created_at', 'deleted_at', 'updated_at' ];
    protected $dates = [ 'deleted_at' ];

    public function privacy()
    {
        return $this->morphOne(UserPrivacy::class, 'privacy')->where('user_id', \Auth::guard('api')->user()->id);
    }
}
