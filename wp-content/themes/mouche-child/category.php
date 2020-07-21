<?php
/**
* Template Name: Home
*/

$navigation = get_field('navigation', 'options') ?: null;
$footer = get_field('footer', 'options') ?: null;

get_header( $navigation );

$exclude_posts = array();
$big = 999999999;

$category = get_queried_object();

?>

<section class="header-top-padding-normal header-bottom-padding-normal bg-secondary">
  <div class="container width-950 align-center p-t-15 p-b-15">
    <h1 class="large m-b-15"><?php echo $category->name; ?></h1>
    <p class="m-b-25"><?php echo $category->description; ?></p>
    <a href="#" onclick="history.back();">
      <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/arrow-primary.svg" alt="Go back">
    </a>
  </div>
</section>

<section class="m-t-50">
  <div class="container">
    <div class="row gutter-30 margin-responsive">
      <div class="flex-73">
        <div>

          <?php

          $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;

          $args = array(
            'post__not_in' => $exclude_posts,
            'post_type' => 'post',
            'post_status' => array(
              'publish'
            ),
            'posts_per_page' => 6,
            'order' => 'DESC',
            'orderby' => 'date',
            'paged' => $paged,
          );

          $the_query = new WP_Query( $args );

          if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $category = get_the_category();

                ?>

                <div class="row gutter-25 m-l-25 m-r-25 latest-articles-item">
                  <div class="flex-41">
                    <a href="<?php the_permalink(); ?>" class="full-height full-width block">
                      <img class="full-height full-width image-cover" src="<?php echo get_the_post_thumbnail_url( $post->ID, 'medium' ); ?>" alt="<?php the_title() ?>">
                    </a>
                  </div>
                  <div class="col">
                    <a href="<?php echo $category[0]->slug; ?>" class="type-bold font-12 letter-spacing caps color-primary m-b-15 block"><?php echo $category[0]->cat_name; ?></p>
                    <a href="<?php the_permalink(); ?>" class="color-dark">
                      <h3 class="medium m-b-10"><?php the_title(); ?></h3>
                    </a>
                    <div class="subtitle font-14 m-b-20"><?php the_excerpt(); ?></div>
                    <div class="row gutter-10">
                      <div class="col-auto">
                        <p class="text-white subtitle font-12"><?php the_time('M j'); ?></p>
                      </div>
                      <div class="row col-auto align-items-center">
                        <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/icon/comment.svg" alt="Comments">
                        <p class="text-white subtitle font-12 p-l-5">342</p>
                      </div>
                      <div class="row col-auto align-items-center">
                        <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/icon/heart.svg" alt="Likes">
                        <p class="text-white subtitle font-12 p-l-5">830</p>
                      </div>
                    </div>
                  </div>
                </div>

                <?php
            }
          }

          ?>

        </div>
        <div class="pagination block-top-padding-large block-bottom-padding-large">
          <div class="nav-links">

          <?php

            echo paginate_links( array(
                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format' => '?paged=%#%',
                'prev_next' => true,
                'current' => max( 1, get_query_var('page') ),
                'total' =>  $the_query->max_num_pages,
                'show_all' => false,
                'prev_text' => '<div class="row align-items-center"><img src="' . get_bloginfo('stylesheet_directory') . '/images/icon/arrow.svg" alt="Previous post"><p class="font-14 type-bold m-l-5">Prev</p></div>',
                'next_text' => '<div class="row align-items-center"><p class="font-14 type-bold m-r-5">Next</p><img src="' . get_bloginfo('stylesheet_directory') . '/images/icon/arrow.svg" class="rotate-180" alt="Next post"></div>',
            ) );

            ?>

          </div>
        </div>
      </div>
      <div class="col">
        <div class="m-t-40">
          <div class="widget">
            <div class="align-center">
              <div class="p-25">
                <p class="type-bold color-tertiary m-b-30 font-14">Join the only global professional development academy for HR</p>
                <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/josh-bersin-academy.png" alt="Josh Bersin Academy">
              </div>
              <a href="#" class="p-t-10 p-b-10 p-l-25 p-r-25 border-top block type-bold caps font-14 color-dark">Learn More</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php wp_reset_postdata(); ?>
<?php get_footer( $footer ); ?>
