<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBlock extends Model
{
    protected $table = 'user_block';
    protected $fillable = [ 'block_to', 'block_by'];

    public function blockToUser()
    {
        return $this->belongsTo(User::class, 'block_to');
    }

    public function blockByUser()
    {
        return $this->belongsTo(User::class, 'block_by');
    }
}
