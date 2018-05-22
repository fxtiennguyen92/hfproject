@extends('template.index-no-nav') @push('stylesheets')
<style type="text/css">
</style>

<!-- Page Scripts -->
<script>
$(document).ready(function() {
	$('#inpUsername').focus();
	
	@if (session('error'))
	swal({
		title: 'Thất bại',
		text: 'Tài khoản đăng nhập chưa đúng',
		type: 'error',
		confirmButtonClass: 'btn-danger',
		confirmButtonText: 'Quay lại',
	});
	@endif

	$('#frmMain').validate({
		submit: {
			settings: {
				inputContainer: '.form-group',
				errorListClass: 'form-control-error',
				errorClass: 'has-danger',
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
<section class="page-content" style="margin:0">
	<div class="page-content-inner single-page-login-alpha" style="background-image:url({{ env('CDN_HOST') }}/img/banner/bg_auth_page.png);">
		<div class="single-page-block">
			<div class="">
				<div class="login-form-wrapper">
					<div class="single-page-block-inner">
						<div class="logo text-center" style="margin-bottom: 30px;">
							<a href="javascript: history.back();">
								<img src="{{ env('CDN_HOST') }}/img/logo/logoh.png" alt="HandFree" width="150"/>
							</a>
						</div>

						<h1 class="page-title">Đăng nhập</h1>
						<div class="single-page-block-form">
							<form id="frmMain" name="form-validation" method="POST" action="{{ route('login') }}">
								<div class="form-group">
									<div class="social-login">
										<div class="row" style="padding-top: 10px">
											<div class="col-xs-6">
												<a href="{{ route('redirect_fb') }}" class="btn btn-icon" style="width: 100%; background:#fff; color:#424242!important">
												<img src="https://auth.udacity.com/images/facebook_logo-adc2f.svg" width="18">&nbsp;&nbsp; Facebook
											</a>
											</div>
											<div class="col-xs-6" style="padding-right: 14px;">
												<a href="{{ route('redirect_gg') }}" class="btn btn-icon" style="width: 100%; background:#fff; color:#424242!important">
												<img src="https://auth.udacity.com/images/google_logo-12018.svg" width="18">&nbsp;&nbsp; Google
											</a>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<br/>
									<p class="text-center text-label">Hoặc</p>
									<input id="inpUsername" maxlength="100" class="form-control"
										placeholder="Email hoặc Số điện thoại" name="username"
										type="text" data-validation="[NOTEMPTY]"
										@if (session('error'))
										value="{{ old('username') }}"
										@endif>
								</div>
								<div class="form-group">
									<input id="inpPassword" class="form-control password" placeholder="Mật khẩu" name="password" type="password" data-validation="[L>=6]">
								</div>
<!--								<a href="javascript: void(0);" class="pull-right link-blue" style="font-size: 12px">Quên mật khẩu?</a>	-->
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
	</div>
</section>
@endsection
