$ = jQuery;

jQuery(document).ready(function($) {
  $('.events-testimonials').owlCarousel({
    items: 1,
    loop: true,
    dots: true,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: true
  });

  var webinars = $('.webinars-carousel');

  webinars.owlCarousel({
    items: 1,
    dots: false,
  });

  $('#webinars-prev').on('click', function(event) {
      event.preventDefault();

      webinars.trigger('prev.owl.carousel');
  });

  $('#webinars-next').on('click', function(event) {
      event.preventDefault();

      webinars.trigger('next.owl.carousel');
  });
});
