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
});
