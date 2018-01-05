@extends('template.index_no_nav')
@push('stylesheets')
	<style type="text/css">
		.single-page-block-inner {
			margin-top: 0px;
		}
		@media only screen and (min-width: 540px) {
			.single-page-block-inner {
				margin-top: 100px;
			} 
		}
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
								url: '{{ route("login") }}',
								data: $('#frmMain').serialize(),
								success: function(response) {
									
								},
								error: function(xhr) {
									if (xhr.status == 401) {
										$.notify({
											title: '<strong>Thất bại! </strong>',
											message: 'Tài khoản bạn nhập chưa đúng.'
										},{
											type: 'danger',
										});
									} else {
										$.notify({
											title: '<strong>Thất bại! </strong>',
											message: 'Đăng nhập không thành công, hãy thử lại.'
										},{
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
@endpush

@section('title')
	Đăng nhập
@endsection

@section('content')
<section class="page-content">
<div class="page-content-inner single-page-login-alpha" style="background-image: url(assets/common/img/temp/login/5.jpg)">
	<!-- Login Page -->
	<div class="single-page-block">
		<div class="row">
			<div class="col-xl-4">
			</div>
			<div class="col-xl-4">
				<div class="single-page-block-inner">
					<div class="logo" style="text-align: center; margin-top: 10px;">
						<a href="javascript: history.back();">
							<img src="img/logoh.png" alt="Hand Free" width="250" />
						</a>
					</div>
					<div class="single-page-block-form">
						<form id="frmMain" name="form-validation" method="POST">
							<div class="form-group">
								<div class="social-login">
									<div class="social-container row">
										<div>
											<p>Đăng nhập nhanh</p>
										</div>
										<div class="col-xs-6">
											<a href="{{ route('redirect_fb') }}" class="btn btn-icon" style="width: 100%">
												<img src="img/ic-fb.svg" width="18">&nbsp;&nbsp; Facebook
											</a>
										</div>
										<div class="col-xs-6">
											<a href="{{ route('redirect_gg') }}" class="btn btn-icon" style="width: 100%">
												<img src="img/ic-gg.png" width="18">&nbsp;&nbsp; Google
											</a>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<br>
								<div  style="text-align: center;">
									<p class="title">
										Hoặc
									</p>
								</div>
								<input id="inpEmail" maxlength="100"
										class="form-control"
										placeholder="Email"
										name="email"
										type="text"
										data-validation-message="Email không đúng định dạng"
										data-validation="[EMAIL]">
							</div>
							<div class="form-group">
								<input id="inpPassword"
										class="form-control password"
										name="password"
										type="password" data-validation="[L>=10]"
										data-validation-message="Mật khẩu có ít nhất là 10 ký tự"
										placeholder="Mật Khẩu">
							</div>
							<a href="javascript: void(0);" class="pull-right link-blue" style="font-size: 12px">Quên mật khẩu?</a>
							<br>
							<div class="form-group" style="text-align: center;">
								<button id="btnLogin" type="submit" class="btn btn-primary width-150">ĐĂNG NHẬP</button>
								<br>
								<a href="{{ route('signup_page') }}" type="button" class="btn btn-link margin-inline" style="color: #02B3E4 !important;">Chưa có tài khoản, Đăng ký!</a>
								
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