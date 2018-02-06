@extends('template.index')
@push('stylesheets')
<style>
	body {
		background: #f4f4f4;
	}

	.dropdown-menu {
		z-index: 3000;
	}
</style>

<!-- Page Scripts -->
<script>
	$(document).ready(function() {
		$('.list').DataTable({
			responsive: true,
			info: false,
			language: {
				lengthMenu: "Hiển thị _MENU_ dòng",
				zeroRecords: "Không có bất kỳ Đối Tác nào",
				search: "Tìm kiếm"
			},
		});
	});

	function modify(url) {
		swal({
			title: '',
			text: 'Bạn muốn thay đổi thông tin Đối Tác này?',
			type: 'info',
			showCancelButton: true,
			cancelButtonClass: 'btn-default',
			confirmButtonClass: 'btn-primary',
			cancelButtonText: 'Quay lại',
			confirmButtonText: 'Tiếp tục',
		},
		function(){
			location.href = url;
		});
	}
</script>
@endpush

@section('title')
@endsection

@section('content')
<section class="page-content signup-pro">
	<div class="col-md-2">
	</div>
	<div class="col-md-8">
		<div class="form-wrapper hf-card">
			<h1 class="page-title text-left">Danh sách Đối Tác</h1>
			<div class="row">
				<div class="col-md-12">
					<table class="table table-hover nowrap list" width="100%">
						<thead>
							<tr>
								<th class="text-center">Họ Tên</th>
								<th class="text-center">Ngày Sinh</th>
								<th class="text-center">Giới Tính</th>
								<th class="text-center">Trạng Thái</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($pros as $pro)
							<tr onclick="modify('{{ route('modify_pro', ['id' => $pro['id']]) }}');">
								<td class="text-capitalize">{{ $pro['name'] }}</td>
								<td class="text-center">
									{{ Carbon\Carbon::parse($pro['profile']['date_of_birth'])->format('d-m-Y') }}
								</td>
								<td class="text-center">
									@if ($pro['profile']['gender'] == '1')
										Nam
									@elseif ($pro['profile']['gender'] == '2')
										Nữ
									@else
										Khác
									@endif
								</td>
								<td class="text-center">
									@if ($pro['profile']['state'] == '1')
										<span class="label label-primary">Sẵn Sàng</span>
									@elseif ($pro['profile']['state'] == '2')
										<span class="label label-default">Treo</span>
									@elseif ($pro['profile']['state'] == '3')
										<span class="label label-warning">Cảnh cáo</span>
									@elseif ($pro['profile']['state'] == '4')
										<span class="label label-danger">Khóa</span>
									@elseif ($pro['profile']['state'] == '5')
										<span class="label label-secondary">Cấm vĩnh viễn</span>
									@else
										<span class="label label-success">Chờ Duyệt</span>
									@endif
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- MODAL -->
</section>
@endsection
