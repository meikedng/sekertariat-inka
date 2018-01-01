@extends('admin-lte::layouts.main')

@if (auth()->check())
@section('user-avatar', 'https://www.gravatar.com/avatar/' . md5(auth()->user()->email) . '?d=mm')
@section('user-name', auth()->user()->name)
@endif

@section('sidebar-menu')
<ul class="sidebar-menu">
  <li class="header">MAIN NAVIGATOR</li>
  <li class="active">
    <a href="{{ route('home') }}">
      <i class="fa fa-home"></i>
      <span>Home</span>
    </a>

    <a href="{{ route('sm_eksternal.index') }}">
      <i class="fa fa-home"></i>
      <span>Surat Masuk Eksternal</span>
    </a>

    <a href="{{ route('sm_internal.index') }}">
      <i class="fa fa-home"></i>
      <span>Surat Masuk Internal</span>
    </a>

    <a href="{{ route('memo_internal.index') }}">
      <i class="fa fa-home"></i>
      <span>Memo Internal</span>
    </a>

  </li>
</ul>
@endsection

@yield('scripts')