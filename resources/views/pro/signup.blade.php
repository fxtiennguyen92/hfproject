@extends('template.index')
@push('stylesheets')
<style>
	.dropdown-menu {
		z-index: 3000;
	}
</style>

<!-- Page Scripts -->
<script>
	$(document).ready(function() {
		$('.datepicker-only-init').datetimepicker({
			maxDate: moment(),
			minDate: moment().subtract(100, 'year'),
			locale: moment.locale('vi'),
			format: 'DD/MM/YYYY',
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
		$('.datepicker-only-init').each(function () {
			$(this).val('');
		});
		$('.phone').mask('0000000000000');
		$('.ddServices').select2({ closeOnSelect: false });
		$('.selectpicker').selectpicker();
		$('.ddCity').on('change', function() {
			if ($(this).val() == '') {
				return false;
			}
			
			var ddDist = $(this).parent().parent().parent().parent().find('select.ddDist');
			ddDist.children('option').remove();
			
			var url = '{{ route("get_dist_by_city", ["code" => "cityCode"]) }}';
			url = url.replace('cityCode', $(this).val());
			$.ajax({
				url: url,
				success: function (data) {
					$.each(data, function(key, value) {
						ddDist.append($('<option></option>')
									.attr('value', value.code)
									.text(value.name));
					});

					ddDist.selectpicker('refresh');
				}
			});
			
		});

		$('.row-company-info').hide();
		$('div[data-toggle="buttons"]').on('change', function() {
			var mode = $('input[name="operationMode"]:checked').val();
			if (mode == 0) {
				$('.row-company-info').hide();
				$('.comp-name').removeValidation('NOTEMPTY');
				$('.comp-addr').removeValidation('NOTEMPTY');
			} else {
				$('.row-company-info').show();
				$('.comp-name').addValidation('NOTEMPTY')
				$('.comp-addr').addValidation('NOTEMPTY')
			}

			$(this).find('span').each(function() {
				if ($(this).hasClass('icmn-radio-unchecked')) {
					$(this).removeClass('icmn-radio-unchecked').addClass('icmn-checkmark-circle');
				} else {
					$(this).removeClass('icmn-checkmark-circle').addClass('icmn-radio-unchecked');
				}
			});
		});

		$('input[name=email]').on('change', function() {
			if ($(this).val() !== '') {
				$(this).addValidation('EMAIL');
			} else {
				$(this).removeValidation('EMAIL');
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
					onError: function (e) {
						$.notify({
							title: '<strong>Thất bại! </strong>',
							message: 'Thông tin chưa đúng.' + e.toString()
						}, {
							type: 'danger',
							z_index: 1051,
						});
					},
					onSubmit: function() {
						$.ajax({
							type: 'POST',
							url: '{{ route("signup_pro") }}',
							data: $('#frmMain').serialize(),
							success: function(response) {
								swal({
									title: 'Chúc mừng',
									text: 'Đăng ký thành công, đội ngũ CSKH sẽ liên lạc với bạn trong thời gian nhanh nhất',
									type: 'success',
									confirmButtonClass: 'btn-primary',
									confirmButtonText: 'Kết thúc',
								},
								function() {
									location.href = '{{ route("home_page") }}';
								});
							},
							error: function(xhr) {
								if (xhr.status == 400) {
									$.notify({
										title: '<strong>Thất bại! </strong>',
										message: 'Không có thông tin để thay đổi.'
									}, {
										type: 'danger',
										z_index: 1051,
									});
								} else if (xhr.status == 409) {
									$.notify({
										title: '<strong>Thất bại! </strong>',
										message: 'Email hoặc Số Điện Thoại đã được sử dụng.'
									}, {
										type: 'danger',
										z_index: 1051,
									});
								} else {
									$.notify({
										title: '<strong>Thất bại! </strong>',
										message: 'Không đăng ký được, vui lòng thử lại.'
									}, {
										type: 'danger',
										z_index: 1051,
									});
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

@section('title') Trở thành Đối tác @endsection

@section('content')
<section class="content-body content-template-1">
	<form id="frmMain" class="form-wrapper" name="form-validation" method="post" enctype="multipart/form-data" action="{{ route('signup_pro') }}">
		<h1 class="page-title text-left">Thông tin <span style="white-space: nowrap;">Đối Tác<span></span></h1>
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Họ tên</label>
							<input type="text" maxlength="225" class="form-control" name="name" data-validation="[NOTEMPTY]">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Ngày tháng năm sinh</label>
							<input type="text" maxlength="10" class="form-control datepicker-only-init" name="dateOfBirth" data-validation="[NOTEMPTY]"/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Giới tính</label>
							<select class="form-control selectpicker hf-select" name="gender">
								<option value="1">Nam</option>
								<option value="2">Nữ</option>
								<option value="0">Khác</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Email</label>
							<input type="text" maxlength="100" class="form-control" name="email">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Số điện thoại</label>
							<input type="text" maxlength="25" class="form-control phone" name="phone" data-validation="[NOTEMPTY]">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Số CMND</label>
							<input type="text" maxlength="12" class="form-control" name="govId">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Ngày cấp</label>
							<input type="text" maxlength="10" class="form-control datepicker-only-init" name="govDate">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Nơi cấp</label>
							<input type="text" maxlength="50" class="form-control" name="govPlace">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Hộ khẩu</label>
							<input type="text" maxlength="150" class="form-control" name="familyRegAddress" data-validation="[NOTEMPTY]">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Quận/Huyện</label>
							<select class="form-control selectpicker ddDist hf-select" data-live-search="true" name="familyRegDist" data-validation="[NOTEMPTY]">
								@foreach($districts as $dist)
								<option value="{{ $dist->code }}">{{ $dist->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Thành phố/Tỉnh</label>
							<select class="form-control selectpicker ddCity hf-select" data-live-search="true" name="familyRegCity" data-validation="[NOTEMPTY]">
								@foreach($cities as $city)
								<option value="{{ $city->code }}">{{ $city->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Chỗ ở hiện nay</label>
							<input type="text" maxlength="150" class="form-control" name="address" data-validation="[NOTEMPTY]">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Quận/Huyện</label>
							<select class="form-control selectpicker ddDist hf-select" data-live-search="true" name="dist" data-validation="[NOTEMPTY]">
								@foreach($districts as $dist)
								<option value="{{ $dist->code }}">{{ $dist->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Thành phố/Tỉnh</label>
							<select class="form-control selectpicker ddCity hf-select" data-live-search="true" name="city" data-validation="[NOTEMPTY]">
								@foreach($cities as $city)
								<option value="{{ $city->code }}">{{ $city->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						<label>Hình thức kinh doanh</label>
						@if (auth()->check() && auth()->user()->role == 2)
							<input type="text" class="form-control" value="{{ $company->name }}" readonly>
						@else
						<div class="btn-group btn-group-50" data-toggle="buttons">
							<label class="btn active">
								<input type="radio" name="operationMode" value="0" checked="checked">
								<span class="icon icmn-checkmark-circle"></span>Cá nhân
							</label>
							<label class="btn">
								<input type="radio" name="operationMode" value="1">
								<span class="icon icmn-radio-unchecked"></span>Doanh nghiệp
							</label>
						</div>
						@endif
					</div>
				</div>

<!-- =================== DOANH NGHIỆP ================================ -->
				<div class="row-company-info row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Tên Doanh nghiệp</label>
							<input type="text" maxlength="150" class="comp-name form-control" name="compName">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label>Địa chỉ Doanh nghiệp</label>
							<input type="text" maxlength="150" class="comp-addr form-control" name="compAddress">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Quận/Huyện</label>
							<select class="form-control selectpicker ddDist hf-select" data-live-search="true" name="compDist">
								@foreach($districts as $dist)
								<option value="{{ $dist->code }}">{{ $dist->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Thành phố/Tỉnh</label>
							<select class="form-control selectpicker ddCity hf-select" data-live-search="true" name="compCity">
								@foreach($cities as $city)
								<option value="{{ $city->code }}">{{ $city->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
<!-- ========================================================================= -->
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Dịch vụ tham gia</label>
							<select class="form-control ddServices hf-select" multiple name="services[]">
								@foreach($services as $service)
									@if (auth()->check() && auth()->user()->role == 2)
										@if (in_array($service->id, json_decode($company->services, true)))
										<option value="{{ $service->id }}">{{ $service->name }}</option>
										@endif
									@else
										<option value="{{ $service->id }}">{{ $service->name }}</option>
									@endif
								@endforeach
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group" style="text-align: right;">
			<button id="btnSubmit" type="submit" class="btn btn-primary width-150 margin-top-50">Đăng ký</button>
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		</div>
	</form>
	<!-- MODAL -->
</section>
@endsection
