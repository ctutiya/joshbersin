<?php
$navigation = get_field('navigation', 'options') ?: null;
$footer = get_field('footer', 'options') ?: null;

get_header( $navigation );

$big = 999999999;
?>

<section class="header-top-padding-normal header-bottom-padding-normal bg-secondary">
  <div class="container width-950 align-center p-t-15 p-b-15">
    <h1 class="large m-b-15">News</h1>
    <p class="m-b-25 color-tertiary">Check this page for the latest news releases and articles related to Josh Bersin's work and the Josh Bersin Academy.  For press-related queries, please contact Linda Galloway at <a href="mailto:linda@bersinpartners.com" target="_blank" class="type-bold">linda@bersinpartners.com</a>.</p>
    <a href="#" onclick="history.back();">
      <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/arrow-primary.svg" alt="Go back">
    </a>
  </div>
</section>

<section class="block-top-padding-large">
  <div class="container">
    <div class="row gutter-30 margin-responsive">
      <div class="flex-73">
        <div id="news-items">
          <?php

          if ( have_posts() ) {
            while ( have_posts() ) {
              the_post();
              $category = get_the_category();

              get_template_part( 'template-parts/content', 'news' );
            }
          }

          ?>

        </div>
        <div class="pagination block-top-padding-large block-bottom-padding-large">
          <div class="nav-links">

          <?php

            global $wp_query;

            echo paginate_links( array(
                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format' => '?paged=%#%',
                'prev_next' => true,
                'current' => max( 1, get_query_var('paged') ),
                'total' =>  $wp_query->max_num_pages,
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
        <div class="m-t-40 block-bottom-padding-large">
          <?php dynamic_sidebar('inner'); ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php get_footer( $footer ); ?>
