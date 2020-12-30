<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scrapeddata extends Model
{
    protected $table = 'scraped_data';
    protected $fillable = [ 'message_id',	'title'	,'description',	'image'	,'favicon',	'url'];

    public function message()
    {
      return $this->belongsTo(Message::class, 'message_id');
    }
}
