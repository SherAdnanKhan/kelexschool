<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notification extends Model
{
    //public $table = 'notifications';
    protected $fillable = [ 'type', 'status', 'notifyable_type', 'notifyable_id', 'sender_id', 'receiver_id' ];
    protected $hidden = [ 'updated_at', 'notifyable_type', 'notifyable_id' ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

  
    public function user()
    {
        return $this->belongsTo(User::class, 'notifyable_id');
    }

    public function gallery()
    {
        return $this->belongsTo(Gallery::class, 'notifyable_id');
    }
    public function notifyable()
    {
        return $this->morphTo();
    }

    public function post()
    {
        return $this->morphOne(Post::class, 'notifyable');
    }

    public function feed()
    {
        return $this->belongsTo(Feed::class, 'notifyable_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return (new Carbon($value))->diffForHumans(['options' => Carbon::JUST_NOW | Carbon::ONE_DAY_WORDS | Carbon::TWO_DAY_WORDS]);
        //return Carbon::createFromFormat('Y-m-d H:i:s', $value);
    }

}
