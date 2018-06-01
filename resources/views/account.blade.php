@extends('template.index') @push('stylesheets')
<script>
$(document).ready(function() {
	$('.price').each(function() {
		$(this).html(accounting.formatMoney($(this).html()));
	});
	$("[data-toggle=tooltip]").tooltip();
	$('#btnFillWallet').on('click', function() {
		swal({
			title: 'Tài khoản',
			text: 'Hiện tại chúng tôi chỉ nhận nạp thêm tài khoản tại Văn phòng 4/2 Đinh Bộ Lĩnh, P104',
			type: 'warning',
			confirmButtonClass: 'btn-primary',
			confirmButtonText: 'Quay lại',
		});
	});
});
</script>
@endpush @section('title') Tài khoản @endsection @section('content')
<section class="content-body content-template-1 has-bottom-menu">
	<div class="hf-bg-gradient wallet">
		<div class="padding-20 row">
			<div class="col-xs-6 text-center" style="border-right: solid 2px #fff">
				<div class="name">Ví Hand
					<i class="icmn-notification" data-toggle="tooltip" data-placement="right"
						title="Ví Hand ..."></i></div>
				<div class="price">{{ $user->wallet->wallet_2 }}</div>
			</div>
			<div class="col-xs-6 text-center">
				<div class="name">Ví Tiền
					<i class="icmn-notification" data-toggle="tooltip" data-placement="left"
						title="Ví Tiền ..."></i></div>
				<div class="price">{{ $user->wallet->wallet_1 }}</div>
			</div>
		</div>
		<div class="margin-top-20 padding-bottom-20 row">
			<div class="margin-bottom-10 col-xs-12 text-center">
				<button class="btn-deposit btn color-primary text-uppercase">Nạp thêm</button>
			</div>
			<div class="col-xs-12 text-center">
				<button class="btn-withdraw btn text-uppercase">Rút ra</button>
			</div>
		</div>
	</div>
	
	<div class="form-wrapper">
		<h3 class="padding-top-20">Tài khoản</h3>
		<div class="padding-20 hf-card">
			<div class="row">
				<div class="col-xs-5 text-right">
					<img class="avt" src="{{ env('CDN_HOST') }}/u/{{ auth()->user()->id }}/{{ auth()->user()->avatar }}">
				</div>
				<div class="col-xs-7">
					<div class="name text-uppercase">{{ auth()->user()->name }}</div>
					
					@if (!auth()->user()->phone)
					<div class="no-info color-warning">(Chưa cập nhật Số điện thoại)</div>
					@else
					<div class="phone">{{ auth()->user()->phone }}</div>
					@endif
					
					@if (!auth()->user()->email)
					<div class="no-info color-warning">(Chưa cập nhật Email)</div>
					@else
					<div class="email">{{ auth()->user()->email }}</div>
					@endif
				</div>
			</div>
			<div class="row">
				<div class="margin-top-20 margin-bottom-20 col-xs-12 text-center">
					<button type="button" class="btn btn-primary-outline" style="width: 80%"
						onclick="window.open('https://handfree.co/pro/{{ auth()->user()->id }}')">handfree.co/pro/{{ auth()->user()->id }}</button>
				</div>
				<div class="padding-top-10 padding-right-12 col-xs-12 text-right">
					<a class="padding-right-10 color-primary" href="{{ route('password_edit') }}" style="border-right: 1px solid #01a8fe">Đổi Mật khẩu</a>
					<a class="padding-left-10 color-primary" href="{{ route('logout') }}">Đăng xuất</a>
				</div>
			</div>
		</div>
		
		<h3 class="padding-top-30">Cấp độ</h3>
		<div class="padding-20 hf-card">
			<h3 class="color-primary">Cấp độ 6 - {{ auth()->user()->point }}</h3>
			<progress class="progress progress-primary" value="74" max="100"></progress>
			<div class="margin-top-10 info">Còn 12300 điểm để đạt cấp độ tiếp theo</div>
			<div class="margin-top-30 text-center">
				<a class="margin-right-30 color-primary" href="javacript:void(0);">Xem lịch sử</a>
				<a class="color-primary" href="javacript:void(0);" data-toggle="modal" data-target="#modalNewCommon">Hệ thống cấp độ</a>
			</div>
		</div>
		
		<h3 class="padding-top-30">Đánh giá</h3>
		<div class="padding-20 hf-card">
			<div class="row">
				<div class="col-xs-2"></div>
				<div class="col-xs-10">
					<span class="margin-right-20 rating-number color-primary">3.7 <i class="material-icons">star</i></span>
					<span class="total-review">513 người</span>
				</div>
			</div>
			<div class="margin-top-20 row">
				<div class="col-xs-2 text-center">5</div>
				<div class="margin-top-10 col-xs-8">
					<progress class="progress progress-primary" value="74" max="100"></progress>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-2 text-center">4</div>
				<div class="margin-top-10 col-xs-8">
					<progress class="progress progress-info" value="54" max="100"></progress>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-2 text-center">3</div>
				<div class="margin-top-10 col-xs-8">
					<progress class="progress progress-success" value="34" max="100"></progress>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-2 text-center">2</div>
				<div class="margin-top-10 col-xs-8">
					<progress class="progress progress-warning" value="10" max="100"></progress>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-2 text-center">1</div>
				<div class="margin-top-10 col-xs-8">
					<progress class="progress progress-danger" value="1" max="100"></progress>
				</div>
			</div>
			<div class="margin-top-30 row text-center">
				<a class="color-primary" href="javacript:void(0);">Cách để tăng điểm đánh giá</a>
			</div>
		</div>
		
		<h3 class="padding-top-30">Nhận xét</h3>
		<div class="padding-20 hf-card">
			<div class="row">
				<div class="col-xs-2"></div> 
				<div class="col-xs-10">
					<h3 class="color-primary"><span class="margin-right-5 total-review-number">158</span> nhận xét</h3>
				</div>
			</div>
			<div class="margin-top-30 row text-center">
				<a class="color-primary" href="javacript:void(0);">Xem tất cả nhận xét</a>
			</div>
		</div>
		
		<h3 class="padding-top-30">Hỗ trợ</h3>
		<div class="padding-20 hf-card">
			<div class="row">
				<div class="col-xs-4 text-center"
					onclick="window.open('https://zalo.me/1699928395940319098', '_blank');">
					<img class="social-icon" src="{{ env('CDN_HOST') }}/img/social/zalo.png">
					<label class="margin-top-10">Hand Free</label>
				</div>
				<div class="col-xs-4 text-center"
					onclick="window.open('https://m.me/handfreeco', '_blank');">
					<img class="social-icon" src="{{ env('CDN_HOST') }}/img/social/facebook-messenger.png">
					<label class="margin-top-10">handfreeco</label>
				</div>
				<div class="col-xs-4 text-center">
					<img class="social-icon" src="{{ env('CDN_HOST') }}/img/social/phone.png">
					<label class="margin-top-10">024 7304 1114</label>
				</div>
			</div>
		</div>
		
		<h3 class="padding-top-30">Thông tin Hand Free</h3>
		<div class="padding-20 hf-card">
			<div class="row">
				<div class="margin-top-10 col-xs-4 text-center">
					<div><i class="material-icons">perm_identity</i></div>
					<div>Về chúng tôi</div>
				</div>
				<div class="margin-top-10 col-xs-4 text-center">
					<div><i class="material-icons">work_outline</i></div>
					<div>Tuyển dụng</div>
				</div>
				<div class="margin-top-10 col-xs-4 text-center">
					<div><i class="material-icons">live_help</i></div>
					<div>Câu hỏi <span style="white-space: nowrap;">thường gặp</span></div>
				</div>
				<div class="margin-top-10 col-xs-4 text-center">
					<div><i class="material-icons">security</i></div>
					<div>Chính sách <span style="white-space: nowrap;">bảo mật</span></div>
				</div>
				<div class="margin-top-10 col-xs-4 text-center">
					<div><i class="material-icons">description</i></div>
					<div>Điều khoản</div>
				</div>
				<div class="margin-top-10 col-xs-4 text-center">
					<div><i class="material-icons">verified_user</i></div>
					<div>An ninh</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@include('template.mb.footer-menu')