<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\mSekdir;
use App\mTipeDokumen;
use Carbon\Carbon;
use App\tDokumen;
use App\tTujuanDokumen;
use App\tStatusTujuanDokumen;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Datatables;
use App\tDisposisiDokumen;
use App\DataTables\ViewDisposisiDataTable;

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

        if($request->status == 4) // selesai, auto-create telah diserahkan untuk dokumen selanjutnya
        {
            $recentTujuanDoc = tTujuanDokumen::find($tujuan_id);
            $nextDest = $recentTujuanDoc->urutan_ke + 1;
            // dd($tujuan_id,$recentTujuanDoc,$nextDest);
            $nextDestofDoc = tTujuanDokumen::select('id')
                ->where('dokumen_id',$recentTujuanDoc->dokumen_id)
                ->where('urutan_ke',$nextDest)->first();

            // dd($tujuan_id,$recentTujuanDoc,$nextDest,$nextDestofDoc);
            
            // belum tujuan terakhir 
            if(!is_null($nextDestofDoc)){
                $status = new tStatusTujuanDokumen();
                $status->tujuan_dokumen_id = $nextDestofDoc->id; 
                $status->status_tujuan_id = 2; // diserahkan 
                $status->keterangan = 'Dokumen telah diserahkan';
                $status->tgl_status = Carbon::now()->toDateString();
                $status->save();
            }
            // ini tujuan terakhir, berarti closing document
            elseif(is_null($nextDestofDoc)){
                $document= tDokumen::find($recentTujuanDoc->dokumen_id);
                $document->is_closed = 3; // Done
                $document->save();
            }
        }
        
        return redirect()->route('doc.show',[$route_doc,$tujuan_id]);
    }

    /*
        Store Disposisi Tujuan Dokumen
    */
    public function storeDisposisi(Request $request,$route_doc, $tujuan_id){
                
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

        // $route_doc = 'dokumen/'. $route_doc . '/show/' . $tujuan_id ;
        
        return redirect()->route('doc.show',[$route_doc,$tujuan_id]);
    }

    public function storePenerima(Request $request,$route_doc, $tujuan_id){
                
        $this->validate($request , [
            'tgl_penerimaan' => 'required',
            
            'penerima' => 'required',                        
        ]);
        
        $tujuan = tTujuanDokumen::select('dokumen_id')->where('id',$tujuan_id)->first();
        $dokumen = tDokumen::find($tujuan->dokumen_id);
        $dokumen->penerima = $request->penerima;
        $dokumen->tgl_keluar = $request->tgl_penerimaan;
        $dokumen->is_closed = 3; // Dokumen
        $dokumen->save();
        
        return redirect()->route('doc.show',[$route_doc,$tujuan_id]);
    }

    public function createStatus($route_doc,$tujuan_id){
        // apakah sudah pernah diserahkan
        if($route_doc == 'sm_eksternal')
        {
            $text = 'Surat Masuk Eksternal';
            $route = $route_doc;
        }
        elseif($route_doc == 'sm_internal')
        {
            $text = 'Surat Masuk Internal';
            $route = $route_doc;
        }
        elseif($route_doc == 'memo_internal')
        {
            $text = 'Memo Internal';
            $route = $route_doc;
        }
        
        $is_diserahkan = tStatusTujuanDokumen::where('tujuan_dokumen_id',$tujuan_id)
                            ->where('status_tujuan_id',2)->count(); 
        
        return view('dokumen.create_status')->with(compact('tujuan_id','is_diserahkan','text','route'));
    }

    public function createDisposisi($route_doc,$tujuan_id){
        
        if($route_doc == 'sm_eksternal')
        {
            $text = 'Surat Masuk Eksternal';
            $route = $route_doc;
        }
        elseif($route_doc == 'sm_internal')
        {
            $text = 'Surat Masuk Internal';
            $route = $route_doc;
        }
        elseif($route_doc == 'memo_internal')
        {
            $text = 'Memo Internal';
            $route = $route_doc;
        }

        return view('dokumen.create_disposisi')->with(compact('tujuan_id','is_diserahkan','text','route'));
    }

    public function createPenerima($route_doc,$tujuan_id){
        
        if($route_doc == 'sm_eksternal')
        {
            $text = 'Surat Masuk Eksternal';
            $route = $route_doc;
        }
        elseif($route_doc == 'sm_internal')
        {
            $text = 'Surat Masuk Internal';
            $route = $route_doc;
        }
        elseif($route_doc == 'memo_internal')
        {
            $text = 'Memo Internal';
            $route = $route_doc;
        }

        return view('dokumen.create_penerima')->with(compact('tujuan_id','is_diserahkan','text','route'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Builder $htmlBuilder,$route_doc,$tujuan_id)
    {

        if($route_doc == 'sm_eksternal')
        {
            $text = 'Surat Masuk Eksternal';
            $route = $route_doc ;
        }
        elseif($route_doc == 'sm_internal')
        {
            $text = 'Surat Masuk Internal';
            $route = $route_doc ;
        }
        elseif($route_doc == 'memo_internal')
        {
            $text = 'Memo Internal';
            $route = $route_doc ;
        }


        $tujuan_doc = tTujuanDokumen::where('id',$tujuan_id)->first();
        // dd($tujuan_doc);
        $dokumen = tDokumen::find($tujuan_doc->dokumen_id);

        //is last dokumen
        $tujuan_next = $tujuan_doc->urutan_ke +1;
        // dd($tujuan_next);
        $tujuan_next = tTujuanDokumen::where('dokumen_id',$dokumen->id)->where('urutan_ke',$tujuan_next)->first();
        
        if(is_null($tujuan_next))
            $is_last=1;
        elseif(!is_null($tujuan_next))
            $is_last=0;

        if ($tujuan_doc->urutan_ke==1)
        {
            $is_done_prev= 1; // karena ini tujuan pertama
            $is_done = tStatusTujuanDokumen::where('tujuan_dokumen_id',$tujuan_doc->id)
                                    ->where('status_tujuan_id',4)
                                    ->count();
        }
        
        elseif($tujuan_doc->urutan_ke >1){
            if($dokumen->is_circular == 0){
                $urutan = $tujuan_doc->urutan_ke;
                
                $prev_urutan = $urutan - 1;

                if($prev_urutan > 0){
                    // cari tujuan sebelumnya
                    $prev_tujuan_doc = tTujuanDokumen::where('dokumen_id',$dokumen->id)
                                    ->where('urutan_ke',$prev_urutan)
                                    ->first();   

                    // apakah tujuan sebelumnya selesai ?
                    $is_done_prev = tStatusTujuanDokumen::where('tujuan_dokumen_id',$prev_tujuan_doc->id)
                                    ->where('status_tujuan_id',4)
                                    ->count();

                    
                    if($is_done_prev > 0){
                        $is_done = tStatusTujuanDokumen::where('tujuan_dokumen_id',$tujuan_id)
                            ->where('status_tujuan_id',4)
                            ->count();
                    }else{
                        $is_done =0;
                    }

                }elseif($prev_urutan == 0){
                        $is_done_prev = 1;    
                        $is_done = tStatusTujuanDokumen::where('tujuan_dokumen_id',$tujuan_id)
                            ->where('status_tujuan_id',4)
                            ->count();
                        
                }                
            }elseif($dokumen->is_circular==1){
                $urutan = $tujuan_doc->urutan_ke;
                $prev_urutan = $urutan - 1;
                
                // urutan 2 dan 3 bisa saling mendahului
                if($prev_urutan == 1 || $prev_urutan == 2){
                    // boleh saling mendahului asalkan 
                    // tujuan pertama telah selesai
                    $prev_tujuan_doc = tTujuanDokumen::where('dokumen_id',$dokumen->id)
                                    ->where('urutan_ke',1)
                                    ->first(); 

                    $is_done_prev = tStatusTujuanDokumen::where('tujuan_dokumen_id',$prev_tujuan_doc->id)
                                    ->where('status_tujuan_id',4)
                                    ->count();

                    $is_done = tStatusTujuanDokumen::where('tujuan_dokumen_id',$tujuan_id)
                            ->where('status_tujuan_id',4)
                            ->count();
                }elseif($prev_urutan==3){
                    $second_tujuan_doc = tTujuanDokumen::where('dokumen_id',$dokumen->id)
                                    ->where('urutan_ke',2)
                                    ->first(); 

                    $is_done_second = tStatusTujuanDokumen::where('tujuan_dokumen_id',$second_tujuan_doc->id)
                                    ->where('status_tujuan_id',4)
                                    ->count();

                    $third_tujuan_doc = tTujuanDokumen::where('dokumen_id',$dokumen->id)
                                    ->where('urutan_ke',3)
                                    ->first(); 

                    $is_done_third = tStatusTujuanDokumen::where('tujuan_dokumen_id',$third_tujuan_doc->id)
                                    ->where('status_tujuan_id',4)
                                    ->count();

                    if($is_done_second >0 && $is_done_third > 0){
                        $is_done_prev = 1;

                        $is_done = tStatusTujuanDokumen::where('tujuan_dokumen_id',$tujuan_id)
                            ->where('status_tujuan_id',4)
                            ->count();
                    }elseif($is_done_second == 0 || $is_done_third == 0){
                        $is_done_prev = 0;

                        $is_done = tStatusTujuanDokumen::where('tujuan_dokumen_id',$tujuan_id)
                            ->where('status_tujuan_id',4)
                            ->count();
                    }
                }
            }
        }
        
        if($request->ajax()){
            $list_status_tujuan = tStatusTujuanDokumen::with('status')
                 ->whereHas('tujuan',function ($q) use ($dokumen,$tujuan_doc){
                        $q->where('dokumen_id',$dokumen->id);
                        $q->where('dest_direksi_id',$tujuan_doc->dest_direksi_id);
                    });
            return Datatables::of($list_status_tujuan)
        
            ->addColumn('delete', function($stat){
                if($stat->status_tujuan_id ==2)
                    return view ('datatable._delete_disabled');
                else{
                    return view ('datatable._delete',[
                        'model'    => $stat,
                        'delete_url' => route('document.destroy_status', $stat->id),                    
                        'confirm_message' => 'Yakin mau menghapus status dokumen ?',
                    ]);
                }  
            })

            ->rawColumns(['delete'])
            
            ->make(true);
        }

        $html = $htmlBuilder
            ->addColumn(['data' => 'tgl_status', 'name' => 'tgl_status' , 'title' => 'Tanggal'])
            ->addColumn(['data' => 'status.description', 'name' => 'status.description' , 'title' => 'Status'])
            ->addColumn(['data' => 'keterangan', 'name' => 'keterangan' , 'title' => 'Keterangan'])
            ->addColumn(['data' => 'delete', 'name' => 'delete' , 'title' => '']);
      
        $switch_to = 'disposisi';

        return view('dokumen.show')->with(compact('dokumen','tujuan_id','html','is_done',
                    'is_done_prev','text','route','is_last','switch_to'));

        // return $dataTable->with('tujuan_id',$tujuan_id)
        //             ->render('dokumen.show',
        //             compact('dokumen','html','tujuan_id','is_done','is_done_prev','text','route','is_last'));
    }


    public function showDisposisi(Request $request, Builder $htmlBuilder,$route_doc,$tujuan_id)
    {
        if($route_doc == 'sm_eksternal')
        {
            $text = 'Surat Masuk Eksternal';
            $route = $route_doc ;
        }
        elseif($route_doc == 'sm_internal')
        {
            $text = 'Surat Masuk Internal';
            $route = $route_doc ;
        }
        elseif($route_doc == 'memo_internal')
        {
            $text = 'Memo Internal';
            $route = $route_doc ;
        }


        $tujuan_doc = tTujuanDokumen::where('id',$tujuan_id)->first();
        // dd($tujuan_doc);
        $dokumen = tDokumen::find($tujuan_doc->dokumen_id);
        
        //is last dokumen
        $tujuan_next = $tujuan_doc->urutan_ke +1;
        $tujuan_next = tTujuanDokumen::where('dokumen_id',$dokumen->id)->where('urutan_ke',$tujuan_next)->first();
        
        if(is_null($tujuan_next))
            $is_last=1;
        elseif(!is_null($tujuan_next))
            $is_last=0;

        if ($tujuan_doc->urutan_ke==1)
        {
            $is_done_prev= 1; // karena ini tujuan pertama
            $is_done = tStatusTujuanDokumen::where('tujuan_dokumen_id',$tujuan_doc->id)
                                    ->where('status_tujuan_id',4)
                                    ->count();
        }
        
        elseif($tujuan_doc->urutan_ke >1){
            if($dokumen->is_circular == 0){
                $urutan = $tujuan_doc->urutan_ke;
                
                $prev_urutan = $urutan - 1;

                if($prev_urutan > 0){
                    // cari tujuan sebelumnya
                    $prev_tujuan_doc = tTujuanDokumen::where('dokumen_id',$dokumen->id)
                                    ->where('urutan_ke',$prev_urutan)
                                    ->first();   

                    // apakah tujuan sebelumnya selesai ?
                    $is_done_prev = tStatusTujuanDokumen::where('tujuan_dokumen_id',$prev_tujuan_doc->id)
                                    ->where('status_tujuan_id',4)
                                    ->count();

                    
                    if($is_done_prev > 0){
                        $is_done = tStatusTujuanDokumen::where('tujuan_dokumen_id',$tujuan_id)
                            ->where('status_tujuan_id',4)
                            ->count();
                    }else{
                        $is_done =0;
                    }

                }elseif($prev_urutan == 0){
                        $is_done_prev = 1;    
                        $is_done = tStatusTujuanDokumen::where('tujuan_dokumen_id',$tujuan_id)
                            ->where('status_tujuan_id',4)
                            ->count();
                        
                }                
            }elseif($dokumen->is_circular==1){
                $urutan = $tujuan_doc->urutan_ke;
                $prev_urutan = $urutan - 1;
                
                // urutan 2 dan 3 bisa saling mendahului
                if($prev_urutan == 1 || $prev_urutan == 2){
                    // boleh saling mendahului asalkan 
                    // tujuan pertama telah selesai
                    $prev_tujuan_doc = tTujuanDokumen::where('dokumen_id',$dokumen->id)
                                    ->where('urutan_ke',1)
                                    ->first(); 

                    $is_done_prev = tStatusTujuanDokumen::where('tujuan_dokumen_id',$prev_tujuan_doc->id)
                                    ->where('status_tujuan_id',4)
                                    ->count();

                    $is_done = tStatusTujuanDokumen::where('tujuan_dokumen_id',$tujuan_id)
                            ->where('status_tujuan_id',4)
                            ->count();
                }elseif($prev_urutan==3){
                    $second_tujuan_doc = tTujuanDokumen::where('dokumen_id',$dokumen->id)
                                    ->where('urutan_ke',2)
                                    ->first(); 

                    $is_done_second = tStatusTujuanDokumen::where('tujuan_dokumen_id',$second_tujuan_doc->id)
                                    ->where('status_tujuan_id',4)
                                    ->count();

                    $third_tujuan_doc = tTujuanDokumen::where('dokumen_id',$dokumen->id)
                                    ->where('urutan_ke',3)
                                    ->first(); 

                    $is_done_third = tStatusTujuanDokumen::where('tujuan_dokumen_id',$third_tujuan_doc->id)
                                    ->where('status_tujuan_id',4)
                                    ->count();

                    if($is_done_second >0 && $is_done_third > 0){
                        $is_done_prev = 1;

                        $is_done = tStatusTujuanDokumen::where('tujuan_dokumen_id',$tujuan_id)
                            ->where('status_tujuan_id',4)
                            ->count();
                    }elseif($is_done_second == 0 || $is_done_third == 0){
                        $is_done_prev = 0;

                        $is_done = tStatusTujuanDokumen::where('tujuan_dokumen_id',$tujuan_id)
                            ->where('status_tujuan_id',4)
                            ->count();
                    }
                }
            }
        }
        
        if($request->ajax()){
            $list_disposisi = tDisposisiDokumen::where('dest_doc_id',$tujuan_id);
            return Datatables::of($list_disposisi)
        
            ->addColumn('delete', function($disp){
                return view ('datatable._delete',[
                    'model'    => $disp,
                    'delete_url' => route('document.destroy_disposisi', $disp->id),                    
                    'confirm_message' => 'Yakin mau menghapus disposisi dokumen ?',
                ]);         
            })

            ->rawColumns(['delete'])

            ->make(true);
        }

        $html = $htmlBuilder
            ->addColumn(['data' => 'disposisi_to', 'name' => 'disposisi_to' , 'title' => 'Disposisi Kepada'])
            ->addColumn(['data' => 'keterangan', 'name' => 'keterangan' , 'title' => 'Keterangan'])
            ->addColumn(['data' => 'delete', 'name' => 'delete' , 'title' => '']);
      
        $switch_to = 'status';
        
        return view('dokumen.show')->with(compact('dokumen','tujuan_id','html','is_done',
                    'is_done_prev','text','route','is_last','switch_to'));

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
    public function destroy($tujuan_id)
    {
        $tujuan = tTujuanDokumen::find($tujuan_id);

        // $dokumen = tDokumen::select('id')->where('id', $tujuan->id)->first();
        $dokumen = tDokumen::find($tujuan_id);
        $dokumen->nomor_dokumen = $dokumen->nomor_dokumen . '_D' ; // flag delete di kode dokumen
        $dokumen->save();
        // soft delete
        tDokumen::destroy($tujuan->dokumen_id);

        return redirect()->route('home');
    }

    /*
        Fungsi Delete Status
    */
    public function destroyStatus($status_id)
    {
        //dd($status_id);
        $status = tStatusTujuanDokumen::find($status_id);
        $status->delete();
        return redirect()->back();
    }

    /* 
        Fungsi Delete Disposisi 
    */
    public function destroyDisposisi($disposisi_id)
    {
        //dd($disposisi_id);
        $disp = tDisposisiDokumen::find($disposisi_id);
        $disp->delete();
        return redirect()->back();
    }
}
