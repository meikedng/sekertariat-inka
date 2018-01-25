@extends('layouts.app')

@section('content-title', 'Monitoring Dokumen')
@section('content-subtitle', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <ul class = "breadcrumb">
            <li> <a href = "{{ url('home')}}"> Dokumen </a></li>
            <li class = "active" > Monitoring Dokumen </a> </li>
        </ul>
    <div class="box box-purple">
        <div class="box-header">
            <h3 class="box-title">Monitoring Dokumen</h3>
        </div>
        <div class="box-body">
            
             {!! $dataTable->table(['class' => 'table-striped', 'width' => '100%']) !!} 
        </div>
    </div>
  </div>
</div>
@endsection

 
@section('scripts')
     {!! $dataTable->scripts() !!} 
@endsection 
