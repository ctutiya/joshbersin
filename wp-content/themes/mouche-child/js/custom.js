$ = jQuery;

$(document).ready(function(){
  // Scroll to top
  $('#scroll-top').on('click', function(event) {
    event.preventDefault();

    $('body, html').animate({
      scrollTop: 0
    }, 1000);
  });

  // Registration popup
  $('.close-registration-popup').on('click', function(event) {
    event.preventDefault();

    $('.registration-overlay').fadeOut();
  });
});
