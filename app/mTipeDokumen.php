<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mTipeDokumen extends Model
{
     //use SoftDeletes;

    protected $fillable = [ 
        'desccription','code'    
    ];
}
