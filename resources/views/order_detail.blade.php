@extends('template.index') @push('stylesheets')
<script>
$(document).ready(function() {
  $('#btnBack').on('click', function() {
    swal({
      title: 'Hủy đơn',
      text: 'Bạn muốn hủy đơn hàng này?',
      type: 'warning',
      showCancelButton: true,
      cancelButtonClass: 'btn-primary',
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

  function initMap() {
    initOrderMap({{ $order->location }}, '{{ $order->address }}');
  }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&callback=initMap&languages=vi&libraries=places" async defer></script>

@endpush @section('title') Trang điều khiển @endsection @section('content')
<section class="content-body">
  <div style="min-height: 463px;">
  @include('template.order_detail_header_map')
  @include('template.order_detail_header')
  </div>
  <div class="row-complete clearfix">
    <button id="btnBack" type="button" class="btn"><i class="material-icons">&#xE14C;</i></button>
    <button id="btnSubmit" type="button" class="btn btn-primary"><i class="material-icons">&#xE876;</i></button>
  </div>
  <form id="frmMain" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
  </form>
</section>
@endsection
