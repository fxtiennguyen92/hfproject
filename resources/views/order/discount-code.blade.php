<script>
$(document).ready(function() {
	$('#searchDisCode').on('keyup', function() {
		var searchCode = $(this).val();
		if (searchCode.length >= 2 && searchCode !== $('#oldDisCode').val()) {
			$('#oldDisCode').val(searchCode);
			$('#iconDisCode').removeClass('icmn-search').addClass('fa fa-spinner fa-spin');
			
			$.ajax({
				type: 'GET',
				url: "{{ route('order_discount_code_list') }}"+'?search='+searchCode,
				success: function(codes) {
					$('#disCodes').empty();
					if (codes.length > 0) {
						for(var k in codes) {
							var codeCard = '';
							codeCard+= '<div class="col-sm-4 col-xs-6" onclick="return setDisCode(' + "'" + codes[k].code + "'" + ')">';
							codeCard+= '<div class="discount-code-card">';
							codeCard+= '<div class="image" style="background-image: url({{ env("CDN_HOST") }}/img/service/0esuuM.png)"></div>';
							codeCard+= '<div class="description">' + codes[k].description + '</div>';
							codeCard+= '<div class="row">';
							codeCard+= '<div class="col-xs-6 title">' + codes[k].code + '</div>';
							codeCard+= '<div class="col-xs-6 code-blog" onclick="return viewBlog(' + "'" + 'https://handfree.co/doc/privacy' + "'" +');"><i class="icmn-menu"></i></div>';
							codeCard+= '</div></div></div>';
							
							$('#disCodes').append(codeCard);
						}
						
						$('#content').html('Hãy chọn mã khuyến mãi của bạn');
					} else {
						$('#content').html('Mã không tồn tại hoặc đã hết hiệu lực');
					}
					
					$('#iconDisCode').removeClass('fa fa-spinner fa-spin').addClass('icmn-search');
				},
				error: function(xhr) {
					$('#content').html('Mã không tồn tại hoặc đã hết hiệu lực');
					$('#iconDisCode').removeClass('fa fa-spinner fa-spin').addClass('icmn-search');
				}
			});
		}
	});
});

function viewBlog(url) {
	window.open(url, '_blank');
}
</script>

<div id="modalDisCode" class="modal modal-size-small fade modal-review" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<div class="row">
					<div class="form-group col-xs-8">
						<div class="form-input-icon">
							<i id="iconDisCode" class="icmn-search"></i>
							<input id="searchDisCode" type="text" maxlength="20" class="form-control" name="name" placeholder="Nhập mã khuyến mãi của bạn">
							<input id="oldDisCode" type="hidden" value="" />
						</div>
					</div>
				</div>
			</div>
			<div class="modal-body padding-bottom-30" style="min-height: 150px; background-color: #f2f2f2">
				<div id="content" class="discount-code-wrapper-content">Mã không tồn tại hoặc đã hết hiệu lực</div>
				<div id="disCodes" class="row">
				</div>
			</div>
		</div>
	</div>
</div>
