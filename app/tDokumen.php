<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tDokumen extends Model
{
    use SoftDeletes;

    protected $fillable = [ 
        'tipe_dok_id','tgl_masuk','nomor_dokumen','nomor_referensi','nama_dokumen','perihal','pengirim',
        'tgl_dok_referensi','penerima','tgl_keluar','tgl_kembali','is_circular','is_closed','id_user'    
    ];

    protected $dates = ['deleted_at'];

    public function tujuan(){
        return $this->hasMany('App\tTujuanDokumen','dokumen_id','id');
    }

    public function document_status(){
        return $this->belongsTo('App\mStatusDokumen','is_closed','id');
    }

    
}
