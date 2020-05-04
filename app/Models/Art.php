<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Art extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'parent_id'];
    
    public function parent()
    {
        return $this->belongsTo(Art::class,'parent_id')->where('parent_id',null)->with('parent');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
