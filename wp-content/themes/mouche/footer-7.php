
<?php wp_footer(); ?>

<?php

  $footer_theme = get_field('footer_theme', 'options');

  if ( $footer_theme == 'dark' ) {
    $logo = get_field('white_logo', 'options');
    $text_color = 'text-white';
  } else {
    $logo = get_field('black_logo', 'options');
    $text_color = '';
  }

  $footer_content = get_field( 'footer_content', 'options' );

?>

  <footer class="footer_7 p-t-30 p-b-30 relative">
    <div class="container width-980">
      <div class="text-white font-17"><?php echo $footer_content; ?></div>
      <a href="#" class="absolute" id="scroll-top">
        <svg height="15" viewBox="0 0 27 15" width="27" xmlns="http://www.w3.org/2000/svg">
          <path d="m14.5 13-12.23680104 12.5-1.76319896-1.7996588 10.5522886-10.7287453-10.52435162-10.70034126 1.73526198-1.77125464z" fill="#fff" fill-rule="evenodd" transform="matrix(0 -1 -1 0 26.5 15)"/>
        </svg>
      </a>
    </div>
  </footer>
</body>
</html>
