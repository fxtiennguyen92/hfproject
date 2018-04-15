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
			columnDefs: [ { orderable: false, targets: [1] } ]
		});
	});
</script>
@endpush

@section('title') Quản lý Blog @endsection

@section('content')
<section class="content-body-full-page content-template-1">
	<div class="page-header hf-bg-gradient text-capitalize">Blog</div>
	<div class="form-wrapper">
		<button class="btn btn-primary pull-right" type="button" onclick="location.href='{{ route('mng_blog_page') }}'">
			<i class="material-icons">&#xE89C;</i></button>
		<div class="row">
			<div class="col-md-12">
				<table class="table table-hover nowrap mng-list" width="100%">
					<thead>
						<tr>
							<th class="text-center">Mã</th>
							<th class="text-center">Tiêu đề</th>
							<th class="text-center">Đối tượng</th>
							<th class="text-center">Ngày đăng</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($blogs as $blog)
						<tr onclick="location.href='{{ route('mng_blog_page', ['urlName' => $blog->url_name]) }}'">
							<td class="text-center">{{ '#'.sprintf('%05d', $blog->id) }}</td>
							<td title="{{ $blog->title }}"><span class="blog-title">{{ $blog->title }}</span></td>
							<td class="blog-style text-center">
								@if ($blog->style == 0)
								<span class="label label-primary">Chung</span>
								@else
								<span class="label label-success">Đối tác</span>
								@endif
							</td>
							<td class="text-center">
								{{ Carbon\Carbon::parse($blog->created_at)->format('d/m/Y H:i') }}
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
