<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class mDirektorat extends Model
{
    /*
         $table->string('nama_direktorat');
         $table->string('dir_code',10);
          
    */
    use SoftDeletes;

    protected $fillable = [ 
        'nama_direktorat','dir_code'    
    ];

    protected $dates = ['deleted_at'];

}
