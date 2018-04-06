@extends('template.index') @push('stylesheets')
<script>
</script>
@endpush @section('title') Đơn hàng @endsection @section('content')
<section class="content-body has-bottom-menu">
  <div class="page-header hf-bg-gradient text-capitalize">Đơn hàng</div>
  <div class="nav-tabs-horizontal orders-page">
    <ul class="nav nav-tabs nav-page hf-bg-gradient text-uppercase" role="tablist">
      <li class="nav-item">
        <a class="nav-link active pull-right" href="javascript: void(0);" data-toggle="tab" data-target="#listTab" role="tab" aria-expanded="true">Danh sách</a>
      </li>
      <li class="nav-item">
        <a class="nav-link right pull-left" href="javascript: void(0);" data-toggle="tab" data-target="#notiTab" role="tab" aria-expanded="false">Thông báo</a>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="listTab" role="tabpanel" aria-expanded="true">
        <h3 class="padding-top-10">Hiện tại</h3>
        <div class="row">
          @if (sizeof($currentOrders) == 0)
            <div class="common-text">Không có đơn hàng nào</div>
          @endif
          @foreach ($currentOrders as $order)
          <div class="col-md-12 col-sm-12" onclick="location.href='{{ route('order_page', ['orderId' => $order->id]) }}'">
            @include('order.order_detail_tag')
          </div>
          @endforeach
        </div>
        
        <h3 class="padding-top-10">Lịch sử</h3>
        <div class="row">
          <div class="common-text">Chưa có lịch sử đơn hàng</div>
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