@extends('template.index') @push('stylesheets')
<link rel="stylesheet" type="text/css" href="css/home.css">
<style>
</style>
<script>
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.12';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  $(document).on('click', '.footer_title_div', function(e) {
    $('.footer_link').attr("style", "display: block !important");
  });
</script>
@endpush
@section('title') Ứng dụng đặt dịch vụ @endsection
@section('content')
<section class="has-bottom-menu">
<!-- SECTION BANNER -->
<section class="top-banner">
  <div class="hero" style="background-image: url({{ env('CDN_HOST') }}/img/banner/main.png);">
    <div class="content">
<!--       <h1 class="text-center">Đặt việc nhà trong 60 giây <small>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</small></h1> -->
    </div>
  </div>

  <!-- SECTION SERVICES -->
  <div class="service">
    <div class="row">
      @foreach ($services as $service)
      <div class="col-xs-6 col-sm-4 col-lg-2 center">
        <a href="{{ route('service_page', ['serviceUrlName' => $service->url_name]) }}">
          <div class="shadow btn-services">
            <img class="btn-services-img" src="{{ env('CDN_HOST') }}/img/service/{{ $service->id }}.svg">
            <p class="btn-services-text">{{ $service->name }}</p>
          </div>
        </a>
      </div>
      @endforeach
    </div>
  </div>
</section>

@foreach ($parts as $part)
{!! $part->text !!}
@endforeach
</section>
@endsection
@include('template.mb.footer-menu')

<!-- <div id="section-form"> -->
<!--   <div class="container"> -->
<!--     <div class="heading text-center">Đăng ký tài khoản MIỄN PHÍ ngay bây giờ</div> -->
<!--     <div class="sub-heading text-center margin-bottom-50">Để khám phá đầy đủ tính năng của HandFree</div> -->
<!--     <div class="row"> -->
<!--       <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1"> -->
<!--         <div class="row hf-card"> -->
<!--           <div class="col-md-7"> -->
<!--             <div class="signin"> -->
<!--               <h3 class="title">Đăng ký</h3> -->
<!--               <div class="signin-social"> -->
<!--                 <h4 class="sub-title">Đăng ký bằng mạng xã hội</h4> -->
<!--                 <div class="sigin-button-group"> -->
<!--                   <a class="button btn  facebook" href="">Facebook</a> -->
<!--                   <a class="button btn google" href="">Google+</a> -->
<!--                 </div> -->
<!--               </div> -->
<!--               <div class="signin-form"> -->
<!--                 <h4 class="sub-title">Hoặc điền thông tin</h4> -->
<!--                 <form> -->
<!--                   <div class="form-input-icon"> -->
<!--                     <i class="material-icons">&#xE7FD;</i> -->
<!--                     <input type="text" class="form-control" placeholder="Địa chỉ email"> -->
<!--                   </div> -->
<!--                   <div class="form-input-icon"> -->
<!--                     <i class="material-icons">&#xE899;</i> -->
<!--                     <input type="password" class="form-control" placeholder="Mật khẩu từ 6 đến 32 ký tự"> -->
<!--                   </div> -->
<!--                   <div class="form-input-icon"> -->
<!--                     <i class="material-icons">&#xE899;</i> -->
<!--                     <input type="password" class="form-control" placeholder="Gõ lại mật khẩu"> -->
<!--                   </div> -->
<!--                   <div class="margin-top-20"> -->
<!--                     <button type="button" class="btn btn-primary width-150">Đăng ký</button> -->
<!--                   </div> -->
<!--                 </form> -->
<!--               </div> -->
<!--             </div> -->
<!--           </div> -->
<!--           <div class="col-md-5"> -->
<!--             <div class="login text-center"> -->
<!--               <img src="img/logow.png" /> -->
<!--               <h4 class="sub-title">Bạn đã có tài khoản?</h4> -->
<!--               <div class="margin-top-20"> -->
<!--                 <div class="text-center"><a class="btn text-uppercase" href="#">Đăng nhập</a></div> -->
<!--               </div> -->
<!--             </div> -->
<!--           </div> -->
<!--         </div> -->
<!--       </div> -->
<!--     </div> -->
<!--   </div> -->
<!-- </div> -->

