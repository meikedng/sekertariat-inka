<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class mStatusDokumen extends Model
{

    use SoftDeletes;

    protected $fillable = [ 
        'desccription'    
    ];
}
