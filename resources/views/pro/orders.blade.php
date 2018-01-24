@extends('template.index')

@push('stylesheets')
	<link rel="stylesheet" type="text/css" href="css/donhang.css">
@endpush

@section('title')

@endsection

@section('content')
<section class="page-content">
	<div class="orders col-md-12 col-sm-12 col-sx-12">
		<div class="margin-bottom-50">
			<div class="nav-tabs-horizontal">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" href="javascript: void(0);" data-toggle="tab" data-target="#tabNew" role="tab">Đơn hàng mới</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="javascript: void(0);" data-toggle="tab" data-target="#tabQuoted" role="tab">Đã báo giá </a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="javascript: void(0);" data-toggle="tab" data-target="#tabComplete" role="tab">Lịch sử</a>
					</li>
				</ul>
				<div class="tab-content padding-vertical-20">
					<div class="tab-pane active" id="tabNew" role="tabpanel">
						@foreach ($newOrders as $order)
						<div class="row order-row" onclick="location.href='{{ route('view_pro_order', ['orderId' => $order->id]) }}'">
							<div class="order-info col-md-10 col-sm-10 col-sx-10">
								<label>{{ $order->user_name }}</label>
								<div class="order-req">
									{{ $order->short_requirements }}
								</div>
								<p><span class="icmn-location"></span> {{ $order->address }}</p>
							</div>
							<div class="order-state col-md-2 col-sm-2 col-sx-2">
								@if ($order->time_state == '0')
								<span class="state-now">Ngay lập tức</span>
								@else
								<span class="state-confirm">Hẹn thời gian</span>
								@endif
							</div>
						</div>
						@endforeach
					</div>
					<div class="tab-pane" id="tabQuoted" role="tabpanel">
						@foreach ($quotedOrders as $order)
						<div class="row order-row" onclick="location.href='{{ route('view_pro_order', ['orderId' => $order->id]) }}'">
							<div class="order-info col-md-10 col-sm-10 col-sx-10">
								<label>{{ $order->user_name }}</label>
								<div class="order-req">
									{{ $order->short_requirements }}
								</div>
								<p><span class="icmn-location"></span> {{ $order->address }}</p>
							</div>
							<div class="order-state col-md-2 col-sm-2 col-sx-2">
								@if ($order->time_state == '0')
								<span class="state-now">Ngay lập tức</span>
								@else
								<span class="state-confirm">Hẹn thời gian</span>
								@endif
							</div>
						</div>
						@endforeach
					</div>
					<div class="tab-pane" id="tabComplete" role="tabpanel">
						@foreach ($newOrders as $order)
						<div class="row order-row" onclick="location.href='{{ route('view_pro_order', ['orderId' => $order->id]) }}'">
							<div class="order-info col-md-10 col-sm-10 col-sx-10">
								<label>{{ $order->user_name }}</label>
								<div class="order-req">
									{{ $order->short_requirements }}
								</div>
								<p><span class="icmn-location"></span> {{ $order->address }}</p>
							</div>
							<div class="order-state col-md-2 col-sm-2 col-sx-2">
								@if ($order->time_state == '0')
								<span class="state-now">Ngay lập tức</span>
								@else
								<span class="state-confirm">Hẹn thời gian</span>
								@endif
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection