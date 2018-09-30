@extends('template.index') @push('stylesheets')
<style>
</style>
<!-- Page Scripts -->
<script>
	$(document).ready(function() {
		@if (sizeof($questions) == 0)
			$('.content-body').hide();
			
			swal({
				title: 'Dịch vụ tạm dừng hoạt động',
				text: 'Xin hãy quay lại sau!',
				type: 'warning',
				showCancelButton: false,
				confirmButtonClass: 'btn-warning',
				confirmButtonText: 'Quay lại',
			},
			function() {
				location.href = '{{ route("home_page") }}';
			});
		@endif
		
		$('body').addClass('survey-page');
		$('#frmMain').on('keyup keypress', function(e) {
			var keyCode = e.keyCode || e.which;
			if (keyCode === 13) { 
				e.preventDefault();
				return false;
			}
		});
		$('#surveyList').steps({
			headerTag: 'h3',
			bodyTag: 'section',
			transitionEffect: 'slideLeft',
			autoFocus: true,
			enableAllSteps: true,
			labels: {
				finish: "<i class='material-icons'>&#xE315;</i>",
				next: "<i class='material-icons'>&#xE315;</i>",
				previous: "<i class='material-icons'>&#xE314;</i>",
			},
			onStepChanging: function(e, currentIndex, newIndex) {
				if (currentIndex < newIndex) {
					return validateStep(currentIndex);
				}
				return true;
			},
			onFinishing: function(e, currentIndex) {
				return validateStep(currentIndex);
			},
			onFinished: function(e, currentIndex) {
				$('#positionAndTime').show();
				$('.service-title').hide();
				$('#surveyList').hide();
				geolocation();
			}
		});

		function validateStep(currentIndex) {
			var validate = true;
				var section = $('section[id=surveyList-p-' + currentIndex + ']');
				var name = section.find('input:not([type=text],[type=button],[type=submit])').first().attr('name');
				if (typeof name == 'undefined') {
					validReturn = true;
				} else if ($('input[name="' + name + '"]:checked').length == 0) {
					$.notify({
						message: 'Hãy chọn một nội dung bên dưới.'
					}, {
						type: 'danger',
					});

					validate = false;
				} else {
					section.find('label[class*=active]').each(function() {
						var otherInput = $(this).find('.input-other');
						if (typeof otherInput !== 'undefined' && otherInput.val() == '') {
							$.notify({
								message: 'Vui lòng cung cấp thông tin.'
							}, {
								type: 'danger',
							});
							otherInput.focus();
							validate = false;
						};
					});
				}

				return validate;
		}
		
		$('label').on('click', function() {
			// control show/hide next answers
			var questionId = $(this).attr('question-id');
			var ansGroup = $(this).attr('ans-group');
			$('label[prev-ans-group^='+questionId+']').each(function() {
				$(this).removeClass('active');
				$(this).find('input').prop('checked', false);
				var subSpan = $(this).find('span');
				if (subSpan.hasClass('icmn-checkmark-circle')) {
					subSpan.addClass('icmn-radio-unchecked').removeClass('icmn-checkmark-circle');
				} else if (subSpan.hasClass('icmn-checkbox-checked2')) {
					subSpan.addClass('icmn-checkbox-unchecked2').removeClass('icmn-checkbox-checked2');
				}
				
				if ($(this).attr('prev-ans-group') != ansGroup) {
					$(this).hide();
				} else {
					$(this).show();
				}
			})

			// change icon
			var span = $(this).find('span');
			if (span.hasClass('icmn-radio-unchecked')) {
				$(this).parent().find('span').each(function() {
					$(this).addClass('icmn-radio-unchecked').removeClass('icmn-checkmark-circle');
				});
				span.addClass('icmn-checkmark-circle').removeClass('icmn-radio-unchecked');

			} else if (span.hasClass('icmn-checkbox-unchecked2')) {
				span.addClass('icmn-checkbox-checked2').removeClass('icmn-checkbox-unchecked2');
			} else if (span.hasClass('icmn-checkbox-checked2')) {
				span.addClass('icmn-checkbox-unchecked2').removeClass('icmn-checkbox-checked2');
			}
		});
		$('.label-other').on('click', function() {
			if (!$(this).hasClass('active')) {
				$(this).find('.input-other').focus();
			}
		});
		$('a[href=#finish]').on('click', function() {
			
		});
		$('#btnBack').on('click', function() {
			$('#positionAndTime').hide();
			$('.service-title').show();
			$('#surveyList').show();
		});
		$('#orderAddress').on('blur', function() {
			$(this).val($('input[name=address]').val());
		});

		$('.datetimepicker').datetimepicker({
			minDate: moment(),
			locale: moment.locale('vi'),
			format: 'dddd, DD/MM/YYYY HH:ss',
			showClose: true,
			widgetPositioning: {
				horizontal: 'auto',
				vertical: 'top'
			},
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

		$('.time-rad').on('click', function() {
			if ($(this).find('input').val() == 1) {
				$('#excuteDatetime').show();
			} else {
				$('#excuteDatetime').hide();
			}
		});

		$('#btnDisCode').on('click', function() {
			$('#modalDisCode').modal('show');
		});

		$('#btnSubmit').on('click', function() {
			if ($('input[name=location]').val() == '') {
				$.notify({
					title: '<strong>Không thể tiếp tục! </strong>',
					message: 'Chưa xác định được địa điểm.'
				}, {
					type: 'danger',
					z_index: 1051,
				});
				$('#orderAddress').focus();
			} else {
				$.ajax({
					type: 'POST',
					url: '{{ route("submit_order") }}',
					data: $('#frmMain').serialize(),
					success: function(orderId) {
						swal({
							title: 'Thành công',
							text: 'Bạn đã đặt đơn hàng thành công!',
							type: 'success',
							showCancelButton: false,
							confirmButtonClass: 'btn-primary',
							confirmButtonText: 'Xem đơn hàng',
						},
						function() {
							var url = '{{ route("order_page", ["orderId" => "orderId"]) }}';
							url = url.replace('orderId', orderId);
							location.href = url;
						});
					},
					error: function(xhr) {
						if (xhr.status == 400) {
							$.notify({
								title: '<strong>Thất bại! </strong>',
								message: 'Đã có lỗi xảy ra, mời chọn lại dịch vụ.'
							}, {
								type: 'danger',
								z_index: 1051,
							});
						} else if (xhr.status == 403) {
							$.notify({
								title: '<strong>Thất bại! </strong>',
								message: 'Thời gian thực hiện không đúng, mời chọn lại.'
							}, {
								type: 'danger',
								z_index: 1051,
							});
						} else {
							$.notify({
								title: '<strong>Thất bại! </strong>',
								message: 'Không thể thực hiện đặt đơn hàng.'
							}, {
								type: 'danger',
								z_index: 1051,
							});
						};
					}
				});
			}
		});
	});

	function setDisCode(code) {
		$('input[name=disCode]').val(code);
		$('#btnDisCode').addClass('active');
		$('#btnDisCode').html('<i class="icmn-ticket2" aria-hidden="true"></i>' + code);
		$('#modalDisCode').modal('hide');
	}
</script>
@endpush @section('title') Đơn hàng @endsection @section('content')
<section class="content-body">
	<form id="frmMain" class="survey-form" method="get">
	
		<div class="survey-banner hf-bg-gradient" style="background-image: url('{{ env('CDN_HOST') }}/img/service/{{ $service->image }}')">
			<div class="survey-banner-content text-center" style="color: #fff; font-size: 22px;">{{ $service->name }}</div>
			<div class="survey-banner-opacity"></div>
<!-- 			<span class="title"><img class="service-icon" src="{/{ env('CDN_HOST') }}/img/service/{{ $service->image }}" /> {{ $service->name }}</span> -->
		</div>
		<div id="surveyList" class="cui-wizard cui-wizard__numbers">
			@foreach ($questions as $qKey => $q)
			<h3><span class="cui-wizard--steps--title"></span></h3>
			<section>
				<div class="question">
					{{ $q->content }}
				</div>
				<div class="answer">
					@if ($q->answer_type == '0')
					<div>
						<textarea style="margin:0;padding:10px;" class="form-control" name="q[{{ $q->id }}]" rows="6" maxlength="100"></textarea>
					</div>
					@elseif ($q->answer_type == '1')
					<div data-toggle="buttons">
						@foreach ($q->answers as $a) @if ($a->other_flg == 1)
						<label class="label-other btn" question-id="q{{ $q->id }}" ans-group="q{{ $q->id }}-a{{ $a->order_dsp }}" @if ($a->previous_answer != 0) prev-ans-group="q{{ $questions[$qKey-1]->id }}-a{{ $a->previous_answer }}" @endif>
							<input type="checkbox"
									name="q[{{ $q->id }}][]"
									value="{{ $a->order_dsp }}">
							<span class="icon icmn-checkbox-unchecked2"></span>
							
							<input class="input-other" type="text"
									placeholder="{{ $a->content }}"
									name="{{ $q->id.'_'.$a->order_dsp }}_text"
									value="">
						</label> @else
						<label class="btn" question-id="q{{ $q->id }}" ans-group="q{{ $q->id }}-a{{ $a->order_dsp }}" @if ($a->previous_answer != 0) prev-ans-group="q{{ $questions[$qKey-1]->id }}-a{{ $a->previous_answer }}" @endif>
							<input type="checkbox"
									name="q[{{ $q->id }}][]"
									value="{{ $a->order_dsp }}">
							<span class="icon icmn-checkbox-unchecked2"></span>
								{{ $a->content }}
						</label> @endif @endforeach
					</div>
					@elseif ($q->answer_type == '2')
					<div class="btn-group" data-toggle="buttons">
						@foreach ($q->answers as $a) @if ($a->other_flg == 1)
						<label class="btn" question-id="q{{ $q->id }}" ans-group="q{{ $q->id }}-a{{ $a->order_dsp }}" @if ($a->previous_answer != 0) prev-ans-group="q{{ $questions[$qKey-1]->id }}-a{{ $a->previous_answer }}" @endif>
							<input type="radio"
									name="q[{{ $q->id }}]"
									value="{{ $a->order_dsp }}">
							<span class="icon icmn-radio-unchecked"></span>
							
							<input class="input-other" type="text"
									placeholder="{{ $a->content }}"
									name="{{ $q->id.'_'.$a->order_dsp }}_text"
									value="">
						</label> @else
						<label class="btn" question-id="q{{ $q->id }}" ans-group="q{{ $q->id }}-a{{ $a->order_dsp }}" @if ($a->previous_answer != 0) prev-ans-group="q{{ $questions[$qKey-1]->id }}-a{{ $a->previous_answer }}" @endif>
							<input type="radio"
									name="q[{{ $q->id }}]"
									value="{{ $a->order_dsp }}">
							<span class="icon icmn-radio-unchecked"></span>
								{{ $a->content }}
						</label> @endif @endforeach
					</div>
					@endif
				</div>
			</section>
			@endforeach
		</div>

		<div id="positionAndTime" style="display: none">
			<div class="content clearfix">
				<div class="address hf-bg-gradient text-uppercase">
					Địa điểm và Thời gian
				</div>
				<div id="map" class="order-map"></div>
				<div id="infowindow-content">
					<span id="place-address"></span>
				</div>
				<div class="address-wrapper">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<input type="text" id="orderAddress" class="form-control" placeholder="Địa chỉ của bạn. VD: 4/2 Đinh Bộ Lĩnh, Bình Thạnh, Hồ Chí Minh">
						</div>
					</div>
				</div>
				<div class="time">
					Vào lúc
				</div>
				<div class="btn-group time-wrapper" data-toggle="buttons">
					<label class="btn time-rad">
									<input type="radio" name="timeState" value="0" checked>
									<span class="icon icmn-checkmark-circle"></span>
											Sớm nhất có thể
							</label>
					<label class="btn time-rad">
									<input type="radio" name="timeState" value="1">
									<span class="icon icmn-radio-unchecked"></span>
											Chọn thời gian
							</label>
				</div>
				<div id="excuteDatetime" class="row excute-date-wrapper" style="display: none">
							<div class="col-md-8 col-sm-8 col-xs-8" style="padding-left: 0; padding-right: 0">
								<select class="form-control selectpicker hf-select hf-select-date" data-live-search="false" name="estDate">
								@foreach($dates as $date)
								<option value="{{ $date }}">{{ $date }}</option>
								@endforeach
							</select>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4" style="padding-right: 0">
								<select class="form-control selectpicker hf-select hf-select-time" data-live-search="false" name="estTime">
								@foreach($times as $time)
								<option value="{{ $time }}">{{ $time }}</option>
								@endforeach
							</select>
							</div>
				</div>
			</div>
			<div class="row-complete clearfix">
				<button id="btnBack" type="button" class="btn"><i class="material-icons">&#xE314;</i></button>
				<button id="btnDisCode" type="button" class="btn" style="width: 30%"><i class="icmn-ticket2" aria-hidden="true"></i> Mã khuyến mãi</button>
				<button id="btnSubmit" type="button" class="btn btn-primary" style="padding: 16px; width: 40%"><i class="material-icons">&#xE876;</i></button>
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				<input type="hidden" name="address" value="" />
				<input type="hidden" name="location" value="" />
				<input type="hidden" name="disCode" value="" />
			</div>
		</div>
	</form>
	
	@include('order.discount-code')
</section>

<script>
function initMap(lat = null, lng = null) {
	var google_map_pos = null;
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

	var input = document.getElementById('orderAddress');
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

			$('#orderAddress').focus();
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
		navigator.geolocation.getCurrentPosition(
			function(position) {
				var lat = position.coords.latitude;
				var lng = position.coords.longitude;
				var google_map_pos = new google.maps.LatLng(lat, lng);
				/* Use Geocoder to get address */
				var google_maps_geocoder = new google.maps.Geocoder();
				google_maps_geocoder.geocode(
					{'latLng': google_map_pos },
					function(results, status) {
						if (status == google.maps.GeocoderStatus.OK && results[0]) {
							$('#orderAddress').val(formatAddress(results[0].formatted_address));
							
							$('input[name=address]').val(formatAddress(results[0].formatted_address));
							$('input[name=location]').val(lat + ',' + lng);
						}
					}
				);

				initMap(lat, lng);
			},
			function() {
			}
		);
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
