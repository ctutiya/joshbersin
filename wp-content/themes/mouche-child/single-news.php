<?php

$navigation = get_field('navigation', 'options') ?: null;
$footer = get_field('footer', 'options') ?: null;

get_header( $navigation );

$as_published_in = get_field( 'as_published_in' );
?>

<section class="header-top-padding-normal header-bottom-padding-normal bg-secondary">
  <div class="container align-center width-950">
    <p class="type-bold font-12 letter-spacing caps color-primary m-b-30">
      <a href="<?php echo home_url('news'); ?>">News</a>
    </p>
    <h1 class="medium m-b-25"><?php the_title(); ?></h1>
    <div class="row gutter-5 align-items-center justify-content-center">
      <img class="col-auto" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/icon/clock.svg" alt="Publish date">
      <span class="col-auto color-tertiary font-12"><?php the_time('M j, Y'); ?>.</span>
    </div>
  </div>
</section>

<section class="block-top-padding-large block-bottom-padding-large">
  <?php if ( have_posts() ): ?>
    <?php while ( have_posts() ): ?>
      <?php the_post(); ?>

      <div class="container">
        <div class="row gutter-30">
          <div class="flex-9"></div>
          <div class="flex-66">
            <?php if ( $as_published_in ): ?>
              <div class="type-bold font-12 caps m-b-50 row align-items-center">
                <span class="m-r-5">as published in </span> <span><?php echo $as_published_in; ?></span>
              </div>
            <?php endif; ?>
            <article id="post-article">
              <?php the_content(); ?>
            </article>
          </div>
          <div class="col">
            <?php get_search_form(); ?>
            <div class="m-t-40 block-bottom-padding-large">
              <?php dynamic_sidebar('inner'); ?>
            </div>
          </div>
        </div>
      </div>

    <?php endwhile; ?>
  <?php endif; ?>
</section>

<?php get_footer( $footer ); ?>
