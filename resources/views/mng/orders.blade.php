@extends('template.mng.index')
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
		
		$('.mng-list').DataTable({
			responsive: true,
			info: false,
			paging: false,
			language: {
				zeroRecords: 'Chưa có thông tin',
				search: 'Tìm kiếm'
			},
			order: [[5, 'desc']],
			columnDefs: [ { orderable: false, targets: [7] } ]
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
	<div class="margin-30 mng-report">
		<form method="get" action="{{ route('mng_order_list') }}">
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
		@if (sizeof($orderCountReport) > 0)
		<h5 class="margin-top-20">Số lượng Đơn hàng</h5>
		<div id="reportCarousel" class="owl-carousel owl-theme">
			@foreach ($orderCountReport as $item)
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
		@if (sizeof($orderValueReport) > 0)
		<h5 class="margin-top-20">Giá trị Đơn hàng (VNĐ)</h5>
		<div id="reportCarousel" class="owl-carousel owl-theme">
			@foreach ($orderValueReport as $item)
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
			<div class="col-md-12">
				<table class="table table-hover mng-list" width="100%">
					<thead>
						<tr>
							<th class="text-center">Mã</th>
							<th class="text-center">Khách hàng</th>
							<th class="text-center">Đối tác</th>
							<th class="text-center">Địa điểm - Thời gian</th>
							<th class="text-center" style="width: 100px">Giá</th>
							<th class="text-center">T.gian</th>
							<th class="text-center">T.thái</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($orders as $order)
						<tr>
							<td class="">
								<div class="col-order-no">{{ '#'.$order->no }}</div>
								<div class="col-service" style="font-size: 10px">{{ $order->service->name }}</div>
							</td>
							<td class="text-capitalize col-cus-info">
								<div class="cus-name">{{ $order->user->name }}</div>
								<div class="cus-email" style="font-size: 10px">{{ $order->user->email }}</div>
							</td>
							<td class="text-capitalize col-pro-info">
								@if (isset($order->pro))
								<div class="pro-name" style="white-space: nowrap;">{{ $order->pro->name }}</div>
								<div class="pro-email" style="font-size: 10px">{{ $order->pro->email }}</div>
								@else ---
								@endif
							</td>
							<td>
								<div class="order-address" title="{{ $order->address }}">
									<i class="material-icons">&#xE0C8;</i> {{ $order->address }}
								</div>
								<div class="order-state">
									@if ($order->est_excute_at_string)
									<span class="order-time state-est-time"><i class="material-icons">&#xE8B5;</i> {{ $order->est_excute_at_string }}</span> @else
									<span class="order-time state-now"><i class="material-icons">&#xE8B5;</i> Ngay lập tức</span> @endif
								</div>
							</td>
							<td class="text-right col-order-price">
								@if ($order->state != 0 && $order->state != 4)
								<span class="price text-danger">{{ $order->total_price }}</span>
								@endif
							</td>
							<td class="text-right col-order-created-date" style="font-size: 10px">
								<span class='hide'>{{ Carbon\Carbon::parse($order->created_at)->format('YmdHi') }}</span>
								<div>{{ Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</div>
								<div>{{ Carbon\Carbon::parse($order->created_at)->format('H:i') }}</div>
							</td>
							<td class="text-center col-label-order-state">
								@if ($order->state == 0)
									<span class="label label-success">New</span>
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
