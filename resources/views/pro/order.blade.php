@extends('template.index') @push('stylesheets')
<style>
</style>
<script>
  $(document).ready(function() {
    $('.inp-quoted-price').number({
      'containerClass': 'number-style',
      'minus': 'number-minus',
      'plus': 'number-plus',
      'containerTag': 'div',
      'btnTag': 'span'
    });
    $('.inp-quoted-price').val(accounting.formatMoney($('input[name=price]').val()));
    $('.datetimepicker').datetimepicker({
      minDate: moment(),
      locale: moment.locale('vi'),
      format: 'dddd, DD/MM/YYYY HH:ss',
      showClose: true,
      widgetPositioning: {
        horizontal: 'auto',
        vertical: 'top'
      },
      icons: {
        time: 'fa fa-clock-o',
        date: 'fa fa-calendar',
        up: 'fa fa-chevron-up',
        down: 'fa fa-chevron-down',
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-screenshot',
        clear: 'fa fa-trash',
        close: 'fa fa-check'
      },
    });
    $('.price').each(function() {
      $(this).html(accounting.formatMoney($(this).html()));
    });
    $('#frmMain').validate({
      submit: {
        settings: {
          inputContainer: '.form-group',
          errorListClass: 'form-control-error',
          errorClass: 'has-danger',
        },
        callback: {
          onSubmit: function() {
            $('input[name=price]').val(accounting.unformat($('.inp-quoted-price').val()));
            $.ajax({
              type: 'POST',
              url: '{{ route("quote_price") }}',
              data: $('#frmMain').serialize(),
              success: function(response) {
                swal({
                    title: 'Thành công',
                    text: 'Hoàn tất báo giá, chờ khách hàng đồng ý !',
                    type: 'success',
                    confirmButtonClass: 'btn-primary',
                    confirmButtonText: 'Kết thúc',
                  },
                  function() {
                    location.href = '{{ route("pro_order_list_page") }}';
                  });
              },
              error: function(xhr) {
                if (xhr.status == 400) {
                  $.notify({
                    title: '<strong>Thất bại! </strong>',
                    message: 'Đơn hàng này đã đóng hoặc đã bị hủy.'
                  }, {
                    type: 'danger',
                  });
                } else {
                  $.notify({
                    title: '<strong>Thất bại! </strong>',
                    message: 'Có lỗi phát sinh, hãy thử lại.'
                  }, {
                    type: 'danger'
                  });
                };

                location.reload();
              }
            });
          }
        }
      }
    });
  });
</script>
@endpush @section('title') Đơn hàng @endsection @section('content')
<section class="content-body">
  @include('order.order_detail_map') @include('order.order_detail_tag')
  @if (!$quotedPrice)
  <form class="quoted-form" id="frmMain" name="form-validation" method="POST" action="{{ route('quote_price') }}">
    <input name="inpPrice" class="inp-quoted-price" step="5000" min="100000" max="">
    <input name="price" class="basic-inp-quoted-price" value="100000" type="hidden" />
    <div class="quoted-intro">
    <textarea class="form-control" name="introduction" rows="6" maxlength="200" placeholder="Ghi chú"></textarea>
    </div>
    <button id="btnSubmit" type="submit" class="btn btn-primary width-150 btn-bottom-screen">Báo giá x</button>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
  </form>
  @elseif ($quotedPrice->state == 0)
  <div class="reported">
    <div class="text-uppercase">Bạn đã báo giá</div>
    <span class="price">{{ $quotedPrice->price }}</span>
    <div class="text-uppercase margin-top-25">Lời giới thiệu</div>
    <div>{{ $quotedPrice->introduction }}</div>
  </div>
  <button id="btnSubmit" type="button" class="btn btn-primary text-uppercase btn-bottom-screen">Tôi đã đến</button>
  @elseif ($quotedPrice->state == 2)
  @endif
</section>

<script type="text/javascript">
  function initMap() {
    initOrderMap("{{ explode(',', $order->location)[0] }}", "{{ explode(',', $order->location)[1] }}", "{{ $order->address }}");
  }
</script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&callback=initMap&languages=vi&libraries=places" async defer></script>
@endsection
