@extends('template.index-no-nav') @push('stylesheets')
<style type="text/css">
</style>

<!-- Page Scripts -->
<script>
$(document).ready(function() {
	$('#inpUsername').focus();
	$('.phone').mask('0000000000000');
	$('.sac').mask('0000');
	
	// update phone
	@if (session('error') == 428)
	$('#modalPhone #frmPhone').validate({
		submit: {
			settings: {
				inputContainer: '.form-group',
				errorListClass: 'form-control-error',
				errorClass: 'has-danger',
			},
			callback: {
				onSubmit: function() {
					loadingBtnSubmit('btnUpdate');
					
					$.ajax({
						type: 'POST',
						url: '{{ route("profile_phone_update") }}',
						data: $('#modalPhone #frmPhone').serialize(),
						success: function(response) {
							$('#modalPhone').modal('hide');
							swal({
								title: 'Thành công',
								text: 'Cập nhật Số điện thoại hoàn tất',
								type: 'success',
								confirmButtonClass: 'btn-primary',
								confirmButtonText: 'Tiếp tục',
							},
							function() {
								location.href = "{{ route('home_page') }}";
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
									text: 'Số điện thoại đã được sử dụng.',
									type: 'error',
									confirmButtonClass: 'btn-default',
									confirmButtonText: 'Quay lại',
								});
							} else {
								swal({
									title: 'Thất bại',
									text: 'Cập nhật không thành công',
									type: 'error',
									confirmButtonClass: 'btn-default',
									confirmButtonText: 'Thử lại',
								});
							};
							resetBtnSubmit('btnUpdate', 'Cập nhật');
						}
					});
				}
			}
		}
	});
	$('#modalPhone').modal({backdrop: 'static', keyboard: false});
	@endif
	
	@if (session('error') == 401)
	swal({
		title: 'Thất bại',
		text: 'Tài khoản đăng nhập không đúng',
		type: 'error',
		confirmButtonClass: 'btn-danger',
		confirmButtonText: 'Quay lại',
	});
	@elseif (session('error') == 400)
		swal({
			title: 'Tài khoản vô hiệu',
			text: 'Vui lòng liên hệ Bộ phận CSKH',
			type: 'error',
			confirmButtonClass: 'btn-danger',
			confirmButtonText: 'Quay lại',
		});
	@elseif (session('error') == 406)
		swal({
			title: 'Email chưa xác thực',
			text: 'Xác nhận Email để nhận thêm thông tin từ HandFree',
			type: 'warning',
			confirmButtonClass: 'btn-warning',
			confirmButtonText: 'Tiếp tục',
		},
		function() {
			location.href = "{{ route('home_page') }}";
		});
	@endif
	
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
			
			@if (auth()->check())
			var url = '{{ route("signup_get_sac") }}';
			@else
			var url = '{{ route("password_reset_get_sac") }}';
			@endif
			$.ajax({
				type: 'POST',
				url: url,
				data: $('#frmPhone').serialize(),
				success: function(response) {
					$('#btnSendSAC').html('Đã gửi mã PIN');
					setTimeout(function() {
						$('#btnSendSAC').removeClass('disabled');
						$('#btnSendSAC').html('Gửi lại Mã PIN');
					}, 60000);
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
					} else if (xhr.status == 406) {
						$.notify({
							title: '<strong>Không tồn tại!</strong>',
							message: 'Số điện thoại chưa được đăng ký.'
						}, {
							type: 'danger',
							z_index: 1051,
						});
					} else if (xhr.status == 409) {
						$.notify({
							title: '<strong>Vô hiệu!</strong>',
							message: 'Số điện thoại này không đúng.'
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
			}
		},
		callback: {
			onBeforeSubmit: function() {
				loadingBtnSubmit('btnLogin');
			},
		}
	});

	@if (!auth()->check())
	$('#btnResetPassword').on('click', function() {
		$('#modalReset').find('input[type=text]').each(function() {
			$(this).val('');
		});
		$('#modalReset').modal('show');
	});

	$('#modalReset #frmPhone').validate({
		submit: {
			settings: {
				inputContainer: '.form-group',
				errorListClass: 'form-control-error',
				errorClass: 'has-danger',
			},
			callback: {
				onSubmit: function() {
					loadingBtnSubmit('btnUpdatePassword');
					
					$.ajax({
						type: 'POST',
						url: '{{ route("password_reset") }}',
						data: $('#modalReset #frmPhone').serialize(),
						success: function(response) {
							swal({
								title: 'Cấp lại Mật khẩu',
								text: 'Đã gửi Mật khẩu mới, kiểm tra tin nhắn',
								type: 'info',
								confirmButtonClass: 'btn-primary',
								confirmButtonText: 'Quay lại',
							});
							$('#modalReset').modal('hide');
							resetBtnSubmit('btnUpdatePassword', 'Cấp lại Mật khẩu');
						},
						error: function(xhr) {
							if (xhr.status == 401) {
								swal({
									title: 'Mã PIN',
									text: 'Mã xác thực không đúng.',
									type: 'error',
									confirmButtonClass: 'btn-default',
									confirmButtonText: 'Quay lại',
								});
							} else if (xhr.status == 503) {
								swal({
									title: 'Thất bại',
									text: 'Gửi tin nhắn thất bại',
									type: 'error',
									confirmButtonClass: 'btn-default',
									confirmButtonText: 'Quay lại',
								});
							} else {
								swal({
									title: 'Thất bại',
									text: 'Có lỗi phát sinh, mời thử lại',
									type: 'error',
									confirmButtonClass: 'btn-default',
									confirmButtonText: 'Thử lại',
								});
							};
							resetBtnSubmit('btnUpdatePassword', 'Cấp lại Mật khẩu');
						}
					});
				}
			}
		}
	});
	@endif
	
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
			<div class="@if (auth()->check()) hide @endif">
				<div class="login-form-wrapper">
					<div class="single-page-block-inner">
						<div class="logo" style="margin-bottom: 30px;">
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
									<a id="btnResetPassword" href="javascript: void(0);" class="pull-right link-blue" style="font-size: 12px">Quên mật khẩu?</a>	
								<br>
								<div class="form-group" style="text-align: center; margin-top: 34px; margin-bottom: 0">
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
	
	@if (auth()->check())
	<div id="modalPhone" class="modal modal-size-small fade" role="dialog">
		<div class="modal-dialog">
			<form id="frmPhone" method="post" name="form-validation" enctype="multipart/form-data" action="{{ route('profile_phone_update') }}">
			<div class="modal-content">
				<div class="modal-body margin-top-10 padding-top-30 padding-bottom-30">
					<div class="logo" style="margin-bottom: 30px;">
						<a href="javascript: void(0);">
							<img src="{{ env('CDN_HOST') }}/img/logo/logoh.png" alt="HandFree" width="150"/>
						</a>
					</div>
					<h1 class="padding-top-30 text-center" style="font-weight: normal;">Cập nhật Thông tin</h1>
					<p class="text-center"><small>Hiện tại Thông tin tài khoản của bạn chưa có Số điện thoại, vui lòng cập nhật để tham gia cùng HANDFREE.</small></p>
					<div class="margin-top-30 margin-bottom-20 row">
						<div class="col-xs-12">
							<input id="inpPhone" maxlength="25" class="form-control phone" placeholder="Số điện thoại" name="phone" type="text" data-validation="[NOTEMPTY]">
						</div>
					</div>
					<div class="margin-bottom-30 row">
						<div class="col-xs-12 text-center">
							<span id="btnSendSAC" class="btnSendSAC btn width-150">Gửi mã PIN</span>
						</div>
					</div>
					<div class="margin-bottom-30 row">
						<div class="col-xs-12">
							<input id="inpSAC" maxlength="4" class="form-control sac" placeholder="Nhập Mã PIN" name="sac" type="text" data-validation="[NOTEMPTY, INTEGER]">
						</div>
					</div>
					<div class="padding-top-30 padding-bottom-30 text-center">
						<button id="btnUpdate" type="submit" class="btn btn-primary width-150">Cập nhật</button>
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
	@else
	<div id="modalReset" class="modal modal-size-small fade" role="dialog">
		<div class="modal-dialog">
			<form id="frmPhone" method="post" name="form-validation" enctype="multipart/form-data" action="{{ route('password_reset') }}">
			<div class="modal-content">
				<div class="modal-body margin-top-10 padding-top-30 padding-bottom-30">
					<div class="logo" style="margin-bottom: 30px;">
						<a href="javascript: void(0);">
							<img src="{{ env('CDN_HOST') }}/img/logo/logoh.png" alt="HandFree" width="150"/>
						</a>
					</div>
					<h1 class="padding-top-30 text-center" style="font-weight: normal;">Cấp lại Mật khẩu</h1>
					<p class="text-center"><small><b>Mật khẩu mới</b> sẽ được gửi đến Số điện thoại của bạn</small></p>
					<div class="margin-top-30 margin-bottom-20 row">
						<div class="col-xs-12">
							<input id="inpPhone" maxlength="25" class="form-control phone" placeholder="Số điện thoại" name="phone" type="text" data-validation="[NOTEMPTY]">
						</div>
					</div>
					<div class="margin-bottom-30 row">
						<div class="col-xs-12 text-center">
							<span id="btnSendSAC" class="btnSendSAC btn width-150">Gửi mã PIN</span>
						</div>
					</div>
					<div class="margin-bottom-30 row">
						<div class="col-xs-12">
							<input id="inpSAC" maxlength="4" class="form-control sac" placeholder="Nhập Mã PIN" name="sac" type="text" data-validation="[NOTEMPTY, INTEGER]">
						</div>
					</div>
					<div class="padding-top-30 padding-bottom-30 text-center">
						<button id="btnUpdatePassword" type=submit class="btn btn-primary width-150">Cấp lại Mật khẩu</button>
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
	@endif
</section>
@endsection
