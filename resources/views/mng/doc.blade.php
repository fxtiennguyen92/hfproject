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
		@if (session('error'))
			swal({
				title: 'Thất bại',
				text: '{{ session("error") }}',
				type: 'error',
				confirmButtonClass: 'btn-danger',
				confirmButtonText: 'Kiểm tra lại',
			});
		@endif
		
		$('.dropify').dropify();
		$('#summernote').summernote({
			height: 250
		});
		
		$('#frmMain').validate({
			submit: {
				settings: {
					inputContainer: '.form-group',
					errorListClass: 'form-control-error',
					errorClass: 'has-danger',
				}
			},
		});

		$('#btnCreateDoc').on('click', function(e) {
			e.preventDefault();
			loadingBtnSubmit($(this).attr('id'));
			
			$('#frmMain').attr('action', '{{ route("mng_doc_create") }}');
			$('#frmMain').submit();
		});

		@if (session()->has('doc'))
		$('#btnUpdateDoc').on('click', function(e) {
			e.preventDefault();
			loadingBtnSubmit($(this).attr('id'));
			
			$('#frmMain').attr('action', '{{ route("mng_doc_update", ["id" => $doc->id ]) }}');
			$('#frmMain').submit();
		});

		$('#btnDeleteDoc').on('click', function(e) {
			e.preventDefault();
			swal({
				title: 'Xóa tài liệu',
				text: 'Bạn muốn xóa tài liệu này?',
				type: 'warning',
				showCancelButton: true,
				cancelButtonClass: 'btn-default',
				confirmButtonClass: 'btn-danger',
				cancelButtonText: 'Quay lại',
				confirmButtonText: 'Xóa',
			},
			function() {
				loadingBtnSubmit('btnDeleteDoc');
				
				$('#frmMain').attr('action', '{{ route("mng_doc_delete", ["id" => $doc->id ]) }}');
				$('#frmMain').submit();
			});
		});
		@endif
	});
</script>
@endpush

@section('title') Tài liệu @endsection

@section('content')
<section class="content-body-full-page content-template-1">
	<div class="page-header hf-bg-gradient text-capitalize">Tài liệu</div>
	<form id="frmMain" class="form-wrapper" method="post" enctype="multipart/form-data" action="">
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12 form-group">
						<label>Tiêu đề</label>
						<input type="text" maxlength="150"
							class="form-control"
							id="title"
							name="title"
							@if (session('error') || !session()->has('doc'))
							value="{{ old('title') }}">
							@else
							value="{{ $doc->title }}">
							@endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 form-group">
						<label>URL</label>
						<input type="text" maxlength="45"
							class="form-control"
							name="url_name"
							@if (session('error') || !session()->has('doc'))
							value="{{ old('url_name') }}">
							@else
							value="{{ $doc->url_name }}">
							@endif
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 form-group">
				<label>Nội dung</label>
				<textarea id="summernote"
						class="form-control"
						name="content">@if (session('error') || !session()->has('doc')){{ old('content') }}@else{{ $doc->content }}@endif</textarea>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12 text-right">
				@if (session('doc'))
				<button id="btnUpdateDoc" type="button" class="btn btn-warning width-150">Lưu thay đổi</button>
				<button id="btnDeleteDoc" type="button" class="btn btn-danger width-150">Xóa</button>
				@else
				<button id="btnCreateDoc" type="button" class="btn btn-primary width-150">Thêm mới</button>
				@endif
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			</div>
		</div>
	</form>
</section>
@endsection
