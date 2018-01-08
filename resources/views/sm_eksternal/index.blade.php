@extends('layouts.app')

@section('content-title', 'Surat Masuk Eksternal')
@section('content-subtitle', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <ul class = "breadcrumb">
            <li> <a href = "{{ url('home')}}"> Surat Masuk Eksternal </a></li>
            <li class = "active" > Surat Masuk Eksternal </a> </li>
        </ul>
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Surat Masuk Eksternal</h3>
        </div>
        <div class="box-body">
            @if($create_doc)
                <p> <a class="btn btn-primary" href="{{ route('sm_eksternal.create') }}">Tambah Surat Masuk Eksternal</a> </p>
            @endif
            
            {!! $dataTable->table(['class' => 'table-striped', 'width' => '100%']) !!}
        </div>
    </div>
  </div>
</div>
@endsection

 
@section('scripts')
    {!! $dataTable->scripts() !!}
@endsection 
