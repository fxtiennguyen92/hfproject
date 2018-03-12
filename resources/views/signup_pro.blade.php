@extends('template.index')
@push('stylesheets')
<style>
	nav.top-menu {
		display: none;
	}

	body {
		background-image: url(img/bgdoitac.png);
		background-size: cover;
	}

	.page-content {
		margin-left: 0px;
	}
	nav.top-menu+.page-content {
		margin-top: 0;
	}

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
					onError: function () {
						$.notify({
							title: '<strong>Thất bại! </strong>',
							message: 'Thông tin chưa đúng hoặc chưa đầy đủ.'
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
								$.notify({
									title: '<strong>Hoàn tất! </strong>',
									message: 'Đăng ký thành công.'
								}, {
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
	<div class="col-md-6" style="color: #fff;">
		<div class="cell-wrapper layout-widget-wrapper">
			<span id="hs_cos_wrapper_module_1496142652331121" class="hs_cos_wrapper hs_cos_wrapper_widget hs_cos_wrapper_type_rich_text" style="" data-hs-cos-general-type="widget" data-hs-cos-type="rich_text">
				<p style="text-align: center;">&nbsp;</p>
				<p style="text-align: center;">&nbsp;</p>
				<p style="text-align: center;"><span style="background-color: transparent; font-size: 24px;"><strong>TRỞ THÀNH ĐỐI TÁC VỚI HANDFREE<br><br></strong></span></p>
				<p style="text-align: center;"><span style="background-color: transparent; letter-spacing: 0.72px; font-size: 20px;">&nbsp; &nbsp; &nbsp;Tận dụng thời gian rảnh - Kiếm thêm thu nhập với chính kỹ năng của bạn<br>&nbsp;&nbsp;<br></span>&nbsp; &nbsp; &nbsp;<strong style="font-size: 20px; text-align: center; background-color: transparent; letter-spacing: 0.06em;">ĐĂNG KÝ NGAY ĐỂ NHẬN CÁC ĐẶC QUYỀN HẤP DẪN</strong></p>
				<p style="font-size: 20px; line-height: 1px; text-align: center;"><span style="font-size: 18px; line-height: 1.15em;">(Ưu tiên các đối tác khu vực nội thành <strong>Hồ Chí Minh</strong>)</span></p>
				<p style="font-size: 20px; line-height: 1px; text-align: center;">&nbsp;</p>
				<table style="margin-left: auto; margin-right: auto;">
					<tbody>
						<tr style="height: 89px;">
							<td style="width: 150px; height: 89px; text-align: right;">
								<p>
									<img src="http://v.fastcdn.co/u/d4b02ad8/16955801-0-icon-2-78.png" width="100" caption="false" data-constrained="true" style="width: 80px; display: block; margin-left: auto; margin-right: auto;">
								</p>
							</td>
							<td style="height: 89px;">
								<p><span style="font-size: 30px; color:#02b3e4;"><strong>Đào tạo miễn phí</strong></span></p>
								<p><span style="font-size: 18px;">Không cần kinh nghiệm</span></p>
							</td>
						</tr>
						<tr style="height: 89px;">
							<td style="width: 150px; height: 89px; text-align: right;">
								<p><span style="font-size: 18px;"><img src="http://v.fastcdn.co/u/d4b02ad8/16648396-0-icon-2-72.png" width="100" caption="false" data-constrained="true" style="width: 80px; display: block; margin-left: auto; margin-right: auto;"></span></p>
							</td>
							<td style="height: 89px;">
								<p><span style="font-size: 30px; color:#02b3e4;"><strong>Thưởng khi đăng ký</strong></span></p>
								<p><span style="font-size: 18px;">Ưu đãi hấp dẫn cho đối tác đăng ký mới</span></p>
							</td>
						</tr>
						<tr style="height: 89px;">
							<td style="width: 150px; height: 89px; text-align: right;">
								<p><img src="https://v.fastcdn.co/u/d4b02ad8/16955666-0-icon-2-75.png" style="width: 80px; display: block; margin-left: auto; margin-right: auto;" width="100" caption="false" data-constrained="true"></p>
							</td>
							<td style="height: 89px;">
								<p><span style="font-size: 30px; color:#02b3e4;"><strong>Làm việc linh động</strong></span></p>
								<p><span style="font-size: 24px; "><span style="font-size: 20px;">Chủ động thời gian làm việc</span><strong><span>&nbsp;</span></strong></span></p>
							</td>
						</tr>
						<tr style="height: 89px;">
							<td style="width: 150px; height: 89px; text-align: right;">
								<p><img src="https://v.fastcdn.co/u/d4b02ad8/16648391-0-icon-2-71.png" width="100" caption="false" data-constrained="true" style="width: 80px; display: block; margin-left: auto; margin-right: auto;"></p>
							</td>
							<td style="height: 89px;">
								<p><span color="#f16622" style="color:#02b3e4; font-size: 30px;"><strong>Giới thiệu đối tác</strong></span></p>
								<p><span style="font-size: 20px;">Thưởng ngay khi giới thiệu bạn bè</span></p>
							</td>
						</tr>
					</tbody>
				</table>
			</span>
		</div>
	</div>
	<div class="col-md-6" style="background-color: transparent;">
		<form id="frmMain" class="form-wrapper hf-card" style="background-color: transparent;" name="form-validation" method="post" enctype="multipart/form-data" action="{{ route('signup_pro') }}">
			<h1 class="page-title text-left">Thông tin Đối Tác</h1>
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Họ tên</label>
								<input type="text" maxlength="225" class="form-control" name="name" data-validation="[NOTEMPTY]">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Ngày tháng năm sinh</label>
								<input type="text" maxlength="10" class="form-control datepicker-only-init d-sinh" name="dateOfBirth" data-validation="[NOTEMPTY]"/>
							</div>
						</div>
						<div class="col-md-2">
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
								<label>Số CMND</label>
								<input type="text" maxlength="12" class="form-control" name="govId">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Ngày cấp</label>
								<input type="text" maxlength="10" class="form-control datepicker-only-init" name="govDate">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Nơi cấp</label>
								<input type="text" maxlength="50" class="form-control" name="govPlace">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Hộ khẩu</label>
								<input type="text" maxlength="150" class="form-control" name="familyRegAddress" data-validation="[NOTEMPTY]">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Quận/Huyện</label>
								<select class="form-control selectpicker ddDist hf-select" data-live-search="true" name="familyRegDist" data-validation="[NOTEMPTY]">
									@foreach($districts as $dist)
									<option value="{{ $dist->code }}">{{ $dist->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-md-3">
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
						<div class="col-md-6">
							<div class="form-group">
								<label>Chỗ ở hiện nay</label>
								<input type="text" maxlength="150" class="form-control" name="address" data-validation="[NOTEMPTY]">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Quận/Huyện</label>
								<select class="form-control selectpicker ddDist hf-select" data-live-search="true" name="dist" data-validation="[NOTEMPTY]">
									@foreach($districts as $dist)
									<option value="{{ $dist->code }}">{{ $dist->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-md-3">
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
								<label>Mô hình kinh doanh</label>
								<select class="form-control selectpicker hf-select" data-live-search="true" name="company">
									<option value="" disable selected>&nbsp;</option>
									<optgroup label="Cá nhân">
										<option value="">Kinh doanh cá nhân</option>
									</optgroup>
									<optgroup label="Doanh nghiệp">
										@foreach($companies as $comp)
										<option value="{{ $comp->id }}">{{ $comp->name .' - '. $comp->address }}</option>
										@endforeach
									</optgroup>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Dịch vụ tham gia</label>
								<select class="form-control ddServices hf-select" multiple name="services[]">
									@foreach($services as $service)
									<option value="{{ $service->id }}">{{ $service->name }}</option>
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
	</div>
	<!-- MODAL -->
</section>
@endsection
