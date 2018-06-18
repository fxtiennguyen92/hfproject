@extends('template.index-no-nav') @push('stylesheets')
<script src='https://www.google.com/recaptcha/api.js?hl=vi'></script>
<style>
	.btnSendSAC, .btnSendSAC:hover {
		margin-bottom: -20px;
		font-size: 12px;
		background-color: #01a8fe;
		border-color: #01a8fe;
		color: #fff;
	}
</style>
<script>
	$(document).ready(function() {
		$('.phone').mask('0000000000000');
		$('.sac').mask('0000');
		$('.password').password({
			eyeClass: '',
			eyeOpenClass: 'icmn-eye',
			eyeCloseClass: 'icmn-eye-blocked'
		});

		$('#btnSendSAC').on('click', function() {
			if ($('input[name=phone]').val() == '') {
				$('input[name=phone]').focus();
				$.notify({
					title: '<strong>Lỗi! </strong>',
					message: 'Chưa có thông tin về Số điện thoại.'
				}, {
					type: 'danger',
					z_index: 1051,
				});
			} else {
				$('#btnSendSAC').addClass('disabled');
				$('#btnSendSAC').html('<i class="fa fa-spinner fa-spin"></i> Đang gửi')
				
				$.ajax({
					type: 'POST',
					url: '{{ route("signup_get_sac") }}',
					data: $('#frmMain').serialize(),
					success: function(response) {
						$('#btnSendSAC').html('Đã gửi mã PIN');
						setTimeout(function() {
							$('#btnSendSAC').removeClass('disabled');
							$('#btnSendSAC').html('Gửi lại Mã PIN');
						}, 30000);
					},
					error: function(xhr) {
						if (xhr.status == 400) {
							$.notify({
								title: '<strong>Lỗi! </strong>',
								message: 'Chưa có thông tin về Số điện thoại.'
							}, {
								type: 'danger',
								z_index: 1051,
							});
						} else if (xhr.status == 409) {
							$.notify({
								title: '<strong>Đã sử dụng! </strong>',
								message: 'Số điện thoại đã được đăng ký.'
							}, {
								type: 'danger',
								z_index: 1051,
							});
						} else if (xhr.status == 503) {
							$.notify({
								title: '<strong>Lỗi SMS! </strong>',
								message: 'Gửi tin nhắn thất bại, mời thử lại.'
							}, {
								type: 'danger',
								z_index: 1051,
							});
						} else {
							$.notify({
								title: '<strong>Thất bại! </strong>',
								message: 'Có lỗi phát sinh, mời thử lại.'
							}, {
								type: 'danger',
								z_index: 1051,
							});
						}

						setTimeout(function() {
							$('#btnSendSAC').removeClass('disabled');
							$('#btnSendSAC').html('Gửi lại Mã PIN');
						}, 2000);
					}
				});
				
			}
		});
		
		$('#frmMain').validate({
			submit: {
				settings: {
					inputContainer: '.form-group',
					errorListClass: 'form-control-error',
					errorClass: 'has-danger',
				},
				callback: {
					onSubmit: function() {
						loadingBtnSubmit('btnSubmit');
						
						$.ajax({
							type: 'POST',
							url: '{{ route("signup") }}',
							data: $('#frmMain').serialize(),
							success: function(response) {
								swal({
									title: 'Thành công',
									text: 'Tạo tài khoản thành công',
									type: 'success',
									confirmButtonClass: 'btn-primary',
									confirmButtonText: 'Đăng nhập',
								},
								function() {
									location.href = "{{ route('login_page') }}";
								});
							},
							error: function(xhr) {
								if (xhr.status == 401) {
									swal({
										title: 'PIN Code!',
										text: 'Mã xác thực không đúng.',
										type: 'error',
										confirmButtonClass: 'btn-default',
										confirmButtonText: 'Quay lại',
									});
								} else if (xhr.status == 409) {
									swal({
										title: 'Thất bại',
										text: 'Số điện thoại hoặc Email đã được sử dụng.',
										type: 'error',
										confirmButtonClass: 'btn-default',
										confirmButtonText: 'Quay lại',
									});
								} else if (xhr.status == 429) {
									swal({
										title: 'Lỗi CAPTCHA',
										text: 'Captcha chưa được xác nhận hoặc đã vô hiệu.',
										type: 'error',
										confirmButtonClass: 'btn-default',
										confirmButtonText: 'Quay lại',
									});
								} else {
									swal({
										title: 'Thất bại',
										text: 'Đăng ký không thành công',
										type: 'error',
										confirmButtonClass: 'btn-default',
										confirmButtonText: 'Thử lại',
									});
								};
								grecaptcha.reset();
								resetBtnSubmit('btnSubmit', 'Tạo tài khoản');
							}
						});
					}
				}
			}
		});
	});
</script>
<!-- End Page Scripts -->
@endpush @section('title') Đăng ký @endsection @section('content')
<section class="page-content">
	<div class="page-content-inner single-page-login-alpha" style="background-image:url({{ env('CDN_HOST') }}/img/banner/bg_auth_page.png);">
		<div class="single-page-block">
			<div class="signup-form-wrapper">
				<div class="single-page-block-inner">
					<div class="logo" style="margin-bottom: 30px;">
						<a href="{{ route('home_page') }}">
							<img src="{{ env('CDN_HOST') }}/img/logo/logoh.png" width="150"/>
						</a>
					</div>
					<h1 class="page-title"> Đăng ký </h1>
					<div class="single-page-block-form">
						<form id="frmMain" name="form-validation" method="POST" action="{{ route('signup') }}">
							<div class="margin-bottom-10 row">
								<div class="col-xs-12">
									<input id="inpName" maxlength="200" class="form-control" placeholder="Họ và Tên" name="name" type="text" data-validation="[NOTEMPTY]">
								</div>
							</div>
							<div class="margin-bottom-10 row">
								<div class="col-xs-12">
									<input id="inpPhone" maxlength="25" class="form-control phone" placeholder="Số điện thoại" name="phone" type="text" data-validation="[NOTEMPTY, INTEGER]">
								</div>
							</div>
							<div class="margin-bottom-10 row">
								<div class="col-xs-8">
									<input id="inpSAC" maxlength="4" class="form-control sac" placeholder="Mã kích hoạt" name="sac" type="text" data-validation="[NOTEMPTY, INTEGER]">
								</div>
								<div class="col-xs-4 text-right">
									<span id="btnSendSAC" class="btnSendSAC btn">Gửi mã PIN</span>
								</div>
							</div>
							<div class="margin-bottom-10 row">
								<div class="col-xs-12">
									<input id="inpEmail" maxlength="100" class="form-control" placeholder="Email" name="email" type="text" data-validation="[NOTEMPTY, EMAIL]">
								</div>
							</div>
							<div class="margin-bottom-10 row">
								<div class="col-xs-12">
									<input id="inpPassword" maxlength="50" class="form-control password" placeholder="Mật khẩu" name="password" type="password" data-validation="[NOTEMPTY, L>=6, L<=50]">
								</div>
							</div>
							<div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_SITEKEY') }}"></div>
							<div class="text-center row">
								<button id="btnSubmit" type="submit" class="margin-top-20 btn btn-primary width-200">Tạo tài khoản</button>
								<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							</div>
							<div class="text-center">
								<a href="{{ route('login_page') }}" type="button" class=" btn btn-link" style="color: #02B3E4 !important">Đã có tài khoản, Đăng nhập!</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
