<?php
/**
* Template Name: About
*/

$navigation = get_field('navigation', 'options') ?: null;
$footer = get_field('footer', 'options') ?: null;

get_header( $navigation );
?>

<section class="header-top-padding-normal header-bottom-padding-normal bg-secondary">
  <div class="container width-950 align-center">
    <h1 class="large m-b-15">Josh Bersin</h1>
    <p class="m-b-25">Global Industry Analyst and Dean, Josh Bersin Academy</p>
    <a href="#" onclick="history.back();">
      <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/arrow-primary.svg" alt="Go back">
    </a>
  </div>
</section>

<section class="block-top-padding-large block-bottom-padding-large">
  <div class="container">
    <article id="about-content" class="block-bottom-padding-large border-bottom">
      <img class="m-r-30 m-b-30 float-left" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/about-josh-bersin.jpg" alt="About Josh Bersin">
      <?php if ( have_posts() ): ?>
        <?php while ( have_posts() ): ?>
          <?php the_post(); ?>
          <?php the_content(); ?>
        <?php endwhile; ?>
      <?php endif; ?>
    </article>
    <div class="block-top-padding-large row align-items-center">
      <span class="col-auto p-r-45 font-12 color-primary letter-spacing type-bold caps">featured in</span>
      <div class="col row justify-content-between align-items-center">
        <div class="col-auto">
          <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/harvard-business-review.png" alt="Harvard Business Review">
        </div>
        <div class="col-auto">
          <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/forbes.png" alt="Forbes">
        </div>
        <div class="col-auto">
          <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/clo.png" alt="Clo">
        </div>
        <div class="col-auto">
          <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/fast-company.png" alt="Fast Company">
        </div>
        <div class="col-auto">
          <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/wsj.png" alt="Wsj">
        </div>
        <div class="col-auto">
          <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/human-resource-executive.png" alt="Human Resource Executive">
        </div>
      </div>
    </div>
  </div>
</section>

<?php get_footer( $footer ); ?>
