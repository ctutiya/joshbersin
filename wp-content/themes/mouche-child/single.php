<?php

$navigation = get_field('navigation', 'options') ?: null;
$footer = get_field('footer', 'options') ?: null;

get_header( $navigation );
?>

<section>
  <?php if ( have_posts() ): ?>
    <?php while ( have_posts() ): ?>
      <?php the_post(); ?>

    <?php endwhile; ?>
  <?php endif; ?>
</section>

<?php get_footer( $footer ); ?>
