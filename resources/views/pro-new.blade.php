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

		$('div[data-toggle="buttons"]').on('change', function() {
			var style = $(this).find('input').attr('id');
			$(this).find('span').each(function() {
				if ($(this).hasClass('icmn-checkbox-checked2')) {
					$(this).removeClass('icmn-checkbox-checked2').addClass('icmn-checkbox-unchecked2');
					if (style == 'tog-service') {
						$('.service-row').hide();
					} else if (style == 'tog-material') {
						$('.material-row').hide();
					}
				} else {
					$(this).removeClass('icmn-checkbox-unchecked2').addClass('icmn-checkbox-checked2');
					if (style == 'tog-service') {
						$('.service-row').show();
					} else if (style == 'tog-material') {
						$('.material-row').show();
					}
				}
			});

			$('#chosenService').html('...');
			var chosenServices = '';
			$('.icmn-checkbox-checked2').each(function() {
				chosenServices = chosenServices + $(this).attr('service-name') + ', ';
			});
			$('#chosenService').html(chosenServices.substring(0, chosenServices.length - 2));
			$('input[name=service_str]').val($('#chosenService').html());
		});

		$('input[name=email]').on('change', function() {
			if ($(this).val() !== '') {
				$(this).addValidation('EMAIL');
			} else {
				$(this).removeValidation('EMAIL');
			}
		});

		$('.event-info-row').hide();
		$('#eventSelect').on('change', function() {
			var option = $(this).find(':selected');
			if (option.val() == '') {
				$('#eventName').val('');
				$('#eventTime').val('');
				$('#eventDate').val('');
				$('#eventPlace').val('');
				
				$('.event-info-row').hide();
			} else {
				$('#eventName').val(option.attr('name'));
				$('#eventTime').val(option.attr('time'));
				$('#eventDate').val(option.attr('date'));
				$('#eventPlace').val(option.attr('place'));
				
				$('.event-info-row').show();
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
						loadingBtnSubmit('btnSubmit');
						$.ajax({
							type: 'POST',
							url: '{{ route("pro_create") }}',
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
								resetBtnSubmit('btnSubmit', 'Đăng ký');
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
	<div class="page-header hf-bg-gradient text-capitalize"
		style="line-height: 150px; background-image: url('{{ env('CDN_HOST') }}/img/banner/pro_new.png ')">Trở thành đối tác</div>
	<form id="frmMain" class="pro-new-form form-wrapper" name="form-validation" method="post" enctype="multipart/form-data" action="">
		<h5>Cơ bản</h5>
		<div class="padding-20 hf-card">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<div class="form-group">
						<label>Họ tên <span class="color-danger">*</span></label>
						<input type="text" maxlength="225" class="form-control" name="name" data-validation="[NOTEMPTY]">
					</div>
				</div>
				<div class="col-sm-6 col-xs-6">
					<div class="form-group">
						<label>Ngày tháng năm sinh <span class="color-danger">*</span></label>
						<input type="text" maxlength="10" class="form-control datepicker-only-init" style="padding-top: 11px;"
							name="dateOfBirth" data-validation="[NOTEMPTY]"/>
					</div>
				</div>
				<div class="col-sm-6 col-xs-6">
					<div class="form-group">
						<label>Giới tính</label>
						<select class="form-control selectpicker hf-select" name="gender">
							<option value="1" selected>Nam</option>
							<option value="2">Nữ</option>
							<option value="0">Khác</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		
		<h5 class="padding-top-30">Liên lạc</h5>
		<div class="padding-20 hf-card">
			<div class="row">
				<div class="col-sm-6 col-xs-6">
					<div class="form-group">
						<label>Di động <span class="color-danger">*</span></label>
						<input type="text" maxlength="25" class="form-control phone" name="phone" data-validation="[NOTEMPTY]">
					</div>
				</div>
				<div class="col-sm-6 col-xs-6">
					<div class="form-group">
						<label>Email</label>
						<input type="text" maxlength="100" class="form-control" name="email">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<div class="form-group">
						<label>Chỗ ở hiện nay <span class="color-danger">*</span></label>
						<div class="row">
							<div class="col-sm-6 col-xs-6">
								<div class="form-group">
									<select class="form-control selectpicker ddCity hf-select" data-live-search="true" name="city" data-validation="[NOTEMPTY]">
										@foreach($cities as $city)
										<option value="{{ $city->code }}" @if ($city->init_flg == '1') selected @endif>{{ $city->name }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-sm-6 col-xs-6">
								<div class="form-group">
									<select class="form-control selectpicker ddDist hf-select" data-live-search="true"	name="dist">
										@foreach($districts as $dist)
										<option value="{{ $dist->code }}">{{ $dist->name }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-sm-6 col-xs-6">
								<input type="text" maxlength="150" class="form-control" name="address_1" placeholder="Số nhà">
							</div>
							<div class="col-sm-6 col-xs-6">
								<input type="text" maxlength="150" class="form-control" name="address_2" placeholder="Tên đường" data-validation="[NOTEMPTY]">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<h5 class="padding-top-30">CMND & Hộ khẩu</h5>
		<div class="padding-20 hf-card">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<div class="form-group">
						<label>Số CMND</label>
						<input type="text" maxlength="12" class="form-control" name="govId">
					</div>
				</div>
				<div class="col-sm-6 col-xs-6">
					<div class="form-group">
						<label>Ngày cấp</label>
						<input type="text" maxlength="10" class="form-control datepicker-only-init" name="govDate">
					</div>
				</div>
				<div class="col-sm-6 col-xs-6">
					<div class="form-group">
						<label>Nơi cấp</label>
						<input type="text" maxlength="50" class="form-control" name="govPlace">
					</div>
				</div>
				<div class="col-sm-12 col-xs-12">
					<div class="form-group">
						<label>Hộ khẩu</label>
						<div class="row">
							<div class="col-sm-6 col-xs-6">
								<div class="form-group">
									<select class="form-control selectpicker ddCity hf-select" data-live-search="true" name="familyRegCity">
										@foreach($cities as $city)
										<option value="{{ $city->code }}" @if ($city->init_flg == '1') selected @endif>{{ $city->name }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-sm-6 col-xs-6">
								<div class="form-group">
									<input type="text" maxlength="50" class="form-control" placeholder="Quận/Huyện" name="familyRegDist" style="padding-bottom: 12px;">
								</div>
							</div>
							<div class="col-sm-12 col-xs-12">
								<input type="text" maxlength="150" class="form-control" name="familyRegAddress" placeholder="Địa chỉ">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<h5 class="padding-top-30">Dịch vụ tham gia</h5>
		<div class="padding-bottom-10"><span class="header-info">HandFree sẽ kiểm tra kinh nghiệm và bằng cấp chuyên môn của bạn vào buổi training</span></div>
		<div class="hf-card">
			<div class="panel-group accordion" id="accordion" role="tablist" aria-multiselectable="true">
				@foreach ($services as $service)
				<div class="panel panel-default">
					<div class="panel-heading collapsed" role="tab" id="heading{{ $service->id }}" data-toggle="collapse" data-parent="#accordion" data-target="#collapse{{ $service->id }}" aria-expanded="true" aria-controls="collapse{{ $service->id }}">
						<div class="panel-title">
							<span class="accordion-indicator pull-right">
								<i class="plus fa fa-plus"></i>
								<i class="minus fa fa-minus"></i>
							</span>
							<a>{{ $service->name }}</a>
						</div>
					</div>
					<div id="collapse{{ $service->id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{ $service->id }}">
						<div class="panel-body padding-left-10 row">
							@foreach ($service->children as $child)
							<div data-toggle="buttons" class="col-md-6 col-sm-6 col-xs-12">
								<label class="btn">
									<input type="checkbox"
										name="services[]"
										value="{{ $child->id }}">
										<span class="icon icmn-checkbox-unchecked2" service-name="{{ $child->name }}"></span> {{ $child->name }}
								</label>
							</div>
							@endforeach
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
		<div class="padding-top-10">
			<small><b>Dịch vụ đã chọn: </b><span class="header-info" id="chosenService">...</span></small>
		</div>
		<h5 class="padding-top-30">Buổi training</h5>
		<div class="padding-20 margin-bottom-30 hf-card">
			<div class="row">
				<select id="eventSelect" class="form-control selectpicker hf-select" name="event">
					<option value="" selected>Chưa tham gia</option>
					@foreach ($events as $event)
					<option value="{{ $event->id }}" name="{{ $event->name }}" time="{{ $event->from_time }}" date="{{ Carbon\Carbon::parse($event->date)->format('d/m/Y') }}" place="{{ $event->address }}">
						{{ Carbon\Carbon::parse($event->date)->format('d/m/Y').' '.$event->from_time.' - '.$event->name.' - '.$event->address }}</option>
					@endforeach
				</select>
			</div>
			<div class="event-info-row padding-top-10 row">
				<div class="col-sm-12 col-xs-12">
					<div class="form-group">
						<label>Tên sự kiện</label>
						<input id="eventName" type="text" class="form-control" disabled>
					</div>
				</div>
				<div class="col-sm-6 col-xs-6">
					<div class="form-group">
						<label>Thời gian</label>
						<input id="eventTime" type="text" class="form-control" disabled>
					</div>
				</div>
				<div class="col-sm-6 col-xs-6">
					<div class="form-group">
						<label>Ngày</label>
						<input id="eventDate" type="text" class="form-control" disabled>
					</div>
				</div>
				<div class="col-sm-12 col-xs-12">
					<div class="form-group">
						<label>Địa điểm</label>
						<input id="eventPlace" type="text" class="form-control" disabled>
					</div>
				</div>
			</div>
		</div>
		<div class="row-complete clearfix">
			<button id="btnSubmit" type="submit" class="btn btn-primary" style="width: 100%">Đăng ký</button>
			<input type="hidden" name="service_str" value="" />
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		</div>
	</form>
	<!-- MODAL -->
</section>
@endsection
