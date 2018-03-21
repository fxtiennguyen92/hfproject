@extends('template.index') @push('stylesheets')
<script>


</script>
@endpush @section('title') Trang điều khiển @endsection @section('content')
<section class="orders-content-body">
  <div class="nav-tabs-horizontal orders-page">
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" href="javascript: void(0);" data-toggle="tab" data-target="#upcoming" role="tab" aria-expanded="true">Hiện tại</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="javascript: void(0);" data-toggle="tab" data-target="#history" role="tab" aria-expanded="false">Lịch sử</a>
      </li>
    </ul>
    <div class="tab-content content-width-700" style="margin:auto;">
      <div class="tab-pane active" id="upcoming" role="tabpanel" aria-expanded="true">
        <div class="row">
          @foreach ($currentOrders as $order) @endforeach
          <div class="col-md-12 col-sm-12">
            @include('template.order_detail_tag_1')
          </div>

        </div>
      </div>
      <div class="tab-pane" id="history" role="tabpanel" aria-expanded="false">
        <div class="row">

        </div>
      </div>
    </div>
  </div>
</section>
@endsection
