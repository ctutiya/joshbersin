<?php $category = get_the_category(); ?>

<div class="item p-l-25 p-r-25 featured-articles-item">
  <a href="#">
    <img class="m-b-15 full-width height-140 image-cover" src="<?php echo get_the_post_thumbnail_url( $post->ID, 'medium' ); ?>" alt="<?php the_title(); ?>">
  </a>
  <a href="<?php echo $category[0]->slug; ?>" class="color-primary caps font-12 letter-spacing type-bold m-b-10">
    <?php

    echo $category[0]->cat_name;

    ?>
  </a>
  <a href="#" class="color-dark">
    <h3 class="small m-b-15"><?php echo the_title(); ?></h3>
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
