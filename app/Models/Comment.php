<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = [ 'description', 'created_by', 'post_id' ];
    protected $hidden = [ 'deleted_by', 'deleted_at', 'updated_at', 'updated_by' ];
    protected $dates = [ 'deleted_at' ];

    public function getCreatedAtAttribute($value)
    {
        $now = new \DateTime;
        $ago = new \DateTime($value);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        //if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
        //return $value;
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
