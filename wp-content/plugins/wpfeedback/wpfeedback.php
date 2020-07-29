<?php
/**
 * Plugin Name: WP FeedBack PRO
 * Plugin URI: https://wpfeedback.co/
 * Description: Client feedback in 1 click - WP FeedBack PRO
 *
 * Version: 1.5.0
 * Requires at least: 5.0
 *
 * Author: WP FeedBack
 * Author URI: https://wpfeedback.co/
 *
 * Text Domain: wpfeedback
 * Domain Path: /languages/
 *
 * License: GPL-3.0-or-later
 *
 *
 * @author    WP FeedBack <info@wpfeedback.co>
 * @copyright 2019 WP FeedBack
 * @license   GPL-3.0-or-later
 * @package   WP FeedBack
 */
/**
 * If this file is called directly, abort.
 **/
if (!defined('WPINC')) {
    die;
}

if (!defined('WPF_PLUGIN_NAME'))
    define('WPF_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

if (!defined('WPF_PLUGIN_DIR'))
    define('WPF_PLUGIN_DIR', plugin_dir_path(__FILE__));

if (!defined('WPF_PLUGIN_URL'))
    define('WPF_PLUGIN_URL', plugin_dir_url(__FILE__));

if (!defined('WPF_VERSION'))
    define('WPF_VERSION', '1.5.0');

if ( is_multisite() ) {
    $site_url =  network_site_url();
} else{
    $site_url =  site_url();
}

define( 'SCOPER_ALL_UPLOADS_EDITABLE ', true );


if (!defined('WPF_SITE_URL'))
    define('WPF_SITE_URL', $site_url);

// this is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
define('WPF_EDD_SL_STORE_URL', 'https://wpfeedback.co/'); // IMPORTANT: change the name of this constant to something unique to prevent conflicts with other plugins using this system
// the download ID. This is the ID of your product in EDD and should match the download ID visible in your Downloads list (see example below)
define('WPF_EDD_SL_ITEM_ID', 95016); // IMPORTANT: change the name of this constant to something unique to prevent conflicts with other plugins using this system
define('WPF_EDD_FALLBACK_URL', 'https://verify.wpfeedback.co/');

/*
* Register hooks that are fired when the plugin is activated or deactivated.
* When the plugin is deleted, the uninstall.php file is loaded.
*/
register_activation_hook( __FILE__, array( 'WP_Feedback', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'WP_Feedback', 'deactivate' ) );

/*
 * This function is used to register the custom post type "wpfeedback" on the website where it is installed.
 *
 * @input NULL
 * @return NULL
 */
if (!function_exists('wpfeedback_post_type')) {

// Register Custom Post Type
    function wpfeedback_post_type()
    {

        $labels = array(
            'name' => _x('Wp feedback Types', 'Post Type General Name', 'wpfeedback'),
            'singular_name' => _x('Wp feedback Type', 'Post Type Singular Name', 'wpfeedback'),
            'menu_name' => __('WP feedBack', 'wpfeedback'),
            'name_admin_bar' => __('WP feedBack Type', 'wpfeedback'),
            'archives' => __('WP feedBack Item Archives', 'wpfeedback'),
            'attributes' => __('WP feedBack Item Attributes', 'wpfeedback'),
            'parent_item_colon' => __('WP feedBack Parent Item:', 'wpfeedback'),
            'all_items' => __('WP feedBack All Items', 'wpfeedback'),
            'add_new_item' => __('WP feedBack Add New Item', 'wpfeedback'),
            'add_new' => __('Add New WP feedBack', 'wpfeedback'),
            'new_item' => __('WP feedBack New Item', 'wpfeedback'),
            'edit_item' => __('WP feedBack Edit Item', 'wpfeedback'),
            'update_item' => __('WP feedBack Update Item', 'wpfeedback'),
            'view_item' => __('WP feedBack View Item', 'wpfeedback'),
            'view_items' => __('WP feedBack View Items', 'wpfeedback'),
            'search_items' => __('WP feedBack Search Item', 'wpfeedback'),
            'not_found' => __('Not found WP feedBack', 'wpfeedback'),
            'not_found_in_trash' => __('WP feedBack Not found in Trash', 'wpfeedback'),
            'featured_image' => __('WP feedBack Featured Image', 'wpfeedback'),
            'set_featured_image' => __('WP feedBack Set featured image', 'wpfeedback'),
            'remove_featured_image' => __('WP feedBack Remove featured image', 'wpfeedback'),
            'use_featured_image' => __('WP feedBack Use as featured image', 'wpfeedback'),
            'insert_into_item' => __('WP feedBack Insert into item', 'wpfeedback'),
            'uploaded_to_this_item' => __('Uploaded to this item', 'wpfeedback'),
            'items_list' => __('WP feedBack Items list', 'wpfeedback'),
            'items_list_navigation' => __('WP feedBack Items list navigation', 'wpfeedback'),
            'filter_items_list' => __('WP feedBack Filter items list', 'wpfeedback'),
        );
        $args = array(
            'label' => __('Wp feedback Type', 'wpfeedback'),
            'description' => __('Post Type Description', 'wpfeedback'),
            'labels' => $labels,
            'supports' => array('title', 'editor', 'comments', 'author'),
            //'taxonomies'            => array( '', '' ),
            'hierarchical' => false,
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => false,
            'show_in_rest' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-editor-help',
            'show_in_admin_bar' => false,
            'show_in_nav_menus' => false,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'capability_type' => 'page',
        );
        register_post_type('wpfeedback', $args);

    }

    add_action('init', 'wpfeedback_post_type', 0);

}

/*
 * This function is used to register the custom post type "wpf_graphcis" on the website where it is installed.
 *
 * @input NULL
 * @return NULL
 */
if (!function_exists('wpf_graphics_post_type')) {
    // Register Custom Post Type
    function wpf_graphics_post_type() {

        $labels = array(
            'name'                  => _x( 'Graphics Type', 'Post Type General Name', 'wpfeedback' ),
            'singular_name'         => _x( 'Graphics Type', 'Post Type Singular Name', 'wpfeedback' ),
            'menu_name'             => __( 'Graphics Types', 'wpfeedback' ),
            'name_admin_bar'        => __( 'Graphics Type', 'wpfeedback' ),
            'archives'              => __( 'Graphics Archives', 'wpfeedback' ),
            'attributes'            => __( 'Graphics Attributes', 'wpfeedback' ),
            'parent_item_colon'     => __( 'Graphics Parent Item:', 'wpfeedback' ),
            'all_items'             => __( 'Graphics All Items', 'wpfeedback' ),
            'add_new_item'          => __( 'Add Graphics Item', 'wpfeedback' ),
            'add_new'               => __( 'Add New Graphics', 'wpfeedback' ),
            'new_item'              => __( 'Graphics New Item', 'wpfeedback' ),
            'edit_item'             => __( 'Graphics Edit Item', 'wpfeedback' ),
            'update_item'           => __( 'Graphics Update Item', 'wpfeedback' ),
            'view_item'             => __( 'Graphics View Item', 'wpfeedback' ),
            'view_items'            => __( 'Graphics View Items', 'wpfeedback' ),
            'search_items'          => __( 'Search Graphics Item', 'wpfeedback' ),
            'not_found'             => __( 'Not found Graphics', 'wpfeedback' ),
            'not_found_in_trash'    => __( 'Graphics Not found in Trash', 'wpfeedback' ),
            'featured_image'        => __( 'Graphics Featured Image', 'wpfeedback' ),
            'set_featured_image'    => __( 'Graphics Set featured image', 'wpfeedback' ),
            'remove_featured_image' => __( 'Graphics Remove featured image', 'wpfeedback' ),
            'use_featured_image'    => __( 'Graphics Use as featured image', 'wpfeedback' ),
            'insert_into_item'      => __( 'Insert into Graphics item', 'wpfeedback' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'wpfeedback' ),
            'items_list'            => __( 'Graphics Items list', 'wpfeedback' ),
            'items_list_navigation' => __( 'Graphics Items list navigation', 'wpfeedback' ),
            'filter_items_list'     => __( 'Graphics Filter items list', 'wpfeedback' ),
        );
        $args = array(
            'label'                 => __( 'Graphics Type', 'wpfeedback' ),
            'description'           => __( 'Graphics Type Description', 'wpfeedback' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'excerpt', 'thumbnail', 'comments' ),
            'hierarchical'          => false,
            'public'                => false,
            'show_ui'               => true,
            'show_in_menu'          => false,
            'menu_position'         => 6,
            'show_in_admin_bar'     => false,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'rewrite'               => false,
            'capability_type'       => 'page',
            'show_in_rest'          => true,
            'rest_base'             => 'wpf_graphics',
        );
        register_post_type( 'wpf_graphics', $args );

    }
    add_action( 'init', 'wpf_graphics_post_type', 0 );
}

/*
 * This function is used to register the taxonomy "Task Status" on the website where it is installed.
 *
 * @input NULL
 * @return NULL
 */
if (!function_exists('wp_feedback_task_status_taxonomy')) {

// Register Task status Custom Taxonomy
    function wp_feedback_task_status_taxonomy()
    {

        $labels = array(
            'name' => _x('Task status', 'Taxonomy General Name', 'wp_feedback'),
            'singular_name' => _x('Task status', 'Taxonomy Singular Name', 'wp_feedback'),
            'menu_name' => __('Task status', 'wp_feedback'),
            'all_items' => __('All Task status', 'wp_feedback'),
            'parent_item' => __('Parent Item', 'wp_feedback'),
            'parent_item_colon' => __('Parent Item:', 'wp_feedback'),
            'new_item_name' => __('New Task status', 'wp_feedback'),
            'add_new_item' => __('New Task status', 'wp_feedback'),
            'edit_item' => __('Edit Task status', 'wp_feedback'),
            'update_item' => __('Update Task status', 'wp_feedback'),
            'view_item' => __('View Task status', 'wp_feedback'),
            'separate_items_with_commas' => __('Separate items with commas', 'wp_feedback'),
            'add_or_remove_items' => __('Add or remove Task status', 'wp_feedback'),
            'choose_from_most_used' => __('Choose from the most used', 'wp_feedback'),
            'popular_items' => __('Popular Task status', 'wp_feedback'),
            'search_items' => __('Search Task status', 'wp_feedback'),
            'not_found' => __('Not Found Task status', 'wp_feedback'),
            'no_terms' => __('No Task status', 'wp_feedback'),
            'items_list' => __('Task status list', 'wp_feedback'),
            'items_list_navigation' => __('Task status list navigation', 'wp_feedback'),
        );
        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'public' => false,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => false,
            'show_tagcloud' => true,
        );
        register_taxonomy('task_status', array('wpfeedback'), $args);

    }

    add_action('init', 'wp_feedback_task_status_taxonomy', 0);

}

/*
 * This function is used to register the taxonomy "Task Urgency" on the website where it is installed.
 *
 * @input NULL
 * @return NULL
 */
if (!function_exists('wp_feedback_task_priority_taxonomy')) {

// Register Task urgency Custom Taxonomy
    function wp_feedback_task_priority_taxonomy()
    {

        $labels = array(
            'name' => _x('Task urgency', 'Taxonomy General Name', 'wp_feedback'),
            'singular_name' => _x('Task urgency', 'Taxonomy Singular Name', 'wp_feedback'),
            'menu_name' => __('Task urgency', 'wp_feedback'),
            'all_items' => __('All Task urgency', 'wp_feedback'),
            'parent_item' => __('Parent Item', 'wp_feedback'),
            'parent_item_colon' => __('Parent Item:', 'wp_feedback'),
            'new_item_name' => __('New Task urgency', 'wp_feedback'),
            'add_new_item' => __('New Task urgency', 'wp_feedback'),
            'edit_item' => __('Edit Task urgency', 'wp_feedback'),
            'update_item' => __('Update Task urgency', 'wp_feedback'),
            'view_item' => __('View Task urgency', 'wp_feedback'),
            'separate_items_with_commas' => __('Separate items with commas', 'wp_feedback'),
            'add_or_remove_items' => __('Add or remove Task urgency', 'wp_feedback'),
            'choose_from_most_used' => __('Choose from the most used', 'wp_feedback'),
            'popular_items' => __('Popular Task urgency', 'wp_feedback'),
            'search_items' => __('Search Task urgency', 'wp_feedback'),
            'not_found' => __('Not Found Task urgency', 'wp_feedback'),
            'no_terms' => __('No Task urgency', 'wp_feedback'),
            'items_list' => __('Task urgency list', 'wp_feedback'),
            'items_list_navigation' => __('Task urgency list navigation', 'wp_feedback'),
        );
        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'public' => false,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => false,
            'show_tagcloud' => true,
        );
        register_taxonomy('task_priority', array('wpfeedback'), $args);

    }

    add_action('init', 'wp_feedback_task_priority_taxonomy', 0);

}

/*
 * This function is used to register the terms for taxonomy "Task Priority" on the website where it is installed.
 *
 * @input NULL
 * @return NULL
 */
if (!function_exists('wp_feedback_register_task_priority_terms')) {
    function wp_feedback_register_task_priority_terms()
    {
        $taxonomy = 'task_priority';
        $terms = array(
            '0' => array(
                'name' => 'Low',
                'slug' => 'low',
                'description' => '',
            ),
            '1' => array(
                'name' => 'Medium',
                'slug' => 'medium',
                'description' => '',
            ),
            '2' => array(
                'name' => 'High',
                'slug' => 'high',
                'description' => '',
            ),
            '3' => array(
                'name' => 'Critical',
                'slug' => 'critical',
                'description' => '',
            ),
        );

        foreach ($terms as $term_key => $term) {
            if (!term_exists($term['slug'], 'task_priority')) {
                wp_insert_term(
                    $term['name'],
                    $taxonomy,
                    array(
                        'description' => $term['description'],
                        'slug' => $term['slug'],
                    )
                );
            }
            //unset( $term );
        }

    }
}
add_action('wp_loaded', 'wp_feedback_register_task_priority_terms', 0);

/*
 * This function is used to register the terms for taxonomy "Task Status" on the website where it is installed.
 *
 * @input NULL
 * @return NULL
 */
if (!function_exists('wp_feedback_register_task_status_terms')) {
    function wp_feedback_register_task_status_terms()
    {
        $taxonomy = 'task_status';
        $terms = array(
            '0' => array(
                'name' => 'Open',
                'slug' => 'open',
                'description' => '',
            ),
            '1' => array(
                'name' => 'In Progress',
                'slug' => 'in-progress',
                'description' => '',
            ),
            '2' => array(
                'name' => 'Pending Review',
                'slug' => 'pending-review',
                'description' => '',
            ),
            '3' => array(
                'name' => 'Complete',
                'slug' => 'complete',
                'description' => '',
            ),
        );

        foreach ($terms as $term_key => $term) {
            if (!term_exists($term['slug'], 'task_status')) {
                wp_insert_term(
                    $term['name'],
                    $taxonomy,
                    array(
                        'description' => $term['description'],
                        'slug' => $term['slug'],
                    )
                );
            }
            //unset( $term );
        }

    }
}
add_action('wp_loaded', 'wp_feedback_register_task_status_terms', 0);

/*
 * This function is used to register the taxonomy "WPF Tag" on the website where it is installed.
 *
 * @input NULL
 * @return NULL
 */
if (!function_exists('wp_feedback_task_tag')) {

// Register Task status Task tag Taxonomy
    function wp_feedback_task_tag()
    {

        $labels = array(
            'name' => _x('WPF tag', 'Taxonomy General Name', 'wp_feedback'),
            'singular_name' => _x('WPF tag', 'Taxonomy Singular Name', 'wp_feedback'),
            'menu_name' => __('WPF tag', 'wp_feedback'),
            'all_items' => __('All WPF tag', 'wp_feedback'),
            'parent_item' => __('Parent tag', 'wp_feedback'),
            'parent_item_colon' => __('Parent Item:', 'wp_feedback'),
            'new_item_name' => __('New WPF tag', 'wp_feedback'),
            'add_new_item' => __('New WPF tag', 'wp_feedback'),
            'edit_item' => __('Edit WPF tag', 'wp_feedback'),
            'update_item' => __('Update WPF tag', 'wp_feedback'),
            'view_item' => __('View WPF tag', 'wp_feedback'),
            'separate_items_with_commas' => __('Separate items with commas', 'wp_feedback'),
            'add_or_remove_items' => __('Add or remove WPF tag', 'wp_feedback'),
            'choose_from_most_used' => __('Choose from the most used', 'wp_feedback'),
            'popular_items' => __('Popular WPF tag', 'wp_feedback'),
            'search_items' => __('Search WPF tag', 'wp_feedback'),
            'not_found' => __('Not Found WPF tag', 'wp_feedback'),
            'no_terms' => __('No WPF tag', 'wp_feedback'),
            'items_list' => __('WPF tag list', 'wp_feedback'),
            'items_list_navigation' => __('Task tag list navigation', 'wp_feedback'),
        );
        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'public' => false,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => false,
            'show_tagcloud' => true,
            'show_in_rest' => true,
        );
        register_taxonomy('wpf_tag', array('wpfeedback'), $args);

    }
    add_action('init', 'wp_feedback_task_tag', 0);
}

/**
 * Create the admin menu.
 */

/*
 * This function is used to register the admin menu for the WP FeedBack.
 *
 * @input NULL
 * @return NULL
 */
add_action('admin_menu', 'wp_feedback_admin_menu');
function wp_feedback_admin_menu()
{
    global $current_user;
    $wpf_powered_by = get_option('wpf_powered_by');
    $selected_roles = get_option('wpf_selcted_role');
    $selected_roles = explode(',', $selected_roles);

    /*if ( is_multisite() ) {
        $main_menu_id =  'wpfeedback_page_task';
    }
    else{
        $main_menu_id =  'wp_feedback';
    }*/
    $main_menu_id =  'wpfeedback_page_tasks';

    if(array_intersect($current_user->roles, $selected_roles) || current_user_can('administrator')){
        $wpf_user_type = wpf_user_type();
        $badge = '';
        if($wpf_powered_by=='yes'){
            $wpf_main_menu_label = 'FeedBack';
        }
        else{
            $wpf_main_menu_label = 'WP FeedBack PRO';
        }
        add_menu_page(
            __($wpf_main_menu_label, 'wpfeedback'),
            __($wpf_main_menu_label, 'wpfeedback') . $badge,
            'read',
            $main_menu_id,
            $main_menu_id,
            WPF_PLUGIN_URL . 'images/wpf-favicon.png',
            80
        );
        add_submenu_page(
            $main_menu_id,
            __('Tasks Center', 'wpfeedback'),
            __('Tasks Center', 'wpfeedback'),
            'read',
            'wpfeedback_page_tasks',
            'wpfeedback_page_tasks'
        );
        add_submenu_page(
            $main_menu_id,
            __('Graphics', 'wpfeedback'),
            __('Graphics', 'wpfeedback'),
            'read',
            'wpfeedback_page_graphics',
            'wpfeedback_page_graphics'
        );
        if($wpf_user_type == 'advisor' || ($wpf_user_type == '' && current_user_can('administrator') ) ){
            add_submenu_page(
                $main_menu_id,
                __('Settings', 'wpfeedback'),
                __('Settings', 'wpfeedback'),
                'read',
                'wpfeedback_page_settings',
                'wpfeedback_page_settings'
            );
        }
        if($wpf_user_type == 'advisor' || ($wpf_user_type == '' && current_user_can('administrator') )){
            add_submenu_page(
                $main_menu_id,
                __('Permissions', 'wpfeedback'),
                __('Permissions', 'wpfeedback'),
                'read',
                'wpfeedback_page_permissions',
                'wpfeedback_page_permissions'
            );
        }
        if($wpf_user_type == 'advisor' || $wpf_user_type == 'king' || ($wpf_user_type == '' && current_user_can('administrator') ) ){
            add_submenu_page(
                $main_menu_id,
                __('Integrations', 'wpfeedback'),
                __('Integrations', 'wpfeedback'),
                'read',
                'wpfeedback_page_integrate',
                'wpfeedback_page_integrate'
            );
        }

        if($wpf_user_type == 'advisor'  || ($wpf_user_type == '' && current_user_can('administrator') ) ){
            add_submenu_page(
                $main_menu_id,
                __('Support', 'wpfeedback'),
                __('Support', 'wpfeedback'),
                'read',
                'wpfeedback_page_support',
                'wpfeedback_page_support'
            );
            add_submenu_page(
                $main_menu_id,
                __('Upgrade', 'wpfeedback'),
                __('Upgrade', 'wpfeedback'),
                'read',
                'https://wpfeedback.co/wpf-pro/#plans'
            );
        }

    }
}

/*
 * This function is used to set the link for the "Settings" menu item.
 *
 * @input Array
 * @return Array
 */
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'wpf_setting_action_links');
function wpf_setting_action_links($links)
{
    $links[] = '<a href="' . esc_url(get_admin_url(null, 'admin.php?page=wpfeedback_page_settings&wpf_setting=1')) . '">'.__('Settings','wpfeedback').'</a>';
    return $links;
}

/*
 * This function is used used to include the page-settings template for the settings menu if the initial onboarding is already or include wpf_backend_initial_setup if not.
 *
 * @input NULL
 * @return NULL
 */
function wpfeedback_page_settings()
{
    global $current_user;
    $initial_setup = get_option("wpf_initial_setup");
    if($initial_setup != 'yes' ){
        require_once(WPF_PLUGIN_DIR . 'inc/admin/wpf_backend_initial_setup.php');
    }
    else{
        require_once(WPF_PLUGIN_DIR . 'inc/admin/page-settings.php');
    }
}

/*
 * This function is used used to include the page-settings template for the tasks menu.
 *
 * @input NULL
 * @return NULL
 */
function wpfeedback_page_tasks()
{
    global $current_user;
    require_once(WPF_PLUGIN_DIR . 'inc/admin/page-settings.php');
}

/*
 * This function is used used to include the page-settings template for the integration menu.
 *
 * @input NULL
 * @return NULL
 */
function wpfeedback_page_integrate()
{
    global $current_user;
    require_once(WPF_PLUGIN_DIR . 'inc/admin/page-settings.php');
}

/*
 * This function is used used to include the page-settings template for the support menu.
 *
 * @input NULL
 * @return NULL
 */
function wpfeedback_page_support(){
    global $current_user;
    require_once(WPF_PLUGIN_DIR . 'inc/admin/page-settings.php');
}

/*
 * This function is used used to include the page-settings-permissions template for the Permissions menu.
 *
 * @input NULL
 * @return NULL
 */
function wpfeedback_page_permissions(){
    global $current_user;
    require_once(WPF_PLUGIN_DIR . 'inc/admin/page-settings-permissions.php');
}

/*
 * This function is used used to include the page-settings-graphics template for the graphics menu.
 *
 * @input NULL
 * @return NULL
 */
function wpfeedback_page_graphics(){
    global $current_user;
    require_once(WPF_PLUGIN_DIR . 'inc/admin/page-settings-graphics.php');
}

/*
* Require admin functionality
*/
require_once(WPF_PLUGIN_DIR . 'inc/wpf_ajax_functions.php');
require_once(WPF_PLUGIN_DIR . 'inc/wpf_function.php');
require_once(WPF_PLUGIN_DIR . 'inc/wpf_email_notifications.php');
require_once(WPF_PLUGIN_DIR . 'inc/wpf_admin_functions.php');
require_once(WPF_PLUGIN_DIR . 'inc/admin/wpf_admin_function.php');
require_once(WPF_PLUGIN_DIR . 'inc/wpf_api.php');

if (!class_exists('EDD_SL_Plugin_Updater')) {
    // load our custom updater if it doesn't already exist
    include(dirname(__FILE__) . '/inc/EDD_SL_Plugin_Updater.php');
}

$wpf_image_cache = WPF_PLUGIN_DIR . "cache/";
if (!file_exists($wpf_image_cache)) {
    mkdir($wpf_image_cache, 0777, true);
}

// retrieve our license key from the DB
$wpf_license_key = trim(get_option('wpf_license_key'));
$wpf_decry_key = wpf_crypt_key($wpf_license_key,'d');
// setup the updater
$edd_updater = new EDD_SL_Plugin_Updater(WPF_EDD_SL_STORE_URL, __FILE__, array(
    'version' => WPF_VERSION,        // current version number
    'license' => $wpf_decry_key,    // license key (used get_option above to retrieve from DB)
    'item_id' => WPF_EDD_SL_ITEM_ID,    // id of this plugin
    'author' => 'Ace Digital London',    // author of this plugin
    'url' => WPF_SITE_URL,
    'beta' => false // set to true if you wish customers to receive update notifications of beta releases
));

if (is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX)) {
    /*
     * Verify license
     */
    $wpf_license_key = get_option('wpf_license_key');
    $wpf_license = get_option('wpf_license');
    $date_now = date("Y-m-d",strtotime("+3 day"));
    $wpf_check_license_date = get_option('wpf_check_license_date');

    if ($date_now > $wpf_check_license_date || $wpf_check_license_date == '') {
        update_option('wpf_check_license_date',$date_now,'no');
        if($wpf_license == 'valid' ){
            $outputObject = wpf_license_key_check_item($wpf_license_key);
            if($outputObject['executed']==1){
                if ($outputObject['license'] == 'valid') {
                    update_option('wpf_license', $outputObject['license'],'no');
                    update_option('wpf_license_expires', $outputObject['expires'],'no');
                    if(!get_option('wpf_decr_key')){
                        update_option('wpf_decr_key', $outputObject['payment_id'],'no');
                        update_option('wpf_decr_checksum', $outputObject['checksum'],'no');
                        $wpf_crypt_key = wpf_crypt_key($wpf_license_key,'e');
                        update_option('wpf_license_key',$wpf_crypt_key,'no');
                    }
                } else {
                    update_option('wpf_license', $outputObject['license'],'no');
                }
            }
        }
    }

    $wpf_license = get_option('wpf_license');
    if($wpf_license == 'site_inactive' && $wpf_license_key != ''){
        $outputObject = wpf_license_key_license_item($wpf_license_key);
        if($outputObject['executed']==1){
            if ($outputObject['license'] == 'valid') {
                update_option('wpf_license', $outputObject['license'],'no');
                update_option('wpf_license_expires', $outputObject['expires'],'no');
                if(!get_option('wpf_decr_key')){
                    update_option('wpf_decr_key', $outputObject['payment_id'],'no');
                    update_option('wpf_decr_checksum', $outputObject['checksum'],'no');
                    $wpf_crypt_key = wpf_crypt_key($wpf_license_key,'e');
                    update_option('wpf_license_key',$wpf_crypt_key,'no');
                }
            }
        }
    }


    if(get_option('wpf_tab_permission_user_client')===false){
        update_option('wpf_tab_permission_user_client', 'yes', 'no');
        update_option('wpf_tab_permission_user_webmaster', 'yes', 'no');
        update_option('wpf_tab_permission_user_others', 'yes', 'no');

        update_option('wpf_tab_permission_priority_client', 'yes', 'no');
        update_option('wpf_tab_permission_priority_webmaster', 'yes', 'no');
        update_option('wpf_tab_permission_priority_others', '', 'no');

        update_option('wpf_tab_permission_status_client', '', 'no');
        update_option('wpf_tab_permission_status_webmaster', 'yes', 'no');
        update_option('wpf_tab_permission_status_others', '', 'no');

        update_option('wpf_tab_permission_screenshot_client', 'yes', 'no');
        update_option('wpf_tab_permission_screenshot_webmaster', 'yes', 'no');
        update_option('wpf_tab_permission_screenshot_others', 'yes', 'no');

        update_option('wpf_tab_permission_information_client', 'yes', 'no');
        update_option('wpf_tab_permission_information_webmaster', 'yes', 'no');
        update_option('wpf_tab_permission_information_others', 'yes', 'no');

        update_option('wpf_tab_permission_delete_task_client', '', 'no');
        update_option('wpf_tab_permission_delete_task_webmaster', 'yes', 'no');
        update_option('wpf_tab_permission_delete_task_others', '', 'no');
    }

    if(get_option('wpf_tab_permission_user_guest')===false){
        update_option('wpf_tab_permission_user_guest', '', 'no');
        update_option('wpf_tab_permission_priority_guest', '', 'no');
        update_option('wpf_tab_permission_status_guest', '', 'no');
        update_option('wpf_tab_permission_screenshot_guest', 'yes', 'no');
        update_option('wpf_tab_permission_information_guest', 'yes', 'no');
        update_option('wpf_tab_permission_delete_task_guest', '', 'no');
    }

    if(get_option('wpf_tab_auto_screenshot_task_client')===false){
        update_option('wpf_tab_auto_screenshot_task_client', 'yes', 'no');
    }
    if(get_option('wpf_tab_auto_screenshot_task_webmaster')===false){
        update_option('wpf_tab_auto_screenshot_task_webmaster', 'yes', 'no');
    }
    if(get_option('wpf_tab_auto_screenshot_task_others')===false){
        update_option('wpf_tab_auto_screenshot_task_others', 'yes', 'no');
    }
    if(get_option('wpf_tab_auto_screenshot_task_guest')===false){
        update_option('wpf_tab_auto_screenshot_task_guest', 'yes', 'no');
    }
}

/*
 * This function is used to detect if the page builder is initialized on the current running page and deregister the WP FeedBack of found running.
 *
 * @input NULL
 * @return NULL
 */
add_action('wp_enqueue_scripts', 'wpfeedback_add_stylesheet_frontend');
function wpfeedback_add_stylesheet_frontend()
{
    $wpf_check_page_builder_active = wpf_check_page_builder_active();
    /*=====Start Check customize.php====*/
    if($wpf_check_page_builder_active == 0){
        if ( is_customize_preview() ) {
            $wpf_check_page_builder_active =1;
        }
        else {
            $wpf_check_page_builder_active = 0;
        }
    }
    /*=====END check customize.php====*/
    $enabled_wpfeedback = wpf_check_if_enable();
    $wpf_allow_guest = get_option('wpf_allow_guest');
    $wpf_enabled = get_option('wpf_enabled');
    if($wpf_enabled == 'yes' ){

        if(!is_user_logged_in()){
            wp_register_style('wpf_login_style', WPF_PLUGIN_URL . 'css/wpf-login.css', false, WPF_VERSION);
            wp_enqueue_style('wpf_login_style');
        }

        if(is_singular('wpf_graphics')){
            wp_register_style('wpf-graphics-front-style', WPF_PLUGIN_URL . 'css/graphics-front.css', false, WPF_VERSION);
            wp_enqueue_style('wpf-graphics-front-style');
        }

        wp_register_script('wpf_jquery_script', WPF_PLUGIN_URL . 'js/jquery3.5.1.js', array('jquery'), WPF_VERSION, false);
        wp_enqueue_script('wpf_jquery_script');

        wp_register_script('wpf-ajax-login', WPF_PLUGIN_URL.'js/wpf-ajax-login.js', array('jquery'), WPF_VERSION,true);
        wp_enqueue_script('wpf-ajax-login');

        wp_localize_script( 'wpf-ajax-login', 'wpf_ajax_login_object', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'wpf_reconnect_icon' => WPF_PLUGIN_URL.'images/wpf_reconnect.png',
            'redirecturl' => home_url(),
            'loadingmessage' => __('Sending user info, please wait...')
        ));
    }
    if ($enabled_wpfeedback==1) {

        wp_register_style('wpf_wpf-icons', WPF_PLUGIN_URL . 'css/wpf-icons.css', false, WPF_VERSION);
        wp_enqueue_style('wpf_wpf-icons');

        wp_register_style('wpf_wpfb-front_script', WPF_PLUGIN_URL . 'css/wpfb-front.css', false, WPF_VERSION);
        wp_enqueue_style('wpf_wpfb-front_script');

        wp_register_style('wpf_bootstrap_script', WPF_PLUGIN_URL . 'css/bootstrap.min.css', false, WPF_VERSION);
        wp_enqueue_style('wpf_bootstrap_script');
        if ($wpf_check_page_builder_active == 0) {

            wp_register_script('wpf_jquery_ui_script', WPF_PLUGIN_URL . 'js/jquery-ui.js', array('jquery'), WPF_VERSION, true);
            wp_enqueue_script('wpf_jquery_ui_script');

            wp_register_script('wpf_touch_mouse_script', WPF_PLUGIN_URL.'js/jquery.ui.mouse.min.js', array('jquery'), WPF_VERSION, true);
            wp_enqueue_script('wpf_touch_mouse_script');

            wp_register_script('wpf_touch_punch_script', WPF_PLUGIN_URL.'js/jquery.ui.touch-punch.js', array('jquery'), WPF_VERSION, true);
            wp_enqueue_script('wpf_touch_punch_script');


            wp_register_script('wpf_browser_info_script', WPF_PLUGIN_URL . 'js/wpf_browser_info.js', array('jquery'), WPF_VERSION, true);
            wp_enqueue_script('wpf_browser_info_script');

            if(is_singular('wpf_graphics')){
                wp_register_script('wpf-graphics-front-script', WPF_PLUGIN_URL . 'js/app_graphics.js', array('jquery'), WPF_VERSION, true);
                wp_enqueue_script('wpf-graphics-front-script');
                wp_enqueue_media();
            }
            else{
                wp_register_script('wpf_app_script', WPF_PLUGIN_URL . 'js/app.js', array('jquery'), WPF_VERSION, true);
                wp_enqueue_script('wpf_app_script');
            }

            wp_register_script('wpf_html2canvas_script', WPF_PLUGIN_URL . 'js/html2canvas.js', array('jquery'), WPF_VERSION, true);
            wp_enqueue_script('wpf_html2canvas_script');

            wp_register_script('wpf_popper_script', WPF_PLUGIN_URL . 'js/popper.min.js', array('jquery'), WPF_VERSION, true);
            wp_enqueue_script('wpf_popper_script');

            wp_register_script('wpf_custompopover_script', WPF_PLUGIN_URL . 'js/custompopover.js', array('jquery'), WPF_VERSION, true);
            wp_enqueue_script('wpf_custompopover_script');

            wp_register_script('wpf_selectoroverlay_script', WPF_PLUGIN_URL . 'js/selectoroverlay.js', array('jquery'), WPF_VERSION, true);
            wp_enqueue_script('wpf_selectoroverlay_script');

            wp_register_script('wpf_common_functions', WPF_PLUGIN_URL . 'js/wpf_common_functions.js', array('jquery'), WPF_VERSION, true);
            wp_enqueue_script('wpf_common_functions');

            wp_register_script('wpf_xyposition_script', WPF_PLUGIN_URL . 'js/xyposition.js', array('jquery'), WPF_VERSION, true);
            wp_enqueue_script('wpf_xyposition_script');

            wp_register_script('wpf_bootstrap_script', WPF_PLUGIN_URL . 'js/bootstrap.min.js', array('jquery'), WPF_VERSION, true);
           //if(! defined( 'AVADA_VERSION' )){
                wp_enqueue_script('wpf_bootstrap_script');
            //}

        }
    }
}

/*
 * This function is used to create the security nonce every time a user requests the WP FeedBack.
 *
 * @input NULL
 * @return String
 */
function wpf_wp_create_nonce(){
    global $post;
    $wpf_allow_guest = get_option('wpf_allow_guest');
    if(is_user_logged_in() || $wpf_allow_guest == 'yes'){
        $wpf_nonce = wp_create_nonce( 'wpfeedback-script-nonce' );
        return $wpf_nonce;
    }
    if ( is_singular('wpf_graphics') && !is_user_logged_in() && $wpf_allow_guest != 'yes') {
        $wpf_nonce = wp_create_nonce( 'wpfeedback-script-nonce' );
        return $wpf_nonce;
    }

}

/*==========All Java script for Admin footer=========*/
/*
 * This function is used to initial the WP FeedBack and all related variables on the backend.
 *
 * @input NULL
 * @return NULL
 */
add_action('admin_footer', 'wpf_backed_scripts');
function wpf_backed_scripts()
{
    global $wpdb,$post, $current_user; //for this example only :)
    $author_id = $current_user->ID;
    $my_saved_attachment_post_id = get_option('wpfeedback_logo_id', 0);
    $wpf_user_type = wpf_user_type();

    $currnet_user_information = wpf_get_current_user_information();
    $current_role = $currnet_user_information['role'];
    $current_user_name = $currnet_user_information['display_name'];
    $current_user_id = $currnet_user_information['user_id'];
    $wpf_website_builder = get_option('wpf_website_developer');
    if($current_user_name=='Guest'){
        $wpf_website_client = get_option('wpf_website_client');
        $wpf_current_role = 'guest';
        if($wpf_website_client){
            $wpf_website_client_info = get_userdata($wpf_website_client);
            if($wpf_website_client_info){
                if($wpf_website_client_info->display_name==''){
                    $current_user_name = $wpf_website_client_info->user_nicename;
                }
                else{
                    $current_user_name = $wpf_website_client_info->display_name;
                }
            }
        }

    }
    $current_user_name = addslashes($current_user_name);
    $wpf_show_front_stikers = get_option('wpf_show_front_stikers');

    $wpfb_users = do_shortcode('[wpf_user_list_front]');
    $wpf_all_pages = wpf_get_page_list();
    $ajax_url = admin_url('admin-ajax.php');
    $plugin_url = WPF_PLUGIN_URL;
    $wpf_comment_time = date( 'd-m-Y H:i', current_time( 'timestamp', 0 ) );
    $wpf_nonce = wpf_wp_create_nonce();
    $sound_file = esc_url(plugins_url('images/wpf-screenshot-sound.mp3', __FILE__));

//    Old logic to count latest task bubble number, was changed after the delete task feature was introduced
//    $comment_count_obj = wp_count_posts('wpfeedback');
//    $comment_count = $comment_count_obj->publish + 1;

    $table =  $wpdb->prefix . 'postmeta';
    $latest_count = $wpdb->get_results("SELECT meta_value FROM $table WHERE meta_key = 'task_comment_id' ORDER BY meta_id DESC LIMIT 1 ");
    if($latest_count){
        $comment_count = $latest_count[0]->meta_value + 1;
    }
    else{
        $comment_count = 1;
    }

    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';



    echo "<script>var wpf_nonce='$wpf_nonce',wpf_comment_time='$wpf_comment_time',wpf_all_pages ='$wpf_all_pages' ,ipaddress='$ipaddress', current_role='$current_role', wpf_current_role='$wpf_user_type', current_user_name='$current_user_name', current_user_id='$current_user_id', wpf_website_builder='$wpf_website_builder', wpfb_users = '$wpfb_users',  ajaxurl = '$ajax_url', wpf_screenshot_sound = '$sound_file', plugin_url = '$plugin_url', comment_count='$comment_count', wpf_show_front_stikers='$wpf_show_front_stikers';</script>";
    if (isset($_REQUEST['page'])) {
        if ($_REQUEST['page'] == 'wpfeedback_page_settings' || $_REQUEST['page'] == 'wpfeedback_page_tasks' || $_REQUEST['page'] == 'wpfeedback_page_integrate' || $_REQUEST['page'] == 'wpfeedback_page_upgrade' || $_REQUEST['page'] == 'wpfeedback_page_support' || $_REQUEST['page'] == 'wpfeedback_page_permissions' || $_REQUEST['page'] == 'wpfeedback_page_graphics') {
            ?>
            <script type='text/javascript'>
                var current_task = 0;
                var current_user_id = "<?php echo $author_id; ?>";
                var wpf_user_type = "<?php echo $wpf_user_type; ?>";

                function getParameterByName(name) {
                    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
                    var regexS = "[\\?&]" + name + "=([^&#]*)";
                    var regex = new RegExp(regexS);
                    var results = regex.exec(window.location.href);
                    if (results == null)
                        return "";
                    else
                        return decodeURIComponent(results[1].replace(/\+/g, " "));
                }

                /*
                * wpf task filter code
                */
                function wp_feedback_cat_filter() {
                    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
                    var task_types = [];
                    var task_title = jQuery('#wpf_tasks #wpf_search_title').val();
                    var task_types_meta = [];
                    jQuery.each(jQuery("#wpf_filter_form input[name='task_types']:checked"), function () {
                        task_types.push(jQuery(this).val());
                    });
                    var selected_task_types_values = task_types.join(",");

                    jQuery.each(jQuery("#wpf_filter_form input[name='task_types_meta']:checked"), function () {
                        task_types_meta.push(jQuery(this).val());
                    });
                    var selected_task_types_meta_values = task_types_meta.join(",");

                    var task_status = [];
                    jQuery.each(jQuery("#wpf_filter_form input[name='task_status']:checked"), function () {
                        task_status.push(jQuery(this).val());
                    });
                    //alert("My task status are: " + task_status.join(","));
                    var selected_task_status_values = task_status.join(",");

                    var task_priority = [];
                    jQuery.each(jQuery("#wpf_filter_form input[name='task_priority']:checked"), function () {
                        task_priority.push(jQuery(this).val());
                    });
                    // alert("My task urgency are: " + task_priority.join(","));
                    var selected_task_priority_values = task_priority.join(",");

                    var author_list = [];
                    jQuery.each(jQuery("#wpf_filter_form input[name='author_list']:checked"), function () {
                        author_list.push(jQuery(this).val());
                    });
                    // alert("My task urgency are: " + task_priority.join(","));
                    var selected_author_list_values = author_list.join(",");
                    //if(selected_task_status_values || selected_task_priority_values || selected_author_list_values){
                    jQuery.ajax({
                        method: "POST",
                        url: ajaxurl,
                        data: {
                            action: "wpfeedback_get_post_list_ajax",
                            wpf_nonce:wpf_nonce,
                            task_title:task_title,
                            task_types: selected_task_types_values,task_types_meta: selected_task_types_meta_values,
                            task_status: selected_task_status_values,
                            task_priority: selected_task_priority_values,
                            author_list: selected_author_list_values
                        },
                        beforeSend: function () {
                            jQuery('.wpf_loader_admin').show();
                        },
                        success: function (data) {
                            //Comment
                            jQuery('#wpf_display_all_taskmeta_tasktab').prop('checked',false);
                            jQuery('.wpf_loader_admin').hide();
                            jQuery('.wpf_tasks_col .wpf_tasks-list').html(data);
                            if(document.getElementById('wpf_task_bulk_tab').checked) {
                                jQuery('.wpf_task_num_top').hide();
                                jQuery('#wpf_task_all_tab').removeClass('active');
                                jQuery('ul#all_wpf_list li .wpf_task_id').addClass('wpf_active');
                                jQuery('ul#all_wpf_list #wpf_bulk_select_task_checkbox').addClass('wpf_active');
                                jQuery('#wpf_bulk_select_task_checkbox').show();
                            }
                            /*console.log(data);*/
                        }
                    });
                    // }
                }

                function get_wpf_message_form(comment_post_ID, curren_user_id) {
                    var html = '<div id="wpf_chat_box"><form action="" method="post" id="wpf_form" class="comment-form" enctype="multipart/form-data"><p class="comment-form-comment"><textarea placeholder="'+wpf_comment_box_placeholder+'" id="wpf_comment" name="comment" maxlength="65525" required="required"></textarea><input type="hidden" name="comment_post_ID" value="' + comment_post_ID + '" id="comment_post_ID">  <input type="hidden" name="curren_user_id" value="' + curren_user_id + '" id="curren_user_id"><p class="form-submit chat_button"><input name="submit" type="button" id="send_chat" onclick="send_chat_message()" class="submit wpf_button submit" value="'+wpf_send_message_text+'"><a href="javascript:void(0)" class="wpf_upload_button wpf_button" onchange="wpf_upload_file_admin('+comment_post_ID+');"><input type="file" name="wpf_uploadfile" id="wpf_uploadfile" data-elemid="'+comment_post_ID+'" class="wpf_uploadfile"><i class="gg-attachment"></i></a></p><p id="wpf_upload_error" class="wpf_hide">You are trying to upload an invalid filetype <br> Allowd File Types: JPG, PNG, GIF, PDF, DOC, DOCX and XLSX</p></form></div></div>';
                    return html;
                }
                function send_chat_message() {
                    jQuery("#get_masg_loader").show();
                    jQuery(".get_masg_loader").show();
                    var wpf_comment = jQuery('#wpf_comment').val();
                    var post_id = jQuery('#comment_post_ID').val();
                    var author_id = "<?php echo $author_id; ?>";
                    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
                    var task_notify_users = [];
                    jQuery.each(jQuery('#wpf_attributes_content input[name="author_list_task"]:checked'), function () {
                        task_notify_users.push(jQuery(this).val());
                    });
                    task_notify_users = task_notify_users.join(",");

                    if (jQuery('#wpf_comment').val().trim().length > 0) {
                        jQuery.ajax({
                            method: "POST",
                            url: ajaxurl,
                            data: {
                                action: "insert_wpf_comment_func",
                                wpf_nonce:wpf_nonce,
                                post_id: post_id,
                                author_id: author_id,
                                task_notify_users : task_notify_users,
                                wpf_comment: wpf_comment
                            },
                            beforeSend: function () {
                                jQuery('.wpf_loader_admin').show();
                            },
                            success: function (data) {
                                jQuery('.wpf_loader_admin').hide();
                                jQuery("#wpf_not_found").remove();
                                //jQuery("#tag_post").remove();
                                jQuery("#tag_post").html('');
                                if (jQuery('#wpf_message_list li').length == 0) {
                                    jQuery('ul#wpf_message_list').html(data);
                                } else {
                                    jQuery('ul#wpf_message_list li:last').after(data);
                                }
                                jQuery("#wpf_comment").val("");
                                jQuery("#addcart_loader").fadeOut();
                                jQuery("#get_masg_loader").hide();
                                jQuery(".get_masg_loader").hide();
                                jQuery('#wpf_message_content').animate({scrollTop: jQuery('#wpf_message_content').prop("scrollHeight")}, 2000);
                                if(jQuery( "#task_task_status_attr" ).val()=='complete'){
                                    jQuery("#task_task_status_attr").val("open");
                                    var obj = document.getElementById("task_task_status_attr");
                                    task_status_changed(obj);
                                }
                            }
                        })
                    } else {
                        jQuery("#get_masg_loader").hide();
                        jQuery('ul#wpf_message_list').animate({scrollTop: jQuery("ul#wpf_message_list li").last().offset().top}, 1000);
                        jQuery("#wpf_comment").focus();
                        jQuery("#get_masg_loader").hide();
                    }
                }

                function task_status_changed(sel) {
                    var task_info = [];
                    var task_notify_users = [];

                    jQuery.each(jQuery('#wpf_attributes_content input[name="author_list_task"]:checked'), function () {
                        task_notify_users.push(jQuery(this).val());
                    });
                    task_notify_users = task_notify_users.join(",");

                    task_info['task_id'] = current_task;
                    task_info['task_status'] = sel.value;
                    task_info['task_notify_users'] = task_notify_users;
                    var wpf_task_id =  jQuery('#wpf_task_details .wpf_task_num_top').text()

                    var task_info_obj = jQuery.extend({}, task_info);
                    jQuery.ajax({
                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                        type: 'POST',
                        data: {action: "wpfb_set_task_status",wpf_nonce:wpf_nonce, task_info: task_info_obj},
                        beforeSend: function () {
                            jQuery('.wpf_loader_admin').show();
                        },
                        success: function (data) {
                            // alert(data);wpf_get_page_list
                            jQuery("#wpf-task-"+ current_task+" .wpf_task_label .task_status").removeClass().addClass("task_status wpf_"+sel.value);
                            
                            jQuery('.wpf_loader_admin').hide();
                            jQuery('#wpf-task-' + current_task).data('task_status', sel.value);

                             if(sel.value == 'complete'){
                                jQuery('#all_wpf_list .post_' + current_task).addClass('complete');
                                jQuery('#all_wpf_list .post_' + current_task + ' .wpf_task_num_top').html('<i class="gg-check"></i>');
                                jQuery('#wpf_task_details #wpf_task_num_top').html('<i class="gg-check"></i>');
                                jQuery('#wpf_task_details .wpf_task_num_top').addClass('complete');

                            }else{
                                jQuery('#all_wpf_list .post_' + current_task).removeClass('complete');
                                 jQuery('#all_wpf_list .post_' + current_task + ' .wpf_task_num_top').html(wpf_task_id);
                                jQuery('#wpf_task_details .wpf_task_num_top').html(wpf_task_id);
                                jQuery('#wpf_task_details .wpf_task_num_top').removeClass('complete');
                            }
                        }
                    });
                }

                function task_priority_changed(sel) {
                    // alert(sel.value);
                    var task_info = [];
                    var task_priority = sel.value;


                    task_info['task_id'] = current_task;
                    task_info['task_priority'] = task_priority;

                    var task_info_obj = jQuery.extend({}, task_info);
                    jQuery.ajax({
                        method: "POST",
                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                        data: {action: "wpfb_set_task_priority",wpf_nonce:wpf_nonce, task_info: task_info_obj},
                        beforeSend: function () {
                            jQuery('.wpf_loader_admin').show();
                        },
                        success: function (data) {
                            // alert(data);
                            jQuery("#wpf-task-" +current_task+ " .wpf_task_label .task_priority").removeClass().addClass("task_priority wpf_"+sel.value);

                            jQuery('.wpf_loader_admin').hide();
                            
                            jQuery('#wpf-task-' + current_task).data('task_priority', sel.value);
                           // jQuery('#wpf-task-' + current_task).data('task_priority', sel.value);
                        }
                    });
                }

                function update_notify_user(user_id) {
                    var task_info = [];
                    var task_notify_users = [];

                    jQuery.each(jQuery('#wpf_attributes_content input[name="author_list_task"]:checked'), function () {
                        task_notify_users.push(jQuery(this).val());
                    });
                    task_notify_users = task_notify_users.join(",");

                    task_info['task_id'] = current_task;
                    task_info['task_notify_users'] = task_notify_users;

                    var task_info_obj = jQuery.extend({}, task_info);

                    jQuery.ajax({
                        method: "POST",
                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                        data: {action: "wpfb_set_task_notify_users",wpf_nonce:wpf_nonce, task_info: task_info_obj},
                        beforeSend: function () {
                            jQuery('.wpf_loader_admin').show();
                        },
                        success: function (data) {
                            // alert(data);
                            jQuery('.wpf_loader_admin').hide();
                            jQuery('#wpf-task-' + current_task).data('task_notify_users', task_notify_users);
                        }
                    });
                }

                //get chat based on WPF post select
                function get_wpf_chat(obj, tg) {
                    jQuery("#wpf_edit_title").show();
                    jQuery("#wpf_task_tabs_container").show();
                    jQuery("#wpf_edit_title_box").hide();
                    jQuery("#wpf_title_val").val();
                    var post_id = jQuery(obj).data("postid");
                    if (tg === undefined) {
                        tg = false;
                    }
                    jQuery("ul#all_wpf_list li.wpf_list").removeClass('active');
                    jQuery(obj).parent().addClass('active');
                    //alert(jQuery(obj).data("postid"));
                    //var post_author_id = <?php echo $author_id; ?>;
                    var post_author_id = jQuery(obj).data('uid');
                    var post_task_type = jQuery(obj).data('task_type');
                    var post_task_status = jQuery(obj).data('wpf_task_status');
                    var post_task_no = jQuery(obj).data("task_no");
                    var task_status = jQuery(obj).data("task_status");
                    var task_page_url = jQuery(obj).data("task_page_url");
                    var wpf_task_screenshot = jQuery(obj).data("wpf_task_screenshot");

                    var task_page_title = jQuery(obj).data("task_page_title");
                    var task_config_author_name = jQuery(obj).data("task_config_author_name");
                    var task_author_name = jQuery(obj).data("task_author_name");


                    var task_config_author_res = jQuery(obj).data("task_config_author_res");
                    var task_config_author_browser = jQuery(obj).data("task_config_author_browser");
                    var task_config_author_browserversion = jQuery(obj).data("task_config_author_browserversion");
                    var task_config_author_ipaddress = jQuery(obj).data("task_config_author_ipaddress");
                    var task_config_author_name = jQuery(obj).data("task_config_author_name");
                    var task_notify_users = jQuery(obj).data("task_notify_users");

                    var task_priority = jQuery(obj).data("task_priority");
                    var click = 'yes';
                    var additional_info_html = '<p>'+wpf_resolution+' ' + task_config_author_res + '</p><p>'+wpf_browser+' ' + task_config_author_browser + ' ' + task_config_author_browserversion + '</p><p>'+wpf_user_name+' ' + task_author_name + '</p><p>'+wpf_user_ip+' ' + task_config_author_ipaddress + '</p><p>'+wpf_task_id+' ' + post_id + '</p>';
                    jQuery.ajax({
                        method: "POST",
                        url: ajaxurl,
                        data: {
                            action: "list_wpf_comment_func",
                            wpf_nonce:wpf_nonce,
                            post_id: post_id,
                            post_author_id: post_author_id,
                            click: click
                        },
                        beforeSend: function () {
                            jQuery('.wpf_loader_admin').show();
                        },
                        success: function (data) {
                            onload_wpfb_tasks = JSON.parse(data);
                            current_task = post_id;
                            wpf_tag_autocomplete(document.getElementById("wpf_tags"), wpf_all_tags);
                            jQuery('.wpf_loader_admin').hide();
                            jQuery("#wpf_not_found").remove();
                            // console.log(task_status);
                            jQuery("#get_masg_loader").hide();
                            jQuery("div#wpf_task_details .wpf_task_num_top").html(post_task_no);
                            jQuery('#wpf_task_details .wpf_task_num_top').removeClass('complete');
                            jQuery('#wpf_task_details .wpf_task_num_top').addClass(task_status);
                            jQuery("div#wpf_task_details .wpf_task_title_top").html(task_page_title);
                            jQuery("div#wpf_task_details .wpf_task_details_top").html(task_config_author_name);
                            jQuery("div#wpf_attributes_content #additional_information").html(additional_info_html);
                            if(current_user_id == post_author_id || wpf_user_type == 'advisor'){
                                jQuery('#wpf_delete_task_container').html('<a href="javascript:void(0)" class="wpf_task_delete_btn"><i class="gg-trash"></i> '+wpf_delete_ticket+'</a><p class="wpf_hide" id="wpf_task_delete">'+wpf_delete_conform_text2+' <a href="javascript:void(0);" class="wpf_task_delete" data-taskid='+ post_id +' data-elemid='+post_task_no+'>'+wpf_yes+'</a></p>');
                            }else{
                                jQuery('#wpf_delete_task_container').html('');
                            }
                            jQuery("#task_task_status_attr").val(task_status);
                            jQuery("#task_task_priority_attr").val(task_priority);

                            var wpf_page_url=task_page_url;
                            if(wpf_page_url &&  post_task_status == 'wpf_admin'){
                                var wpf_page_url_with_and=wpf_page_url.split('&')[1];
                                var wpf_page_url_question=wpf_page_url.split('?')[1];
                                if(wpf_page_url_with_and){
                                    var saperater = '&';
                                }
                                if(wpf_page_url_question){
                                    var saperater = '&';
                                }
                                else{
                                    var saperater = '?';
                                }
                            }else{
                                var saperater = '?';
                            }
                            if(wpf_task_screenshot == ''){
                                wpf_open_tab('wpf_message_content');
                            }

                            if(post_task_type == 'general'){
                                jQuery("#wpfb_attr_task_page_link").attr("href", task_page_url+saperater+"wpf_general_taskid="+post_id);
                            }else if(post_task_type == 'graphics'){
                                wpf_open_tab('wpf_message_content');
                                jQuery("#wpfb_attr_task_page_link").attr("href", task_page_url+"&wpf_taskid="+post_task_no);
                            }
                            else{
                                jQuery("#wpfb_attr_task_page_link").attr("href", task_page_url+saperater+"wpf_taskid="+post_task_no);
                            }


                            if(typeof task_notify_users=='string'){
                                var task_notify_users_arr = task_notify_users.split(',');
                            }
                            else{
                                var task_notify_users_arr = [task_notify_users.toString()];
                            }
                            jQuery('#wpf_attributes_content input[name="author_list_task"]').each(function () {
                                jQuery(this).prop('checked', false);
                            });
                            jQuery('#wpf_attributes_content input[name="author_list_task"]').each(function () {
                                if (jQuery.inArray(this.value, task_notify_users_arr) != '-1') {
                                    jQuery(this).prop('checked', true);
                                }
                            });

                            chat_form = get_wpf_message_form(post_id, post_author_id);
                            jQuery('#wpf_message_form').html(chat_form);
                            if (onload_wpfb_tasks.data == 0) {
                                chat_form = get_wpf_message_form(post_id, post_author_id);
                                jQuery('#wpf_message_form').html(chat_form);
                            } else {
                                var chat_form = get_wpf_message_form(post_id, post_author_id);
                                jQuery('#wpf_message_form').html(chat_form);
                                jQuery('ul#wpf_message_list').html(onload_wpfb_tasks.data);
                                jQuery('#wpf_task_screenshot').attr('src',wpf_task_screenshot);
                                jQuery('#wpf_task_screenshot_link').attr('href',wpf_task_screenshot);
                                jQuery('#all_tag_list').html(onload_wpfb_tasks.wpf_tags);
                            }
                            jQuery('#wpf_message_content').animate({scrollTop: jQuery('#wpf_message_content').prop("scrollHeight")}, 2000);
                        }
                    });
                }

                jQuery(document).ready(function ($) {
                    var wpfeedback_page = getParameterByName('page');
                    if (wpfeedback_page == "wpfeedback_page_tasks") {
                        jQuery("button.wpf_tab_item.wpf_tasks").trigger('click');
                    }
                    if (wpfeedback_page == "wpfeedback_page_settings") {
                        jQuery("button.wpf_tab_item.wpf_settings").trigger('click');
                    }
                    if (wpfeedback_page == "wpfeedback_page_integrate") {
                        jQuery("button.wpf_tab_item.wpf_addons").trigger('click');
                    }
                    if (wpfeedback_page == "wpfeedback_page_support") {
                        jQuery("button.wpf_tab_item.wpf_support").trigger('click');
                    }
                    if (wpfeedback_page == "wpfeedback_page_permissions") {
                        jQuery("button.wpf_tab_item.wpf_misc").trigger('click');
                    }
                    if (wpfeedback_page == "wpfeedback_page_graphics") {
                        jQuery("button.wpf_tab_item.wpf_graphics").trigger('click');
                    }

                    // Uploading files
                    var file_frame;
                    if(wp.media!=undefined){
                        var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
                        var set_to_post_id = <?php echo $my_saved_attachment_post_id; ?>; // Set this
                        jQuery('#upload_image_button').on('click', function (event) {
                            event.preventDefault();
                            // If the media frame already exists, reopen it.
                            if (file_frame) {
                                // Set the post ID to what we want
                                //file_frame.uploader.uploader.param('post_id', set_to_post_id);
                                // Open frame
                                file_frame.open();
                                return;
                            } else {
                                // Set the wp.media post id so the uploader grabs the ID we want when initialised
                                wp.media.model.settings.post.id = set_to_post_id;
                            }
                            // Create the media frame.
                            file_frame = wp.media.frames.file_frame = wp.media({
                                title: 'Select a image to upload',
                                button: {
                                    text: 'Use this image',
                                },
                                multiple: false // Set to true to allow multiple files to be selected
                            });
                            // When an image is selected, run a callback.
                            file_frame.on('select', function () {
                                // We set multiple to false so only get one image from the uploader
                                attachment = file_frame.state().get('selection').first().toJSON();
                                /*console.log(attachment);*/
                                // Do something with attachment.id and/or attachment.url here
                                $('#image-preview').attr('src', attachment.url).css('width', 'auto');
                                $('#image_attachment_id').val(attachment.id);
                                jQuery('#wpf_graphics_popup_form .wpf_preview_graphics_img').text(attachment.filename);
                                jQuery('#wpf_graphics_popup_form .wpf_preview_graphics_img').show();
                                // Restore the main post ID
                                wp.media.model.settings.post.id = wp_media_post_id;
                            });
                            // Finally, open the modal
                            file_frame.open();
                        });
                        // Restore the main ID when the add media button is pressed
                        jQuery('a.add_media').on('click', function () {
                            wp.media.model.settings.post.id = wp_media_post_id;
                        });
                    }
                });
            </script>
        <?php }
    }
}

/*
 * This function is used to initial the WP FeedBack and all related variables on the frontend.
 *
 * @input NULL
 * @return NULL
 */
function show_wpf_comment_button()
{
    global $wpdb,$wp_query,$post;
    $disable_for_admin = 0;
    $currnet_user_information = wpf_get_current_user_information();
    $current_role = $currnet_user_information['role'];
    $current_user_name = $currnet_user_information['display_name'];
    $current_user_id = $currnet_user_information['user_id'];
    $wpf_website_builder = get_option('wpf_website_developer');
    if($current_user_name=='Guest'){
        $wpf_website_client = get_option('wpf_website_client');
        $wpf_current_role = 'guest';
        if($wpf_website_client){
            $wpf_website_client_info = get_userdata($wpf_website_client);
            if($wpf_website_client_info){
                if($wpf_website_client_info->display_name==''){
                    $current_user_name = $wpf_website_client_info->user_nicename;
                }
                else{
                    $current_user_name = $wpf_website_client_info->display_name;
                }
            }
        }

    }
    else{
        $wpf_current_role = get_user_meta($current_user_id,'wpf_user_type',true);
    }

    if($wpf_current_role=='advisor'){
        $wpf_tab_permission_user = get_option('wpf_tab_permission_user_webmaster') ? 'true' : 'false';
        $wpf_tab_permission_priority = get_option('wpf_tab_permission_priority_webmaster') ? 'true' : 'false';
        $wpf_tab_permission_status = get_option('wpf_tab_permission_status_webmaster') ? 'true' : 'false';
        $wpf_tab_permission_screenshot = get_option('wpf_tab_permission_screenshot_webmaster') ? 'true' : 'false';
        $wpf_tab_permission_information = get_option('wpf_tab_permission_information_webmaster') ? 'true' : 'false';
        $wpf_tab_permission_delete_task = get_option('wpf_tab_permission_delete_task_webmaster') ? 'all' : 'own';
        $wpf_tab_permission_auto_screenshot = get_option('wpf_tab_auto_screenshot_task_webmaster') ? 'true' : 'false';
    }
    elseif ($wpf_current_role=='king'){
        $wpf_tab_permission_user = get_option('wpf_tab_permission_user_client') ? 'true' : 'false';
        $wpf_tab_permission_priority = get_option('wpf_tab_permission_priority_client') ? 'true' : 'false';
        $wpf_tab_permission_status = get_option('wpf_tab_permission_status_client') ? 'true' : 'false';
        $wpf_tab_permission_screenshot = get_option('wpf_tab_permission_screenshot_client') ? 'true' : 'false';
        $wpf_tab_permission_information = get_option('wpf_tab_permission_information_client') ? 'true' : 'false';
        $wpf_tab_permission_delete_task = get_option('wpf_tab_permission_delete_task_client') ? 'all' : 'own';
        $wpf_tab_permission_auto_screenshot = get_option('wpf_tab_auto_screenshot_task_client') ? 'true' : 'false';
    }
    elseif ($wpf_current_role=='council'){
        $wpf_tab_permission_user = get_option('wpf_tab_permission_user_others') ? 'true' : 'false';
        $wpf_tab_permission_priority = get_option('wpf_tab_permission_priority_others') ? 'true' : 'false';
        $wpf_tab_permission_status = get_option('wpf_tab_permission_status_others') ? 'true' : 'false';
        $wpf_tab_permission_screenshot = get_option('wpf_tab_permission_screenshot_others') ? 'true' : 'false';
        $wpf_tab_permission_information = get_option('wpf_tab_permission_information_others') ? 'true' : 'false';
        $wpf_tab_permission_delete_task = get_option('wpf_tab_permission_delete_task_others') ? 'all' : 'own';
        $wpf_tab_permission_auto_screenshot = get_option('wpf_tab_auto_screenshot_task_others') ? 'true' : 'false';
    }
    else{
        $wpf_tab_permission_user = get_option('wpf_tab_permission_user_guest') ?'true':'false';
        $wpf_tab_permission_priority = get_option('wpf_tab_permission_priority_guest') ?'true':'false';
        $wpf_tab_permission_status = get_option('wpf_tab_permission_status_guest') ?'true':'false';
        $wpf_tab_permission_screenshot = get_option('wpf_tab_permission_screenshot_guest') ?'true':'false';
        $wpf_tab_permission_information = get_option('wpf_tab_permission_information_guest') ?'true':'false';
        $wpf_tab_permission_delete_task = get_option('wpf_tab_permission_delete_task_guest') ?'true':'false';
        $wpf_tab_permission_auto_screenshot = get_option('wpf_tab_auto_screenshot_task_guest') ? 'true' : 'false';
    }

    $wpf_disable_for_admin = get_option('wpf_disable_for_admin');
    if($wpf_disable_for_admin == 'yes' && $current_role == 'administrator'){
        $disable_for_admin = 1;
    }else{
        $disable_for_admin = 0;
    }
    $current_page_id = get_the_ID();
    if($current_page_id == ''){
        if(isset($wp_query->post->ID)) {
            $current_page_id = $wp_query->post->ID;
        }
    }
    $current_page_url = get_permalink($current_page_id);
    $current_page_title = addslashes(get_the_title($current_page_id));
    $wpf_show_front_stikers = get_option('wpf_show_front_stikers');

    $wpfb_users = do_shortcode('[wpf_user_list_front]');
    $ajax_url = admin_url('admin-ajax.php');
    $plugin_url = WPF_PLUGIN_URL;

    $sound_file = esc_url(plugins_url('images/wpf-screenshot-sound.mp3', __FILE__));

    $wpf_tag_enter_img = esc_url(plugins_url('images/enter.png', __FILE__));

//    Old logic to count latest task bubble number, was changed after the delete task feature was introduced
//    $comment_count_obj = wp_count_posts('wpfeedback');
//    $comment_count = $comment_count_obj->publish + 1;

    $table =  $wpdb->prefix . 'postmeta';
    $latest_count = $wpdb->get_results("SELECT meta_value FROM $table WHERE meta_key = 'task_comment_id' ORDER BY meta_id DESC LIMIT 1 ");
    /*$comment_count = $latest_count[0]->meta_value + 1;*/
    if($latest_count){
        $comment_count = $latest_count[0]->meta_value + 1;
    }else{
        $comment_count = 1;
    }

    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    $wpf_powered_class = '_blank';
    $wpf_powered_by = get_option('wpf_powered_by');
    $enabled_wpfeedback = get_option('wpf_enabled');
    $selected_roles = get_option('wpf_selcted_role');
    $selected_roles = explode(',', $selected_roles);
    $wpf_powerbylink = 'https://wpfeedback.co/powered';
    $get_logoid = get_option('wpf_logo');
    $wpf_powerbylogo = get_wpf_logo();
    if ($wpf_powered_by == 'yes') {
        $wpf_powered_class = '_self';
        $wpf_powered_link = get_option('wpf_powered_link');
        if($wpf_powered_link!=''){
            $wpf_powerbylink = $wpf_powered_link;
            $wpf_powered_class = '_blank';
        }
        else{
            $wpf_powerbylink = "javascript:void(0)";
        }
        $get_logoid = get_option('wpf_logo');
        $wpf_global_settings = get_option('wpf_global_settings');
        if ($wpf_global_settings == 'yes') {
//            $wpf_powerbylogo = get_option('wpf_logo');
            $wpf_powered_by_html = '<div class="wpf_sidebar_footer"><a href="'.$wpf_powerbylink.'" target="'.$wpf_powered_class.'">'.__('Powered by','wpfeedback').' <img alt="Powered by WPFeedBack" src="'.$wpf_powerbylogo.'" /></a></div>';
        } else {
//            $wpf_powerbylogo = esc_url(WPF_PLUGIN_URL . 'images/Logo-WPFeedback.svg');
            $wpf_powered_by_html = '<div class="wpf_sidebar_footer"></div>';
        }
    }else{
        $wpf_powered_link = get_option('wpf_powered_link');
        if($wpf_powered_link!=''){
            $wpf_powerbylink = $wpf_powered_link;
            $wpf_powered_class = '_blank';
            $wpf_powered_by_html = '<div class="wpf_sidebar_footer"><a href="'.$wpf_powerbylink.'" target="'.$wpf_powered_class.'">'.__('Powered by','wpfeedback').' <img alt="Powered by WPFeedBack" src="'.$wpf_powerbylogo.'" /></a></div>';
        }
        else{
            $wpf_powered_by_html = '<div class="wpf_sidebar_footer"><a href="'.$wpf_powerbylink.'" target="'.$wpf_powered_class.'">'.__('Powered by','wpfeedback').' <img alt="Powered by WPFeedBack" src="'.$wpf_powerbylogo.'" /></a></div>';
        }
    }

    $wpf_check_page_builder_active = wpf_check_page_builder_active();

    /*=====Start Check customize.php====*/
    if($wpf_check_page_builder_active == 0){
        if ( is_customize_preview() ) {
            $wpf_check_page_builder_active =1;
        }
        else {
            $wpf_check_page_builder_active = 0;
        }
    }
    /*=====END check customize.php====*/

    /*=====Start filter sidebar HTML Structure====*/
    if(is_singular('wpf_graphics') && $wpf_show_front_stikers == 'yes'){
        $checkbox_checked = "checked";
    }else{
        $checkbox_checked = "";
    }
    $wpf_active = wpf_check_if_enable();
    $backend_btn ='';
    $wpf_report_btn = '';
    $wpf_go_to_dashboard_btn_tab = '';
    $wpf_report_btn_tab = '';
    $wpf_go_to_cloud_dashboard_btn_tab = '';
    if($current_user_id>0){
        if($wpf_current_role=='advisor'){
            $wpf_go_to_cloud_dashboard_btn_tab = '<a href="https://app.wpfeedback.co/login" target="_blank" class="wpf_filter_tab_btn cloud_dashboard_btn" title="'. __("WP FeedBack Dashboard","wpfeedback").'"><svg id="wpf_icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 730.450000 636.050000" shape-rendering="geometricPrecision" text-rendering="geometricPrecision"><path id="wpf_comment_box" d="M288.130000,655.410000C235.770000,643.640000,187.620000,623.580000,147.130000,596.200000C112.680000,572.900000,85.440000,545.440000,66.130000,514.590000C45.280000,481.250000,34.710000,445.590000,34.710000,408.590000C34.710000,371.590000,45.280000,335.910000,66.130000,302.590000C85.410000,271.740000,112.650000,244.280000,147.130000,220.980000C197.070000,187.190000,258.710000,164.560000,325.520000,154.900000L324.130000,229.800000C273,238.590000,226.390000,256.410000,188.520000,282C136.960000,316.880000,108.520000,361.810000,108.520000,408.520000C108.520000,455.230000,136.910000,500.160000,188.520000,535.040000C216.870000,554.230000,250.150000,569.040000,286.520000,578.990000C278.283648,603.880910,278.848506,630.845843,288.120000,655.370000ZM713.810000,587.770000C709.810000,579.010000,703.960000,566.210000,700.350000,556.850000C742.870000,513.520000,765.230000,462.580000,765.230000,408.560000C765.230000,371.560000,754.660000,335.880000,733.810000,302.560000C714.530000,271.710000,687.290000,244.250000,652.810000,220.950000C622.810000,200.670000,588.630000,184.400000,551.630000,172.550000L542.390000,247.310000C566.757008,255.992643,589.961727,267.643702,611.480000,282C663.040000,316.880000,691.430000,361.810000,691.430000,408.520000C691.430000,456.320000,662.280000,492.520000,637.820000,514.520000C614.890000,535.140000,625.540000,566.320000,629.040000,576.520000C632.720000,587.280000,638.090000,599.460000,643.600000,611.580000L633.210000,606.400000C592.210000,585.870000,564.720000,572.790000,541.920000,572.790000C536.609003,572.760887,531.324722,573.543244,526.250000,575.110000Q515.540000,578.440000,504.550000,581.180000C512.251226,606.243497,511.136012,633.188615,501.390000,657.530000Q522.810000,653.200000,543.510000,647C555.040000,649.800000,582.990000,663.790000,600.180000,672.390000C638.410000,691.530000,667.180000,705.920000,691.060000,705.920000C699.713640,706.033752,708.240690,703.834671,715.760000,699.550000C730.160000,691.320000,738.140000,676.240000,737.640000,658.170000C737.430000,650.690000,735.820000,642.590000,732.640000,632.690000C728.100000,619,720.830000,603.140000,713.810000,587.770000Z" transform="matrix(1 0 0 1 -34.77000000000000 -69.98000000000000)" fill="rgb(142,139,201)" stroke="none" stroke-width="1"/><circle id="wpf_exc_circle" r="84.900000" transform="matrix(1 0 0 1 360.41000000000003 544.97000000000003)" fill="rgb(5,32,85)" stroke="none" stroke-width="1"/><path id="wpf_exc_mark" d="M518.870000,106C514.710000,74,494.870000,75.070000,434.630000,70.560000C388,67,363.590000,80,359.070000,122.220000C355.490000,155.590000,342.070000,458.220000,349.940000,473.880000C357.810000,489.540000,451.070000,501.260000,463.160000,488.620000C475.250000,475.980000,523.380000,140.630000,518.870000,106Z" transform="matrix(1 0 0 1 -34.77000000000000 -69.98000000000000)" fill="rgb(5,32,85)" stroke="none" stroke-width="1"/></svg></a>';
        }
        $sidebar_col = "wpf_col3";
        $backend_btn = ' <button class="wpf_tab_sidebar wpf_backend"  onclick="openWPFTab(\'wpf_backend\')" >'.__('Backend','wpfeedback').'</button>';
        $wpf_daily_report = get_option('wpf_daily_report');
        $wpf_weekly_report = get_option('wpf_weekly_report');

        if ( 'wpf_graphics' === $post->post_type ) {
            $wpf_current_page_url = get_permalink().'&wpf_login=1';
            $dashboard_url = admin_url().'admin.php?page=wpfeedback_page_graphics';;
        }
        else{
            $wpf_current_page_url = get_permalink().'?wpf_login=1';
            $dashboard_url = admin_url().'admin.php?page=wpfeedback_page_tasks';
        }
        /*================Go to dashboard Tabs HTML================*/
        $wpf_go_to_dashboard_btn_tab = '<a href="'.$dashboard_url.'" target="_blank" class="wpf_filter_tab_btn"><i class="gg-options"></i></a>';
        $wpf_report_btn.='<div class="wpf_report_trigger"><label class="wpf_reports_title">'. __("Send Reports:","wpfeedback").'</label>';
        if($wpf_daily_report=='yes'){
            /*================Daily report btn HTML================*/
            $wpf_report_btn.='<a href="javascript:wpf_send_report(\'daily_report\')">'.__('Last 24 Hours','wpfeedback').'</a>';
        }
        if($wpf_weekly_report=='yes'){
            /*================Weekly report btn HTML================*/
            $wpf_report_btn.='<a href="javascript:wpf_send_report(\'weekly_report\')">'.__('Last 7 Days','wpfeedback').'</a>';
        }
        $wpf_report_btn.='<span id="wpf_front_report_sent_span" class="wpf_hide text-success">'.__('Your report was sent','wpfeedback').'</span></div>';

         /*================Report Tabs HTML================*/
        $wpf_report_btn_tab = '<a href="javascript:void(0)" class="wpf_filter_tab_btn" data-tag="wpf_report_btn" title="'. __("Reports","wpfeedback").'"><i class="gg-mail"></i></a>';
    }
    else{
        $sidebar_col = "wpf_col2";
    }

    /*================filter Tabs Content HTML================*/
    $wpf_task_filter_btn = '<div id="wpf_filter_taskstatus" class=""><label class="wpf_filter_title"><i class="gg-thermostat"></i>'. __('Filter by Status:','wpfeedback').'</label>'.wp_feedback_get_texonomy_filter("task_status").'</div><div id="wpf_filter_taskpriority" class=""><label class="wpf_filter_title"><i class="gg-danger"></i> '.__("Filter by Priority:","wpfeedback").'</label>'.wp_feedback_get_texonomy_filter("task_priority").'</div>';
    
    /*================visibility Tabs Content HTML================*/
    $wpf_task_visibility = '<label class="wpf_visibility_title">'.__("Tasks Visibility","wpfeedback").'</label><div class="wpf_sidebar_checkboxes"><input type="checkbox" name="wpfb_display_tasks" id="wpfb_display_tasks" '.$checkbox_checked.'/> <label for="wpfb_display_tasks">'.__('Show Tasks','wpfeedback').'</label></div>
            <div class="wpf_sidebar_checkboxes"><input type="checkbox" name="wpfb_display_completed_tasks" id="wpfb_display_completed_tasks" /> <label for="wpfb_display_completed_tasks">'.__('Show Completed','wpfeedback').'</label></div>
            <label class="wpf_visibility_title">'.__("Sidebar Visibility","wpfeedback").'</label><div class="wpf_display_all_taskmeta_div wpf_sidebar_checkboxes"><input type="checkbox" name="wpf_display_all_taskmeta" id="wpf_display_all_taskmeta" class="wpf_display_all_taskmeta" title="Display taskmeta"><label for="wpf_display_all_taskmeta">'. __("Show Details","wpfeedback").'</label></div>';

    $wpf_page_share = '<div class="wpf_icon_title">'. __("Share Page Link : ","wpfeedback").'</div><input type="text" id="wpf_share_page_link" value="'.$wpf_current_page_url.'" style="position: absolute; z-index: -999; opacity: 0;"><span class="wpf_share_task_link"><div class="wpf_task_link">'.$wpf_current_page_url.'</div><a href="javascript:void(0);" onclick="wpf_copy_to_clipboard(\'wpf_share_page_link\')" class="wpf_copy_task_icon" style="display: inline-block; color: var(--main-wpf-color) !important;"><i class="gg-copy"></i></a><span class="wpf_success_wpf_share_link" id="wpf_success_wpf_share_page_link" style="display: none;">The link was copied to your clipboard.</span></span><div class="wpf_remove_login_box"><input type="checkbox" id="wpf_remove_login_task_link" class="wpf_remove_login_task_link" onclick=\'wpf_remove_login_to_clipboard_sidebar("wpf_share_page_link","")\'><label class="wpf_remove_login_label" for="wpf_remove_login_task_link">'. __("Remove Login Parameter","wpfeedback").'</label></div>';
     /*================Filter Tabs & Content HTML================*/
    $wpf_toggel_filter_tab = '<div class="wpf_sidebar_filter wpf_col2">
        <a href="javascript:void(0)" data-tag="wpf_task_filter_btn" class="wpf_filter_tab_btn" title="'.__("Filter","wpfeedback").'"><i class="gg-options"></i></a></li>
        <a href="javascript:void(0)" class="wpf_filter_tab_btn" data-tag="wpf_task_visibility" title="'.__("Visibility","wpfeedback").'"><i class="gg-eye"></i></a>
        '.$wpf_report_btn_tab.$wpf_go_to_cloud_dashboard_btn_tab.'
        <a href="javascript:void(0)" class="wpf_filter_tab_btn" data-tag="wpf_share_page_btn" title="'. __("Share Page","wpfeedback").'"><i class="gg-share"></i></a>
       <a href="javascript:void(0)" onclick="wpf_new_general_task(0)" class="wpf_general_task_thispage"  title="'. __("General","wpfeedback").'"><i class="gg-add"></i>'. __("General","wpfeedback").'</a>
    <div style="clear: both;"></div>    
    <div id="container">
        <div class="wpf_list wpf_hide" id="wpf_task_filter_btn">'.$wpf_task_filter_btn.'</div>
        <div class="wpf_list wpf_hide" id="wpf_task_visibility">'.$wpf_task_visibility.'</div>
        <div class="wpf_list wpf_hide" id="wpf_report_btn">'.$wpf_report_btn.'</div>
        <div class="wpf_list wpf_hide" id="wpf_share_page_btn">'.$wpf_page_share.'</div>
    </div></div>';
    /*=====END filter sidebar HTML Structure====*/

    $wpf_nonce = wpf_wp_create_nonce();
    $wpf_admin_bar = 0;
    if(is_admin_bar_showing()){
        $wpf_admin_bar = 1;
    }

    if ( $wpf_active == 1 && $wpf_check_page_builder_active == 0){
        require_once(WPF_PLUGIN_DIR . 'inc/wpf_popup_string.php');
        echo "<style>li#wp-admin-bar-wpfeedback_admin_bar {display: none !important;}</style>";
        echo "<script>var wpf_tag_enter_img='$wpf_tag_enter_img',disable_for_admin='$disable_for_admin',wpf_nonce='$wpf_nonce',ipaddress='$ipaddress', current_role='$current_role', wpf_current_role='$wpf_current_role', current_user_name='$current_user_name', current_user_id='$current_user_id', wpf_website_builder='$wpf_website_builder', wpfb_users = '$wpfb_users',  ajaxurl = '$ajax_url', current_page_url = '$current_page_url', current_page_title = '$current_page_title', current_page_id = '$current_page_id', wpf_screenshot_sound = '$sound_file', plugin_url = '$plugin_url', comment_count='$comment_count', wpf_show_front_stikers='$wpf_show_front_stikers', wpf_tab_permission_user=$wpf_tab_permission_user, wpf_tab_permission_priority=$wpf_tab_permission_priority, wpf_tab_permission_status=$wpf_tab_permission_status, wpf_tab_permission_screenshot=$wpf_tab_permission_screenshot, wpf_tab_permission_information=$wpf_tab_permission_information, wpf_tab_permission_delete_task='$wpf_tab_permission_delete_task',wpf_tab_permission_auto_screenshot=$wpf_tab_permission_auto_screenshot, wpf_admin_bar=$wpf_admin_bar;</script>";
        if($disable_for_admin == 0){
            if(is_singular('wpf_graphics')){
                $wpf_sidebar_style = "";
                $wpf_sidebar_active = "wpf_graphics active";
            }else{
                $wpf_sidebar_active = "";
                $wpf_sidebar_style = "opacity: 0; margin-right: -300px";
            }
            echo '<div id="wpf_already_comment" class="wpf_hide"><div class="wpf_notice_title">'.__("Task already exist for this element.","wpfeedback").'</div><div class="wpf_notice_text">'.__("Write your message in the existing thread. <br>Here, we opened it for you.","wpfeedback").'</div></div><div id="wpf_reconnecting_task" class="wpf_hide" style="display: none;"><div class="wpf_notice_title">'.__("Remapping task....","wpfeedback").'</div><div class="wpf_notice_text">'.__("Give it a few seconds. <br>Then, refresh the page to see the task in the new position.","wpfeedback").'</div></div><div id="wpf_reconnecting_enabled" class="wpf_hide" style="display: none;"><div class="wpf_notice_title">'.__("Remap task","wpfeedback").'</div><div class="wpf_notice_text">'.__("Place the task anywhere on the page to pinpoint the location of the request.","wpfeedback").'</div></div><div id="wpf_launcher" data-html2canvas-ignore="true" ><div class="wpf_launch_buttons"><div class="wpf_start_comment"><a href="javascript:enable_comment();" title="'.__('Click to give your feedback!','wpfeedback').'" data-placement="left" class="comment_btn"><i class="gg-math-plus"></i></a></div>
            <div class="wpf_expand"><a href="javascript:expand_sidebar()" id="wpf_expand_btn" title="'. __("WP FeedBack Sidebar","wpfeedback").'">
<svg id="wpf_icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 730.450000 636.050000" shape-rendering="geometricPrecision" text-rendering="geometricPrecision"><path id="wpf_comment_box" d="M288.130000,655.410000C235.770000,643.640000,187.620000,623.580000,147.130000,596.200000C112.680000,572.900000,85.440000,545.440000,66.130000,514.590000C45.280000,481.250000,34.710000,445.590000,34.710000,408.590000C34.710000,371.590000,45.280000,335.910000,66.130000,302.590000C85.410000,271.740000,112.650000,244.280000,147.130000,220.980000C197.070000,187.190000,258.710000,164.560000,325.520000,154.900000L324.130000,229.800000C273,238.590000,226.390000,256.410000,188.520000,282C136.960000,316.880000,108.520000,361.810000,108.520000,408.520000C108.520000,455.230000,136.910000,500.160000,188.520000,535.040000C216.870000,554.230000,250.150000,569.040000,286.520000,578.990000C278.283648,603.880910,278.848506,630.845843,288.120000,655.370000ZM713.810000,587.770000C709.810000,579.010000,703.960000,566.210000,700.350000,556.850000C742.870000,513.520000,765.230000,462.580000,765.230000,408.560000C765.230000,371.560000,754.660000,335.880000,733.810000,302.560000C714.530000,271.710000,687.290000,244.250000,652.810000,220.950000C622.810000,200.670000,588.630000,184.400000,551.630000,172.550000L542.390000,247.310000C566.757008,255.992643,589.961727,267.643702,611.480000,282C663.040000,316.880000,691.430000,361.810000,691.430000,408.520000C691.430000,456.320000,662.280000,492.520000,637.820000,514.520000C614.890000,535.140000,625.540000,566.320000,629.040000,576.520000C632.720000,587.280000,638.090000,599.460000,643.600000,611.580000L633.210000,606.400000C592.210000,585.870000,564.720000,572.790000,541.920000,572.790000C536.609003,572.760887,531.324722,573.543244,526.250000,575.110000Q515.540000,578.440000,504.550000,581.180000C512.251226,606.243497,511.136012,633.188615,501.390000,657.530000Q522.810000,653.200000,543.510000,647C555.040000,649.800000,582.990000,663.790000,600.180000,672.390000C638.410000,691.530000,667.180000,705.920000,691.060000,705.920000C699.713640,706.033752,708.240690,703.834671,715.760000,699.550000C730.160000,691.320000,738.140000,676.240000,737.640000,658.170000C737.430000,650.690000,735.820000,642.590000,732.640000,632.690000C728.100000,619,720.830000,603.140000,713.810000,587.770000Z" transform="matrix(1 0 0 1 -34.77000000000000 -69.98000000000000)" fill="rgb(142,139,201)" stroke="none" stroke-width="1"/><circle id="wpf_exc_circle" r="84.900000" transform="matrix(1 0 0 1 360.41000000000003 544.97000000000003)" fill="rgb(5,32,85)" stroke="none" stroke-width="1"/><path id="wpf_exc_mark" d="M518.870000,106C514.710000,74,494.870000,75.070000,434.630000,70.560000C388,67,363.590000,80,359.070000,122.220000C355.490000,155.590000,342.070000,458.220000,349.940000,473.880000C357.810000,489.540000,451.070000,501.260000,463.160000,488.620000C475.250000,475.980000,523.380000,140.630000,518.870000,106Z" transform="matrix(1 0 0 1 -34.77000000000000 -69.98000000000000)" fill="rgb(5,32,85)" stroke="none" stroke-width="1"/></svg>
			</a></div></div>
            <div class="wpf_sidebar_container '.$wpf_sidebar_active.'" style="'.$wpf_sidebar_style.'";>
            <div class="wpf_sidebar_header '.$sidebar_col.'">
            <!-- =================Top Tabs================-->
            <button class="wpf_tab_sidebar wpf_thispage wpf_active" onclick="openWPFTab(\'wpf_thispage\')" >'.__('This Page','wpfeedback').'</button>
            <button class="wpf_tab_sidebar wpf_allpages"  onclick="openWPFTab(\'wpf_allpages\')" >'.__('All Pages','wpfeedback').'</button>'.$backend_btn.'
            </div><div class="wpf_filter_tab">'.$wpf_toggel_filter_tab.'</div>
            <div class="wpf_sidebar_content">
            <div class="wpf_sidebar_loader wpf_hide"></div>
            <div id="wpf_thispage" class="wpf_thispage_tab wpf_container wpf_active_filter"><ul id="wpf_thispage_container"></ul></div>
            <div id="wpf_allpages" class="wpf_allpages_tab wpf_container" style="display:none";><ul id="wpf_allpages_container"></ul></div>
             <div id="wpf_backend" class="wpf_backend_tab wpf_container" style="display:none";><ul id="wpf_backend_container"></ul></div>
            </div>
            '.$wpf_powered_by_html.'
            </div>
            </div>
            <div id="wpf_enable_comment" class="wpf_hide"><p>'.__('Commenting enabled','wpfeedback').'</p><a class="wpf_comment_mode_general_task" id="wpf_comment_mode_general_task" href="javascript:void(0)" onclick="wpf_new_general_task(0)"><i class="gg-add"></i> '.__('General Task','wpfeedback').'</a><a href="javascript:disable_comment();" id="disable_comment_a">'.__('Cancel','wpfeedback').'</a></div>';
            $wpf_get_user_type =esc_attr( get_the_author_meta( 'wpf_user_initial_setup', $current_user_id ) );
            if($wpf_get_user_type == '' && $current_user_id && in_array($current_role, $selected_roles)){
                require_once(WPF_PLUGIN_DIR . 'inc/frontend/wpf_frontend_initial_setup.php');
            }
            require_once(WPF_PLUGIN_DIR . 'inc/frontend/wpf_general_task_modal.php');
        }
    }
    $wpf_enabled = get_option('wpf_enabled');
    $wpf_allow_guest = get_option('wpf_allow_guest');
    if(!is_user_logged_in() && $wpf_enabled == 'yes'){
        require_once(WPF_PLUGIN_DIR . 'inc/frontend/wpf_login_modal.php');
    }
}
add_action('wp_footer', 'show_wpf_comment_button');

// Remove wpfeedback CPT page in menu
/*
 * This function is used to remove the backend menu for the wpfeedback post type so they are not accessible by backend users.
 *
 * @input NULL
 * @return NULL
 */
function wpf_disable_comments_admin_menu()
{
    remove_menu_page('edit.php?post_type=wpfeedback');
}
add_action('admin_menu', 'wpf_disable_comments_admin_menu');

/* Remove 'wpfeedback' comment type in admin side*/
/*
 * This function is used to disabled the WP FeedBack features on WP FeedBack pages.
 *
 * @input NULL
 * @return NULL
 */
add_action('pre_get_comments', 'wpf_exclude_comments');
function wpf_exclude_comments($query)
{
    if ($query->query_vars['type'] !== 'wp_feedback') {
        $query->query_vars['type__not_in'] = array_merge((array)$query->query_vars['type__not_in'], array('wp_feedback'));
    }
}

/*
 * This function is used to set the redirect of Upgrade menu item.
 *
 * @input NULL
 * @return NULL
 */
add_action( 'admin_head', 'wpf_upgrade_menu_page_redirect' );
function wpf_upgrade_menu_page_redirect() {
    $wpf_license = get_option('wpf_license');
    $wpf_user_type = wpf_user_type();
    if($wpf_license !='valid'){
        ?>
        <style type="text/css">
            div#wpf_tasks {
                position: relative;
            }
        </style>
    <?php } if($wpf_user_type == 'advisor'){?>
        <script type="text/javascript">
            jQuery(document).ready( function($) {
                jQuery('#toplevel_page_wp_feedback ul li').last().find('a').attr('target','_blank');
            });
        </script>
    <?php }
}

require_once(WPF_PLUGIN_DIR . 'inc/wpf_class.php');

/*
 * This function is used to redirect the users to the settings page on the activation of the plugin.
 *
 * @input String
 * @return Redirect
 */
function wpf_activation_redirect( $plugin ) {
    if( $plugin == plugin_basename( __FILE__ ) ) {
        $url = admin_url( 'admin.php?page=wpfeedback_page_settings' );
        wp_redirect( $url );
        exit;
    }
}
add_action( 'activated_plugin', 'wpf_activation_redirect', 10, 1 );

/*
 * This function is used to detect if the page builder is active on the current running page.
 *
 * @input NULL
 * @return Boolean
 */
function wpf_check_page_builder_active(){
    $page_builder = 0;
    /*========Check Divi editor Active========*/
    if ( isset($_GET['et_fb']) ) {
        $page_builder = 1;
    }
    /*------Check wpbeaver editor Active-------*/
    else if (class_exists('FLBuilderModel') && FLBuilderModel::is_builder_active() ) {
        $page_builder = 1;
    }
    /*========Check brizy editor Active========*/
    else if( isset( $_GET['brizy-edit'] ) || isset( $_GET['brizy-edit-iframe'] )  || isset( $_GET['brizy_post'] ) ){
        $page_builder = 1;
    }
    /*=======Check oxygen editor Active========*/
    else if ( isset($_GET['ct_builder']) || isset($_GET['ct_template']) ) {
        $page_builder = 1;
    }
    /*=======Check Cornerstone editor Active========*/
    else if ( isset($_POST['cs_preview_state']) ) {
        $page_builder = 1;
    }
    /*------Check Visual Composer Active========*/
    else if( isset($_GET['vc_editable'])){
        $page_builder =1;
    }
    /*------Check elementor editor Active========*/
    else if ( defined( 'ELEMENTOR_VERSION' )) {
        if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
            $page_builder =1;
        }
        else{
            $page_builder =0;
        }
    }
    else if ( is_customize_preview() ) {
        $page_builder =1;
    }
    else {
        $page_builder = 0;
    }
    return $page_builder;
}
// Load plugin text domain
add_action( 'init', 'wpf_load_plugin_textdomain' ,10);

/**
 * Load the plugin text domain for translation.
 *
 */

/*
 * This function is used to identify the selected language of the current user and load the translations.
 *
 * @input NULL
 * @return NULL
 */
function wpf_load_plugin_textdomain() {
    $domain = 'wpfeedback';
    if(is_user_logged_in()){
        $get_locale = get_user_locale( $user_id = 0 );
    }else{
        $get_locale = get_locale();
    }
    $locale = apply_filters( 'plugin_locale', $get_locale, $domain );
    load_textdomain( $domain, trailingslashit(  WPF_PLUGIN_DIR . '/languages/' ). $domain . '-' . $locale . '.mo' );
    load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );
}

/*
 * This function is used to register the template for the graphics post.
 *
 * @input String
 * @return String
 */
function wpf_graphics_post_template( $page_template )
{
    global $post;
    if(isset($post->post_type)){
        if ( 'wpf_graphics' === $post->post_type ) {
            $page_template = dirname( __FILE__ ) . '/graphics/wpf_graphics.php';
        }
    }
    return $page_template;
}
add_filter( 'template_include', 'wpf_graphics_post_template', 9999 );

/*
 * This function is used to identify if certain themes/plugins are so that jquery UI can be de registered.
 *
 * @input NULL
 * @return Boolean
 */
function wpf_remove_ui_script(){
    $response = 1;
    if(function_exists('get_field')){
        $response = 0;
    }
    if (class_exists('PMXI_Plugin')) {
        $response = 0;
    }
    if(class_exists('Avada')){
        $response = 0;
    }
    if ( class_exists( 'WooCommerce' ) ) {
         $response = 0;
    }
    if ( class_exists( 'The7_Less_Functions' ) ) {
         $response = 0;
    }
    if ( class_exists( 'iHomefinderAutoloader' ) ) {
        $response = 0;
    }
    return $response;
}

remove_action( 'wp_body_open', 'wp_admin_bar_render', 0 );