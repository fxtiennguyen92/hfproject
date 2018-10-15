@extends('template.index')
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
		$('.company-row').hide();
		$('label.btn').on('click', function() {
			var span = $(this).find('span');
			if (span.hasClass('icmn-radio-unchecked')) {
				$(this).parent().find('span').each(function() {
					$(this).addClass('icmn-radio-unchecked').removeClass('icmn-checkmark-circle');
				});
				span.addClass('icmn-checkmark-circle').removeClass('icmn-radio-unchecked');
			}

			if (span.attr('id') == 'spanNoCompany') {
				$('.company-row').hide();
			} else {
				$('.company-row').show();
			}
		});

		$('#frmNewPro').validate({
			submit: {
				settings: {
					inputContainer: '.form-group',
					errorListClass: 'form-control-error',
					errorClass: 'has-danger',
				},
				callback: {
					onError: function (e) {
						$.notify({
							title: '<strong>Thất bại! </strong>',
							message: 'Thông tin chưa đầy đủ.'
						}, {
							type: 'danger',
							z_index: 1051,
						});
					},
					onSubmit: function() {
						loadingBtnSubmit('btnSubmit');
						
						$.ajax({
							type: 'POST',
							url: '{{ route("pa_pro_create") }}',
							data: $('#frmNewPro').serialize(),
							success: function(response) {
								swal({
									title: 'Hoàn thành',
									text: 'Đăng ký thành công',
									type: 'success',
									confirmButtonClass: 'btn-success',
									confirmButtonText: 'Quay lại',
								},
								function() {
									location.href = '{{ route("pa_pro_list") }}';
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
										text: 'Số điện thoại đã được sử dụng!',
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
								resetBtnSubmit('btnSubmit', 'Lưu Đối tác');
							}
						});
					}
				}
			}
		});
	});
	
	function deletePro(proId) {
		swal({
			title: 'Xóa Đối tác',
			text: 'Bạn muốn xóa đối tác này?',
			type: 'warning',
			showCancelButton: true,
			cancelButtonClass: 'btn-default',
			confirmButtonClass: 'btn-danger',
			cancelButtonText: 'Quay lại',
			confirmButtonText: 'Xóa',
			closeOnConfirm: false,
		},
		function(isConfirm) {
			if (isConfirm) {
				swal({
					title: 'Đang xử lý yêu cầu',
					text: 'Xin chờ trong giây lát!',
					type: 'info',
					showConfirmButton: false,
					closeOnConfirm: false,
				});
				
				var url = "{{ route('pa_pro_delete', ['id' => 'selectedProId']) }}";
				url = url.replace('selectedProId', proId);
				
				$('#frmMain').attr('action', url);
				$('#frmMain').submit();
			}
		});
	}
</script>
@endpush

@section('title') Đối tác @endsection

@section('content')
<section class="content-body content-template-1 has-bottom-menu">
	<div class="page-header hf-bg-gradient text-capitalize">Đối tác</div>
	<div class="form-wrapper">
		<div class="text-right">
			<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalNewPro">
				<i class="material-icons">person_add</i></button>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-hover nowrap mng-list" width="100%">
					<thead>
						<tr>
							<th class="text-center col-name">Đối tác</th>
							<th class="text-center">Trạng thái</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($pros as $pro)
						<tr>
							<td class="col-pro-info"">
								<div class="pro-name">
									{{ $pro->name }}
								</div>
								<div class="pro-phone padding-left-5">
									<i class="material-icons">phone</i>
									@if ($pro->phone){{ $pro->phone }}
									@endif
								</div>
							</td>
							<td class="text-center col-label-profile-state">
								@if ($pro->user)
									<span class="label label-primary">Đã tham gia</span>
								@else
									<span class="label label-warning">Chưa tham gia</span>
								@endif
							</td>
							<td class="text-right">
								<div class="dropdown">
									<span class="btn" data-toggle="dropdown">
									<i class="icmn-cog3"></i>
									</span>
									@if ($pro->created_by == auth()->user()->id)
									<ul class="dropdown-menu dropdown-menu-right" role="menu">
										<a class="dropdown-item" href="javascript:void(0);" onclick="return deletePro('{{ $pro->id }}');">
											<i class="icmn-bin"></i> Xóa
										</a>
									</ul>
									@endif
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
	<div id="modalNewPro" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<form id="frmNewPro" method="post" name="form-validation" enctype="multipart/form-data" action="">
				<div class="modal-content">
					<div class="modal-body">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<div class="form-wrapper">
							<h1 class="page-title text-left">Tài khoản Đối tác</h1>
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
								<div class="form-group col-sm-12">
									<label>Loại tài khoản</label>
									<div class="row" style="margin: 0px 5px;">
										<div class="btn-group" data-toggle="buttons" class="col-sm-12">
											<label class="col-sm-12 btn">
												<input type="radio"
													name="style"
													value="1">
													<span class="icon icmn-radio-unchecked"></span> Doanh nghiệp
											</label>
											<label class="col-sm-12 btn">
												<input type="radio"
													name="style"
													value="2">
													<span class="icon icmn-radio-unchecked"></span> Quản lý Doanh nghiệp
											</label>
											<label class="col-sm-12 btn active">
												<input type="radio"
													name="style"
													value="0" checked>
													<span id="spanNoCompany" class="icon icmn-checkmark-circle"></span> Cá nhân
											</label>
										</div>
									</div>
								</div>
							</div>
							<div class="row company-row">
								<div class="col-sm-12">
									<div class="form-group">
										<label>Doanh nghiệp</label>
										<select class="form-control selectpicker hf-select" data-live-search="true" name="company">
											@foreach ($companies as $company)
											<option value="{{ $company->id }}">{{ $company->name }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label>Training</label>
										<select class="form-control selectpicker hf-select" data-live-search="true" name="event">
											<option value="" selected>Chưa tham gia</option>
											@foreach ($events as $event)
											<option value="{{ $event->id }}">{{ $event->name.' - '.$event->from_time.' ngày '.Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row-complete">
						<button id="btnSubmit" type="submit" class="btn btn-primary" style="width: 100%">Lưu Đối tác</button>
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
@include('template.mng.footer-menu')
@endsection