@extends('template.index') @push('stylesheets')
<script>
</script>
@endpush @section('title') Quản lý đơn hàng @endsection @section('content')
<section class="orders-content-body">
  <div class="nav-tabs-horizontal orders-page">
    <ul class="nav nav-tabs nav-page" role="tablist">
      <li class="nav-item">
        <a class="nav-link active pull-right" href="javascript: void(0);" data-toggle="tab" data-target="#current" role="tab" aria-expanded="true">Hiện tại</a>
      </li>
      <li class="nav-item">
        <a class="nav-link right pull-left" href="javascript: void(0);" data-toggle="tab" data-target="#history" role="tab" aria-expanded="false">Lịch sử</a>
      </li>
    </ul>
    <div class="tab-content content-width-700" style="margin:auto;">
      <div class="tab-pane active" id="current" role="tabpanel" aria-expanded="true">
        <div class="row">
          @if (sizeof($currentOrders) == 0)
            <div class="common-text">Không có đơn hàng nào</div>
          @endif
          @foreach ($currentOrders as $order)
          <div class="col-md-12 col-sm-12">
            @include('template.order_detail_tag')
          </div>
          @endforeach
        </div>
      </div>
      <div class="tab-pane" id="history" role="tabpanel" aria-expanded="false">
        <div class="row">
          <div class="common-text">Chưa có lịch sử đơn hàng</div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
