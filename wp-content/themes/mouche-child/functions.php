<?php
// enqueue scripts
function child_scripts() {
  if ( ! is_admin() ) {
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/less/style.less' );

    $custom  = date("ymd-Gis", filemtime( get_stylesheet_directory_uri() . '/js/custom.js' ));

    wp_enqueue_script( 'custom', get_stylesheet_directory_uri() . '/js/custom.js', array(), $custom );

    if ( is_single() ) {
      $sticky_kit  = date("ymd-Gis", filemtime( get_stylesheet_directory_uri() . '/js/sticky-kit.js' ));

      wp_enqueue_script( 'sticky-kit', get_stylesheet_directory_uri() . '/js/sticky-kit.js', array(), $sticky_kit );

      $single_post  = date("ymd-Gis", filemtime( get_stylesheet_directory_uri() . '/js/single-post.js' ));

      wp_enqueue_script( 'single-post', get_stylesheet_directory_uri() . '/js/single-post.js', array(), $single_post );
    }

    if ( is_page('events') ) {
      $events  = date("ymd-Gis", filemtime( get_stylesheet_directory_uri() . '/js/events.js' ));

      wp_enqueue_script( 'events', get_stylesheet_directory_uri() . '/js/events.js', array(), $events );
    }
  }
}

add_action( 'wp_enqueue_scripts', 'child_scripts', 999 );
