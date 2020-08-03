$ = jQuery;

jQuery(document).ready(function($) {
  // Sticky share buttons
  $('#share-buttons').stick_in_parent({
    offset_top: 140,
  });

  // Like button
  $('.pp_like').click(function(e){
    e.preventDefault();

    var postid = jQuery(this).data('id');
    var data = {
      action: 'my_action',
      security : MyAjax.security,
      postid: postid
    };

    $.post(MyAjax.ajaxurl, data, function(res) {
      var result = $.parseJSON( res );
      var likes = "";

      likes = result.likecount;
      $('.post_like span').text(likes);

      if(result.like == 1){
        $('.pp_like').addClass('liked');
      }

      if(result.dislike == 1){
        $('.pp_like').removeClass('liked');
      }
    });
  });
});
