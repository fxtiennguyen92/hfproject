@extends('template.index_no_nav') @push('stylesheets')
<style type="text/css">
</style>

<!-- Page Scripts -->
<script>
  $(document).bind('keypress', function(e) {
    if (e.keyCode == 13) {
      $('#btnLogin').trigger('click');
    }
  });

  $(document).ready(function() {
    // Form Validation
    $('#frmMain').validate({
      submit: {
        settings: {
          inputContainer: '.form-group',
          errorListClass: 'form-control-error',
          errorClass: 'has-danger',
        },
        callback: {
          onSubmit: function() {
            $.ajax({
              type: 'POST',
              url: "{{ route('login') }}",
              data: $('#frmMain').serialize(),
              success: function(response) {
                $.notify({
                  title: '<strong>Xin chào! </strong>',
                    message: 'Bạn đã đăng nhập thành công.'
                  }, {
                    type: 'success',
                });
                location.href = "{{ route('redirect') }}";
              },
              error: function(xhr) {
                if (xhr.status == 401) {
                  $.notify({
                    title: '<strong>Thất bại! </strong>',
                    message: 'Tài khoản bạn nhập chưa đúng.'
                  }, {
                    type: 'danger',
                  });
                } else {
                  $.notify({
                    title: '<strong>Thất bại! </strong>',
                    message: 'Đăng nhập không thành công, hãy thử lại.'
                  }, {
                    type: 'danger'
                  });
                };
              }
            });
          }
        }
      }
    });
    // Show/Hide Password
    $('.password').password({
      eyeClass: '',
      eyeOpenClass: 'icmn-eye',
      eyeCloseClass: 'icmn-eye-blocked'
    });
  });

</script>
<!-- End Page Scripts -->
@endpush @section('title') Đăng nhập @endsection @section('content')
<section class="page-content">
  <div class="page-content-inner single-page-login-alpha" style="background-image:url(img/banner/7.png);">
    <!-- Login Page -->
    <div class="single-page-block">
      <div class="">
        <div class="login-form-wrapper">
          <div class="single-page-block-inner">

            <div class="logo" style="margin-bottom: 30px;">
              <a href="javascript: history.back();">
                <img src="img/logoh.png" alt="Hand Free" width="150"/>
              </a>
            </div>

            <h1 class="page-title">
              Đăng nhập
            </h1>
            <div class="single-page-block-form">
              <form id="frmMain" name="form-validation" method="POST">
                <div class="form-group">
                  <div class="social-login">
                    <p class="text-center text-label">Đăng nhập bằng mạng xã hội</p>
                    <div class="row" style="padding-top: 10px">
                      <div class="col-xs-6">
                        <a href="{{ route('redirect_fb') }}" class="btn btn-icon" style="width: 100%; background:#2151B2; color:#fff!important">
                        <img src="img/social/facebook-logo.png" width="18">&nbsp;&nbsp; Facebook
                      </a>
                      </div>
                      <div class="col-xs-6" style="padding-right: 14px;">
                        <a href="{{ route('redirect_gg') }}" class="btn btn-icon" style="width: 100%; background:#D41701; color:#fff!important">
                        <img src="img/social/google-logo.png" width="18">&nbsp;&nbsp; Google
                      </a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <br/>
                  <p class="text-center text-label">Đăng nhập với Email</p>
                  <input id="inpEmail" maxlength="100" class="form-control" placeholder="Email" name="email" type="text" data-validation="[EMAIL]">
                </div>
                <div class="form-group">
                  <input id="inpPassword" class="form-control password" placeholder="Mật khẩu" name="password" type="password" data-validation="[L>=6]">
                </div>
                <a href="javascript: void(0);" class="pull-right link-blue" style="font-size: 12px">Quên mật khẩu?</a>
                <br>
                <div class="form-group" style="text-align: center; margin-top: 10px; margin-bottom: 0">
                  <button id="btnLogin" type="submit" class="btn btn-primary width-150">ĐĂNG NHẬP</button>
                  <br>
                  <a href="{{ route('signup_page') }}" type="button" class="btn btn-link" style="color: #02B3E4 !important;">Chưa có tài khoản, Đăng ký!</a>
                  <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Login Page -->
  </div>
</section>
@endsection
