<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Art extends Model
{
    public $timestamps = false;
    protected $table = 'arts';
    protected $fillable = [ 'name', 'parent_id' ];
    protected $hidden = [ 'deleted_at' ];
    
    public function parent()
    {
        //return $this->belongsTo(Art::class,'parent_id')->with('parent'); //for nested parents
        return $this->belongsTo(Art::class,'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
