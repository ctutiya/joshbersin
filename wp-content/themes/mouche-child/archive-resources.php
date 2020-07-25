<?php
$navigation = get_field('navigation', 'options') ?: null;
$footer = get_field('footer', 'options') ?: null;

get_header( $navigation );
?>

<section class="header-top-padding-normal header-bottom-padding-normal bg-secondary">
  <div class="container width-950 align-center p-t-15 p-b-15">
    <h1 class="large m-b-15">Resources</h1>
    <p class="m-b-25">Here you’ll find special reports, videos, podcasts, and other information produced by Josh Bersin.</p>
    <a href="#" onclick="history.back();">
      <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/arrow-primary.svg" alt="Go back">
    </a>
  </div>
</section>

<?php

$args = array(
  'tag_id' => 45,
  'post_status' => array(
    'publish'
  ),
  'posts_per_page' => 4,
  'order' => 'ASC',
  'orderby' => 'date',
  'post_type' => 'resources',
);

$featured_posts = new WP_Query( $args );

array_push( $exclude_posts, wp_list_pluck( $featured_posts->posts, 'ID' ) );

$exclude_posts = array_flatten( $exclude_posts );

?>

<section class="block-top-padding-large block-bottom-padding-large">
  <div class="container">
    <?php

    if ( $featured_posts->have_posts() ) {
      ?>

      <p class="type-bold font-14 letter-spacing caps p-b-20 border-bottom m-b-20">featured RESOURCES</p>
      <div class="row gutter-30 margin-responsive" id="featured-resources-row">

      <?php
      while ( $featured_posts->have_posts() ) {
        $featured_posts->the_post();

        ?>

        <div class="col">
          <div class="featured-resources-item">
            <a href="<?php the_permalink(); ?>">
              <img class="full-width height-160 image-cover m-b-30" src="<?php echo get_the_post_thumbnail_url( $post->ID, 'medium' ); ?>" alt="<?php the_title(); ?>">
            </a>
            <div class="p-l-20 p-r-20 p-b-30">
              <a href="<?php the_permalink() ?>" class="color-tertiary">
                <h2 class="small m-b-15"><?php the_title(); ?></h2>
              </a>
              <a href="<?php the_permalink(); ?>" class="btn small primary full-width align-center row no-gutters align-items-center justify-content-center"><span>learn more</span> <i class="m-l-5 icon-arrow_right_alt"></i></a>
            </div>
          </div>
        </div>

        <?php
      }
      ?>

      </div>

      <?php
    }

    wp_reset_postdata();

    ?>

  </div>
</section>

<?php

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

$args = array(
  'post__not_in' => $exclude_posts,
  'post_type' => 'resources',
  'post_status' => array(
    'publish'
  ),
  'posts_per_page' => 9,
  'order' => 'DESC',
  'orderby' => 'date',
  'paged' => $paged,
);

$the_query = new WP_Query( $args );

if ( $the_query->have_posts() ) { ?>

<section class="block-bottom-padding-normal">
  <div class="container">
    <p class="type-bold font-14 letter-spacing caps p-b-20 border-bottom m-b-20">RESOURCES</p>
    <div class="row gutter-30 margin-responsive justify-content-between" id="resources-row">
      <?php

      while ( $the_query->have_posts() ) {
          $the_query->the_post();

          ?>

          <div class="col-md-4">
            <div class="border row flex-column">
              <div class="row gutter-15">
                <div class="col-auto">
                  <a href="<?php the_permalink(); ?>" class="full-height block">
                    <img class="image-cover full-height full-width" src="<?php echo get_the_post_thumbnail_url( $post->ID, 'medium' ); ?>" alt="<?php the_title(); ?>">
                  </a>
                </div>
                <div class="col">
                  <div class="p-r-15 p-t-15 p-b-15 full-height relative">
                    <a href="<?php the_permalink(); ?>" class="color-tertiary">
                      <h3 class="medium m-b-10"><?php the_title(); ?></h3>
                    </a>
                    <a href="<?php the_permalink(); ?>" class="btn small primary resources-button">Learn More <i class="m-l-5 icon-arrow_right_alt"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>

        <?php } ?>
    </div>
  </div>
  <div class="pagination block-top-padding-normal block-bottom-padding-large">
    <div class="nav-links">

    <?php
      $big = 999999999;

      echo paginate_links( array(
          'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
          'format' => '?paged=%#%',
          'prev_next' => true,
          'current' => max( 1, get_query_var('paged') ),
          'total' =>  $the_query->max_num_pages,
          'show_all' => false,
          'prev_text' => '<div class="row align-items-center"><img src="' . get_bloginfo('stylesheet_directory') . '/images/icon/arrow.svg" alt="Previous post"><p class="font-14 type-bold m-l-5">Prev</p></div>',
          'next_text' => '<div class="row align-items-center"><p class="font-14 type-bold m-r-5">Next</p><img src="' . get_bloginfo('stylesheet_directory') . '/images/icon/arrow.svg" class="rotate-180" alt="Next post"></div>',
      ) );

      ?>

    </div>
  </div>
</section>

<?php } ?>

<?php get_footer( $footer ); ?>
