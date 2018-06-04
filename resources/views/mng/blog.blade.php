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
		$('#summernote').summernote({
			height: 250
		});
		$('.selectpicker').selectpicker();
		
		var categories = [ @foreach ($categories as $c) '{{ $c->category }}', @endforeach ];
		$.typeahead({
			input: "#category",
			order: "asc",
			minLength: 1,
			maxItem: 0,
			source: {
				data: categories
			},
			cancelButton: false,
			accent: true,
		});

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

		

		@if (isset($blog))
		$('#btnUpdateBlog').on('click', function(e) {
			swal({
				title: 'Đang xử lý yêu cầu',
				text: 'Xin chờ trong giây lát!',
				type: 'info',
				showConfirmButton: false,
				closeOnConfirm: false,
			});
			
			$('input[name=image]').val($('span.dropify-render').find('img').attr('src'));
			$('#frmMain').attr('action', '{{ route("mng_blog_update", ["id" => $blog->id]) }}');
			$('#frmMain').submit();
		});
		@else
		$('#btnPostBlog').on('click', function(e) {
			swal({
				title: 'Đang xử lý yêu cầu',
				text: 'Xin chờ trong giây lát!',
				type: 'info',
				showConfirmButton: false,
				closeOnConfirm: false,
			});
			
			$('input[name=image]').val($('span.dropify-render').find('img').attr('src'));
			$('#frmMain').attr('action', '{{ route("mng_blog_new") }}');
			$('#frmMain').submit();
		});
		@endif
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
							@if (session('error') || !isset($blog))
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
							@if (session('error') || !isset($blog))
							value="{{ old('urlName') }}">
							@else
							value="{{ $blog->url_name }}">
							@endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 form-group">
						<label>Chủ đề</label>
						<div class="row">
						<div class="col-md-12 text-right">
							<div class="typeahead__container">
								<div class="typeahead__field">
									<span class="typeahead__query">
										<input id="category"
												class="input-search form-control"
												maxlength="100"
												name="category"
												type="text"
												placeholder="Tìm chủ đề hoặc Nhập chủ đề mới"
												autocomplete="off"
												@if (session('error') || !isset($blog))
												value="{{ old('category') }}">
												@else
												value="{{ $blog->category }}">
												@endif
									</span>
								</div>
							</div>
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
							data-allowed-file-extensions="gif png jpg"
							data-max-file-size-preview="3M"
							@if (session('error') || !isset($blog))
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
						name="content">@if (session('error') || !isset($blog)){{ old('content') }}@else{{ $blog->content }}@endif</textarea>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12 text-right">
				@if (isset($blog))
				<button id="btnUpdateBlog" type="button" class="btn btn-warning width-150">Lưu thay đổi</button>
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
