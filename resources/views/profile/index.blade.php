@extends('layouts.app')

@section('content-title', 'Edit Profile')
@section('content-subtitle', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <ul class = "breadcrumb">
            <li> <a href = "{{ url('/home') }}"> Edit Profile</a>
            <li class= "active"> Edit Profile </li>
        </ul>
    <div class="box box-purple">
        <div class="box-header">
            <h3 class="box-title">Edit Profile</h3>
        </div>
        <div class="box-body">
            {!! Form::model($user , ['url' =>route('profile.update', $user->id),
                'method' =>'put' , 'files' => 'true', 'class' => 'form-horizontal']) !!}
                                
                @include('profile._form')
            {!! Form::close() !!}
        </div>
    </div>
  </div>
</div>
@endsection
