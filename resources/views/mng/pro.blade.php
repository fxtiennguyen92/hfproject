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
			<div class="row margin-top-20">
				<div class="col-sm-12 col-xs-12">
					<div class="form-group">
						<h5 style="color: #000; font-weight: bold">Định vị Tọa độ</h5>
						<input type="text" class="form-control" name="location" placeholder="Tọa độ" value="{{ $pro->profile->location }}" readonly>
						
						<input type="text" id="proAddress" class="form-control" name="address" placeholder="Nhập Địa chỉ để định vị">
					</div>
				</div>
				<div class="col-sm-12 col-xs-12">
					<div id="map" class="order-map"></div>
					<div id="infowindow-content">
						<span id="place-address"></span>
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
								<label class="btn @if (in_array($child->id, json_decode($pro->profile->services))) active @endif">
									<input type="checkbox"
										name="services[]"
										value="{{ $child->id }}" @if (in_array($child->id, json_decode($pro->profile->services))) checked @endif>
										@if (in_array($child->id, json_decode($pro->profile->services)))
										<span class="icon icmn-checkbox-checked2" service-name="{{ $child->name }}"></span> {{ $child->name }}
										@else
										<span class="icon icmn-checkbox-unchecked2" service-name="{{ $child->name }}"></span> {{ $child->name }}
										@endif
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
			<small><b>Dịch vụ đã chọn: </b><span class="header-info" id="chosenService">{{ $pro->profile->service_str }}</span></small>
		</div>
		
		<h5 class="padding-top-30">Hình thức kinh doanh</h5>
		<div class="padding-20 margin-bottom-30 hf-card">
			<div class="row">
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
		
		<h5 class="padding-top-30">Buổi training</h5>
		<div class="padding-20 margin-bottom-30 hf-card">
			<div class="row">
				<select class="form-control selectpicker hf-select" name="event">
					<option value="" selected>Chưa tham gia</option>
					@foreach ($events as $event)
					<option value="{{ $event->id }}" name="{{ $event->name }}" @if ($pro->profile->training == $event->id) selected @endif>
						{{ Carbon\Carbon::parse($event->date)->format('d/m/Y').' '.$event->from_time.' - '.$event->name.' - '.$event->address }}</option>
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
			<input type="hidden" name="service_str" value="" />
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		</div>
	</form>
</section>

<script>
function initMap(lat = null, lng = null) {
	var google_map_pos = null;
	if ($('input[name=location]').val()) {
		var location = $('input[name=location]').val().split(',');
		lat = location[0];
		lng = location[1];
	}
	
	if (lat && lng) {
		google_map_pos = new google.maps.LatLng(lat, lng);
	} else {
		google_map_pos = new google.maps.LatLng(10.762622, 106.660172);
	}

	var map = new google.maps.Map(document.getElementById('map'), {
		center: google_map_pos,
		zoom: 13,
		disableDefaultUI: true
	});

	var input = document.getElementById('proAddress');
	var autocomplete = new google.maps.places.Autocomplete(input);
	autocomplete.bindTo('bounds', map);
	autocomplete.setTypes(['address']);

	var infowindow = new google.maps.InfoWindow();
	var marker = new google.maps.Marker({
		map: map,
		position: google_map_pos,
		visible: false,
	});

	// init map
	if (lat && lng) {
		marker.setVisible(true);
		map.setZoom(17);
	} else {
		marker.setVisible(false);
		map.setZoom(13);
	}
	infowindow.open(map);

	var infowindowContent = document.getElementById('infowindow-content');
	autocomplete.addListener('place_changed', function() {
		infowindow.close();
		marker.setVisible(false);
		var place = autocomplete.getPlace();
		if (!place.geometry) {
			$.notify({
				message: 'Không lấy được địa điểm của bạn. Hãy thử lại!'
			}, {
				type: 'danger',
			});

			$('#proAddress').focus();
			return;
		}

		// If the place has a geometry, then present it on a map.
		if (place.geometry.viewport) {
			map.fitBounds(place.geometry.viewport);
		} else {
			map.setCenter(place.geometry.location);
			map.setZoom(17);
		}

		marker.setPosition(place.geometry.location);
		marker.setVisible(true);

		$('input[name=address]').val(formatAddress(place.formatted_address));
		$('input[name=location]').val(place.geometry.location.lat() + ',' + place.geometry.location.lng());

		infowindowContent.children['place-address'].textContent = place.name;
		infowindow.setContent(infowindowContent);
		infowindow.open(map, marker);
	});
}

function geolocation() {
	// geolocation
	if ($('input[name=location]').val() == '') {
		initMap('', '');
	} else {
		
	}
}


function formatAddress(address) {
	address = address.replace(', Việt Nam','');
	address = address.replace(', Vietnam', '');
	address = address.replace(', VietNam', '');

	return address;
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&callback=initMap&languages=vi&libraries=places" async defer ></script>
@endsection
