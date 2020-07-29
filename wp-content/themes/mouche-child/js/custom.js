$ = jQuery;

function customCarousel(carousel, options) {
  var $element = $('.' + carousel + '-carousel');

  $('#' + carousel + '-prev').addClass('disabled');

  $element.owlCarousel({
    items: options.items,
    dots: false,
    slideBy: options.items,
  });

  $('#' + carousel + '-prev').on('click', function(event) {
    event.preventDefault();

    $element.trigger('prev.owl.carousel');

    var isFirst = !!$element.find('.owl-item').first().hasClass('active');

    if (isFirst) {
      $(this).addClass('disabled');
    } else {
      $(this).removeClass('disabled');
      $(this).next().removeClass('disabled');
    }
  });

  $('#' + carousel + '-next').on('click', function(event) {
    event.preventDefault();

    $element.trigger('next.owl.carousel');

    var isLast = !!$element.find('.owl-item').last().hasClass('active');

    if (isLast) {
      $(this).addClass('disabled');
    } else {
      $(this).removeClass('disabled');
      $(this).prev().removeClass('disabled');
    }
  });
}

function readURL(input, imageSelector) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $(imageSelector).attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

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

  // Update profile picture image on my account dashboard
  $('#profile-picture-url').on('change', function() {
    readURL(this, '#profile-picture');
  });

  // My account edit popup
  $('.close-account-edit').on('click', function(event) {
    event.preventDefault();

    $('.account-edit-overlay').removeClass('active');
  });

  $('.open-account-edit-popup').on('click', function(event) {
      event.preventDefault();

      $('.account-edit-overlay').addClass('active');

      var popupId = $(this).attr('id');

      $('[data-edit]').hide();
      $('[data-edit="' + popupId + '"]').show();
  });

  // User registration password match
  // $('form.register').on('submit', function(event) {
  //     event.preventDefault();
  //
  //     if ($('input[name="password"]').val() === $('input[name="afreg_additional_129"]').val()) {
  //       alert('Passwords don\'t match');
  //     } else {
  //       $('form.register')[0].submit();
  //     }
  // });

  // Account details password match
  $('form.change-account-details').on('submit', function(event) {
      event.preventDefault();

      if (($(this).find('input[name="password"]').val() !== $(this).find('input[name="confirm-password"]').val()) && $(this).find('input[name="password"]').val() !== '') {
        alert('Passwords don\'t match');
      } else {
        $('form.change-account-details')[0].submit();
      }
  });

  // Featured articles pagination
  customCarousel('featured', { items: 4 });

  // Edit my account - remove buttons
  $('[data-clear]').on('click', function(event) {
    event.preventDefault();

    var form = $(this).attr('data-clear');
    $('[data-edit="' + form + '"] input').val('');
    $('form.change-account-details').submit();
  });

});
