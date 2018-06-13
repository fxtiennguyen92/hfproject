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
			order: [[2, 'desc']],
			columnDefs: [ { orderable: false, targets: [3] } ]
		});
	});

	function deleteDoc(id) {
		var url = '{{ route("mng_doc_delete", ["id" => "docId" ]) }}';
		url = url.replace('docId', id);
		
		$.ajax({
			type: 'POST',
			url: url,
			data: $('#frmMain').serialize(),
			success: function(response) {
				swal({
					title: 'Hoàn thành',
					text: 'Đã xóa thành công',
					type: 'success',
					confirmButtonClass: 'btn-success',
					confirmButtonText: 'Quay lại',
				},
				function() {
					location.href = '{{ route("mng_doc_list") }}';
				});
			},
			error: function(xhr) {
				swal({
					title: 'Thất bại',
					text: 'Yêu cầu không thực hiện được!',
					type: 'error',
					confirmButtonClass: 'btn-default',
					confirmButtonText: 'Quay lại',
				});
			}
		});
	}
</script>
@endpush

@section('title') Tài liệu @endsection

@section('content')
<section class="content-body-full-page content-template-1">
	<div class="page-header hf-bg-gradient text-capitalize">Tài liệu</div>
	<div class="form-wrapper">
		<div class="text-right">
			<button class="btn btn-primary" type="button" onclick="location.href='{{ route('mng_doc_new') }}'">
				<i class="material-icons">create</i></button>
		</div>
		<div class="row">
			<div class="col-md-12">
				<table class="table table-hover nowrap mng-list" width="100%">
					<thead>
						<tr>
							<th class="text-center">URL</th>
							<th class="text-center">Tiêu đề</th>
							<th class="text-center">Ngày chỉnh sửa</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($docs as $doc)
						<tr>
							<td>{{ '/'.$doc->url_name }}</td>
							<td title="{{ $doc->title }}"><span class="doc-title">{{ $doc->title }}</span></td>
							<td class="text-center">
								<span class='hide'>{{ Carbon\Carbon::parse($doc->updated_at)->format('YmdHi') }}</span>
								{{ Carbon\Carbon::parse($doc->updated_at)->format('d/m/Y H:i') }}
							</td>
							<td class="text-right">
								<div class="dropdown">
									<span class="btn" data-toggle="dropdown">
									<i class="icmn-cog3"></i>
									</span>
									<ul class="dropdown-menu dropdown-menu-right" role="menu">
										<a class="dropdown-item" href="{{ route('mng_doc_edit', ['id' => $doc->id]) }}">
											<i class="icmn-pencil"></i> Sửa
										</a>
										<a class="dropdown-item" href="javascript:void(0);" onclick="return deleteDoc('{{ $doc->id }}');">
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
</section>
@endsection
