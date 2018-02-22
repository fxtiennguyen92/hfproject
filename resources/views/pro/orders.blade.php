@extends('template.index') @push('stylesheets') @endpush
@section('title') @endsection @section('content')
<section class="page-content page-orders">
  <div class="page-content-inner">
    <div class="hf-wrapper">
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
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tabNew" role="tabpanel">
                @foreach ($newOrders as $order)
                <div class="col-md-6 col-sm-6 order-item-wrapper">
                  <div class="order-item">
                    <div class="row order-row" onclick="location.href='{{ route('pro_order_page', ['orderId' => $order->id]) }}'">
                      <div class="col-md-3 col-sm-4 col-sx-4">
                        <img class="avt" src="http://innovatik.payo-themes.com/wp-content/uploads/2017/11/lawn-team03.jpg" />
                      </div>
                      <div class="col-md-9 col-sm-8 col-sx-8">
                        <label class="order-user">{{ $order->user_name }}</label>
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
                        <div class="order-request-date col-md-12 col-sm-12 col-sx-12">
                          <span>Đã yêu cầu lúc {{ Carbon\Carbon::parse($order->created_at)->format('d-m-Y H:i') }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
              <div class="tab-pane" id="tabQuoted" role="tabpanel">
                @foreach ($quotedOrders as $q) @php $order = $q->order @endphp
                <div class="col-md-6 col-sm-6 order-item-wrapper">
                  <div class="order-item">
                    <div class="row order-row" onclick="location.href='{{ route('pro_order_page', ['orderId' => $order->id]) }}'">
                      <div class="col-md-3 col-sm-4 col-sx-4">
                        <img class="avt" src="http://innovatik.payo-themes.com/wp-content/uploads/2017/11/lawn-team03.jpg" />
                      </div>
                      <div class="col-md-9 col-sm-8 col-sx-8">
                        <label class="order-user">{{ $order->user_name }}</label>
                        <div class="order-address" title="{{ $order->address }}"><i class="material-icons">&#xE0C8;</i> {{ $order->address }}</div>
                        <div class="order-state">
                          @if ($order->est_excute_at_string)
                          <span class="order-time state-est-time"><i class="material-icons">&#xE855;</i> {{ $order->est_excute_at_string }}</span> @else
                          <span class="order-time state-now"><i class="material-icons">&#xE3E7;</i> Ngay lập tức</span> @endif
                        </div>
                      </div>
                      <div class="row">
                        <div class="order-req col-md-12 col-sm-12 col-sx-12">
                          @if (strlen($order->short_requirements) > 175)
                          <span>{{ substr($order->short_requirements, 0, 150).'...' }}</span> @else
                          <span>{{ $order->short_requirements }}</span> @endif
                        </div>
                      </div>
                      <div class="row">
                        <div class="order-request-date col-md-12 col-sm-12 col-sx-12">
                          <span>Đã yêu cầu lúc {{ Carbon\Carbon::parse($order->created_at)->format('d-m-Y H:i') }}</span>
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
