<div class="row blog-row" onclick="location.href='{{ route('blog_page', ['urlName' => $blog->url_name]) }}'">
  <div class="col-md-12 col-sm-12 col-sx-12">
    <img class="blog-image" src="{{ env('CDN_HOST') }}/img/blog/{{ $blog->image }}" />
    <div class="blog-title">{{ $blog->title }}</div>
  </div>
</div>