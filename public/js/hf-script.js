$(document).ready(function () {
	$(window).on('load resize', function () {
		$('.hero').css('height', $(window).height() - 80);
		$('.fullHeight').css('height', $(window).height());
	});
	$('.hiw-slider, .testinomial-slider').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		dots: true,
		autoplay: true,
		autoplaySpeed: 3000,
		adaptiveHeight: true
	});
	$('.rating').each(function () {
		$(this).barrating({
			theme: 'fontawesome-stars-o',
			readonly: true,
			initialRating: $(this).data('current-rating'),
			allowEmpty: true,
		});
	});
	$('.rating-review').barrating('show', {
		theme: 'fontawesome-stars-o',
		initialRating: 4,
		allowEmpty: null,
		onSelect: function(value, text, event) {
			if (value <= 3) {
				$('.review-type').show();
			} else {
				$('.review-type').hide();
			}
		}
	});
	$('.cui-wizard-order').each(function () {
		var idx = $(this).attr('start-step');
		$(this).steps({
			headerTag: 'h3',
			bodyTag: '',
			enableKeyNavigation: false,
			enablePagination: false,
			autoFocus: false,
			startIndex: idx,
		})
	});

	// show less content order
	$('button[toggle=toggleContent]').on('click', function () {
		$(this).parent().parent().find('div[toggle=showLessContent]').toggleClass('show');
	});

	// image error
	$('img').each(function() {
		$(this).on('error', function() {
			$(this).attr('src', "https://cdn.handfree.co/img/no-image.png");
		});
	});

});

function coverMoneyToString(money) {
	var cover = function(){var t=["không","một","hai","ba","bốn","năm","sáu","bảy","tám","chín"],r=function(r,n){var o="",a=Math.floor(r/10),e=r%10;return a>1?(o=" "+t[a]+" mươi",1==e&&(o+=" mốt")):1==a?(o=" mười",1==e&&(o+=" một")):n&&e>0&&(o=" lẻ"),5==e&&a>=1?o+=" lăm":4==e&&a>=1?o+=" tư":(e>1||1==e&&0==a)&&(o+=" "+t[e]),o},n=function(n,o){var a="",e=Math.floor(n/100),n=n%100;return o||e>0?(a=" "+t[e]+" trăm",a+=r(n,!0)):a=r(n,!1),a},o=function(t,r){var o="",a=Math.floor(t/1e6),t=t%1e6;a>0&&(o=n(a,r)+" triệu",r=!0);var e=Math.floor(t/1e3),t=t%1e3;return e>0&&(o+=n(e,r)+" ngàn",r=!0),t>0&&(o+=n(t,r)),o};return{doc:function(r){if(0==r)return t[0];var n="",a="";do ty=r%1e9,r=Math.floor(r/1e9),n=r>0?o(ty,!0)+a+n:o(ty,!1)+a+n,a=" tỷ";while(r>0);return n.trim()}}}();
	return cover.doc(money)
}

function loadingBtnSubmit(id) {
	$('#' + id).html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý');
	$('#' + id).prop('disabled', true);
}
function resetBtnSubmit(id, text) {
	$('#' + id).html(text);
	$('#' + id).prop('disabled', false);
}

function initOrderMap(lat, lng, address) {
	var location = new google.maps.LatLng(lat, lng);
	var map = new google.maps.Map(document.getElementById('map'), {
		center: location,
		zoom: 17,
		disableDefaultUI: true
	});
	var marker = new google.maps.Marker({
		map: map,
	});
	marker.setPosition(location);
	marker.setTitle(address);
	marker.setVisible(true);

	var infowindow = new google.maps.InfoWindow();
	infowindow.open(map);
};

function changeToUrl() {
	var title, url;

	title = document.getElementById('title').value;

	url = title.toLowerCase();

	url = url.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
	url = url.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
	url = url.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
	url = url.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
	url = url.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
	url = url.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
	url = url.replace(/đ/gi, 'd');
	url = url.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
	url = url.replace(/ /gi, "-");
	url = url.replace(/\-\-\-\-\-/gi, '-');
	url = url.replace(/\-\-\-\-/gi, '-');
	url = url.replace(/\-\-\-/gi, '-');
	url = url.replace(/\-\-/gi, '-');
	url = '@' + url + '@';
	url = url.replace(/\@\-|\-\@|\@/gi, '');

	document.getElementById('urlName').value = url;
}
