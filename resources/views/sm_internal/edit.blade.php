@extends('layouts.app')

@section('content-title', 'Tambah Surat Masuk Internal')
@section('content-subtitle', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <ul class = "breadcrumb">
            <li> <a href = "{{ url('/home') }}"> Dashboard</a>
            <li> Surat Masuk Internal</a>
            <li class= "active"> Tambah Surat Masuk Internal </li>
        </ul>
    <div class="box box-purple">
        <div class="box-header">
            <h3 class="box-title">Tambah Surat Masuk Internal</h3>
        </div>
        <div class="box-body">
            {!! Form::model($sm_internal,['url' => route('sm_internal.update',$sm_internal->id),
                'method' => 'put' , 'files' => 'true' , 'class' => 'form-horizontal']) !!}
                @include('sm_internal._form_edit')
            {!! Form::close() !!}
        </div>
    </div>
  </div>
</div>
@endsection 
