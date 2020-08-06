
<?php wp_footer(); ?>

<?php

  $footer_theme = get_field('footer_theme', 'options');

  if ( $footer_theme == 'dark' ) {
    $logo = get_field('white_logo', 'options');
  } else {
    $logo = get_field('black_logo', 'options');
  }

?>

  <footer class="footer_7">
    <div class="container p-t-60 p-b-60">
      <div class="align-center">
        <a href="<?php echo home_url(); ?>">
          <img class="m-b-40" src="<?php echo $logo; ?>" alt="<?php echo bloginfo('name'); ?>">
        </a>
        <?php

        wp_nav_menu(array(
					'theme_location' => 'Footer',
					'menu' => 'footer',
					'menu_class' => 'row gutter-30 m-b-20',
				));

        ?>
        <?php

        if ( have_rows( 'social_networks', 'options' ) ):
          ?>

          <div class="row gutter-30 social-icons-row justify-content-center">

            <?php
            while ( have_rows( 'social_networks', 'options' ) ) {
              the_row();

              $name = get_sub_field('name');
              $url = get_sub_field('url');
              $icon = 'icon-' . $name;

              ?>

              <div class="col-auto">
                <a href="<?php echo $url; ?>" target="_blank">
                  <i class="<?php echo $icon; ?>"></i>
                </a>
              </div>

              <?php
            }

          ?>

          </div>

          <?php
          endif;

          ?>
      </div>
    </div>
    <div id="footer-copyright">
      <div class="container-fluid">
        <div class="row justify-content-between align-items-center">
          <div class="col">

          </div>
          <div class="col-auto">
            <p class="type-bold font-14 align-center">© <?php echo Date('Y'); ?> Copyright Josh Bersin. All rights reserved. Designed & Developed by <a href="https://onpurposeprojects.com/" target="_blank" class="text-white">On Purpose Projects</a></p>
          </div>
          <div class="col align-right">
            <a href="#" id="scroll-top" class="row no-gutters align-items-center justify-content-end">
              <span class="m-r-15 type-bold font-14 text-white">BACK TO TOP</span>
              <svg height="10" viewBox="0 0 10 10" width="10" xmlns="http://www.w3.org/2000/svg">
                <path d="m6.84740125 5-3.70756757-3.68895248c-.18644491-.18553834-.18644491-.48635543 0-.67189376.1864449-.18553834.48873181-.18553834.67517671 0l4.04515593 4.02489936c.18644491.18553834.18644491.48635542 0 .67189376l-4.04515593 4.02489937c-.1864449.18553833-.48873181.18553833-.67517671 0-.18644491-.18553834-.18644491-.48635543 0-.67189377z" fill="#fff" fill-rule="evenodd" transform="matrix(0 -1 1 0 0 10)"/>
              </svg>
            </a>
          </div>
        </div>
      </div>
    </div>
  </footer>
</body>
</html>
