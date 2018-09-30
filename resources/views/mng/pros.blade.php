@extends('template.mng.index')
@push('stylesheets')
<style>
</style>

<!-- Page Scripts -->
<script>
	$(document).ready(function() {
		autosize($('textarea'));
		$('.owl-carousel').owlCarousel({
			center: false,
			loop: false,
			nav: false,
			margin: 10,
			items: 5,
			autoWidth: true,
		});
		$('.datepicker-only-init').datetimepicker({
			widgetPositioning: {
				horizontal: 'left'
			},
			locale: moment.locale('vi'),
			icons: {
				time: "fa fa-clock-o",
				date: "fa fa-calendar",
				up: "fa fa-arrow-up",
				down: "fa fa-arrow-down"
			},
			format: 'DD/MM/YYYY',
		});
		$('#walletMoney').mask('000000000000');
		$('#walletMoney').on('keyup', function() {
			var money = accounting.unformat($(this).val());
			if (money > 0) {
				$('#walletMoneyString').html(coverMoneyToString(money) + ' Đồng');
			} else {
				$('#walletMoneyString').html('');
			}
		});
		$('#walletMoney').on('focusout', function() {
			$(this).val(accounting.formatMoney($(this).val()));
		});
		$('#walletMoney').on('focus', function() {
			if ($(this).val() !== '') {
				$(this).val(accounting.unformat($(this).val()));
			}
		});
		$('.price').each(function() {
			var money = $(this).html();
			if (parseInt(money) < 0) {
				$(this).addClass('color-danger');
			}
			$(this).html(accounting.formatMoney(money));
		});
		$('.mng-list').DataTable({
			responsive: true,
			info: false,
			paging: false,
			language: {
				zeroRecords: "Chưa có thông tin",
				search: "Tìm kiếm cục bộ"
			},
			order: [[3, 'desc']],
			columnDefs: [{ orderable: false, targets: [5] }]
		});

		$('#btnWallet').on('click', function() {
			$('#walletWallet').val(accounting.unformat($('#walletMoney').val()));
			
			if ($('#walletWallet').val() > 0) {
				loadingBtnSubmit('btnWallet');
				
				$.ajax({
					type: 'POST',
					url: $('#frmWallet').attr('action'),
					data: $('#frmWallet').serialize(),
					success: function(response) {
						swal({
							title: 'Hoàn tất',
							text: 'Đã chuyển tiền thành công',
							type: 'info',
							confirmButtonClass: 'btn-info',
							confirmButtonText: 'Quay lại',
						},
						function() {
							location.reload();
						});
					},
					error: function(xhr) {
						if (xhr.status == 400) {
							swal({
								title: 'Thất bại',
								text: 'Không tìm thấy ví tiền này',
								type: 'error',
								confirmButtonClass: 'btn-danger',
								confirmButtonText: 'Quay lại',
							});
						} else if (xhr.status == 409) {
							swal({
								title: 'Thất bại',
								text: 'Số tiền không đúng',
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
						resetBtnSubmit('btnWallet', 'Thực hiện');
					}
				});
			} else {
				swal({
					title: 'Thất bại',
					text: 'Chưa nhập số tiền nạp',
					type: 'error',
					confirmButtonClass: 'btn-danger',
					confirmButtonText: 'Quay lại',
				});
			}
		});
	});

	function deletePro(proId) {
		swal({
			title: 'Xóa Đối tác?',
			text: 'Thông tin này sẽ không thể phục hồi!',
			type: 'warning',
			showCancelButton: true,
			cancelButtonClass: 'btn-default',
			confirmButtonClass: 'btn-danger',
			cancelButtonText: 'Quay lại',
			confirmButtonText: 'Xóa',
			closeOnConfirm: false,
		},
		function(isConfirm) {
			if (isConfirm) {
				swal({
					title: 'Đang xử lý yêu cầu',
					text: 'Xin chờ trong giây lát!',
					type: 'info',
					showConfirmButton: false,
					closeOnConfirm: false,
				});
				
				var url = "{{ route('mng_pro_delete', ['id' => 'selectedProId']) }}";
				url = url.replace('selectedProId', proId);
				
				$('#frmMain').attr('action', url);
				$('#frmMain').submit();
			}
		});
	}

	function withdraw(proName, proId) {
		$('#walletTitle').html('Nạp tiền vào Tài khoản');
		$('#walletName').val(proName);
		$('#walletId').val(proId);
		$('#walletMoney').val('');
		$('#walletMoneyString').html('');
		$('#btnWallet').addClass('btn-primary').removeClass('btn-danger');
		
		var url = '{{ route("mng_wallet_update", ["id" => "walletId"]) }}';
		url = url.replace('walletId', proId);
		$('#frmWallet').attr('action', url);
		
		$('#modalWallet').modal('show');
	}

	function deposit(proName, proId) {
		$('#walletTitle').html('Xuất tiền khỏi Tài khoản');
		$('#walletName').val(proName);
		$('#walletId').val(proId);
		$('#walletMoney').val('');
		$('#walletMoneyString').html('');
		$('#btnWallet').addClass('btn-danger').removeClass('btn-primary');
		
		var url = '{{ route("mng_wallet_deposit", ["id" => "walletId"]) }}';
		url = url.replace('walletId', proId);
		$('#frmWallet').attr('action', url);
		
		$('#modalWallet').modal('show');
	}
</script>
@endpush

@section('title') Đối tác @endsection

@section('content')
<section class="content-body-full-page content-template-1">
	<div class="page-header hf-bg-gradient text-capitalize">Đối tác</div>
	<div class="margin-30 mng-report">
		<form method="get" action="{{ route('mng_pro_list') }}">
		<div class="search-row">
			<div class="form-group">
				<input type="text" class="form-control datepicker-only-init"
					name="fromDate"
					value="{{ app('request')->input('fromDate') }}"
					placeholder="DD/MM/YYYY" />
				<input type="text" class="form-control datepicker-only-init"
					name="endDate"
					value="{{ app('request')->input('endDate') }}"
					placeholder="DD/MM/YYYY" />
				<button class="btn btn-primary" type="submit">Hiển thị</button>
			</div>
		</div>
		</form>
		@if (sizeof($workProCountReport) > 0)
		<h5 class="margin-top-20">Số lượng Đối tác Hoạt động</h5>
		<div id="reportCarousel" class="owl-carousel owl-theme">
			@foreach ($workProCountReport as $item)
			<div class="item mng-report">
				<div class="widget widget-seven widget-report">
					<div class="widget-body">
						<div class="widget-body-inner">
							<h5 class="text-uppercase">Tháng {{ substr($item->yearmonth, -2) }}</h5>
							<span class="counter-count">
								<span class="counter-init">
									{{ number_format($item->data, 0, ',', '.') }}
								</span>
							</span>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		@endif
	</div>
	<div class="form-wrapper">
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-hover nowrap mng-list" width="100%">
					<thead>
						<tr>
							<th class="text-center">Họ tên</th>
							<th class="text-center">Địa chỉ</th>
							<th class="text-center" style="width: 100px;">Ví</th>
							<th class="text-center" style="width: 100px;">Ngày Đ.ký</th>
							<th class="text-center">Trạng thái</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($pros as $pro)
						<tr>
							<td class="col-pro-info"">
								<div class="@if ($pro->role == 2) color-danger @endif pro-name">
									{{ $pro->name }}
								</div>
								<div class="padding-left-5">
									@if (isset($pro->profile) && isset($pro->profile->company))
									<i class="material-icons">store</i> {{ $pro->profile->company->name }}
									@else
									<i class="material-icons">build</i> Kinh doanh cá nhân
									@endif
								</div>
							</td>
							<td>
								<div>
									<i class="material-icons">phone</i>
									@if ($pro->phone){{ $pro->phone }}
									@else
										<span class="no-info">Chưa cập nhật</span>
									@endif
								</div>
								<div>
									<i class="material-icons">mail</i>
									@if ($pro->email){{ $pro->email }}
									@else
										<span class="no-info">Chưa cập nhật</span>
									@endif
								</div>
								<div>
									<i class="material-icons">person_pin_circle</i> 
									@if ($pro->profile->address_2) {{ $pro->profile->address_1.' '.$pro->profile->address_2 }}
										@if ($pro->profile->city && $pro->profile->district)
										{{ $pro->profile->district_info->name.', '.$pro->profile->city_info->name }}
										@endif
									@else
										<span class="no-info">Chưa cập nhật</span>
									@endif
								</div>
							</td>
							<td>
								<div class="color-info font-weight-600">{{ '#'.sprintf('%06d', $pro->wallet->id) }}</div>
								<div class="price text-right">{{ $pro->wallet->wallet_2 }}</div>
								<div class="price font-weight-600 text-right">{{ $pro->wallet->wallet_1 }}</div>
							</td>
							<td class="text-right">
								<span class='hide'>{{ Carbon\Carbon::parse($pro->created_at)->format('YmdHi') }}</span>
								<div>{{ Carbon\Carbon::parse($pro->created_at)->format('d/m/Y') }}</div>
								<div>{{ Carbon\Carbon::parse($pro->created_at)->format('H:i') }}</div>
							</td>
							<td class="text-center col-label-profile-state">
								@if ($pro->delete_flg == 1)
									<span class="label label-secondary">Đã xóa</span>
								@elseif ($pro->profile->state == '1')
									<span class="label label-primary">Sẵn Sàng</span>
								@elseif ($pro->profile->state == '2')
									<span class="label label-default">Treo</span>
								@elseif ($pro->profile->state == '3')
									<span class="label label-warning">Cảnh cáo</span>
								@elseif ($pro->profile->state == '4')
									<span class="label label-danger">Khóa</span>
								@elseif ($pro->profile->state == '5')
									<span class="label label-secondary">Cấm vĩnh viễn</span>
								@else
									<span class="label label-success">Chờ Duyệt</span>
								@endif
							</td>
							<td class="text-right">
								<div class="dropdown">
									<span class="btn btn-sm " data-toggle="dropdown">
									<i class="icmn-cog3"></i>
									</span>
									<ul class="dropdown-menu dropdown-menu-right" role="menu">
										<a class="dropdown-item" href="{{ route('mng_pro_edit', ['id' => $pro->id]) }}">
											<i class="icmn-grid6"></i> Chi tiết
										</a>
										<a class="dropdown-item"  onclick="return withdraw('{{$pro->name}}', '{{$pro->id}}')">
											<i class="icmn-coins"></i> Nạp tiền
										</a>
										<a class="dropdown-item"  onclick="return deposit('{{$pro->name}}', '{{$pro->id}}')">
											<i class="icmn-upload9"></i> Xuất tiền
										</a>
										<a class="dropdown-item" href="javascript:void(0);">
											<i class="icmn-user-minus2"></i> Treo
										</a>
										<a class="dropdown-item" href="javascript:void(0);">
											<i class="icmn-user-cancel2"></i> Cảnh cáo
										</a>
										<a class="dropdown-item" href="javascript:void(0);">
											<i class="icmn-user-lock2"></i> Khóa
										</a>
										<a class="dropdown-item" href="javascript:void(0);">
											<i class="icmn-user-block"></i> Cấm vĩnh viễn
										</a>
										<a class="dropdown-item" href="javascript:void(0);" onclick="return deletePro('{{ $pro->id }}')">
											<i class="icmn-bin"></i> Xóa
										</a>
										<a class="dropdown-item" href="javascript:void(0);">
											<i class="icmn-user-check2"></i> Phục hồi
										</a>
									</ul>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<form id="frmMain" method="post" enctype="multipart/form-data" action="">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		</form>
	</div>
	
	<div id="modalWallet" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<form id="frmWallet" method="post" enctype="multipart/form-data" action="">
			<div class="modal-content">
				<div class="modal-body padding-30">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h3 id="walletTitle" class="padding-top-20 text-center"></h3>
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label>Họ tên</label>
								<input id="walletName" type="text" class="form-control" readonly>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label>Số tiền</label>
								<input id="walletMoney" type="text" maxlength="20" class="form-control">
							</div>
							<div id="walletMoneyString" class="font-size-12 color-primary" style="text-transform: capitalize;"></div>
						</div>
					</div>
					<div class="row padding-top-20">
						<div class="col-xs-12">
							<div class="form-group">
								<label>Ghi chú</label>
								<textarea class="form-control" name="description" rows="3" maxlength="200"></textarea>
							</div>
						</div>
					</div>
					<div class="row row-complete margin-top-20">
						<button id="btnWallet" type="button" class="btn" style="width: 100%">Thực hiện</button>
						<input id="walletId" type="hidden" name="id" value="" />
						<input id="walletWallet" type="hidden" name="wallet" value="" />
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
</section>
@endsection
