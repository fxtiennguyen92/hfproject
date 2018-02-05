@extends('template.index')

@push('stylesheets')
	<style>
	nav.top-menu {
		display: none;
	}
	body {
		background: #f4f4f4;
	}
	nav.top-menu+.page-content {
		margin-top: 0;
	}
	</style>

	<!-- Page Scripts -->
	<script>
	$(document).ready(function() {
		$('.datepicker-only-init').datetimepicker({
			maxDate: moment().subtract(10, 'year'),
			minDate: moment().subtract(100, 'year'),
			locale: moment.locale('vi'),
			format: 'DD/MM/YYYY',
			defaultDate: '',
			icons: {
				time: 'fa fa-clock-o',
				date: 'fa fa-calendar',
				up: 'fa fa-chevron-up',
				down: 'fa fa-chevron-down',
				previous: 'fa fa-chevron-left',
				next: 'fa fa-chevron-right',
				today: 'fa fa-screenshot',
				clear: 'fa fa-trash',
				close: 'fa fa-check'
			},
		});
		$('.phone').mask('0000000000000');

		<!-- Autocomplete Companies - STA -->
		var path = "{{ route('get_companies') }}";
		$('#inpCompany').typeahead({
			minLength: 2,
			maxItem: 5,
			order: 'asc',
			source: function(request, response) {
				$.ajax({
					url: path,
					dataType: 'json',
					data: {
						term: $('#inpCompany').val(),
					},
					success: function (data) {
						response(data);
					}
				});
			},
			displayText: function (item) {
				return item.value;
			}
		});
		<!-- Autocomplete Companies - END -->
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
							url: '{{ route("change_pro_profile") }}',
							data: $('#frmMain').serialize(),
							success: function(response) {
								$.notify({
									title: '<strong>Hoàn tất! </strong>',
									message: 'Thông tin cá nhân đã thay đổi thành công.'
								},{
									type: 'success',
									z_index: 1051,
								});
	
								setTimeout(function() {
									location.reload();
								}, 1500);
							},
							error: function(xhr) {
								if (xhr.status == 400) {
									$.notify({
										title: '<strong>Thất bại! </strong>',
										message: 'Không có thông tin để thay đổi.'
									},{
										type: 'danger',
										z_index: 1051,
									});
								} else {
									$.notify({
										title: '<strong>Thất bại! </strong>',
										message: 'Không thể Cập nhật thông tin cá nhân.'
									},{
										type: 'danger',
										z_index: 1051,
									});
								};
	
								setTimeout(function() {
									location.reload();
								}, 1500);
							}
						});
					}
				}
			}
		});

		$('#frmChangePassword').validate({
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
							data: $('#frmChangePassword').serialize(),
							success: function(response) {
								$.notify({
									title: '<strong>Hoàn tất! </strong>',
									message: 'Mật khẩu đã thay đổi thành công.'
								},{
									type: 'success',
									z_index: 1051,
								});

								setTimeout(function() {
									location.reload();
								}, 1500);
							},
							error: function(xhr) {
								if (xhr.status == 401) {
									$.notify({
										title: '<strong>Thất bại! </strong>',
										message: 'Mật khẩu hiện tại chưa đúng.'
									},{
										type: 'danger',
										z_index: 1051,
									});
								} else if (xhr.status == 400) {
									$.notify({
										title: '<strong>Thất bại! </strong>',
										message: 'Mật khẩu mới giống Mật khẩu hiện tại.'
									},{
										type: 'danger',
										z_index: 1051,
									});
								} else {
									$.notify({
										title: '<strong>Thất bại! </strong>',
										message: 'Thay đổi Mật khẩu thất bại.'
									},{
										type: 'danger',
										z_index: 1051,
									});

									setTimeout(function() {
										location.reload();
									}, 1500);
								};
							}
						});
					}
				}
			}
		});
	});
	</script>

@endpush

@section('title')

@endsection

@section('content')
<section class="page-content signup-pro">
	<div class="header-logo">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<a href="#"><img src="img/hf-logo.png" /></a>
			</div>
		</div>
	</div>
	<div class="col-md-2">
	</div>
	<div class="col-md-8">
	<form id="frmMain" class="form-wrapper hf-card" name="form-validation" method="post" enctype="multipart/form-data" action="{{ route('change_pro_profile') }}">
		<h1 class="page-title text-left">Thông tin Đối Tác</h1>
		<div class="form-group">
			<label>Họ tên</label>
			<input maxlength="200"
				class="form-control"
				placeholder="Họ và Tên"
				name="name"
				type="text"
				data-validation-message="Chưa nhập thông tin này"
				data-validation="[NOTEMPTY]">
		</div>
		<div class="form-group">
			<label>Ngày tháng năm sinh</label>
			<input type="text"
				class="form-control datepicker-only-init"
				name="dateOfBirth"
				data-validation-message="Chưa nhập thông tin này"
				data-validation="[NOTEMPTY]"/>
		</div>
		<div class="form-group">
			<label>Giới tính</label>
			<select class="form-control"
					name="gender"
					data-validation-message="Chưa nhập thông tin này"
					data-validation="[NOTEMPTY]">
				<option value="" disabled selected>Giới tính</option>
				<option value="1">Nam</option>
				<option value="2">Nữ</option>
				<option value="0">Khác</option>
			</select>
		</div>
		<div class="form-group">
			<label>Số CMND</label>
			<input type="text" class="form-control" name="govId">
		</div>
		<div class="form-group">
			<label>Hộ khẩu</label>
			<input type="text" class="form-control" name="familyRegister">
		</div>
		<div class="form-group">
			<label>Thành phố/Tỉnh</label>
			<select class="form-control" name="familyRegister_city">
				<option value="" selected disabled>Thành phố / Tỉnh</option>
				@foreach ($cities as $city)
					<option value="{{ $city->code }}">{{ $city->name }}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label>Quận/Huyện</label>
			<select class="form-control" name="familyRegister_dist"
					data-validation-message="Chưa nhập thông tin này"
					data-validation="[NOTEMPTY]">
				<option value="" selected>Quận / Huyện</option>
			</select>
		</div>
		<div class="form-group">
			<label>Chỗ ở hiện nay</label>
			<input type="text" class="form-control" name="address">
		</div>
		<div class="form-group">
			<label>Thành phố/Tỉnh</label>
			<select class="form-control" name="city">
				<option value="" selected disabled>Thành phố / Tỉnh</option>
				@foreach ($cities as $city)
					<option value="{{ $city->code }}">{{ $city->name }}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label>Quận/Huyện</label>
			<select class="form-control" name="dist"
					data-validation-message="Chưa nhập thông tin này"
					data-validation="[NOTEMPTY]">
				<option value="" selected>Quận / Huyện</option>
			</select>
		</div>
		<div class="form-group">
			<label>Email</label>
			<input type="text" class="form-control" name="email">
		</div>
		<div class="form-group">
			<label>Số điện thoại</label>
			<input type="text" maxlength="25"
				class="form-control phone"
				name="phone"
				placeholder="Số điện thoại">
		</div>
		
		<div class="form-group">
			<label>Công ty</label>
			<div class="typeahead__container">
				<div class="typeahead__field">
					<div class="typeahead__query">
						<input class="form-control" type="text"
							placeholder="Công ty"
							autocomplete="off"
							id="inpCompany"
							name="company"/>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label>Địa chỉ công ty</label>
			<input type="text" class="form-control" name="address" disabled>
		</div>
		<div class="form-group" style="text-align: center;">
			<button id="btnSubmit" type="submit" class="btn btn-primary width-150">Đăng ký</button>
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		</div>
	</form>
	</div>
	
	<!-- MODAL -->
</section>
@endsection