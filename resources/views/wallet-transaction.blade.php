@extends('template.index') @push('stylesheets')
<script>
</script>
@endpush @section('title') Lịch sử giao dịch @endsection @section('content')
<section class="content-body has-bottom-menu">
	<div class="page-header hf-bg-gradient text-capitalize">Lịch sử giao dịch</div>
	<table class="table table-hover nowrap mng-list" width="100%">
		<thead>
			<tr>
				<th class="text-center">Thời gian</th>
				<th class="text-center">Nội dung</th>
				<th class="text-center">Số tiền</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td></td>
			</tr>
		</tbody>
	</table>
</section>
@endsection
@include('template.mb.footer-menu')