
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
        <a href="#">
          <img class="m-b-40" src="<?php echo $logo; ?>" alt="<?php echo bloginfo('name'); ?>">
        </a>
        <?php

        if ( have_rows( 'social_networks', 'options' ) ):
          ?>

          <div class="row gutter-30 social-icons-row">

            <?php
            while ( have_rows( 'social_networks', 'options' ) ) {
              the_row();

              $name = get_sub_field('name');
              $url = get_sub_field('url');
              $icon = 'icon-' . $name;

              ?>

              <div class="col-auto">
                <a href="<?php echo $url; ?>">
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
  </footer>
</body>
</html>
