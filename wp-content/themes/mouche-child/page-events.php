<?php
/**
* Template Name: Events
*/

$navigation = get_field('navigation', 'options') ?: null;
$footer = get_field('footer', 'options') ?: null;

get_header( $navigation );
?>

<section class="header-top-padding-normal header-bottom-padding-normal bg-secondary color-tertiary">
  <div class="container width-950 align-center p-t-15 p-b-15">
    <h1 class="large m-b-15">Events</h1>
    <p class="m-b-25">Check this page for upcoming presentations and events related to Josh Bersin and the Josh Bersin Academy.  For speaking inquiries, contact <a href="mailto:lindagalloway@bersinpartners.com" class="type-bold">lindagalloway@bersinpartners.com</a>.</p>
    <a href="#" onclick="history.back();">
      <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/arrow-primary.svg" alt="Go back">
    </a>
  </div>
</section>

<?php

$args = array(
    'post_status' => array(
      'future'
    ),
    'post_type' => 'webinars',
    'posts_per_page' => -1,
    'order' => 'ASC',
    'orderby' => 'date',
);

$webinars = get_posts( $args );

?>

<section class="block-top-padding-large block-bottom-padding-large color-tertiary">
  <div class="container">
    <div class="row justify-content-between align-items-end p-b-25 border-bottom m-b-25">
      <div>
        <p class="type-bold font-32 letter-spacing m-b-10">Webinars</p>
        <p>Register to join an upcoming virtual event.</p>
      </div>
      <div class="row no-gutters">
        <a href="#" id="webinars-prev" class="square-30 border color-dark row no-gutters align-items-center justify-content-center">
          <i class="icon-play_arrow rotate-180 font-14"></i>
        </a>
        <a href="#" id="webinars-next" class="square-30 border-right border-bottom border-top color-dark row no-gutters align-items-center justify-content-center">
          <i class="icon-play_arrow font-14"></i>
        </a>
      </div>
    </div>
    <div id="webinars">
      <div class="owl-carousel owl-theme webinars-carousel">

      <?php

      $items = array_chunk( $webinars, 6 );

      for ($i=0; $i < sizeof( $items ); $i++) {
        ?>

        <div class="row gutter-35 item">

        <?php

        foreach ($items[$i] as $post) {
          setup_postdata( $post );

          $promo_code = get_field( 'coupon_code', get_the_ID() );
          $link_to_event_page = get_field( 'link_to_event_page', get_the_ID() );

          ?>

          <div class="col-md-4">
            <div class="event-item p-t-60 p-b-60 p-l-40 p-r-40">
              <a href="<?php echo $link_to_event_page ?: '#'; ?>" class="color-tertiary">
                <h2 class="small m-b-10"><?php the_title(); ?></h2>
              </a>
              <div class="font-16 m-b-25">
                <?php the_time('l, F j, Y'); ?>
                <br>
                <?php

                $date_EST = new DateTime( get_the_time(), new DateTimeZone('UTC') );
                $date_EST->setTimezone( new DateTimeZone('EST') );

                $date_MT = new DateTime( get_the_time(), new DateTimeZone('UTC') );
                $date_MT->setTimezone( new DateTimeZone('America/Edmonton') );

                ?>
                <?php echo $date_MT->format( 'h:iA') . ' MT / ' . $date_EST->format( 'h:iA') . ' EST'; ?>
                <?php if ( $promo_code ): ?>
                  <br>Promo Code: <?php echo $promo_code; ?>
                <?php endif; ?>
              </div>
              <a href="<?php echo $link_to_event_page ?: '#'; ?>" class="btn primary small">learn more <i class="icon-arrow_right_alt m-l-5"></i></a>
            </div>
          </div>

          <?php
        }

        ?>

        </div>

        <?php
      }
      ?>
    </div>
  </div>
</section>

<?php wp_reset_postdata(); ?>

<section class="block-top-padding-large block-bottom-padding-large">
  <div class="container">
    <div class="row gutter-60 align-items-center" id="events-testimonials-row">
      <div class="col-auto">
        <img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/josh-bersin-event.jpg" alt="Josh Bersin in an event">
      </div>
      <div class="col">
        <div>
          <img class="m-b-15" src="<?php echo bloginfo('stylesheet_directory'); ?>/images/icon/quotes.svg" alt="Quotes">
          <div class="owl-carousel owl-theme events-testimonials">
            <div>
              <h2 class="medium m-b-15">Exceptional materials. The most durable glass ever in a smartphone. A beautiful new gold finish, achieved lorem ipsum placeholder text here. </h2>
              <div class="m-b-50 font-16">
                Richard Davidson,<br>Project Manager at Skyscanner
              </div>
            </div>
            <div>
              <h2 class="medium m-b-15">Exceptional materials. The most durable glass ever in a smartphone. A beautiful new gold finish, achieved lorem ipsum placeholder text here. </h2>
              <div class="m-b-50 font-16">
                Richard Davidson,<br>Project Manager at Skyscanner
              </div>
            </div>
            <div>
              <h2 class="medium m-b-15">Exceptional materials. The most durable glass ever in a smartphone. A beautiful new gold finish, achieved lorem ipsum placeholder text here. </h2>
              <div class="m-b-50 font-16">
                Richard Davidson,<br>Project Manager at Skyscanner
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php

$args = array(
    'post_status' => array(
      'future'
    ),
    'post_type' => 'conferences',
    'posts_per_page' => -1,
    'order' => 'ASC',
    'orderby' => 'date',
);

$conferences = get_posts( $args );

?>

<section class="block-top-padding-large block-bottom-padding-large color-tertiary">
  <div class="container">
    <div class="row justify-content-between align-items-end p-b-25 border-bottom m-b-25">
      <div>
        <p class="type-bold font-32 letter-spacing m-b-10">Conferences & Seminars</p>
        <p>Hear Josh Bersin in person.</p>
      </div>
      <div class="row no-gutters">
        <a href="#" id="conferences-prev" class="square-30 border color-dark row no-gutters align-items-center justify-content-center">
          <i class="icon-play_arrow rotate-180 font-14"></i>
        </a>
        <a href="#" id="conferences-next" class="square-30 border-right border-bottom border-top color-dark row no-gutters align-items-center justify-content-center">
          <i class="icon-play_arrow font-14"></i>
        </a>
      </div>
    </div>
    <div id="conferences">
      <div class="owl-carousel owl-theme conferences-carousel">

        <?php

        $items = array_chunk( $conferences, 6 );

        for ( $i=0; $i < sizeof( $items ); $i++ ) {
          ?>

          <div class="row gutter-35 item">

          <?php

          foreach ( $items[$i] as $post ) {
            setup_postdata( $post );

            $promo_code = get_field( 'coupon_code', get_the_ID() );
            $link_to_event_page = get_field( 'link_to_event_page', get_the_ID() );
            $location = get_field( 'location', get_the_ID() );
            $event_date = get_field( 'event_date', get_the_ID() );

            ?>

            <div class="col-md-4">
              <div class="event-item p-t-60 p-b-60 p-l-40 p-r-40">
                <a href="<?php echo $link_to_event_page ?: '#'; ?>" class="color-tertiary">
                  <h2 class="small m-b-10"><?php the_title(); ?></h2>
                </a>
                <div class="font-16 m-b-25">
                  <?php echo $location; ?>
                  <br>
                  <?php echo $event_date; ?>
                  <?php if ( $promo_code ): ?>
                    <br>Promo Code: <?php echo $promo_code; ?>
                  <?php endif; ?>
                </div>
                <a href="<?php echo $link_to_event_page ?: '#'; ?>" class="btn primary small">learn more <i class="icon-arrow_right_alt m-l-5"></i></a>
              </div>
            </div>

            <?php
          }

          ?>

          </div>

          <?php
        }
        ?>
      </div>
    </div>
  </div>
</section>

<?php wp_reset_postdata(); ?>
<?php get_footer( $footer ); ?>
