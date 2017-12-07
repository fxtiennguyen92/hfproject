<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Ứng Dụng Đặt Việc Nhà trong 60 giây">
	<meta name="author" content="Hand Free">
	<link rel="icon" type="image/png" sizes="96x96" href="img/favicon-96x96.png">
	<title>Hand Free - Đặt Việc Nhà 60 giây</title>

	<!-- PWA -->
	<link rel="manifest" href="./manifest.json">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-title" content="Hand Free">
	<link rel="apple-touch-icon" href="img/icons/icon-152x152.png">
	<meta name="msapplication-TileImage" content="img/icons/icon-144x144.png">
	<meta name="msapplication-TileColor" content="#2F3BA2">

	<!-- Jquery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

	<!-- Google Font & Icons-->
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

	<!-- MDL -->
	<link rel="stylesheet" type="text/css" href="https://code.getmdl.io/1.3.0/material.blue-red.min.css">
	<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

	<!-- Main CSS -->
	<link rel="stylesheet" type="text/css" href="css/main.css">

</head>
<body>
	<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
	@include('template.nav')

	<!-- SECTION JUMBO -->
	<section>
		<div id="jumbo" class="mdl-grid">
			<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--8-col-desktop">
				<div class="card_udacity_jumbo_left">
					<input type="text" name="search" class="main_search_input" placeholder="Tìm Sửa Điện, Sửa Nước, ..." autofocus>
				</div>
			</div>			
		</div>
	</section>

	<!-- SECTION SERVICE -->	
	<section>
		<div class="mdl-grid">
			<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--2-col-tablet mdl-cell--12-col-desktop">
				<p class="title_new_22">Chọn Dịch Vụ</p>
			</div>
			<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
				<div class="mdl-grid">
					@foreach ($groups as $group)
					<div class="mdl-cell mdl-cell--2-col-phone mdl-cell--2-col-tablet mdl-cell--1-offset-tablet mdl-cell--2-col-desktop">
						<div class="card_service_col2">
							<a class="card_service_button" href="#">
								<img src="img/services/groups/{{ $group['id'] }}.png" class="card_service_img">
								<br><p class="card_service_title">{{ $group['name'] }}</p>
							</a>
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</div>
	</section>

	<!-- SECTION GUIDE -->	
	<section style="text-align: center;">
		<div id="guide">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--2-col-tablet mdl-cell--12-col-desktop">
					<h4>Các bước đặt việc</h4><br>
				</div>
				<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--2-col-tablet mdl-cell--4-col-desktop">
							<img alt="Vetted professionals" src="img/home/guide-1.png">
							<h5>Chọn Dịch Vụ</h5>
							<p>Chúng tôi có mọi dịch vụ bạn cần và giá niêm yết</p>
				</div>
				<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--2-col-tablet mdl-cell--4-col-desktop">
						<img alt="Vetted professionals" src="img/home/guide-2.png">
							<h5>Chọn Thời Gian</h5>
							<p>Xác nhận thời gian, địa điểm và OK.</p>
				</div>
				<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--2-col-tablet mdl-cell--4-col-desktop">
						<img alt="Vetted professionals" src="img/home/guide-3.png">
							<h5>HandFree Có Mặt</h5>
							<p>Chúng tôi cam kết đến nhà trong vòng 30 phút.</p>
				</div>
			</div>
			<br><br>
			<p style="color: #02b3e4; font-size: 16px;">XEM ỨNG DỤNG HOẠT ĐỘNG <i class="material-icons">arrow_forward</i></p>
			<br>
		</div>
	</section>


		<!-- SECTION FEATURED -->
	<section style="text-align: center;">
		<div id="featured">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--2-col-tablet mdl-cell--1-offset-tablet mdl-cell--4-col-desktop">
					<img alt="Vetted professionals" src="img/home/featured-1.png">
					<h5>Đối Tác Chuyên Nghiệp</h5>
					<p>Đào tạo nghiệp vụ bài bản</p>
					<p>Kiểm tra lý lịch kỹ càng.</p>
					<p>Liên tục thử thách để duy trì</p>
				</div>
				<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--2-col-tablet mdl-cell--4-col-desktop">
					<img alt="Vetted professionals" src="img/home/featured-2.png">
					<h5>Tiết Kiệm Thời Gian </h5>
					<p>Đặt dưới 60 giây</p>
					<p>Có mặt trong 30 phút.</p>
				</div>
				<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--2-col-tablet mdl-cell--4-col-desktop">
					<img alt="Vetted professionals" src="img/home/featured-3.png" width="90">
					<h5 style="line-height: 30px;">Cam Kết Hài Lòng của HandFree</h5>
					<p>Sự hài lòng của bạn là tối thượng.</p>
					<p>Bạn không vui, chúng tôi sửa lỗi ngay lập tức.</p>
					<a href="/guarantee" class="learn-more" target="_blank">Xem Thêm</a>
				</div>
			</div>
		</div>
	</section>

	<!-- SECTION PARTNER -->
	<section style="text-align: center;">
		<div id="partner">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
					<p class="partner-call-title">Trở Thành Đối Tác Hand Free</p>
					<p class="partner-call-txt">Tham Gia với chúng tôi ngay để kiếm thêm thu nhập.</p>
					<a href="./doi-tac" class="mdl-button mdl-js-button btn-partner">TRỞ THÀNH ĐỐI TÁC</a>
				</div>
			</div>
		</div>
	</section>

	</div>
</body>
</html>