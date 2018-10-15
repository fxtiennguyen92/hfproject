@extends('template.index')
@push('stylesheets')
<style>

.acc-avatar {
	height: 80px;
	width: 80px;
	position: relative;
}

.acc-avatar:before {
	position: absolute;
	font-family: FontAwesome;
	content: '\f030';
	width: 100%;
	height: 80px;
	border-radius: 100%;
	line-height: 80px;
	background: rgba(0, 0, 0, .2);
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
	$('.inp-price').each(function() {
		$(this).val(accounting.formatMoney($(this).val()));
	});
	$('.phone').mask('0000000000000');
	$('.sac').mask('0000');
	$('[data-toggle=tooltip]').tooltip();
	$('#walletMoney').mask('000000000000');
	$('#walletMoney').on('focusout', function() {
		$(this).val(accounting.formatMoney($(this).val()));
	});
	$('#walletMoney').on('focus', function() {
		if ($(this).val() !== '') {
			$(this).val(accounting.unformat($(this).val()));
		}
	});
	$('.trans-list').DataTable({
		responsive: true,
		info: false,
		paging: true,
		ordering: false,
		language: {
			lengthMenu: "Hiển thị _MENU_ dòng",
			zeroRecords: "Chưa có thông tin",
			search: "Tìm kiếm",
		},
	});
	
	$('#btnFillWallet').on('click', function() {
		var textAlert = '<p><strong>Cách 1: Chuyển Khoản Ngân Hàng</strong></p>';
		textAlert += '<p>Ngân hàng: Vietcombank</p>';
		textAlert += '<p>Số Tài khoản: 0071000686539</p>';
		textAlert += '<p>Tên Tài Khoản: LA THANH MINH</p>';
		textAlert += '<p><strong>Cách 2: Nạp qua MOMO</strong></p>';
		textAlert += '<p>Số Điện thoại: 0903375500</p>';
		textAlert += '<p><strong>Cách 3: Nạp Trực Tiếp</strong></p>';
		textAlert += '<p>Văn Phòng Hand Free</p>';
		textAlert += '<p>157/1A Nguyễn Gia Trí, Phường 25</p>';
		textAlert += 'Quận Bình Thạnh, TPHCM';
		
		swal({
			html: true,
			title: '',
			text: textAlert,
			confirmButtonClass: 'btn-primary',
			confirmButtonText: 'Quay lại',
		});
	});
	$('#btnEditAcc').on('click', function() {
		@if (auth()->user()->role == 2)
			swal({
				title: 'Cập nhật Thông tin',
				text: 'Hãy liên hệ Bộ phận CSKH để thay đổi thông tin cá nhân',
				type: 'info',
				confirmButtonClass: 'btn-info',
				confirmButtonText: 'Quay lại',
			});
		@else
			$('#modalInfo').modal('show');
		@endif
	});
	$('#btnEditPassword').on('click', function() {
		$('input[type=password]').each(function() {
			$(this).val('');
		});
		$('#modalPassword').modal('show');
	});
	$('#btnTransHistory').on('click', function() {
		@if (sizeof($user->walletTransactionRequest) == 0)
			swal({
				title: 'Lịch sử giao dịch',
				text: 'Hiện chưa có giao dịch nào',
				type: 'warning',
				confirmButtonClass: 'btn-warning',
				confirmButtonText: 'Quay lại',
			});
		@else
			$('#modalTransaction').modal('show');
		@endif
	});
	
	$('input[name=phone]').on('keyup', function() {
		if ($(this).val() !== '{{ auth()->user()->phone }}') {
			$('.sac-row').show();
			$('input[name=sac]').addValidation('NOTEMPTY');
		} else {
			$('.sac-row').hide();
			$('input[name=sac]').removeValidation('NOTEMPTY');
		}
	});
	$('#btnSendSAC').on('click', function() {
		if ($('input[name=phone]').val() == '') {
			$('input[name=phone]').focus();
			$.notify({
				title: '<strong>Lỗi! </strong>',
				message: 'Chưa có thông tin về Số điện thoại.'
			}, {
				type: 'danger',
				z_index: 1051,
			});
		} else {
			$('#btnSendSAC').addClass('disabled');
			$('#btnSendSAC').html('<i class="fa fa-spinner fa-spin"></i> Đang gửi')
			
			$.ajax({
				type: 'POST',
				url: '{{ route("signup_get_sac") }}',
				data: $('#frmInfo').serialize(),
				success: function(response) {
					$('#btnSendSAC').html('Đã gửi mã PIN');
					setTimeout(function() {
						$('#btnSendSAC').removeClass('disabled');
						$('#btnSendSAC').html('Gửi lại Mã PIN');
					}, 60000);
				},
				error: function(xhr) {
					if (xhr.status == 400) {
						$.notify({
							title: '<strong>Lỗi! </strong>',
							message: 'Chưa có thông tin về Số điện thoại.'
						}, {
							type: 'danger',
							z_index: 1051,
						});
					} else if (xhr.status == 409) {
						$.notify({
							title: '<strong>Đã sử dụng! </strong>',
							message: 'Số điện thoại đã được đăng ký.'
						}, {
							type: 'danger',
							z_index: 1051,
						});
					} else if (xhr.status == 503) {
						$.notify({
							title: '<strong>Lỗi SMS! </strong>',
							message: 'Gửi tin nhắn thất bại, mời thử lại.'
						}, {
							type: 'danger',
							z_index: 1051,
						});
					} else {
						$.notify({
							title: '<strong>Thất bại! </strong>',
							message: 'Có lỗi phát sinh, mời thử lại.'
						}, {
							type: 'danger',
							z_index: 1051,
						});
					}

					setTimeout(function() {
						$('#btnSendSAC').removeClass('disabled');
						$('#btnSendSAC').html('Gửi lại Mã PIN');
					}, 2000);
				}
			});
		}
	});
	$('#frmInfo').validate({
		submit: {
			settings: {
				inputContainer: '.form-group',
				errorListClass: 'form-control-error',
				errorClass: 'has-danger',
			},
			callback: {
				onSubmit: function() {
					loadingBtnSubmit('btnUpdateAcc');
					
					$.ajax({
						type: 'POST',
						url: '{{ route("profile_account_update") }}',
						data: $('#frmInfo').serialize(),
						success: function(response) {
							location.href = "{{ route('control') }}";
						},
						error: function(xhr) {
							if (xhr.status == 401) {
								swal({
									title: 'PIN Code!',
									text: 'Mã xác thực không đúng.',
									type: 'error',
									confirmButtonClass: 'btn-default',
									confirmButtonText: 'Quay lại',
								});
							} else if (xhr.status == 409) {
								swal({
									title: 'Thất bại',
									text: 'Số điện thoại hoặc Email đã được sử dụng.',
									type: 'error',
									confirmButtonClass: 'btn-default',
									confirmButtonText: 'Thử lại',
								});
							} else if (xhr.status == 412) {
								swal({
									title: 'Lỗi định dạng',
									text: 'Thông tin chưa đúng định dạng.',
									type: 'error',
									confirmButtonClass: 'btn-danger',
									confirmButtonText: 'Kiểm tra lại',
								});
							} else {
								swal({
									title: 'Thất bại',
									text: 'Cập nhật không thành công',
									type: 'error',
									confirmButtonClass: 'btn-default',
									confirmButtonText: 'Thử lại',
								});
							};
							resetBtnSubmit('btnUpdateAcc', 'Cập nhật');
						}
					});
				}
			}
		}
	});
	$('#frmPassword').validate({
		submit: {
			settings: {
				inputContainer: '.form-group',
				errorListClass: 'form-control-error',
				errorClass: 'has-danger',
			},
			callback: {
				onSubmit: function() {
					loadingBtnSubmit('btnUpdatePassword');
					
					$.ajax({
						type: 'POST',
						url: '{{ route("password_update") }}',
						data: $('#frmPassword').serialize(),
						success: function(response) {
							location.href = "{{ route('control') }}";
						},
						error: function(xhr) {
							if (xhr.status == 401) {
								swal({
									title: 'Thất bại',
									text: 'Mật khẩu hiện tại không đúng',
									type: 'error',
									confirmButtonClass: 'btn-danger',
									confirmButtonText: 'Quay lại',
								});
							} else if (xhr.status == 409) {
								swal({
									title: 'Thất bại',
									text: 'Mật khẩu mới không đúng định dạng',
									type: 'error',
									confirmButtonClass: 'btn-danger',
									confirmButtonText: 'Quay lại',
								});
							} else {
								swal({
									title: 'Thất bại',
									text: 'Có lỗi phát sinh, mời thử lại',
									type: 'error',
									confirmButtonClass: 'btn-default',
									confirmButtonText: 'Thử lại',
								});
							};
							$('input[type=password]').each(function() {
								$(this).val('');
							});
							resetBtnSubmit('btnUpdatePassword', 'Cập nhật');
						}
					});
				}
			}
		}
	});
	$('#btnDeposit').on('click', function() {
		$('#walletWallet').val(accounting.unformat($('#walletMoney').val()));
		if ($('#walletWallet').val() == '0') {
			swal({
				title: 'Thất bại',
				text: 'Số dư không hợp lệ',
				type: 'error',
				confirmButtonClass: 'btn-danger',
				confirmButtonText: 'Quay lại',
			});
		} else {
			loadingBtnSubmit('btnDeposit');
			$.ajax({
				type: 'POST',
				url: '{{ route("wallet_deposit") }}',
				data: $('#frmDeposit').serialize(),
				success: function(response) {
					location.reload();
				},
				error: function(xhr) {
					if (xhr.status == 409) {
						swal({
							title: 'Thất bại',
							text: 'Số dư không hợp lệ',
							type: 'error',
							confirmButtonClass: 'btn-danger',
							confirmButtonText: 'Quay lại',
						});
					} else {
						swal({
							title: 'Thất bại',
							text: 'Có lỗi phát sinh, mời thử lại',
							type: 'error',
							confirmButtonClass: 'btn-default',
							confirmButtonText: 'Thử lại',
						});
					};
					resetBtnSubmit('btnDeposit', 'Xác nhận yêu cầu');
				}
			});
		}
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
		<div class="margin-top-20 padding-bottom-10 row">
			<div class="margin-bottom-10 col-xs-12 text-center">
				<button id="btnFillWallet" class="btn-deposit btn color-primary text-uppercase">Nạp thêm</button>
			</div>
			<div class="col-xs-12 text-center">
				<button class="btn-withdraw btn text-uppercase" data-toggle="modal" data-target="#modalDeposit">Rút ra</button>
			</div>
		</div>
		<div class="padding-20 row text-right control">
			<div class="col-xs-12 text-right">
				<a id="btnTransHistory" style="color: #fff; font-size: 13px;" href="javacript:void(0);">Lịch sử giao dịch</a>
			</div>
		</div>
	</div>
	
	<div class="form-wrapper account-info">
		<h3 class="padding-top-20">Tài khoản</h3>
		<div class="padding-20 hf-card">
			<div class="acc-info-row row">
				<div class="col-xs-4 text-right">
					<img class="avt" src="{{ env('CDN_HOST') }}/u/{{ auth()->user()->id }}/{{ auth()->user()->avatar }}">
				</div>
				<div class="col-xs-8">
					<div id="btnEditAcc" class="pull-right color-default cursor-pointer btn-acc-update"><span><i class="icmn-pencil7"></i> Cập nhật</span></div>
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
						<div class="color-warning email">
							<span>{{ auth()->user()->email }}
							<i class="icmn-warning2" data-toggle="tooltip" data-placement="top"
								title="Chưa xác thực"></i>
							</span>
						</div>
						@else
						<div class="email"><span>{{ auth()->user()->email }}</span></div>
						@endif
					@endif
				</div>
			</div>
			<div class="row">
				@if (auth()->user()->role == '1')
				<div class="margin-top-20 margin-bottom-20 col-xs-12 text-center">
					<button type="button" class="btn btn-primary-outline" style="width: 80%; overflow: hidden !important; text-overflow: ellipsis;"
						onclick="window.open('{{ route('pro_page', ['id' => auth()->user()->id]) }}')">{{ route('pro_page', ['id' => auth()->user()->id]) }}</button>
				</div>
				@endif
				<div class="padding-top-10 padding-right-12 col-xs-12 text-right control">
					<a id="btnEditPassword" class="padding-right-10 color-primary" href="javascript:void(0);" style="border-right: 1px solid #01a8fe">
						Mật khẩu
						@if ($user->password_temp)
						<span class="icmn-warning2 color-warning"></span>
						@endif
					</a>
					<a class="padding-left-10 color-primary" href="{{ route('logout') }}">Đăng xuất</a>
				</div>
			</div>
		</div>
		
		<h3 class="padding-top-30">Cấp độ</h3>
		<div class="padding-20 hf-card">
			<h3 class="color-primary">Cấp độ {{ $user->pLevel + 1 }} - {{ auth()->user()->point }} điểm</h3>
			<progress class="progress progress-primary" value="{{ auth()->user()->point }}" max="{{ $levels[$user->pLevel]->value }}"></progress>
			@if ($levels[$user->pLevel]->value - auth()->user()->point > 0)
			<div class="margin-top-10 info">Còn <b>{{ $levels[$user->pLevel]->value - auth()->user()->point }} điểm</b> để đạt cấp độ tiếp theo</div>
			@endif
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
					<span class="margin-right-20 rating-number color-primary">{{ $user->profile->rating }} <i class="material-icons">star</i></span>
					<span class="total-review">{{ $user->profile->total_review }} người</span>
				</div>
			</div>
			<div class="margin-top-20 row">
				<div class="col-xs-2 text-center">5</div>
				<div class="margin-top-10 col-xs-8">
					<progress class="progress progress-primary" value="{{ json_decode($user->profile->lvl_total_review)[4] }}" max="{{ $user->profile->total_review }}"></progress>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-2 text-center">4</div>
				<div class="margin-top-10 col-xs-8">
					<progress class="progress progress-info" value="{{ json_decode($user->profile->lvl_total_review)[3] }}" max="{{ $user->profile->total_review }}"></progress>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-2 text-center">3</div>
				<div class="margin-top-10 col-xs-8">
					<progress class="progress progress-success" value="{{ json_decode($user->profile->lvl_total_review)[2] }}" max="{{ $user->profile->total_review }}"></progress>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-2 text-center">2</div>
				<div class="margin-top-10 col-xs-8">
					<progress class="progress progress-warning" value="{{ json_decode($user->profile->lvl_total_review)[1] }}" max="{{ $user->profile->total_review }}"></progress>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-2 text-center">1</div>
				<div class="margin-top-10 col-xs-8">
					<progress class="progress progress-danger" value="{{ json_decode($user->profile->lvl_total_review)[0] }}" max="{{ $user->profile->total_review }}"></progress>
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
					<h3 class="color-primary"><span class="margin-right-5 total-review-number">{{ $user->profile->total_review }}</span> nhận xét</h3>
				</div>
			</div>
			@foreach ($user->profile->reviews as $review)
			<div class="message row">
				<div class=" col-md-2 col-sm-2 col-xs-2 text-center">
					<img class="avatar" style="border-radius:100%" class="avt" src="{{ env('CDN_HOST') }}/u/{{ $review->user->id }}/{{ $review->user->avatar }}">
				</div>
				<div class="col-md-10 col-sm-10 col-xs-10">
					<div class="clearfix">
						<div class="pull-left author"><a href="#">{{ $review->user->name }}</a> <span>{{ $review->created_at->format('d/m/Y') }}</span></div>
						<div class="author-rating pull-right">
							<select id="rating" class="rating" data-current-rating="{{ $review->rating }}">
								<option value=""></option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
						</div>
					</div>
					<div class="message-text">
						{{ $review->content }}
					</div>
				</div>
			</div>
			@endforeach
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
					<label class="margin-top-10">035 2221 050</label>
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
				<div class="margin-top-20 col-xs-4 text-center cursor-pointer" onclick="window.open('https://handfree.co/doc/privacy', '_blank');">
					<div><i class="material-icons">security</i></div>
					<div>Chính sách <span style="white-space: nowrap;">bảo mật</span></div>
				</div>
				<div class="margin-top-20 col-xs-4 text-center cursor-pointer" onclick="window.open('https://handfree.co/doc/term-of-use', '_blank');">
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
	
	<div id="modalInfo" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<form id="frmInfo" method="post" name="form-validation" enctype="multipart/form-data" action="{{ route('profile_account_update') }}">
			<div class="modal-content">
				<div class="modal-body padding-30">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h3 class="padding-top-20 padding-bottom-20 text-center">Thông tin cá nhân</h3>
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label>Họ và tên</label>
								<input type="text" maxlength="225" class="form-control" name="name"
									data-validation="[NOTEMPTY]" value="{{ auth()->user()->name }}">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label>Số điện thoại</label>
								<input id="inpPhone" type="text" maxlength="25" class="form-control phone" name="phone"
									data-validation="[NOTEMPTY]" value="{{ auth()->user()->phone }}">
							</div>
						</div>
					</div>
					<div class="sac-row row hide">
						<div class="col-xs-8">
							<div class="form-group">
								<label>Mã PIN</label>
								<input id="inpSAC" maxlength="4" class="form-control sac" name="sac" type="text">
							</div>
						</div>
						<div class="col-xs-4 text-right">
							<span id="btnSendSAC" class="btnSendSAC btn" style="margin-top: 15px;">Gửi mã PIN</span>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label>Email</label>
								<input id="" type="text" maxlength="100" class="form-control" name="email"
									data-validation="[NOTEMPTY, EMAIL]" value="{{ auth()->user()->email }}">
								<div class="font-size-12 color-warning">Hand Free sẽ gửi mail kích hoạt về địa chỉ Email này. Vui lòng xác thực để kích hoạt.</div>
							</div>
						</div>
					</div>
					<div class="row row-complete margin-top-20">
						<button id="btnUpdateAcc" type="submit" class="btn btn-primary" style="width: 100%">Cập nhật</button>
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
	
	<div id="modalPassword" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<form id="frmPassword" method="post" name="form-validation" enctype="multipart/form-data" action="{{ route('password_update') }}">
			<div class="modal-content">
				<div class="modal-body padding-30">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h3 class="padding-top-20 text-center">Cập nhật Mật khẩu</h3>
					<p class="font-size-12 text-center color-warning padding-bottom-20">
						@if ($user->password_temp)
						Hiện tại bạn đang sử dụng <b>Mật khẩu mặc định</b>
						@endif
					</p>
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label>Mật khẩu hiện tại</label>
								<input type="password" maxlength="100" class="form-control password" name="current_password" data-validation="[NOTEMPTY]">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label>Mật khẩu mới</label>
								<input type="password" maxlength="100" class="form-control password" name="password" data-validation="[NOTEMPTY, L>=6]">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label>Xác nhận lại Mật khẩu</label>
								<input type="password" maxlength="100" class="form-control" name="password_confirmation" data-validation="[NOTEMPTY, V==password]">
							</div>
						</div>
					</div>
					<div class="row row-complete margin-top-20">
						<button id="btnUpdatePassword" type="submit" class="btn btn-primary" style="width: 100%">Cập nhật</button>
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
	
	<div id="modalDeposit" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<form id="frmDeposit" method="post" name="form-validation" action="{{ route('wallet_deposit') }}">
			<div class="modal-content">
				<div class="modal-body padding-30">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h3 class="padding-20 text-center">Yêu cầu Rút tiền</h3>
					<div class="form-group row">
						<div class="col-xs-4">
							<label class="form-control-label">Số dư hiện tại</label>
						</div>
						<div class="col-xs-8">
							<input type="text" class="form-control inp-price" value="{{ $user->wallet->wallet_1 }}" readonly>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-4">
							<label class="form-control-label">Số tiền rút</label>
						</div>
						<div class="col-xs-8">
							<input id="walletMoney" type="text" maxlength="16"
								class="form-control">
						</div>
					</div>
					<div class="row row-complete margin-top-20">
						<button id="btnDeposit" type="submit" class="btn btn-primary" style="width: 100%">Xác nhận yêu cầu</button>
						<input id="walletWallet" type="hidden" name="wallet" value="" />
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
	
	<div id="modalTransaction" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body padding-30">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h3 class="padding-top-20 text-center">Lịch sử giao dịch</h3>
					<table class="table table-hover trans-list" width="100%">
						<thead>
							<tr>
								<th>Thời gian</th>
								<th>Nội dung</th>
								<th class="text-center">Số tiền</th>
							</tr>
						</thead>
						<tbody>
							@foreach($user->walletTransactionRequest as $transaction)
							<tr>
								<td>
									<span class='hide'>{{ Carbon\Carbon::parse($transaction->created_at)->format('YmdHi') }}</span>
									{{ Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y H:i') }}
								</td>
								<td>Yêu cầu rút tiền</td>
								<td class="price text-right">{{ $transaction->wallet }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@include('template.mb.footer-menu')