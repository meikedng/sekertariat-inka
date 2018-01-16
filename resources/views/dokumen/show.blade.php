@extends('layouts.app')

@section('styles')
    <link href="/css/costum.css" rel="stylesheet">
@endsection

@section('content-title', 'Dokumen')
@section('content-subtitle', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <ul class = "breadcrumb">
            <li> <a href = "{{ url('home')}}"> Dashboard </a></li>
            <li> <a href = "{{ route($route . '.index') }}"> {!!$text!!}  </a>
            <li class = "active" > {!!$text!!} </a> </li>
        </ul>
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">{!!$text!!}</h3>
        </div>
        <div class="box-body">
            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-3"><p>No. Dokumen </p></div>
                    <div class="col-md-9"><p>: {{ ($dokumen->nomor_dokumen) }}</p></div>
                </div>

                <div class="row">
                    <div class="col-md-3"><p>Tanggal Masuk Dokumen</p></div>
                    <div class="col-md-9"><p>: {{ ($dokumen->tgl_masuk) }}</p></div>
                </div>
                
                <div class="row">
                    <div class="col-md-3"><p>Pengirim</p></div>
                    <div class="col-md-9"><p>: {{ ($dokumen->pengirim) }}</p></div>
                </div>

                <div class="row">
                    <div class="col-md-3"><p>Perihal</p></div>
                    <div class="col-md-9"><p>: {{ ($dokumen->perihal) }}</p></div>
                </div>

                <div class="row">
                        <div class="col-md-3"><p>Tanggal Keluar</p></div>
                        <div class="col-md-9"><p>: {{ ($dokumen->tgl_keluar) }}</p></div>
                </div>

                <div class="row">
                        <div class="col-md-3"><p>Penerima</p></div>
                        <div class="col-md-9"><p>: {{ ($dokumen->penerima) }}</p></div>
                </div>

                @if($is_done>0 && $is_last>0)
                <div class= "row">
                    <div class="col-md-3">
                        <a href="{{ route('doc.create_penerima',[$route,$tujuan_id]) }}" class="btn btn-danger">
                            <span class="glyphicon glyphicon-ok"></span> Pengembalian Dokumen ke Unit</a>

                    </div>
                </div>
                @endif
                                
                <div class="row">
                    <div class='col-md-12'>
                        <hr style="height: 2px; color: #4a5fe2; background-color: #4286f4">
                    </div>
                </div>

                @if($switch_to=='disposisi')
                    <div class="row">
                        
                        <div class="col-md-3">
                            <a href="{{ route('doc.show_disposisi',[$route,$tujuan_id]) }}" class="btn btn-success">
                                <span class="glyphicon glyphicon-file"></span> Tampilkan Disposisi </a>
                        </div>
                    </div>
                    @if($is_done_prev>0)
                            @if($is_done==0)
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <a href="{{ route('doc.create_status',[$route,$tujuan_id]) }}" 
                                        class="btn btn btn-primary"> <span class="glyphicon glyphicon-plus"></span> 
                                            Tambahkan Status Dokumen
                                    </a>
                                </div>
                            </div>
                            @endif
                    @elseif($is_done_prev==0)
                        <div class="col-md-5"><p>Status pada Tujuan Sebelumnya Belum Selesai</p></div>
                    @endif
                @elseif($switch_to=='status')
                    <div class="row">
                        <div class="col-md-3"><a href="{{ route('doc.show',[$route,$tujuan_id]) }}" 
                            class="btn btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span> 
                            Tampilkan Status</a>
                        </div>
                    </div>
                    @if($is_done_prev>0)
                       @if($is_done>0)
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <a href="{{ route('doc.create_disposisi',[$route,$tujuan_id]) }}" 
                                            class="btn btn btn-primary"><span class="glyphicon glyphicon-plus">
                                                </span> Tambah Disposisi Dokumen
                                        </a>
                                    </div>    
                            </div>
                        @endif
                           
                       
                    @elseif($is_done_prev==0)
                        <div class="col-md-5"><p>Status pada Tujuan Sebelumnya Belum Selesai</p></div>
                    @endif
                @endif

                    <div class="row">
                        <div class='col-md-12'>
                            <hr style="height: 2px; color: #4a5fe2; background-color: #4286f4">
                        </div>
                    </div>
    
                    

                <div class="row">
                    {!! $html->table(['class' => 'table-striped']) !!}
                </div>

            <div class="box-footer">
                <div class="row">
                    <div class="col-md-5 col-md-offset-5">
                        {{--  //<a class="btn btn-primary" href="{{ url('ncr_reg/'. $ncr_data->id .'/print_pdf') }}" target="_blank"><i class="glyphicon glyphicon-print" aria-hidden="true"> Print</i></a>  --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
     {!! $html->scripts() !!}
@endsection


