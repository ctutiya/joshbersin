<?php
/**
* Template Name: Blog
*/

$navigation = get_field('navigation', 'options') ?: null;
$footer = get_field('footer', 'options') ?: null;

get_header( $navigation );
?>

<section class="header-top-padding-normal header-bottom-padding-normal bg-secondary">
  <div class="container width-950 align-center">
    <h1 class="large m-b-15">Enterprise Learning</h1>
    <p class="m-b-25">Enterprise Learning covers all aspects of employee development, training, leadership development, and the operations, governance, technologies, and tools of corporate training. This is a $240 billion industry filled with complex and powerful solutions to help people learn and progress at work.</p>
    <a href="#" onclick="history.back();">
      <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/arrow-primary.svg" alt="Go back">
    </a>
  </div>
</section>

<section class="block-top-padding-large">
  <div class="container">
    <div class="row gutter-30 margin-responsive">
      <div class="flex-73">
        <div>
          <?php get_template_part( 'template-parts/content', 'article' ); ?>
          <?php get_template_part( 'template-parts/content', 'article' ); ?>
          <?php get_template_part( 'template-parts/content', 'article' ); ?>
          <?php get_template_part( 'template-parts/content', 'article' ); ?>
          <?php get_template_part( 'template-parts/content', 'article' ); ?>
          <?php get_template_part( 'template-parts/content', 'article' ); ?>
        </div>
        <div class="pagination block-top-padding-large block-bottom-padding-large">
          <div class="nav-links">
            <a class="prev page-numbers" href="#">
              <div class="row align-items-center">
                <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/icon/arrow.svg" alt="Previous post">
                <p class="font-14 type-bold m-l-5">Prev</p>
              </div>
            </a>
            <span aria-current="page" class="page-numbers current">1</span>
            <a class="page-numbers" href="#">2</a>
            <a class="next page-numbers" href="#">
              <div class="row align-items-center">
                <p class="font-14 type-bold m-r-5">Next</p>
                <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/icon/arrow.svg" class="rotate-180" alt="Next post">
              </div>
            </a>
          </div>
        </div>

      </div>
      <div class="col">
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
</section>

<?php get_footer( $footer ); ?>
