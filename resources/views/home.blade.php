@extends('template.index') @push('stylesheets')
<link rel="stylesheet" type="text/css" href="css/home.css">
<style>
</style>
<script>
$(document).ready(function() {
	$('.carousel').carousel({
		interval: 5000
	});
	$('#most-popular-services').owlCarousel({
		center: true,
		loop: true,
		nav: false,
		margin: 10,
		responsive: {
			0: {
				items:1
			},
			400: {
				items:2
			},
			700: {
				items:4
			},
			1000: {
				items:5
			}
		}
	});
	$('#newest-blogs').owlCarousel({
		center: true,
		loop: true,
		nav: false,
		margin: 20,
		responsive: {
			0: {
				items:1
			},
			650: {
				items:2
			},
			1000: {
				items:3
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
<section class="home-page has-bottom-menu">
	<div id="banner" class="home-carousel carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			<li data-target="banner" data-slide-to="1" class="active"></li>
			<li data-target="banner" data-slide-to="2"></li>
			<li data-target="banner" data-slide-to="3"></li>
		</ol>
		<div class="carousel-inner" role="listbox">
			<div class="carousel-item active">
				<img src="{{ env('CDN_HOST') }}/img/banner/home/1.png">
	<!-- 				<div class="carousel-caption"> -->
	<!-- 					<p>Title</p> -->
	<!-- 				</div> -->
			</div>
			<div class="carousel-item">
				<img src="{{ env('CDN_HOST') }}/img/banner/home/2.png">
			</div>
			<div class="carousel-item">
				<img src="{{ env('CDN_HOST') }}/img/banner/home/2.png">
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
	
	<div class="margin-top-30 services">
		<h3>Nhóm Dịch vụ</h3>
		<div class="row">
			@foreach ($services as $key=>$service)
			<div class="center col-lg-2 col-md-3 col-sm-4 col-xs-6">
				<button type="button" class="btn-service shadow btn btn-default text-uppercase"
					onclick="location.href='{{ route('service_page', ['serviceUrlName' => $service->url_name]) }}'"
					style="">{{ $service->name }}</button>
			</div>
			@endforeach
		</div>
	</div>
	
	<div class="margin-top-30 services">
		<div class="margin-bottom-20 form-group" style="width: 300px;">
			<div class="typeahead__container">
				<div class="typeahead__field">
					<div class="typeahead__query">
						<div class="input-group">
							<input id="searchService"
									class="form-control"
									name=""
									type="text"
									placeholder=""
									autocomplete="off"
									style="border: solid 1px #e1e1e1"/>
							<span class="input-group-btn">
								<a href="javascript: void(0);" class="btn btn-primary">Tìm Dịch vụ</a>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<h3>Đặt nhiều nhất</h3>
		<div id="most-popular-services" class="owl-carousel owl-theme">
			@foreach ($services as $service)
			<div class="item center">
				<div>
					<img class="service-img" src="{{ env('CDN_HOST') }}/img/service/{{ $service->id }}.svg">
				</div>
				<div>
					<span class="service-name">{{ $service->name }}</span>
				</div>
			</div>
			@endforeach
		</div>
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

	@foreach ($parts as $part)
	{!! $part->text !!}
	@endforeach

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
			<div class="col-md-6 text-left">
				<p><b>© 2018 Bản quyền của Công ty Cổ phần Hand Free</b></p>
				<p>Giấy phép kinh doanh số 0315000331 do Sở Kế hoạch và Đầu tư Thành phố Hồ Chí Minh cấp ngày 19/04/2018</p>
			</div>
		</div>
	</div>
	
	<script>
    $(function() {

        var countries = [
            "Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda",
            "Argentina", "Armenia", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh",
            "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia",
            "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", "Burkina Faso", "Burma",
            "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Central African Republic", "Chad",
            "Chile", "China", "Colombia", "Comoros", "Congo, Democratic Republic", "Congo, Republic of the",
            "Costa Rica", "Cote d'Ivoire", "Croatia", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti",
            "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador",
            "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Fiji", "Finland", "France", "Gabon",
            "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Greenland", "Grenada", "Guatemala", "Guinea",
            "Guinea-Bissau", "Guyana", "Haiti", "Honduras", "Hong Kong", "Hungary", "Iceland", "India",
            "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan",
            "Kazakhstan", "Kenya", "Kiribati", "Korea, North", "Korea, South", "Kuwait", "Kyrgyzstan", "Laos",
            "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg",
            "Macedonia", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands",
            "Mauritania", "Mauritius", "Mexico", "Micronesia", "Moldova", "Mongolia", "Morocco", "Monaco",
            "Mozambique", "Namibia", "Nauru", "Nepal", "Netherlands", "New Zealand", "Nicaragua", "Niger",
            "Nigeria", "Norway", "Oman", "Pakistan", "Panama", "Papua New Guinea", "Paraguay", "Peru",
            "Philippines", "Poland", "Portugal", "Qatar", "Romania", "Russia", "Rwanda", "Samoa", "San Marino",
            "Sao Tome", "Saudi Arabia", "Senegal", "Serbia and Montenegro", "Seychelles", "Sierra Leone",
            "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "Spain",
            "Sri Lanka", "Sudan", "Suriname", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan",
            "Tajikistan", "Tanzania", "Thailand", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey",
            "Turkmenistan", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States",
            "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe"
        ];

        $.typeahead({
            input: "#searchService",
            order: "asc",
            minLength: 1,
            source: {
                data: countries
            },
            cancelButton: false
        });

    });
</script>
</section>
@endsection
@include('template.mb.footer-menu')
