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
		<!-- Initial - STA -->
		@if (isset($profile))
		$('input[name=dateOfBirth]').val("{{ Carbon\Carbon::parse($profile->date_of_birth)->format('d-m-Y') }}");
		$('select[name=gender]').val("{{ $profile->gender }}");
		@endif
		
		<!-- Avatar - STA -->
		$('#fileInput').on('change', function() {
			$('#btnSaveImage').show();
		});
		$('#btnSaveImage').on('click', function() {
			$('#avatar').val($('#image_avatar').attr('ng-src'));
		});
		<!-- Avatar - END -->

		$('#dpDateOfBirth').datetimepicker({
			format: 'DD/MM/YYYY'
		});
		$('#dpDateOfBirth input').mask('00/00/0000');
		$('#inpPhone').mask('0000000000000');

		<!-- Autocomplete Companies - STA -->
		var path = "{{ route('get_companies') }}";
		$('#inpCompany').typeahead({
			minLength: 2,
			maxItem: 5,
			order: 'asc',
			source: function(request, response) {
				$.ajax({
					url: path,
					dataType: 'json',
					data: {
						term: $('#inpCompany').val(),
					},
					success: function (data) {
						response(data);
					}
				});
			},
			displayText: function (item) {
				return item.value;
			}
		});
		<!-- Autocomplete Companies - END -->
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
								$.notify({
									title: '<strong>Hoàn tất! </strong>',
									message: 'Thông tin cá nhân đã thay đổi thành công.'
								},{
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

		$('#frmChangePassword').validate({
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
							url: '{{ route("change_password") }}',
							data: $('#frmChangePassword').serialize(),
							success: function(response) {
								$.notify({
									title: '<strong>Hoàn tất! </strong>',
									message: 'Mật khẩu đã thay đổi thành công.'
								},{
									type: 'success',
									z_index: 1051,
								});

								setTimeout(function() {
									location.reload();
								}, 1500);
							},
							error: function(xhr) {
								if (xhr.status == 401) {
									$.notify({
										title: '<strong>Thất bại! </strong>',
										message: 'Mật khẩu hiện tại chưa đúng.'
									},{
										type: 'danger',
										z_index: 1051,
									});
								} else if (xhr.status == 400) {
									$.notify({
										title: '<strong>Thất bại! </strong>',
										message: 'Mật khẩu mới giống Mật khẩu hiện tại.'
									},{
										type: 'danger',
										z_index: 1051,
									});
								} else {
									$.notify({
										title: '<strong>Thất bại! </strong>',
										message: 'Thay đổi Mật khẩu thất bại.'
									},{
										type: 'danger',
										z_index: 1051,
									});

									setTimeout(function() {
										location.reload();
									}, 1500);
								};
							}
						});
					}
				}
			}
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
		angular.element(document.querySelector('#fileInput')).on('change',handleFileSelect);
	});
	</script>

@endpush

@section('title')

@endsection

@section('content')
<section class="page-content" ng-app="app" ng-controller="Ctrl">
	<nav class="top-submenu">
		<div class="row" style="max-width: 500px;margin: auto">
			<div class="col-md-4 text-center">
				<a class="avatar" style="width:120px;height:120px" href="javascript:void(0);" data-toggle="modal" data-target="#avatar-modal">
					<img id="userAvatar" src="../storage/app/u/{{ auth()->user()->id }}/{{ auth()->user()->avatar }}">
				</a>
			</div>
			<div class="col-md-8">
				<div class="profile-title">
					<h2>{{ auth()->user()->name }}</h2>
					<small>Nhân viên</small>
					<p>Công ty TNHH Một thành viên</p>
					<div class="skill_rating" title="2.3">
						<select id="rating" class="rating" data-current-rating="2.3">
							<option value=""></option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select>
					</div>
				</div>
			</div>
		</div>
	</nav>
	
	<div class="col-md-2">
	</div>
	<div class="col-md-8">
	<form id="frmMain" name="form-validation" method="post" enctype="multipart/form-data" action="{{ route('change_pro_profile') }}">
		<div class="form-group">
			<label>Họ tên</label>
			<input maxlength="200"
				class="form-control"
				placeholder="Họ và Tên"
				name="name"
				type="text"
				data-validation-message="Họ tên chưa được nhập"
				data-validation="[NOTEMPTY]"
				value="{{ auth()->user()->name }}">
		</div>
		<div class="form-group">
			<label>Ngày tháng năm sinh</label>
			<div class='input-group date' id='dpDateOfBirth'>
				<input type='text' class="form-control"
					name="dateOfBirth"/>
				<span class="input-group-addon">
					<span class="icmn-calendar5"></span>
				</span>
			</div>
		</div>
		<div class="form-group">
			<label>Giới tính</label>
			<select class="form-control" name="gender">
				<option value="" disabled selected></option>
				<option value="1">Nam</option>
				<option value="2">Nữ</option>
				<option value="0">Khác</option>
			</select>
		</div>
		<div class="form-group">
			<label>Email</label>
			<div class="input-group">
				<input type="text" class="form-control" disabled
					value="{{ auth()->user()->email }}"
					name="email">
				<a class="input-group-addon" title="Thay đổi Email"><i class="icmn-envelop5"></i></a>
			</div>
		</div>
		<div class="form-group">
			<label>Số điện thoại</label>
			<input type="text" maxlength="25"
				class="form-control"
				value="{{ auth()->user()->phone }}"
				id="inpPhone"
				name="phone"
				placeholder="Số điện thoại">
		</div>
		<div class="form-group">
			<label>Mật khẩu</label>
			<div class="input-group">
				<input type="password" class="form-control" value="*********" disabled>
				<a class="input-group-addon" data-toggle="modal"
					data-target="#password-modal" title="Thay đổi Mật khẩu"><i class="icmn-cogs"></i></a>
			</div>
		</div>
		<div class="form-group">
			<label>Công ty</label>
			<div class="typeahead__container">
				<div class="typeahead__field">
					<div class="typeahead__query">
						<input class="form-control" type="text"
							placeholder="Công ty"
							autocomplete="off"
							id="inpCompany"
							name="company"/>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group" style="text-align: center;">
			<button id="btnSubmit" type="submit" class="btn btn-primary width-150">Lưu lại</button>
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		</div>
	</form>
	</div>
	
	<!-- MODAL -->
	<div id="avatar-modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<form id="frmImage" method="post" enctype="multipart/form-data" action="{{ route('change_pro_avatar') }}">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Thay đổi Hình đại diện</h4>
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
	
	<div id="password-modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
		<form id="frmChangePassword" name="form-validation" method="post" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Thay đổi Mật khẩu</h4>
				</div>
				<div class="modal-body">
					@if (auth()->user()->password)
					<div class="form-group">
						<label>Mật khẩu hiện tại</label>
						<input id="currPassword"
							name="currPassword"
							class="form-control password"
							type="password" data-validation="[L>=10]"
							data-validation-message="Mật khẩu có ít nhất là 10 ký tự"
							placeholder="Mật khẩu hiện tại">
					</div>
					@endif
					<div class="form-group">
						<label>Mật khẩu mới</label>
						<input id="newPassword"
							name="newPassword"
							class="form-control password"
							type="password" data-validation="[L>=10]"
							data-validation-message="Mật khẩu có ít nhất là 10 ký tự"
							placeholder="Mật khẩu mới">
					</div>
					<div class="form-group">
						<label>Xác nhận Mật khẩu mới</label>
						<input id="rePassword"
							name="rePassword"
							class="form-control password"
							type="password" data-validation="[V==newPassword]"
							data-validation-message="Xác nhận Mật khẩu mới chưa đúng"
							placeholder="Nhập lại Mật khẩu mới">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" id="btnChangePassword">Thay đổi</button>
					<button type="button" class="btn" data-dismiss="modal">Đóng lại</button>
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				</div>
			</div>
		</form>
		</div>
	</div>
</section>
@endsection