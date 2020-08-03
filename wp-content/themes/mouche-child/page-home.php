<?php
/**
* Template Name: Home
*/

$navigation = get_field('navigation', 'options') ?: null;
$footer = get_field('footer', 'options') ?: null;

get_header( $navigation );

$exclude_posts = array();
$big = 999999999;

?>

<section class="block-top-padding-large block-bottom-padding-large">
  <div class="container align-center width-850">
    <h1 class="large m-b-35 type-black">Insights on Work, Talent and HR technology</h1>
    <form action="<?php echo home_url(); ?>" method="get" class="relative width-550 margin-auto">
      <div class="input-icon-right absolute">
        <input type="text" placeholder="Search Insights" name="s" id="search" value="<?php the_search_query(); ?>">
        <button class="absolute"></button>
        <i class="icon-search"></i>
      </div>
      <div class="absolute" id="search-category-wrapper">
        <select class="search-category" name="category">
          <?php

          $categories = get_categories();

          usort( $categories, function($a, $b) {
              return strcmp( $a->slug, $b->slug );
          });

          foreach ($categories as $key => $category) {
            ?>

              <option value="<?php echo $category->slug; ?>"><?php echo $category->name; ?></option>

            <?php
          }

          ?>
        </select>
      </div>
    </form>
  </div>
</section>
<section>
  <div class="container">
    <div class="row no-gutters">

      <?php

      $args = array(
          'post_type' => 'post',
          'post_status' => array(
            'publish'
          ),
          'posts_per_page' => 1,
          'order' => 'DESC',
          'orderby' => 'date',
      );

      $latest_article = new WP_Query( $args );

      if ( $latest_article->have_posts() ) {

        array_push( $exclude_posts, $latest_article->posts[0]->ID );

        while ( $latest_article->have_posts() ) {
            $latest_article->the_post();
            $category = get_the_category();
            ?>

            <div class="flex-77 bg-img row" id="latest-post" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post->ID, 'large' ); ?>)">
              <div class="row no-gutters flex-column justify-content-end align-items-start p-55">
                <a href="<?php echo home_url('category') . '/' . $category[0]->slug . '/'; ?>" class="caps text-white type-bold font-12 letter-spacing m-b-25">
                  <?php echo $category[0]->cat_name; ?>
                </a>
                <a href="<?php the_permalink(); ?>">
                  <h2 class="width-600 text-white m-b-45 large"><?php the_title(); ?></h2>
                </a>
                <a href="<?php the_permalink(); ?>" class="btn small primary">Read more<i class="m-l-5 icon-arrow_right_alt"></i></a>
              </div>
            </div>

            <?php
        }
      }

      wp_reset_postdata();

      ?>

      <div class="flex-23 bg-secondary">
        <div class="bg-primary p-t-20 p-r-25 p-b-20 p-l-25 caps text-white type-bold font-14 letter-spacing">
          trending
        </div>
        <div class="p-t-35 p-b-35 p-l-25 p-r-25">
          <ul class="trending-list">

            <?php

            $trending_posts = new WP_Query(
              array(
                'posts_per_page' => 5,
                'meta_key' => 'post_views_count',
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
                'post__not_in' => $exclude_posts,
                'post_type' => 'post',
              )
            );

            array_push( $exclude_posts, wp_list_pluck( $trending_posts->posts, 'ID' ) );

            $exclude_posts = array_flatten( $exclude_posts );

            if ( $trending_posts->have_posts() ) {

              while ( $trending_posts->have_posts() ) : $trending_posts->the_post();

              ?>

              <li class="row gutter-10">
                <div class="col-auto">
                  <a href="<?php the_permalink() ?>">
                    <img class="square-60 image-cover" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                  </a>
                </div>
                <div class="col">
                  <a href="<?php the_permalink() ?>" class="subtitle type-regular">
                    <p class="font-14"><?php the_title(); ?></p>
                  </a>
                  <p class="subtitle text-white font-12 m-t-5"><?php echo time_ago(); ?></p>
                </div>
              </li>

              <?php

              endwhile;
            }

            wp_reset_postdata();

            ?>

          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Featured articles -->

<?php

$args = array(
  'tag_id' => 45,
  'post_status' => array(
    'publish'
  ),
  'posts_per_page' => -1,
  'order' => 'ASC',
  'orderby' => 'date',
  'post__not_in' => $exclude_posts,
  'post_type' => 'post',
);

$featured_posts = new WP_Query( $args );

array_push( $exclude_posts, wp_list_pluck( $featured_posts->posts, 'ID' ) );

$exclude_posts = array_flatten( $exclude_posts );

?>

<section class="m-t-50">
  <div class="container">
    <div class="row justify-content-between p-l-25 p-r-25 align-items-center p-b-15 border-bottom">
      <p class="type-bold font-14 letter-spacing caps">featured articles</p>
      <div class="featured-articles-navigation row no-gutters">
        <a href="#" id="featured-prev" class="square-30 border color-dark row no-gutters align-items-center justify-content-center">
          <i class="icon-play_arrow rotate-180 font-14"></i>
        </a>
        <a href="#" id="featured-next" class="square-30 border-right border-bottom border-top color-dark row no-gutters align-items-center justify-content-center">
          <i class="icon-play_arrow font-14"></i>
        </a>
      </div>
    </div>
    <div class="p-t-20 featured-articles-row featured-carousel" id="featured-articles-row">
      <?php

      if ( $featured_posts->have_posts() ) {
        while ( $featured_posts->have_posts() ) {
          $featured_posts->the_post();
          $category = get_the_category();

          get_template_part( 'template-parts/content', 'featured' );
        }
      }

      wp_reset_postdata();

      ?>

    </div>
  </div>
</section>

<section class="m-t-50">
  <div class="container">
    <div class="row gutter-30 margin-responsive">
      <div class="flex-75">
        <div class="border-bottom p-b-20 p-l-25 p-r-25 m-b-25">
          <p class="type-bold font-14 letter-spacing caps">latest articles</p>
        </div>
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
                    <a href="<?php echo home_url('category') . '/' . $category[0]->slug . '/'; ?>" class="type-bold font-12 letter-spacing caps color-primary m-b-15 block"><?php echo $category[0]->cat_name; ?></p>
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
                        <p class="text-white subtitle font-12 p-l-5"><?php echo $total_like1 ?: 0; ?></p>
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
        <div class="m-t-40 block-bottom-padding-large">
          <?php dynamic_sidebar('blog'); ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php wp_reset_postdata(); ?>
<?php get_footer( $footer ); ?>
