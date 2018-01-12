<?php

namespace App\DataTables;

use App\User;
use Yajra\Datatables\Services\DataTable;
use App\tDokumen;
use Illuminate\Support\Facades\Auth;
use App\mSekdir;
use App\mDireksi;
use App\tTujuanDokumen;

class smInternalDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @return \Yajra\Datatables\Engines\BaseEngine
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('show', function($doc){
                return view ('datatable._show',[
                    'model'    => $doc,
                    'show_url' => route('doc.show', ['sm_internal',$doc->id]),
                ]);
            })
            ->addColumn('delete', function($doc){
                $user_id = Auth::id();

                if($doc->dokumen->id_user == $user_id){
                    return view ('datatable._delete',[
                        'model'    => $doc,
                        'delete_url' => route('document_process.destroy', $doc->id),                    
                        'confirm_message' => 'Yakin mau menghapus ' . $doc->nomor_dokumen . '?'
                    ]);    
                }else{
                    return view ('datatable._delete_disabled');
                }
            })
            ->rawColumns(['show'])
            ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $user_id = Auth::id();
        $direksi = mSekdir::where('user_id',$user_id)->get();
        
        $query = tTujuanDokumen::with('dokumen','direksi')
                    ->whereHas('dokumen',function ($q){
                        $q->where('tipe_dok_id',1);
                    })
                    ->whereHas('direksi',function ($q) use ($direksi){
                        $q->whereIn('id',$direksi->pluck('direksi_id'));
                    });

        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
        ->columns([
            (['data' => 'id', 'name' => 'uid' , 'title' => 'ID', 'orderable' => false,'searchable'=> false,'visible'=>false]),
            (['data' => 'dokumen.nomor_dokumen', 'name' => 'dokumen.nomor_dokumen' , 'title' => 'Nomor Dokumen', 'orderable' => true,'searchable'=> true]),
            (['data' => 'dokumen.tgl_masuk', 'name' => 'dokumen.tgl_masuk' , 'title' => 'Tanggal Masuk', 'orderable' => true,'searchable'=> true]),
            (['data' => 'dokumen.pengirim', 'name' => 'dokumen.pengirim' , 'title' => 'Nama Pengirim', 'orderable' => true,'searchable'=> true]),
            // (['data' => 'dokumen.tgl_dok_referensi', 'name' => 'dokumen.tgl_dok_referensi' , 'title' => 'Tanggal Surat', 'orderable' => true,'searchable'=> true]),
            (['data' => 'dokumen.perihal', 'name' => 'dokumen.perihal' , 'title' => 'Perihal', 'orderable' => true,'searchable'=> true]),
            (['data' => 'direksi.jabatan_direksi', 'name' => 'direksi.jabatan_direksi' , 'title' => 'Nama Direksi', 'orderable' => false,'searchable'=> false]),
           
            // (['data' => 'direksi.nama_direksi', 'name' => 'direksi.nama_direksi' , 'title' => 'Nama Direksi', 'orderable' => false,'searchable'=> false]),
            (['data' => 'urutan_ke', 'name' => 'urutan_ke' , 'title' => 'Urutan Ke-', 'orderable' => false,'searchable'=> false]),
            (['data'=>'show' ,'name' =>'show' , 'title' => '' ,'orderable' => false,'searchable'=> false,'exportable' => false, 'printable' => false, 'width' => '30px']),
            (['data'=>'delete' ,'name' =>'delete' , 'title' => '' ,'orderable' => false,'searchable'=> false,'exportable' => false, 'printable' => false, 'width' => '30px'])
    
        ])
        
        ->parameters([
            'buttons' => ['excel', 'reset', 'reload'],
            'dom' => '<"row"<"col-sm-4"l><"col-sm-5"B><"col-sm-3"f>><"row"<"col-sm-12"tr>><"row"<"col-sm-5"i><"col-sm-7"p>>',  
        ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            (['data' => 'dokumen.nomor_dokumen', 'name' => 'dokumen.nomor_dokumen' , 'title' => 'Nomor Dokumen', 'orderable' => true,'searchable'=> true]),
            (['data' => 'dokumen.tgl_masuk', 'name' => 'dokumen.tgl_masuk' , 'title' => 'Tanggal Masuk', 'orderable' => true,'searchable'=> true]),
            (['data' => 'dokumen.pengirim', 'name' => 'dokumen.pengirim' , 'title' => 'Nama Pengirim', 'orderable' => true,'searchable'=> true]),
            (['data' => 'dokumen.perihal', 'name' => 'dokumen.perihal' , 'title' => 'Perihal', 'orderable' => true,'searchable'=> true]),
            (['data' => 'direksi.jabatan_direksi', 'name' => 'direksi.jabatan_direksi' , 'title' => 'Nama Direksi', 'orderable' => false,'searchable'=> false]),           
            (['data' => 'urutan_ke', 'name' => 'urutan_ke' , 'title' => 'Urutan Ke-', 'orderable' => false,'searchable'=> false]),
            
            (['data'=>'show' ,'name' =>'show' , 'title' => '' ,'orderable' => false,'searchable'=> false,'exportable' => false, 'printable' => false, 'width' => '30px']),
            (['data'=>'delete' ,'name' =>'delete' , 'title' => '' ,'orderable' => false,'searchable'=> false,'exportable' => false, 'printable' => false, 'width' => '30px'])
    ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'sminternal_' . time();
    }
}
