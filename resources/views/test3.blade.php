@extends('template.index') @push('stylesheets')
<script>


</script>
@endpush @section('title') Trang điều khiển @endsection @section('content')
<section class="content-body content-width-700">
  <div class="order-map cover-profile" style="background-image: url(img/OB81ZW0.jpg);">
    <a class="arrow-back" href="#"><i class="material-icons">&#xE5C4;</i></a>
    <a class="icon-cart" href="#"><i class="material-icons">&#xE8CC;</i></a>
  </div>

  <div class="padding-top-20 padding-bottom-20 hf-card pro-profile" style="margin-right:0">
    <div class="row">
      <div class="col-md-6">
        <div class="flex row">
          <div class="col-md-5 col-sm-5 col-xs-5 service-info text-center">
            <img style="border-radius:100%" class="avt" src="img/landing-page/avatar-1.png">
          </div>
          <div class="col-md-7 col-sm-7 col-xs-7">
            <h4 class="pro-name text-bold">Y&C Electric</h4>
            <div class="order-address margin-top-10">56, Bình Thạnh, Tp. Hồ Chí Minh</div>
            <div class="order-tag margin-top-10">
              sửa điện, sửa nước
            </div>
          </div>
        </div>
      </div>

      <div class="text-center margin-top-20 col-md-6">
        <button type="button" class="btn btn-primary-outline margin-inline">Chọn đối tác này</button>
      </div>
    </div>

    <div class="row skill-rating flex margin-top-20 text-center">
      <div class="des col-md-6">
        dịch vụ sửa chữa điện nước tại Bình Thạnh, gọi là đến ngay chỉ 10 phút
      </div>
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-4 col-sm-4 col-xs-4">
            <span class="btn btn-info-outline hf-rounded">50</span>
            <div>Đơn hàng</div>
          </div>
          <div class="col-md-4 col-sm-4 col-xs-4">
            <span class="btn btn-info hf-rounded">4.3</span>
            <div>Đánh giá</div>
          </div>
          <div class="col-md-4 col-sm-4 col-xs-4">
            <span class="btn btn-info hf-rounded">25</span>
            <div>Nhận xét</div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="project padding-20">
          <div class=" row">
            <h5>Dự án đã thực hiện (50)</h5>
            <div class="col-md-6 col-sm-6 col-xs-6 margin-bottom-15">
              <img src="img/landing-page/avatar-1.png">
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 margin-bottom-15">
              <img src="img/landing-page/avatar-1.png">
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 margin-bottom-15">
              <img src="img/landing-page/avatar-1.png">
            </div>

          </div>
          <div class="text-center"><a href="#">Xem tất cả (50)</a></div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="comment padding-20">
          <h5>Nhận xét (22)</h5>

          <div class="message row">
            <div class=" col-md-2 col-sm-2 col-xs-2 text-center">
              <img class="avatar" style="border-radius:100%" class="avt" src="img/landing-page/avatar-1.png">
            </div>
            <div class="col-md-10 col-sm-10 col-xs-10">
              <div class="clearfix">
                <div class="pull-left author"><a href="#">Thanh Tâm</a> <span>9 tháng 9, 2017</span></div>
                <div class="author-rating pull-right">
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                </div>
              </div>
              <div class="message-text">
                Làm cẩn thận, nhanh chóng, có nhiều dịch vụ chuyển nghiệp nói dung là hết xẩy con bà bảy
              </div>
              <div class="info-project">
                <div><span>Ngày dự án</span>: 8 tháng 9, 2017</div>
                <div><span>Giá dự án</span>: 200k - 500k</div>
              </div>
            </div>
          </div>

          <div class="message row">
            <div class=" col-md-2 col-sm-2 col-xs-2 text-center">
              <img class="avatar" style="border-radius:100%" class="avt" src="img/landing-page/avatar-1.png">
            </div>
            <div class="col-md-10 col-sm-10 col-xs-10">
              <div class="clearfix">
                <div class="pull-left author"><a href="#">Thanh Tâm</a> <span>9 tháng 9, 2017</span></div>
                <div class="author-rating pull-right">
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                </div>
              </div>
              <div class="message-text">
                Làm cẩn thận, nhanh chóng, có nhiều dịch vụ chuyển nghiệp nói dung là hết xẩy con bà bảy
              </div>
              <div class="info-project">
                <div><span>Ngày dự án</span>: 8 tháng 9, 2017</div>
                <div><span>Giá dự án</span>: 200k - 500k</div>
              </div>
            </div>
          </div>
          <div class="text-center"><a href="#">Tất cả (25)</a></div>
        </div>
      </div>
    </div>

  </div>
</section>
@endsection
