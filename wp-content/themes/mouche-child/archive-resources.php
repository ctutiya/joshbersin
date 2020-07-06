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

<section class="block-top-padding-large block-bottom-padding-large">
  <div class="container">
    <p class="type-bold font-14 letter-spacing caps p-b-20 border-bottom m-b-20">featured RESOURCES</p>
    <div class="row gutter-30 margin-responsive" id="featured-resources-row">
      <div class="col">
        <div class="featured-resources-item">
          <img class="full-width height-160 image-cover m-b-30" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/featured-resource-1.jpg" alt="Featured resource">
          <div class="p-l-20 p-r-20 p-b-30">
            <h2 class="small m-b-15">Why HR Technology Matters Now More Than Ever</h2>
            <a href="#" class="btn small primary full-width align-center row no-gutters align-items-center justify-content-center"><span>learn more</span> <i class="m-l-5 icon-arrow_right_alt"></i></a>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="featured-resources-item">
          <img class="full-width height-160 image-cover m-b-30" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/featured-resource-2.jpg" alt="Featured resource">
          <div class="p-l-20 p-r-20 p-b-30">
            <h2 class="small m-b-15">Guide to Talent Acquisition for the Future</h2>
            <a href="#" class="btn small primary full-width align-center row no-gutters align-items-center justify-content-center"><span>learn more</span> <i class="m-l-5 icon-arrow_right_alt"></i></a>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="featured-resources-item">
          <img class="full-width height-160 image-cover m-b-30" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/featured-resource-3.jpg" alt="Featured resource">
          <div class="p-l-20 p-r-20 p-b-30">
            <h2 class="small m-b-15">Data Security, Trust, and Privacy for the Changing World</h2>
            <a href="#" class="btn small primary full-width align-center row no-gutters align-items-center justify-content-center"><span>learn more</span> <i class="m-l-5 icon-arrow_right_alt"></i></a>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="featured-resources-item">
          <img class="full-width height-160 image-cover m-b-30" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/featured-resource-4.jpg" alt="Featured resource">
          <div class="p-l-20 p-r-20 p-b-30">
            <h2 class="small m-b-15">Data Security, Trust, and Privacy for the Changing World</h2>
            <a href="#" class="btn small primary full-width align-center row no-gutters align-items-center justify-content-center"><span>learn more</span> <i class="m-l-5 icon-arrow_right_alt"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="block-bottom-padding-normal">
  <div class="container">
    <p class="type-bold font-14 letter-spacing caps p-b-20 border-bottom m-b-20">RESOURCES</p>
    <div class="row gutter-30 margin-responsive justify-content-between" id="resources-row">
      <div class="col-md-4">
        <div class="border row flex-column">
          <div class="row gutter-15">
            <div class="col-auto">
              <div class="full-height">
                <img class="image-cover full-height full-width" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/resources-1.jpg" alt="Resource">
              </div>
            </div>
            <div class="col">
              <div class="p-r-15 p-t-15 p-b-15 full-height relative">
                <h3 class="medium m-b-10">HRPS Research on the New Workforce</h3>
                <a href="#" class="btn small primary resources-button">Learn More <i class="m-l-5 icon-arrow_right_alt"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="border row flex-column">
          <div class="row gutter-15">
            <div class="col-auto">
              <div class="full-height">
                <img class="image-cover full-height full-width" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/resources-2.jpg" alt="Resource">
              </div>
            </div>
            <div class="col">
              <div class="p-r-15 p-t-15 p-b-15 full-height relative">
                <h3 class="medium m-b-10">HR Technology for 2020 Slideset</h3>
                <a href="#" class="btn small primary resources-button">Learn More <i class="m-l-5 icon-arrow_right_alt"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="border row flex-column">
          <div class="row gutter-15">
            <div class="col-auto">
              <div class="full-height">
                <img class="image-cover full-height full-width" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/resources-3.jpg" alt="Resource">
              </div>
            </div>
            <div class="col">
              <div class="p-r-15 p-t-15 p-b-15 full-height relative">
                <h3 class="medium m-b-10">HR Technology Market 2020</h3>
                <a href="#" class="btn small primary resources-button">Learn More <i class="m-l-5 icon-arrow_right_alt"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="border row flex-column">
          <div class="row gutter-15">
            <div class="col-auto">
              <div class="full-height">
                <img class="image-cover full-height full-width" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/resources-1.jpg" alt="Resource">
              </div>
            </div>
            <div class="col">
              <div class="p-r-15 p-t-15 p-b-15 full-height relative">
                <h3 class="medium m-b-10">HRPS Research on the New Workforce</h3>
                <a href="#" class="btn small primary resources-button">Learn More <i class="m-l-5 icon-arrow_right_alt"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="border row flex-column">
          <div class="row gutter-15">
            <div class="col-auto">
              <div class="full-height">
                <img class="image-cover full-height full-width" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/resources-2.jpg" alt="Resource">
              </div>
            </div>
            <div class="col">
              <div class="p-r-15 p-t-15 p-b-15 full-height relative">
                <h3 class="medium m-b-10">HR Technology for 2020 Slideset</h3>
                <a href="#" class="btn small primary resources-button">Learn More <i class="m-l-5 icon-arrow_right_alt"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="border row flex-column">
          <div class="row gutter-15">
            <div class="col-auto">
              <div class="full-height">
                <img class="image-cover full-height full-width" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/resources-3.jpg" alt="Resource">
              </div>
            </div>
            <div class="col">
              <div class="p-r-15 p-t-15 p-b-15 full-height relative">
                <h3 class="medium m-b-10">HR Technology Market 2020</h3>
                <a href="#" class="btn small primary resources-button">Learn More <i class="m-l-5 icon-arrow_right_alt"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="border row flex-column">
          <div class="row gutter-15">
            <div class="col-auto">
              <div class="full-height">
                <img class="image-cover full-height full-width" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/resources-1.jpg" alt="Resource">
              </div>
            </div>
            <div class="col">
              <div class="p-r-15 p-t-15 p-b-15 full-height relative">
                <h3 class="medium m-b-10">HRPS Research on the New Workforce</h3>
                <a href="#" class="btn small primary resources-button">Learn More <i class="m-l-5 icon-arrow_right_alt"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="border row flex-column">
          <div class="row gutter-15">
            <div class="col-auto">
              <div class="full-height">
                <img class="image-cover full-height full-width" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/resources-2.jpg" alt="Resource">
              </div>
            </div>
            <div class="col">
              <div class="p-r-15 p-t-15 p-b-15 full-height relative">
                <h3 class="medium m-b-10">HR Technology for 2020 Slideset</h3>
                <a href="#" class="btn small primary resources-button">Learn More <i class="m-l-5 icon-arrow_right_alt"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="border row flex-column">
          <div class="row gutter-15">
            <div class="col-auto">
              <div class="full-height">
                <img class="image-cover full-height full-width" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/resources-3.jpg" alt="Resource">
              </div>
            </div>
            <div class="col">
              <div class="p-r-15 p-t-15 p-b-15 full-height relative">
                <h3 class="medium m-b-10">HR Technology Market 2020</h3>
                <a href="#" class="btn small primary resources-button">Learn More <i class="m-l-5 icon-arrow_right_alt"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="pagination block-top-padding-normal block-bottom-padding-large">
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
</section>

<?php get_footer( $footer ); ?>
