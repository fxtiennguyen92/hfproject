<div id="footer-menu">
	<ul class="list-inline clearfix ">
		@if (auth()->user()->role == 91)
		<li class="">
			<a href="{{ route('pa_company_list') }}">
				<i class="material-icons ">store</i>
			</a>
		</li>
		<li class="">
			<a href="{{ route('pa_pro_list') }}">
				<i class="material-icons ">assignment_ind</i>
			</a>
		</li>
		<li class="">
			<a href="javascript: void(0);">
				<i class="material-icons ">attach_money</i>
			</a>
		</li>
		<li>
			<a href="javascript: void(0);" data-toggle="modal" data-target="#modalLogout">
				<i class="material-icons">person</i>
			</a>
		</li>
		@endif
		
		@if (auth()->user()->role == 99)
		<li class="">
			<a href="{{ route('pa_company_list') }}">
				<i class="material-icons ">store</i>
			</a>
		</li>
		<li class="">
			<a href="{{ route('mng_pro_list') }}">
				<i class="material-icons ">assignment_ind</i>
			</a>
		</li>
		<li>
			<a href="javascript: void(0);">
				<i class="material-icons ">attach_money</i>
			</a>
		</li>
		<li>
			<a href="{{ route('control') }}">
				<i class="material-icons ">person</i>
			</a>
		</li>
		@endif
	</ul>
</div>
<div id="modalLogout" class="modal modal-size-small fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<a class="dropdown-item" href="javascript:void(0)"><i class="material-icons">person</i> {{ auth()->user()->email }}</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modalPassword"><i class="material-icons">verified_user</i> Mật khẩu</a>
				<a class="dropdown-item" href="{{ route('logout') }}"><i class="material-icons">power_settings_new</i> Đăng xuất</a>
			</div>
		</div>
	</div>
</div>
<div id="modalPassword" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<form id="frmPassword" method="post" name="form-validation" enctype="multipart/form-data" action="">
		<div class="modal-content">
			<div class="modal-body padding-30">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="padding-top-20 text-center">Cập nhật Mật khẩu</h3>
				<p class="font-size-12 text-center color-warning padding-bottom-20">
					@if (auth()->user()->password_temp)
					Hiện tại bạn đang sử dụng <b>Mật khẩu mặc định</b>
					@endif
				</p>
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group">
							<label>Mật khẩu hiện tại</label>
							<input type="password" maxlength="100" class="form-control password" name="current_password" data-validation="[NOTEMPTY]">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group">
							<label>Mật khẩu mới</label>
							<input type="password" maxlength="100" class="form-control password" name="password" data-validation="[NOTEMPTY, L>=6]">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group">
							<label>Xác nhận lại Mật khẩu</label>
							<input type="password" maxlength="100" class="form-control" name="password_confirmation" data-validation="[NOTEMPTY, V==password]">
						</div>
					</div>
				</div>
				<div class="row row-complete margin-top-20">
					<button id="btnUpdatePassword" type="submit" class="btn btn-primary" style="width: 100%">Cập nhật</button>
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				</div>
			</div>
		</div>
		</form>
	</div>
</div>
<script>
$(document).ready(function() {
	$('#frmPassword').validate({
		submit: {
			settings: {
				inputContainer: '.form-group',
				errorListClass: 'form-control-error',
				errorClass: 'has-danger',
			},
			callback: {
				onSubmit: function() {
					loadingBtnSubmit('btnUpdatePassword');
					
					$.ajax({
						type: 'POST',
						url: '{{ route("password_update") }}',
						data: $('#frmPassword').serialize(),
						success: function(response) {
							swal({
								title: 'Thành công',
								text: 'Đã cập nhật mật khẩu',
								type: 'info',
								confirmButtonClass: 'btn-info',
								confirmButtonText: 'Quay lại',
							},
							function() {
								location.reload();
							});
						},
						error: function(xhr) {
							if (xhr.status == 401) {
								swal({
									title: 'Thất bại',
									text: 'Mật khẩu hiện tại không đúng',
									type: 'error',
									confirmButtonClass: 'btn-danger',
									confirmButtonText: 'Quay lại',
								});
							} else if (xhr.status == 409) {
								swal({
									title: 'Thất bại',
									text: 'Mật khẩu mới không đúng định dạng',
									type: 'error',
									confirmButtonClass: 'btn-danger',
									confirmButtonText: 'Quay lại',
								});
							} else {
								swal({
									title: 'Thất bại',
									text: 'Có lỗi phát sinh, mời thử lại',
									type: 'error',
									confirmButtonClass: 'btn-default',
									confirmButtonText: 'Thử lại',
								});
							};
							resetBtnSubmit('btnUpdatePassword', 'Cập nhật');
						}
					});
				}
			}
		}
	});
});
</script>