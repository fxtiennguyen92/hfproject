@extends('template.index') @push('stylesheets')
<script>
$(document).ready(function() {
	@if (session('error'))
		swal({
			title: 'Thất bại',
			text: '{{ session("error") }}',
			type: 'error',
			confirmButtonClass: 'btn-default',
			confirmButtonText: 'Quay lại',
		});
	@endif
	
	$('#frmMain').validate({
		submit: {
			settings: {
				inputContainer: '.form-group',
				errorListClass: 'form-control-error',
				errorClass: 'has-danger',
			},
			callback: {
				onBeforeSubmit: function() {
					loadingBtnSubmit('btnUpdate');
				}
			}
		}
	});
	
	$('#btnReset').on('click', function() {
		swal({
			title: 'Quên mật khẩu',
			text: 'Mật khẩu mới sẽ được cấp lại và gửi đến tin nhắn hoặc email của bạn',
			type: 'warning',
			showCancelButton: true,
			cancelButtonClass: 'btn-default',
			confirmButtonClass: 'btn-danger',
			cancelButtonText: 'Quay lại',
			confirmButtonText: 'Cấp lại',
		},
		function() {
			loadingBtnSubmit('btnUpdate');
			$('#frmReset').submit();
		});
	});
	
	$('.password').password({
		eyeClass: '',
		eyeOpenClass: 'icmn-eye',
		eyeCloseClass: 'icmn-eye-blocked'
	});
});
</script>
@endpush @section('title') Mật khẩu @endsection @section('content')
<section class="content-body content-template-1" style="min-height: 0px;">
	<div class="page-header hf-bg-gradient text-capitalize">Mật khẩu</div>
	<form id="frmMain" class="form-wrapper" name="form-validation" method="post" enctype="multipart/form-data" action="{{ route('password_update') }}">
		<div class="padding-bottom-20 row">
			@if (!auth()->user()->password)
			<div class="common-text">Hãy tạo mật khẩu để có thể đăng nhập bằng tài khoản HandFree</div>
			@else
			<div class="col-md-12">
				<div class="form-group">
					<label>Mật khẩu hiện tại</label>
					<input type="password" maxlength="100" class="form-control password" name="current_password" data-validation="[NOTEMPTY]">
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
			<div class="col-md-12 text-right" style="font-size: 13px">
				<button type="button" id="btnReset" class="btn-reset btn btn-link">Quên mật khẩu</a>
			</div>
		</div>
		<div>
			<button id="btnUpdate" type="submit" class="btn btn-primary" style="width: 100%">@if (!auth()->user()->password) Thiết lập @else Thay đổi @endif</button>
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		</div>
	</form>
	<form id="frmReset" class="form-wrapper" method="post" action="{{ route('password_reset') }}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
	</form>
</section>
@endsection
