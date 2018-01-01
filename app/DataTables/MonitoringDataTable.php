<?php

namespace App\DataTables;

use App\User;
use Yajra\Datatables\Services\DataTable;
use App\tTujuanDokumen;
use App\tDokumen;

class MonitoringDataTable extends DataTable
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
                    'show_url' => route('monitoring_dokumen.show', $doc->id),
                ]);
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
        $route = $this->route;

        if($route == 'sm_eksternal')
            $type_id = 2;
        elseif($route == 'sm_internal')
            $type_id = 1;
        elseif($route == 'memo_internal')
            $type_id = 3;
/*
        $query = tTujuanDokumen::with('dokumen','direksi')
                    ->whereHas('dokumen',function ($q) use ($type_id){
                        $q->where('tipe_dok_id',$type_id);
                    });
*/

        $query = tDokumen::where('tipe_dok_id',$type_id);
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
            (['data' => 'nomor_dokumen', 'name' => 'dokumen.nomor_dokumen' , 'title' => 'Nomor Dokumen', 'orderable' => true,'searchable'=> true]),
            (['data' => 'tgl_masuk', 'name' => 'dokumen.tgl_masuk' , 'title' => 'Tanggal Masuk', 'orderable' => true,'searchable'=> true]),
            (['data' => 'pengirim', 'name' => 'dokumen.pengirim' , 'title' => 'Nama Pengirim', 'orderable' => true,'searchable'=> true]),
            // (['data' => 'tgl_dok_referensi', 'name' => 'dokumen.tgl_dok_referensi' , 'title' => 'Tanggal Surat', 'orderable' => true,'searchable'=> true]),
            (['data' => 'perihal', 'name' => 'dokumen.perihal' , 'title' => 'Perihal', 'orderable' => true,'searchable'=> true]),
            // (['data' => 'direksi.nama_direksi', 'name' => 'direksi.nama_direksi' , 'title' => 'Nama Direksi', 'orderable' => false,'searchable'=> false]),
            // (['data' => 'urutan_ke', 'name' => 'urutan_ke' , 'title' => 'Urutan Ke-', 'orderable' => false,'searchable'=> false]),
            
            (['data'=>'show' ,'name' =>'show' , 'title' => '' ,'orderable' => false,'searchable'=> false,'exportable' => false, 'printable' => false, 'width' => '30px'])
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
            (['data' => 'id', 'name' => 'uid' , 'title' => 'ID', 'orderable' => false,'searchable'=> false,'visible'=>false]),
            (['data' => 'nomor_dokumen', 'name' => 'dokumen.nomor_dokumen' , 'title' => 'Nomor Dokumen', 'orderable' => true,'searchable'=> true]),
            (['data' => 'tgl_masuk', 'name' => 'dokumen.tgl_masuk' , 'title' => 'Tanggal Masuk', 'orderable' => true,'searchable'=> true]),
            (['data' => 'pengirim', 'name' => 'dokumen.pengirim' , 'title' => 'Nama Pengirim', 'orderable' => true,'searchable'=> true]),
            // (['data' => 'tgl_dok_referensi', 'name' => 'dokumen.tgl_dok_referensi' , 'title' => 'Tanggal Surat', 'orderable' => true,'searchable'=> true]),
            (['data' => 'perihal', 'name' => 'dokumen.perihal' , 'title' => 'Perihal', 'orderable' => true,'searchable'=> true]),
            
            (['data'=>'show' ,'name' =>'show' , 'title' => '' ,'orderable' => false,'searchable'=> false,'exportable' => false, 'printable' => false, 'width' => '30px'])            
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'monitoring_' . time();
    }
}
