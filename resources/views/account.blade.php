@extends('template.index')
@push('stylesheets')
<style>
.acc-update-row i {
	font-size: 9px;
}

.avatar {
	height: 80px;
	width: 80px;
	position: relative;
}

.avatar:before {
	position: absolute;
	font-family: FontAwesome;
	content: '\f030';
	width: 100%;
	height: 100%;
	line-height: 80px;
	background: rgba(0, 0, 0, .3);
	color: #fafbfc;
	text-align: center;
}

.btn-acc-update {
	font-size: 11px;
	margin-top: -5px;
}
</style>

<script>
$(document).ready(function() {
	$('.price').each(function() {
		$(this).html(accounting.formatMoney($(this).html()));
	});
	$('[data-toggle=tooltip]').tooltip();
	$('#btnFillWallet').on('click', function() {
		swal({
			title: 'Tài khoản',
			text: 'Hiện tại chúng tôi chưa cung cấp dịch vụ này',
			type: 'warning',
			confirmButtonClass: 'btn-warning',
			confirmButtonText: 'Quay lại',
		});
	});
	$('#btnUpdateAcc').on('click', function() {
		$('.acc-update-row').show();
		$('.acc-info-row').hide();
	});
	$('#btnCompleteUpdateAcc').on('click', function() {
		$('.acc-info-row').show();
		$('.acc-update-row').hide();
	});
});
</script>
@endpush
@section('title') Tài khoản @endsection
@section('content')
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
				<button id="btnFillWallet" class="btn-deposit btn color-primary text-uppercase">Nạp thêm</button>
			</div>
			<div class="col-xs-12 text-center">
				<button class="btn-withdraw btn text-uppercase disabled">Rút ra</button>
			</div>
		</div>
	</div>
	
	<div class="form-wrapper">
		<h3 class="padding-top-20">Tài khoản</h3>
		<div class="padding-20 hf-card">
			<div class="acc-info-row row">
				<div class="col-xs-4 text-right">
					<img class="avt" src="{{ env('CDN_HOST') }}/u/{{ auth()->user()->id }}/{{ auth()->user()->avatar }}">
				</div>
				<div class="col-xs-8">
					<div id="btnUpdateAcc" class="pull-right color-default cursor-pointer btn-acc-update"><span><i class="icmn-pencil7"></i> Cập nhật</span></div>
					<div class="name">{{ auth()->user()->name }}</div>
					
					@if (!auth()->user()->phone)
					<div class="no-info color-warning">(Chưa cập nhật Số điện thoại)</div>
					@else
					<div class="phone">{{ auth()->user()->phone }}</div>
					@endif
					
					@if (!auth()->user()->email)
					<div class="no-info color-warning">(Chưa cập nhật Email)</div>
					@else
						@if (auth()->user()->confirm_flg == '0')
						<div class="color-warning email"><span>{{ auth()->user()->email }}</span>
							<i class="icmn-warning2" data-toggle="tooltip" data-placement="top"
								title="Chưa xác thực"></i></div>
						@else
						<div class="email"><span>{{ auth()->user()->email }}</span></div>
						@endif
					@endif
				</div>
			</div>
			
			<div class="acc-update-row row hide">
				<div class="col-xs-4 text-right">
					<a class="avatar" href="javascript:void(0);" data-toggle="modal" data-target="#modalAvatar">
						<img class="avt" src="{{ env('CDN_HOST') }}/u/{{ auth()->user()->id }}/{{ auth()->user()->avatar }}">
					</a>
				</div>
				<div class="col-xs-8">
					<div id="btnCompleteUpdateAcc" class="pull-right color-default cursor-pointer btn-acc-update"><span><i class="icmn-checkmark"></i> Hoàn tất</span></div>
					<div class="cursor-pointer" data-toggle="modal" data-target="#modalName">
						<span class="name">{{ auth()->user()->name }}</span>
						<span><i class="icmn-pencil2"></i></span>
					</div>
					<div class="cursor-pointer" data-toggle="modal" data-target="#modalPhone">
						<span class="phone">{{ auth()->user()->phone }}</span>
						<span><i class="icmn-pencil2"></i></span>
					</div>
					<div class="cursor-pointer" data-target="#modalEmail">
						<span class="phone">{{ auth()->user()->email }}</span>
						<span><i class="icmn-pencil2"></i></span>
					</div>
				</div>
			</div>
			
			<div class="row">
				@if (auth()->user()->role == '1')
				<div class="margin-top-20 margin-bottom-20 col-xs-12 text-center">
					<button type="button" class="btn btn-primary-outline" style="width: 80%"
						onclick="window.open('{{ route('pro_page', ['id' => auth()->user()->id]) }}')">{{ route('pro_page', ['id' => auth()->user()->id]) }}</button>
				</div>
				@endif
				<div class="padding-top-10 padding-right-12 col-xs-12 text-right control">
					<a class="padding-right-10 color-primary" href="{{ route('password_edit') }}" style="border-right: 1px solid #01a8fe">Đổi Mật khẩu</a>
					<a class="padding-left-10 color-primary" href="{{ route('logout') }}">Đăng xuất</a>
				</div>
			</div>
		</div>
		
		<h3 class="padding-top-30">Cấp độ</h3>
		<div class="padding-20 hf-card">
			@php $userLevel = -1 @endphp
			@foreach ($levels as $key=>$level) @if ($level->value <= auth()->user()->point) $userLevel = $key @endif @endforeach
			<h3 class="color-primary">Cấp độ {{ $userLevel+1 }} - {{ auth()->user()->point }} điểm</h3>
			<progress class="progress progress-primary" value="{{ auth()->user()->point }}" max="{{ $levels[$userLevel+1]->value }}"></progress>
			<div class="margin-top-10 info">Còn <b>{{ $levels[$userLevel+1]->value - auth()->user()->point }} điểm</b> để đạt cấp độ tiếp theo</div>
			<div class="margin-top-30 text-right control">
				<a class="padding-right-10 color-primary" href="javacript:void(0);" data-toggle="modal" data-target="#modalLevel" style="border-right: 1px solid #01a8fe">Hệ thống cấp độ</a>
				<a class="padding-left-10 color-primary" href="javacript:void(0);">Lịch sử</a>
			</div>
		</div>
		
		@if (auth()->user()->role == '1')
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
			<div class="margin-top-30 row text-center control">
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
			<div class="margin-top-30 row text-center control">
				<a class="color-primary" href="javacript:void(0);">Xem tất cả nhận xét</a>
			</div>
		</div>
		@endif
		
		<h3 class="padding-top-30">Hỗ trợ</h3>
		<div class="padding-20 hf-card">
			<div class="row" style="font-size: 14px; white-space: nowrap;">
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
			<div class="hf-info row">
				<div class="margin-top-10 col-xs-4 text-center cursor-pointer">
					<div><i class="material-icons">perm_identity</i></div>
					<div>Về chúng tôi</div>
				</div>
				<div class="margin-top-10 col-xs-4 text-center cursor-pointer">
					<div><i class="material-icons">work_outline</i></div>
					<div>Tuyển dụng</div>
				</div>
				<div class="margin-top-10 col-xs-4 text-center cursor-pointer">
					<div><i class="material-icons">help_outline</i></div>
					<div>Câu hỏi <span style="white-space: nowrap;">thường gặp</span></div>
				</div>
				<div class="margin-top-20 col-xs-4 text-center cursor-pointer" onclick="location.href = 'https://handfree.co/doc/privacy'">
					<div><i class="material-icons">security</i></div>
					<div>Chính sách <span style="white-space: nowrap;">bảo mật</span></div>
				</div>
				<div class="margin-top-20 col-xs-4 text-center cursor-pointer">
					<div><i class="material-icons">description</i></div>
					<div>Điều khoản <span style="white-space: nowrap;">sử dụng</span></div>
				</div>
				<div class="margin-top-20 col-xs-4 text-center cursor-pointer">
					<div><i class="material-icons">report</i></div>
					<div>SOS</div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="modalLevel" class="modal modal-size-small fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="padding-top-20 padding-bottom-20 text-center" style="font-weight: normal; white-space: nowrap;">Hệ thống Cấp độ</h3>
							<div class="row">
								@foreach ($levels as $key=>$level)
								<div class="col-lg-12">
									<div class="step-block
										@if ($key == 0) step-primary
										@elseif ($key == 1) step-info
										@elseif ($key == 2) step-success
										@elseif ($key == 3) step-warning
										@elseif ($key == 4) step-danger
										@elseif ($key == 5) step-secondary
										@else step-default
										@endif
									">
										<span class="step-digit">{{ $key+1 }}</span>
										<div class="step-desc">
											<span class="step-title">{{ $level->value }} điểm</span>
											<p>{{ $level->name }}</p>
										</div>
									</div>
								</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="modalName" class="modal modal-size-small fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<h3 class="padding-top-20 padding-bottom-20 text-center">abc</h3>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@include('template.mb.footer-menu')