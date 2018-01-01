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

    <li class="treeview">
            <a href="#">
            <i class="fa fa-book"></i><span>Buat Dokumen</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
              <li>
                  <a href="{{ route('sm_eksternal.index') }}">
                    <i class="fa fa-home"></i>
                      <span>Surat Masuk Eksternal</span>
                  </a>
              </li>

              <li>      
                  <a href="{{ route('sm_internal.index') }}">
                    <i class="fa fa-home"></i>
                    <span>Surat Masuk Internal</span>
                  </a>          
              </li>

              <li>
                <a href="{{ route('memo_internal.index') }}">
                  <i class="fa fa-home"></i>
                  <span>Memo Internal</span>
                </a>          
              </li>    
            </ul>
    </li>

    <li class="treeview">
            <a href="#">
            <i class="fa fa-book"></i><span>Monitoring Dokumen</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
              <li>
                  <a href="{{ route('monitoring.show',['sm_eksternal']) }}">
                    <i class="fa fa-home"></i>
                      <span>Surat Masuk Eksternal</span>
                  </a>
              </li>

              <li>      
                  <a href="{{ route('monitoring.show',['sm_internal']) }}">
                    <i class="fa fa-home"></i>
                    <span>Surat Masuk Internal</span>
                  </a>          
              </li>

              <li>
                <a href="{{ route('monitoring.show',['memo_internal']) }}">
                  <i class="fa fa-home"></i>
                  <span>Memo Internal</span>
                </a>          
              </li>    
            </ul>
    </li>
  </li>
</ul>
@endsection

@yield('scripts')