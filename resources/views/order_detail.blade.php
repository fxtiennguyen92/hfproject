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
    @include('order.order_detail_item')

    @if ($order->state == 0 && $order->no && $order->quoted_price_count == 0)
    @elseif ($order->state == 0 && $order->quoted_price_count > 0)
    <div class="row padding-top-20">
    <div class="col-md-12">
      @foreach ($order->quotedPrice as $quoted)
      <div class="orders-item hf-card">
        <div class="row flex">
          <div class="col-md-5 col-sm-5 col-xs-5 text-center">
            <div class="author-avt"><img src="{{ env('CDN_HOST') }}/u/{{ $quoted->pro->id }}/{{ $quoted->pro->avatar }}" /></div>
          </div>
          <div class="col-md-7 col-sm-7 col-xs-7">
            <div class="author-name margin-top-10">{{ $quoted->pro->name }}</div>
            <div class="author-rating">
              <select id="rating" class="rating" data-current-rating="{{ $quoted->pro->profile->rating }}">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>
            </div>
            <div>Báo giá: <span class="price text-danger">{{ $quoted->price }}</span></div>
          </div>
        </div>
        <div class="padding-20">
          <div class="message text-center">{{ $quoted->introduction }}</div>
        </div>
        <div class="text-center padding-top-15" style="border-top:solid 1px #e1e1e1">
          <a class="text-info" href="{{ route('order_pro_page', ['proId' => $quoted->pro_id]) }}">Xem hồ sơ đối tác</a>
        </div>
      </div>
      @endforeach
    </div>
    </div>
    @elseif ($order->state == 1)
    <div class="row padding-top-20">
    <div class="col-md-12">
      <div class="orders-item hf-card">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12 text-center">
            <h5>Đối tác thực hiện</h5>
          </div>
        </div>
        <div class="row flex padding-bottom-15">
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
            <div><span class="price text-danger">{{ $order->total_price }}</span></div>
          </div>
        </div>
        <div class="text-center padding-top-15" style="border-top:solid 1px #e1e1e1">
          <a class="text-info" href="javascript:void(0);">Gọi đối tác</a>
        </div>
      </div>
    </div>
    </div>
    @endif
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
