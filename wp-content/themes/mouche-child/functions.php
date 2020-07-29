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

  $can_read_post = !($is_blog_article && $has_reached_blog_limit && !is_user_logged_in());
  $bypass = true;

  if ( !$can_read_post ) {
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
function get_current_user_profile_picture( $url, $id_or_email, $args ) {
  $profile_picture = get_stylesheet_directory_uri() . '/images/icon/user.svg';

  $profile_picture_base64 = get_user_meta( $id_or_email, 'profile_picture_base64' );

  if ( $profile_picture_base64[0] ) {
    $profile_picture = 'data:image/png;base64, ' . $profile_picture_base64[0];
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
function time_ago() {
  $time_ago = human_time_diff( get_the_time('U') );

  return $time_ago . ' ago';
}

function array_flatten($array) {

   $return = array();
   foreach ($array as $key => $value) {
       if (is_array($value)){ $return = array_merge($return, array_flatten($value));}
       else {$return[$key] = $value;}
   }
   return $return;

}

function post_like_table_create() {

global $wpdb;
$table_name = $wpdb->prefix. "post_like_table";
global $charset_collate;
$charset_collate = $wpdb->get_charset_collate();
global $db_version;

if( $wpdb->get_var("SHOW TABLES LIKE '" . $table_name . "'") != $table_name) {
  $create_sql = "CREATE TABLE " . $table_name . " (
  id INT(11) NOT NULL auto_increment,
  postid INT(11) NOT NULL ,

  clientip VARCHAR(40) NOT NULL ,

  PRIMARY KEY (id))$charset_collate;";
  require_once(ABSPATH . "wp-admin/includes/upgrade.php");
  dbDelta( $create_sql );
}

if (!isset($wpdb->post_like_table)) {
  $wpdb->post_like_table = $table_name;
  //add the shortcut so you can use $wpdb->stats
  $wpdb->tables[] = str_replace($wpdb->prefix, '', $table_name);
}

}
add_action( 'init', 'post_like_table_create');

function get_client_ip() {
  $ip = $_SERVER['REMOTE_ADDR'];

  return $ip;
}

function my_action_callback() {
  check_ajax_referer( 'my-special-string', 'security' );
  $postid = intval( $_POST['postid'] );
  $clientip = get_client_ip();
  $like = 0;
  $dislike = 0;
  $like_count = 0;

  global $wpdb;
  $row = $wpdb->get_results( "SELECT id FROM $wpdb->post_like_table WHERE postid = '$postid' AND clientip = '$clientip'");

  if( empty( $row ) ){
    $wpdb->insert( $wpdb->post_like_table, array( 'postid' => $postid, 'clientip' => $clientip ), array( '%d', '%s' ) );
    $like = 1;
  }

  if( ! empty( $row ) ){
    //delete row
    $wpdb->delete( $wpdb->post_like_table, array( 'postid' => $postid, 'clientip'=> $clientip ), array( '%d','%s' ) );
    $dislike = 1;
  }

  //calculate like count from db.
  $totalrow = $wpdb->get_results( "SELECT id FROM $wpdb->post_like_table WHERE postid = '$postid'");
  $total_like = $wpdb->num_rows;
  $data = array( 'postid'=>$postid,'likecount'=>$total_like,'clientip'=>$clientip,'like'=>$like,'dislike'=>$dislike);
  echo json_encode($data);
  //echo $clientip;
  die(); // this is required to return a proper result
}

add_action( 'wp_ajax_my_action', 'my_action_callback' );
add_action( 'wp_ajax_nopriv_my_action', 'my_action_callback' );

// Download resource file and save to database
function download_resource(){
  $attachment_id = $_GET['attachment_id'];
  $file = wp_get_attachment_url( $attachment_id );

  if( !$file ) {
    return;
  }

  $file_url  = stripslashes( trim( $file ) );
  $file_name = basename( $file );
  $file_mime_type = get_post_mime_type( $attachment_id );

  if(strpos( $file_url , '.php' ) == true) {
	  die("Invalid file!");
  }

  global $current_user;

  get_currentuserinfo();

  $resource_download_history = get_user_meta( $current_user->ID, 'resource_download_history', true) ?: array();
  $resource_download_history[intval( $_GET['resource_id'] )] = true;

  update_user_meta( $current_user->ID, 'resource_download_history', $resource_download_history );

  header("Expires: 0");
  header("Cache-Control: no-cache, no-store, must-revalidate");
  header('Cache-Control: pre-check=0, post-check=0, max-age=0', false);
  header("Pragma: no-cache");
  header("Content-type: {$file_mime_type}");
  header("Content-Disposition:attachment; filename={$file_name}");
  header("Content-Type: application/force-download");

  readfile("{$file_url}");
  exit();
}

add_filter( 'init', 'download_resource' );

add_filter( 'get_avatar_url', 'get_current_user_profile_picture', 999, 3 );

function filter_get_avatar( $avatar, $id_or_email, $size, $default, $alt, $args ) {
  $profile_picture = get_stylesheet_directory_uri() . '/images/icon/user.svg';

  $profile_picture_base64 = get_user_meta( $id_or_email, 'profile_picture_base64' );

  if ( $profile_picture_base64[0] ) {
    $profile_picture = 'data:image/png;base64, ' . $profile_picture_base64[0];
  }

  $profile_picture = '<img src="' . $profile_picture . '" alt="Avatar">';

  return $profile_picture;
}

add_filter( 'get_avatar', 'filter_get_avatar', 999, 6 );

// Events widget shortcode
function events_widget( $args ) {
  $output = '<div class="align-center p-t-20 p-b-20 p-l-25 p-r-25 border-bottom letter-spacing type-bold caps font-14 color-tertiary">Upcoming events</div>';
  $output .= '<div class="p-l-25 p-r-25">';

  $args = array(
      'post_status' => array(
        'future'
      ),
      'post_type' => array( 'webinars', 'conferences' ),
      'posts_per_page' => 3,
      'order' => 'ASC',
      'orderby' => 'date',
  );

  $events = new WP_Query( $args );

  if ( $events->have_posts() ) {
    while ( $events->have_posts() ) {
        $events->the_post();
        $promo_code = get_field( 'coupon_code', get_the_ID() );
        $link_to_event_page = get_field( 'link_to_event_page', get_the_ID() );

        $output .= '<div class="p-t-15 row gutter-20">';
        $output .= '<div class="col-auto align-center color-primary">';
        $output .= '<p class="font-30 type-bold">' . get_the_time('d') . '</p>';
        $output .= '<p class="font-12">' . get_the_time('M') . '</p>';
        $output .= '</div>';
        $output .= '<div class="col">';
        $output .= '<p class="font-14 type-bold m-b-5">';
        $output .= '<a href="' . $link_to_event_page . '" target="_blank" class="color-dark">' . get_the_title() . '</a>';
        $output .= '</p>';

        $date_EST = new DateTime( get_the_time(), new DateTimeZone('UTC') );
        $date_EST->setTimezone( new DateTimeZone('EST') );

        $output .= '<p class="subtitle font-12 m-b-5">' . $date_EST->format( 'h:iA') . ' EST' . '</p>';

        if ( $promo_code ):
          $output .= '<p class="subtitle font-12 m-b-5">Promo Code: ' . $promo_code . '</p>';
        endif;

        $output .= '<a href="' . $link_to_event_page . '" class="font-12 row no-gutters align-items-center" target="_blank" >Learn More <i class="icon-arrow_right_alt m-l-5 font-20"></i></a>';
        $output .= '</div>';
        $output .= '</div>';
    }
  }

  wp_reset_postdata();

  $output .= '</div>';
  $output .= '<a href="' . home_url('events') . '" class="block align-center m-t-15 p-t-15 p-b-20 p-l-25 p-r-25 border-top letter-spacing type-bold caps font-14 color-tertiary">View more</a>';

  return $output;
}
add_shortcode( 'events', 'events_widget' );

// Register Sidebars
function inner_sidebars() {
  register_sidebar( array(
      'name'          => __( 'Inner pages sidebar', 'textdomain' ),
      'id'            => 'inner',
      'description'   => __( 'Widgets in this area will be shown on inner pages.', 'textdomain' ),
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget'  => '</div>',
      'before_title'  => '<p class="widgettitle m-b-30 font-18 type-medium">',
      'after_title'   => '</p>',
  ) );
}
add_action( 'widgets_init', 'inner_sidebars' );

// Events widget shortcode
function academy_widget( $args ) {
$output = '<a href="https://bersinacademy.com/" target="_blank" class="align-center academy-widget">';
$output .= '<div class="p-25">';
$output .= '<p class="type-bold color-tertiary m-b-30 font-14">Join the only global professional development academy for HR</p>';
$output .= '<img src="' . get_stylesheet_directory_uri() . '/images/josh-bersin-academy.png" alt="Josh Bersin Academy">';
$output .= '</div>';
$output .= '<div class="p-t-10 p-b-10 p-l-25 p-r-25 border-top block type-bold caps font-14 color-tertiary learn-more-button">Learn More</div>';
$output .= '</a>';

  return $output;
}
add_shortcode( 'academy', 'academy_widget' );

function custom_search_form( $form ) {
   $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
   <div>
     <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="Search" class="full-width block">
     <button type="submit" id="searchsubmit">
       <i class="icon-search font-18"></i>
     </button>
    </div>
   </form>';

   return $form;
}
add_filter( 'get_search_form', 'custom_search_form' );
