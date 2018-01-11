<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\smEksternalDataTable;
use Illuminate\Support\Facades\Auth;
use App\mSekdir;
use App\mTipeDokumen;
use Carbon\Carbon;
use App\tDokumen;
use App\tTujuanDokumen;
use App\tStatusTujuanDokumen;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Datatables;
use App\tDisposisiDokumen;
use App\mDireksi;
use App\mDirektorat;

class SuratMasukEksternalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(smEksternalDataTable $dataTable)
    {
        $is_sekdirkeu = Auth::user()->hasRole('sek_dirkeu');
        $is_sekdirut = Auth::user()->hasRole('sek_dirut');
        $is_sekdirkomtek = Auth::user()->hasRole('sek_dirkomtek');
        $is_sekdirprod = Auth::user()->hasRole('sek_dirprod');

        if($is_sekdirkeu || $is_sekdirut || $is_sekdirkomtek || $is_sekdirprod)
        {
            $create_doc = true;
        }
        elseif(!$is_sekdirkeu && !$is_sekdirut && !$is_sekdirkomtek && !$is_sekdirprod) 
        {
            $create_doc = false;
        }

        return $dataTable->render('sm_eksternal.index', compact('create_doc'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $is_sekdirkeu = Auth::user()->hasRole('sek_dirkeu');
        $is_sekdirut = Auth::user()->hasRole('sek_dirut');
        $is_sekdirkomtek = Auth::user()->hasRole('sek_dirkomtek');
        $is_sekdirprod = Auth::user()->hasRole('sek_dirprod');
        
        /*
            Hal ini digunakan karena hanya sek dirkeu yang bisa membuat dokumen sirkular
        */
        if($is_sekdirkeu){
            $is_circular = [0,1];
            $lbl_circular = ['Dokumen Biasa','Dokumen Sirkular'];
        }
        elseif($is_sekdirut || $is_sekdirkomtek || $is_sekdirprod)      
        {
            $is_circular = [0];
            $lbl_circular = ['Dokumen Biasa'];
        }
        
        for ($i=0; $i < count($is_circular) ; $i++){
            $id = $is_circular[$i];
            $lbl = $lbl_circular[$i];
       
            if($i==0){
                 $list_circular = collect();
                $list_circular = $list_circular->push(['id' => $id ,'label' => $lbl]);
            } else{
                $list_circular = $list_circular->push(['id' => $id ,'label' => $lbl]);
            }
        }

        // pembuat dokumen adalah sekretaris dari direkisi tujuan pertama
        $first_dest  = mSekdir::select('direksi_id')->where('user_id', Auth::id())->first();
        return view('sm_eksternal.create')->with(compact('list_circular','first_dest'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // no urut per tahun per direksi per jenis surat
        $doc_code = mTipeDokumen::select('code')->where('id',2)->first();
        $no_urut = $request->nomor_urut_dokumen;

        $this->validate($request , [
            'first_destination' => 'required|exists:m_direksis,id', 
        ]);
        
        //get dir code
        $first_dest = mDireksi::select('id_direktorat')
            ->where('id',$request->first_destination)->first();
        $direktorat = mDirektorat::select('dir_code')->where('id',$first_dest->id_direktorat)->first();

        $year= Carbon::now()->year;
        $nomor_urut_dokumen = $no_urut. '/' . $doc_code->code. 
                    '/'. $direktorat->dir_code . '/'.$year;

        $request->merge(['nomor_urut_dokumen' => $nomor_urut_dokumen]);

        $this->validate($request , [
            'nomor_urut_dokumen' => 'unique:t_dokumens,nomor_dokumen',
            'tgl_masuk' => 'required',
            'tgl_surat' => 'required|before or equal:tgl_masuk',
            'pengirim' => 'required',
            'no_surat' => 'required',
            'perihal' => 'required',
            'jenis_dokumen' => 'required',
            'first_destination' => 'required|exists:m_direksis,id',
            'second_destination' => 'nullable||exists:m_direksis,id',
            'third_destination' => 'nullable||different:second_destination|exists:m_direksis,id',
            'fourth_destination' => 'nullable||different:second_destination|different:third_destination|exists:m_direksis,id',                        
        ]);

        // // no urut per tahun per direksi per jenis surat
        // $doc_code = mTipeDokumen::select('code')->where('id',2)->first();

        // $year= Carbon::now()->year;
        // $date_create_doc = Carbon::now()->format('dmy');
        
        // $nomor_urut_dokumen = tDokumen::whereRaw('year(created_at) = '. $year )
        //                         ->whereHas('tujuan',function ($query) use($request){
        //                             $query->where('urutan_ke',1);
        //                             $query->where('dest_direksi_id', $request->first_destination);
        //                         })->count();

        // $nomor_urut_dokumen++; // plus 1 

        // $generate_no_doc = $nomor_urut_dokumen. '/' . $doc_code->code . '/'.
        //                     $request->first_destination. '/' . $date_create_doc; 

        // create dokumen
        $dokumen = new tDokumen();
        $dokumen->tipe_dok_id = 2; // Surat Masuk Eksternal;
        $dokumen->tgl_masuk = $request->tgl_masuk;
        $dokumen->nomor_dokumen = $request->nomor_urut_dokumen;
        $dokumen->nomor_referensi= $request->nomor_surat;
        $dokumen->perihal = $request->perihal;
        $dokumen->pengirim = $request->pengirim;
        $dokumen->tgl_dok_referensi = $request->tgl_surat;
        $dokumen->is_circular = $request->jenis_dokumen;
        $dokumen->is_closed = 0;
        $dokumen->save();

        // tujuan dokumen
        $dest1 = new tTujuanDokumen();
        $dest1->dokumen_id = $dokumen->id;
        $dest1->urutan_ke = 1 ; // urutan pertama
        $dest1->dest_direksi_id = $request->first_destination;
        $dest1->save();

        // auto create status, untuk diserahkan 
        $status = new tStatusTujuanDokumen();
        $status->tujuan_dokumen_id = $dest1->id; 
        $status->status_tujuan_id = 2; // diserahkan 
        $status->keterangan = 'Dokumen telah diserahkan';
        $status->tgl_status = Carbon::now()->toDateString();
        $status->save();

        if(!is_null($request->second_destination)){
            $dest2 = new tTujuanDokumen();
            $dest2->dokumen_id = $dokumen->id;
            $dest2->urutan_ke = 2 ; // urutan kedua
            $dest2->dest_direksi_id = $request->second_destination;
            $dest2->save();
        }

        if(!is_null($request->third_destination)){
            $dest3 = new tTujuanDokumen();
            $dest3->dokumen_id = $dokumen->id;
            $dest3->urutan_ke = 3 ; // urutan kedua
            $dest3->dest_direksi_id = $request->third_destination;
            $dest3->save();
        }

        if(!is_null($request->fourth_destination)){
            $dest4 = new tTujuanDokumen();
            $dest4->dokumen_id = $dokumen->id;
            $dest4->urutan_ke = 4 ; // urutan kedua
            $dest4->dest_direksi_id = $request->fourth_destination;
            $dest4->save();
        }

        return redirect(route('sm_eksternal.index'));                           
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Builder $htmlBuilder,$tujuan_id)
    {
        $tujuan_doc = tTujuanDokumen::where('id',$tujuan_id)->first();
        $dokumen = tDokumen::find($tujuan_doc->dokumen_id);
        
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
        
            // ->addColumn('show', function($stat){
            //         return view ('datatable._print',[
            //         'model'    => $gmHeader,
            //         'show_url' => route ('goods_movement.show', $gmHeader->id)
            //     ]);         
            // })

            
            ->make(true);
        }

        $html = $htmlBuilder
            ->addColumn(['data' => 'tgl_status', 'name' => 'tgl_status' , 'title' => 'Tanggal'])
            ->addColumn(['data' => 'status.description', 'name' => 'status.description' , 'title' => 'Status'])
            ->addColumn(['data' => 'keterangan', 'name' => 'keterangan' , 'title' => 'Keterangan']);
               
        return view('sm_eksternal.show')->with(compact('dokumen','tujuan_id','html','is_done','is_done_prev'));
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
