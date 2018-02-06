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
  });

});
