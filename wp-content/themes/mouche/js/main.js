jQuery(document).ready(function($) {
  // mobile menu
  $('.open-mobile-menu').on('click', function(e) {
    e.preventDefault();
    $('.mobile-menu').fadeIn();
  });

  $('.close-mobile-menu').on('click', function(e) {
    e.preventDefault();
    $('.mobile-menu').fadeOut();
  });

  $('footer .menu-item-has-children, .mobile-menu .menu-item-has-children').on('click', function(e) {
    if ($(window).width() < 991) {
      e.preventDefault();
      $(this).find('.sub-menu').slideToggle().parent().toggleClass('active');
    }
  });

  // tabs
  $('.tab').on('click', function(event) {
    event.preventDefault();

    var $currentTab = $(this);
    var id = $currentTab.attr('data-id');
    // var $select = $('select[name="home-page-tabs"]');
    // $select.val(id).trigger('change');

    $('.tab').removeClass('active');
    $currentTab.addClass('active');

    $currentTab.parent().parent().parent().find('.tab-content').hide();
    $('#' + id).fadeIn(500);

  });

  // sub menu
  $('.main-menu .menu-item-has-children a[href^="#"]').on('click', function(event) {
    event.preventDefault();
  });

  $('#menu-footer .menu-item-has-children a[href^="#"]').on('click', function(event) {
    event.preventDefault();
  });

  // Like button
  $('.pp_like').click(function(e){
    e.preventDefault();

    var postid=jQuery(this).data('id');
    var data = {
      action: 'my_action',
      security : MyAjax.security,
      postid: postid
    };

    $.post(MyAjax.ajaxurl, data, function(res) {
      var result = $.parseJSON( res );
      var likes = "";

      likes = result.likecount + " like";
      $('.pp_like span').text(likes);

      if(result.like == 1){
        $('.pp_like').addClass('liked');
      }

      if(result.dislike == 1){
        $('.pp_like').removeClass('liked');
      }
    });
  });

  // Dropdown inputs
  $('select').select2({
    minimumResultsForSearch: -1
  });

  // Accordions
  $accordions = $('.accordion-item');
  $accordions.on('click', function() {
    $(this).toggleClass('active');
  });

});

jQuery(window).load(function() {
  // Loader
  jQuery('#loader').hide();

  // Animations
  AOS.init({
    duration: 800,
  });
});
