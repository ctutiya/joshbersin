$(document).ready(function() {
  var mY = 0;

  $('.wrapper svg').mousemove(function(e){
    var x = e.clientX;
    var y = e.clientY;
    var height = $(window).height();

    y = y/height*360;

    var deg = Math.min(Math.max(y, 300), 360);

    if (e.pageY < mY) {
      deg = -deg;
    }

    mY = e.pageY;

    $(this).css('transform', 'rotate3d(' + x + ',' + y + ',1, ' + deg + 'deg)');
  });

  $('.wrapper').addClass('active');

  $('.wrapper g[data-delay]').each(function(i, el) {
    function intervalFunction() {
      var delay = ((Number($(el).attr('data-delay')) + 1) * Math.random() * 1000);
      var duration = (3000 * (Math.floor(Math.random() * 3) + 1));

      $(el).removeClass('active').find('path').css('animation', 'none');
      $(el).addClass('active').find('path').css('animation', duration + 'ms dash ' + delay + 'ms linear infinite');

      setTimeout(intervalFunction, delay )
    }

    intervalFunction();
  });
});
