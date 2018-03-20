<div class="order-info hf-card margin-bottom-20" style="margin-right:0; padding:0">
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
        <label class="margin-top-10 padding-10 label-outlined label label-default margin-inline text-uppercase">Chờ xác nhận</label> @else
        <label class="margin-top-10 padding-10 label-outlined label label-danger margin-inline text-uppercase">Chờ báo giá</label> @endif
      </div>
    </div>
    <div id="showLessContent" class="content-detail text-center">{{ $order->short_requirements }}</div>
  </div>
  <div class="text-center">
    <button type="button" id="toggleContent" class=" btn btn-squared btn-default btn-block ">Xem thêm Chi tiết đơn hàng</button>
  </div>
</div>
