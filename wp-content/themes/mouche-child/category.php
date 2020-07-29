<?php

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
    <p class="m-b-25 color-tertiary"><?php echo $category->description; ?></p>
    <a href="#" onclick="history.back();">
      <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/arrow-primary.svg" alt="Go back">
    </a>
  </div>
</section>

<section class="block-top-padding-large">
  <div class="container">
    <div class="row gutter-30 margin-responsive">
      <div class="flex-75">
        <div>

          <?php

          $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

          $args = array(
            'post__not_in' => $exclude_posts,
            'post_type' => 'post',
            'post_status' => array(
              'publish'
            ),
            'posts_per_page' => 6,
            'order' => 'DESC',
            'orderby' => 'date',
            'category_name' => $category->name,
            'paged' => $paged,
          );

          $the_query = new WP_Query( $args );

          if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) {
                $the_query->the_post();

                global $wpdb;
                global $post;

                $l=0;
                $postid=get_the_id();
                $clientip=get_client_ip();
                $row1 = $wpdb->get_results( "SELECT id FROM $wpdb->post_like_table WHERE postid = '$postid' AND clientip = '$clientip'");

                if( !empty( $row1 ) ){
                  $l=1;
                }

                $totalrow1 = $wpdb->get_results( "SELECT id FROM $wpdb->post_like_table WHERE postid = '$postid'");
                $total_like1 = $wpdb->num_rows;

                ?>


                <div class="row gutter-25 m-l-25 m-r-25 latest-articles-item">
                  <div class="flex-44">
                    <a href="<?php the_permalink(); ?>" class="full-height full-width block">
                      <img class="full-height full-width image-cover" src="<?php echo get_the_post_thumbnail_url( $post->ID, 'medium' ); ?>" alt="<?php the_title() ?>">
                    </a>
                  </div>
                  <div class="col">
                    <a href="<?php echo home_url('category') . '/' . $category->slug . '/'; ?>" class="type-bold font-12 letter-spacing caps color-primary m-b-15 block"><?php echo $category->name; ?></p>
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
                        <p class="text-white subtitle font-12 p-l-5"><?php echo get_comments_number( get_the_ID() ); ?></p>
                      </div>
                      <div class="row col-auto align-items-center">
                        <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/icon/heart.svg" alt="Likes">
                        <p class="text-white subtitle font-12 p-l-5">
                          <?php echo $total_like1; ?>
                        </p>
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
                'current' => max( 1, get_query_var('paged') ),
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
        <?php get_search_form(); ?>
        <div class="m-t-50 block-bottom-padding-large">
          <?php dynamic_sidebar('inner'); ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php wp_reset_postdata(); ?>
<?php get_footer( $footer ); ?>
