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
			paging: true,
			ordering: false,
			language: {
				zeroRecords: "Chưa có thông tin",
				search: "Tìm kiếm",
				lengthMenu: "Hiện _MENU_ dòng",
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
<section class="content-body content-template-1 has-bottom-menu">
	<div class="page-header hf-bg-gradient text-capitalize">Doanh nghiệp</div>
	<div class="form-wrapper">
		<div class="text-right">
			<button class="btn btn-primary" type="button" onclick="location.href='{{ route('pa_company_new') }}'">
				<i class="material-icons">create</i></button>
		</div>
		<div class="row">
			<div class="col-md-12">
				<table class="table table-hover mng-list" width="100%">
					<thead>
						<tr>
							<th class="text-center">Doanh nghiệp</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($companies as $comp)
						<tr>
							<td>
								<span class="col-company-name">{{ $comp->name }}</span>
								<div class="col-company-address padding-left-5">
									<i class="material-icons">location_on</i>
									@if ($comp->address_1)
									<span class="address">{{ $comp->address_1.' '.$comp->address_2 }}</span>
									@else
									<span class="no-info">Chưa cập nhật</span>
									@endif
								</div>
								<div class="col-company-phone padding-left-5">
									<i class="material-icons">phone</i>
									@if ($comp->phone_1) {{ $comp->phone_1 }} @endif
									@if ($comp->phone_1 && $comp->phone_2) {{ ' - '.$comp->phone_2 }} @endif
									@if (!$comp->phone_1 && $comp->phone_2) {{ $comp->phone_2 }} @endif
									@if (!$comp->phone_1 && !$comp->phone_2)
									<span class="no-info">Chưa cập nhật</span>
									@endif 
								</div>
								<div class="col-company-style padding-left-5">
									<i class="material-icons">widgets</i>
									@foreach(json_decode($comp->style)->style as $key => $value)
										@if ($key > 0) ,@endif 
										@if ($value == '0')Dịch vụ
										@elseif ($value == '1')Bán vật tư
										@endif
									@endforeach
								</div>
								@if (isset(json_decode($comp->style)->service_name)
									&& sizeof(json_decode($comp->style)->service_name) > 0)
								<div class="col-company-style padding-left-35">
									@foreach(json_decode($comp->style)->service_name as $key => $value)
										@if ($key > 0) ,@endif 
										{{ $value }}
									@endforeach
								</div>
								@endif
								@if (isset(json_decode($comp->style)->material_name)
									&& sizeof(json_decode($comp->style)->material_name) > 0)
								<div class="col-company-style padding-left-35">
									@foreach(json_decode($comp->style)->material_name as $key => $value)
										@if ($key > 0) ,@endif
										{{ $value }}
									@endforeach
								</div>
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
@include('template.mng.footer-menu')
@endsection