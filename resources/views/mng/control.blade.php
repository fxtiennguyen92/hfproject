@extends('template.index') @push('stylesheets')
<script>
$(document).ready(function() {
});
</script>
@endpush @section('title') Tài khoản @endsection @section('content')
<section class="content-body has-bottom-menu">
  <div class="page-header hf-bg-gradient text-capitalize">Tài khoản</div>
  <div class="nav-tabs-horizontal orders-page">
    <ul class="nav nav-tabs nav-page hf-bg-gradient text-uppercase" role="tablist">
      <li class="nav-item">
        <a class="nav-link active pull-right" href="javascript: void(0);" data-toggle="tab" data-target="#infoTab" role="tab" aria-expanded="true">Cá nhân</a>
      </li>
      <li class="nav-item">
        <a class="nav-link right pull-left" href="javascript: void(0);" data-toggle="tab" data-target="#supTab" role="tab" aria-expanded="false">Hỗ trợ</a>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="infoTab" role="tabpanel" aria-expanded="true">
        <div class="hf-main-card">
          <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-4 text-right">
              <img class="avt" src="{{ env('CDN_HOST') }}/u/{{ auth()->user()->id }}/{{ auth()->user()->avatar }}">
            </div>
            <div class="col-md-7 col-sm-7 col-xs-7 text-center">
              <div class="name">{{ auth()->user()->name }}</div>
              <div class="email">{{ auth()->user()->email }}</div>
              @if (is_null(auth()->user()->phone))
              <div class="no-phone color-warning">Chưa cập nhật số điện thoại</div>
              @else
              <div class="phone">{{ auth()->user()->phone }}</div>
              @endif
            </div>
          </div>
          <a class="edit-icon" href="javascript:void(0)"><i class="material-icons">edit</i></a>
        </div>
        <div class="control-list margin-top-20">
        <section class="user-menu">
          <ul class="list-menu">
            <li><a href="{{ route('mng_common_list') }}"><i class="material-icons">language</i> Tùy chỉnh hệ thống</a></li>
            <li><a href="{{ route('password_page') }}"><i class="material-icons">verified_user</i> Mật khẩu</a></li>
            <li><a href="{{ route('logout') }}"><i class="material-icons">power_settings_new</i> Đăng xuất</a></li>
          </ul>
        </section>
        </div>
      </div>
      <div class="tab-pane" id="supTab" role="tabpanel" aria-expanded="false">
        <div class="control-list">
        <section class="user-menu">
          <ul class="list-menu">
            <li><a href="javascript:void(0);"><i class="material-icons">&#xE887;</i> Câu hỏi thường gặp</a></li>
            <li><a href="javascript:void(0);"><i class="material-icons">&#xE8A3;</i> Tuyển dụng</a></li>
            <li><a href="javascript:void(0);"><i class="material-icons">&#xE55A;</i> Về HandFree</a></li>
          </ul>
        </section>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@include('template.mb.footer-menu')