<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tStatusTujuanDokumen;
use App\tDisposisiDokumen;

class DokumenController extends Controller
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

    /*
        Store Status Tujuan Dokumen  
    */
    public function storeStatus(Request $request,$route_doc, $tujuan_id){
        
        $this->validate($request , [
            'tgl_status' => 'required',
            'keterangan' => 'required|before or equal:tgl_masuk',
            'status' => 'required|exists:m_status_tujuan_dokumens,id',                        
        ]);

        $tujuan_status = new tStatusTujuanDokumen();
        $tujuan_status->status_tujuan_id = $request->status;
        $tujuan_status->tujuan_dokumen_id = $tujuan_id;
        $tujuan_status->keterangan = $request->keterangan;
        $tujuan_status->tgl_status = $request->tgl_status;
        $tujuan_status->save();

        $route_doc = $route_doc . '.show' ;
        
        return redirect()->route($route_doc,[$tujuan_id]);
    }

    /*
        Store Disposisi Tujuan Dokumen
    */
    public function storeDisposisi(Request $request, $tujuan_id){
                
        $this->validate($request , [
            'tgl_disposisi' => 'required',
            'disposisi_kepada' => 'required',
            'keterangan' => 'required',
            'penerima' => 'required',                        
        ]);

        $disposisi = new tDisposisiDokumen();
        $disposisi->dest_doc_id = $tujuan_id;
        $disposisi->disposisi_to = $request->disposisi_kepada;
        $disposisi->keterangan = $request->keterangan;
        $disposisi->penerima = $request->penerima;
        $disposisi->save();

        $route_doc = $route_doc . '.show' ;
        return redirect()->route($route_doc,[$tujuan_id]);
    }

    public function createStatus($route_doc,$tujuan_id){
        // apakah sudah pernah diserahkan
        $is_diserahkan = tStatusTujuanDokumen::where('tujuan_dokumen_id',$tujuan_id)
                            ->where('status_tujuan_id',2)->count(); 
        
        return view('dokumen.create_status')->with(compact('tujuan_id','is_diserahkan'));
    }

    public function createDisposisi($route_doc,$tujuan_id){
        // apakah sudah pernah diserahkan
        // $is_diserahkan = tStatusTujuanDokumen::where('tujuan_dokumen_id',$tujuan_id)
        //                     ->where('status_tujuan_id',2)->count(); 
        
        return view('dokumen.create_disposisi')->with(compact('tujuan_id','is_diserahkan'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
