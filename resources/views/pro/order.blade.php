@extends('template.index') @push('stylesheets')
<style>
  body {
    background: #F4F3F0;
  }

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

    @if($quotedPrice)
    $('input[name=price]').val('{{ $quotedPrice->price }}');
    @else
    $('input[name=price]').val('0');
    @endif
    $('.quoted-price').val(accounting.formatMoney($('input[name=price]').val()));
  });

  $('#frmMain').validate({
    submit: {
      callback: {
        onSubmit: function() {
          $.ajax({
            type: 'POST',
            url: '{{ route("quote_price") }}',
            data: $('#frmMain').serialize(),
            success: function(response) {
              $.notify({
                title: '<strong>Thành công! </strong>',
                message: 'Bạn đã báo giá thành công.'
              }, {
                type: 'success',
              });
              setTimeout(function() {
                location.href = "{{ route('pro_order_list_page') }}"
              }, 1500);
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

</script>

@endpush @section('title') @endsection @section('content')
<section class="page-content page-order">
  <form class="order-form" id="frmMain" method="POST" action="{{ route('quote_price') }}">
    <input name="inpPrice" class="quoted-price" value="10000" step="10000" min="10000" max="">
    <input name="price" class="basic-quoted-price" value="0" type="hidden" />
    <div class="order-item">
      <div class="row order-row" onclick="location.href='{{ route('pro_order_page', ['orderId' => $order->id]) }}'">
        <div class="col-md-3 col-sm-4 col-sx-4">
          <img class="avt" src="http://innovatik.payo-themes.com/wp-content/uploads/2017/11/lawn-team03.jpg" />
        </div>
        <div class="col-md-9 col-sm-8 col-sx-8">
          <label class="order-user">{{ $order->user_name }}</label>
          <div class="order-address"><i class="material-icons">&#xE0C8;</i> {{ $order->address }}</div>
          <div class="order-state">
            @if ($order->est_excute_at_string)
            <span class="order-time state-est-time"><i class="material-icons">&#xE855;</i> {{ $order->est_excute_at_string }}</span> @else
            <span class="order-time state-now"><i class="material-icons">&#xE3E7;</i> Ngay lập tức</span> @endif
          </div>
        </div>
        <div class="row">
          <div class="order-req col-md-12 col-sm-12 col-sx-12">
            <span>{{ $order->short_requirements }}</span>
          </div>
        </div>
        <div class="row">
          <div class="order-request-date col-md-12 col-sm-12 col-sx-12">
            <span>Đã yêu cầu lúc {{ Carbon\Carbon::parse($order->created_at)->format('d-m-Y H:i') }}</span>
          </div>
        </div>
      </div>
    </div>

    @if ($quotedPrice)
    <button id="btnSubmit" type="submit" class="btn btn-danger width-150">
			Xóa báo giá
		</button> @endif
    <button id="btnSubmit" type="submit" class="btn btn-primary width-150">
			@if ($quotedPrice)
			Báo giá lại
			@else
			Báo giá
			@endif
		</button>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
  </form>
</section>
@endsection
