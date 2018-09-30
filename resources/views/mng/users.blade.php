@extends('template.mng.index')
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
		$('.owl-carousel').owlCarousel({
			center: false,
			loop: false,
			nav: false,
			margin: 10,
			items: 5,
			autoWidth: true,
		});
		$('.datepicker-only-init').datetimepicker({
			widgetPositioning: {
				horizontal: 'left'
			},
			locale: moment.locale('vi'),
			icons: {
				time: "fa fa-clock-o",
				date: "fa fa-calendar",
				up: "fa fa-arrow-up",
				down: "fa fa-arrow-down"
			},
			format: 'DD/MM/YYYY',
		});
	});
</script>
@endpush

@section('title') Khách hàng @endsection

@section('content')
<section class="content-body-full-page content-template-1">
	<div class="page-header hf-bg-gradient text-capitalize">Khách hàng</div>
	<div class="margin-30 mng-report">
		<form method="get" action="{{ route('mng_user_list') }}">
		<div class="search-row">
			<div class="form-group">
				<input type="text" class="form-control datepicker-only-init"
					name="fromDate"
					value="{{ app('request')->input('fromDate') }}"
					placeholder="DD/MM/YYYY" />
				<input type="text" class="form-control datepicker-only-init"
					name="endDate"
					value="{{ app('request')->input('endDate') }}"
					placeholder="DD/MM/YYYY" />
				<button class="btn btn-primary" type="submit">Hiển thị</button>
			</div>
		</div>
		</form>
		@if (sizeof($usingUserCountReport) > 0)
		<h5 class="margin-top-20">Số lượng Khách hàng Sử dụng</h5>
		<div id="reportCarousel" class="owl-carousel owl-theme">
			@foreach ($usingUserCountReport as $item)
			<div class="item mng-report">
				<div class="widget widget-seven widget-report">
					<div class="widget-body">
						<div class="widget-body-inner">
							<h5 class="text-uppercase">Tháng {{ substr($item->yearmonth, -2) }}</h5>
							<span class="counter-count">
								<span class="counter-init">
									{{ number_format($item->data, 0, ',', '.') }}
								</span>
							</span>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		@endif
	</div>
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
								@if ($user->facebook_id) <i class="icmn-facebook color-primary"></i> @endif
								@if ($user->google_id) <i class="icmn-google-plus color-danger"></i> @endif
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
