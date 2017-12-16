<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class mStatusTujuanDokumen extends Model
{
     use SoftDeletes;

    protected $fillable = [ 
        'desccription'    
    ];
}
