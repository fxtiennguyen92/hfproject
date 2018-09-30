@extends('template.mng.index')
@push('stylesheets')
<style>
</style>

<!-- Page Scripts -->
<script>
	$(document).ready(function() {
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
			order: [[4, 'desc']],

			"footerCallback": function (row, data, start, end, display) {
				var api = this.api(), data;
				
				// Total over all pages
				total = api
					.column(3, { page: 'current'})
					.data()
					.reduce(function (a, b) {
						return accounting.unformat(a) + accounting.unformat(b);
					}, 0);
				
				$(api.column(3).footer()).html(accounting.formatMoney(total));
			}
		});
	});
</script>
@endpush

@section('title') Giao dịch Ví @endsection

@section('content')
<section class="content-body-full-page content-template-1">
	<div class="page-header hf-bg-gradient text-capitalize">Giao dịch Ví</div>
	<div class="form-wrapper">
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-hover mng-list" width="100%">
					<thead>
						<tr>
							<th class="text-center" style="width: 100px">No</th>
							<th class="text-center" style="width: 100px">Ví nhận</th>
							<th class="text-center">Ghi chú</th>
							<th class="text-center" style="width: 150px">Số tiền</th>
							<th class="text-center" style="width: 150px">Giao dịch</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($trans as $tran)
						<tr>
							<td class="text-center">
								<div class="font-weight-600">{{ '#'.sprintf('%06d', $tran->id) }}</div>
								@if ($tran->out_flg == '0')
								<div><span class="label label-success">Nhập</span></div>
								@else
								<span class="label label-danger">Xuất</span>
								@endif
							</td>
							<td class="">
								<div>{{ '#'.sprintf('%06d', $tran->wallet_id) }}</div>
								<div class="color-primary font-weight-600">{{ $tran->walletInfo->name }}</div>
							</td>
							<td>
								<div>{{ $tran->description }}</div>
							</td>
							<td class="text-right price font-weight-600">{{ ($tran->out_flg == '0') ? $tran->wallet : -$tran->wallet }}</td>
							<td class="text-center">
								<span class='hide'>{{ Carbon\Carbon::parse($tran->created_at)->format('YmdHi') }}</span>
								<div>{{ '#'.$tran->createdInfo->id.'-'.$tran->createdInfo->name }}</div>
								<div>{{ Carbon\Carbon::parse($tran->created_at)->format('d/m/Y H:i') }}</div>
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
</section>
@endsection
