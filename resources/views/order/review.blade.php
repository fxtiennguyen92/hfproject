<div id="modalReview" class="modal modal-size-small fade modal-review" role="dialog">
	<div class="modal-dialog">
		<form id="frmReview" method="post" enctype="multipart/form-data" action="{{ route('order_review') }}">
		<div class="modal-content">
			<div class="page-header hf-bg-gradient">Đánh giá dịch vụ</div>
			<div class="modal-body margin-top-10 padding-top-30 padding-bottom-30">
				<div class="author-avt"><img src="{{ env('CDN_HOST') }}/u/{{ $order->pro->id }}/{{ $order->pro->avatar }}" /></div>
				<select id="rating" class="text-center rating-review" name="rating" data-current-rating="">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
				
				<div class="row review-type" style="display: none;">
					<div class="text-center font-size-13 padding-bottom-10">Bạn muốn Hand Free cần cải thiện điều gì?</div>
					<div class="col-sm-4 col-xs-6 btn-group" data-toggle="buttons">
						<label class="btn">
							<input type="checkbox"
									name="type[]"
									value="1">
							<span class="icon icmn-user"></span>
							Thái độ
						</label>
					</div>
					<div class="col-sm-4 col-xs-6 btn-group" data-toggle="buttons">
						<label class="btn">
							<input type="checkbox"
									name="type[]"
									value="1">
							<span class="icon icmn-alarm"></span>
							Thời gian
						</label>
					</div>
					<div class="col-sm-4 col-xs-6 btn-group" data-toggle="buttons">
						<label class="btn">
							<input type="checkbox"
									name="type[]"
									value="1">
							<span class="icon icmn-cog"></span>
							Chất lượng
						</label>
					</div>
					<div class="col-sm-4 col-xs-6 btn-group" data-toggle="buttons">
						<label class="btn">
							<input type="checkbox"
									name="type[]"
									value="1">
							<span class="icon icmn-tree7"></span>
							Quy trình
						</label>
					</div>
					<div class="col-sm-4 col-xs-6 btn-group" data-toggle="buttons">
						<label class="btn">
							<input type="checkbox"
									name="type[]"
									value="1">
							<span class="icon icmn-shield-check"></span>
							An toàn
						</label>
					</div>
					<div class="col-sm-4 col-xs-6 btn-group" data-toggle="buttons">
						<label class="btn">
							<input type="checkbox"
									name="type[]"
									value="1">
							<span class="icon icmn-menu"></span>
							Khác
						</label>
					</div>
				</div>
				<textarea class="form-control" style="padding: 10px;" name="content" rows="4" maxlength="500" placeholder="Nhận xét của bạn"></textarea>
			</div>
			<div class="row-complete">
				<button id="btnBack" type="button" class="btn color-default" data-dismiss="modal"><i class="material-icons">keyboard_arrow_left</i></button>
				<button id="btnReview" type="button" class="btn btn-primary" style="height: 69px; font-size: 18px;"><i class="material-icons">thumb_up_alt</i></button>
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			</div>
		</div>
		</form>
	</div>
</div>

<script>
$(document).ready(function() {
	autosize($('textarea'));

	$('#btnReview').on('click', function() {
		$(this).prop('disabled', true);
		
		$.ajax({
			type: 'POST',
			url: '{{ route("order_review") }}',
			data: $('#frmReview').serialize(),
			success: function(response) {
				swal({
					title: 'Hoàn tất',
					text: 'Cám ơn bạn, nhận xét của bạn sẽ giúp nâng cao chất lượng của chúng tôi',
					type: 'success',
					confirmButtonClass: 'btn-primary',
					confirmButtonText: 'Quay lại',
				},
				function() {
					location.href = "{{ route('order_list_page') }}";
				});
			},
			error: function(xhr) {
				swal({
					title: 'Thất bại',
					text: 'Có lỗi phát sinh, mời bạn để lại nhận xét sau',
					type: 'success',
					confirmButtonClass: 'btn-primary',
					confirmButtonText: 'Quay lại',
				},
				function() {
					location.href = "{{ route('order_list_page') }}";
				});
			}
		});
	});
});
</script>