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
      allowEmpty: null,
    });
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
  $("button[toggle=toggleContent]").on('click', function () {
    $(this).parent().parent().find('div[toggle=showLessContent]').toggleClass('show');
  });
});

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