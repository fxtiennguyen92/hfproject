@extends('template.index')
@push('stylesheets')
<style>
</style>

<!-- Page Scripts -->
<script>
	$(document).ready(function() {
		$('.ddServices').select2({ closeOnSelect: false });
		$('.selectpicker').selectpicker();
		$('.ddCity').on('change', function() {
			if ($(this).val() == '') {
				return false;
			}
			
			var ddDist = $(this).parent().parent().parent().parent().find('select.ddDist');
			ddDist.children('option').remove();
			
			var url = '{{ route("get_dist_by_city", ["code" => "cityCode"]) }}';
			url = url.replace('cityCode', $(this).val());
			$.ajax({
				url: url,
				success: function (data) {
					$.each(data, function(key, value) {
						ddDist.append($('<option></option>')
									.attr('value', value.code)
									.text(value.name));
					});

					ddDist.selectpicker('refresh');
				}
			});
		});
		$('input[name=email]').on('change', function() {
			if ($(this).val() !== '') {
				$(this).addValidation('EMAIL');
			} else {
				$(this).removeValidation('EMAIL');
			}
		});
		$('#frmMain').validate({
			submit: {
				settings: {
					inputContainer: '.form-group',
					errorListClass: 'form-control-error',
					errorClass: 'has-danger',
				},
				callback: {
					onError: function () {
						$.notify({
							title: '<strong>Thất bại! </strong>',
							message: 'Thông tin chưa đúng hoặc chưa đầy đủ.'
						}, {
							type: 'danger',
							z_index: 1051,
						});
					},
					onSubmit: function() {
						var url = "{{ route('modify_company', ['id' => 'companyId']) }}";
						@if ($company)
							url = "{{ route('modify_company', ['id' => $company->id]) }}";
						@endif
						
						$.ajax({
							type: 'POST',
							url: url,
							data: $('#frmMain').serialize(),
							success: function(response) {
								$.notify({
									title: '<strong>Hoàn tất! </strong>',
									message: 'Cập nhật thành công.'
								}, {
									type: 'success',
									z_index: 1051,
								});

								setTimeout(function() {
									location.reload();
								}, 1500);
							},
							error: function(xhr) {
								if (xhr.status == 400) {
									$.notify({
										title: '<strong>Thất bại! </strong>',
										message: 'Doanh nghiệp này không tồn tại.'
									}, {
										type: 'danger',
										z_index: 1051,
									});
								} else if (xhr.status == 409) {
									$.notify({
										title: '<strong>Thất bại! </strong>',
										message: 'Thông tin cập nhật chưa đúng định dạng.'
									}, {
										type: 'danger',
										z_index: 1051,
									});
								} else {
									$.notify({
										title: '<strong>Thất bại! </strong>',
										message: 'Không cập nhật được, vui lòng thử lại.'
									}, {
										type: 'danger',
										z_index: 1051,
									});
								};
							}
						});
					}
				}
			}
		});
		$('#btnList').on('click', function() {
			swal({
				title: '',
				text: 'Bạn muốn đến trang Danh sách Doanh Nghiệp?',
				type: 'info',
				showCancelButton: true,
				cancelButtonClass: 'btn-default',
				confirmButtonClass: 'btn-primary',
				cancelButtonText: 'Hủy',
				confirmButtonText: 'Tiếp tục',
			},
			function(){
				location.href = "{{ route('mng_company_list_page') }}";
			});
		});
	});
</script>
@endpush

@section('title') Doanh nghiệp @endsection

@section('content')
<section class="content-body-full-page content-template-1">
	<div class="page-header hf-bg-gradient text-capitalize">Doanh nghiệp</div>
	<div class="form-wrapper">
		<form id="frmMain" name="form-validation" method="post" enctype="multipart/form-data" action="{{ route('modify_company') }}">
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Tên Doanh nghiệp / Cửa Hàng</label>
								<input type="text" maxlength="150" class="form-control" name="name" type="text" data-validation="[NOTEMPTY]"
								@if ($company) value="{{ $company->name }}" @endif>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Địa chỉ</label>
								<input type="text" maxlength="150" class="form-control" name="address" data-validation="[NOTEMPTY]"
								@if ($company) value="{{ $company->address }}" @endif>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Quận/Huyện</label>
								<select class="form-control selectpicker ddDist hf-select" data-live-search="true" name="dist" data-validation="[NOTEMPTY]">
									@foreach ($districts as $dist)
										@if ($company)
										<option value="{{ $dist->code }}" @if ($company->district == $dist->code) selected @endif>{{ $dist->name }}</option>
										@else
										<option value="{{ $dist->code }}">{{ $dist->name }}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Thành phố/Tỉnh</label>
								<select class="form-control selectpicker ddCity hf-select" data-live-search="true" name="city" data-validation="[NOTEMPTY]">
									@foreach ($cities as $city)
										@if ($company)
										<option value="{{ $city->code }}" @if ($company->city == $city->code) selected @endif>{{ $city->name }}</option>
										@else
										<option value="{{ $city->code }}">{{ $city->name }}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Email</label>
								<input type="text" maxlength="100" class="form-control" name="email"
								@if ($company && $company->email) value="{{ $company->email }}" data-validation="[EMAIL]" @endif>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Số điện thoại</label>
								<input type="text" maxlength="50" class="form-control" name="phone"
								@if ($company) value="{{ $company->phone }}" @endif>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Dịch vụ cung cấp</label>
								<select class="form-control ddServices hf-select" multiple name="services[]">
									@foreach ($services as $service)
										@if ($company && $company->services)
											@if (in_array($service->id, json_decode($company->services, true)))
										<option value="{{ $service->id }}" selected>{{ $service->name }}</option>
											@else
										<option value="{{ $service->id }}">{{ $service->name }}</option>
											@endif
										@else
										<option value="{{ $service->id }}">{{ $service->name }}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group text-right">
				<button id="btnList" type="button" class="btn btn-default width-150 margin-top-50">Danh sách DN</button>
				<button id="btnSubmit" type="submit" class="btn btn-primary width-150 margin-top-50">
					@if ($company) Cập nhật @else Đăng ký @endif
				</button>
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			</div>
		</form>
	</div>
	<!-- MODAL -->
</section>
@endsection
