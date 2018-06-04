@extends('template.index') @push('stylesheets')
<script>
$(document).ready(function() {
});
</script>
@endpush @section('title') Blog @endsection @section('content')
<section class="content-template-1 has-bottom-menu">
	<div class="page-banner hf-bg-gradient text-capitalize"
		style="background-image: url('{{ env('CDN_HOST') }}/img/banner/pro_new.png')">
		<div class="page-banner-info">
			<div class="text-capitalize text-center margin-bottom-20"><b>Blog</b></div>
			<div class="text-center" style="font-size: 20px">Khuyến mãi, thông báo, <span style="white-space: nowrap;">mẹo vặt, chia sẻ</span></div>
		</div>
	</div>
	<div class="margin-30 row">
		<div class="col-md-7">
			@if (sizeof($blogs) == 0)
			<div class="row">
				<div class="common-text">Chưa có bài viết nào</div>
			</div>
			@else
			@foreach ($blogs as $blog)
				<div class="margin-bottom-30 blog-row" onclick="location.href='{{ route('blog_page', ['urlName' => $blog->url_name]) }}'">
					<img class="blog-image" src="{{ env('CDN_HOST') }}/img/blog/{{ $blog->image }}" />
					<div class="margin-top-10 margin-bottom-10">
						<span class="margin-right-10 text-uppercase label label-danger">{{ $blog->category }}</span>
						<span style="color: #aaa">{{ Carbon\Carbon::parse($blog->created_at)->format('d/m/Y H:i') }}</span>
					</div>
					<div class="blog-title">{{ $blog->title }}</div>
				</div>
			@endforeach
			@endif
		</div>
		<div class="col-md-5">
			@if (sizeof($highlights) > 0)
			<div class="highlight-row">
				<h3 class="margin-bottom-20">Nổi bật</h3>
				@foreach ($highlights as $h)
				<div class="margin-bottom-10 row">
					<div class="col-xs-8"><a href="{{ route('blog_page', ['urlName' => $h->url_name]) }}">{{ $h->title }}</a></div>
					<div class="col-xs-4">
						<img src="{{ env('CDN_HOST') }}/img/blog/{{ $h->image }}" />
					</div>
				</div>
				@endforeach
			</div>
			@endif
		</div>
	</div>
	<div >
	</div>
</section>
@endsection
@include('template.mb.footer-menu')