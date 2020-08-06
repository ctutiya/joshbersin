<?php

$navigation = get_field('navigation', 'options') ?: null;
$footer = get_field('footer', 'options') ?: null;

get_header( $navigation );
?>

<?php if ( have_posts() ): ?>
  <?php while ( have_posts() ): ?>
    <?php the_post(); ?>

    <section class="header-top-padding-normal header-bottom-padding-normal bg-secondary">
      <div class="container align-center width-850 p-t-10 p-b-10">
        <p class="type-bold font-12 letter-spacing caps color-primary m-b-30">
          <a href="<?php echo home_url('resources'); ?>">resources</a>
        </p>
        <h1 class="large m-b-15"><?php the_title(); ?></h1>
        <a href="#" onclick="history.back();">
          <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/arrow-primary.svg" alt="Go back">
        </a>
      </div>
    </section>

    <section class="block-top-padding-large block-bottom-padding-large">
      <div class="container">
        <div class="row justify-content-between no-gutters align-items-center">
          <div class="row flex-column flex-45">
            <img class="full-width height-300 image-cover" src="<?php echo get_the_post_thumbnail_url( $post->ID, 'large' ); ?>" alt="Download resource">
          </div>
          <div class="flex-46">
            <div class="m-b-30 single-resource-content color-tertiary">
              <?php the_content(); ?>
            </div>
            <?php

            $resource = get_field('resource');

            if ( $resource ):

              if ( !(is_user_logged_in()) ):
                $redirect_url = get_permalink();
          			$redirect_url = urlencode( $redirect_url );
          			$resource = home_url('my-account') . '?redirect-url=' . $redirect_url . '&register';
              else:
                $resource = get_permalink( $resource['ID'] ) . '?attachment_id=' . $resource['ID'] . '&resource_id=' . $post->ID . '&download_file=1';
              endif;

              ?>
              <a href="<?php echo $resource; ?>" class="btn medium primary">DOWNLOAD RESOURCE <i class="icon-download m-l-10"></i></a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>

  <?php endwhile; ?>
<?php endif; ?>
<?php get_footer( $footer ); ?>
