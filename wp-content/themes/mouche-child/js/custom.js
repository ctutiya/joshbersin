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

  // My account registration placeholder Fix
  $('#afreg_additional_127').attr('placeholder', 'How can we help you? ');

  // Replace my account registration fields
  $('#afreg_additional_117').attr('name', 'first_name');
  $('#afreg_additional_118').attr('name', 'last_name');
  $('#afreg_additional_121').attr('name', 'email');
  $('#afreg_additional_128').attr('name', 'password');
});
