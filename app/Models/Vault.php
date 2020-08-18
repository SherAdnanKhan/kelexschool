<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vault extends Model
{
    protected $table = 'users_vault';
    protected $fillable = [
        'vaultable_id', 'vaultable_type', 'user_id'
    ];
    protected $hidden = [ 'vaultable_type' ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'vaultable_id');
    }
}