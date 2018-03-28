<div class="order-info hf-card" style="margin-right:0; padding:0">
  <div class="padding-20">
    <div class="flex">
      <div class="col-md-5 col-sm-5 col-xs-5 service-info text-center">
        <img class="avt" src="{{ env('CDN_HOST') }}/img/service/{{ $order->service->id }}.svg">
        <label class="order-user">{{ $order->service->name }}</label>
      </div>
      <div class="col-md-7 col-sm-7 col-xs-7">
        <div class="order-code">@if (!is_null($order->no)) #{{ $order->no }} @else Đơn hàng chưa xác nhận @endif</div>
        <div class="order-address" title="{{ $order->address }}"><i class="material-icons">&#xE0C8;</i> {{ $order->address }}</div>
        <div class="order-state">
          @if ($order->est_excute_at_string)
          <span class="order-time state-est-time"><i class="material-icons">&#xE855;</i> {{ $order->est_excute_at_string }}</span> @else
          <span class="order-time state-now"><i class="material-icons">&#xE3E7;</i> Ngay lập tức</span> @endif
        </div>
        @if (is_null($order->no))
        <label class="margin-top-10 padding-10 label-outlined label label-default margin-inline text-uppercase">Chờ xác nhận</label>
        @elseif ($order->state == 0 &&  $order->quoted_price_count == 0)
        <label class="margin-top-10 padding-10 label-outlined label label-danger margin-inline text-uppercase">Chờ báo giá</label>
        @elseif ($order->state == 0 && $order->quoted_price_count > 0)
        <label class="margin-top-10 padding-10 label-outlined label label-danger margin-inline text-uppercase">Có {{ $order->quoted_price_count }} báo giá</label>
        @elseif ($order->state == 1)
        <label class="margin-top-10 padding-10 label-outlined label label-info margin-inline text-uppercase">Đang thực hiện</label>
        @elseif ($order->state == 2)
        <label class="margin-top-10 padding-10 label-outlined label label-success margin-inline text-uppercase">Hoàn thành</label>
        @elseif ($order->state == 3)
        <label class="margin-top-10 padding-10 label-outlined label label-danger margin-inline text-uppercase">Đã hủy</label>
        @endif
      </div>
    </div>
  </div>
</div>
