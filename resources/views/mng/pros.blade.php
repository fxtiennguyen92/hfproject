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

@section('title') Đối tác @endsection

@section('content')
<section class="content-body-full-page content-template-1">
	<div class="page-header hf-bg-gradient text-capitalize">Đối tác</div>
	<div class="form-wrapper">
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-hover nowrap mng-list" width="100%">
					<thead>
						<tr>
							<th class="text-center">Họ tên</th>
							<th class="text-center">Địa chỉ</th>
							<th class="text-center">Ngày đăng ký</th>
							<th class="text-center">Trạng thái</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($pros as $pro)
						<tr>
							<td class="col-pro-info"">
								<div class="@if ($pro->role == 2) color-danger @endif pro-name">
									{{ $pro->name }}
								</div>
								<div class="padding-left-5">
									@if (isset($pro->profile) && isset($pro->profile->company))
									<i class="material-icons">store</i> {{ $pro->profile->company->name }}
									@else
									<i class="material-icons">build</i> Kinh doanh cá nhân
									@endif
								</div>
							</td>
							<td>
								<div>
									<i class="material-icons">phone</i>
									@if ($pro->phone){{ $pro->phone }}
									@else
										<span class="no-info">Chưa cập nhật</span>
									@endif
								</div>
								<div>
									<i class="material-icons">mail</i>
									@if ($pro->email){{ $pro->email }}
									@else
										<span class="no-info">Chưa cập nhật</span>
									@endif
								</div>
								<div>
									<i class="material-icons">person_pin_circle</i> 
									@if ($pro->profile->address_2) {{ $pro->profile->address_1.' '.$pro->profile->address_2 }}
										@if ($pro->profile->city && $pro->profile->district)
										{{ $pro->profile->district_info->name.', '.$pro->profile->city_info->name }}</div>
										@endif
									@else
										<span class="no-info">Chưa cập nhật</span>
									@endif
							</td>
							<td class="text-center">
								<span class='hide'>{{ Carbon\Carbon::parse($pro->created_at)->format('YmdHi') }}</span>
								{{ Carbon\Carbon::parse($pro->created_at)->format('d/m/Y H:i') }}
							</td>
							<td class="text-center col-label-profile-state">
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
							</td>
							<td class="text-right">
								<div class="dropdown">
									<span class="btn btn-sm " data-toggle="dropdown">
									<i class="icmn-cog3"></i>
									</span>
									<ul class="dropdown-menu dropdown-menu-right" role="menu">
										<a class="dropdown-item" href="{{ route('mng_pro_edit', ['id' => $pro->id]) }}">
											<i class="icmn-grid6"></i> Chi tiết
										</a>
										<a class="dropdown-item" href="javascript:void(0);">
											<i class="icmn-user-minus2"></i> Treo
										</a>
										<a class="dropdown-item" href="javascript:void(0);">
											<i class="icmn-user-cancel2"></i> Cảnh cáo
										</a>
										<a class="dropdown-item" href="javascript:void(0);">
											<i class="icmn-user-lock2"></i> Khóa
										</a>
										<a class="dropdown-item" href="javascript:void(0);">
											<i class="icmn-user-block"></i> Cấm vĩnh viễn
										</a>
										<a class="dropdown-item" href="javascript:void(0);" onclick="return deletePro('{{ $pro->id }}')">
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
	<!-- MODAL -->
</section>
@endsection
