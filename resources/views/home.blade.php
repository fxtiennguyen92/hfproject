@extends('template.index') @push('stylesheets')
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

	var hints = [ @foreach ($hints as $h) '{{ $h->hint }}', @endforeach ];
	$.typeahead({
		input: "#searchService",
		order: "asc",
		minLength: 1,
		maxItem: 0,
		source: {
			data: hints
		},
		cancelButton: false,
		accent: true,
	});
	$.typeahead({
		input: "#searchServiceNav",
		order: "asc",
		minLength: 1,
		maxItem: 0,
		source: {
			data: hints
		},
		cancelButton: false,
		accent: true,
		callback: {
			onClick (node, a, item, event) {
				// submit form
			},
			onSubmit (node, form, item, event) {
				// submit form
			}
		}
	});
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
			<li data-target="banner" data-slide-to="0" class="active"></li>
			<li data-target="banner" data-slide-to="1"></li>
			<li data-target="banner" data-slide-to="2"></li>
		</ol>
		<div class="carousel-inner" role="listbox">
			<div class="carousel-item active">
				<img src="{{ env('CDN_HOST') }}/img/banner/home/banner-home-001.png">
	<!-- 				<div class="carousel-caption"> -->
	<!-- 					<p>Title</p> -->
	<!-- 				</div> -->
			</div>
			<div class="carousel-item">
				<img src="{{ env('CDN_HOST') }}/img/banner/home/banner-home-002.png">
			</div>
			<div class="carousel-item">
				<img src="{{ env('CDN_HOST') }}/img/banner/home/banner-home-003.png">
			</div>
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
			<li data-target="banner-mb" data-slide-to="1" class="active"></li>
			<li data-target="banner-mb" data-slide-to="2"></li>
		</ol>
		<div class="carousel-inner" role="listbox">
			<div class="carousel-item active">
				<img src="{{ env('CDN_HOST') }}/img/banner/home-mb/banner-mb-001.png">
	<!-- 				<div class="carousel-caption"> -->
	<!-- 					<p>Title</p> -->
	<!-- 				</div> -->
			</div>
			<div class="carousel-item">
				<img src="{{ env('CDN_HOST') }}/img/banner/home-mb/banner-mb-002.png">
			</div>
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
			<div class="item center">
			@endif
				<div>
					<button type="button" class="btn-service shadow btn btn-default"
						onclick="location.href='{{ route('service_page', ['serviceUrlName' => $root->url_name]) }}'"
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
				<div class="form-group">
					<div class="typeahead__container">
						<div class="typeahead__field">
							<div class="typeahead__query">
								<div class="input-group">
									<input id="searchService"
											class="input-search form-control"
											maxlength="100"
											name=""
											type="text"
											placeholder="Bạn cần làm gì?"
											autocomplete="off"
											style="border: solid 1px #e1e1e1; padding-left: 5px; padding-right: 5px;"/>
									<span class="input-group-btn">
										<a href="javascript: void(0);" style="border: solid 3px #01a8fe" class="btn btn-primary">Tìm Dịch vụ</a>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		@if (sizeof($services) > 0)
		<h3>Đặt nhiều nhất</h3>
		<div id="most-popular-services" class="owl-carousel owl-theme">
			@foreach ($services as $service)
			<div class="item center">
				<div>
					<img class="service-img" src="{{ env('CDN_HOST') }}/img/service/{{ $service->image }}">
				</div>
				<div>
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
			<div class="item" style="text-align: left;">
				<div class="text-left color-primary blog-date">{{ Carbon\Carbon::parse($blog->created_at)->format('d/m/Y H:i') }}</div>
				<div class="text-left blog-title" title="{{ $blog->title }}">{{ $blog->title }}</div>
				<div class="padding-top-10"><img class="blog-img" src="{{ env('CDN_HOST') }}/img/blog/{{ $blog->image }}"></div>
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
			<div class="col-md-4 col-xs-12">
				<ul class="info">
					<li>99/1B Võ Văn Tần, Phường 6, Quận 3, Tp.HCM</li>
					<li><i class="icmn-envelop3"></i> info@handfree.co</li>
					<li><a href="javascript:void(0);" onclick="window.open('https://m.me/handfreeco', '_blank');">
						<i class="icmn-bubble-notification"></i> handfreeco</a></li>
					<li><i class="icmn-phone-wave"></i> 024 7304 1114</li>
					
				</ul>
			</div>
			<div class="col-md-2 col-xs-6">
				<ul class="link">
					<li><a href="javascript:void(0);">Thông tin</a></li>
					<li><a href="javascript:void(0);">Tuyển dụng</a></li>
					<li><a href="{{ route('blog_page') }}">Blog</a>
					</li>
				</ul>
			</div>
			<div class="col-md-3 col-xs-6">
				<ul class="link">
					<li><a href="javascript:void(0);">Hỗ trợ Khách hàng</a></li>
					<li><a href="{{ route('pro_new') }}">Trở thành Đối tác</a></li>
				</ul>
			</div>
			<div class="col-md-3 text-right">
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
