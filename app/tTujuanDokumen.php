<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\mDireksi;

class tTujuanDokumen extends Model
{
    use SoftDeletes;
    protected $fillable = [ 
        'dokumen_id','urutan_ke','dest_direksi_id'    
    ];

    protected $dates = ['deleted_at'];

    public function direksi(){
        return $this->belongsTo('App\mDireksi','dest_direksi_id','id');
    }

    public function dokumen(){
        return$this->belongsTo('App\tDokumen','dokumen_id','id');
    }

}
