@extends('layouts.app')

@section('content-title', 'Tambah Surat Masuk Internal')
@section('content-subtitle', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <ul class = "breadcrumb">
            <li> <a href = "{{ url('/home') }}"> Dashboard</a>
            <li> <a href = "{{ route('sm_internal.index') }}"> Surat Masuk Internal</a>
            <li class= "active"> Tambah Surat Masuk Internal </li>
        </ul>
    <div class="box box-purple">
        <div class="box-header">
            <h3 class="box-title">Tambah Surat Masuk Internal</h3>
        </div>
        <div class="box-body">
            {!! Form::open(['url' => route('sm_internal.store'),
                'method' => 'post' , 'files' => 'true' , 'class' => 'form-horizontal']) !!}
                @include('sm_internal._form')

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
