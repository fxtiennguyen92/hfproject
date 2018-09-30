@extends('template.mng.index')
@push('stylesheets')
<style>
</style>

<!-- Page Scripts -->
<script>
	$(document).ready(function() {
		$('.time').mask('00:00');
		$('.datetimepicker').datetimepicker({
			minDate: moment(),
			locale: moment.locale('vi'),
			format: 'DD/MM/YYYY',
			showClose: true,
			widgetPositioning: {
				horizontal: 'auto',
				vertical: 'top'
			},
			icons: {
				time: 'fa fa-clock-o',
				date: 'fa fa-calendar',
				up: 'fa fa-chevron-up',
				down: 'fa fa-chevron-down',
				previous: 'fa fa-chevron-left',
				next: 'fa fa-chevron-right',
				today: 'fa fa-screenshot',
				clear: 'fa fa-trash',
				close: 'fa fa-check'
			},
		});
		
		$('.mng-list').DataTable({
			responsive: true,
			info: false,
			paging: false,
			ordering: false,
			language: {
				zeroRecords: "Chưa có thông tin",
				search: "Tìm kiếm"
			},
		});

		$('#frmNewEvent').validate({
			submit: {
				settings: {
					inputContainer: '.form-group',
					errorListClass: 'form-control-error',
					errorClass: 'has-danger',
				},
				callback: {
					onSubmit: function() {
						loadingBtnSubmit('btnSubmit');
						
						$.ajax({
							type: 'POST',
							url: '{{ route("mng_event_create") }}',
							data: $('#frmNewEvent').serialize(),
							success: function(response) {
								swal({
									title: 'Hoàn thành',
									text: 'Tạo thành công',
									type: 'success',
									confirmButtonClass: 'btn-success',
									confirmButtonText: 'Quay lại',
								},
								function() {
									location.href = '{{ route("mng_event_list") }}';
								});
							},
							error: function(xhr) {
								swal({
									title: 'Thất bại',
									text: 'Có lỗi phát sinh, mời thử lại!',
									type: 'error',
									confirmButtonClass: 'btn-default',
									confirmButtonText: 'Quay lại',
								});
								resetBtnSubmit('btnSubmit', 'Tạo sự kiện');
							}
						});
					}
				}
			}
		});
	});
	
	function deleteEvent(eventId) {
		swal({
			title: 'Xóa Sự kiện',
			text: 'Dữ liệu sẽ không thể khôi phục',
			type: 'warning',
			showCancelButton: true,
			cancelButtonClass: 'btn-default',
			confirmButtonClass: 'btn-danger',
			cancelButtonText: 'Quay lại',
			confirmButtonText: 'Xóa',
			closeOnConfirm: false,
		},
		function() {
			var url = "{{ route('mng_event_delete', ['id' => 'eventId']) }}";
			url = url.replace('eventId', eventId);
			$.ajax({
				type: 'POST',
				url: url,
				data: $('#frmMain').serialize(),
				success: function(response) {
					swal({
						title: 'Hoàn thành',
						text: 'Xóa thành công',
						type: 'success',
						confirmButtonClass: 'btn-success',
						confirmButtonText: 'Quay lại',
					},
					function() {
						location.reload();
					});
				},
				error: function(xhr) {
					swal({
						title: 'Thất bại',
						text: 'Có lỗi phát sinh, mời thử lại!',
						type: 'error',
						confirmButtonClass: 'btn-default',
						confirmButtonText: 'Quay lại',
					});
				}
			});
		});
	}
</script>
@endpush

@section('title') Sự kiện @endsection

@section('content')
<section class="content-body-full-page content-template-1">
	<div class="page-header hf-bg-gradient text-capitalize">Sự kiện</div>
	<div class="form-wrapper">
		<div class="text-right">
			<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalNewEvent">
				<i class="material-icons">alarm_add</i></button>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-hover nowrap mng-list" width="100%">
					<thead>
						<tr>
							<th class="text-center col-name">Tên sự kiện</th>
							<th class="text-center col-name">Thời gian</th>
							<th class="text-center col-name">Địa điểm</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($events as $event)
						<tr>
							<td class="font-weight-600">{{ $event->name }}</td>
							<td>
								<span class='hide'>{{ Carbon\Carbon::parse($event->date)->format('Ymd').$event->from_time }}</span>
								<div>{{ $event->from_time }} @if ($event->end_time) {{ ' - '.$event->end_time }} @endif</div>
								<div>{{ Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</div>
							</td>
							<td>
								<div class="font-weight-600">{{ $event->place }}</div>
								<div>{{ $event->address }}</div>
							</td>
							<td class="text-right">
								<div class="dropdown">
									<span class="btn" data-toggle="dropdown">
									<i class="icmn-cog3"></i>
									</span>
									<ul class="dropdown-menu dropdown-menu-right" role="menu">
										<a class="dropdown-item" href="javascript:void(0);" onclick="return deleteEvent('{{ $event->id }}');">
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
	<div id="modalNewEvent" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<form id="frmNewEvent" method="post" name="form-validation" enctype="multipart/form-data" action="">
				<div class="modal-content">
					<div class="modal-body">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<div class="form-wrapper">
							<h1 class="page-title text-left">Tạo Sự kiện</h1>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label>Tên sự kiện</label>
										<input type="text" maxlength="150" class="form-control" name="name" data-validation="[NOTEMPTY]"
											value="TRAINING">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Thời gian bắt đầu</label>
										<input type="text" maxlength="5" class="form-control time" name="from_time" data-validation="[NOTEMPTY]">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Thời gian kết thúc</label>
										<input type="text" maxlength="5" class="form-control time" name="end_time">
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<label>Ngày</label>
										<input type="text" maxlength="10" class="form-control datetimepicker" name="date" data-validation="[NOTEMPTY]">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label>Nơi tổ chức</label>
										<input type="text" maxlength="150" class="form-control" name="place">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label>Địa chỉ</label>
										<input type="text" maxlength="150" class="form-control" name="address">
									</div>
								</div>
							</div>
							<div class="row text-right padding-top-30" style="margin-bottom: -15px;">
								<button id="btnSubmit" type="submit" class="btn btn-primary width-150">Tạo sự kiện</button>
								<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
@endsection