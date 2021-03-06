@extends('layouts.app')

@section('content-title', 'Home')
@section('content-subtitle', 'Dashboard')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="box box-purple">
      <div class="box-header">
        <h3 class="box-title">Dashboard</h3>
      </div>
      <div class="box-body">
        @if (session('status'))
        <div class="alert alert-success">
          {{ session('status') }}
        </div>
        @endif
        You are logged in!
      </div>
    </div>
  </div>
</div>
@endsection
