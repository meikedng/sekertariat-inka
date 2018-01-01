@extends('layouts.app')

@section('content-title', 'Surat Masuk Internal')
@section('content-subtitle', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <ul class = "breadcrumb">
            <li> <a href = "{{ url('home')}}"> Surat Masuk Internal </a></li>
            <li class = "active" > Surat Masuk Internal </a> </li>
        </ul>
    <div class="box box-success">
        <div class="box-header">
            <h3 class="box-title">Surat Masuk Internal</h3>
        </div>
        <div class="box-body">
            <p> <a class="btn btn-primary" href="{{ route('sm_internal.create') }}">Tambah Surat Masuk Internal</a> </p>
            
            {!! $dataTable->table(['class' => 'table-striped', 'width' => '100%']) !!}
        </div>
    </div>
  </div>
</div>
@endsection

 
@section('scripts')
    {!! $dataTable->scripts() !!}
@endsection 
