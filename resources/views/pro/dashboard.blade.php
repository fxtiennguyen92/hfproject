@extends('template.index') @push('stylesheets')
<script>
</script>
@endpush @section('title') Đơn hàng mới @endsection @section('content')
<section class="content-body has-bottom-menu">
  <div class="page-header hf-bg-gradient text-capitalize">Đơn hàng mới</div>
  <div class="nav-tabs-horizontal orders-page">
    <div class="tab-content">
      <div class="tab-pane active" id="newTab" role="tabpanel" aria-expanded="true">
        <div class="row">
          @if (sizeof($orders) == 0)
            <div class="common-text">Chưa có đơn hàng nào</div>
          @endif
          @php $mode = 'list'; $dashboard = true @endphp
          @foreach ($orders as $order)
          <div class="col-md-12 col-sm-12 active-order" onclick="location.href='{{ route('pro_order_page', ['orderId' => $order->id]) }}'">
            @include('order.order_detail_tag')
          </div>
          @endforeach
        </div>
      </div>
      <div class="tab-pane" id="quotedTab" role="tabpanel" aria-expanded="false">
        <div class="row">
            <div class="common-text">Không có đơn hàng nào</div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@include('template.mb.footer-menu')
