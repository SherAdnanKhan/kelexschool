<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelex_paper_upload extends Model
{
    use HasFactory;
    protected $fillable = ['PAPER_ID','EMP_ID','DUEDATE','UPLOADSTATUS','UPLOADFILE','SESSION_ID','CLASS_ID','SUBJECT_ID',
        'SECTION_ID','CAMPUS_ID','USER_ID'];
    protected $primaryKey = 'PAPER_MARKING_ID';
    protected $softDelete = true;
}
