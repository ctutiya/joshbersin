<?php

$navigation = get_field('navigation', 'options') ?: null;
$footer = get_field('footer', 'options') ?: null;

get_header( $navigation );
?>

<section class="header-top-padding-normal header-bottom-padding-normal bg-secondary">
  <div class="container align-center width-950 p-t-10 p-b-10">
    <p class="type-bold font-12 letter-spacing caps color-primary m-b-30">News</p>
    <h1 class="medium m-b-30">The Josh Bersin Academy Launches Unique Program to Help HR Professionals Accelerate
Transition to Remote Work</h1>
    <div class="row gutter-5 align-items-center justify-content-center">
      <img class="col-auto" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/icon/clock.svg" alt="Publish date">
      <span class="col-auto">May 13, 2020.</span>
    </div>
  </div>
</section>

<section class="block-top-padding-large block-bottom-padding-large">
  <?php if ( have_posts() ): ?>
    <?php while ( have_posts() ): ?>
      <?php the_post(); ?>

      <div class="container width-1050">
        <div class="row gutter-30">
          <div class="flex-72">
            <article id="post-article">
              <?php the_content(); ?>
            </article>
          </div>
          <div class="col">

          </div>
        </div>
      </div>

    <?php endwhile; ?>
  <?php endif; ?>
</section>

<?php get_footer( $footer ); ?>
