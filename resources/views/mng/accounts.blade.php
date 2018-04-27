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
			order: [[3, 'desc']],
// 			columnDefs: [ { orderable: false, targets: [4] } ]
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
		<div class="row">
			<div class="col-md-12">
				<table class="table table-hover nowrap mng-list" width="100%">
					<thead>
						<tr>
							<th class="text-center">Họ tên - Tài khoản</th>
							<th class="text-center">Đối tượng</th>
							<th class="text-center">Trạng thái</th>
							<th class="text-center">Ngày đăng ký</th>
<!-- 							<th>&nbsp;</th> -->
						</tr>
					</thead>
					<tbody>
						@foreach ($accounts as $acc)
						<tr>
							<td class="text-capitalize col-cus-info">
								<div class="cus-name">{{ $acc->name }}</div>
								<div class="cus-email">{{ $acc->email }}</div>
							</td>
							<td class="text-center col-label-user-role">
								@if ($acc->role == 0)
								<label class="label-outlined label label-success">Customer</label>
								@elseif ($acc->role == 1 || $acc->role == 2)
								<label class="label-outlined label label-danger">Pro</label>
								@elseif ($acc->role == 90)
								<label class="label-outlined label label-default">CSO</label>
								@elseif ($acc->role == 99)
								<label class="label-outlined label label-default">Admin</label>
								@endif
							</td>
							<td class="text-center col-label-acc-state">
								@if ($acc->delete_flg == 1)
									<span class="label label-default">Deleted</span>
								@elseif ($acc->confirm_flg != 1)
									<span class="label label-warning">Unconfirmed</span>
								@else
									<span class="label label-primary">Active</span>
								@endif
							</td>
							<td class="text-center">
								{{ Carbon\Carbon::parse($acc->created_at)->format('d/m/Y H:i') }}
							</td>
<!-- 							<td> -->
<!-- 								<div class="dropdown pull-right"> -->
<!-- 									<span class="btn btn-sm " data-toggle="dropdown"> -->
<!-- 									<i class="icmn-cog3"></i> -->
<!-- 									</span> -->
<!-- 									<ul class="dropdown-menu dropdown-menu-right" role="menu"> -->
<!-- 										<a class="dropdown-item view" href="javascript:void(0);"> -->
<!-- 											<i class="icmn-grid6"></i> Chi tiết -->
<!-- 										</a> -->
<!-- 										<a class="dropdown-item view" href="javascript:void(0);"> -->
<!-- 											<i class="icmn-bin"></i> Xóa -->
<!-- 										</a> -->
<!-- 									</ul> -->
<!-- 								</div> -->
<!-- 							</td> -->
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
