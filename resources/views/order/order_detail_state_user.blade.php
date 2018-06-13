<div style="margin-right:0; padding:0">
	@if ($order->state == 0 && $order->quoted_price_count == 0)
	<div style="background: url('{{ env('CDN_HOST') }}/img/order/NoQuote.svg') no-repeat center; height: 300px;">
	</div>
	@elseif ($order->state == 0 && $order->quoted_price_count > 0)
	<div class="row padding-top-20">
	<div class="col-md-12">
		@foreach ($order->quotedPrice as $quoted)
		<div class="orders-item hf-card">
		<div class="row flex">
			<div class="col-md-5 col-sm-5 col-xs-5 text-center">
			<div class="author-avt"><img src="{{ env('CDN_HOST') }}/u/{{ $quoted->pro->id }}/{{ $quoted->pro->avatar }}" /></div>
			</div>
			<div class="col-md-7 col-sm-7 col-xs-7">
			<div class="author-name margin-top-10">{{ $quoted->pro->name }}</div>
			<div class="author-rating">
				<select id="rating" class="rating" data-current-rating="{{ $quoted->pro->profile->rating }}">
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				</select>
			</div>
			<div>Báo giá: <span class="price text-danger">{{ $quoted->price }}</span></div>
			</div>
		</div>
		<div class="padding-20">
			<div class="message text-center">{{ $quoted->introduction }}</div>
		</div>
		<div class="text-center padding-top-15" style="border-top:solid 1px #e1e1e1">
			<a class="text-info" href="{{ route('order_pro_page', ['proId' => $quoted->pro_id]) }}">Xem hồ sơ đối tác</a>
		</div>
		</div>
		@endforeach
	</div>
	</div>
	@elseif ($order->state == 1)
	<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
			<h3>{{ Carbon\Carbon::parse($order->est_excute_at)->format('H:i') }}</h3>
			<progress class="progress progress-primary" value="75" max="100"></progress>
			</div>
		</div>
	</div>
	</div>
	@elseif ($order->state == 2)
	<div class="common-text color-primary">Đơn hàng đang được thực hiện</div>
	@elseif ($order->state == 3)
	<div class="common-text color-success">Đơn hàng đã hoàn tất</div>
	@elseif ($order->state == 4)
	<div class="common-text color-danger">Đơn hàng đã hủy</div>
	@endif
</div>
