@extends('template.mng.index')
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
		autosize($('textarea'));
		$('.dropify').dropify();
		$('#summernote').summernote({
			height: 250
		});
		$('.selectpicker').selectpicker();

		@if (session('error') && session('error') == 400)
			swal({
				title: 'Thất bại',
				text: 'Thông tin Dịch vụ không hợp lệ!',
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

		$('#btnCreateService').on('click', function(e) {
			$('input[name=image]').val($('span.dropify-render').find('img').attr('src'));
			$('#frmMain').attr('action', '{{ route("mng_service_create") }}');
			$('#frmMain').submit();
		});

		@if (isset($service))
		$('#btnUpdateService').on('click', function(e) {
			$('input[name=image]').val($('span.dropify-render').find('img').attr('src'));
			$('#frmMain').attr('action', '{{ route("mng_service_update", ["id" => $service->id]) }}');
			$('#frmMain').submit();
		});
		@endif
	});
</script>
@endpush

@section('title') service @endsection

@section('content')
<section class="content-body-full-page content-template-1">
	<div class="page-header hf-bg-gradient text-capitalize">Dịch vụ</div>
	<form id="frmMain" class="form-wrapper" method="post" enctype="multipart/form-data" action="">
		<div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-12 form-group">
						<label>Tên dịch vụ</label>
						<input type="text" maxlength="50"
							class="form-control"
							name="name"
							@if (session('error') || !isset($service))
							value="{{ old('name') }}">
							@else
							value="{{ $service->name }}">
							@endif
					</div>
					<div class="col-sm-6 form-group">
						<label>URL</label>
						<input type="text" maxlength="50" style="padding-bottom: 11px;"
							class="form-control"
							name="url_name"
							@if (session('error') || !isset($service))
							value="{{ old('url_name') }}">
							@else
							value="{{ $service->url_name }}">
							@endif
					</div>
					<div class="col-sm-6 form-group">
						<label>Loại dịch vụ</label>
						<div class="col-md-12 style-div text-right">
							<select class="form-control selectpicker hf-select style-select" name="style">
								<optgroup label="Dịch vụ gốc">
									@if (session('error') || !isset($service))
									<option value="0" @if (old('style') == '0') selected @endif>Dịch vụ gốc</option>
									@else
									<option value="0" @if ($service->parent_id == '0') selected @endif>Dịch vụ gốc</option>
									@endif
								</optgroup>
								<optgroup label="Dịch vụ khác">
									@foreach ($roots as $root)
									@if (session('error') || !isset($service))
									<option value="{{ $root->id }}" @if (old('style') == $root->id) selected @endif>{{ $root->name }}</option>
									@else
									<option value="{{ $root->id }}" @if ($service->parent_id == $root->id) selected @endif>{{ $root->name }}</option>
									@endif
									@endforeach
								</optgroup>
							</select>
						</div>
					</div>
					<div class="col-md-12 form-group">
						<label>Từ khóa tìm kiếm</label>
						<textarea class="form-control" name="hint"
							rows="1" maxlength="150">@if (session('error') || !isset($service)){{ old('hint') }}@else{{ $service->hint }}@endif</textarea>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-12 form-group">
						<label>Hình đại diện</label>
						<input id="inpImageDropify" type="file" class="dropify"
							data-allowed-file-extensions="gif png jpg"
							data-max-file-size-preview="3M"
							@if (session('error') || !isset($service))
							@elseif ($service->image)
							data-default-file="{{ env('CDN_HOST') }}/img/service/{{ $service->image }}"
							@endif
							/>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 form-group">
				<label>CSS Nút hiển thị</label>
				<textarea class="form-control" name="css"
					rows="3" maxlength="200">@if (session('error') || !isset($service)){{ old('css') }}@else{{ $service->css }}@endif</textarea>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-right">
				@if (isset($service))
				<button id="btnUpdateService" type="button" class="btn btn-warning width-150">Lưu thay đổi</button>
				@else
				<button id="btnCreateService" type="button" class="btn btn-primary width-150">Tạo mới</button>
				@endif
				<input type="hidden" name="image" value="" />
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			</div>
		</div>
	</form>
</section>
@endsection
