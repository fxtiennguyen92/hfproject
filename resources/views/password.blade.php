@extends('template.index') @push('stylesheets')
<script>
$(document).ready(function() {
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
						url: '{{ route("change_password") }}',
						data: $('#frmMain').serialize(),
						success: function(response) {
							
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
	
	$('.password').password({
		eyeClass: '',
		eyeOpenClass: 'icmn-eye',
		eyeCloseClass: 'icmn-eye-blocked'
	});
});
</script>
@endpush @section('title') Mật khẩu @endsection @section('content')
<section class="content-body content-template-1">
	<form id="frmMain" class="form-wrapper" name="form-validation" method="post" enctype="multipart/form-data" action="">
		<h1 class="page-title text-left">Mật khẩu</h1>
		<div class="row">
			@if (!auth()->user()->password)
			<div class="common-text">Hãy tạo mật khẩu để có thể đăng nhập bằng tài khoản HandFree</div>
			@else
			<div class="col-md-12">
				<div class="form-group">
					<label>Mật khẩu hiện tại</label>
					<input type="password" maxlength="100" class="form-control password" name="currPassword" data-validation="[NOTEMPTY]">
				</div>
			</div>
			@endif
			<div class="col-md-12">
				<div class="form-group">
					<label>Mật khẩu mới</label>
					<input type="password" maxlength="100" class="form-control password" name="password" data-validation="[L>=6]">
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label>Xác nhận lại Mật khẩu</label>
					<input type="password" maxlength="100" class="form-control" name="password_confirmation" data-validation="[V==password]">
				</div>
			</div>
		</div>
		<div class="row row-btn-bottom form-group">
			<button id="btnLogin" type="submit" class="btn btn-primary width-150">@if (!auth()->user()->password) Thiết lập @else Thay đổi @endif</button>
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		</div>
	</form>
</section>
@endsection
