<?php
// enqueue scripts
function child_scripts() {
  if ( ! is_admin() ) {
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/less/style.less' );

    $custom  = date("ymd-Gis", filemtime( get_stylesheet_directory_uri() . '/js/custom.js' ));

    wp_enqueue_script( 'custom', get_stylesheet_directory_uri() . '/js/custom.js', array(), $custom );
  }
}

add_action( 'wp_enqueue_scripts', 'child_scripts', 999 );
