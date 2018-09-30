@extends('template.index')
@push('stylesheets')

<!-- Page Scripts -->
<script>
	$(document).ready(function() {
		autosize($('textarea'));
		$('.dropify').dropify();
		$('.phone').mask('0000000000000');
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
		
		$('.service-row').show();
		$('.material-row').hide();
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
							message: 'Thông tin chưa đầy đủ.'
						}, {
							type: 'danger',
							z_index: 1051,
						});
					},
					onSubmit: function() {
						$('input[name=image]').val($('span.dropify-render').find('img').attr('src'));
						loadingBtnSubmit('btnSubmit');
						
						var url = '{{ route("pa_company_create") }}';
						$.ajax({
							type: 'POST',
							url: url,
							data: $('#frmMain').serialize(),
							success: function(response) {
								swal({
									title: 'Chúc mừng',
									text: 'Đăng ký thành công',
									type: 'success',
									confirmButtonClass: 'btn-primary',
									confirmButtonText: 'Kết thúc',
								},
								function() {
									location.href = '{{ route("pa_company_list") }}';
								});
							},
							error: function(xhr) {
								if (xhr.status == 400) {
									swal({
										title: 'Thất bại',
										text: 'Yêu cầu không thực hiện được!',
										type: 'error',
										confirmButtonClass: 'btn-default',
										confirmButtonText: 'Quay lại',
									});
								} else if (xhr.status == 409) {
									swal({
										title: 'Thất bại',
										text: 'Email không đúng hoặc đã được sử dụng!',
										type: 'error',
										confirmButtonClass: 'btn-default',
										confirmButtonText: 'Quay lại',
									});
								} else {
									swal({
										title: 'Thất bại',
										text: 'Có lỗi phát sinh, mời thử lại!',
										type: 'error',
										confirmButtonClass: 'btn-default',
										confirmButtonText: 'Quay lại',
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

@section('title') Doanh nghiệp @endsection

@section('content')
<section class="content-body content-template-1">
	<form id="frmMain" class="company-new-form form-wrapper" name="form-validation" method="post" enctype="multipart/form-data" action="">
		<h1 class="page-title text-left">Thông tin <span style="white-space: nowrap;">Doanh nghiệp<span></span></h1>
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Thành phố/Tỉnh</label>
							<select class="form-control selectpicker ddCity hf-select" data-live-search="true" name="city" data-validation="[NOTEMPTY]">
								@foreach($cities as $city)
									@if ($preAddress && $city->code == $preAddress['city'])
									<option value="{{ $city->code }}" selected>{{ $city->name }}</option>
									@else
									<option value="{{ $city->code }}" @if ($city->init_flg == '1') selected @endif>{{ $city->name }}</option>
									@endif
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Quận/Huyện</label>
							<select class="form-control selectpicker ddDist hf-select" data-live-search="true" name="district" data-validation="[NOTEMPTY]">
								@foreach($districts as $dist)
									@if ($preAddress && $dist->code == $preAddress['district'])
									<option value="{{ $dist->code }}" selected>{{ $dist->name }}</option>
									@else
									<option value="{{ $dist->code }}">{{ $dist->name }}</option>
									@endif
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Địa chỉ <span class="color-danger">*</span></label>
							<input type="text" maxlength="150"
								class="form-control" name="address_1"
								placeholder="Số nhà"
								value="@if ($preAddress) {{ $preAddress['address_1'] }} @endif"
								data-validation="[NOTEMPTY]">
						</div>
					</div>
					<div class="col-md-8">
						<div class="form-group">
							<label>&nbsp;</label>
							<input type="text" maxlength="150"
								class="form-control" name="address_2"
								placeholder="Tên đường"
								value="@if ($preAddress) {{ $preAddress['address_2'] }} @endif"
								data-validation="[NOTEMPTY]">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Tên Doanh nghiệp/Cửa hàng <span class="color-danger">*</span></label>
							<input type="text" maxlength="225" class="form-control" name="name" data-validation="[NOTEMPTY]">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Số điện thoại (Cố định)</label>
							<input type="text" maxlength="25" class="form-control phone" name="phone_1">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Số điện thoại (Di động)</label>
							<input type="text" maxlength="25" class="form-control phone" name="phone_2">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Email</label>
							<input type="text" maxlength="100" class="form-control" name="email">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Hình chụp cửa hàng</label>
							<input type="file" class="dropify"
								data-allowed-file-extensions="gif png jpg"
								data-max-file-size-preview="3M">
							<input type="hidden" name="image">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						<label>Loại cửa hàng</label>
						<div class="row" style="margin: 0px 5px;">
							<div data-toggle="buttons" class="col-md-6">
								<label class="btn active">
									<input id="tog-service"
										type="checkbox"
										name="style[]"
										value="0" checked>
										<span class="icon icmn-checkbox-checked2"></span> Dịch vụ
								</label>
							</div>
							<div data-toggle="buttons" class="col-md-6">
								<label class="btn">
									<input id="tog-material"
										type="checkbox"
										name="style[]"
										value="1">
										<span class="icon icmn-checkbox-unchecked2"></span> Bán vật tư
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="service-row row">
					<div class="form-group col-md-12">
						<label>Dịch vụ</label>
						<div class="row" style="margin: 0px 5px;">
							@foreach ($services as $service)
							<div data-toggle="buttons" class="col-md-6 col-sm-6 col-xs-6">
								<label class="btn">
									<input type="checkbox"
										name="service[]"
										value="{{ $service->id }}">
										<span class="icon icmn-checkbox-unchecked2"></span> {{ $service->name }}
								</label>
							</div>
							@endforeach
						</div>
						<div class="row" style="margin: 0px 5px;">
							<div class="col-md-12">
								<input type="text" class="form-control"
									placeholder="Dịch vụ khác"
									name="otherService">
							</div>
						</div>
					</div>
				</div>
				<div class="material-row row">
					<div class="form-group col-md-12">
						<label>Loại vật tư</label>
						<div class="row" style="margin: 0px 5px;">
							@foreach ($materials as $material)
							<div data-toggle="buttons" class="col-md-6 col-sm-6 col-xs-6">
								<label class="btn">
									<input type="checkbox"
										name="material[]"
										value="{{ $material->id }}">
										<span class="icon icmn-checkbox-unchecked2"></span> {{ $material->name }}
								</label>
							</div>
							@endforeach
						</div>
						<div class="row" style="margin: 0px 5px;">
							<div class="col-md-12">
								<input type="text" class="form-control"
									placeholder="Vật tư khác"
									name="otherMaterial">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Ghi chú</label>
							<textarea class="form-control" name="description" rows="3" maxlength="200"></textarea>
						</div>
					</div>
				</div>
				
				<div class="row margin-top-20 margin-bottom-20">
					<div class="col-sm-12 col-xs-12">
						<div class="form-group">
							<h5 style="color: #000;">Định vị Tọa độ</h5>
							<input type="text" class="form-control margin-bottom-10" name="location" placeholder="Tọa độ" value="" readonly>
							
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
		</div>
		<div class="row-complete clearfix">
			<button id="btnSubmit" type="submit" class="btn btn-primary" style="width: 100%">Đăng ký</button>
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		</div>
	</form>
	<!-- MODAL -->
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
