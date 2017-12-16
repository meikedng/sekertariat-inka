<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class mDireksi extends Model
{
    /*
        $table->string('nama_direksi');
        $table->integer('id_direktorat');
        
    */

    use SoftDeletes;

    protected $fillable = [ 
        'nama_direksi','id_direktorat'    
    ];

    protected $dates = ['deleted_at'];

    public function direktorat(){
        return $this->belongsTo('App\mDirektorat','id_direktorat','id');
    }

}
