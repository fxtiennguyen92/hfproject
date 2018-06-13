<div class="order-info hf-card" style="margin-right:0; padding:0">
  <div class="padding-20">
    <div class="flex">
      <div class="col-md-5 col-sm-5 col-xs-5 service-info text-center">
        <img class="avt" src="{{ env('CDN_HOST') }}/img/service/{{ $order->service->image }}">
        <label class="order-user">{{ $order->service->name }}</label>
      </div>
      <div class="col-md-7 col-sm-7 col-xs-7">
        <div class="order-code">#{{ $order->no }}</div>
        <div class="order-address"
          @if (!(isset($mode) && $mode == 'list'))
          onclick="window.open('https://www.google.com/maps/search/?api=1&query={{ $order->location }}', '_blank');"
          @endif
          title="{{ $order->address }}">
          <i class="material-icons">&#xE0C8;</i> {{ $order->address }}</div>
        <div class="order-state">
          @if ($order->est_excute_at_string)
          <span class="order-time state-est-time"><i class="material-icons">&#xE8B5;</i> {{ $order->est_excute_at_string }}</span> @else
          <span class="order-time state-now"><i class="material-icons">&#xE8B5;</i> Ngay lập tức</span> @endif
        </div>
      @if (auth()->user()->role != 1)
        @if ($order->state == 0 &&  $order->quoted_price_count == 0)
        <label class="margin-top-10 padding-10 label-outlined label label-danger margin-inline text-uppercase">Chờ báo giá</label>
        @elseif ($order->state == 0 && $order->quoted_price_count > 0)
        <label class="margin-top-10 padding-10 label-outlined label label-danger margin-inline text-uppercase">Có {{ $order->quoted_price_count }} báo giá</label>
        @elseif ($order->state == 1)
        <label class="margin-top-10 padding-10 label-outlined label label-info margin-inline text-uppercase">Đã chọn đối tác</label>
        @elseif ($order->state == 2)
        <label class="margin-top-10 padding-10 label-outlined label label-info margin-inline text-uppercase">Đang thực hiện</label>
        @elseif ($order->state == 3)
        <label class="margin-top-10 padding-10 label-outlined label label-success margin-inline text-uppercase">Hoàn thành</label>
        @elseif ($order->state == 4)
        <label class="margin-top-10 padding-10 label-outlined label label-default margin-inline text-uppercase">Đã hủy</label>
        @endif
      @elseif (!isset($dashboard))
        @if ($order->pro_id == auth()->user()->id)
          @if ($order->state == 1)
            <label class="margin-top-10 padding-10 label-outlined label label-info margin-inline text-uppercase">Thành công</label>
          @elseif ($order->state == 2)
            <label class="margin-top-10 padding-10 label-outlined label label-info margin-inline text-uppercase">Đang thực hiện</label>
          @elseif ($order->state == 3)
            <label class="margin-top-10 padding-10 label-outlined label label-success margin-inline text-uppercase">Hoàn thành</label>
          @elseif ($order->state == 4)
            <label class="margin-top-10 padding-10 label-outlined label label-default margin-inline text-uppercase">Đã hủy</label>
          @endif
        @else
          @if ($order->state == 0)
            @if ((isset($order->quoted) && $order->quoted == 0) || isset($quotedPrice))
            <label class="margin-top-10 padding-10 label-outlined label label-danger margin-inline text-uppercase">Đã báo giá</label>
            @else
            <label class="margin-top-10 padding-10 label-outlined label label-danger margin-inline text-uppercase">Chờ báo giá</label>
            @endif
          @else
            <label class="margin-top-10 padding-10 label-outlined label label-default margin-inline text-uppercase">Thất bại</label>
          @endif
        @endif
      @endif
      </div>
    </div>
  </div>
</div>
