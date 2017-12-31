<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class tDisposisiDokumen extends Model
{
    /*
         $table->integer('dest_doc_id')->unsigned();
            $table->string('disposisi_to')->nullable();
            $table->integer('disp_user_id')->unsigned()->nullable();
            $table->longtext('keterangan');
            $table->string('penerima')->string();
           
    */

     use SoftDeletes;

    protected $fillable = [ 
            'dest_doc_id','disposisi_to','disp_user_id','keterangan','penerima'
    ];

    protected $dates = ['deleted_at'];

}
