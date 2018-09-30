@extends('template.index') @push('stylesheets')
<script>
$(document).ready(function() {
});
</script>
@endpush
@section('title') 404 @endsection
@section('content')
<div class="text-center">
	<div>
		<img src="{{ env('CDN_HOST') }}/img/404.png"
			style="width: 300px; height: 300px; display: block; margin-left: auto; margin-right: auto">
		
	</div>
	<h1 class="color-info">404</h1>
	<div><span>Không tìm thấy trang này</span></div>
	
	<button type="button"
		class="margin-top-50 text-center btn btn-primary width-150"
		onclick="location.href = '{{ route('home_page') }}'">Trở về trang chủ</button>
</div>
@endsection