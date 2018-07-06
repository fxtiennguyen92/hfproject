@extends('template.index')
@push('stylesheets')
<style>
</style>

<!-- Page Scripts -->
<script>
	$(document).ready(function() {
		$('.mng-list').DataTable({
			responsive: true,
			info: false,
			paging: false,
			language: {
				zeroRecords: "Chưa có thông tin",
				search: "Tìm kiếm cục bộ"
			},
			order: [[2, 'desc']],
			columnDefs: [ { orderable: false, targets: [4] } ]
		});
	});

	function deletePro(proId) {
		swal({
			title: 'Xóa Đối tác?',
			text: 'Thông tin này sẽ không thể phục hồi!',
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
				
				var url = "{{ route('mng_pro_delete', ['id' => 'selectedProId']) }}";
				url = url.replace('selectedProId', proId);
				
				$('#frmMain').attr('action', url);
				$('#frmMain').submit();
			}
		});
	}
</script>
@endpush

@section('title') Khách hàng @endsection

@section('content')
<section class="content-body-full-page content-template-1">
	<div class="page-header hf-bg-gradient text-capitalize">Khách hàng</div>
	<div class="form-wrapper">
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-hover nowrap mng-list" width="100%">
					<thead>
						<tr>
							<th class="text-center">Họ tên</th>
							<th class="text-center"></th>
							<th class="text-center">Ngày đăng ký</th>
							<th class="text-center">Trạng thái</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($users as $user)
						<tr>
							<td class="col-pro-info"">
								<div class="@if ($user->role == 2) color-danger @endif pro-name">
									{{ $user->name }}
								</div>
								<div>
									<i class="material-icons">phone</i>
									@if ($user->phone){{ $user->phone }}
									@else
										<span class="no-info">Chưa cập nhật</span>
									@endif
								</div>
								<div>
									<i class="material-icons">mail</i>
									@if ($user->email){{ $user->email }}
									@else
										<span class="no-info">Chưa cập nhật</span>
									@endif
								</div>
							</td>
							<td class="text-center">
								@if ($user->password) <i class="icmn-circles2"></i> @endif
								@if ($user->facebook_id) <i class="icmn-facebook"></i> @endif
								@if ($user->google_id) <i class="icmn-google-plus"></i> @endif
							</td>
							<td class="text-center">
								<span class='hide'>{{ Carbon\Carbon::parse($user->created_at)->format('YmdHi') }}</span>
								{{ Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i') }}
							</td>
							<td class="text-center col-label-profile-state">
								@if ($user->delete_flg == 1)
									<span class="label label-danger">Đã xóa</span>
								@elseif ($user->confirm_flg == 0)
									<span class="label label-warning">Email vô hiệu</span>
								@else
									<span class="label label-success">Hoạt động</span>
								@endif
							</td>
							<td class="text-right">
								<div class="dropdown">
									<span class="btn" data-toggle="dropdown">
									<i class="icmn-cog3"></i>
									</span>
									<ul class="dropdown-menu dropdown-menu-right" role="menu">
										<a class="dropdown-item" href="javascript:void(0);">
											<i class="icmn-loop2"></i> Cấp lại Mật khẩu
										</a>
										<a class="dropdown-item" href="javascript:void(0);">
											<i class="icmn-bin"></i> Xóa
										</a>
										<a class="dropdown-item" href="javascript:void(0);">
											<i class="icmn-user-check2"></i> Phục hồi
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
</section>
@endsection
