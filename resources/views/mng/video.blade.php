@extends('template.index')
@push('stylesheets')
<style>
	.content-template-1 .btn-group {
		width: auto !important;
	}
</style>

<!-- Page Scripts -->
<script>
	$(document).ready(function() {
		$('.dropify').dropify();

		@if (session('error') && session('error') == 400)
			swal({
				title: 'Thất bại',
				text: 'Thông tin không hợp lệ!',
				type: 'error',
				confirmButtonClass: 'btn-danger',
				confirmButtonText: 'Kiểm tra lại',
			});
		@elseif (session('error'))
			swal({
				title: 'Thất bại',
				text: '{{ session("error") }}',
				type: 'error',
				confirmButtonClass: 'btn-default',
				confirmButtonText: 'Quay lại',
			});
		@endif

		

		@if (isset($video))
		$('#btnUpdateVideo').on('click', function(e) {
			swal({
				title: 'Đang xử lý yêu cầu',
				text: 'Xin chờ trong giây lát!',
				type: 'info',
				showConfirmButton: false,
				closeOnConfirm: false,
			});
			
			$('input[name=image]').val($('span.dropify-render').find('img').attr('src'));
			$('#frmMain').attr('action', '{{ route("mng_video_update", ["id" => $video->id]) }}');
			$('#frmMain').submit();
		});
		@else
		$('#btnCreateVideo').on('click', function(e) {
			swal({
				title: 'Đang xử lý yêu cầu',
				text: 'Xin chờ trong giây lát!',
				type: 'info',
				showConfirmButton: false,
				closeOnConfirm: false,
			});
			
			$('input[name=image]').val($('span.dropify-render').find('img').attr('src'));
			$('#frmMain').attr('action', '{{ route("mng_video_new") }}');
			$('#frmMain').submit();
		});
		@endif
	});
</script>
@endpush

@section('title') Video @endsection

@section('content')
<section class="content-body-full-page content-template-1">
	<div class="page-header hf-bg-gradient text-capitalize">Video</div>
	<form id="frmMain" class="form-wrapper" method="post" enctype="multipart/form-data" action="">
		<div class="row">
			<div class="col-md-8">
				<div class="row">
					<div class="col-md-12 form-group">
						<label>Tiêu đề</label>
						<input type="text" maxlength="150" onkeyup="changeToUrl();"
							class="form-control"
							id="title"
							name="title"
							@if (session('error') || !isset($video))
							value="{{ old('title') }}">
							@else
							value="{{ $video->title }}">
							@endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 form-group">
						<label>URL</label>
						<input type="text" maxlength="150"
							class="form-control"
							id="urlName"
							name="urlName"
							@if (session('error') || !isset($video))
							value="{{ old('urlName') }}">
							@else
							value="{{ $video->url_name }}">
							@endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 form-group">
						<label>Video</label>
						<input type="file"
							class="form-control"
							name="file">
						@if (isset($video))
						<br />
						<small>Video hiện tại: {{ $video->content }}</small>
						@endif
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="row">
					<div class="col-md-12 form-group">
						<label>Hình đại diện</label>
						<input id="inpImageDropify" type="file" class="dropify"
							data-allowed-file-extensions="gif png jpg"
							data-max-file-size-preview="3M"
							@if (session('error') || !isset($video))
							@else
							data-default-file="{{ env('CDN_HOST') }}/img/blog/{{ $video->image }}"
							@endif
							/>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-right">
				@if (isset($video))
				<button id="btnUpdateVideo" type="button" class="btn btn-warning width-150">Lưu thay đổi</button>
				@else
				<button id="btnCreateVideo" type="button" class="btn btn-primary width-150">Tạo video</button>
				@endif
				<input type="hidden" name="image" value="" />
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			</div>
		</div>
	</form>
</section>
@endsection
