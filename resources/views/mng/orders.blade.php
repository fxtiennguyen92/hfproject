@extends('template.index')
@push('stylesheets')
<style>
</style>

<!-- Page Scripts -->
<script>
	$(document).ready(function() {
		@if (session('error') && session('error') == 400)
			swal({
				title: 'Thất bại',
				text: 'Đơn hàng này không tồn tại!',
				type: 'error',
				confirmButtonClass: 'btn-default',
				confirmButtonText: 'Quay lại',
			});
		@elseif (session('error'))
			swal({
				title: 'Thất bại',
				text: '{{ session("error") }}',
				type: 'error',
				confirmButtonClass: 'btn-default',
				confirmButtonText: 'Quay lại',
			});
		@endif
		
		$('.mng-list').DataTable({
			responsive: true,
			info: false,
			paging: false,
			language: {
				zeroRecords: 'Chưa có thông tin',
				search: 'Tìm kiếm'
			},
			order: [[4, 'desc']],
			columnDefs: [ { orderable: false, targets: [6] } ]
		});

		$('a.cancel').on('click', function(e) {
			e.preventDefault();
			var orderNo = $(this).attr('order');
			swal({
				title: 'Đơn hàng #' + orderNo,
				text: 'Bạn muốn hủy đơn hàng này?',
				type: 'warning',
				showCancelButton: true,
				cancelButtonClass: 'btn-default',
				confirmButtonClass: 'btn-danger',
				cancelButtonText: 'Quay lại',
				confirmButtonText: 'Hủy đơn hàng',
			},
			function() {
				var url = '{{ route("mng_cancel_order", ["orderNo" => "orderNo"]) }}';
				url = url.replace('orderNo', orderNo);

				$('#frmMain').attr('action', url);
				$('#frmMain').submit();
			});
		});
	});
</script>
@endpush

@section('title') Đơn hàng @endsection

@section('content')
<section class="content-body-full-page content-template-1">
	<div class="page-header hf-bg-gradient text-capitalize">Đơn hàng</div>
	<div class="form-wrapper">
		<div class="row">
			<div class="col-md-12">
				<table class="table table-hover nowrap mng-list" width="100%">
					<thead>
						<tr>
							<th class="text-center">Mã</th>
							<th class="">Dịch vụ</th>
							<th class="text-center">Khách hàng</th>
							<th class="text-center">Đối tác</th>
							<th class="text-center">Ngày đăng</th>
							<th class="text-center">Trạng thái</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($orders as $order)
						<tr>
							<td class="text-center col-order-no">{{ '#'.$order->no }}</td>
							<td class="">{{ $order->service->name }}</td>
							<td class="text-capitalize col-cus-info">
								<div class="cus-name">{{ $order->user->name }}</div>
								<div class="cus-email">{{ $order->user->email }}</div>
							</td>
							<td class="text-capitalize col-pro-info">
								@if (isset($order->pro))
								<div class="pro-name">{{ $order->pro->name }}</div>
								<div class="pro-email">{{ $order->pro->email }}</div>
								@else ---
								@endif
							</td>
							<td class="text-center">
								{{ Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}
							</td>
							<td class="text-center col-label-order-state">
								@if ($order->state == 0)
									<span class="label label-info">New</span>
								@elseif ($order->state == '1')
									<span class="label label-warning">Accepted</span>
								@elseif ($order->state == '2')
									<span class="label label-default">Processing</span>
								@elseif ($order->state == '3')
									<span class="label label-primary">Complete</span>
								@elseif ($order->state == '4')
									<span class="label label-danger">Cancel</span>
								@endif
							</td>
							<td>
								<div class="dropdown pull-right">
									<span class="btn btn-sm " data-toggle="dropdown">
									<i class="icmn-cog3"></i>
									</span>
									<ul class="dropdown-menu dropdown-menu-right" role="menu">
										<a class="dropdown-item view" href="javascript:void(0);">
											<i class="icmn-grid6"></i> Chi tiết
										</a>
										@if ($order->state != '4')
										<a class="dropdown-item cancel" href="javascript:void(0);" order="{{ $order->no }}">
											<i class="icmn-bin"></i> Hủy
										</a>
										@endif
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
	<!-- MODAL -->
</section>
@endsection
