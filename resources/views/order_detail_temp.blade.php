@extends('template.index') @push('stylesheets')
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&callback=initMap">
</script>
<script>
function initMap() {
  var myLatLng = {lat: 21.0302432, lng: 105.8354};
  var map = new google.maps.Map(document.getElementById('googleMap'), {
    zoom: 17,
    center: myLatLng
  });

  numberMarkerImg = {
	        url: 'img/logo.png',
	        size: new google.maps.Size(16, 16),
	        scaledSize: new google.maps.Size(32, 38),
	        labelOrigin: new google.maps.Point(9, 9)
	   };
  
  var marker = new google.maps.Marker({
    position: myLatLng,
    map: map,
    icon     : numberMarkerImg,
    labelClass: 'labels',
    label: {
        text: 'test abdsdfs asdf ',
        color: 'black',
        fontSize: '12px',
        x: '200',
        y: '100'
    }
  });

  var infowindow = new google.maps.InfoWindow();
  infowindow.setContent('Test abc');
  infowindow.open(map, marker);
}
</script>

@endpush @section('title') Trang điều khiển @endsection @section('content')
<section class="content-body">
  <div id="googleMap" class="order-map" style="height:170px">
  </div>
  <div class=" order-info hf-card flex margin-bottom-20" style="margin-right:0">
    <div class="col-md-5 col-sm-5 col-xs-5 service-info text-center">
      <img class="avt" src="img/service/1.svg">
      <label class="order-user">Sửa điện</label>
    </div>
    <div class="col-md-7 col-sm-7 col-xs-7">
      <div class="order-code">Đơn #23D65</div>
      <div class="order-address"><i class="material-icons"></i> 56, Bình Thạnh, Tp. Hồ Chí Minh</div>
      <div class="order-state">
        <span class="order-time state-est-time"><i class="material-icons"></i> Thứ bảy, 31/03/2018 21:16</span>
      </div>
      <button type="button" class="margin-top-10 btn btn-squared btn-danger-outline margin-inline text-uppercase">Có 3 báo giá</button>
    </div>

  </div>

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
