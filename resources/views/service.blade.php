@extends('template.index')
@push('stylesheets')
<script>
$(document).ready(function() {
	$('#roots').owlCarousel({
		center: false,
		loop: false,
		nav: false,
		items: 6,
		autoWidth: true,
	});
	$('#most-popular-services').owlCarousel({
		center: false,
		loop: false,
		nav: false,
		margin: 10,
		items: 5,
		autoWidth: true,
	});
	@if (Session::has('hint-service'))
	var hints = [ @foreach (Session::get('hint-service') as $h) '{{ $h->hint }}', @endforeach ];
	$.typeahead({
		input: "#searchService",
		order: "asc",
		minLength: 2,
		maxItem: 5,
		source: {
			data: hints
		},
		cancelButton: false,
		accent: true,
		callback: {
			onClickAfter (node, a, item, event) {
				node.closest('form').submit()
			},
			onSubmit (node, form, item, event) {
				if ($.trim($('#searchService').val()) !== '') {
					return true;
				}
				return false;
			}
		}
	});
	@endif
});
</script>
@endpush

@section('title') Dịch vụ @endsection
@section('content')
<section class="service-section has-bottom-menu">
	@if (!isset($serviceRoot))
	<div class="service-banner" style="background-image: url('{{ env('CDN_HOST') }}/img/service/home.png')">
	@else
	<div class="service-banner" style="background-image: url('{{ env('CDN_HOST') }}/img/service/{{ $serviceRoot->image }}')">
	@endif
		<div class="service-banner-content">
			<h2 class="root-name text-uppercase text-center">@if (!isset($serviceRoot)) Tìm kiếm Dịch vụ @else {{ $serviceRoot->name }} @endif</h2>
			<div class="row">
				<div class="col-md-3 col-sm-2 col-xs-1"></div>
				<div class="col-md-6 col-sm-8 col-xs-10">
					<form name="frmSearchService" method="get" action="{{ route('service_search') }}">
						<div class="typeahead__container">
							<div class="typeahead__field">
								<span class="typeahead__query">
									<input id="searchService"
											class="input-search form-control"
											maxlength="100"
											name="hint"
											type="text"
											value="{{ app('request')->input('hint') }}"
											placeholder="Bạn cần làm gì?"
											autocomplete="off"
											style="border: solid 1px #e1e1e1; padding: 8px 5px; width: 100%; border-radius: 5px;"/>
								</span>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="service-banner-opacity"></div>
	</div>
	
	@if (sizeof($services) == 0)
		<div class="search-result">
			Không tìm thấy dịch vụ cho từ khóa: <span class="search-input">'{{ app('request')->input('hint') }}'</span>
		</div>
	@else
		@if (!isset($serviceRoot))
		<div class="margin-30">
			<h3>Dịch vụ phù hợp ({{ sizeof($services) }})</h3>
		@else
		<div class="margin-30">
			<h3>{{ $serviceRoot->name }} ({{ sizeof($services) }})</h3>
		@endif
			<div class="search-service row">
				@foreach ($services as $service)
				<div class="col-md-3 col-sm-4 col-xs-6">
					<div class="service-img" style="background-image: url('{{ env('CDN_HOST') }}/img/service/{{ $service->image }}')"></div>
					<div class="text-center padding-top-10 padding-bottom-20">
						<span class="service-name">{{ $service->name }}</span>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	@endif
	
	<div class="margin-30">
		<h3>Tất cả</h3>
		<div id="roots" class="owl-carousel owl-theme">
			@foreach ($roots as $key=>$root)
			<div class="item" onclick="location.href='{{ route('service_view', ['urlName' => $root->url_name]) }}'">
				<div style="margin: 10px 0px 10px 10px; padding-right: 10px; border-right: 1px solid #e1e1e1">
					<img class="service-img" style="width: 120px;" src="{{ env('CDN_HOST') }}/img/service/{{ $root->image }}">
				</div>
				<div class="text-center"><span class="service-name">{{ $root->name }}</span></div>
			</div>
			@endforeach
		</div>
	</div>
	
	@if (sizeof($popularServices) > 0)
	<div class="margin-30">
		<h3>Đặt nhiều nhất</h3>
		<div id="most-popular-services" class="service-carousel owl-carousel owl-theme">
			@foreach ($popularServices as $popService)
			<div class="item">
				<div>
					<img class="service-img" src="{{ env('CDN_HOST') }}/img/service/{{ $popService->image }}">
				</div>
				<div class="padding-top-10">
					<span class="service-name">{{ $popService->name }}</span>
				</div>
			</div>
			@endforeach
		</div>
	</div>
	@endif
</section>
@endsection
@include('template.mb.footer-menu')