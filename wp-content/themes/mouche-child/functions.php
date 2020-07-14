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

// My Account menu
add_filter ( 'woocommerce_account_menu_items', 'remove_my_account_links' );
function remove_my_account_links( $menu_links ){

	unset( $menu_links['edit-address'] );
	unset( $menu_links['payment-methods'] );
	unset( $menu_links['orders'] );

  $menu_links['downloads'] = 'Download History';

	return $menu_links;

}

function get_the_user_ip() {
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  } else {
    $ip = $_SERVER['REMOTE_ADDR'];
  }

  return $ip;
}

// Require user to login when accessing resources or reading the third blog post
function my_forcelogin_bypass( $bypass, $url ) {
  $is_blog_article = is_singular('post');
  $is_resource = is_singular('resources');

  $user_ip = get_the_user_ip();
  $posts_read = get_option( 'posts_read_' . $user_ip ) ?: 0;
  $has_reached_blog_limit = $posts_read >= 3;

  $can_read_post = !($is_blog_article && $has_reached_blog_limit);
  $can_read_resource = !$is_resource;

  $bypass = true;

  if ( !$can_read_post || !$can_read_resource ) {
    $bypass = false;
  }

  return $bypass;
}
add_filter( 'v_forcelogin_bypass', 'my_forcelogin_bypass', 10, 2 );


function login_redirect( $redirect, $user ) {
  $redirect = isset( $_GET['redirect-url'] ) ? $_GET['redirect-url'] : $redirect;

  return $redirect;
}
add_filter( 'woocommerce_login_redirect', 'login_redirect', 10, 2 );

add_action( 'wp_enqueue_scripts', 'mywptheme_child_deregister_styles', 11 );
function mywptheme_child_deregister_styles() {
    wp_dequeue_style( 'select2-css' );

}
