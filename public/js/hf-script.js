$(document).ready(function () {
  $(window).on('load resize', function () {
    $('.hero').css('height', $(window).height() - 80);
    $('.fullHeight').css('height', $(window).height());
  });

  $('.backToHome').on('click', function () {
    
  })

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

  //show less content order
  $("button[toggle=toggleContent]").on('click', function () {
    $(this).parent().parent().find('div[toggle=showLessContent]').toggleClass('show');
  });

});

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

  var infowindowContent = document.getElementById('infowindow-content');
  infowindowContent.children['place-address'].textContent = address;

  var infowindow = new google.maps.InfoWindow();
  infowindow.setContent(infowindowContent);
  infowindow.open(map, marker);
}
