@extends('template.index') @push('stylesheets')
<script>
$(document).ready(function() {
  $('.carousel').carousel({
    interval: 5000
  });
});
</script>
@endpush @section('title') Blog @endsection @section('content')
<section class="content-body has-bottom-menu">
  <div class="page-header hf-bg-gradient text-capitalize">Blog</div>
  <div class="nav-tabs-horizontal orders-page">
    <ul class="nav nav-tabs nav-page hf-bg-gradient text-uppercase" role="tablist">
      <li class="nav-item">
        <a class="nav-link active pull-right" href="javascript: void(0);" data-toggle="tab" data-target="#generalTab" role="tab" aria-expanded="true">Chung</a>
      </li>
      <li class="nav-item">
        <a class="nav-link right pull-left" href="javascript: void(0);" data-toggle="tab" data-target="#proTab" role="tab" aria-expanded="false">Đối tác</a>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="generalTab" role="tabpanel" aria-expanded="true">
        <div class="row blog-carousel-row">
          @php $blogs = $genBlogs; $caroId = 'genBlogs' @endphp
          @include('blog.blog-carousel')
        </div>
      </div>
      <div class="tab-pane" id="proTab" role="tabpanel" aria-expanded="false">
        <div class="row">
          <div class="common-text">Chưa có thông báo</div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@include('template.mb.footer-menu')