<div class="order-info hf-card margin-bottom-20 margin-top-20" style="margin-right:0; padding:0">
  <div class="padding-20">
    <div class="flex">
      <div class="col-md-5 col-sm-5 col-xs-5 service-info text-center">
        <img class="avt" src="{{ env('CDN_HOST') }}/img/service/{{ $order->service->id }}.svg">
        <label class="order-user">{{ $order->service->name }}</label>
      </div>
      <div class="col-md-7 col-sm-7 col-xs-7">
        <div class="order-code">@if (!is_null($order->no)) Mã #{{ $order->no }} @else Đơn hàng mới @endif</div>
        <div class="order-address" title="{{ $order->address }}"><i class="material-icons">&#xE0C8;</i> {{ $order->address }}</div>
        <div class="order-state">
          @if ($order->est_excute_at_string)
          <span class="order-time state-est-time"><i class="material-icons">&#xE855;</i> {{ $order->est_excute_at_string }}</span> @else
          <span class="order-time state-now"><i class="material-icons">&#xE3E7;</i> Ngay lập tức</span> @endif
        </div>
        @if (is_null($order->no))
        <label class="margin-top-10 padding-10 label-outlined label label-default margin-inline text-uppercase">Chờ xác nhận</label>
        @elseif ($order->state == 0 && sizeof($order->quotedPrice) == 0)
        <label class="margin-top-10 padding-10 label-outlined label label-danger margin-inline text-uppercase">Chờ báo giá</label>
        @elseif ($order->state == 0 && sizeof($order->quotedPrice) > 0)
        <label class="margin-top-10 padding-10 label-outlined label label-danger margin-inline text-uppercase">Có {{ sizeof($order->quotedPrice) }} báo giá</label>
        @endif
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
    <div class="col-md-7 col-sm-7 col-xs-7 text-left">
      @if ($order->state == 0 && $order->quoted_price_count == 0 && !is_null($order->no))
        <h5 class="margin-0">Các đối tác sẽ báo giá trong ít phút</h5>
      @elseif ($order->state == 0 && $order->quoted_price_count > 0)
        @if ($order->quoted_price_count <= 2)
          @foreach ($order->quotedPrice as $quoted)
          <a href="#" title="{{ $quoted->pro->name }}"><img style="border-radius:100%" class="pro-avt" src="{{ env('CDN_HOST') }}/u/{{ $quoted->pro->id }}/{{ $quoted->pro->avatar }}"></a>
          <a class="order-more" href="#">+{{ sizeof($order->quotedPrice) }}</a>
          @endforeach
        @else
          <a class="order-more" href="#">+{{ sizeof($order->quotedPrice) }}</a>
        @endif
      @endif
    </div>
    <div class="col-md-5 col-sm-5 col-xs-5 text-right">
      @if (is_null($order->no))
      <button type="button" class="btn btn-squared btn-primary margin-inline text-uppercase">Xác nhận</button>
      @elseif ($order->state == 0 && $order->quoted_price_count == 0)
      <button type="button" class="btn btn-squared btn-default-outline margin-inline text-uppercase">Hủy</button>
      @elseif ($order->state == 0 && $order->quoted_price_count > 0)
      <button type="button" class="btn btn-squared btn-default-outline margin-inline text-uppercase">Hủy</button>
      <button type="button" class="btn btn-squared btn-primary margin-inline text-uppercase">Xem báo giá</button>
      @elseif ($order->state == 1)
      <button type="button" class="btn btn-squared btn-primary margin-inline text-uppercase">Xem chi tiết</button>
      @endif
    </div>
  </div>
</div>
