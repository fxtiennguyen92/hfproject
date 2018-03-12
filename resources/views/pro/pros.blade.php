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
		var returnUrl = '{{ route("home_page") }}';
		@if (auth()->check())
			@if (auth()->user()->id == 2)
				returnUrl = '{{ route("view_pro_mng_page") }}';
			@else
				returnUrl = '{{ route("pro_list_page") }}';
			@endif
		@endif
		
		$('.list').DataTable({
			responsive: true,
			info: false,
			paging: false,
			language: {
				lengthMenu: "Hiển thị _MENU_ dòng",
				zeroRecords: "Không có bất kỳ Nhân viên nào",
				search: "Tìm kiếm"
			},
			order: [[3, 'desc']],
			columnDefs: [ { orderable: false, targets: [1] } ]
		});

		$('a.delete').on('click', function() {
			var url = '{{ route("delete_pro_by_pro_mng", ["proId" => "proIndex"]) }}';
			url = url.replace('proIndex', $(this).attr('pro-id'));
			
			swal({
				title: '',
				text: 'Bạn muốn xóa Tài khoản này?',
				type: 'warning',
				showCancelButton: true,
				cancelButtonClass: 'btn-default',
				confirmButtonClass: 'btn-danger',
				cancelButtonText: 'Quay lại',
				confirmButtonText: 'Xóa',
			},
			function(){
				$.ajax({
					type: 'POST',
					url: url,
					data: $('#frmMain').serialize(),
					success: function(response) {
						swal({
							title: 'Đã xóa',
							text: 'Tài khoản đã được xóa.',
							type: 'info',
							confirmButtonClass: 'btn-primary',
							confirmButtonText: 'Kết thúc',
						},
						function() {
							location.href = returnUrl;
						});
					},
					error: function(xhr) {
						$.notify({
							title: '<strong>Thất bại! </strong>',
							message: 'Không thể xóa Tài khoản này.'
						}, {
							type: 'danger',
							z_index: 1051,
						});
					}
				});
			});
		});
	});
</script>
@endpush

@section('title') @if (auth()->user()->role == 90) Danh sách Đối tác @else Danh sách Nhân viên @endif @endsection

@section('content')
<section class="content-body content-template-1">
	<div class="form-wrapper">
		<h1 class="page-title text-left">@if (auth()->user()->role == 90) Danh sách Đối tác @else Danh sách Nhân viên @endif</h1>
		<button type="button" onclick="location.href='{{ route('signup_pro') }}'" class="btn btn-primary"><i class="material-icons">&#xE7F0;</i></button>
		<div class="row">
			<div class="col-md-12">
				<table class="emp-table table table-hover nowrap list" width="100%">
					<thead>
						<tr>
							<th class="text-center col-name">Họ tên / Tài khoản</th>
							<th>&nbsp;</th>
							<th class="text-center col-state">Trạng thái</th>
							<th class="text-center">Ngày đăng ký</th>
							<th class="text-center">Giới tính</th>
							<th class="text-center">Ngày sinh</th>
							
						</tr>
					</thead>
					<tbody>
						@foreach ($pros as $pro)
						<tr>
							<td class="text-capitalize">
								<div class="emp-name">{{ $pro['name'] }}
									@if ($pro['role'] == 2)
									<span style="color: red; font-style: italic;">(Mng)</span>
									@endif
								</div>
								<div class="emp-email">{{ $pro['email'] }}</div>
							</td>
							<td>
								<div class="dropdown margin-inline pull-right">
									<span class="btn btn-sm " data-toggle="dropdown">
									<i class="icmn-cog3"></i>
									</span>
									<ul class="dropdown-menu dropdown-menu-right" role="menu">
										@if (auth()->user()->role == 90)
										<a class="dropdown-item view" href="{{ route('pro_profile_mng_page', ['proId' => $pro['id']]) }}">
											<i class="icmn-grid6"></i> Chi tiết
										</a>
										@endif
									</ul>
								</div>
							</td>
							<td class="text-center">
								@if ($pro['delete_flg'] == 1)
									<span class="label label-secondary">Đã xóa</span>
								@elseif ($pro['profile']['state'] == '1')
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
							<td class="text-center">
								{{ Carbon\Carbon::parse($pro['created_at'])->format('d-m-Y H:i') }}
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
								{{ Carbon\Carbon::parse($pro['profile']['date_of_birth'])->format('d-m-Y') }}
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
