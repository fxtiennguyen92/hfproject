@extends('template.index') @push('stylesheets')
<link rel="stylesheet" type="text/css" href="css/home.css"> @endpush @section('title') @endsection @section('content')
<!-- SECTION BANNER -->
<section class="top-banner">
  <div class="hero">
    <div class="content">
      <h1 class="text-center">Đặt việc nhà trong 60 giây <small>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</small></h1>
    </div>

  </div>
  <div class="service">
    <div class="row">
      <div class="col-xs-6 col-sm-4 col-lg-2 center">
        <a href="/sua-dien">
          <div class="shadow btn-services">
            <img class="btn-services-img" src="img/services/group/1.png">
            <p class="btn-services-text">SỬA ĐIỆN</p>
          </div>
        </a>
      </div>
      <div class="col-xs-6 col-sm-4 col-lg-2">
        <a href="/sua-dien">
          <div class="shadow btn-services">
            <img class="btn-services-img" src="img/services/group/2.png">
            <p class="btn-services-text">SỬA NƯỚC</p>
          </div>
        </a>
      </div>
      <div class="col-xs-6 col-sm-4 col-lg-2">
        <a href="/sua-dien">
          <div class="shadow btn-services">
            <img class="btn-services-img" src="img/services/group/3.png">
            <p class="btn-services-text">ĐIỆN LẠNH</p>
          </div>
        </a>
      </div>
      <div class="col-xs-6 col-sm-4 col-lg-2">
        <a href="/sua-dien">
          <div class="shadow btn-services">
            <img class="btn-services-img" src="img/services/group/4.png">
            <p class="btn-services-text">KHÓA - CỬA</p>
          </div>
        </a>
      </div>
      <div class="col-xs-6 col-sm-4 col-lg-2">
        <a href="/sua-dien">
          <div class="shadow btn-services">
            <img class="btn-services-img" src="img/services/group/5.png">
            <p class="btn-services-text">CHỤP ẢNH</p>
          </div>
        </a>
      </div>
      <div class="col-xs-6 col-sm-4 col-lg-2">
        <a href="/sua-dien">
          <div class="shadow btn-services">
            <img class="btn-services-img" src="img/services/group/6.png">
            <p class="btn-services-text">SỰ KIỆN</p>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- SECTION SERVICES -->


<!-- SECTION GUARANTEE -->
<section id="section_value" class="fullHeight">
  <div class="container flex ">
    <div class="col-sm-6">
      <img src="img/home_value.png" class="home_value_img" width="100%">
    </div>
    <div class="col-sm-6">
      <div class="home_value_text">
        <h5 class="home_value_title">DỊCH VỤ TRONG VÀI PHÚT</h5>
        <p class="home_value_content">Đặt. Báo Giá. Đến Nhà.</p>
      </div>
      <div class="home_value_text">
        <h5 class="home_value_title">AN TOÀN TUYỆT ĐỐI</h5>
        <p class="home_value_content">Từ thông tin pháp lý của chuyên gia cho đến đội Xử Lý Tình Huống 24/7. Chúng tôi luôn bên cạnh bạn.</p>
      </div>
      <div class="home_value_text">
        <h5 class="home_value_title">KHÁCH HÀI LÒNG. ĐỐI TÁC HÀI LÒNG.</h5>
        <p class="home_value_content">Bạn sẽ hiểu vì sao 9 trên 10 khách hàng đánh giá đội ngũ của chúng tôi 5 sao.</p>
      </div>

    </div>
  </div>
</section>

<!-- SECTION STEPS -->
<section id="hiw">
  <div class="container">
    <div class="heading text-center">Đặt dịch vụ từ mọi nơi cùng HandFree</div>
    <div class="sub-heading text-center margin-bottom-50">Lorem Ipsum is simply dummy text of the printing and typesetting industry</div>
    <div class="hiw-slider">
      <div class="row">
        <div class="col-md-6">
          <div class="img">
            <img style="" src="img/x-img-demo.jpg" />
          </div>
        </div>
        <div class="col-md-6">
          <div class="text margin-padding-50">
            <span class="step-title">Bước 1:</span>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="img">
            <img style="" src="img/x-img-demo.jpg" />
          </div>
        </div>
        <div class="col-md-6">
          <div class="text margin-padding-50">
            <span class="step-title">Bước 2:</span>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="img">
            <img style="" src="img/x-img-demo.jpg" />
          </div>
        </div>
        <div class="col-md-6">
          <div class="text margin-padding-50">
            <span class="step-title">Bước 3:</span>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</p>
          </div>
        </div>
      </div>
</section>

<!-- SECTION TESTINOMIAL -->
<section id="testinomial">
  <div class="container">
    <div class="heading text-center">Testimonials</div>
    <div class="sub-heading text-center margin-bottom-50">Lorem Ipsum is simply dummy text of the printing and typesetting industry</div>
    <div class="testinomial-slider">
      <div class="quote">
        <div class="item-info text-center">
          <div class="avatar-wrapper">
            <a href="#" class="avatar-link">
              <img width="180" height="180" src="https://cgtmedia.com/wp-content/uploads/avatars/1/5a4af11de1efb-bpfull.png" class="avatar" alt="">
              </a>
          </div>
          <cite class="author">
            <span class="author-name">Mr. Dat Ngo</span>
              <span class="title" itemprop="jobTitle">CEO of CGT-Media</span> 
              <span class="url">
                <a href="#" itemprop="url">https://cgtmedia.com</a>
              </span> 
              </cite>
        </div>
        <blockquote class="testimonials-text">
          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</p>
          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</p>
        </blockquote>

      </div>
      <div class="quote">
        <div class="item-info text-center">
          <div class="avatar-wrapper">
            <a href="#" class="avatar-link">
              <img width="180" height="180" src="https://cgtmedia.com/wp-content/uploads/avatars/1/5a4af11de1efb-bpfull.png" class="avatar" alt="">
              </a>
          </div>
          <cite class="author">
            <span class="author-name">Mr. Dat Ngo</span>
              <span class="title" itemprop="jobTitle">CEO of CGT-Media</span> 
              <span class="url">
                <a href="#" itemprop="url">https://cgtmedia.com</a>
              </span> 
              </cite>
        </div>
        <blockquote class="testimonials-text">
          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</p>

        </blockquote>

      </div>
    </div>
  </div>
</section>

<div id="section-form">
  <div class="container">
    <div class="heading text-center">Đăng ký tài khoản MIỄN PHÍ ngay bây giờ</div>
    <div class="sub-heading text-center margin-bottom-50">Để khám phá đầy đủ tính năng của Hand Free</div>
    <div class="row">
      <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
        <div class="row hf-card">
          <div class="col-md-7">
            <div class="signin">
              <h3 class="title">Đăng ký</h3>
              <div class="signin-social">
                <h4 class="sub-title">Đăng ký bằng mạng xã hội</h4>
                <div class="sigin-button-group">
                  <a class="button btn  facebook" href="">Facebook</a>
                  <a class="button btn google" href="">Google+</a>
                </div>
              </div>
              <div class="signin-form">
                <h4 class="sub-title">Hoặc điền thông tin</h4>
                <form>
                  <div class="form-input-icon">
                    <i class="material-icons">&#xE7FD;</i>
                    <input type="text" class="form-control" placeholder="Địa chỉ email" id="">
                  </div>
                  <div class="form-input-icon">
                    <i class="material-icons">&#xE899;</i>
                    <input type="password" class="form-control" placeholder="Mật khẩu từ 6 đến 32 ký tự" id="">
                  </div>
                  <div class="form-input-icon">
                    <i class="material-icons">&#xE899;</i>
                    <input type="password" class="form-control" placeholder="Gõ lại mật khẩu" id="">
                  </div>
                  <div class="margin-top-20">
                    <button type="button" class="btn btn-primary width-150">Đăng ký</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div class="login text-center">
              <img src="img/logow.png" />
              <h4 class="sub-title">Bạn đã có tài khoản?</h4>
              <div class="margin-top-20">
                <button type="button" class="btn btn-white width-150">Đăng nhập</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<section class="lets-work" style="background-image:url(img/lest-work.jpg)">
  <div class="wrapper">
    <div class="headline text-center">Tham gia Hand Free<br> để có thu nhập ổn định mỗi tháng !</div>
    <div class="text-center"><a class="btn edt-btn1 text-uppercase" href="#">Đăng ký ngay</a></div>
  </div>
</section>
<footer class="hf-footer">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <img src="img/logow.png" width="180">
        <p class="intro margin-top-20">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor</p>
        <ul class="social list-inline margin-top-20">
          <li>
            <a href="#" class="icon"><img src="img/social/facebook.png" width="32"></a>
          </li>
          <li>
            <a href="#" class="icon"><img src="img/social/google-plus.png" width="32"></a>
          </li>
          <li>
            <a href="#" class="icon"><img src="img/social/instagram.png" width="32"></a>
          </li>
          <li>
            <a href="#" class="icon"><img src="img/social/linkedin.png" width="32"></a>
          </li>
          <li>
            <a href="#" class="icon"><img src="img/social/twitter.png" width="32"></a>
          </li>
        </ul>
      </div>
      <div class="col-md-3">
        <div class="title">
          Quick links
        </div>
        <ul class="link">
          <li><a href="#">Lorem Ipsum</a></li>
          <li><a href="#">Lorem Ipsum is simply</a></li>
          <li><a href="#">Lorem Ipsum is simply</a></li>
          <li><a href="#">Lorem </a></li>
          <li><a href="#">Lorem Ipsum</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <div class="title">
          Page
        </div>
        <ul class="link">
          <li><a href="#">Home</a></li>
          <li><a href="#">About Us</a></li>
          <li><a href="#">Blog</a></li>
          <li><a href="#">Service </a></li>
          <li><a href="#">Contact</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <div class="title">
          Đăng ký nhận thông báo
        </div>
        <form>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Email Address" id="l30">
          </div>
          <div class="form-group">
            <button type="button" class="btn btn-primary width-150">Đăng ký</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</footer>
<div class="copyright">
  <div class="container">
    <p><b>© 2018 Bản quyền của Hand Free, JSC.</b></p>
    <p>Địa chỉ: Phòng 104, Số 4/2 Đinh Bộ Lĩnh, Phường 24, Quận Bình Thạnh, TP.HCM.</p>
    <p>Giấy chứng nhận Đăng ký Kinh doanh số 123456789 do Sở Kế hoạch và Đầu tư Thành phố Hồ Chí Minh cấp ngày 01/01/2018.

    </p>
  </div>
</div>
<!-- FOOTER -->
<!--
<footer>
  <div class="footer_main container">
    <div class="row">
      <div class="col-sm-5 col-md-3">
        <div class="footer_title_div">
          <img src="img/logoh.png" width="180">
          <span class="footer_title_arrow visible-xs"><i class="material-icons">keyboard_arrow_down</i></span>
        </div>
        <ul class="footer_link hidden-xs">
          <li><a href="mailto:info@handfree.co" style="color: #02b3e4; font-size: 18px;">info@handfree.co</a></li>
          <li><a href="tel:0903375500" style="color: #02b3e4; font-size: 18px;">0904623460</a></li>
          <li><a href="/help">Hỗ Trợ</a></li>
          <li><a href="/about">Thông Tin</a></li>
          <li><a href="/about">Tuyển Dụng</a></li>
          <li><a href="/about">Blog</a></li>

        </ul>
      </div>

      <div class="col-sm-3 col-md-2">
        <div class="footer_title_div">
          <span class="footer_title">Khách Hàng</span>
          <span class="footer_title_arrow visible-xs"><i class="material-icons">keyboard_arrow_down</i></span>
        </div>
        <ul class="footer_link hidden-xs">
          <li><a href="/" class="btn-link">About</a></li>
          <li><a href="/" class="btn-link">Jobs</a></li>
          <li><a href="/" class="btn-link">Blog</a></li>
          <li><a href="/" class="btn-link">Help</a></li>
        </ul>
      </div>

      <div class="col-sm-4 col-md-2" style="margin-bottom: 50px;">
        <div class="footer_title_div" id="footer_title_div_3">
          <span class="footer_title">Đối Tác</span>
          <span class="footer_title_arrow visible-xs"><i class="material-icons">keyboard_arrow_down</i></span>
        </div>
        <ul class="footer_link hidden-xs" id="footer_link_3">
          <li><a href="/" class="btn-link">About</a></li>
          <li><a href="/" class="btn-link">Jobs</a></li>
          <li><a href="/" class="btn-link">Blog</a></li>
          <li><a href="/" class="btn-link">Help</a></li>
        </ul>
      </div>

      <div class="col-sm-12 col-md-4">
        <center>
          <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fhandfreeco&tabs&width=290&height=214&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=1600106333380695" width="290" height="214" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
        </center>
      </div>

    </div>
  </div>
  <div class="footer_legal">
    <div class="container">
      <div class="col-sm-8">
        <p>© 2018 Hand Free, JSC.</p>
        <p>Phòng 104, Số 4/2 Đinh Bộ Lĩnh, Phường 24, Quận Bình Thạnh, TP.HCM.</p>
        <p>Giấy phép ĐKKD: do Sở Kế Hoạch và Đầu Tư cấp ngày /01/2018.</p>
      </div>
      <div class="col-sm-4">
        <a class="btn-link">Privacy Policy</a>
        <span> | </span>
        <a class="btn-link">Terms of Use</a>

      </div>
    </div>
  </div>
</footer>
-->
<script>
  $(document).on('click', '.footer_title_div', function(e) {
    $('.footer_link').attr("style", "display: block !important");
  });

</script>
@endsection
