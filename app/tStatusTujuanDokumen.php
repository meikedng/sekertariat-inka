<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tStatusTujuanDokumen extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tujuan_dokumen_id','status_tujuan_id','keterangan','tgl_status' 
    ];

    protected $dates = ['deleted_at'];

    public function tujuan(){
        return $this->belongsTo
        ('App\tTujuanDokumen','tujuan_dokumen_id','id');
    }

    public function status(){
        return $this->belongsTo('App\mStatusTujuanDokumen','status_tujuan_id','id');
    }
}
