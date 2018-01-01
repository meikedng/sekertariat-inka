<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DataTables\MonitoringDataTable;
use App\DataTables\HistoryTujuanDokumenDataTable;
use App\DataTables\ListDisposisiDokumenDataTable;
// use App\DataTables\MemoInternalDataTable;
use App\tDokumen;
use App\tTujuanDokumen;
use App\mDireksi;
use App\mDirektorat;

class MonitoringDokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function showTipeDoc(MonitoringDataTable $dataTable,$route){
        //dd($route);
        //dd($dataTable);
        return $dataTable->with('route',$route)->render('monitoring.index');
        //return $dataTable->render('memo_internal.index');
        //return view('monitoring.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showDisposisi(ListDisposisiDokumenDataTable $dataTable,$id)
    {
        // dd($id);
        $dokumen = tDokumen::find($id);
        $list_tujuan =  tTujuanDokumen::where('dokumen_id',$id)
            ->orderBy('urutan_ke')->get();
        $text_tujuan = '';

        foreach($list_tujuan as $tujuan){
            $direksi = mDireksi::select('id_direktorat','nama_direksi')
                ->where('id',$tujuan->dest_direksi_id)->first();
            $direktorat = mDirektorat::select('dir_code')
                ->where('id',$direksi->id_direktorat)->first();                
            
            $text_tujuan = $text_tujuan . $tujuan->urutan_ke . '.' . 
                            $direksi->nama_direksi. ' / ' . $direktorat->dir_code. ' <br> ';
        }

        // dd($text_tujuan);
        $tujuan_id = $list_tujuan->pluck('id');
        //dd($tujuan_id);
        $switch = 'status';

        return $dataTable->with('tujuan_id',$tujuan_id)
            ->render('monitoring.show',compact('dokumen','text_tujuan','switch'));
        //return view('monitoring.show')->with(compact('dokumen','text_tujuan'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HistoryTujuanDokumenDataTable $dataTable,$id)
    {
        // dd($id);
        $dokumen = tDokumen::find($id);
        $list_tujuan =  tTujuanDokumen::where('dokumen_id',$id)
            ->orderBy('urutan_ke')->get();
        $text_tujuan = '';

        foreach($list_tujuan as $tujuan){
            $direksi = mDireksi::select('id_direktorat','nama_direksi')
                ->where('id',$tujuan->dest_direksi_id)->first();
            $direktorat = mDirektorat::select('dir_code')
                ->where('id',$direksi->id_direktorat)->first();                
            
            $text_tujuan = $text_tujuan . $tujuan->urutan_ke . '.' . 
                            $direksi->nama_direksi. ' / ' . $direktorat->dir_code. ' <br> ';
        }

        // dd($text_tujuan);
        $tujuan_id = $list_tujuan->pluck('id');
        // dd($tujuan_id);
        $switch = 'disposisi';

        return $dataTable->with('tujuan_id',$tujuan_id)
            ->render('monitoring.show',compact('dokumen','text_tujuan','switch'));
        //return view('monitoring.show')->with(compact('dokumen','text_tujuan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
