@extends('template.index') @push('stylesheets')
<script>
$(document).ready(function() {
  $('.price').each(function() {
    $(this).html(accounting.formatMoney($(this).html()));
  });

  $('#btnFillWallet').on('click', function() {
      swal({
          title: 'Tài khoản',
          text: 'Hiện tại chúng tôi chỉ nhận nạp thêm tài khoản tại Văn phòng 4/2 Đinh Bộ Lĩnh, P104',
          type: 'warning',
          confirmButtonClass: 'btn-primary',
          confirmButtonText: 'Quay lại',
      });
  });
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
              <div class="no-phone color-warning">(Chưa cập nhật số điện thoại)</div>
              @else
              <div class="phone">{{ auth()->user()->phone }}</div>
              @endif
            </div>
          </div>
          <a class="edit-icon" href="javascript:void(0)"><i class="material-icons">edit</i></a>
        </div>

        <div class="hf-card margin-top-40">
          <div class="row padding-20">
            <h5>Số dư Tài khoản</h5>
            <div class="price color-primary text-center acc-balance">{{ auth()->user()->wallet }}</div>
          </div>
          <button id="btnFillWallet" class="bottom-full-width-btn btn btn-primary text-uppercase">Nạp thêm</button>
        </div>
        <div class="hf-card margin-top-20">
          <div class="row padding-20">
            <h5>Điểm tích lũy</h5>
            <div class="color-primary text-center acc-point">{{ auth()->user()->point }}</div>
          </div>
        </div>
        <div class="control-list margin-top-20">
        <section class="user-menu">
          <ul class="list-menu">
            <li><a href="{{ route('password_page') }}"><i class="material-icons">verified_user</i> Mật khẩu</a></li>
            <li><a href="{{ route('logout') }}"><i class="material-icons">power_settings_new</i> Đăng xuất</a></li>
          </ul>
        </section>
        </div>
      </div>
      <div class="tab-pane" id="supTab" role="tabpanel" aria-expanded="false">
        <div class="hf-main-card">
          <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-4 text-center">
              <img class="social-icon" src="{{ env('CDN_HOST') }}/img/social/zalo.png">
              <label class="social-label">0904623460</label>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4 text-center"
              onclick="window.open('https://m.me/handfreeco', '_blank');">
              <img class="social-icon" src="{{ env('CDN_HOST') }}/img/social/facebook-messenger.png">
              <label class="social-label">handfree</label>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4 text-center">
              <img class="social-icon" src="{{ env('CDN_HOST') }}/img/social/phone.png">
              <label class="social-label">0904623460</label>
            </div>
          </div>
        </div>
        <div class="control-list margin-top-40">
        <section class="user-menu">
          <ul class="list-menu">
            <li><a href="javascript:void(0);"><i class="material-icons">&#xE887;</i> Câu hỏi thường gặp</a></li>
            <li><a href="{{ route('pros_new') }}"><i class="material-icons">&#xE227;</i> Trở thành đối tác</a></li>
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