@extends('template.index') @push('stylesheets')
@endpush @section('title') Trang điều khiển @endsection @section('content')
<section class="content-body user-menu">
  <ul class="list-menu">
  @if (auth()->user())
    <li><a href="javascript:void(0);"><i class="material-icons">&#xE887;</i> Trợ giúp</a></li>
    @if (auth()->user()->role == 0)
    <li><a href="{{ route('pro_signup_page') }}"><i class="material-icons">&#xE227;</i> Trở thành đối tác</a></li>
    <li><a href="javascript:void(0);"><i class="material-icons">&#xE8B8;</i> Cài đặt</a></li>
    @elseif (auth()->user()->role == 1)
    <li><a href="javascript:void(0);"><i class="material-icons">&#xE616;</i> Lịch làm việc</a></li>
    <li><a href="javascript:void(0);"><i class="material-icons">&#xE227;</i> Doanh thu</a></li>
    <li><a href="javascript:void(0);"><i class="material-icons">&#xE8B8;</i> Cài đặt</a></li>
    @elseif (auth()->user()->role == 2)
    <li><a href="javascript:void(0);"><i class="material-icons">&#xE2C9;</i> Nhân viên</a></li>
    <li><a href="javascript:void(0);"><i class="material-icons">&#xE227;</i> Doanh thu</a></li>
    <li><a href="javascript:void(0);"><i class="material-icons">&#xE8B8;</i> Cài đặt</a></li>
    @elseif (auth()->user()->role == 90)
    <li><a href="javascript:void(0);"><i class="material-icons">&#xE80D;</i> Đối tác</a></li>
    @elseif (auth()->user()->role == 99)
    <li><a href="javascript:void(0);"><i class="material-icons">&#xE853;</i> Tài khoản</a></li>
    <li><a href="javascript:void(0);"><i class="material-icons">&#xE8B0;</i> Đơn hàng</a></li>
    @endif
    <li><a href="{{ route('logout') }}"><i class="material-icons">&#xE879;</i> Đăng xuất</a></li>
  @else
    
  @endif
  </ul>
</section>
@endsection
