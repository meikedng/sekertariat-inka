<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mSekdir extends Model
{
    protected $fillable = [ 
        'id','user_id','direksi_id','is_active'    
    ];

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }


    public function direksi(){
        return $this->belongsTo('App\mDireksi','direksi_id','id');
    }
}
