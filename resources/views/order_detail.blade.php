@extends('template.index') @push('stylesheets')
<script>
function initMap() {
	initOrderMap({{ $order->location }}, '{{ $order->address }}');
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&callback=initMap&languages=vi&libraries=places" async defer ></script>

@endpush @section('title') Trang điều khiển @endsection @section('content')
<section class="content-body">
@include('template.order_detail_header')

  <div class="row">
    <div class="col-md-12">
      <div class="orders-item hf-card">
        <div class="row flex">
          <div class="col-md-5 col-sm-5 col-xs-5 text-center">
            <div class="author-avt"><img src="img/landing-page/avatar-2.png" /></div>
          </div>
          <div class="col-md-7 col-sm-7 col-xs-7">
            <div class="author-name margin-top-10">Ngô Tấn Đạt</div>
            <div class="author-rating">
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
            </div>
            <div class="price">Báo giá: <span class="text-danger">300.000đ</span></div>
          </div>

        </div>
        <div class="padding-20">
          <div class="message">
            Tôi có thể sửa đèn trong vòng 20p, uy tín đảm bảo chất lượng, hết xẩy con bà bảy, tuyệt vời ông mặt trời luôn<i></i>
          </div>
        </div>
        <div class="text-center padding-top-15" style="border-top:solid 1px #e1e1e1">
          <a class="text-info" href="#">Xem hồ sơ đối tác</a>
        </div>
      </div>
      <div class="orders-item hf-card">
        <div class="row flex">
          <div class="col-md-5 col-sm-5 col-xs-5 text-center">
            <div class="author-avt"><img src="img/landing-page/avatar-2.png" /></div>
          </div>
          <div class="col-md-7 col-sm-7 col-xs-7">
            <div class="author-name margin-top-10">Ngô Tấn Đạt</div>
            <div class="author-rating">
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
            </div>
            <div class="price">Báo giá: <span class="text-danger">300.000đ</span></div>
          </div>

        </div>
        <div class="padding-20">
          <div class="message">
            Tôi có thể sửa đèn trong vòng 20p, uy tín đảm bảo chất lượng, hết xẩy con bà bảy, tuyệt vời ông mặt trời luôn<i></i>
          </div>
        </div>
        <div class="text-center padding-top-15" style="border-top:solid 1px #e1e1e1">
          <a class="text-info" href="#">Xem hồ sơ đối tác</a>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
