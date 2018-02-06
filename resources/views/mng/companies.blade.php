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
				zeroRecords: "Không có bất kỳ Doanh Nghiệp nào",
				search: "Tìm kiếm"
			},
		});
	});

	function modify(url) {
		swal({
			title: '',
			text: 'Bạn muốn thay đổi thông tin Doanh Nghiệp này?',
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
			<h1 class="page-title text-left">Danh sách Doanh Nghiệp</h1>
			<div class="row">
				<div class="col-md-12">
					<table class="table table-hover nowrap list" width="100%">
						<thead>
							<tr>
								<th class="text-center">Mã</th>
								<th class="text-center" width="85%">Doanh Nghiệp</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($companies as $comp)
							<tr onclick="modify('{{ route('modify_company', ['id' => $comp->id]) }}');">
								<td class="text-center">{{ sprintf('#%04d', $comp->id) }}</td>
								<td>
									<span class="text-uppercase">{{ $comp->name }}</span>
									<div><i class="material-icons">location_on</i>
										@if ($comp->address) {{ $comp->address }} @else
										<span class="no-info">Chưa cập nhật</span>
										@endif
									</div>
									<div><i class="material-icons">email</i>
										@if ($comp->email) {{ $comp->email }} @else
										<span class="no-info">Chưa cập nhật</span>
										@endif
									</div>
									<div><i class="material-icons">phone</i>
										@if ($comp->phone) {{ $comp->phone }} @else
										<span class="no-info">Chưa cập nhật</span>
										@endif 
									</div>
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
