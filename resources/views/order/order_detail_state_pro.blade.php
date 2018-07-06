<div style="margin-right:0; padding:0">
	@if (!$quotedPrice)
	<form class="quoted-form" id="frmQuotedPrice" name="form-validation" method="POST" action="{{ route('quote_price') }}">
		<input name="inpPrice" class="inp-quoted-price" value="100000" step="5000" min="100000" max="">
		<input name="price" class="basic-inp-quoted-price" type="hidden"/>
		<div class="padding-top-10 color-danger text-left" style="font-size: 13px">Giá trên là số tiền bạn thu của Khách</div>
		<div class="color-danger text-left" style="font-size: 13px">Tiền Chiết khấu trả cho Hand Free là <span id="spanCM" style="font-weight: bold">15.000 đ</span></div>
		<div class="padding-bottom-10 color-danger text-left" style="font-size: 13px">Doanh thu thực nhận của bạn là <span id="spanIC" style="font-weight: bold">85.000 đ</span></div>
		<div class="text-light padding-top-20 text-left" style="padding-left: 10px; display: none;">Vào lúc</div>
		<div class="padding-top-20">
		<textarea class="form-control" style="padding: 10px;" name="introduction" rows="6" maxlength="200" placeholder="Mô tả dịch vụ của bạn"></textarea>
		</div>
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
	</form>
	@elseif ($order->state == 0)
	<div class="common-text color-danger">Đã báo giá đơn hàng này</div>
	<div class="padding-10 text-center hf-card user-row">
		<div class="color-primary price" style="font-size: 26px; font-weight: bold;">{{ $quotedPrice->price }}</div>
		@if ($quotedPrice->est_excute_at_string)
		<div class="color-primary" style="font-size: 14px">{{ $quotedPrice->est_excute_at_string }}</div>
		@endif
	</div>
	@elseif ($order->state == 1)
	<h5 style="margin-bottom: 15px;">Thời gian chờ</h5>
	<div class="text-center">
		@include('order.countdown')
	</div>
	<div class="common-text" style="padding-top: 30px;">Báo giá thành công, đơn hàng đang chờ thực hiện</div>
	@elseif ($order->state == 2)
	<div class="common-text color-primary">Đơn hàng đang được thực hiện</div>
	@elseif ($order->state == 3)
	<div class="common-text color-success">Đơn hàng đã hoàn tất</div>
	@elseif ($order->state == 4)
	<div class="common-text color-danger">Đơn hàng đã hủy</div>
	@endif
</div>
