@extends('template.index')
@push('stylesheets')
<link rel="stylesheet" type="text/css" href="css/home.css">
<style>
</style>
<script>
$(document).ready(function() {
	$('.carousel').carousel({
		interval: 5000,
	});
	$('#roots').owlCarousel({
		center: false,
		loop: false,
		nav: false,
		margin: 10,
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
	$('#newest-blogs').owlCarousel({
		center: false,
		loop: false,
		nav: false,
		margin: 10,
		items: 4,
		autoWidth: true,
	});

	@if(Session::has('hint-service'))
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

(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.12';
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

</script>
@endpush
@section('title') Ứng dụng đặt dịch vụ @endsection
@section('content')
<nav class="top-menu-mb">
	<a href="{{ route('home_page') }}"><img src="{{ env('CDN_HOST') }}/img/logo/logoh.png" class="navbar-logo"></a>
</nav>
<section class="home-page has-bottom-menu">
	<div id="banner" class="home-carousel carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			@foreach ($banners as $key=>$li)
			<li data-target="banner" data-slide-to="{{ $key }}" @if ($key == 0) class="active" @endif></li>
			@endforeach
		</ol>
		<div class="carousel-inner" role="listbox">
			@foreach ($banners as $key=>$b)
			<div class="carousel-item @if ($key == 0) active @endif">
				<img src="{{ env('CDN_HOST') }}/img/banner/home/{{ $b->name }}">
			</div>
			@endforeach
		</div>
		<a class="left carousel-control" data-target="#banner" role="button" data-slide="prev">
			<span class="icon-prev fa fa-arrow-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" data-target="#banner" role="button" data-slide="next">
			<span class="icon-next fa fa-arrow-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
	<div id="banner-mb" class="home-carousel carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			@foreach ($mbbanners as $key=>$mbli)
			<li data-target="banner-mb" data-slide-to="{{ $key }}" @if ($key == 0) class="active" @endif></li>
			@endforeach
		</ol>
		<div class="carousel-inner" role="listbox">
			@foreach ($mbbanners as $key=>$mbb)
			<div class="carousel-item @if ($key == 0) active @endif">
				<img src="{{ env('CDN_HOST') }}/img/banner/home-mb/{{ $mbb->name }}">
			</div>
			@endforeach
		</div>
		<a class="left carousel-control" data-target="#banner-mb" role="button" data-slide="prev">
			<span class="icon-prev fa fa-arrow-left" aria-hidden="true"></span>
		</a>
		<a class="right carousel-control" data-target="#banner-mb" role="button" data-slide="next">
			<span class="icon-next fa fa-arrow-right" aria-hidden="true"></span>
		</a>
	</div>
	
	<div class="margin-top-30 services">
		<h3>Nhóm Dịch vụ</h3>
		<div id="roots" class="owl-carousel owl-theme">
			@foreach ($roots as $key=>$root)
			@if ($key%2 == 0)
			<div class="item">
			@endif
				<div>
					<button type="button" class="btn-service shadow btn btn-default"
						onclick="location.href='{{ route('service_view', ['urlName' => $root->url_name]) }}'"
						style="{{ $root->css }}">{{ $root->name }}</button>
				</div>
			@if ($key%2 == 1 || $key == (sizeof($roots) - 1))
			</div>
			@endif
			@endforeach
		</div>
	</div>
	
	<div class="margin-top-30 services">
		<div class="margin-bottom-20 row">
			<div class="col-md-3 col-sm-2"></div>
			<div class="col-md-6 col-sm-8">
				<form name="frmSearchService" method="get" action="{{ route('service_search') }}">
					<div class="input-group">
						<div class="typeahead__container">
							<div class="typeahead__field">
								<span class="typeahead__query">
									<input id="searchService"
											class="form-control"
											maxlength="100"
											name="hint"
											type="text"
											placeholder="Bạn cần làm gì?"
											autocomplete="off"
											style="border: solid 1px #e1e1e1; padding-left: 5px; padding-right: 5px;"/>
								</span>
							</div>
						</div>
						<span class="input-group-btn">
							<button type="submit" class="btn btn-primary" style="border-width: 3px">
								Tìm dịch vụ
							</button>
						</span>
					</div>
				</form>
			</div>
		</div>
		
		@if (sizeof($services) > 0)
		<h3>Đặt nhiều nhất</h3>
		<div id="most-popular-services" class="owl-carousel owl-theme">
			@foreach ($services as $service)
			<div class="item service-obj" onclick="location.href='{{ route('service_view', ['urlName' => $service->url_name]) }}'">
				<div>
					<img class="service-img" src="{{ env('CDN_HOST') }}/img/service/{{ $service->image }}">
				</div>
				<div class="padding-top-10">
					<span class="service-name">{{ $service->name }}</span>
				</div>
			</div>
			@endforeach
		</div>
		@endif
	</div>
	
	<div class="margin-top-30 margin-bottom-30 blogs">
		<h3>Tin tức mới nhất</h3>
		<div id="newest-blogs" class="owl-carousel owl-theme">
			@foreach ($blogs as $blog)
			<div class="item blog-obj" onclick="location.href='{{ route('blog_page', ['urlName' => $blog->url_name]) }}'">
				<div><img class="blog-img" src="{{ env('CDN_HOST') }}/img/blog/{{ $blog->image }}"></div>
				<div class="text-left padding-top-10">
					<span class="margin-right-10 text-uppercase label label-danger" style="font-size: 13px;">{{ $blog->category }}</span>
					<span class="color-primary blog-date">{{ Carbon\Carbon::parse($blog->created_at)->format('d/m/Y H:i') }}</span>
				</div>
				<div class="text-left blog-title" title="{{ $blog->title }}">
					<a href="{{ route('blog_page', ['urlName' => $blog->url_name]) }}" style="color: #000;">{{ $blog->title }}</a>
				</div>
			</div>
			@endforeach
		</div>
		<div class="margin-top-20 text-center">
			<button type="button" class="text-center btn btn-primary width-150" onclick="location.href='{{ route('blog_page') }}'">Xem thêm</button>
		</div>
	</div>

<!-- 	@foreach ($parts as $part) -->
<!-- 	{/!! $part->text !!} -->
<!-- 	@endforeach -->

	<footer class="hf-footer">
		<div class="row padding-bottom-10">
			<img src="{{ env('CDN_HOST') }}/img/logo/logoh.png" width="180px">
		</div>
		<div class="row margin-top-10">
			<div class="col-md-3 col-xs-12">
				<ul class="info">
					<li>157/1A Đường Nguyễn Gia Trí (D2), Bình Thạnh, Tp.HCM</li>
					<li><i class="icmn-envelop3"></i> info@handfree.co</li>
					<li><a href="javascript:void(0);" onclick="window.open('https://m.me/handfreeco', '_blank');">
						<i class="icmn-bubble-notification"></i> handfreeco</a></li>
					<li><i class="icmn-phone-wave"></i>035 2221 050</li>
					
				</ul>
			</div>
			<div class="col-md-3 col-xs-12 text-right">
				<ul class="link">
					<li><a href="{{ route('pro_new') }}">Trở thành Đối tác</a></li>
					<li><a href="{{ route('blog_page') }}">Blog</a></li>
				</ul>
			</div>
			<div class="col-md-6 col-xs-12 text-right">
				<div class="fb-page"
					data-href="https://www.facebook.com/handfree.co"
					data-tabs="timeline" data-width="300px"
					data-height="100px" data-small-header="false"
					data-adapt-container-width="true"
					data-hide-cover="false"
					data-show-facepile="true">
					<blockquote cite="https://www.facebook.com/handfree.co" class="fb-xfbml-parse-ignore">
						<a href="https://www.facebook.com/handfree.co">Hand Free - Đặt Dịch Vụ An Toàn Dễ Dàng</a>
					</blockquote>
				</div>
				<div id="fb-root"></div>
			</div>
		</div>
	</footer>
	
	<div class="copyright">
		<div class="row">
			<div class="col-md-8 text-left">
				<p><b>© 2018 Bản quyền của Công ty Cổ phần Hand Free</b></p>
				<p>Giấy phép kinh doanh số 0315000331 do Sở Kế hoạch và Đầu tư Thành phố Hồ Chí Minh cấp ngày 19/04/2018</p>
			</div>
			<div class="col-md-4 text-center">
				<div class="col-xs-4">
				</div>
				<div class="margin-top-10 col-xs-4" style="border-right: 1px solid #000">
					<div class="doc-link"><a href="https://handfree.co/doc/privacy" target="_blank">Chính sách bảo mật</a></div>
				</div>
				<div class="margin-top-10 col-xs-4">
					<div class="doc-link"><a href="https://handfree.co/doc/term-of-use" target="_blank">Điều khoản sử dụng</a></div>
				</div>
			</div>
		</div>
	</div>
	
</section>
@endsection
@include('template.mb.footer-menu')
