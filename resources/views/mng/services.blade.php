@extends('template.mng.index')
@push('stylesheets')
<style>
</style>

<!-- Page Scripts -->
<script>
	$(document).ready(function() {
		@if (session('error'))
			swal({
				title: 'Thất bại',
				text: '{{ session("error") }}',
				type: 'error',
				confirmButtonClass: 'btn-default',
				confirmButtonText: 'Quay lại',
			});
		@endif
		
		$('.mng-list').DataTable({
			responsive: true,
			info: false,
			paging: false,
			sorting: false,
			language: {
				zeroRecords: "Chưa có thông tin",
				search: "Tìm kiếm"
			},
			columnDefs: [ { orderable: false, targets: [0,1,2,3,4] } ]
		});
	});
	
	function deleteService(id) {
		swal({
			title: 'Đang xử lý yêu cầu',
			text: 'Xin chờ trong giây lát!',
			type: 'info',
			showConfirmButton: false,
			closeOnConfirm: false,
		});
		
		var url = "{{ route('mng_service_delete', ['id' => 'serviceId']) }}";
		url = url.replace('serviceId', id);
		
		$('#frmMain').attr('action', url);
		$('#frmMain').submit();
	}
	
	function activeService(id) {
		swal({
			title: 'Đang xử lý yêu cầu',
			text: 'Xin chờ trong giây lát!',
			type: 'info',
			showConfirmButton: false,
			closeOnConfirm: false,
		});
		
		var url = "{{ route('mng_service_active', ['id' => 'serviceId']) }}";
		url = url.replace('serviceId', id);
		
		$('#frmMain').attr('action', url);
		$('#frmMain').submit();
	}
	
	function publishService(id) {
		swal({
			title: 'Đang xử lý yêu cầu',
			text: 'Xin chờ trong giây lát!',
			type: 'info',
			showConfirmButton: false,
			closeOnConfirm: false,
		});
		
		var url = "{{ route('mng_service_publish', ['id' => 'serviceId']) }}";
		url = url.replace('serviceId', id);
		
		$('#frmMain').attr('action', url);
		$('#frmMain').submit();
	}
	
	function unpublishService(id) {
		swal({
			title: 'Đang xử lý yêu cầu',
			text: 'Xin chờ trong giây lát!',
			type: 'info',
			showConfirmButton: false,
			closeOnConfirm: false,
		});
		
		var url = "{{ route('mng_service_unpublish', ['id' => 'serviceId']) }}";
		url = url.replace('serviceId', id);
		
		$('#frmMain').attr('action', url);
		$('#frmMain').submit();
	}
	
	function popularService(id) {
		swal({
			title: 'Đang xử lý yêu cầu',
			text: 'Xin chờ trong giây lát!',
			type: 'info',
			showConfirmButton: false,
			closeOnConfirm: false,
		});
		
		var url = "{{ route('mng_service_popular', ['id' => 'serviceId']) }}";
		url = url.replace('serviceId', id);
		
		$('#frmMain').attr('action', url);
		$('#frmMain').submit();
	}
	
	function unpopularService(id) {
		swal({
			title: 'Đang xử lý yêu cầu',
			text: 'Xin chờ trong giây lát!',
			type: 'info',
			showConfirmButton: false,
			closeOnConfirm: false,
		});
		
		var url = "{{ route('mng_service_unpopular', ['id' => 'serviceId']) }}";
		url = url.replace('serviceId', id);
		
		$('#frmMain').attr('action', url);
		$('#frmMain').submit();
	}
</script>
@endpush

@section('title') Dịch vụ @endsection

@section('content')
<section class="content-body-full-page content-template-1">
	<div class="page-header hf-bg-gradient text-capitalize">Dịch vụ</div>
	<div class="form-wrapper">
		<div class="text-right">
			<button class="btn btn-primary" type="button" onclick="location.href='{{ route('mng_service_new') }}'">
				<i class="material-icons">playlist_add</i></button>
		</div>
		<div class="row">
			<div class="col-md-12">
				<table class="table table-hover nowrap mng-list" width="100%">
					<thead>
						<tr>
							<th class="text-center">Dịch vụ</th>
							<th class="text-center">URL</th>
							<th class="text-center">Hiện trạng</th>
							<th class="text-center">Trạng thái</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($services as $service)
						<tr>
							<td><i class="icmn-cog"></i> <b>{{ $service->name }}</b></td>
							<td>{{ '/'.$service->url_name }}</td>
							<td class="text-center">
								@if ($service->serve_flg == 1 && $service->popular_flg == 1)
									<span class="label label-success text-right">Phổ biến</span>
								@endif
							</td>
							<td class="text-center">
								@if ($service->delete_flg == 1)
								<div><span class="label label-danger">Đã xóa</span></div>
								@elseif ($service->serve_flg == 1)
								<div><span class="label label-primary">Đang hiển thị</span></div>
								@else
								<div><span class="label label-default">Đang ẩn</span></div>
								@endif
							</td>
							<td class="text-right">
								<div class="dropdown">
									<span class="btn btn-sm " data-toggle="dropdown">
									<i class="icmn-cog3"></i>
									</span>
									<ul class="dropdown-menu dropdown-menu-right" role="menu">
										<a class="dropdown-item" href="{{ route('mng_service_edit', ['id' => $service->id]) }}">
											<i class="icmn-grid6"></i> Chi tiết
										</a>
										<a class="dropdown-item @if ($service->serve_flg == 1) disabled @endif" href="javascript:void(0);" onclick="publishService('{{ $service->id }}')">
											<i class="icmn-eye"></i> Hiển thị
										</a>
										<a class="dropdown-item @if ($service->serve_flg == 0) disabled @endif" href="javascript:void(0);" onclick="unpublishService('{{ $service->id }}')">
											<i class="icmn-eye-blocked"></i> Ẩn đi
										</a>
										<a class="dropdown-item @if ($service->popular_flg == 1) disabled @endif" href="javascript:void(0);" onclick="popularService('{{ $service->id }}')">
											<i class="icmn-earth2"></i> Phổ biến
										</a>
										<a class="dropdown-item @if ($service->popular_flg == 0) disabled @endif" href="javascript:void(0);" onclick="unpopularService('{{ $service->id }}')">
											<i class="icmn-earth3"></i> Hủy phổ biến
										</a>
										<a class="dropdown-item @if ($service->delete_flg == 1) disabled @endif" href="javascript:void(0);" onclick="deleteService('{{ $service->id }}')">
											<i class="icmn-lock"></i> Xóa
										</a>
										<a class="dropdown-item @if ($service->delete_flg == 0) disabled @endif" href="javascript:void(0);" onclick="activeService('{{ $service->id }}')">
											<i class="icmn-undo2"></i> Phục hồi
										</a>
									</ul>
								</div>
							</td>
						</tr>
						@foreach ($service->children as $child)
						<tr>
							<td><span class="padding-left-20"><i class="icmn-circle-small"></i> {{ '#'.$child->id.'-'.$child->name }}</span></td>
							<td>{{ '/'.$child->url_name }}</td>
							<td class="text-center">
								@if ($child->serve_flg == 1 && $child->popular_flg == 1)
									<span class="label label-success text-right">Phổ biến</span>
								@endif
							</td>
							<td class="text-center">
								@if ($child->delete_flg == 1)
								<span class="label label-danger">Đã xóa</span>
								@elseif ($child->serve_flg == 1)
								<span class="label label-primary">Đang hiển thị</span>
								@else
								<span class="label label-default">Đang ẩn</span>
								@endif
							</td>
							<td class="text-right">
								<div class="dropdown">
									<span class="btn btn-sm " data-toggle="dropdown">
									<i class="icmn-cog3"></i>
									</span>
									<ul class="dropdown-menu dropdown-menu-right" role="menu">
										<a class="dropdown-item" href="{{ route('mng_service_edit', ['id' => $child->id]) }}">
											<i class="icmn-grid6"></i> Chi tiết
										</a>
										<a class="dropdown-item" href="{{ route('mng_survey_list', ['id' => $child->id]) }}">
											<i class="icmn-clipboard2"></i> Câu hỏi
										</a>
										<a class="dropdown-item @if ($child->serve_flg == 1) disabled @endif" href="javascript:void(0);" onclick="publishService('{{ $child->id }}')">
											<i class="icmn-eye"></i> Hiển thị
										</a>
										<a class="dropdown-item @if ($child->serve_flg == 0) disabled @endif" href="javascript:void(0);" onclick="unpublishService('{{ $child->id }}')">
											<i class="icmn-eye-blocked"></i> Ẩn đi
										</a>
										<a class="dropdown-item @if ($child->popular_flg == 1) disabled @endif" href="javascript:void(0);" onclick="popularService('{{ $child->id }}')">
											<i class="icmn-earth2"></i> Phổ biến
										</a>
										<a class="dropdown-item @if ($child->popular_flg == 0) disabled @endif" href="javascript:void(0);" onclick="unpopularService('{{ $child->id }}')">
											<i class="icmn-earth3"></i> Hủy phổ biến
										</a>
										<a class="dropdown-item @if ($child->delete_flg == 1) disabled @endif" href="javascript:void(0);" onclick="deleteService('{{ $child->id }}')">
											<i class="icmn-lock"></i> Xóa
										</a>
										<a class="dropdown-item @if ($child->delete_flg == 0) disabled @endif" href="javascript:void(0);" onclick="activeService('{{ $child->id }}')">
											<i class="icmn-undo2"></i> Phục hồi
										</a>
									</ul>
								</div>
							</td>
						</tr>
						@endforeach
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
