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
		@if (session('error') && session('error') == 400)
			swal({
				title: 'Thất bại',
				text: 'Thông tin không hợp lệ, kiểm tra lại',
				type: 'error',
				confirmButtonClass: 'btn-danger',
				confirmButtonText: 'Kiểm tra lại',
			});
		@elseif (session('error'))
			swal({
				title: 'Thất bại',
				text: '{{ session("error") }}',
				type: 'error',
				confirmButtonClass: 'btn-default',
				confirmButtonText: 'Quay lại',
			});
		@endif

		
		$('.dropify').dropify();
		$('#inpDateOfBirth').datetimepicker({
			format: 'DD/MM/YYYY',
			date: moment("@if (session('error')) {{ old('dateOfBirth') }} @else {{ Carbon\Carbon::parse($pro->profile->date_of_birth)->format('d/m/Y') }} @endif", 'DD/MM/YYYY'),
			maxDate: moment().subtract(10, 'year'),
			minDate: moment().subtract(100, 'year'),
			locale: moment.locale('vi'),
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
		$('#inpGovDate').datetimepicker({
			format: 'DD/MM/YYYY',
			date: moment("@if (session('error')) {{ old('govDate') }} @else {{ json_decode($pro->profile->gov_id)->date }} @endif", 'DD/MM/YYYY'),
			maxDate: moment(),
			minDate: moment().subtract(100, 'year'),
			locale: moment.locale('vi'),
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
		});

		$('input[name=email]').on('change', function() {
			if ($(this).val() !== '') {
				$(this).addValidation('EMAIL');
			} else {
				$(this).removeValidation('EMAIL');
			}
		});

		$('#btnUpdate').on('click', function() {
			$('input[name=govEvidence]').val($('#imgGovEvidence').parent().find('div.dropify-preview').find('span.dropify-render').find('img').attr('src'));
			$('input[name=avatar]').val($('#imgAvatar').parent().find('div.dropify-preview').find('span.dropify-render').find('img').attr('src'));
			
			loadingBtnSubmit('btnUpdate');
			$('#btnSubmit').prop('disabled', true);
			
			$('#frmMain').attr('action',"{{ route('mng_pro_update', ['id' => $pro->id]) }}");
			$('#frmMain').submit();
		});

		$('#btnSubmit').on('click', function() {
			$('input[name=govEvidence]').val($('#imgGovEvidence').parent().find('div.dropify-preview').find('span.dropify-render').find('img').attr('src'));
			$('input[name=avatar]').val($('#imgAvatar').parent().find('div.dropify-preview').find('span.dropify-render').find('img').attr('src'));
			
			loadingBtnSubmit('btnSubmit');
			$('#btnUpdate').prop('disabled', true);
			
			$('#frmMain').attr('action',"{{ route('mng_pro_active', ['id' => $pro->id]) }}");
			$('#frmMain').submit();
		});

		$('#frmMain').validate({
			submit: {
				settings: {
					inputContainer: '.form-group',
					errorListClass: 'form-control-error',
					errorClass: 'has-danger',
					scrollToError: true,
				}
			}
		});
	});
</script>
@endpush

@section('title') Đối tác @endsection

@section('content')
<section class="content-body content-template-1">
	<div class="page-header hf-bg-gradient text-capitalize"
		style="line-height: 150px; background-image: url('{{ env('CDN_HOST') }}/img/banner/pro_new.png ')">Thông tin đối tác</div>
	<form id="frmMain" class="pro-new-form form-wrapper" name="form-validation" method="post" enctype="multipart/form-data"
		action="{{ route('mng_pro_active', ['id' => $pro->id]) }}">
		<h5>Ảnh đại diện</h5>
		<div>
			<input id="imgAvatar" type="file" class="dropify"
				data-allowed-file-extensions="gif png jpg"
				data-max-file-size-preview="3M"
				@if ($pro->avatar)
				data-default-file="{{ env('CDN_HOST') }}/u/{{ $pro->id }}/{{ $pro->avatar }}"
				@endif
				/>
		</div>
		
		<h5 class="padding-top-30">Cơ bản</h5>
		<div class="padding-20 hf-card">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<div class="form-group">
						<label>Họ tên <span class="color-danger">*</span></label>
						<input type="text" maxlength="225" class="form-control" name="name" data-validation="[NOTEMPTY]"
							@if (session('error'))
							value="{{ old('name') }}">
							@else
							value="{{ $pro->name }}">
							@endif
					</div>
				</div>
				<div class="col-sm-6 col-xs-6">
					<div class="form-group">
						<label>Ngày tháng năm sinh <span class="color-danger">*</span></label>
						<input id="inpDateOfBirth" type="text" maxlength="10" class="form-control datepicker-only-init" style="padding-top: 11px;"
							name="dateOfBirth" data-validation="[NOTEMPTY]"
							@if (session('error'))
							value="{{ old('dateOfBirth') }}">
							@else
							value="{{ Carbon\Carbon::parse($pro->profile->date_of_birth)->format('d/m/Y') }}">
							@endif
					</div>
				</div>
				<div class="col-sm-6 col-xs-6">
					<div class="form-group">
						<label>Giới tính</label>
						<select class="form-control selectpicker hf-select" name="gender">
							@php $gender = (session('gender')) ? old('gender') : $pro->profile->gender; @endphp
							<option value="1" @if ($gender == '1') selected @endif>Nam</option>
							<option value="2" @if ($gender == '2') selected @endif>Nữ</option>
							<option value="0" @if ($gender == '0') selected @endif>Khác</option>
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
						<input type="text" maxlength="25" class="form-control phone" name="phone" data-validation="[NOTEMPTY]"
							@if (session('error'))
							value="{{ old('phone') }}">
							@else
							value="{{ $pro->phone }}">
							@endif
					</div>
				</div>
				<div class="col-sm-6 col-xs-6">
					<div class="form-group">
						<label>Email</label>
						<input type="text" maxlength="100" class="form-control" name="email"
							@if (session('error'))
							value="{{ old('email') }}">
							@else
							value="{{ $pro->email }}">
							@endif
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
										@php $selectedCity = (session('error')) ? old('city') : $pro->profile->city; @endphp
										@foreach($cities as $city)
										<option value="{{ $city->code }}" @if ($selectedCity == $city->code) selected @endif>{{ $city->name }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-sm-6 col-xs-6">
								<div class="form-group">
									<select class="form-control selectpicker ddDist hf-select" data-live-search="true"  name="dist">
										@php $selectedDistrict = (session('error')) ? old('dist') : $pro->profile->district; @endphp
										@foreach($districts as $dist)
										<option value="{{ $dist->code }}" @if ($selectedDistrict == $dist->code) selected @endif>{{ $dist->name }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-sm-6 col-xs-6">
								<input type="text" maxlength="150" class="form-control" name="address_1" placeholder="Số nhà"
									@if (session('error'))
									value="{{ old('address_1') }}">
									@else
									value="{{ $pro->profile->address_1 }}">
									@endif
							</div>
							<div class="col-sm-6 col-xs-6">
								<input type="text" maxlength="150" class="form-control" name="address_2" placeholder="Tên đường" data-validation="[NOTEMPTY]"
									@if (session('error'))
									value="{{ old('address_2') }}">
									@else
									value="{{ $pro->profile->address_2 }}">
									@endif
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
						<input type="text" maxlength="12" class="form-control" name="govId"
							@if (session('error'))
							value="{{ old('govId') }}">
							@else
							value="{{ json_decode($pro->profile->gov_id)->id }}">
							@endif
					</div>
				</div>
				<div class="col-sm-6 col-xs-6">
					<div class="form-group">
						<label>Ngày cấp</label>
						<input id="inpGovDate" type="text" maxlength="10" class="form-control datepicker-only-init" name="govDate"
							@if (session('error'))
							value="@if (old('govDate')) {{ old('govDate') }} @endif">
							@else
							value="{{ json_decode($pro->profile->gov_id)->date }}">
							@endif
					</div>
				</div>
				<div class="col-sm-6 col-xs-6">
					<div class="form-group">
						<label>Nơi cấp</label>
						<input type="text" maxlength="50" class="form-control" name="govPlace"
							@if (session('error'))
							value="@if (old('govPlace')) {{ old('govPlace') }} @endif">
							@else
							value="{{ json_decode($pro->profile->gov_id)->place }}">
							@endif
					</div>
				</div>
				<div class="col-sm-12 col-xs-12">
					<div class="form-group">
						<label>Hộ khẩu</label>
						<div class="row">
							<div class="col-sm-6 col-xs-6">
								<div class="form-group">
									<select class="form-control selectpicker ddCity hf-select" data-live-search="true" name="familyRegCity">
										@php $selectedFgCity = (session('error')) ? old('familyRegCity') : $pro->profile->fg_city; @endphp
										@foreach($cities as $city)
										<option value="{{ $city->code }}" @if ($selectedFgCity == $city->code) selected @endif>{{ $city->name }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-sm-6 col-xs-6">
								<div class="form-group">
									<input type="text" maxlength="50" class="form-control" placeholder="Quận/Huyện" name="familyRegDist" style="padding-bottom: 12px;"
										@if (session('error'))
										value="{{ old('familyRegDist') }}">
										@else
										value="{{ $pro->profile->fg_district }}">
										@endif
								</div>
							</div>
							<div class="col-sm-12 col-xs-12">
								<input type="text" maxlength="150" class="form-control" name="familyRegAddress" placeholder="Địa chỉ"
									@if (session('error'))
									value="{{ old('familyRegAddress') }}">
									@else
									value="{{ $pro->profile->fg_address }}">
									@endif
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-xs-12">
					<div class="form-group">
						<label>Hình chụp CMND</label>
						<input id="imgGovEvidence" type="file" class="dropify"
							data-allowed-file-extensions="gif png jpg"
							data-max-file-size-preview="3M"
							@if ($pro->profile->gov_evidence)
							data-default-file="{{ env('CDN_HOST') }}/u/{{ $pro->id }}/{{ $pro->profile->gov_evidence }}"
							@endif
							/>
					</div>
				</div>
			</div>
		</div>
		<h5 class="padding-top-30">Dịch vụ tham gia</h5>
		<div class="padding-20 hf-card">
			<div class="row">
				<div class="form-group col-sm-12 col-xs-12" style="margin-bottom: 0px;">
					<label>Dịch vụ</label>
				</div>
				@foreach ($services as $service)
				<div data-toggle="buttons" class="padding-left-20 col-sm-6 col-xs-6">
					@if (in_array($service->id, json_decode($pro->profile->services)))
					<label class="btn active">
						<input type="checkbox"
							name="services[]"
							value="{{ $service->id }}" checked>
							<span class="icon icmn-checkbox-checked2"></span> {{ $service->name }}
					</label>
					@else
					<label class="btn">
						<input type="checkbox"
							name="services[]"
							value="{{ $service->id }}">
							<span class="icon icmn-checkbox-unchecked2"></span> {{ $service->name }}
					</label>
					@endif
				</div>
				@endforeach
			</div>
			<div class="row">
				<div class="form-group col-sm-12 col-xs-12">
					<label>Hình thức kinh doanh</label>
					<select class="form-control selectpicker hf-select" data-live-search="true" name="company">
						<optgroup label="Cá nhân">
							<option value="">Kinh doanh Cá nhân</option>
						</optgroup>
						<optgroup label="Doanh nghiệp">
							@foreach($companies as $company)
							<option value="{{ $company->id }}" @if ($pro->profile->company_id == $company->id) selected @endif>{{ $company->name }}</option>
							@endforeach
						</optgroup>
					</select>
				</div>
			</div>
		</div>
		<h5 class="padding-top-30">Buổi training</h5>
		<div class="padding-20 margin-bottom-30 hf-card">
			<div class="row">
				<select class="form-control selectpicker hf-select" name="event">
					<option value="" selected>Chưa tham gia</option>
					@foreach ($events as $event)
					<option value="{{ $event->id }}" name="{{ $event->name }}" @if ($pro->profile->training == $event->id) selected @endif>
						{{ Carbon\Carbon::parse($event->date)->format('d/m/Y').' '.$event->from_time.' - '.$event->name.' - '.$event->place }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="row-complete clearfix">
			@if ($pro->profile->state == '0')
			<button id="btnUpdate" type="button" class="btn btn-warning-outline" style="width: 50%">Cập nhật</button> 
			<button id="btnSubmit" type="button" class="btn btn-primary" style="width: 50%">Kích hoạt</button>
			@else
			<button id="btnSubmit" type="button" class="btn btn-warning" style="width: 100%">Cập nhật</button>
			@endif
			
			<input type="hidden" name="govEvidence" value=""/>
			<input type="hidden" name="avatar" value=""/>
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		</div>
	</form>
	<!-- MODAL -->
</section>
@endsection
