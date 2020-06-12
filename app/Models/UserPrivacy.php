<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPrivacy extends Model
{
    protected $table = 'user_privacy';
    protected $fillable = [ 'privacy_type_id', 'privacy_type', 'privacy_id', 'user_id' ];

    protected $hidden = [
        'privacy_type', 'created_at', 'updated_at'
    ];

    public function privacy_type()
    {
        return $this->belongsTo(PrivacyType::class, 'privacy_type_id');
    }
}
