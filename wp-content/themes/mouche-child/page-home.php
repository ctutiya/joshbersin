<?php
/**
* Template Name: Home
*/

$navigation = get_field('navigation', 'options') ?: null;
$footer = get_field('footer', 'options') ?: null;

get_header( $navigation );
?>

<section class="block-top-padding-large block-bottom-padding-large">
  <div class="container align-center width-850">
    <h1 class="large m-b-35">Insights on Work, Talent and HR technology</h1>
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
      <div class="flex-77 bg-img row" style="background-image: url(<?php echo bloginfo('stylesheet_directory'); ?>/images/trends-main.jpg)">
        <div class="row no-gutters flex-column justify-content-end align-items-start p-55">
          <p class="caps text-white type-bold font-12 letter-spacing m-b-25">business trends</p>
          <h2 class="width-600 text-white m-b-45 large">Remote Work Is Here To Stay: Are You Ready?</h2>
          <a href="#" class="btn small primary">Read more<i class="m-l-5 icon-arrow_right_alt"></i></a>
        </div>
      </div>
      <div class="flex-23 bg-secondary">
        <div class="bg-primary p-t-20 p-r-25 p-b-20 p-l-25 caps text-white type-bold font-14 letter-spacing">
          trending
        </div>
        <div class="p-t-35 p-b-35 p-l-25 p-r-25">
          <ul class="trending-list">
            <li class="row gutter-10">
              <img class="col-auto square-60 image-cover" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/trending-1.jpg" alt="Trending topic">
              <div class="col">
                <a href="#" class="subtitle">
                  <p class="font-14">Office Meetings Leave the Office</p>
                </a>
                <p class="subtitle text-white font-12">15 minutes ago</p>
              </div>
            </li>
            <li class="row gutter-10">
              <img class="col-auto square-60 image-cover" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/trending-2.jpg" alt="Trending topic">
              <div class="col">
                <a href="#" class="subtitle">
                  <p class="font-14">Experimental Vocal Music in Brooklyn</p>
                </a>
                <p class="subtitle text-white font-12">32 minutes ago</p>
              </div>
            </li>
            <li class="row gutter-10">
              <img class="col-auto square-60 image-cover" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/trending-3.jpg" alt="Trending topic">
              <div class="col">
                <a href="#" class="subtitle">
                  <p class="font-14">Google’s Influence Over Think Tanks</p>
                </a>
                <p class="subtitle text-white font-12">38 minutes ago</p>
              </div>
            </li>
            <li class="row gutter-10">
              <img class="col-auto square-60 image-cover" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/trending-4.jpg" alt="Trending topic">
              <div class="col">
                <a href="#" class="subtitle">
                  <p class="font-14">Homes for Sale in NYC and Connecticut</p>
                </a>
                <p class="subtitle text-white font-12">53 minutes ago</p>
              </div>
            </li>
            <li class="row gutter-10">
              <img class="col-auto square-60 image-cover" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/trending-5.jpg" alt="Trending topic">
              <div class="col">
                <a href="#" class="subtitle">
                  <p class="font-14">Are You There, Dad? It’s Me, Alice</p>
                </a>
                <p class="subtitle text-white font-12">1 hour ago</p>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="m-t-50">
  <div class="container">
    <div class="row justify-content-between p-l-25 p-r-25 align-items-center p-b-15 border-bottom">
      <p class="type-bold font-14 letter-spacing caps">featured articles</p>
      <div class="featured-articles-navigation row no-gutters">
        <a href="#" class="square-30 border color-dark row no-gutters align-items-center justify-content-center">
          <i class="icon-play_arrow rotate-180 font-14"></i>
        </a>
        <a href="#" class="square-30 border-right border-bottom border-top color-dark row no-gutters align-items-center justify-content-center">
          <i class="icon-play_arrow font-14"></i>
        </a>
      </div>
    </div>
    <div class="row p-t-20" id="featured-articles-row">
      <div class="flex-25 p-l-25 p-r-25 featured-articles-item">
        <a href="#">
          <img class="m-b-15 full-width height-140 image-cover" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/featured-articles-1.jpg" alt="Featured article">
        </a>
        <p class="color-primary caps font-12 letter-spacing type-bold m-b-10">Enterprise Learning</p>
        <a href="#" class="color-dark">
          <h3 class="small m-b-15">Best Labor Day Weekend Car Deals, Financing Discounts</h3>
        </a>
        <div class="row gutter-10">
          <div class="row col-auto align-items-center">
            <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/icon/comment.svg" alt="Comments">
            <p class="text-white subtitle font-12 p-l-5">560</p>
          </div>
          <div class="row col-auto align-items-center">
            <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/icon/heart.svg" alt="Likes">
            <p class="text-white subtitle font-12 p-l-5">3,354</p>
          </div>
        </div>
      </div>
      <div class="flex-25 p-l-25 p-r-25 featured-articles-item">
        <a href="#">
          <img class="m-b-15 full-width height-140 image-cover" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/featured-articles-2.jpg" alt="Featured article">
        </a>
        <p class="color-primary caps font-12 letter-spacing type-bold m-b-10">Enterprise Learning</p>
        <a href="#" class="color-dark">
          <h3 class="small m-b-15">Best Labor Day Weekend Car Deals, Financing Discounts</h3>
        </a>
        <div class="row gutter-10">
          <div class="row col-auto align-items-center">
            <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/icon/comment.svg" alt="Comments">
            <p class="text-white subtitle font-12 p-l-5">560</p>
          </div>
          <div class="row col-auto align-items-center">
            <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/icon/heart.svg" alt="Likes">
            <p class="text-white subtitle font-12 p-l-5">3,354</p>
          </div>
        </div>
      </div>
      <div class="flex-25 p-l-25 p-r-25 featured-articles-item">
        <a href="#">
          <img class="m-b-15 full-width height-140 image-cover" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/featured-articles-3.jpg" alt="Featured article">
        </a>
        <p class="color-primary caps font-12 letter-spacing type-bold m-b-10">Enterprise Learning</p>
        <a href="#" class="color-dark">
          <h3 class="small m-b-15">Best Labor Day Weekend Car Deals, Financing Discounts</h3>
        </a>
        <div class="row gutter-10">
          <div class="row col-auto align-items-center">
            <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/icon/comment.svg" alt="Comments">
            <p class="text-white subtitle font-12 p-l-5">560</p>
          </div>
          <div class="row col-auto align-items-center">
            <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/icon/heart.svg" alt="Likes">
            <p class="text-white subtitle font-12 p-l-5">3,354</p>
          </div>
        </div>
      </div>
      <div class="flex-25 p-l-25 p-r-25 featured-articles-item">
        <a href="#">
          <img class="m-b-15 full-width height-140 image-cover" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/featured-articles-4.jpg" alt="Featured article">
        </a>
        <p class="color-primary caps font-12 letter-spacing type-bold m-b-10">Enterprise Learning</p>
        <a href="#" class="color-dark">
          <h3 class="small m-b-15">Best Labor Day Weekend Car Deals, Financing Discounts</h3>
        </a>
        <div class="row gutter-10">
          <div class="row col-auto align-items-center">
            <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/icon/comment.svg" alt="Comments">
            <p class="text-white subtitle font-12 p-l-5">560</p>
          </div>
          <div class="row col-auto align-items-center">
            <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/icon/heart.svg" alt="Likes">
            <p class="text-white subtitle font-12 p-l-5">3,354</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="m-t-50">
  <div class="container">
    <div class="row gutter-30 margin-responsive">
      <div class="flex-73">
        <div class="border-bottom p-b-20 p-l-25 p-r-25 m-b-25">
          <p class="type-bold font-14 letter-spacing caps">latest articles</p>
        </div>
        <div>
          <?php get_template_part( 'template-parts/content', 'article' ); ?>
          <div class="row gutter-25 m-l-25 m-r-25 latest-articles-item">
            <div class="flex-41">
              <a href="#" class="full-height full-width block">
                <img class="full-height full-width image-cover" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/latest-articles-2.jpg" alt="Latest article">
              </a>
            </div>
            <div class="col">
              <p class="type-bold font-12 letter-spacing caps color-primary m-b-15">hr operations & transformation</p>
              <a href="#" class="color-dark">
                <h3 class="medium m-b-10">Passengers Suffer as Crowded Field Puts Pressure on Europe’s Airlines</h3>
              </a>
              <p class="subtitle font-14 m-b-20">Weaker carriers have fallen by the wayside amid fierce competition, while others have been hit by bad luck. The result: thousands of canceled flights.</p>
              <div class="row gutter-10">
                <div class="col-auto">
                  <p class="text-white subtitle font-12">Aug 6</p>
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
          <div class="row gutter-25 m-l-25 m-r-25 latest-articles-item">
            <div class="flex-41">
              <a href="#" class="full-height full-width block">
                <img class="full-height full-width image-cover" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/latest-articles-3.jpg" alt="Latest article">
              </a>
            </div>
            <div class="col">
              <p class="type-bold font-12 letter-spacing caps color-primary m-b-15">hr operations & transformation</p>
              <a href="#" class="color-dark">
                <h3 class="medium m-b-10">Passengers Suffer as Crowded Field Puts Pressure on Europe’s Airlines</h3>
              </a>
              <p class="subtitle font-14 m-b-20">Weaker carriers have fallen by the wayside amid fierce competition, while others have been hit by bad luck. The result: thousands of canceled flights.</p>
              <div class="row gutter-10">
                <div class="col-auto">
                  <p class="text-white subtitle font-12">Aug 6</p>
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
          <div class="row gutter-25 m-l-25 m-r-25 latest-articles-item">
            <div class="flex-41">
              <a href="#" class="full-height full-width block">
                <img class="full-height full-width image-cover" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/latest-articles-4.jpg" alt="Latest article">
              </a>
            </div>
            <div class="col">
              <p class="type-bold font-12 letter-spacing caps color-primary m-b-15">hr operations & transformation</p>
              <a href="#" class="color-dark">
                <h3 class="medium m-b-10">Passengers Suffer as Crowded Field Puts Pressure on Europe’s Airlines</h3>
              </a>
              <p class="subtitle font-14 m-b-20">Weaker carriers have fallen by the wayside amid fierce competition, while others have been hit by bad luck. The result: thousands of canceled flights.</p>
              <div class="row gutter-10">
                <div class="col-auto">
                  <p class="text-white subtitle font-12">Aug 6</p>
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
          <div class="row gutter-25 m-l-25 m-r-25 latest-articles-item">
            <div class="flex-41">
              <a href="#" class="full-height full-width block">
                <img class="full-height full-width image-cover" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/latest-articles-5.jpg" alt="Latest article">
              </a>
            </div>
            <div class="col">
              <p class="type-bold font-12 letter-spacing caps color-primary m-b-15">hr operations & transformation</p>
              <a href="#" class="color-dark">
                <h3 class="medium m-b-10">Passengers Suffer as Crowded Field Puts Pressure on Europe’s Airlines</h3>
              </a>
              <p class="subtitle font-14 m-b-20">Weaker carriers have fallen by the wayside amid fierce competition, while others have been hit by bad luck. The result: thousands of canceled flights.</p>
              <div class="row gutter-10">
                <div class="col-auto">
                  <p class="text-white subtitle font-12">Aug 6</p>
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
          <div class="row gutter-25 m-l-25 m-r-25 latest-articles-item">
            <div class="flex-41">
              <a href="#" class="full-height full-width block">
                <img class="full-height full-width image-cover" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/latest-articles-6.jpg" alt="Latest article">
              </a>
            </div>
            <div class="col">
              <p class="type-bold font-12 letter-spacing caps color-primary m-b-15">hr operations & transformation</p>
              <a href="#" class="color-dark">
                <h3 class="medium m-b-10">Passengers Suffer as Crowded Field Puts Pressure on Europe’s Airlines</h3>
              </a>
              <p class="subtitle font-14 m-b-20">Weaker carriers have fallen by the wayside amid fierce competition, while others have been hit by bad luck. The result: thousands of canceled flights.</p>
              <div class="row gutter-10">
                <div class="col-auto">
                  <p class="text-white subtitle font-12">Aug 6</p>
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
<?php get_footer( $footer ); ?>
