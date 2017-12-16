<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mDivisi extends Model
{
    /*
        $table->string('division_name',100)->unique();
            $table->integer('parent')->unsigned()->nullable();
            // foreign ke master direksi
            $table->integer('direktorat_id')->unsigned()->nullable();
            $table->integer('kadiv_id')->unsigned()->nullable(); 
            
    */
    protected $fillable = [ 
        'division_name','parent','direktorat_id','kadiv_id'    
    ];
}
