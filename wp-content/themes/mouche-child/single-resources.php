<?php

$navigation = get_field('navigation', 'options') ?: null;
$footer = get_field('footer', 'options') ?: null;

get_header( $navigation );
?>

<section class="header-top-padding-normal header-bottom-padding-normal bg-secondary">
  <div class="container align-center width-850 p-t-10 p-b-10">
    <p class="type-bold font-12 letter-spacing caps color-primary m-b-30">resources</p>
    <h1 class="large m-b-25">Why HR Technology Matters Now More Than Ever</h1>
    <a href="#" onclick="history.back();">
      <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/arrow-primary.svg" alt="Go back">
    </a>
  </div>
</section>

<section class="block-top-padding-large block-bottom-padding-large">
  <div class="container">

  <?php if ( have_posts() ): ?>
    <?php while ( have_posts() ): ?>
      <?php the_post(); ?>

      <div class="row justify-content-between no-gutters align-items-center">
        <div class="flex-45">
          <img src="<?php echo get_the_post_thumbnail_url( $post->ID, 'large' ); ?>" alt="Download resource">
        </div>
        <div class="flex-45">
          <div class="m-b-30">
            <?php the_content(); ?>
          </div>
          <a href="#" class="btn medium primary">DOWNLOAD RESOURCE <i class="icon-download m-l-10"></i></a>
        </div>
      </div>

    <?php endwhile; ?>
  <?php endif; ?>

  </div>

</section>

<?php get_footer( $footer ); ?>
