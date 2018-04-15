<div id="{{ $caroId }}" class="blog-carousel carousel slide" data-ride="carousel">
	<ol class="carousel-indicators">
		@foreach ($blogs as $key=>$blog) @if($key == 3) @break @endif
		<li data-target="#{{ $caroId }}" data-slide-to="{{ $key }}" @if($key == 0) class="active" @endif></li>
		@endforeach
	</ol>
	<div class="carousel-inner" role="listbox">
		@foreach ($blogs as $key=>$blog) @if($key == 3) @break @endif
		<div class="carousel-item @if($key == 0) active @endif">
			<img src="{{ env('CDN_HOST') }}/img/blog/{{ $blog->image }}">
			<div class="carousel-caption">
					<p>{{ $blog->title }}</p>
			</div>
		</div>
		@endforeach
	</div>
	<a class="left carousel-control" data-target="#{{ $caroId }}" role="button" data-slide="prev">
		<span class="icon-prev fa fa-arrow-left" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="right carousel-control" data-target="#{{ $caroId }}" role="button" data-slide="next">
		<span class="icon-next fa fa-arrow-right" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a>
</div>
