@extends('template.index')
@push('stylesheets')
<style>
	.content-template-1 .btn-group {
		width: auto !important;
	}
	.style-div .btn-group {
		width: 100% !important;
	}
	.style-select a {
		text-align: right;
	}
	.style-select .filter-option {
		text-align: center !important;
	}
</style>

<!-- Page Scripts -->
<script>
	$(document).ready(function() {
		$('.dropify').dropify();
		$('#summernote').summernote({
			height: 250
		});
		$('.selectpicker').selectpicker();

		@if (session('error') && session('error') == 400)
			swal({
				title: 'Thất bại',
				text: 'Nội dung bài viết không hợp lệ!',
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

		$('#frmMain').validate({
			submit: {
				settings: {
					inputContainer: '.form-group',
					errorListClass: 'form-control-error',
					errorClass: 'has-danger',
				}
			},
		});

		$('#btnPostBlog, #btnUpdateBlog').on('click', function(e) {
			e.preventDefault();
			$('input[name=image]').val($('span.dropify-render').find('img').attr('src'));
			$('#frmMain').attr('action', '{{ route("post_blog") }}');
			$('#frmMain').submit();
		});

		$('#btnDeleteBlog').on('click', function(e) {
			e.preventDefault();
			swal({
				title: 'Xóa blog',
				text: 'Bạn muốn xóa bài đăng này?',
				type: 'warning',
				showCancelButton: true,
				cancelButtonClass: 'btn-default',
				confirmButtonClass: 'btn-danger',
				cancelButtonText: 'Quay lại',
				confirmButtonText: 'Xóa bài',
			},
			function() {
				$('#frmMain').attr('action', '{{ route("delete_blog") }}');
				$('#frmMain').submit();
			});
		});
	});
</script>
@endpush

@section('title') Blog @endsection

@section('content')
<section class="content-body-full-page content-template-1">
	<div class="page-header hf-bg-gradient text-capitalize">Blog</div>
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
							@if (session('error') || !session()->has('blog'))
							value="{{ old('title') }}">
							@else
							value="{{ $blog->title }}">
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
							@if (session('error') || !session()->has('blog'))
							value="{{ old('urlName') }}">
							@else
							value="{{ $blog->url_name }}">
							@endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 form-group">
						<label>Đối tượng</label>
						<div class="row">
						<div class="col-md-12 style-div text-right">
							<select class="form-control selectpicker hf-select style-select" name="style">
							@if (session('error') || !session()->has('blog'))
								<option value="0" @if(old('style') == '0') selected @endif>Chung</option>
								<option value="1" @if(old('style') == '1') selected @endif>Đối tác</option>
							@else
								<option value="0" @if($blog->style == '0') selected @endif>Chung</option>
								<option value="1" @if($blog->style == '1') selected @endif>Đối tác</option>
							@endif
							</select>
						</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="row">
					<div class="col-md-12 form-group">
						<label>Hình đại diện</label>
						<input id="inpImageDropify" type="file" class="dropify"
							accept="image/*"
							@if (session('error') || !session()->has('blog'))
							@else
							data-default-file="{{ env('CDN_HOST') }}/img/blog/{{ $blog->image }}"
							@endif
							/>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 form-group">
				<label>Nội dung bài viết</label>
				<textarea id="summernote"
						class="form-control"
						name="content">@if (session('error') || !session()->has('blog')){{ old('content') }}@else{{ $blog->content }}@endif</textarea>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12 text-right">
				@if (session('blog'))
				<button id="btnUpdateBlog" type="button" class="btn btn-warning width-150">Lưu thay đổi</button>
				<button id="btnDeleteBlog" type="button" class="btn btn-danger width-150">Xóa</button>
				@else
				<button id="btnPostBlog" type="button" class="btn btn-primary width-150">Đăng bài viết</button>
				@endif
				<input type="hidden" name="image" value="" />
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			</div>
		</div>
	</form>
</section>
@endsection
