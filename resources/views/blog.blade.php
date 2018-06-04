@extends('template.index') @push('stylesheets')
<script>
$(document).ready(function() {
});
</script>
@endpush @section('title') Blog @endsection @section('content')
<section class="content-body blog-section">
  <div class="has-mb-button-bottom" style="min-height: 513px">
    <img class="blog-image" src="{{ env('CDN_HOST') }}/img/blog/{{ $blog->image }}">
    <div class="blog-icon">
      <img src="{{ env('CDN_HOST') }}/img/logo/logoh.png">
      <span class="label label-danger blog-style pull-right text-upper">{{ $blog->category }}</span>
    </div>
    <div class="blog-title">{{ $blog->title }}</div>
    <div class="blog-create-date color-primary">{{ Carbon\Carbon::parse($blog->created_at)->format('d/m/Y H:i') }}</div>
    <div class="blog-content">{!! $blog->content !!}</div>
  </div>
</section>
@endsection
