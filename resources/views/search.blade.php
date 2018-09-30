@extends('template.index')
@push('stylesheets')
<style>
	@media only screen and (max-width: 500px) {
		.top-menu {
			display: none;
		}
	}
</style>
<script>
	$(document).ready(function() {
		Ladda.bind( '.ladda-button');
		$('.select2').select2({
			language: {
				noResults: function() {
					return 'Không tìm thấy kết quả';
				}
			}
		});
		$('select[name=city]').on('select2:select', function (e) {
			var data = e.params.data;
			$('select[name="dist[]"]').val(null).trigger('change');
			$('select[name="dist[]"]').prop('disabled', true);
			$('select[name="dist[]"]').html('');
			
			var url = '{{ route("get_dist_by_city", ["code" => "cityCode"]) }}';
			url = url.replace('cityCode', data.id);
			$.ajax({
				url: url,
				success: function (data) {
					$.each(data, function(key, value) {
						var newOption = new Option(value.name, value.code, false, false);
						$('select[name="dist[]"]').append(newOption).trigger('change');
					});
					$('select[name="dist[]"]').prop('disabled', false);
				}
			});
		});
	});
</script>
@endpush
@section('title') Tìm kiếm @endsection
@section('content')
<section class="content-body content-width-700">
	<div class="search-page hf-card padding-20" style="min-height: 560px;">
		<div class="search-control hf-bg-gradient">
		<div class="search-title">Tìm kiếm Đối tác</div>
		<form id="frmSearch" method="GET" action="{{ route('search_page') }}">
		<div class="hf-card padding-20">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group form-input-icon">
						<i class="icmn-search"></i>
						<input type="text" class="form-control"
							name="name"
							placeholder="Tìm tên Cửa hàng hoặc Đối tác"
							value="{{ app('request')->input('name') }}">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Thành phố / Tỉnh</label>
						<select name="city" class="select2">
							@foreach ($cities as $city)
							<option value="{{ $city->code }}"
								@if (app('request')->input('city'))
									@if (app('request')->input('city') == $city->code) selected @endif
								@elseif ($city->init_flg == '1') selected
								@endif
							>{{ $city->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Quận / Huyện</label>
						<select name="dist[]" class="select2" multiple>
							@foreach ($districts as $dist)
							<option value="{{ $dist->code }}"
								@if (app('request')->input('dist')
									&& in_array($dist->code, app('request')->input('dist'))) selected
								@endif
							>{{ $dist->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label>Dịch vụ</label>
						<select name="service[]" class="select2" multiple>
							@foreach ($services as $service)
							<optgroup label="{{ $service->name }}">
								@foreach ($service->children as $child)
								<option value="{{ $child->name }}"
									@if (app('request')->input('service')
										&& in_array($child->name, app('request')->input('service'))) selected
									@endif
								>{{ $child->name }}</option>
								@endforeach
							</optgroup>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-md-3 text-center">
					<div class="form-group">
						<button class="btn btn-primary ladda-button" style="width: 100%; margin-top: 21px" data-style="expand-left">
							<span class="ladda-label">Tìm kiếm</span>
						</button>
					</div>
				</div>
			</div>
		</div>
		</form>
	</div>
		<div id="map" class="search-map"></div>
		@foreach ($result as $item)
		<div class="row search-item">
			<div class="col-sm-2 text-center">
				@if ($item['type'] == 'pro')
				<img class="search-image" src="{{ env('CDN_HOST') }}/u/{{ $item['id'] }}/{{ $item['image'] }}">
				@else
				<img class="search-image" src="{{ env('CDN_HOST') }}/img/comp/cover/{{ $item['image'] }}">
				@endif
			</div>
			<div class="col-sm-10">
				<div class="search-item-name">{{ $item['name'] }}</div>
				<div class="search-item-address color-secondary">
					{{ $item['address_1'].' '.$item['address_2'] }}
					@if ($item['district'])
					{{ ', '.$item['district_name'].', '.$item['city_name'] }}
					@endif
				</div>
				<div>
					@if ($item['type'] == 'pro')
						@php $proServices = explode(', ', $item['services']) @endphp
						@foreach ($proServices as $str)
						<span class="search-item-label label label-pill label-primary">{{ $str }}</span>
						@endforeach
					@else
						@foreach (json_decode($item['services'])->service_name as $str)
						<span class="search-item-label label label-pill label-primary">{{ $str }}</span>
						@endforeach
					@endif
				</div>
			</div>
		</div>
		@endforeach
	</div>
</section>

<script>
function initMap() {
	var google_map_pos = new google.maps.LatLng(10.762622, 106.660172);

	var map = new google.maps.Map(document.getElementById('map'), {
		center: google_map_pos,
		zoom: 13,
		disableDefaultUI: true
	});

	var infowindow = new google.maps.InfoWindow();
	var bounds = new google.maps.LatLngBounds();
	var shape = {
		coords: [1, 1, 1, 20, 18, 20, 18, 1],
		type: 'poly'
	};
	@foreach ($result as $item)
		@if ($item['location'])
			var infowincontent = document.createElement('div');
			var strong = document.createElement('strong');
			strong.textContent = "{{ $item['name'] }}";
			infowincontent.appendChild(strong);
			infowincontent.appendChild(document.createElement('br'));
			
			var text = document.createElement('div');
			text.textContent = "{{ $item['address_1'].' '.$item['address_2'] }}"
			infowincontent.appendChild(text);
			var point = new google.maps.LatLng(
					parseFloat("{{ explode(',', $item['location'])[0] }}"),
					parseFloat("{{ explode(',', $item['location'])[1] }}"));
			var image = {
					@if ($item['type'] == 'comp')
					url: 'https://cdn.handfree.co/img/marker/store30x30.png',
					@else
					url: 'https://cdn.handfree.co/img/marker/pro30x30.png',
					@endif
					size: new google.maps.Size(30, 30),
					origin: new google.maps.Point(0, 0),
					anchor: new google.maps.Point(0, 0)
				};
			var marker = new google.maps.Marker({
				map: map,
				icon: image,
				position: point,
				zIndex: 1,
			});
			marker.addListener('click', function() {
				infowindow.setContent(infowincontent);
				infowindow.open(map, marker);
			});
			
			bounds.extend(point);
			map.fitBounds(bounds);
			zoomChangeBoundsListener = 
				google.maps.event.addListenerOnce(map, 'bounds_changed', function(event) {
					if (this.getZoom() > 17) {
						this.setZoom(17);
					}
			});
		@endif
	@endforeach
	
	infowindow.open(map);
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&callback=initMap&languages=vi&libraries=places" async defer ></script>
@endsection
