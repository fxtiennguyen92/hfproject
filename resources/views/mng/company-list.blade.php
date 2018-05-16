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

@section('title') Doanh nghiệp @endsection

@section('content')
<section class="content-body-full-page content-template-1">
	<div class="page-header hf-bg-gradient text-capitalize">Doanh nghiệp</div>
	<div class="form-wrapper">
		<button class="btn btn-primary pull-right" type="button" onclick="location.href='{{ route('mng_company_page') }}'">
			<i class="material-icons">&#xE7F0;</i></button>
		<div class="row">
			<div class="col-md-12">
				<table class="table table-hover nowrap mng-list" width="100%">
					<thead>
						<tr>
							<th class="text-center">Mã</th>
							<th class="text-center">Doanh nghiệp</th>
							<th class="text-center">Trạng thái</th>
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
									@if ($comp->phone_1) {{ $comp->phone_1 }} @endif
									@if ($comp->phone_1 && $comp->phone_2) {{ ' - '.$comp->phone_2 }} @endif
									@if (!$comp->phone_1 && $comp->phone_2) {{ $comp->phone_2 }} @endif
									@if (!$comp->phone_1 && !$comp->phone_2)
									<span class="no-info">Chưa cập nhật</span>
									@endif 
								</div>
							</td>
							<td class="text-center col-label-company-state">
								@if ($comp->state == 0)
									<span class="label label-warning">New</span>
								@elseif ($comp->state == '1')
									<span class="label label-primary">Active</span>
								@endif
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!-- MODAL -->
</section>
@endsection
