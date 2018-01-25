@extends('layouts.app')

@section('content-title', 'Tambah Surat Masuk Eksternal')
@section('content-subtitle', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <ul class = "breadcrumb">
            <li> <a href = "{{ url('/home') }}"> Dashboard</a>
            <li> Surat Masuk Eksternal</a>
            <li class= "active"> Tambah Surat Masuk Eksternal</li>
        </ul>
    <div class="box box-purple">
        <div class="box-header">
            <h3 class="box-title">Tambah Surat Masuk Eksternal</h3>
        </div>
        <div class="box-body">
            {!! Form::model($memo_internal,['url' => route('memo_internal.update',$memo_internal->id),
                'method' => 'put' , 'files' => 'true' , 'class' => 'form-horizontal']) !!}
                @include('memo_internal._form_edit')
            {!! Form::close() !!}
        </div>
    </div>
  </div>
</div>
@endsection 
