@extends('template.index') @push('stylesheets')
<style>
	@media only screen and (max-width: 500px) {
		.top-menu {
			display: none;
		}
	}
</style>
<script>
	$(document).ready(function() {
		$('.btn-submit').on('click', function() {
			$.ajax({
				type: 'POST',
				url: $('#frmMain').attr('action'),
				data: $('#frmMain').serialize(),
				success: function(response) {
					swal({
							title: 'Thành công',
							text: 'Bạn đã chọn đối tác cho mình!',
							type: 'success',
							confirmButtonClass: 'btn-primary',
							confirmButtonText: 'Xem đơn hàng',
						},
						function() {
							location.href = '{{ url()->previous() }}';
						});
				},
				error: function(xhr) {
					if (xhr.status == 400) {
						swal({
						 title: 'Thất bại',
							text: 'Không thể chọn đối tác này, hãy thử lại!',
							type: 'danger',
							confirmButtonClass: 'btn-default',
							confirmButtonText: 'Quay lại',
						},
						function() {
							location.href = '{{ url()->previous() }}';
						});
					}
				}
			});
		});
	});
</script>
@endpush @section('title') Trang điều khiển @endsection @section('content')
<section class="content-body content-width-700 @if (isset($action) && $action == 'order') has-mb-button-bottom @endif">
	<div class="padding-top-20 hf-card pro-profile" style="margin-right:0; min-height:560px;">
		<div class="row">
			<div class="col-lg-6 col-md-12">
				<div class="flex row">
					<div class="col-md-5 col-sm-5 col-xs-5 service-info margin-left-20">
						<img style="border-radius:100%" class="avt" src="{{ env('CDN_HOST') }}/u/{{ $pro->id }}/{{ $pro->avatar }}">
					</div>
					<div class="pro-info col-md-7 col-sm-7 col-xs-7">
						<h4 class="text-bold">{{ $pro->name }}</h4>
						<p>{{ $pro->profile->age }} tuổi, @if ($pro->profile->gender == 1) Nam @elseif ($pro->profile->gender == 2) Nữ @endif</p>
						<p>@if (isset($pro->profile->company))
							{{ $pro->profile->company->name }}
							@else
							Kinh doanh cá nhân
							@endif
						</p>
						<div class="margin-top-10">
							@php $services = explode(', ', $pro->profile->service_str) @endphp
							@foreach ($services as $s)
							<label class="label label-secondary">{{ $s }}</label>
							@endforeach
						</div>
					</div>
				</div>
			</div>

			<div class="text-center col-lg-6 col-md-12">
				<div class="row skill-rating text-center padding-20">
					<div class="row">
						<div class="col-md-4 col-sm-4 col-xs-4">
							<span class="btn btn-info-outline hf-rounded">{{ $pro->profile->total_orders }}</span>
							<div class="skill-title margin-top-10">Đơn hàng</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-4">
							<span class="btn btn-info hf-rounded">{{ $pro->profile->rating }}</span>
							<div class="skill-title margin-top-10">Đánh giá</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-4">
							<span class="btn btn-info hf-rounded">{{ $pro->profile->total_review }}</span>
							<div class="skill-title margin-top-10">Nhận xét</div>
						</div>
					</div>
				</div>

			</div>
		</div>
		@if (isset($action) && $action == 'order')
		<div class="text-center padding-20 btn-book-border">
			<button id="btnAccept" type="button" class="btn-submit btn-book btn btn-primary-outline">Chọn đối tác này</button>
		</div>
		@endif
		<div class="row">
			<div class="col-md-6">
				<div class="project padding-20">
					<div class=" row">
						<h5>Dự án đã thực hiện</h5>
						@if ($pro->profile->total_orders == 0)
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="common-text">Chưa có hình ảnh</div>
						</div>
						@else
						<div class="col-md-6 col-sm-6 col-xs-6 margin-bottom-15">
							<img src="https://st.hzcdn.com/simgs/2451f7cd09a9836c_8-4753/home-design.jpg">
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6 margin-bottom-15">
							<img src="https://st.hzcdn.com/fimgs/ddf197ea09fbc14b_1249-w234-h260-b0-p0--.jpg">
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6 margin-bottom-15">
							<img src="http://suachuadandung.com/wp-content/uploads/2013/09/SUA-HE-THONG-NUOC.jpg">
						</div>
						@endif
					</div>
					@if ($pro->profile->total_orders > 5)
					<div class="text-center"><a href="#">Xem tất cả</a></div>
					@endif
				</div>
			</div>
			<div class="col-md-6">
				<div class="row comment padding-20">
					<h5>Nhận xét @if ($pro->profile->total_review > 0) ({{ $pro->profile->total_review }}) @endif</h5>
					@if ($pro->profile->total_review == 0)
					<div class="col-md-12">
						<div class="common-text">Chưa có nhận xét</div>
					</div>
					@else @foreach ($pro->profile->reviews as $review)
					<div class="message row">
						<div class=" col-md-2 col-sm-2 col-xs-2 text-center">
							<img class="avatar" style="border-radius:100%" class="avt" src="{{ env('CDN_HOST') }}/u/{{ $review->user->id }}/{{ $review->user->avatar }}">
						</div>
						<div class="col-md-10 col-sm-10 col-xs-10">
							<div class="clearfix">
								<div class="pull-left author"><a href="#">{{ $review->user->name }}</a> <span>{{ $review->created_at->format('d/m/Y') }}</span></div>
								<div class="author-rating pull-right">
									<select id="rating" class="rating" data-current-rating="{{ $review->rating }}">
										<option value=""></option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
									</select>
								</div>
							</div>
							<div class="message-text">
								{{ $review->content }}
							</div>
						</div>
					</div>
					@endforeach @endif @if ($pro->profile->total_review > 10)
					<div class="text-center"><a href="#">Xem tất cả</a></div>
					@endif
				</div>
			</div>
		</div>
		@if (isset($action) && $action == 'order')
		<div class="text-center">
			<form id="frmMain" method="POST" action="{{ route('accept_quoted_price', ['proId' => $pro->id]) }}">
				<button id="btnAccept" type="button" class="mb-btn-book btn-submit">Chọn đối tác này</button>
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			</form>
		</div>
		@endif
	</div>
</section>
@endsection
