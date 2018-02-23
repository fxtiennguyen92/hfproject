$(document).ready(function() {

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
      headerTag:'h3',
      bodyTag: '',
      enableKeyNavigation: false,
      enablePagination: false,
      autoFocus: false,
      startIndex: idx,
    })
  });
});
