@extends('template.index') @push('stylesheets')
<script>
  $(document).ready(function() {
    $('.price').each(function() {
      $(this).html(accounting.formatMoney($(this).html()));
    });

    $('.qprice-item').on('click', function() {
      $('.modal-avt').attr('src', ($(this).find('.pro-avt').attr('src')));
      $('.modal-pro-name').html($(this).find('.pro-name').html());
      $('.modal-rating').barrating('set', $(this).find('.rating').attr('data-current-rating'));
      $('.modal-price').html($(this).find('.price').html());
      $('#qpriceId').val($(this).attr('qprice-id'));

      $('#detailModal').modal('show');
    });

    $('#btnAccept').on('click', function() {
      $('#detailModal').modal('hide');

      var url = "{{ route('accept_quoted_price', ['qpId' => 'quotedPriceId']) }}";
      url = url.replace('quotedPriceId', $('#qpriceId').val());

      $.ajax({
        type: 'POST',
        url: url,
        data: $('#frmMain').serialize(),
        success: function(response) {
          swal({
              title: 'Chúc mừng',
              text: 'Bạn đã chọn được chuyên gia cho mình!',
              type: 'success',
              confirmButtonClass: 'btn-primary',
              confirmButtonText: 'Kết thúc',
            },
            function() {
              location.href = '{{ route("order_list_page") }}';
            });
        },
        error: function(xhr) {
          if (xhr.status == 400) {
            $.notify({
              title: '<strong>Thất bại! </strong>',
              message: 'Có lỗi phát sinh nên không thể chọn báo giá.'
            }, {
              type: 'danger',
            });
            setTimeout(function() {
              location.reload();
            }, 2500);
          };
        }
      });
    })
  });

</script>

@endpush @section('title') @endsection @section('content')
<section class="page-order">
  <div class="page-content-inner">
    <div class="hf-wrapper row">
      <div class="col-md-4 col-sm-12 ">
        <div class="row order-info hf-card">
          <div class="col-md-5 col-sm-5 col-xs-5 service-info text-center">
            <img class="avt" src="img/service/{{ $order->service_id }}.svg" />
            <label class="order-user">{{ $order->service->name }}</label>
          </div>
          <div class="col-md-7 col-sm-7 col-xs-7">
            <div class="order-code">Đơn #23D65</div>
            <div class="order-address"><i class="material-icons">&#xE0C8;</i> {{ $order->address }}</div>
            <div class="order-state">
              @if ($order->est_excute_at_string)
              <span class="order-time state-est-time"><i class="material-icons">&#xE855;</i> {{ $order->est_excute_at_string }}</span> @else
              <span class="order-time state-now"><i class="material-icons">&#xE3E7;</i> Ngay lập tức</span> @endif
            </div>
          </div>
          <div class="col-md-12 col-sm-12 col-xs-12 order-req">
            @if (strlen($order->short_requirements) > 175)
            <span>{{ substr($order->short_requirements, 0, 150).'...' }}</span> @else
            <span>{{ $order->short_requirements }}</span> @endif
          </div>
        </div>
      </div>
      <div class="col-md-8 col-sm-12 ">
        <!--
<div class="nav-tabs-horizontal">
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" href="javascript: void(0);" data-toggle="tab" data-target="#tabQPrice" role="tab">
               Danh sách báo giá</a>
    </li>
  </ul>
</div>
-->
        
        @if (sizeof($order->quoted_price) == 0)
        <div class="common-text">Không có báo giá nào</div>
        @else
        <div class="text-center">
          <div class="noti-btn">
            có {{ sizeof($order->quoted_price) }} báo giá
          </div>
        </div>
        @endif @foreach ($order->quoted_price as $q)
        <div class="qprice-item row hf-card" qprice-id="{{ $q->qp_id }}">
          <div class="col-md-5 col-sm-5 text-center">
            <div class="row">
              <div class="col-md-4 col-sm-4 col-xs-4">
                <img class="pro-avt avt" src="http://innovatik.payo-themes.com/wp-content/uploads/2017/11/lawn-team03.jpg">
              </div>
              <div class="col-md-7 col-sm-7 col-xs-7 text-left">
                <label class="pro-name">{{ $q->pro->name }}</label>
                <div>
                  <select class="rating" data-current-rating="{{ $q->pro_profile->rating }}">
                    <option value=""></option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                  </select>
                </div>
                <div class="">
                  Báo giá: <span class="price"> {{ $q->price }}</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-7 col-sm-7 note">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
          </div>
          <div class="col-md-12 text-center btn-profile"><a href="#">Xem hồ sơ đối tác</a></div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <form id="frmMain" method="POST">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row">
            <img class="modal-avt avt" src="" />
          </div>
          <label class="modal-pro-name"></label>
          <select class="modal-rating rating" data-current-rating="">
              <option value=""></option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
          <div class="modal-price"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" data-dismiss="modal">Quay lại</button>
          <button id="btnAccept" type="button" class="btn btn-primary">Chấp nhận</button>
        </div>
      </div>
    </div>
    <input type="hidden" name="quoted_price_id" id="qpriceId" />
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
  </form>
</div>
@endsection
