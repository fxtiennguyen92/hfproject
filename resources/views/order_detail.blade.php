@extends('template.index') @push('stylesheets')
<script>
$(document).ready(function() {
  $('.price').each(function() {
    $(this).html(accounting.formatMoney($(this).html()));
  });
  $('#btnBack').on('click', function() {
    swal({
      title: 'Hủy đơn',
      text: 'Bạn muốn hủy đơn hàng này?',
      type: 'warning',
      showCancelButton: true,
      cancelButtonClass: 'btn-default',
      confirmButtonClass: 'btn-danger',
      cancelButtonText: 'Quay lại',
      confirmButtonText: 'Hủy',
    },
    function() {
      $('#frmMain').attr('action', '{{ route("delete_order") }}');
      $('#frmMain').submit();
    });
  });
  $('#btnSubmit').on('click', function() {
    $('#frmMain').attr('action', '{{ route("complete_order") }}');
    $('#frmMain').submit();
  });
});
</script>
@endpush @section('title') Đơn hàng @endsection @section('content')
<section class="content-body">
  <div style="min-height: 500px;">
    @include('order.order_detail_map')
    @include('order.order_detail_tag')
  <div class="nav-tabs-horizontal order-page">
    <ul class="nav nav-tabs nav-page" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" href="javascript: void(0);" data-toggle="tab" data-target="#stateTab" role="tab" aria-expanded="true">Tình trạng</a>
      </li>
      <li class="nav-item">
        <a class="nav-link right" href="javascript: void(0);" data-toggle="tab" data-target="#infoTab" role="tab" aria-expanded="false">Thông tin</a>
      </li>
      <li class="nav-item">
        <a class="nav-link right" href="javascript: void(0);" data-toggle="tab" data-target="#supTab" role="tab" aria-expanded="false">Hỗ trợ</a>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="stateTab" role="tabpanel" aria-expanded="true">
        @include('order.order_detail_state')
      </div>
      <div class="tab-pane" id="infoTab" role="tabpanel" aria-expanded="false">
<!--         <h5 class="padding-top-10">Chi tiết đơn hàng</h5> -->
<!--         <div class="common-text">Chi tiết đơn hàng</div> -->
        <h5 class="padding-top-20">Khách hàng</h5>
        <div class="padding-10 text-center hf-card user-row">
          <img class="user-avt" src="{{ env('CDN_HOST') }}/u/{{ $order->user_id }}/{{ $order->user->avatar }}">
          <label>{{ $order->user_name }}</label>
        </div>
        <h5 class="padding-top-20">Đối tác</h5>
        @if(!$order->pro_id)
        <div class="common-text">Chưa có đối tác</div>
        @else
        <div class="orders-item hf-card">
        <div class="row flex padding-bottom-10">
          <div class="col-md-5 col-sm-5 col-xs-5 text-center">
            <div class="author-avt"><img src="{{ env('CDN_HOST') }}/u/{{ $order->pro->id }}/{{ $order->pro->avatar }}" /></div>
          </div>
          <div class="col-md-7 col-sm-7 col-xs-7">
            <div class="author-name margin-top-10">{{ $order->pro->name }}</div>
            <div class="author-rating">
              <select id="rating" class="rating" data-current-rating="{{ $order->pro->profile->rating }}">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>
            </div>
          </div>
        </div>
        <div class="text-center padding-top-15" style="border-top:solid 1px #e1e1e1">
          <a class="text-info" href="javascript:void(0);">Gọi đối tác</a>
        </div>
        </div>
        @endif
      </div>
      <div class="tab-pane" id="supTab" role="tabpanel" aria-expanded="false">
        <h5 class="padding-top-10">Câu hỏi thường gặp</h5>
      </div>
    </div>
  </div>
  </div>
  @if (is_null($order->no))
  <div class="row-complete clearfix">
    <button id="btnBack" type="button" class="btn"><i class="material-icons">&#xE14C;</i></button>
    <button id="btnSubmit" type="button" class="btn btn-primary"><i class="material-icons">&#xE876;</i></button>
  </div>
  <form id="frmMain" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
  </form>
  @endif
</section>

<script type="text/javascript">
  function initMap() {
    initOrderMap("{{ explode(',', $order -> location)[0] }}", "{{ explode(',', $order -> location)[1] }}", "{{ $order->address }}");
  }
</script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&callback=initMap&languages=vi&libraries=places" async defer></script>
@endsection
