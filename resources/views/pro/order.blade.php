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
<section class="page-content">
  <form id="frmMain" method="POST" action="{{ route('quote_price') }}">
    <input name="inpPrice" class="quoted-price" value="10000" step="10000" min="10000" max="">
    <input name="price" class="basic-quoted-price" value="0" type="hidden" />

    <div class="row">
      <div class="order-info col-md-10 col-sm-10 col-sx-10">
        <img src="../storage/app/u/{{ $order->user_id }}/{{ $order->user_avatar }}">
        <label>{{ $order->user_name }}</label>
        <div class="order-req">
          {{ $order->short_requirements }}
        </div>
        <p><span class="icmn-location"></span> {{ $order->address }}</p>
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