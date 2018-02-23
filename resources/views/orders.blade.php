@extends('template.index') @push('stylesheets')
<script>
  $(document).ready(function() {});
</script>
@endpush @section('title') @endsection @section('content')
<section class="page-content page-orders">
  <div class="page-content-inner">
    <div class="hf-wrapper">
      @foreach ($processingOrders as $order)
      <div class="col-md-12 col-sm-12 col-sx-12 order-item-wrapper">
        <div class="order-item row">
          <div class="col-md-4 col-sm-4 col-sx-4">
            <div class="row order-row">
              <img class="avt" src="http://innovatik.payo-themes.com/wp-content/uploads/2017/11/lawn-team03.jpg" />
              <label class="order-user">{{ $order->pro->name }}</label>
              <div class="order-address"><i class="material-icons">&#xE0C8;</i> {{ $order->address }}</div>
              <span class="order-address"><i class="material-icons">&#xE0CD;</i> {{ $order->pro->phone }}</span>
            </div>
          </div>
          <div class="col-md-6 col-sm-6 col-sx-6">
            <label>CHI TIẾT ĐƠN HÀNG</label>
            <div class="row order-row">
              <div class="col-md-12 col-sm-12 col-sx-12">
                <div>Địa chỉ: {{ $order->address }}</div>
                <div>Thời gian dự kiến: {{ $order->est_excute_at }}</div>
                <div>Tổng tiền: {{ $order->total_price }}</div>
              </div>
              <div class="col-md-12 col-sm-12 col-sx-12">
                <div class="cui-wizard-order cui-wizard" start-step="2">
                  <h3><i class="material-icons cui-wizard--steps--icon">&#xE24D;</i> <span class="cui-wizard--steps--title">Đơn hàng</span></h3>
                  <h3><i class="material-icons cui-wizard--steps--icon">&#xE91F;</i> <span class="cui-wizard--steps--title">Báo giá</span></h3>
                  <h3><i class="material-icons cui-wizard--steps--icon">&#xE913;</i> <span class="cui-wizard--steps--title">Thực hiện</span></h3>
                  <h3><i class="material-icons cui-wizard--steps--icon">&#xE8DC;</i> <span class="cui-wizard--steps--title">Hoàn thành</span></h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
      <div class="orders col-md-12 col-sm-12 col-sx-12">
        <div class="margin-bottom-50">
          <div class="nav-tabs-horizontal">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" href="javascript: void(0);" data-toggle="tab" data-target="#tabNew" role="tab">Đơn hàng</a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tabNew" role="tabpanel">
                @foreach ($newOrders as $order)
                <div class="col-md-6 col-sm-6 order-item-wrapper">
                  <div class="order-item">
                    <div class="row order-row" onclick="location.href='{{ route('order_page', ['orderId' => $order->id]) }}'">
                      <div class="col-md-3 col-sm-4 col-sx-4">
                        <img class="avt" src="img/service/{{ $order->service_id }}.svg" />
                      </div>
                      <div class="col-md-9 col-sm-8 col-sx-8">
                        <label class="order-user">{{ $order->service->name }}</label>
                        <div class="order-address"><i class="material-icons">&#xE0C8;</i> {{ $order->address }}</div>
                        <div class="order-state">
                          @if ($order->est_excute_at_string)
                          <span class="order-time state-est-time"><i class="material-icons">&#xE855;</i> {{ $order->est_excute_at_string }}</span> @else
                          <span class="order-time state-now"><i class="material-icons">&#xE3E7;</i> Ngay lập tức</span> @endif
                        </div>
                      </div>
                      <div class="row">
                        <div class="order-req col-md-12 col-sm-12 col-sx-12">
                          @if (strlen($order->short_requirements) > 100)
                          <span>{{ substr($order->short_requirements, 0, 100).'...' }}</span> @else
                          <span>{{ $order->short_requirements }}</span> @endif
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-8 col-sm-8 col-sx-8 order-quoted-price">
                          @if ($order->quoted_price_count > 0)
                          <span class="quoted"><i class="material-icons">&#xE91F;</i> Đang có {{ $order->quoted_price_count }} báo giá</span> @else
                          <span><i class="material-icons">&#xE91F;</i> Chưa có báo giá</span> @endif
                        </div>
                        <div class="col-md-4 col-sm-4 col-sx-4 order-cancel">
                          <a><i class="material-icons">&#xE14C;</i> Hủy đơn</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection