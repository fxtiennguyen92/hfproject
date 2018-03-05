@extends('template.index') @push('stylesheets')
@endpush @section('title') Trang điều khiển @endsection @section('content')
<section class="content-body user-menu">
  <ul class="list-menu">
    <li><a href="javascript:void(0);"><i class="material-icons">&#xE887;</i> Trợ giúp</a></li>
    @if (auth()->user()->role == 0)
    <li><a href="{{ route('pro_signup_page') }}"><i class="material-icons">&#xE227;</i> Trở thành đối tác</a></li>
    @endif
    <li><a href="javascript:void(0);"><i class="material-icons">&#xE8B8;</i> Cài đặt</a></li>
    <li><a href="{{ route('logout') }}"><i class="material-icons">&#xE879;</i> Đăng xuất</a></li>
  </ul>
</section>
@endsection
