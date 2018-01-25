@extends('layouts.app')

@section('content-title', 'Memo Internal')
@section('content-subtitle', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <ul class = "breadcrumb">
            <li> <a href = "{{ url('home')}}"> Memo Internal </a></li>
            <li class = "active" > Memo Internal </a> </li>
        </ul>
    <div class="box box-purple">
        <div class="box-header">
            <h3 class="box-title">Memo Internal</h3>
        </div>
        <div class="box-body">
            @if($create_doc)
                <p> <a class="btn btn-primary" href="{{ route('memo_internal.create') }}">Tambah Memo Internal</a> </p>
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
