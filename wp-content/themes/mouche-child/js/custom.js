$ = jQuery;

$(document).ready(function(){
  // Scroll to top
  $('#scroll-top').on('click', function(event) {
    event.preventDefault();

    $('body, html').animate({
      scrollTop: 0
    }, 1000);
  });
});
