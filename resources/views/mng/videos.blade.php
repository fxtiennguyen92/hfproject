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
			order: [[3, 'desc']],
			columnDefs: [ { orderable: false, targets: [4] } ]
		});
	});

	function deleteBlog(id) {
		swal({
			title: 'Xóa bài viết?',
			text: 'Bài viết sẽ không thể phục hồi.',
			type: 'warning',
			showCancelButton: true,
			cancelButtonClass: 'btn-default',
			confirmButtonClass: 'btn-danger',
			cancelButtonText: 'Quay lại',
			confirmButtonText: 'Xóa',
			closeOnConfirm: false,
		},
		function() {
			swal({
				title: 'Đang xử lý yêu cầu',
				text: 'Xin chờ trong giây lát!',
				type: 'info',
				showConfirmButton: false,
				closeOnConfirm: false,
			});
			
			var url = "{{ route('mng_blog_delete', ['id' => 'blogId']) }}";
			url = url.replace('blogId', id);
			
			$('#frmMain').attr('action', url);
			$('#frmMain').submit();
		});
		
	}

	function highlightBlog(id) {
		swal({
			title: 'Đang xử lý yêu cầu',
			text: 'Xin chờ trong giây lát!',
			type: 'info',
			showConfirmButton: false,
			closeOnConfirm: false,
		});
		
		var url = "{{ route('mng_blog_highlight', ['id' => 'blogId']) }}";
		url = url.replace('blogId', id);
		
		$('#frmMain').attr('action', url);
		$('#frmMain').submit();
	}

	function unhighlightBlog(id) {
		swal({
			title: 'Đang xử lý yêu cầu',
			text: 'Xin chờ trong giây lát!',
			type: 'info',
			showConfirmButton: false,
			closeOnConfirm: false,
		});
		
		var url = "{{ route('mng_blog_unhighlight', ['id' => 'blogId']) }}";
		url = url.replace('blogId', id);
		
		$('#frmMain').attr('action', url);
		$('#frmMain').submit();
	}
</script>
@endpush

@section('title') Quản lý Blog @endsection

@section('content')
<section class="content-body-full-page content-template-1">
	<div class="page-header hf-bg-gradient text-capitalize">Video</div>
	<div class="form-wrapper">
		<button class="btn btn-primary pull-right" type="button" onclick="location.href='{{ route('mng_video_new') }}'">
			<i class="material-icons">subscriptions</i></button>
		<div class="row">
			<div class="col-md-12">
				<table class="table table-hover nowrap mng-list" width="100%">
					<thead>
						<tr>
							<th class="text-center">Tiêu đề</th>
							<th class="text-center">Tên file</th>
							<th class="text-center">Ngày đăng</th>
							<th class="text-center">Ngày chỉnh sửa</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($videos as $video)
						<tr>
							<td title="{{ $video->title }}"><span class="blog-title">{{ $video->title }}</span></td>
							<td class="">{{ $video->content }}</td>
							<td class="text-center">
								<span class='hide'>{{ Carbon\Carbon::parse($video->created_at)->format('YmdHi') }}</span>
								{{ Carbon\Carbon::parse($video->created_at)->format('d/m/Y H:i') }}
							</td>
							<td class="text-center">
								<span class='hide'>{{ Carbon\Carbon::parse($video->updated_at)->format('YmdHi') }}</span>
								{{ Carbon\Carbon::parse($video->updated_at)->format('d/m/Y H:i') }}
							</td>
							
							<td class="text-right">
								<div class="dropdown">
									<span class="btn btn-sm" data-toggle="dropdown">
									<i class="icmn-cog3"></i>
									</span>
									<ul class="dropdown-menu dropdown-menu-right" role="menu">
										<a class="dropdown-item" href="{{ route('mng_blog_edit', ['id' => $video->id]) }}">
											<i class="icmn-grid6"></i> Chi tiết
										</a>
										<a class="dropdown-item" href="javascript:void(0);" onclick="deleteBlog('{{ $video->id }}')">
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
