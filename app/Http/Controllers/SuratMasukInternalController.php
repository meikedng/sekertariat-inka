<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DataTables\smInternalDataTable;
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
use App\mDivisi;
use App\mDireksi;
use App\mDirektorat;

class SuratMasukInternalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(smInternalDatatable $dataTable)
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

        return $dataTable->render('sm_internal.index', compact('create_doc'));
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
        return view('sm_internal.create')->with(compact('list_circular','first_dest'));
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
        $doc_code = mTipeDokumen::select('code')->where('id',1)->first();
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
            'nomor_urut_dokumen' => 'required|unique:t_dokumens,nomor_dokumen',
            'tgl_masuk' => 'required',
            'pengirim' => 'required|exists:m_divisis,id',
            'dokumen' => 'required',
            'jenis_dokumen' => 'required',
            'first_destination' => 'required|exists:m_direksis,id',
            'second_destination' => 'nullable||exists:m_direksis,id',
            'third_destination' => 'nullable||different:second_destination|exists:m_direksis,id',
            'fourth_destination' => 'nullable||different:second_destination|different:third_destination|exists:m_direksis,id',                        
        ]);

        // no urut per tahun per direksi per jenis surat
        $doc_code = mTipeDokumen::select('code')->where('id',1)->first();

        $year= Carbon::now()->year;
        $date_create_doc = Carbon::now()->format('dmy');
        
        // $nomor_urut_dokumen = tDokumen::whereRaw('year(created_at) = '. $year )
        //                         ->whereHas('tujuan',function ($query) use($request){
        //                             $query->where('urutan_ke',1);
        //                             $query->where('dest_direksi_id', $request->first_destination);
        //                         })->count();

        // $nomor_urut_dokumen++; // plus 1 

        // $generate_no_doc = $nomor_urut_dokumen. '/' . $doc_code->code . '/'.
        //                     $request->first_destination. '/' . $date_create_doc;

        // dd($generate_no_doc);

        // create dokumen
        $dokumen = new tDokumen();
        $dokumen->tipe_dok_id = 1; // Surat Masuk Internal;
        $dokumen->tgl_masuk = $request->tgl_masuk;
        //$dokumen->nomor_dokumen = $generate_no_doc;
        $dokumen->nomor_dokumen = $request->nomor_urut_dokumen;
        // $dokumen->nomor_referensi= $request->nomor_surat;
        $dokumen->perihal = $request->dokumen;
        // cari nama unit 
        $from_unit = mDivisi::select('division_name')
            ->where('id',$request->pengirim)->first();
        $dokumen->pengirim = $from_unit->division_name;

        // $dokumen->tgl_dok_referensi = $request->tgl_surat;
        $dokumen->is_circular = $request->jenis_dokumen;
        $dokumen->is_closed = 2; // on proses
        $dokumen->id_user = Auth::id();
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

        return redirect(route('sm_internal.index'));
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

     // id --> adalah id tujuan , cari kode dokumen nya dulu
    public function edit($id)
    {
        $dokumen = tTujuanDokumen::select('dokumen_id')->where('id',$id)->first();
        $sm_internal = tDokumen::find($dokumen->dokumen_id);

        $nomor_urut_dokumen = $sm_internal->nomor_dokumen;
        $nomor_urut_dokumen = explode("/",$nomor_urut_dokumen);
        $nomor_urut_dokumen=$nomor_urut_dokumen[0];

        $unit_id = mDivisi::select('id')->where('division_name',$sm_internal->pengirim)->first();

        if(!is_null($unit_id)){
            $sm_internal->pengirim = $unit_id->id;
        }

        if($dokumen->is_circular==1)
            $jenis_dokumen = "Dokumen Sirkular";
        else
            $jenis_dokumen = "Dokumen Biasa";

       
        $list_tujuan =  tTujuanDokumen::where('dokumen_id',$dokumen->dokumen_id)
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

        //dd($sm_internal);
        return view('sm_internal.edit')->with(compact('sm_internal','list_circular','first_dest',
            'jenis_dokumen','text_tujuan','nomor_urut_dokumen'));
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
        $dokumen = tDokumen::find($id);
        $old_number = $dokumen->nomor_dokumen;      

        $new_nomor_urut = $request->nomor_urut_dokumen;

        $old_format = $old_number;
        $old_format = explode("/",$old_format);
        $old_nomor_urut = $old_format[0];
        
        if($old_nomor_urut!=$new_nomor_urut)
            $is_same = false;
        elseif($old_nomor_urut==$new_nomor_urut)
            $is_same=true;

        $type_doc = $old_format[1];
        $dir_code_doc = $old_format[2];
        $year_doc = $old_format[3];

        $new_doc_number = $request->nomor_urut_dokumen . '/' . $type_doc . '/' . $dir_code_doc . '/' . $year_doc;
        $request->merge(['nomor_urut_dokumen' => $new_doc_number]);

        if($is_same){
            $this->validate($request , [
                'tgl_masuk' => 'required',
                'pengirim' => 'required|exists:m_divisis,id',
                'perihal' => 'required',
            ]);
        }elseif(!$is_same){
            $this->validate($request , [
                'nomor_urut_dokumen' => 'required|unique:t_dokumens,nomor_dokumen',
                'tgl_masuk' => 'required',
                'pengirim' => 'required|exists:m_divisis,id',
                'perihal' => 'required',
            ]);
        }


        if(!$is_same){
            $dokumen->nomor_dokumen = $request->nomor_urut_dokumen;
        }

        $dokumen->tgl_masuk = $request->tgl_masuk;
        
        $from_unit = mDivisi::select('division_name')
            ->where('id',$request->pengirim)->first();

        $dokumen->pengirim = $from_unit->division_name;
        $dokumen->perihal = $request->perihal;
        $dokumen->save();

        
        return redirect(route('sm_internal.index'));
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
