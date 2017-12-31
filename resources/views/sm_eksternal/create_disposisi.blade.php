@extends('layouts.app')

@section('content-title', 'Tambah Status Dokumen')
@section('content-subtitle', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <ul class = "breadcrumb">
            <li> <a href = "{{ url('/home') }}"> Dashboard</a>
            <li> <a href = "{{ route('sm_eksternal.index') }}"> Surat Masuk Eksternal</a>
            <li class= "active"> Tambah Disposisi Dokumen</li>
        </ul>
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Tambah Disposisi Dokumen</h3>
        </div>
        <div class="box-body">
            {!! Form::open(['url' => route('sme.store_disposisi',[$tujuan_id]),
                'method' => 'post' , 'files' => 'true' , 'class' => 'form-horizontal']) !!}
                @include('sm_eksternal._form_disposisi')

            {!! Form::close() !!}
        </div>
    </div>
  </div>
</div>
@endsection 

{{--   
@section('scripts')
<script>
        $('#datepicker1').datepicker({
            format: "yyyy-mm-dd",
            daysOfWeekHighlighted: "0,6",
            language: "id",
            autoclose: true,
            todayHighlight: true
        });
    </script>
@endsection   --}}
