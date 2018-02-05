@extends('template.index')

@push('stylesheets')
	<link rel="stylesheet" type="text/css" href="css/home.css">
@endpush

@section('title')

@endsection

@section('content')
	<!-- SECTION BANNER -->
	<section id="section_banner">
		<div class="container">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">			
				<div class="row">
					<div class="col-md-8">
						<div class="shadow home_banner_left">
							
						</div>
				  	</div>
				  	<div class="col-md-4">
					  	<div class="row">
					  		<div class="col-xs-12 col-sm-6 col-md-12">
					  			<div class="shadow home_banner_right">
					  				
					  			</div>
					  		</div>
					  		<div class="col-xs-12 col-sm-6 col-md-12">
					  			<div class="shadow home_banner_right">
					  				
					  			</div>
					  		</div>	  		
					  	</div>
				  	</div>
				</div>
			</div>
		</div>
		</div>
	</section>

	<!-- SECTION SERVICES -->
	<section id="section_services">
		<div class="container">
			<center>
				<p class="services_title">Chọn Dịch Vụ</p>
			</center>
		</div>
		<div class="container center">
			<div class="col-xs-6 col-sm-4 col-lg-2 center">
				<a href="/sua-dien">
					<div class="shadow btn-services">
						<img class="btn-services-img" src="img/services/group/1.png">
						<p class="btn-services-text">SỬA ĐIỆN</p>
					</div>
				</a>
			</div>
			<div class="col-xs-6 col-sm-4 col-lg-2">
				<a href="/sua-dien">
					<div class="shadow btn-services">
						<img class="btn-services-img" src="img/services/group/2.png">
						<p class="btn-services-text">SỬA NƯỚC</p>
					</div>
				</a>
			</div>
			<div class="col-xs-6 col-sm-4 col-lg-2">
				<a href="/sua-dien">
					<div class="shadow btn-services">
						<img class="btn-services-img" src="img/services/group/3.png">
						<p class="btn-services-text">ĐIỆN LẠNH</p>
					</div>
				</a>
			</div>
			<div class="col-xs-6 col-sm-4 col-lg-2">
				<a href="/sua-dien">
					<div class="shadow btn-services">
						<img class="btn-services-img" src="img/services/group/4.png">
						<p class="btn-services-text">KHÓA - CỬA</p>
					</div>
				</a>
			</div>		
			<div class="col-xs-6 col-sm-4 col-lg-2">
				<a href="/sua-dien">
					<div class="shadow btn-services">
						<img class="btn-services-img" src="img/services/group/5.png">
						<p class="btn-services-text">CHỤP ẢNH</p>
					</div>
				</a>
			</div>
			<div class="col-xs-6 col-sm-4 col-lg-2">
				<a href="/sua-dien">
					<div class="shadow btn-services">
						<img class="btn-services-img" src="img/services/group/6.png">
						<p class="btn-services-text">SỰ KIỆN</p>
					</div>
				</a>
			</div>	
		</div>		
	</section>

	<!-- SECTION GUARANTEE -->
	<section id="section_value">
		<div class="container">			
			<div class="col-sm-6">
				<img src="img/home_value.png" class="home_value_img" width="100%">
			</div>
			<div class="col-sm-6">
				<div class="home_value_text">
					<h5 class="home_value_title">DỊCH VỤ TRONG VÀI PHÚT</h5>
					<p class="home_value_content">Đặt. Báo Giá. Đến Nhà.</p>
				</div>
				<div class="home_value_text">
					<h5 class="home_value_title">AN TOÀN TUYỆT ĐỐI</h5>
					<p class="home_value_content">Từ thông tin pháp lý của chuyên gia cho đến đội Xử Lý Tình Huống 24/7. Chúng tôi luôn bên cạnh bạn.</p>
				</div>
				<div class="home_value_text">
					<h5 class="home_value_title">KHÁCH HÀI LÒNG. ĐỐI TÁC HÀI LÒNG.</h5>
					<p class="home_value_content">Bạn sẽ hiểu vì sao 9 trên 10 khách hàng đánh giá đội ngũ của chúng tôi 5 sao.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- SECTION STEPS -->
	<section id="section_steps">
		<div class="container">
			<center>
				<p class="home_step_content">Đặt dịch vụ từ mọi nơi cùng Hand</p>
			</center>
			<div class="row step_horizontal visible-xs">
				<div class="col-xs-3 step_horizontal_div">
					<center>
					<p class="home_step_number home_step_number_1 active">1</p>
					</center>
				</div>
				<div class="col-xs-3 step_horizontal_div">
					<center>
					<p class="home_step_number home_step_number_2">2</p>
					</center>
				</div>
				<div class="col-xs-3 step_horizontal_div">
					<center>
					<p class="home_step_number home_step_number_3">3</p>
					</center>
				</div>
				<div class="col-xs-3 step_horizontal_div">
					<center>
					<p class="home_step_number home_step_number_4">4</p>
					</center>
				</div>
				<div class="step_horizontal_div step_horizontal_content_1">
					<p class="home_step_row_title">Đặt dịch vụ với 2 bước</p>
					<p class="home_step_row_content">Chọn dịch vụ. Trả lời câu hỏi</p>
				</div>

				<div class="step_horizontal_div step_horizontal_content_2" style="display: none">
					<p class="home_step_row_title">2</p>
					<p class="home_step_row_content">Chọn dịch vụ. Trả lời câu hỏi</p>
				</div>

				<div class="step_horizontal_div step_horizontal_content_3" style="display: none">
					<p class="home_step_row_title">3</p>
					<p class="home_step_row_content">Chọn dịch vụ. Trả lời câu hỏi</p>
				</div>

				<div class="step_horizontal_div step_horizontal_content_4" style="display: none">
					<p class="home_step_row_title">4</p>
					<p class="home_step_row_content">Chọn dịch vụ. Trả lời câu hỏi</p>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-2 col-sm-1">
					<center>
					<button href="" class="btn-link home_step_prev"><i class="material-icons">keyboard_arrow_left</i></button>
					</center>
				</div>
				<div class="col-xs-8 col-sm-4">
					<img src="img/mockup1.png" class="home_step_img" width="100%">
				</div>				
				<div class="col-xs-2 col-sm-1">
					<center>
					<button href="" class="btn-link home_step_next"><i class="material-icons">keyboard_arrow_right</i></button>
					</center>
				</div>
				<div class="col-sm-6 hidden-xs">
					<div class="row home_step_right home_step_number_1">
						<div class="col-xs-2">
							<p class="home_step_number">1</p>							
						</div>
						<div class="col-xs-10">
							<p class="home_step_row_title">Đặt dịch vụ với 2 bước</p>
							<p class="home_step_row_content">Chọn dịch vụ. Trả lời câu hỏi</p>
						</div>
					</div>
					<div class="row home_step_right home_step_number_2">					
						<div class="col-xs-2">
							<p class="home_step_number">2</p>							
						</div>
						<div class="col-xs-10">
							<p class="home_step_row_title">Đặt dịch vụ với 2 bước</p>
							<p class="home_step_row_content">Chọn dịch vụ. Trả lời câu hỏi</p>
						</div>
					</div>
					<div class="row home_step_right home_step_number_3">
						<div class="col-xs-2">
							<p class="home_step_number">3</p>
						</div>
						<div class="col-xs-10">
							<p class="home_step_row_title">Đặt dịch vụ với 2 bước</p>
							<p class="home_step_row_content">Chọn dịch vụ. Trả lời câu hỏi</p>
						</div>
					</div>
					<div class="row home_step_right home_step_number_4">
						<div class="col-xs-2">
							<p class="home_step_number">4</p>							
						</div>
						<div class="col-xs-10">
							<p class="home_step_row_title">Đặt dịch vụ với 2 bước</p>
							<p class="home_step_row_content">Chọn dịch vụ. Trả lời câu hỏi</p>
						</div>
					</div>
				</div>
			</div>		
		</div>
		
	</section>

	<!-- SECTION TESTINOMIAL -->
	<section id="section_testinomial">
		<div class="container">
			<div>
				<center>
					<p>Khách Hàng đã đặt hàng ngàn dịch vụ trên HandFree hoàn toàn an toàn và dễ dàng</p>
				</center>
			</div>
			<div class="col-xs-2">
				<a href="#"><i class="material-icons">keyboard_arrow_left</i></a>
			</div>
			<div class="col-xs-8">
				<center>
					<p class="testinomial_content">"I love the content and teaching approach, and wouldn't be where I am now without Udacity."</p>
					<p class="testinomial_name">- SAM, PROFESSIONAL</p>
					<div class="testinomial_avatar">
						<img src="" >						
					</div>
				</center>
			</div>			
			<div class="col-xs-2">
				<a href="#"><i class="material-icons">keyboard_arrow_right</i></a>
			</div>
		</div>
	</section>

	<!-- SECTION BECOME A PRO -->
	<section id="section_become_pro">
		
	</section>

	<!-- FOOTER -->
	<footer>
		<div class="footer_main container">
			<div class="row">
				<div class="col-sm-5 col-md-3">
					<div class="footer_title_div">
						<img src="img/logoh.png" width="180">
						<span class="footer_title_arrow visible-xs"><i class="material-icons">keyboard_arrow_down</i></span>
					</div>
					<ul class="footer_link hidden-xs">
				        <li><a href="mailto:info@handfree.co" style="color: #02b3e4; font-size: 18px;">info@handfree.co</a></li>						
				        <li><a href="tel:0903375500" style="color: #02b3e4; font-size: 18px;">0904623460</a></li>
				        <li><a href="/help">Hỗ Trợ</a></li>
				        <li><a href="/about">Thông Tin</a></li>
				        <li><a href="/about">Tuyển Dụng</a></li>
				        <li><a href="/about">Blog</a></li>

			        </ul>
				</div>

				<div class="col-sm-3 col-md-2">
					<div class="footer_title_div">
						<span class="footer_title">Khách Hàng</span>
						<span class="footer_title_arrow visible-xs"><i class="material-icons">keyboard_arrow_down</i></span>
					</div>
					<ul class="footer_link hidden-xs">
						<li><a href="/" class="btn-link">About</a></li>
						<li><a href="/" class="btn-link">Jobs</a></li>
						<li><a href="/" class="btn-link">Blog</a></li>
						<li><a href="/" class="btn-link">Help</a></li>						
					</ul>
				</div>

				<div class="col-sm-4 col-md-2" style="margin-bottom: 50px;">
					<div class="footer_title_div" id="footer_title_div_3">
						<span class="footer_title">Đối Tác</span>
						<span class="footer_title_arrow visible-xs"><i class="material-icons">keyboard_arrow_down</i></span>
					</div>			
					<ul class="footer_link hidden-xs" id="footer_link_3">
						<li><a href="/" class="btn-link">About</a></li>
						<li><a href="/" class="btn-link">Jobs</a></li>
						<li><a href="/" class="btn-link">Blog</a></li>
						<li><a href="/" class="btn-link">Help</a></li>						
					</ul>
				</div>

				<div class="col-sm-12 col-md-4">
					<center>
					<iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fhandfreeco&tabs&width=290&height=214&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=1600106333380695" width="290" height="214" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
					</center>
				</div>
				
			</div>
		</div>
		<div class="footer_legal">
			<div class="container">
				<div class="col-sm-8">
					<p>© 2018 Hand Free, JSC.</p>
					<p>Phòng 104, Số 4/2 Đinh Bộ Lĩnh, Phường 24, Quận Bình Thạnh, TP.HCM.</p>
					<p>Giấy phép ĐKKD: do Sở Kế Hoạch và Đầu Tư cấp ngày /01/2018.</p>
				</div>
				<div class="col-sm-4">
					<a class="btn-link">Privacy Policy</a>
					<span> | </span>
					<a class="btn-link">Terms of Use</a>

				</div>
			</div>
		</div>
	</footer>
	<script type="text/javascript">
		$(document).on('mouseover','.home_step_number_1', function (e) {
			$('.home_step_number_1').addClass('active');
			$('.home_step_number_2').removeClass('active');
			$('.home_step_number_3').removeClass('active');
			$('.home_step_number_4').removeClass('active');
			$('.step_horizontal_content_1').show();
			$('.step_horizontal_content_2').hide();
			$('.step_horizontal_content_3').hide();
			$('.step_horizontal_content_4').hide();
			$('.home_step_img').attr('src','img/mockup1.png');
		});
		$(document).on('mouseover','.home_step_number_2', function (e) {
			$('.home_step_number_2').addClass('active');
			$('.home_step_number_1').removeClass('active');
			$('.home_step_number_3').removeClass('active');
			$('.home_step_number_4').removeClass('active');
			$('.step_horizontal_content_1').hide();
			$('.step_horizontal_content_2').show();
			$('.step_horizontal_content_3').hide();
			$('.step_horizontal_content_4').hide();
			$('.home_step_img').attr('src','img/mockup2.png');
		});
		$(document).on('mouseover','.home_step_number_3', function (e) {
			$('.home_step_number_3').addClass('active');
			$('.home_step_number_1').removeClass('active');
			$('.home_step_number_2').removeClass('active');
			$('.home_step_number_4').removeClass('active');
			$('.step_horizontal_content_1').hide();
			$('.step_horizontal_content_2').hide();
			$('.step_horizontal_content_3').show();
			$('.step_horizontal_content_4').hide();
			$('.home_step_img').attr('src','img/mockup3.png');

		});
		$(document).on('mouseover','.home_step_number_4', function (e) {
			$('.home_step_number_4').addClass('active');
			$('.home_step_number_1').removeClass('active');
			$('.home_step_number_2').removeClass('active');
			$('.home_step_number_3').removeClass('active');
			$('.step_horizontal_content_1').hide();
			$('.step_horizontal_content_2').hide();
			$('.step_horizontal_content_3').hide();
			$('.step_horizontal_content_4').fadeIn();
			$('.home_step_img').attr('src','img/mockup4.png');

		});
		
		$(document).on('click','.home_step_prev', function (e) {
			$('.home_step_number_4').addClass('active');
			$('.home_step_number_1').removeClass('active');
			$('.home_step_number_2').removeClass('active');
			$('.home_step_number_3').removeClass('active');
			$('.step_horizontal_content_1').hide();
			$('.step_horizontal_content_2').hide();
			$('.step_horizontal_content_3').hide();
			$('.step_horizontal_content_4').show();
			$('.home_step_img').attr('src','img/mockup4.png');
		});
		$(document).on('click','.footer_title_div', function(e){
			$('.footer_link').attr("style", "display: block !important");
		});

	</script>
@endsection