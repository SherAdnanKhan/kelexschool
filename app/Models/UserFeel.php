<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFeel extends Model
{
    use SoftDeletes;

    protected $table = 'user_feels';
    protected $fillable = [ 'feel', 'user_id', 'feel_id' ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function feel()
    {
        return $this->belongsTo(Feel::class, 'feel_id');
    }

}
