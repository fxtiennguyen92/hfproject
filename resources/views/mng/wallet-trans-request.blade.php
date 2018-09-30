@extends('template.mng.index')
@push('stylesheets')
<style>
</style>

<!-- Page Scripts -->
<script>
	$(document).ready(function() {
		$('.price').each(function() {
			$(this).html(accounting.formatMoney($(this).html()));
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
		$('.mng-list').DataTable({
			responsive: true,
			info: false,
			paging: false,
			language: {
				zeroRecords: "Chưa có thông tin",
				search: "Tìm kiếm cục bộ"
			},
			order: [[0, 'desc']],
			"footerCallback": function (row, data, start, end, display) {
				var api = this.api(), data;
				
				// Total over all pages
				total = api
					.column(2, { page: 'current'})
					.data()
					.reduce(function (a, b) {
						return accounting.unformat(a) + accounting.unformat(b);
					}, 0);
				
				$(api.column(2).footer()).html(accounting.formatMoney(total));
			}
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
							text: 'Đã ghi nhận thành công',
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

	function deposit(proName, id, money) {
		$('#walletName').val(proName);
		$('#walletId').val(id);
		$('#walletMoney').val(accounting.formatMoney(money));
		$('#walletMoneyString').html(coverMoneyToString(money) + ' Đồng');
		$('#btnWallet').addClass('btn-primary').removeClass('btn-danger');
		$('#walletTitle').html('Chấp nhận');
		
		var url = '{{ route("mng_wallet_request_deposit", ["id" => "transId"]) }}';
		url = url.replace('transId', id);
		$('#frmWallet').attr('action', url);
		
		$('#modalWallet').modal('show');
	}

	function reject(proName, id, money) {
		$('#walletName').val(proName);
		$('#walletId').val(id);
		$('#walletMoney').val(accounting.formatMoney(money));
		$('#walletMoneyString').html(coverMoneyToString(money) + ' Đồng');
		$('#btnWallet').addClass('btn-danger').removeClass('btn-primary');
		$('#walletTitle').html('Từ chối');
		
		var url = '{{ route("mng_wallet_reject_deposit", ["id" => "transId"]) }}';
		url = url.replace('transId', id);
		$('#frmWallet').attr('action', url);
		
		$('#modalWallet').modal('show');
	}
</script>
@endpush

@section('title') Yêu cầu rút tiền @endsection

@section('content')
<section class="content-body-full-page content-template-1">
	<div class="page-header hf-bg-gradient text-capitalize">Yêu cầu rút tiền</div>
	<div class="form-wrapper">
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-hover mng-list" width="100%">
					<thead>
						<tr>
							<th class="text-center">Tạo lúc</th>
							<th class="text-center">Ví</th>
							<th class="text-center" style="width: 150px">Số tiền</th>
							<th class="text-center" style="width: 150px">Trạng thái</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($walletRequests as $tran)
						<tr>
							<td class="text-center">
								<span class='hide'>{{ Carbon\Carbon::parse($tran->created_at)->format('YmdHi') }}</span>
								<div>{{ Carbon\Carbon::parse($tran->created_at)->format('d/m/Y H:i') }}</div>
							</td>
							<td>
								<div class="color-primary font-weight-600">{{ '#'.$tran->wallet_id.' '.$tran->walletInfo->name }}</div>
							</td>
							<td class="text-right price">{{ $tran->wallet }}</td>
							<td class="text-center">
								@if ($tran->excute_flg == '0')
								<span class="label label-warning">Chưa xử lý</span>
								@elseif ($tran->excute_flg == '1')
								<span class="label label-success">Chấp nhận</span>
								@elseif ($tran->excute_flg == '-')
								<span class="label label-danger">Từ chối</span>
								@endif
							</td>
							<td class="text-center">
								<div class="dropdown">
									<span class="btn btn-sm " data-toggle="dropdown">
									<i class="icmn-cog3"></i>
									</span>
									<ul class="dropdown-menu dropdown-menu-right" role="menu">
										<a class="dropdown-item disable"
											onclick="return deposit('{{$tran->walletInfo->name}}', '{{$tran->id}}', {{$tran->wallet}})">
											<i class="icmn-upload9"></i> Chấp nhận
										</a>
										<a class="dropdown-item"
											onclick="return reject('{{$tran->walletInfo->name}}', '{{$tran->id}}', {{$tran->wallet}})">
											<i class="icmn-backspace2"></i> Từ chối
										</a>
									</ul>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th colspan="3" class="text-right">Tổng tiền:</th>
							<th class="text-right color-primary"></th>
							<th>&nbsp;</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
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
								<input id="walletMoney" type="text" maxlength="20" class="form-control" readonly>
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
