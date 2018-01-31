@extends('template.index_no_nav')
@push('stylesheets')
	<style>
    	.single-page-login-alpha {
			background-image: url(assets/common/img/temp/login/5.jpg);
		}
		@media only screen and (min-width: 540px) {	
			.single-page-block-inner {
				margin-top: 100px;
			}
			.page-content {
				margin-top: -60px;
				position: fixed;
			}
		}
		@media only screen and (max-width: 425px) {
			.page-content {
				margin-top: -60px;
				position: fixed;
			}
			.title {
				margin-top: -30px;
			}
			.single-page-login-alpha {
				background-image: none;	
			}
			.single-page-block-inner {				
				box-shadow: none !important;
				padding-left: 0px !important;
				padding-right: 0px !important;	
			}			
			.single-page-block {			
				padding-right: 10px !important;
			}
			@media only screen and (max-width: 321px) {
				.single-page-block-inner {
					padding-right: 20px !important;
				}
			}
    </style>
	<script>
		$(document).bind('keypress', function(e) {
			if (e.keyCode == 13) {
				$('#btnSignup').trigger('click');
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
								url: '{{ route("signup") }}',
								data: $('#frmMain').serialize(),
								success: function(response) {
									
								},
								error: function(xhr) {
									if (xhr.status == 409) {
										$.notify({
											title: '<strong>Thất bại! </strong>',
											message: 'Email hoặc Số Điện Thoại đã được sử dụng.'
										},{
											type: 'danger'
										});
									} else {
										$.notify({
											title: '<strong>Thất bại! </strong>',
											message: 'Tạo tài khoản thất bại, hãy thử lại.'
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
	Đăng ký
@endsection

@section('content')
<section class="page-content" style="width: 100%">
<div class="page-content-inner single-page-login-alpha">
	<!-- SignUp Page -->
	<div class="single-page-block">
		<div class="row">
			<div class="col-xl-4" style="width: 100%;" >				
				<div class="single-page-block-inner">
					<div class="logo" style="text-align: center; margin-top: 10px;">
						<a href="javascript: history.back();">
							<img src="img/logoh.png" alt="Hand Free" width="250"/>
						</a>
					</div>

					<div class="single-page-block-form">
						<form id="frmMain" name="form-validation" method="POST" action="{{ route('signup') }}">
							<div class="form-group">
								<div class="social-login">
									<div class="social-container row">
										<div>
											<p>Đăng ký nhanh với</p>
										</div>
										<div class="col-xs-6">
											<a href="{{ route('redirect_fb') }}" class="btn btn-icon" style="width: 100%">
												<img src="img/ic-fb.svg" width="20">&nbsp;&nbsp; Facebook
											</a>
										</div>
										<div class="col-xs-6" style="padding-right: 14px;">
											<a href="{{ route('redirect_gg') }}" class="btn btn-icon" style="width: 100%;">
												<img src="img/ic-gg.png" width="20">&nbsp;&nbsp; Google
											</a>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<br><div style="text-align: center;"><p class="title">Hoặc</p></div>
								<input id="inpName" maxlength="200"
										class="form-control"
										placeholder="Họ và Tên"
										name="name"
										type="text"
										data-validation-message="Họ tên chưa được nhập"
										data-validation="[L>=0]">
							</div>
							<div class="form-group">
								<input id="inpEmail" maxlength="100"
										class="form-control"
										placeholder="Email"
										name="email"
										type="text"
										data-validation-message="Email không đúng định dạng"
										data-validation="[EMAIL]">
							</div>
							<div class="form-group">
								<input id="inpPhone" maxlength="25"
										class="form-control"
										name="phone"
										type="text"
										data-validation="[INTEGER]"
										data-validation-message="Số điện thoại không đúng"
										placeholder="Số Điện Thoại">
							</div>
							<div class="form-group">
								<input id="inpPassword"
										class="form-control password"
										name="password"
										type="password" data-validation="[L>=6]"
										data-validation-message="Mật khẩu có ít nhất là 6 ký tự"
										placeholder="Mật Khẩu">
							</div>
							<div class="form-group" style="text-align: center;">
								<button type="submit" class="btn btn-success width-200" style="margin-bottom: 10px; margin-top: 10px;">ĐĂNG KÝ</button>
								<br>
								<a href="{{ route('login_page') }}" type="button" class="btn btn-link margin-inline" style="color: #02B3E4 !important; margin-top: -10px;">Đã có tài khoản, Đăng nhập!</a>
								
								<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Signup Page -->
</div>
</section>
@endsection
