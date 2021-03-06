@extends('template.index') @push('stylesheets')
<script>
  $(document).ready(function() {
    $('.price').each(function() {
      $(this).html(accounting.formatMoney($(this).html()));
    });
  });
</script>
@endpush @section('title') Đơn hàng @endsection @section('content')
<section class="content-body has-bottom-menu">
  <div class="page-header hf-bg-gradient text-capitalize">Đơn hàng</div>
  <div class="nav-tabs-horizontal orders-page">
    <ul class="nav nav-tabs nav-page hf-bg-gradient text-uppercase" role="tablist">
      <li class="nav-item">
        <a class="nav-link active pull-right" href="javascript: void(0);" data-toggle="tab" data-target="#quotedTab" role="tab" aria-expanded="true">Đã nhận</a>
      </li>
      <li class="nav-item">
        <a class="nav-link right pull-left" href="javascript: void(0);" data-toggle="tab" data-target="#notiTab" role="tab" aria-expanded="false">Thông báo</a>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="quotedTab" role="tabpanel" aria-expanded="false">
        <div class="row">
          @if (sizeof($quotedOrders) == 0)
            <div class="common-text">Không có đơn hàng nào</div>
          @else
          @foreach ($quotedOrders as $quotedPrice)
            @php $order = $quotedPrice->order; $order->quoted = $quotedPrice->state; $order->quoted_price = $quotedPrice->price @endphp
            @if ($order->pro_id != auth()->user()->id && $order->state != 0)
          <div class="col-md-12 col-sm-12 fail-order">
            @else
          <div class="col-md-12 col-sm-12 active-order" onclick="location.href='{{ route('pro_order_page', ['orderId' => $order->id]) }}'">
            @endif
            @include('order.order_detail_tag')
          </div>
          @endforeach
          @endif
        </div>
      </div>
      <div class="tab-pane" id="notiTab" role="tabpanel" aria-expanded="false">
        <div class="row">
          <div class="common-text">Chưa có thông báo</div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@include('template.mb.footer-menu')
