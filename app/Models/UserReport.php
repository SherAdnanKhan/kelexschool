<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserReport extends Model
{
    protected $table = 'user_report';
    protected $fillable = [ 'report_to', 'report_by', 'reason'];

    public function reportToUser()
    {
        return $this->belongsTo(User::class, 'report_to');
    }

    public function reportByUser()
    {
        return $this->belongsTo(User::class, 'report_by');
    }
}