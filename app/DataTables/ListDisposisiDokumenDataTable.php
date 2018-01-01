<?php

namespace App\DataTables;

use App\User;
use Yajra\Datatables\Services\DataTable;
use App\tDisposisiDokumen;

class ListDisposisiDokumenDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @return \Yajra\Datatables\Engines\BaseEngine
     */
    public function dataTable()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'listdisposisidokumen.action');
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $tujuan_id = $this->tujuan_id;
        $query = tDisposisiDokumen::with('tujuan','tujuan.direksi')->whereIn('dest_doc_id',$tujuan_id);
        
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
            (['data' => 'tujuan.urutan_ke', 'name' => 'tujuan.urutan_ke' , 'title' => 'Urutan ke-', 'orderable' => true,'searchable'=> true]),
            (['data' => 'tujuan.direksi.nama_direksi', 'name' => 'tujuan.direksi.nama_direksi' , 'title' => 'Nama Direksi', 'orderable' => true,'searchable'=> true]),
            (['data' => 'disposisi_to', 'name' => 'disposisi_to' , 'title' => 'Kepada', 'orderable' => false,'searchable'=> false]),
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
            (['data' => 'tujuan.urutan_ke', 'name' => 'tujuan.urutan_ke' , 'title' => 'Urutan ke-', 'orderable' => true,'searchable'=> true]),
            (['data' => 'tujuan.direksi.nama_direksi', 'name' => 'tujuan.direksi.nama_direksi' , 'title' => 'Nama Direksi', 'orderable' => true,'searchable'=> true]),
            (['data' => 'disposisi_to', 'name' => 'disposisi_to' , 'title' => 'Kepada', 'orderable' => false,'searchable'=> false])
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
        return 'listdisposisidokumen_' . time();
    }
}
