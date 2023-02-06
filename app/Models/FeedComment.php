<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedComment extends Model
{
    protected $fillable = [ 'feed_id', 'comment', 'created_by' ];

    protected $hidden = [ 'updated_at', 'deleted_at' ];

    public function user()
    {
      return $this->belongsTo(User::class, 'created_by');
    }

    public function feed()
    {
      return $this->belongsTo(Feed::class, 'feed_id');
    }
}
