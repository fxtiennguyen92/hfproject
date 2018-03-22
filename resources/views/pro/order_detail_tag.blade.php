<div class="order-info hf-card margin-bottom-20 margin-top-20" style="margin-right:0; padding:0">
  <div class="padding-20">
    <div class="flex">
      <div class="col-md-5 col-sm-5 col-xs-5 service-info text-center">
        <img class="avt" style="border-radius: 100%" src="{{ env('CDN_HOST') }}/u/{{ $order->user->id }}/{{ $order->user->avatar }}">
        <label class="order-user">{{ $order->user->name }}</label>
      </div>
      <div class="col-md-7 col-sm-7 col-xs-7">
        <div class="order-code">@if (!is_null($order->no)) Mã #{{ $order->no }} @else Đơn hàng mới @endif</div>
        <div class="order-service-content"><i class="material-icons">&#xE869;</i> {{ $order->service->name }}</div>
        <div class="order-address" title="{{ $order->address }}"><i class="material-icons">&#xE0C8;</i> {{ $order->address }}</div>
        <div class="order-state">
          @if ($order->est_excute_at_string)
          <span class="order-time state-est-time"><i class="material-icons">&#xE855;</i> {{ $order->est_excute_at_string }}</span> @else
          <span class="order-time state-now"><i class="material-icons">&#xE3E7;</i> Ngay lập tức</span> @endif
        </div>
      </div>
    </div>
    <div toggle="showLessContent" class="content-detail text-center">{{ $order->short_requirements }}</div>
  </div>
  <div class="text-center">
    <button type="button" toggle="toggleContent" class=" btn btn-squared btn-default btn-block ">Xem thêm Chi tiết đơn hàng</button>
  </div>
  @if ($order->state != 0)
  <div class="flex padding-20" style="border-top:solid 1px #e1e1e1; min-height: 100px;">
    
  </div>
  @endif
  <div class="flex padding-bottom-15 padding-20" style="border-top:solid 1px #e1e1e1; min-height: 90px;">
    <div class="col-md-6 col-sm-6 col-xs-6 text-left">
      @if (isset($order->quoted))
      <span class="price quoted-price-content">{{ $order->quoted_price }}</span>
      @endif
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 text-right">
      @if (isset($order->quoted))
        @if ($order->quoted == 0)
      <button type="button" class="btn btn-squared btn-danger-outline margin-inline text-uppercase"
        onclick="location.href='{{ route('pro_order_page', ['orderId' => $order->id]) }}'">Đã báo giá</button>
        @elseif ($order->quoted == 1)
      <button type="button" class="btn btn-squared btn-primary-outline margin-inline text-uppercase"
        onclick="location.href='{{ route('pro_order_page', ['orderId' => $order->id]) }}'">Đang thực hiện</button>
        @elseif ($order->quoted == 2)
      <button type="button" class="btn btn-squared btn-default-outline margin-inline text-uppercase"
        onclick="location.href='{{ route('pro_order_page', ['orderId' => $order->id]) }}'">Thất bại</button>
        @endif
      @else
      <button type="button" class="btn btn-squared btn-primary margin-inline text-uppercase"
        onclick="location.href='{{ route('pro_order_page', ['orderId' => $order->id]) }}'">Báo giá</button>
      @endif
    </div>
  </div>
</div>