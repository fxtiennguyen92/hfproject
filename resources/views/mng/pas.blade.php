@extends('template.mng.index')
@push('stylesheets')
<style>
</style>

<!-- Page Scripts -->
<script>
	$(document).ready(function() {
		$('.phone').mask('0000000000000');
		
		$('.mng-list').DataTable({
			responsive: true,
			info: false,
			paging: false,
			ordering: false,
			language: {
				zeroRecords: "Chưa có thông tin",
				search: "Tìm kiếm"
			},
		});

		$('#frmNewPA').validate({
			submit: {
				settings: {
					inputContainer: '.form-group',
					errorListClass: 'form-control-error',
					errorClass: 'has-danger',
				},
				callback: {
					onSubmit: function() {
						loadingBtnSubmit('btnSubmit');
						
						$.ajax({
							type: 'POST',
							url: '{{ route("mng_pa_create") }}',
							data: $('#frmNewPA').serialize(),
							success: function(response) {
								swal({
									title: 'Hoàn thành',
									text: 'Đăng ký thành công',
									type: 'success',
									confirmButtonClass: 'btn-success',
									confirmButtonText: 'Quay lại',
								},
								function() {
									location.href = '{{ route("mng_pa_list") }}';
								});
							},
							error: function(xhr) {
								if (xhr.status == 400) {
									swal({
										title: 'Thất bại',
										text: 'Yêu cầu không thực hiện được!',
										type: 'error',
										confirmButtonClass: 'btn-default',
										confirmButtonText: 'Quay lại',
									});
								} else if (xhr.status == 409) {
									swal({
										title: 'Thất bại',
										text: 'Email không đúng hoặc đã được sử dụng!',
										type: 'error',
										confirmButtonClass: 'btn-default',
										confirmButtonText: 'Quay lại',
									});
								} else {
									swal({
										title: 'Thất bại',
										text: 'Có lỗi phát sinh, mời thử lại!',
										type: 'error',
										confirmButtonClass: 'btn-default',
										confirmButtonText: 'Quay lại',
									});
								};
								resetBtnSubmit('btnSubmit', 'Đăng ký');
							}
						});
					}
				}
			}
		});
	});
	
	function deletePA(paId) {
		swal({
			title: 'Xóa Cộng tác viên',
			text: 'Dữ liệu sẽ không thể khôi phục',
			type: 'warning',
			showCancelButton: true,
			cancelButtonClass: 'btn-default',
			confirmButtonClass: 'btn-danger',
			cancelButtonText: 'Quay lại',
			confirmButtonText: 'Xóa',
			closeOnConfirm: false,
		},
		function() {
			swal({
				title: 'Đang xử lý yêu cầu',
				text: 'Xin chờ trong giây lát!',
				type: 'info',
				showConfirmButton: false,
				closeOnConfirm: false,
			});
			
			var url = "{{ route('mng_pa_delete', ['id' => 'paId']) }}";
			url = url.replace('paId', paId);
			
			$('#frmMain').attr('action', url);
			$('#frmMain').submit();
		});
	}
</script>
@endpush

@section('title') Cộng tác viên @endsection

@section('content')
<section class="content-body-full-page content-template-1">
	<div class="page-header hf-bg-gradient text-capitalize">Cộng tác viên</div>
	<div class="form-wrapper">
		<div class="text-right">
			<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalNewPA">
				<i class="material-icons">person_add</i></button>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-hover nowrap mng-list" width="100%">
					<thead>
						<tr>
							<th class="text-center col-name">Cộng tác viên</th>
							<th class="text-center">SL Đối tác</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($pas as $pa)
						<tr>
							<td class="col-pro-info"">
								<div class="@if ($pa->role == 2) color-danger @endif pro-name">
									{{ $pa->name }}
								</div>
								<div class="pro-phone padding-left-5">
									<i class="material-icons">phone</i> {{ $pa->phone }}
								</div>
								<div class="pro-company padding-left-5">
									<i class="material-icons">alternate_email</i> {{ $pa->email }}
								</div>
								
							</td>
							<td class="text-right">@if (sizeof($pa->proCount) > 0) {{ $pa->proCount[0]['count'] }} @endif</td>
							<td class="text-right">
								<div class="dropdown">
									<span class="btn" data-toggle="dropdown">
									<i class="icmn-cog3"></i>
									</span>
									<ul class="dropdown-menu dropdown-menu-right" role="menu">
										<a class="dropdown-item" href="javascript:void(0);" onclick="return deletePA('{{ $pa->id }}');">
											<i class="icmn-bin"></i> Xóa
										</a>
									</ul>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<form id="frmMain" method="post" enctype="multipart/form-data" action="">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		</form>
	</div>

	<!-- MODAL -->
	<div id="modalNewPA" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<form id="frmNewPA" method="post" name="form-validation" enctype="multipart/form-data" action="">
				<div class="modal-content">
					<div class="modal-body">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<div class="form-wrapper">
							<h1 class="page-title text-left">Cộng tác viên</h1>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label>Họ tên <span class="color-danger">*</span></label>
										<input type="text" maxlength="225" class="form-control" name="name" data-validation="[NOTEMPTY]">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label>Số điện thoại <span class="color-danger">*</span></label>
										<input type="text" maxlength="25" class="form-control phone" name="phone" data-validation="[NOTEMPTY]">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label>Email <span class="color-danger">*</span></label>
										<input type="text" maxlength="100" class="form-control" name="email" data-validation="[NOTEMPTY, EMAIL]">
									</div>
								</div>
							</div>
							<div class="row text-right padding-top-30" style="margin-bottom: -15px;">
								<button id="btnSubmit" type="submit" class="btn btn-primary width-150">Tạo tài khoản</button>
								<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
@endsection
@include('template.mng.footer-menu')