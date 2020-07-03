<?php
$navigation = get_field('navigation', 'options') ?: null;
$footer = get_field('footer', 'options') ?: null;

get_header( $navigation );
?>

<section>
  <div class="container width-980 block-bottom-padding-large">

    <?php

    $args = array(
      'post_status' => array( 'publish' ),
      'posts_per_page' => 10,
      's' => get_search_query(),
      'category_name' => $_GET['category']
    );

    $the_query = new WP_Query( $args );

    if ( $the_query->have_posts() ) {
      ?>

      <section class="block-top-padding-large block-bottom-padding-large">
        <div class="container align-center width-980">
          <div class="font-36 m-t-40 p-b-20">
            <?php printf( esc_attr__( 'Results found for: "%s"', 'mouche' ), '<b>' . get_search_query() . '</b>' ); ?>
          </div>
        </div>
      </section>

      <?php
      while ( $the_query->have_posts() ) {
          $the_query->the_post();

          ?>

          <article class="blog-item" data-aos="fade-up">
            <div class="blog-item-inner">
              <div class="p-t-40 border-top">
                <h2 class="m-b-15">
                  <a href="<?php the_permalink(); ?>" class="color-dark"><?php the_title(); ?></a>
                </h2>
                <div class="subtitle"><?php echo get_excerpt(400); ?>
                  <a href="<?php the_permalink(); ?>" class="inline-flex align-items-center"><span class="m-r-10">more</span>
                    <svg width="7px" height="12px" viewBox="0 0 7 12" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g class="arrow-right" transform="translate(-459.000000, -678.000000)" fill="#CC3232">
                          <g transform="translate(247.000000, 533.000000)">
                            <g transform="translate(215.500000, 151.000000) rotate(270.000000) translate(-215.500000, -151.000000) translate(210.000000, 148.000000)">
                              <polygon transform="translate(5.850000, 3.000000) scale(1, -1) rotate(270.000000) translate(-5.850000, -3.000000) " points="8.7 3 3.71787386 8 3 7.28013648 7.29628893 2.98863834 3.01137434 -1.29149814 3.71787386 -2"></polygon>
                            </g>
                          </g>
                        </g>
                      </g>
                    </svg>
                  </a>
                </div>
              </div>

              <?php

              $podcast = get_field( 'link_to_podcast' );

              if ( $podcast ) {
                ?>

                <footer class="blog-footer">
                  <div class="podcast-container-style-2 m-t-10">
                    <div class="audio-player-container">
                      <audio controls preload="none">
                        <source src="<?php echo $podcast; ?>" type="audio/mpeg">
                      </audio>
                      <div class="controls">
                        <a href="#" class="not-smooth play-pause-btn">
                          <div class="play-pause">
                              <div class="playi">
                                <svg width="17" height="17" viewBox="0 0 480 480" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path  opacity="0.0" fill-rule="evenodd" clip-rule="evenodd" d="M240 480C372.548 480 480 372.548 480 240C480 107.452 372.548 0 240 0C107.452 0 0 107.452 0 240C0 372.548 107.452 480 240 480Z" fill="black"/>
                                  <path id="icon-path-play" fill-rule="evenodd" clip-rule="evenodd" d="M192 165.001C192 153.106 205.262 145.958 215.27 152.46L329.177 226.459C338.274 232.368 338.274 245.632 329.177 251.541L215.27 325.54C205.262 332.042 192 324.894 192 312.999V165.001Z" fill="white"/>
                                </svg>
                              </div>
                              <div class="pausei">
                                  <svg width="17" height="17" viewBox="0 0 480 480" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path  opacity="0.0" fill-rule="evenodd" clip-rule="evenodd" d="M240 480C372.548 480 480 372.548 480 240C480 107.452 372.548 0 240 0C107.452 0 0 107.452 0 240C0 372.548 107.452 480 240 480Z" fill="#DB0042"/>
                                  <rect id="icon-path-pause" x="160.05" y="142.5" width="58.6066" height="195" rx="26" fill="white"/>
                                  <rect id="icon-path-pause" x="261.28" y="142.5" width="58.6066" height="195" rx="26" fill="white"/>
                                  </svg>
                              </div>
                          </div>
                          <div class="timer" style="width: 30px">0:00</div>
                        </a>

                        <div class="waves">
                          <div class="wave" id="wave-28494127"></div>
                          <div class="wave-normal">
                            <!-- <img data-aos="fade-up" src="https://149396263.v2.pressablecdn.com/wp-content/themes/naval/images/wavenormal.png" alt="waves" > -->
                          </div>
                          <div class="wave-filled">
                            <!-- <img data-aos="fade-up" src="https://149396263.v2.pressablecdn.com/wp-content/themes/naval/images/wavefilled.png" alt="waves" >  -->
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="podcast-links">
                      <div class="dropdown">
                        <button class="podcast-open-link" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="m-r-5">Get podcast</span>
                            <svg width="7px" height="12px" viewBox="0 0 7 12" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g class="arrow-right" transform="translate(-459.000000, -678.000000)" fill="#808080">
                                  <g transform="translate(247.000000, 533.000000)">
                                    <g transform="translate(215.500000, 151.000000) rotate(270.000000) translate(-215.500000, -151.000000) translate(210.000000, 148.000000)">
                                      <polygon transform="translate(5.850000, 3.000000) scale(1, -1) rotate(270.000000) translate(-5.850000, -3.000000) " points="8.7 3 3.71787386 8 3 7.28013648 7.29628893 2.98863834 3.01137434 -1.29149814 3.71787386 -2"></polygon>
                                    </g>
                                  </g>
                                </g>
                              </g>
                            </svg>
                        </button>
                        <div class="dropdown-menu  " aria-labelledby="podcast-open-link">
                          <a href="<?php echo $podcast; ?>" target="_blank" download>Download</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </footer>

                <?php
              }

              ?>
            </div>
          </article>

          <?php
      }
    } else {
      ?>

      <div class="subtitle m-t-40">
        <?php printf( esc_attr__( 'No results found for: "%s"', 'mouche' ), '<span>' . get_search_query() . '</span>' ); ?>
      </div>
    <?php } ?>
  </div>
</section>

<?php get_footer( $footer ); ?>
