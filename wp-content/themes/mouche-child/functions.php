<?php
// enqueue scripts
function child_scripts() {
  global $wp_query;

  if ( ! is_admin() ) {
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/less/style.less' );

    $sticky_kit  = date("ymd-Gis", filemtime( get_stylesheet_directory_uri() . '/js/sticky-kit.js' ));

    wp_enqueue_script( 'sticky-kit', get_stylesheet_directory_uri() . '/js/sticky-kit.js', array(), $sticky_kit );

    $custom  = date("ymd-Gis", filemtime( get_stylesheet_directory_uri() . '/js/custom.js' ));

    wp_enqueue_script( 'custom', get_stylesheet_directory_uri() . '/js/custom.js', array(), $custom );

    wp_localize_script( 'custom', 'ajaxpagination', array(
    	'ajaxurl' => admin_url( 'admin-ajax.php' )
    ));

    if ( is_single() ) {
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

// Redirect user to previous page on login
function login_redirect( $redirect, $user ) {
  $redirect = isset( $_GET['redirect-url'] ) ? $_GET['redirect-url'] : $redirect;

  return $redirect;
}
add_filter( 'woocommerce_login_redirect', 'login_redirect', 10, 2 );

// Remove duplicate select2 style
add_action( 'wp_enqueue_scripts', 'mywptheme_child_deregister_styles', 11 );
function mywptheme_child_deregister_styles() {
    wp_dequeue_style( 'select2-css' );
}

// Update account details from the dashboard
function update_account() {
  global $current_user;

  get_currentuserinfo();

  $fields = array(
    'first_name'           => 'first_name',
    'last_name'            => 'last_name',
    'company'              => 'afreg_additional_120',
    'job_title'            => 'afreg_additional_119',
    'employees'            => 'afreg_additional_122',
    'company_headquarters' => 'afreg_additional_125',
    'job_type'             => 'afreg_additional_123',
  );

  $interests = $_POST['afreg_additional_126'];

  if ( isset( $interests ) ) {
    $interests = implode( $interests, ', ' );
    update_user_meta( $current_user->ID, 'afreg_additional_126', $interests );
  }

  $check = getimagesize( $_FILES['profile_picture_file']['tmp_name'] );

  if ( $current_user ) {
	  if( $check !== false ) {
		  $data = base64_encode( file_get_contents( $_FILES['profile_picture_file']['tmp_name'] ) );

      update_user_meta( $current_user->ID, 'profile_picture_base64', $data );
    }

    $args = array(
      'ID'         => $current_user->id,
      'user_email' => esc_attr( $_POST['email'] )
    );

    wp_update_user( $args );
  }

  $password = $_POST['password'];

  if ( isset( $password ) && !empty( $password ) ) {
    if ( $current_user ) {
      wp_update_user( array( 'ID' => $current_user->id, 'user_pass' => $password ) );
    }
  }

  foreach ( $fields as $name => $key ) {
    $new_value = $_POST[$key];

    if ( isset( $new_value ) ) {
      if ( $current_user ) {
        update_user_meta( $current_user->ID, $key, $new_value );
      }
    }
  }

  wp_redirect( home_url('my-account/edit-account') );
	exit;
}
add_action( 'admin_post_update_account', 'update_account' );

// Get profile picture source
function get_current_user_profile_picture() {
  global $current_user;

  get_currentuserinfo();

  $profile_picture = get_stylesheet_directory() . '/images/icon/user.svg';

  if ( $current_user ) {
    $user_id = $current_user->ID;

    $profile_picture_base64 = get_user_meta( $user_id, 'profile_picture_base64' );

    if ( $profile_picture_base64[0] ) {
      $profile_picture = 'data:image/png;base64, ' . $profile_picture_base64[0];
    }
  }


  return $profile_picture;
}

function is_interest_checked( $interest, $interests ) {
  if ( preg_match("/$interest/", $interests ) ) {
    return 'checked';
  }

  return '';
}

// Set post views for trending articles
function set_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);

    if ( $count === '' ){
      $count = 0;

      delete_post_meta( $postID, $count_key );
      add_post_meta( $postID, $count_key, '0' );
    } else{
      $count++;
      update_post_meta( $postID, $count_key, $count );
    }
}

remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

// Get how much time past since post was published
function time_ago( $full = false ) {
  $datetime = get_the_time();
  $now = new DateTime;
  $ago = new DateTime($datetime);
  $diff = $now->diff($ago);
  $diff->w = floor($diff->d / 7);
  $diff->d -= $diff->w * 7;

  $string = array(
     'y' => 'year',
     'm' => 'month',
     'w' => 'week',
     'd' => 'day',
     'h' => 'hour',
     'i' => 'minute',
     's' => 'second',
  );

  foreach ($string as $k => &$v) {
     if ($diff->$k) {
         $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
     } else {
         unset($string[$k]);
     }
  }

  if (!$full) {
    $string = array_slice($string, 0, 1);
  }

  return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function array_flatten($array) {

   $return = array();
   foreach ($array as $key => $value) {
       if (is_array($value)){ $return = array_merge($return, array_flatten($value));}
       else {$return[$key] = $value;}
   }
   return $return;

}

// Featured articles pagination
add_action( 'wp_ajax_nopriv_ajax_pagination', 'ajax_pagination' );
add_action( 'wp_ajax_ajax_pagination', 'ajax_pagination' );

function ajax_pagination() {
  $args = array(
    'tag_id' => 45,
    'post_status' => array(
      'publish'
    ),
    'posts_per_page' => 4,
    'order' => 'ASC',
    'orderby' => 'date',
    'post_type' => 'post',
    'paged' => intval( $_POST['paged'] ),
  );

  $posts = new WP_Query( $args );

  if ( $posts->have_posts() ) {
    while ( $posts->have_posts() ) {
      $posts->the_post();
      get_template_part( 'template-parts/content', 'featured' );
    }
  }

  die();
}
