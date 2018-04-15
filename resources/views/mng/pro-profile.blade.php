@extends('template.index')

@push('stylesheets')
	<script src="assets/vendors/angular/angular.min.js"></script>
	<script src="assets/vendors/img-crop/ng-img-crop.js"></script>
	<style>
		.cropArea {
			height: 200px;
		}
		
		.top-submenu .avatar {
			position: relative;
		}
		
		.top-submenu .avatar:before {
			position: absolute;
			font-family: FontAwesome;
			content: '\f030  Avatar';
			width: 100%;
			height: 100%;
			line-height: 120px;
			background: rgba(0, 0, 0, .2);
			color: #ffffff;
			font-weight: bold;
			display: none;
		}
		
		.top-submenu .avatar:hover:before {
			display: block;
		}
		
		.image_avatar {
			-webkit-border-radius: 100%;
			-moz-border-radius: 100%;
			border-radius: 100%;
		}
		
		img-crop {
			width: 100%;
			height: 100%;
			display: block;
			position: relative;
			overflow: hidden
		}
		
		img-crop canvas {
			display: block;
			position: absolute;
			top: 50%;
			left: 50%;
			outline: 0;
			-webkit-tap-highlight-color: transparent
		}
		#image_avatar {
			max-height: 200px;
			border-radius: 100%;
		}
		.btn-file {
			position: relative;
			overflow: hidden;
		}
		.btn-file input[type=file] {
			position: absolute;
			top: 0;
			right: 0;
			min-width: 100%;
			min-height: 100%;
			font-size: 100px;
			text-align: right;
			filter: alpha(opacity=0);
			opacity: 0;
			outline: none;
			background: white;
			cursor: inherit;
			display: block;
		}
		ul.dropdown-menu {
			width: 100% !important
		}
	</style>

	<!-- Page Scripts -->
	<script>
	$(document).ready(function() {
		<!-- Avatar - STA -->
		$('#fileInput').on('change', function() {
			$('#btnSaveImage').show();
		});
		$('#btnSaveImage').on('click', function() {
			$('#avatar').val($('#image_avatar').attr('ng-src'));
		});
		<!-- Avatar - END -->

		$('.datepicker-only-init').datetimepicker({
			maxDate: moment(),
			minDate: moment().subtract(100, 'year'),
			locale: moment.locale('vi'),
			format: 'DD/MM/YYYY',
			icons: {
				time: 'fa fa-clock-o',
				date: 'fa fa-calendar',
				up: 'fa fa-chevron-up',
				down: 'fa fa-chevron-down',
				previous: 'fa fa-chevron-left',
				next: 'fa fa-chevron-right',
				today: 'fa fa-screenshot',
				clear: 'fa fa-trash',
				close: 'fa fa-check'
			},
		});
		$('.phone').mask('0000000000000');
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
		$('label.btn').on('click', function() {
			$(this).find('span').each(function() {
				if ($(this).hasClass('icmn-checkbox-unchecked2')) {
					$(this).removeClass('icmn-checkbox-unchecked2').addClass('icmn-checkbox-checked2');
				} else {
					$(this).removeClass('icmn-checkbox-checked2').addClass('icmn-checkbox-unchecked2');
				}
			});
		});

		$('input[name=dateOfBirth]').val("{{ Carbon\Carbon::parse($pro->profile->date_of_birth)->format('d/m/Y') }}");
		$('input[name=govDate]').val("{{ json_decode($pro->profile->gov_id)->date }}");

		$('select[name=gender]').val("{{ $pro->profile->gender }}");
		$('select[name=gender]').selectpicker('refresh');
		$('select[name=familyRegDist]').val("{{ $pro->profile->fg_district }}");
		$('select[name=familyRegDist]').selectpicker('refresh');
		$('select[name=familyRegCity]').val("{{ $pro->profile->fg_city }}");
		$('select[name=familyRegCity]').selectpicker('refresh');

		$('select[name=dist]').val("{{ $pro->profile->district }}");
		$('select[name=dist]').selectpicker('refresh');
		$('select[name=city]').val("{{ $pro->profile->city }}");
		$('select[name=city]').selectpicker('refresh');

		@if ($pro->profile->company)
		$('select[name=compDist]').val("{{ $pro->profile->company->district }}");
		$('select[name=compDist]').selectpicker('refresh');
		$('select[name=compCity]').val("{{ $pro->profile->company->city }}");
		$('select[name=compCity]').selectpicker('refresh');
		@endif

		$('#frmMain').validate({
			submit: {
				settings: {
					inputContainer: '.form-group',
					errorListClass: 'form-control-error',
					errorClass: 'has-danger',
				},
				callback: {
					onSubmit: function() {
						$.ajax({
							type: 'POST',
							url: '{{ route("change_pro_profile") }}',
							data: $('#frmMain').serialize(),
							success: function(response) {
								
							},
							error: function(xhr) {
								if (xhr.status == 400) {
									$.notify({
										title: '<strong>Thất bại! </strong>',
										message: 'Không có thông tin để thay đổi.'
									},{
										type: 'danger',
										z_index: 1051,
									});
								} else {
									$.notify({
										title: '<strong>Thất bại! </strong>',
										message: 'Không thể Cập nhật thông tin cá nhân.'
									},{
										type: 'danger',
										z_index: 1051,
									});
								};
	
								setTimeout(function() {
									location.reload();
								}, 1500);
							}
						});
					}
				}
			}
		});

		$('#btnUpdate').on('click', function() {
			var url = '{{ route("update_pro_cv") }}';

			$.ajax({
				type: 'POST',
				url: url,
				data: $('#frmApprove').serialize(),
				success: function(response) {
					swal({
						title: 'Thành công',
						text: 'Đã cập nhật thành công.',
						type: 'info',
						confirmButtonClass: 'btn-primary',
						confirmButtonText: 'Kết thúc',
					},
					function() {
						location.reload();
					});
				},
				error: function(xhr) {
					$.notify({
						title: '<strong>Thất bại! </strong>',
						message: 'Có lỗi phát sinh, xin thử lại.'
					}, {
						type: 'danger',
						z_index: 1051,
					});
				}
			});
		});

		$('#btnActive').on('click', function() {
			var url = '{{ route("active_pro") }}';
			
			swal({
				title: '',
				text: 'Bạn muốn kích hoạt Tài khoản này?',
				type: 'info',
				showCancelButton: true,
				cancelButtonClass: 'btn-default',
				confirmButtonClass: 'btn-info',
				cancelButtonText: 'Quay lại',
				confirmButtonText: 'Kích hoạt',
			},
			function(){
				$.ajax({
					type: 'POST',
					url: url,
					data: $('#frmApprove').serialize(),
					success: function(response) {
						swal({
							title: 'Thành công',
							text: 'Tài khoản đã được kích hoạt.',
							type: 'info',
							confirmButtonClass: 'btn-primary',
							confirmButtonText: 'Kết thúc',
						},
						function() {
							location.reload();
						});
					},
					error: function(xhr) {
						$.notify({
							title: '<strong>Thất bại! </strong>',
							message: 'Không thể kích hoạt Nhân viên này.'
						}, {
							type: 'danger',
							z_index: 1051,
						});
					}
				});
			});
		});
	});
	
	angular.module('app', ['ngImgCrop'])
	.config(['$interpolateProvider', function ($interpolateProvider) {
		$interpolateProvider.startSymbol('[[');
		$interpolateProvider.endSymbol(']]');
	}])
	.controller('Ctrl', function($scope) {
		$scope.myImage='';
		$scope.myCroppedImage='';
		var handleFileSelect=function(evt) {
			var file=evt.currentTarget.files[0];
			var reader = new FileReader();
			reader.onload = function (evt) {
				$scope.$apply(function($scope){
					$scope.myImage=evt.target.result;
				});
			};
			reader.readAsDataURL(file);
		};
		angular.element(document.querySelector('#fileInput')).on('change', handleFileSelect);
	});
	</script>

@endpush

@section('title') Đối tác @endsection

@section('content')
<section class="content-body-full-page content-template-1" ng-app="app" ng-controller="Ctrl">
	<form id="frmMain" class="form-wrapper" name="form-validation" method="post" enctype="multipart/form-data" action="">
		<div class="row">
			<div class="col-md-4 text-center">
				<a class="avatar" style="width:80px;height:80px" href="javascript:void(0);" data-toggle="modal" data-target="#avatar-modal">
					<img id="userAvatar" src="{{ env('IMAGE_HOST') }}/{{ $pro->id}}/{{ $pro->avatar }}">
				</a>
			</div>
			<div class="col-md-4">
				<h1 class="page-title" style="text-align: left;">Thông tin Đối tác</h1>
			</div>
			<div class="col-md-4 text-right">
				@if ($pro->delete_flg == 1)
					<span class="label label-secondary">Đã xóa</span>
				@elseif ($pro->profile->state == '1')
					<span class="label label-primary">Sẵn Sàng</span>
				@elseif ($pro->profile->state == '2')
					<span class="label label-default">Treo</span>
				@elseif ($pro->profile->state == '3')
					<span class="label label-warning">Cảnh cáo</span>
				@elseif ($pro->profile->state == '4')
					<span class="label label-danger">Khóa</span>
				@elseif ($pro->profile->state == '5')
					<span class="label label-secondary">Cấm vĩnh viễn</span>
				@else
					<span class="label label-success">Chờ Duyệt</span>
				@endif
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="row form-group">
					<label>Họ tên</label>
					<input type="text" maxlength="200"
						class="form-control"
						name="name"
						data-validation="[NOTEMPTY]"
						value="{{ $pro->name }}">
				</div>
				<div class="row">
					<div class="col-md-7 form-group">
						<label>Ngày tháng năm sinh</label>
						<input type="text" maxlength="10"
							class="form-control datepicker-only-init"
							name="dateOfBirth"
							data-validation="[NOTEMPTY]"/>
					</div>
					<div class="col-md-5 form-group">
						<label>Giới tính</label>
						<select class="form-control selectpicker hf-select" name="gender">
							<option value="1">Nam</option>
							<option value="2">Nữ</option>
							<option value="0">Khác</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-md-7 form-group">
						<label>Email</label>
						<input type="text" maxlength="100" class="form-control"
							name="email"
							value="{{ $pro->email }}"
							data-validation="[NOTEMPTY]">
					</div>
					<div class="col-md-5 form-group">
						<label>Số điện thoại</label>
						<input type="text" class="form-control phone"
							name="phone"
							value="{{ $pro->phone }}"
							data-validation="[NOTEMPTY]">
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 form-group">
						<label>Số CMND</label>
						<input type="text" maxlength="12" class="form-control" name="govId"
							value="{{ json_decode($pro->profile->gov_id)->id }}">
					</div>
					<div class="col-md-3 form-group">
						<label>Ngày cấp</label>
						<input type="text" maxlength="10" class="form-control datepicker-only-init" name="govDate">
					</div>
					<div class="col-md-5 form-group">
						<label>Nơi cấp</label>
						<input type="text" maxlength="50" class="form-control" name="govPlace"
							value="{{ json_decode($pro->profile->gov_id)->place }}">
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Hộ khẩu</label>
							<input type="text" maxlength="150" class="form-control" name="familyRegAddress"
								value="{{ $pro->profile->fg_address }}"
								data-validation="[NOTEMPTY]">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Quận/Huyện</label>
							<select class="form-control selectpicker ddDist hf-select" data-live-search="true" name="familyRegDist" data-validation="[NOTEMPTY]">
								@foreach($districts as $dist)
								<option value="{{ $dist->code }}">{{ $dist->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Thành phố/Tỉnh</label>
							<select class="form-control selectpicker ddCity hf-select" data-live-search="true" name="familyRegCity" data-validation="[NOTEMPTY]">
								@foreach($cities as $city)
								<option value="{{ $city->code }}">{{ $city->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Chỗ ở hiện nay</label>
							<input type="text" maxlength="150" class="form-control" name="address"
								value="{{ $pro->profile->address }}"
								data-validation="[NOTEMPTY]">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Quận/Huyện</label>
							<select class="form-control selectpicker ddDist hf-select" data-live-search="true" name="dist" data-validation="[NOTEMPTY]">
								@foreach($districts as $dist)
								<option value="{{ $dist->code }}">{{ $dist->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Thành phố/Tỉnh</label>
							<select class="form-control selectpicker ddCity hf-select" data-live-search="true" name="city" data-validation="[NOTEMPTY]">
								@foreach($cities as $city)
								<option value="{{ $city->code }}">{{ $city->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				@if ($pro->profile->company)
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Tên Doanh nghiệp</label>
							<input type="text" maxlength="150" class="comp-name form-control"
								name="compName"
								value="{{ $pro->profile->company->name }}">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label>Địa chỉ Doanh nghiệp</label>
							<input type="text" maxlength="150" class="comp-addr form-control"
								name="compAddress"
								value="{{ $pro->profile->company->address }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Quận/Huyện</label>
							<select class="form-control selectpicker ddDist hf-select" data-live-search="true" name="compDist">
								@foreach($districts as $dist)
								<option value="{{ $dist->code }}">{{ $dist->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Thành phố/Tỉnh</label>
							<select class="form-control selectpicker ddCity hf-select" data-live-search="true" name="compCity">
								@foreach($cities as $city)
								<option value="{{ $city->code }}">{{ $city->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Dịch vụ tham gia</label>
							<select class="form-control ddServices hf-select" multiple name="services[]">
								@foreach($services as $service)
									@if (!is_null($pro->profile->company->services) && in_array($service->id, json_decode($pro->profile->company->services)))
									<option value="{{ $service->id }}" selected>{{ $service->name }}</option>
									@else
									<option value="{{ $service->id }}">{{ $service->name }}</option>
									@endif
								@endforeach
							</select>
						</div>
					</div>
				</div>
				@else
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Hình thức kinh doanh</label>
							<input type="text"class=" form-control"
								value="Kinh doanh cá nhân" readonly>
						</div>
					</div>
				</div>
				@endif
			</div>
		</div>
	</form>
	
	<!-- MODAL -->
	<div id="avatar-modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<form id="frmImage" method="post" enctype="multipart/form-data" action="{{ route('approve_pro_avatar') }}">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Hình ảnh đại diện</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="cropArea col-md-6 col-sm-6">
								<img-crop image="myImage"
									result-image="myCroppedImage"
									result-image-quality="1"
									result-image-size="500"></img-crop>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="text-center"><img id="image_avatar" ng-src="[[myCroppedImage]]" /> </div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<label class="btn btn-warning btn-file" style="margin-bottom: 0px;">
						Chọn hình <input id="fileInput" type="file" data-default-file="" accept="image/*"/>
						</label>
						<button type="submit" class="btn btn-success" id="btnSaveImage" style="display: none;">Thay đổi</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Đóng lại</button>
						<input type="hidden" name="image" id="avatar" />
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					</div>
				</div>
			</form>
		</div>
	</div>
</section>

<section class="content-body-full-page content-template-1">
	<form id="frmApprove" class="form-wrapper" method="post" enctype="multipart/form-data" action="">
		<div class="row">
			<div class="col-md-4">
				<h1 class="page-title" style="text-align: left; margin-bottom: 0">Xác nhận hồ sơ</h1>
			</div>
			<div class="col-md-4">
				<div class="btn-group" data-toggle="buttons">
					@if (!is_null($pro->profile->inspection) && in_array('0', json_decode($pro->profile->inspection)))
					<label class="btn active">
						<input type="checkbox" name="inspection[]" value="0" checked="checked">
						<span class="icon icmn-checkbox-checked2"></span>CMND
					</label>
					@else
					<label class="btn">
						<input type="checkbox" name="inspection[]" value="0">
						<span class="icon icmn-checkbox-unchecked2"></span>CMND
					</label>
					@endif
					@if (!is_null($pro->profile->inspection) && in_array('1', json_decode($pro->profile->inspection)))
					<label class="btn active">
						<input type="checkbox" name="inspection[]" value="1" checked>
						<span class="icon icmn-checkbox-checked2"></span>Hộ khẩu
					</label>
					@else
					<label class="btn">
						<input type="checkbox" name="inspection[]" value="1">
						<span class="icon icmn-checkbox-unchecked2"></span>Hộ khẩu
					</label>
					@endif
					@if (!is_null($pro->profile->inspection) && in_array('2', json_decode($pro->profile->inspection)))
					<label class="btn active">
						<input type="checkbox" name="inspection[]" value="2" checked="checked">
						<span class="icon icmn-checkbox-checked2"></span>Giấy phép kinh doanh
					</label>
					@else
					<label class="btn">
						<input type="checkbox" name="inspection[]" value="2">
						<span class="icon icmn-checkbox-unchecked2"></span>Giấy phép kinh doanh
					</label>
					@endif
				</div>
			</div>
			<div class="col-md-4 text-right">
				<button id="btnUpdate" type="button" class="btn btn-warning width-150">Cập nhật</button>
				<button id="btnActive" type="button" class="btn btn-primary width-150">Duyệt và kích hoạt</button>
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			</div>
		</div>
	</form>
</section>
@endsection