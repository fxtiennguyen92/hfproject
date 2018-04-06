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
				search: "Tìm kiếm"
			},
			order: [[2, 'desc']],
			columnDefs: [ { orderable: false, targets: [5] } ]
		});

		$('a.delete').on('click', function() {
			
		});
	});
</script>
@endpush

@section('title') Tài khoản @endsection

@section('content')
<section class="content-body-full-page content-template-1">
	<div class="page-header hf-bg-gradient text-capitalize">Tài khoản</div>
	<div class="form-wrapper">
		<button class="btn btn-primary pull-right" type="button" onclick="javascript:void(0);">
			<i class="material-icons">&#xE7F0;</i></button>
		<div class="row">
			<div class="col-md-12">
				<table class="emp-table table table-hover nowrap mng-list" width="100%">
					<thead>
						<tr>
							<th class="text-center col-name">Họ tên - Tài khoản</th>
							<th class="text-center col-state">Trạng thái</th>
							<th class="text-center">Ngày đăng ký</th>
							<th class="text-center">Giới tính</th>
							<th class="text-center">Ngày sinh</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($users as $user)
						<tr>
							<td class="text-capitalize">
								<div class="emp-name">{{ $user['name'] }}
									@if ($user['role'] == 2)
									<span style="color: red; font-style: italic;">(Mng)</span>
									@endif
								</div>
								<div class="emp-email">{{ $user['email'] }}</div>
							</td>
							<td class="text-center label-profile-state">
								@if ($user['delete_flg'] == 1)
									<span class="label label-secondary">Đã xóa</span>
								@elseif ($user['profile']['state'] == '1')
									<span class="label label-primary">Sẵn Sàng</span>
								@elseif ($user['profile']['state'] == '2')
									<span class="label label-default">Treo</span>
								@elseif ($user['profile']['state'] == '3')
									<span class="label label-warning">Cảnh cáo</span>
								@elseif ($user['profile']['state'] == '4')
									<span class="label label-danger">Khóa</span>
								@elseif ($user['profile']['state'] == '5')
									<span class="label label-secondary">Cấm vĩnh viễn</span>
								@else
									<span class="label label-success">Chờ Duyệt</span>
								@endif
							</td>
							<td class="text-center">
								{{ Carbon\Carbon::parse($user['created_at'])->format('d-m-Y H:i') }}
							</td>
							<td class="text-center">
								@if ($user['profile']['gender'] == '1')
									Nam
								@elseif ($user['profile']['gender'] == '2')
									Nữ
								@else
									Khác
								@endif
							</td>
							<td class="text-center">
								{{ Carbon\Carbon::parse($user['profile']['date_of_birth'])->format('d-m-Y') }}
							</td>
							<td>
								<div class="dropdown margin-inline pull-right">
									<span class="btn btn-sm " data-toggle="dropdown">
									<i class="icmn-cog3"></i>
									</span>
									<ul class="dropdown-menu dropdown-menu-right" role="menu">
										<a class="dropdown-item view" href="javascript:void(0);">
											<i class="icmn-grid6"></i> Chi tiết
										</a>
										<a class="dropdown-item view" href="javascript:void(0);">
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
</section>
@endsection
