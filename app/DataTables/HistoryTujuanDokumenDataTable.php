<?php

namespace App\DataTables;

use App\User;
use Yajra\Datatables\Services\DataTable;
use App\tStatusTujuanDokumen;

class HistoryTujuanDokumenDataTable extends DataTable
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
            ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $tujuan_id = $this->tujuan_id;

        $query = tStatusTujuanDokumen::with('status','tujuan','tujuan.direksi')->whereIn('tujuan_dokumen_id',$tujuan_id);

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
             (['data' => 'id', 'name' => 'id' , 'title' => 'ID', 'orderable' => false,'searchable'=> false,'visible'=>false]),
             (['data' => 'tgl_status', 'name' => 'tgl_status' , 'title' => 'Tanggal', 'orderable' => true,'searchable'=> true]),
             (['data' => 'status.description', 'name' => 'status.description' , 'title' => 'Status', 'orderable' => true,'searchable'=> true]),
             (['data' => 'tujuan.urutan_ke', 'name' => 'tujuan.urutan_ke' , 'title' => 'Urutan ke-', 'orderable' => true,'searchable'=> true]),
             (['data' => 'tujuan.direksi.jabatan_direksi', 'name' => 'tujuan.direksi.jabatan_direksi' , 'title' => 'Nama Direksi', 'orderable' => true,'searchable'=> true]),
             
             //  (['data' => 'tujuan.direksi.nama_direksi', 'name' => 'tujuan.direksi.nama_direksi' , 'title' => 'Nama Direksi', 'orderable' => true,'searchable'=> true]),
             (['data' => 'keterangan', 'name' => 'urutan_ke' , 'title' => 'Keterangan', 'orderable' => false,'searchable'=> false])
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
            (['data' => 'id', 'name' => 'id' , 'title' => 'ID', 'orderable' => false,'searchable'=> false,'visible'=>false]),
             (['data' => 'tgl_status', 'name' => 'tgl_status' , 'title' => 'Tanggal', 'orderable' => true,'searchable'=> true]),
             (['data' => 'status.description', 'name' => 'status.description' , 'title' => 'Status', 'orderable' => true,'searchable'=> true]),
             (['data' => 'tujuan.urutan_ke', 'name' => 'tujuan.urutan_ke' , 'title' => 'Urutan ke-', 'orderable' => true,'searchable'=> true]),
             (['data' => 'tujuan.direksi.jabatan_direksi', 'name' => 'tujuan.direksi.jabatan_direksi' , 'title' => 'Nama Direksi', 'orderable' => true,'searchable'=> true]),
             
             //  (['data' => 'tujuan.direksi.nama_direksi', 'name' => 'tujuan.direksi.nama_direksi' , 'title' => 'Nama Direksi', 'orderable' => true,'searchable'=> true]),
             (['data' => 'keterangan', 'name' => 'urutan_ke' , 'title' => 'Keterangan', 'orderable' => false,'searchable'=> false])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'historytujuandokumen_' . time();
    }
}
