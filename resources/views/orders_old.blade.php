@extends('template.index') @push('stylesheets')
<script>

function cancel(orderId) {
    swal({
        title: 'Hủy đơn hàng',
        text: 'Bạn muốn hủy đơn hàng này',
        type: 'warning',
        showCancelButton: true,
        cancelButtonClass: 'btn-default',
        cancelButtonText: 'Quay lại',
        confirmButtonClass: 'btn-danger',
        confirmButtonText: 'Hủy',
    },
    function() {
      var url = "{{ route('cancel_order', ['orderId' => 'cancelOrderId']) }}";
      url = url.replace('cancelOrderId', orderId);
      
      $.ajax({
        type: 'POST',
        url: url,
        data: $('#frmMain').serialize(),
        success: function(response) {
            location.href = '{{ route("order_list_page") }}';
        },
        error: function(xhr) {
            $.notify({
              title: '<strong>Thất bại! </strong>',
              message: 'Có lỗi phát sinh, xin thử lại.'
            }, {
              type: 'danger',
            });
            setTimeout(function() {
              location.reload();
            }, 2500);
        }
      });
    });
}
</script>
@endpush
@section('title') Đơn hàng @endsection
@section('content')
<section class="page-content page-orders">
  <div class="page-content-inner">
    @foreach ($processingOrders as $order)
    <div class="col-md-12 col-sm-12 col-xs-12 order-item-wrapper pro-order">
      <div class="order-item row" style="margin-top:0">
        <div class="col-md-4 col-sm-4 pro-info">
          <div class="row order-row text-center">
            <img class="avt pro-avt" src="http://innovatik.payo-themes.com/wp-content/uploads/2017/11/lawn-team03.jpg" />
            <label class="order-user">{{ $order->pro->name }}</label>
            <div>
              <select class="rating" data-current-rating="{{ $order->pro_profile->rating }}">
                  <option value=""></option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
            </div>
          </div>
          <div class="row pro-des">
            <div class="order-address"><i class="material-icons">&#xE0C8;</i> {{ $order->address }}</div>
            <span class="order-address"><i class="material-icons">&#xE0CD;</i> {{ $order->pro->phone }}</span>
          </div>
        </div>
        <div class="col-md-8 col-sm-8 pro-content">
          <h3 class="heading">CHI TIẾT ĐƠN HÀNG</h3>
          <div class="row order-row">
            <div class="col-md-12 col-sm-12 col-xs-12 detail">
              <div class="row">
                <div class="col-md-4">
                  <span>Địa chỉ:</span>
                </div>
                <div class="col-md-8">
                  <div class="under-line">{{ $order->address }}</div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <span>Thời gian dự kiến:</span>
                </div>
                <div class="col-md-8">
                  <div class="under-line">{{ $order->est_excute_at }}</div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <span>Tổng tiền:</span>
                </div>
                <div class="col-md-8">
                  <div class="under-line">{{ $order->total_price }}</div>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
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
  </div>

  <div class="page-content-inner">
    <div class="hf-wrapper">
      <div class="orders col-md-12 col-sm-12 col-xs-12">
        <div class="margin-bottom-50">
          <div class="nav-tabs-horizontal">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" href="javascript: void(0);" data-toggle="tab" data-target="#tabNew" role="tab">Đơn hàng</a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tabNew" role="tabpanel">
                @if (sizeof($newOrders) == 0)
                <div class="common-text">Không có đơn hàng nào</div>
                @endif

                @foreach ($newOrders as $order)
                <div class="col-md-4 col-sm-6 order-item-wrapper">
                  <div class="order-item">
                    @if ($order->quoted_price_count == 0)
                    <div class="top-btn-order">
                      Chờ báo giá
                    </div>
                    @else
                    <div class="top-btn-quoted-order badge" data-badge="{{ $order->quoted_price_count }}">
                      Có báo giá
                    </div>
                    @endif
                    <div class="row order-row" onclick="location.href='{{ route('order_page', ['orderId' => $order->id]) }}'">
                      <div class="col-md-3 col-sm-4">
                        <img class="avt" src="img/service/{{ $order->service_id }}.svg" />
                      </div>
                      <div class="col-md-9 col-sm-8">
                        <label class="order-service">{{ $order->service->name }}</label>
                        <div class="order-address"><i class="material-icons">&#xE0C8;</i> {{ $order->address }}</div>
                        <div class="order-state">
                          @if ($order->est_excute_at_string)
                          <span class="order-time state-est-time"><i class="material-icons">&#xE855;</i> {{ $order->est_excute_at_string }}</span> @else
                          <span class="order-time state-now"><i class="material-icons">&#xE3E7;</i> Ngay lập tức</span> @endif
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="order-req col-md-12 col-sm-12 col-xs-12">
                        @if (strlen($order->short_requirements) > 100)
                        <span>{{ substr($order->short_requirements, 0, 100).'...' }}</span> @else
                        <span>{{ $order->short_requirements }}</span> @endif
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-8 col-sm-8 col-xs-8">
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-4 order-cancel">
                        <a href="javascript: void(0);" onclick="cancel({{ $order->id }})"><i class="material-icons">&#xE14C;</i> Hủy</a>
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
  <form id="frmMain" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
  </form>
</section>
@endsection