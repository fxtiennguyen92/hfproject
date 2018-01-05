$('document').ready(function () {
	
	
	$('.rating').each(function() {
		$(this).barrating({
			theme: 'fontawesome-stars-o',
			readonly: true,
			initialRating: $(this).data('current-rating'),
			allowEmpty: null,
		});
	});
});