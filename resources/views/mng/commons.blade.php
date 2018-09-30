@extends('template.mng.index')
@push('stylesheets')
<style>
</style>

<!-- Page Scripts -->
<script>
	$(document).ready(function() {
		autosize($('textarea'));
		
		$('.mng-list').DataTable({
			responsive: true,
			info: false,
			paging: false,
			language: {
				zeroRecords: "Chưa có thông tin",
				search: "Tìm kiếm"
			},
			order: [[0, 'asc']],
			columnDefs: [ { orderable: false, targets: [6] } ]
		});

		$('#frmNewCommon').validate({
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
							url: $('#frmNewCommon').attr('action'),
							data: $('#frmNewCommon').serialize(),
							success: function(response) {
								$('#frmNewCommon').modal('toggle');
								swal({
									title: 'Hoàn thành',
									text: 'Tùy chỉnh thành công',
									type: 'success',
									confirmButtonClass: 'btn-success',
									confirmButtonText: 'Quay lại',
								},
								function() {
									location.href = '{{ route("mng_common_list", ["key" => $key]) }}';
								});
							},
							error: function(xhr) {
								$('#frmNewCommon').modal('toggle');
								if (xhr.status == 400) {
									swal({
										title: 'Thất bại',
										text: 'Tùy chỉnh không thực hiện được!',
										type: 'error',
										confirmButtonClass: 'btn-default',
										confirmButtonText: 'Quay lại',
									});
								} else if (xhr.status == 409) {
									swal({
										title: 'Thất bại',
										text: 'Tùy chỉnh không đúng, mời kiểm tra lại!',
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
								resetBtnSubmit('btnSubmit', 'Thêm mới');
								$('#frmNewCommon').modal('show');
							}
						});
					}
				}
			}
		});
	});
	
	function activeCommon(code) {
		var url = '{{ route("mng_common_active", ["key" => $key, "code" => "commonCode" ]) }}';
		url = url.replace('commonCode', code);
		
		$.ajax({
			type: 'POST',
			url: url,
			data: $('#frmMain').serialize(),
			success: function(response) {
				swal({
					title: 'Hoàn thành',
					text: 'Phục hồi thành công',
					type: 'success',
					confirmButtonClass: 'btn-success',
					confirmButtonText: 'Quay lại',
				},
				function() {
					location.href = '{{ route("mng_common_list", ["key" => $key]) }}';
				});
			},
			error: function(xhr) {
				swal({
					title: 'Thất bại',
					text: 'Yêu cầu không thực hiện được!',
					type: 'error',
					confirmButtonClass: 'btn-default',
					confirmButtonText: 'Quay lại',
				});
			}
		});
	}
	
	function disableCommon(code) {
		var url = '{{ route("mng_common_delete", ["key" => $key, "code" => "commonCode" ]) }}';
		url = url.replace('commonCode', code);
		
		$.ajax({
			type: 'POST',
			url: url,
			data: $('#frmMain').serialize(),
			success: function(response) {
				swal({
					title: 'Hoàn thành',
					text: 'Đã vô hiệu thành công',
					type: 'success',
					confirmButtonClass: 'btn-success',
					confirmButtonText: 'Quay lại',
				},
				function() {
					location.href = '{{ route("mng_common_list", ["key" => $key]) }}';
				});
			},
			error: function(xhr) {
				swal({
					title: 'Thất bại',
					text: 'Yêu cầu không thực hiện được!',
					type: 'error',
					confirmButtonClass: 'btn-default',
					confirmButtonText: 'Quay lại',
				});
			}
		});
	}

</script>
@endpush

@section('title') Common @endsection

@section('content')
<section class="content-body-full-page content-template-1">
	<div class="page-header hf-bg-gradient text-capitalize">Tùy chỉnh hệ thống ({{ $key }})</div>
	<div class="form-wrapper">
		<div class="text-right">
			<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalNewCommon">
				<i class="material-icons">playlist_add</i></button>
		</div>
		<div class="row">
			<div class="col-md-12">
				<table class="table table-hover nowrap mng-list" width="100%">
					<thead>
						<tr>
							<th class="text-center">DspNo</th>
							<th class="text-center">Khóa</th>
							<th class="text-center">Mã</th>
							<th class="text-center">Giá trị</th>
							<th class="text-center">Tên</th>
							<th class="text-center">Ngày tạo</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($commons as $common)
						<tr class="@if ($common->delete_flg == '1') row-deleted-flg color-danger @endif">
							<td class="text-center">@if ($common->order_dsp != 0) {{ $common->order_dsp }} @endif</td>
							<td class="font-weight-700">{{ $common->key }}</td>
							<td>{{ $common->code }}</td>
							<td>{{ $common->value }}</td>
							<td>
								<div>{{ $common->name }}</div>
								@if ($common->name_2)
								<div>{{ $common->name_2 }}</div>
								@endif
							</td>
							<td class="text-center">
								<span class='hide'>{{ Carbon\Carbon::parse($common->created_at)->format('YmdHi') }}</span>
								{{ Carbon\Carbon::parse($common->created_at)->format('d/m/Y H:i') }}
							</td>
							<td class="text-right">
								<div class="dropdown">
									<span class="btn" data-toggle="dropdown">
									<i class="icmn-cog3"></i>
									</span>
									<ul class="dropdown-menu dropdown-menu-right" role="menu">
										<a class="dropdown-item" href="{{ route('mng_common_list', ['key' => $common->code]) }}">
											<i class="icmn-grid6"></i> Chi tiết
										</a>
										<a class="dropdown-item" href="javascript:void(0);">
											<i class="icmn-pencil"></i> Sửa
										</a>
										<a class="dropdown-item" href="javascript:void(0);" onclick="return disableCommon('{{ $common->code }}');">
											<i class="icmn-lock"></i> Vô hiệu
										</a>
										<a class="dropdown-item" href="javascript:void(0);" onclick="return activeCommon('{{ $common->code }}');">
											<i class="icmn-undo2"></i> Phục hồi
										</a>
										<a class="dropdown-item" href="javascript:void(0);">
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
	<div id="modalNewCommon" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<form id="frmNewCommon" method="post" name="form-validation" enctype="multipart/form-data" action="{{ route('mng_common_create', ['key' => $key]) }}">
				<div class="modal-content">
					<div class="modal-body">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<div class="form-wrapper">
							<h1 class="page-title text-left">Tùy chỉnh Hệ thống</h1>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Khóa</label>
										<input type="text" class="form-control" value="{{ $key }}" readonly>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Mã <span class="color-danger">*</span></label>
										<input type="text" maxlength="10" class="form-control" name="code" data-validation="[NOTEMPTY]">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Giá trị (Liên kết)</label>
										<input type="text" maxlength="10" class="form-control" name="value">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Tên</label>
										<input type="text" maxlength="50" class="form-control" name="name">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Tên khác</label>
										<input type="text" maxlength="50" class="form-control" name="name_2">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Nội dung khác</label>
										<textarea class="form-control" name="text" rows="3"></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Thứ tự hiển thị</label>
										<input type="text" maxlength="3"
											class="form-control" name="order_dsp"
											value="0" data-validation="[INTEGER]">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row-complete">
						<button id="btnSubmit" type="submit" class="btn btn-primary" style="width: 100%">Thêm mới</button>
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
@endsection
