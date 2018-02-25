@extends('template.index') @push('stylesheets')
<style>
</style>
<script>
  $(document).ready(function() {
    $('.quoted-price').number({
      'containerClass': 'number-style',
      'minus': 'number-minus',
      'plus': 'number-plus',
      'containerTag': 'div',
      'btnTag': 'span'
    });
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
    @if($quotedPrice)
    $('input[name=price]').val('{{ $quotedPrice->price }}');
    @else
    $('input[name=price]').val('10000');
    @endif
    $('.quoted-price').val(accounting.formatMoney($('input[name=price]').val()));

    $('#frmMain').validate({
      submit: {
        settings: {
            inputContainer: '.form-group',
            errorListClass: 'form-control-error',
            errorClass: 'has-danger',
        },
        callback: {
          onSubmit: function() {
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
              } else if (xhr.status == 417) {
                $.notify({
                  title: '<strong>Thất bại! </strong>',
                  message: 'Đơn hàng này đã .'
                }, {
                  type: 'danger'
                });
              };
            }
          });
          }
        }
      }
    });
  });
</script>

@endpush @section('title') @endsection @section('content')
<section class="page-content page-order">
  <form class="order-form" id="frmMain" name="form-validation" method="POST" action="{{ route('quote_price') }}">
    <input name="inpPrice" class="quoted-price" value="10000" step="5000" min="10000" max="">
    <input name="price" class="basic-quoted-price" value="10000" type="hidden"/>
    <div class="order-item">
      <div class="row order-row">
        <div class="col-md-3 col-sm-4 col-sx-4">
          <img class="avt" src="http://innovatik.payo-themes.com/wp-content/uploads/2017/11/lawn-team03.jpg" />
        </div>
        <div class="col-md-9 col-sm-8 col-sx-8">
          <label class="order-user">{{ $order->user_name }}</label>
          <div class="order-address"><i class="material-icons">&#xE0C8;</i> {{ $order->address }}</div>
          <div class="order-state">
            @if ($order->est_excute_at_string)
            <span class="order-time state-est-time"><i class="material-icons">&#xE855;</i> {{ $order->est_excute_at_string }}</span>
            @else
            <span class="order-time state-now"><i class="material-icons">&#xE855;</i></span>
            <input class="datetimepicker" type="text"
                placeholder="Chưa xác định thời gian"
                name="estTime" data-validation="[NOTEMPTY]">
            @endif
          </div>
        </div>
        <div class="row">
          <div class="order-req col-md-12 col-sm-12 col-sx-12">
            <span>{{ $order->short_requirements }}</span>
          </div>
        </div>
      </div>
    </div>

    @if (!$quotedPrice)
    <button id="btnSubmit" type="submit" class="btn btn-primary width-150">Báo giá</button>
    @endif
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
  </form>
</section>
@endsection
