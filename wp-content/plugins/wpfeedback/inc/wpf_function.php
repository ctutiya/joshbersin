<?php
/*
 * wpf_functions.php
 * This file contains the helper functions called from across the plugin.
 */

/*
 * This function is used to get the checkbox of task status / priority from the terms on website.
 *
 * @input String
 * @return String
 */
if (!function_exists('wp_feedback_get_texonomy')) {
    function wp_feedback_get_texonomy($my_term)
    {
        $terms = get_terms(array(
            'taxonomy' => $my_term,
            'hide_empty' => false,
        ));
        if (!empty($terms) && !is_wp_error($terms)) {
            echo '<ul class="wp_feedback_filter_checkbox">';
            foreach ($terms as $term) {
                if($term->name=='In Progress'){
                    $term->name = 'In Prog';
                }elseif ($term->name=='Pending Review'){
                    $term->name = 'Pending';
                }else{
                    $term->name = $term->name;
                }
                echo '<li><input onclick="wp_feedback_cat_filter()" type="checkbox" name="' . $my_term . '" value="' . $term->slug . '" class="wp_feedback_task" id="' . $term->slug . '"/><label for="' . $term->slug . '">' . __($term->name, 'wpfeedback') . '</label></li>';
            }
            echo '</ul>';
        }
    }
}

/*
 * This function is used to get all the roles allowed to use WP FeedBack features.
 *
 * @input NULL
 * @return String
 */
add_shortcode('wpf_user_role_list','wp_feedback_get_user_role_list');
if (!function_exists('wp_feedback_get_user_role_list')) {
    function wp_feedback_get_user_role_list()
    {
        $editable_roles = get_editable_roles();
        return $editable_roles;
    }
}

/*
 * This function is used to get all the users (based on role) which are supposed to get notified. This is called in the Tasks Center for "Filters" section.
 *
 * @input NULL
 * @return String
 */
add_shortcode('wpf_user_list','wp_feedback_get_user_list');
if (!function_exists('wp_feedback_get_user_list')) {
    function wp_feedback_get_user_list()
    {
        $all_role_cs = get_option('wpf_selcted_role');
        $all_role_array = explode(",", $all_role_cs);
        if (!empty($all_role_array) && !is_wp_error($all_role_array)) {
            $blogusers = get_users(['role__in' => $all_role_array]);
            // Array of WP_User objects.
            echo '<ul class="wp_feedback_filter_checkbox users">';
            foreach ($blogusers as $user) {
                echo '<li><input onclick="wp_feedback_cat_filter()"  type="checkbox" name="author_list" value="' . $user->ID . '" class="wp_feedback_task" id="user_' . $user->ID . '" /><label for="user_' . $user->ID . '">' . esc_html($user->display_name) . '</label></li>';
            }
            echo '</ul>';
        }
    }
}

/*
 * This function is used to get all the users (based on role) which are supposed to get notified. This is called in the Tasks Center for the "Notify Users" section.
 *
 * @input NULL
 * @return String
 */
add_shortcode('wpf_user_list_task','wp_feedback_get_user_list_task');
if (!function_exists('wp_feedback_get_user_list_task')) {
    function wp_feedback_get_user_list_task()
    {
        $all_role_cs = get_option('wpf_selcted_role');
        $all_role_array = explode(",", $all_role_cs);
        if (!empty($all_role_array) && !is_wp_error($all_role_array)) {
            $blogusers = get_users(['role__in' => $all_role_array]);
            // Array of WP_User objects.
            echo '<ul class="wp_feedback_filter_checkbox user">';
            foreach ($blogusers as $user) {
                echo '<li><input type="checkbox" name="author_list_task" value="' . $user->ID . '" class="wp_feedback_task" id="' . $user->ID . '" onclick="update_notify_user(' . $user->ID . ')" /><label for="' . $user->ID . '">' . esc_html($user->display_name) . '</label></li>';
            }
            echo '</ul>';
        }
    }
}

/*
 * This function is used to get all the users (based on role) which are supposed to get notified. This is called in the frontend on the Tasks Popup.
 *
 * @input NULL
 * @return String
 */
add_shortcode('wpf_user_list_front','wp_feedback_get_user_list_front');
if (!function_exists('wp_feedback_get_user_list_front')) {
    function wp_feedback_get_user_list_front()
    {
        $response = array();
        $all_role_cs = get_option('wpf_selcted_role');
        $all_role_array = explode(",", $all_role_cs);
        if (!empty($all_role_array) && !is_wp_error($all_role_array)) {
            $wpfb_users = get_users(['role__in' => $all_role_array]);
            foreach ($wpfb_users as $user) {
                $response[$user->ID] = htmlspecialchars($user->display_name, ENT_QUOTES, 'UTF-8');
            }
            return json_encode($response);
        }
    }
}

/*
 * This function is used to verify if the license on the website is valid or not.
 *
 * @input String
 * @return JSON
 */
if (!function_exists('wpf_license_key_check_item')) {
    function wpf_license_key_check_item($wpf_license_key)
    {
        if(!get_option('wpf_decr_key')){
            $wpf_license_key=$wpf_license_key;
        }
        else{
            $wpf_license_key=wpf_crypt_key($wpf_license_key,'d');
        }
        $site_url = WPF_SITE_URL;
        $url = WPF_EDD_SL_STORE_URL."?edd_action=check_license&item_id=" . WPF_EDD_SL_ITEM_ID . "&license=$wpf_license_key&url=$site_url";
        $args = array(
            'timeout' => 20,
            'sslverify' => false
        );
        $output = wp_remote_get($url,$args);
        if($output['response']['code']!=200){
            $url = WPF_EDD_FALLBACK_URL."license.php?edd_action=check_license&item_id=" . WPF_EDD_SL_ITEM_ID . "&license=$wpf_license_key&url=$site_url";
            $output = wp_remote_get($url,$args);
        }
        $outputObject = json_decode($output['body']);
        if ($outputObject->license == 'valid') {
            if(isset($outputObject->wpf_site_id)){
                update_option('wpf_site_id',$outputObject->wpf_site_id);
            }
            $response = array('license' => $outputObject->license, 'expires' => $outputObject->expires, 'payment_id' => $outputObject->payment_id, 'checksum' => $outputObject->checksum, 'executed' => 1);
            if(get_option('wpf_initial_sync')!=1 && get_option('wpf_initial_sync')!=2){
                do_action('wpf_initial_sync',$wpf_license_key);
            }
        } else {
            $response = array('license' => $outputObject->license, 'expires' => '', 'executed' => 1);
        }
        return $response;
    }
}

/*
 * This function is used to activate the license on the website.
 *
 * @input String
 * @return JSON
 */
if (!function_exists('wpf_license_key_license_item')) {
    function wpf_license_key_license_item($wpf_license_key)
    {
        $wpf_license_key_in = $wpf_license_key;
        if(!get_option('wpf_decr_key')){
            $wpf_license_key=$wpf_license_key;
        }
        else{
            $wpf_license_key=wpf_crypt_key($wpf_license_key,'d');
            if($wpf_license_key==''){
                $wpf_license_key = $wpf_license_key_in;
            }
        }
        $site_url = WPF_SITE_URL;
        $url = WPF_EDD_SL_STORE_URL."?edd_action=activate_license&item_id=" . WPF_EDD_SL_ITEM_ID . "&license=$wpf_license_key&url=$site_url";

        $args = array(
            'timeout' => 20,
            'sslverify' => false
        );
        $output = wp_remote_get($url,$args);
        if($output['response']['code']!=200){
            $url = WPF_EDD_FALLBACK_URL."license.php?edd_action=activate_license&item_id=" . WPF_EDD_SL_ITEM_ID . "&license=$wpf_license_key&url=$site_url";
            $output = wp_remote_get($url,$args);
        }
        $outputObject = json_decode($output['body']);
        if ($outputObject->license == 'valid') {
            update_option('wpf_site_id',$outputObject->wpf_site_id);
            $response = array('license' => $outputObject->license, 'expires' => $outputObject->expires, 'payment_id' => $outputObject->payment_id, 'checksum' => $outputObject->checksum, 'executed' => 1);

        } else {
            $response = array('license' => $outputObject->license, 'expires' => '', 'executed' => 1);
        }
        return $response;
    }
}

/*
 * This function is used to save the Settings of the plugin when saved from the "Settings" tab.
 *
 * @input NULL
 * @return Redirect
 */
add_action( 'admin_post_save_wpfeedback_options', 'process_wpfeedback_options' );
if (!function_exists('process_wpfeedback_options')) {
    function process_wpfeedback_options()
    {
        global $wpdb;
        $wpfeedback_selected_roles = '';
        // Check that user has proper security level
        if (!current_user_can('manage_options'))
            wp_die('Not allowed');
        // Check that nonce field created in configuration form
        if (isset($_POST['action'])) {
            update_option('wpf_enabled', $_POST['enabled_wpfeedback'], 'no');
            update_option('wpf_delete_data', $_POST['delete_data_wpfeedback'], 'no');
            //update_option('wpf_font_awesome_script', $_POST['wpfeedback_font_awesome_script'], 'no');
            update_option('wpf_allow_backend_commenting', $_POST['wpf_allow_backend_commenting'], 'no');
//            update_option('wpf_allow_guest', $_POST['wpfeedback_guest_allowed'], 'no');
            /*update_option('wpf_disable_for_admin', $_POST['wpfeedback_disable_for_admin'], 'no');*/
            update_option('wpf_show_front_stikers', $_POST['wpf_show_front_stikers'], 'no');
//            if (isset($_POST['wpfeedback_selcted_role'])) {
//                $wpfeedback_selected_roles = implode(',', $_POST['wpfeedback_selcted_role']);
//            }
//            update_option('wpf_selcted_role', $wpfeedback_selected_roles, 'no');
            update_option('wpf_from_email', $_POST['wpf_from_email'], 'no');
            update_option('wpf_more_emails', $_POST['wpfeedback_more_emails'], 'no');
            update_option('wpf_powered_link', $_POST['wpf_powered_link'], 'no');
            update_option('wpf_color', $_POST['wpfeedback_color'], 'no');
            update_option('wpf_powered_by', $_POST['wpfeedback_powered_by'], 'no');
//            update_option('wpf_customisations_client', $_POST['wpf_customisations_client'], 'no');
//            update_option('wpf_customisations_webmaster', $_POST['wpf_customisations_webmaster'], 'no');
//            update_option('wpf_customisations_others', $_POST['wpf_customisations_others'], 'no');
            update_option('wpf_every_new_task', $_POST['wpf_every_new_task'], 'no');
            update_option('wpf_every_new_comment', $_POST['wpf_every_new_comment'], 'no');
            update_option('wpf_every_new_complete', $_POST['wpf_every_new_complete'], 'no');
            update_option('wpf_every_status_change', $_POST['wpf_every_status_change'], 'no');
            update_option('wpf_daily_report', $_POST['wpf_daily_report'], 'no');
            update_option('wpf_weekly_report', $_POST['wpf_weekly_report'], 'no');
            update_option('wpf_auto_daily_report', $_POST['wpf_auto_daily_report'], 'no');
            update_option('wpf_auto_weekly_report', $_POST['wpf_auto_weekly_report'], 'no');
            update_option('wpf_logo', $_POST['wpfeedback_logo'], 'no');
            update_option('wpf_tutorial_video',stripcslashes(htmlentities($_POST['wpf_tutorial_video'])),'no');
//            update_option('wpf_website_client', $_POST['wpf_website_client'], 'no');
//            update_option('wpf_website_developer', $_POST['wpf_website_developer'], 'no');

//            if ($_POST['wpfeedback_licence_key'] && isset($_POST['wpfeedback_licence_key'])) {
//                if ($_POST['wpfeedback_licence_key'] != '00000000000000000000000000000000') {
//                    $wpf_license_key = $_POST['wpfeedback_licence_key'];
//                    $wpf_result = wpf_license_key_license_item($wpf_license_key);
//                    if ($wpf_result['license'] == 'valid') {
//                        update_option('wpf_license_key', $_POST['wpfeedback_licence_key'], 'no');
//                        update_option('wpf_license', $wpf_result['license'], 'no');
//                        update_option('wpf_license_expires', $wpf_result['expires'], 'no');
//                    } else {
//                        update_option('wpf_license_key', $_POST['wpfeedback_licence_key'], 'no');
//                        update_option('wpf_license', $wpf_result['license'], 'no');
//                    }
//                }
//            }

            $wpf_report_register_types = array();
            if ($_POST['wpf_auto_daily_report'] == 'yes') {
                $wpf_report_register_types['daily'] = 'yes';
            } else {
                $wpf_report_register_types['daily'] = 'no';
            }
            if ($_POST['wpf_auto_weekly_report'] == 'yes') {
                $wpf_report_register_types['weekly'] = 'yes';
            } else {
                $wpf_report_register_types['weekly'] = 'no';
            }
            wpf_register_auto_reports_cron($wpf_report_register_types);
        }
        // check_admin_referer( 'wpfeedback' );
        // Redirect the page to the configuration form that was
        wp_redirect(add_query_arg('page', 'wpfeedback_page_settings&wpf_setting=1', admin_url('admin.php')));
        exit;
    }
}

/*
 * This function is used to save the Permissions options of the plugin when saved from the "Permissions" tab.
 *
 * @input Array ( $_POST )
 * @return Redirect
 */
add_action( 'admin_post_save_wpfeedback_misc_options', 'process_wpfeedback_misc_options' );
if (!function_exists('process_wpfeedback_misc_options')) {
    function process_wpfeedback_misc_options()
    {
        if(isset($_POST)){
            update_option('wpf_allow_guest', $_POST['wpfeedback_guest_allowed'], 'no');
            update_option('wpf_disable_for_admin', $_POST['wpfeedback_disable_for_admin'], 'no');
            update_option('wpf_disable_for_app', $_POST['wpfeedback_disable_for_app'], 'no');
            if (isset($_POST['wpfeedback_selcted_role'])) {
                $wpfeedback_selected_roles = implode(',', $_POST['wpfeedback_selcted_role']);
            }
            update_option('wpf_selcted_role', $wpfeedback_selected_roles, 'no');

            update_option('wpf_customisations_client', $_POST['wpf_customisations_client'], 'no');
            update_option('wpf_customisations_webmaster', $_POST['wpf_customisations_webmaster'], 'no');
            update_option('wpf_customisations_others', $_POST['wpf_customisations_others'], 'no');

            update_option('wpf_website_client', $_POST['wpf_website_client'], 'no');
            update_option('wpf_website_developer', $_POST['wpf_website_developer'], 'no');

            update_option('wpf_tab_permission_user_client', $_POST['wpf_tab_permission_user_client'], 'no');
            update_option('wpf_tab_permission_user_webmaster', $_POST['wpf_tab_permission_user_webmaster'], 'no');
            update_option('wpf_tab_permission_user_others', $_POST['wpf_tab_permission_user_others'], 'no');
            update_option('wpf_tab_permission_user_guest', $_POST['wpf_tab_permission_user_guest'], 'no');

            update_option('wpf_tab_permission_priority_client', $_POST['wpf_tab_permission_priority_client'], 'no');
            update_option('wpf_tab_permission_priority_webmaster', $_POST['wpf_tab_permission_priority_webmaster'], 'no');
            update_option('wpf_tab_permission_priority_others', $_POST['wpf_tab_permission_priority_others'], 'no');
            update_option('wpf_tab_permission_priority_guest', $_POST['wpf_tab_permission_priority_guest'], 'no');

            update_option('wpf_tab_permission_status_client', $_POST['wpf_tab_permission_status_client'], 'no');
            update_option('wpf_tab_permission_status_webmaster', $_POST['wpf_tab_permission_status_webmaster'], 'no');
            update_option('wpf_tab_permission_status_others', $_POST['wpf_tab_permission_status_others'], 'no');
            update_option('wpf_tab_permission_status_guest', $_POST['wpf_tab_permission_status_guest'], 'no');

            update_option('wpf_tab_permission_screenshot_client', $_POST['wpf_tab_permission_screenshot_client'], 'no');
            update_option('wpf_tab_permission_screenshot_webmaster', $_POST['wpf_tab_permission_screenshot_webmaster'], 'no');
            update_option('wpf_tab_permission_screenshot_others', $_POST['wpf_tab_permission_screenshot_others'], 'no');
            update_option('wpf_tab_permission_screenshot_guest', $_POST['wpf_tab_permission_screenshot_guest'], 'no');

            update_option('wpf_tab_permission_information_client', $_POST['wpf_tab_permission_information_client'], 'no');
            update_option('wpf_tab_permission_information_webmaster', $_POST['wpf_tab_permission_information_webmaster'], 'no');
            update_option('wpf_tab_permission_information_others', $_POST['wpf_tab_permission_information_others'], 'no');
            update_option('wpf_tab_permission_information_guest', $_POST['wpf_tab_permission_information_guest'], 'no');

            update_option('wpf_tab_permission_delete_task_client', $_POST['wpf_tab_permission_delete_task_client'], 'no');
            update_option('wpf_tab_permission_delete_task_webmaster', $_POST['wpf_tab_permission_delete_task_webmaster'], 'no');
            update_option('wpf_tab_permission_delete_task_others', $_POST['wpf_tab_permission_delete_task_others'], 'no');
            update_option('wpf_tab_permission_delete_task_guest', $_POST['wpf_tab_permission_delete_task_guest'], 'no');
            
            update_option('wpf_tab_auto_screenshot_task_client', $_POST['wpf_tab_auto_screenshot_task_client'], 'no');
            update_option('wpf_tab_auto_screenshot_task_webmaster', $_POST['wpf_tab_auto_screenshot_task_webmaster'], 'no');
            update_option('wpf_tab_auto_screenshot_task_others', $_POST['wpf_tab_auto_screenshot_task_others'], 'no');
            update_option('wpf_tab_auto_screenshot_task_guest', $_POST['wpf_tab_auto_screenshot_task_guest'], 'no');

            if ($_POST['wpfeedback_licence_key'] && isset($_POST['wpfeedback_licence_key'])) {
                if ($_POST['wpfeedback_licence_key'] != '00000000000000000000000000000000') {
                    $wpf_license_key = $_POST['wpfeedback_licence_key']; 
                    $wpf_result = wpf_license_key_license_item($wpf_license_key);
                    if ($wpf_result['license'] == 'valid') {
                        $wpf_crypt_key = wpf_crypt_key($wpf_license_key,'e');
                        update_option('wpf_license_key', $wpf_crypt_key, 'no');
                        update_option('wpf_license', $wpf_result['license'], 'no');
                        update_option('wpf_license_expires', $wpf_result['expires'], 'no');
                        if(!get_option('wpf_decr_key')){
                            update_option('wpf_decr_key', $wpf_result['payment_id'],'no');
                            update_option('wpf_decr_checksum', $wpf_result['checksum'],'no');
                            $wpf_crypt_key = wpf_crypt_key($wpf_license_key,'e');
                            update_option('wpf_license_key',$wpf_crypt_key,'no');
                        }
                        if(get_option('wpf_initial_sync')!=1 && get_option('wpf_initial_sync')!=2){
                            do_action('wpf_initial_sync',$wpf_license_key);
                        }
                    } else {
                        update_option('wpf_license_key', $_POST['wpfeedback_licence_key'], 'no');
                        update_option('wpf_license', $wpf_result['license'], 'no');
                    }
                }
            }
        }
        wp_redirect(add_query_arg('page', 'wpfeedback_page_permissions', admin_url('admin.php')));
        exit;
    }
}

/*
 * This function is used to create a dropdown of the roles available in website on the "Permissions" tab for the selection.
 *
 * @input Boolean
 * @return String
 */
if (!function_exists('wpfeedback_dropdown_roles')) {
    function wpfeedback_dropdown_roles($selected = false)
    {
        global $wp_roles;
        $p = '';
        $r = '';
        //$editable_roles = get_editable_roles();
        $editable_roles = $wp_roles->get_names();
        $selected_roles = get_option('wpf_selcted_role');
        // For backwards compatibility
        if (is_string($selected_roles)) {
            $selected_roles = explode(',', $selected_roles);
            foreach ($editable_roles as $role => $details) {
                $name = translate_user_role($details['name']);
                if (is_array($selected_roles) AND in_array($role, $selected_roles)) // preselect specified role
                    $p .= "\n\t<option selected='selected' value='" . esc_attr($role) . "'>$details</option>";
                else
                    $r .= "\n\t<option value='" . esc_attr($role) . "'>$details</option>";
            }
        }
        return $p . $r;
    }
}

/*
 * This function is used to get the title of the page based on the page ID. This function is not used currently.
 *
 * @input Int
 * @return String
 */
if (!function_exists('wpf_get_page_title')) {
    function wpf_get_page_title($post_id)
    {
        $get_page_id = get_post_meta($post_id, '_wpf_page_id', true);
        $page_title = get_the_title($get_page_id);
        return $page_title;
    }
}

/*
 * This function is used to get the listing of all the wpfeedback tasks.
 *
 * @input NULL
 * @return String
 */
if (!function_exists('wpfeedback_get_post_list')) {
    function wpfeedback_get_post_list()
    {
        $output = '';
        $args = array(
            'numberposts' => -1,
            'post_type' => 'wpfeedback',
            'post_status' => array('publish','wpf_admin'),
            'orderby' => 'title',
            'orderby' => 'date',
            'order' => 'DESC'
        );
        // Get the posts
        $myposts = get_posts($args);
        //echo count($myposts);
        if ($myposts):
            // Loop the posts
            $i = count($myposts);
            $output .= '<ul id="all_wpf_list" style="list-style-type: none; font-size:12px;">';
            foreach ($myposts as $mypost):
                $post_id = $mypost->ID;
                $author_id = $mypost->post_author;
                $get_post_date = $mypost->post_date;
                $date = date_create($get_post_date);
                $post_date = date_format($date, "d/m/Y H:i");
                $post_title = $mypost->post_title;
                $task_page_url = get_post_meta($post_id, "task_page_url", true);
                $wpf_task_screenshot = get_post_meta($post_id, "wpf_task_screenshot", true);
                $task_page_title = get_post_meta($post_id, "task_page_title", true);
                $task_config_author_name = get_post_meta($post_id, "task_config_author_name", true);
                $task_notify_users = get_post_meta($post_id, "task_notify_users", true);
                $task_config_author_resX = get_post_meta($post_id, "task_config_author_resX", true);
                $task_config_author_resY = get_post_meta($post_id, "task_config_author_resY", true);

                $get_task_type = get_post_meta($post_id, "task_type", true);
                if ($get_task_type == 'general') {
                    $task_type = 'general';
                    $general = '<span class="wpf_task_type">'.__("General","wpfeedback").'</span>';
                }elseif($get_task_type == 'graphics'){
                    $task_type = 'graphics';
                    $general = '<span class="wpf_task_type">'.__("Graphics","wpfeedback").'</span>';
                } else {
                    $task_type = '';
                    $general = '';
                }

                if (get_post_status($post_id) == 'wpf_admin') {
                    $wpf_task_status = 'wpf_admin';
                    $admin_tag = '<span class="wpf_task_type">'.__("Admin","wpfeedback").'</span>';
                } else {
                    $wpf_task_status = 'public';
                    $admin_tag = '';
                }

                $task_config_author_browser = get_post_meta($post_id, "task_config_author_browser", true);
                $task_config_author_browserVersion = get_post_meta($post_id, "task_config_author_browserVersion", true);
                $task_config_author_ipaddress = get_post_meta($post_id, "task_config_author_ipaddress", true);
                $task_comment_id = get_post_meta($post_id, 'task_comment_id', true);
                $task_priority = get_the_terms($post_id, 'task_priority');
                $task_status = get_the_terms($post_id, 'task_status');

                $task_tags = get_the_terms( $post_id, 'wpf_tag' );
                $post_title = esc_html( get_the_title($post_id));
                $all_other_tag = '';
                $wpfb_tags_html = '';
                if($task_tags){
                    $tag_length = count($task_tags);
                    $wpfb_tags_html = '<div class="wpf_task_tags">';
                    $i = 1;

                    foreach ($task_tags as $task_tag => $task_tags_value) {
                        if($i == 1){
                            $wpfb_tags_html .=  '<span class="wpf_task_tag">'.$task_tags_value->name.'</span>';
                        }
                        else {
                            if($tag_length == $i){
                                $all_other_tag .=  $task_tags_value->name;
                            }else{
                                $all_other_tag .=  $task_tags_value->name.', ';
                            }
                        }
                        $i++;
                    }
                    if($tag_length > 1){
                        $wpfb_tags_html .= '<span class="wpf_task_tag_more" title="'.$all_other_tag.'">...</span>';
                    }
                    $wpfb_tags_html .= '</div>';
                }

                $task_date = get_the_time('Y-m-d H:i:s', $post_id);
                $task_date1 = date_create($task_date);
                //Old Logic to get current time. Was creating issues when displaying message
                //$task_date2 = new DateTime('now');

                //New Logic to get current time.
                $wpf_wp_current_timestamp = date('Y-m-d H:i:s', current_time('timestamp', 0));
                $task_date2 = date_create($wpf_wp_current_timestamp);

                $curr_task_time = wpfb_time_difference($task_date1, $task_date2);
                if ($task_status[0]->slug == 'complete') {
                    $bubble_label = '<i class="gg-check"></i>';
                } else {
                    $bubble_label = $task_comment_id;
                }
                if ($author_id) {
                    $author = get_the_author_meta('display_name', $author_id);
                } else {
                    $author = 'Guest';
                }

                $wpf_task_status_label= '<div class="wpf_task_label"><span class="task_status wpf_'.$task_status[0]->slug.'" title="Status: '.$task_status[0]->name.'"><i class="gg-thermostat"></i></span>';
                $wpf_task_priority_label= '<span class="task_priority wpf_'.$task_priority[0]->slug.'" title="Priority: '.$task_priority[0]->name.'"><i class="gg-danger"></i></span></div>';
                //$wpfb_tags_html = '<div class="wpf_task_tags"><span class="wpf_task_tag">Test tag</span><span class="wpf_task_tag_more">...</span></div>';

                $output .= '<li class="post_' . $post_id . ' ' . $task_priority[0]->slug .' '.$task_status[0]->slug. ' wpf_list"><a href="javascript:void(0)" class="'.$task_status[0]->slug.'" id="wpf-task-' . $post_id . '" data-wpf_task_status="' . $wpf_task_status . '"" data-task_type="' . $task_type . '" data-task_author_name="' . $task_config_author_name . '" data-task_config_author_ipaddress="' . $task_config_author_ipaddress . '" data-task_config_author_browserVersion="' . $task_config_author_browserVersion . '" data-task_config_author_res="' . $task_config_author_resX . ' X ' . $task_config_author_resY . '" data-task_config_author_browser="' . $task_config_author_browser . '" data-task_config_author_name="'.__('By ', 'wpfeedback') . $task_config_author_name . ' ' . $post_date . '" data-task_notify_users="' . $task_notify_users . '" data-task_page_url="' . $task_page_url . '" data-wpf_task_screenshot="'.$wpf_task_screenshot.'" data-task_page_title="' . $post_title . '"
    data-task_priority="' . $task_priority[0]->slug . '" data-task_status="' . $task_status[0]->slug . '" onclick="get_wpf_chat(this,true)" data-postid="' . $post_id . '" data-uid="' . $author_id . '"  data-task_no="' . $task_comment_id . '"><div class="wpf_chat_top"><input type="checkbox" value="'.$post_id.'" name="wpf_task_id" id="wpf_'.$post_id.'" class="wpf_task_id" style="display:none;"><div class="wpf_task_num_top">' . $bubble_label . '</div><div class="wpf_task_main_top"><div class="wpf_task_details_top">'. $author . ' <span>' . $curr_task_time['comment_time'] . '</span></div><div class="wpf_task_pagename">' . $task_page_title . ' </div><div class="wpf_task_title_top">' . $post_title . '</div></div><div class="wpf_task_meta"><div class="wpf_task_meta_icon"><i class="gg-chevron-left"></i></div><div class="wpf_task_meta_details">'. ' ' . $admin_tag . ' ' . $general .$wpf_task_status_label.$wpf_task_priority_label.$wpfb_tags_html.'</div></div></div></a></li>';
                $i--;
            endforeach;
            wp_reset_postdata();
            $output .= '</ul>';
        else:
            $output = '<div class="wpf_no_tasks_found"><i class="gg-info"></i> No tasks found</div>';
        endif;
        return $output;
    }
}

/*
 * This function is used to get the comments of the tasks based on the task id.
 *
 * @input Int
 * @return String
 */
if (!function_exists('list_wpf_comment_notif_func')) {
    function list_wpf_comment_notif_func($post_id)
    {
        global $wpdb, $current_user;
        $response = '';
        $current_user_id = $current_user->ID;
        if ($post_id) {
            /*Old Logic to get comment list in Admin side. Was creating issues Security*/
            /*$comment_info = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}comments WHERE comment_approved = 1 AND comment_post_ID =$post_id AND comment_type LIKE 'wp_feedback'  ORDER BY comment_ID ASC");*/

            $args = array(
                'post_id' => $post_id,
                'type' => 'wp_feedback'
            );
            $comment_info = get_comments( $args );

            if ($comment_info) {
                foreach ($comment_info as $comment) {
                    $author_id = $comment->user_id;
                    if ($author_id) {
                        $author = get_the_author_meta('display_name', $comment->user_id);
                    } else {
                        $author = 'Guest';
                    }

                    if ($current_user_id == $comment->user_id) {
                        $class = "chat_author";
                    } else {
                        $class = "not_chat_author";
                    }

                    $name = "<div class='wpf_initials'>" . $author . "</div>";
                    if (strpos($comment->comment_content, 'wp-content/uploads') !== false) {
                        $comment = '<a href="' . $comment->comment_content . '" target=_blank><div class="tag_img" style="width: 275px;height: 183px;"><img src="' . $comment->comment_content . '" style="width: 100%;" class="wpfb_task_screenshot"></div></a>';
                    } else {
                        $comment = $comment->comment_content;
                    }
                    $response .= "<li><strong>$author: </strong>" . nl2br($comment) . "</li>";
                }
            } else {
                $response = '<li id="wpf_not_found">No comments found</li>';
            }
        } else {
            $response = '<li id="wpf_not_found">No comments found</li>';
        }
        return $response;
        die();

    }
}

/*
 * Get Logo URL
 */

/*
 * This function is used to get the logo to be displayed on the backend and sidebar.
 *
 * @input NULL
 * @return String
 */
if (!function_exists('get_wpf_logo')) {
    function get_wpf_logo()
    {
        $wpf_global_settings = get_option('wpf_global_settings');
        $get_logoid = get_option('wpf_logo');
        if ($wpf_global_settings == 'yes') {
            /*$get_logo_url = wp_get_attachment_url(get_option('wpf_logo'));*/
            if(is_numeric($get_logoid)){
                $get_logo_url = wp_get_attachment_url($get_logoid);
            }
            else{
                $get_logo_url = $get_logoid;
            }
        } else {
            if($get_logoid!=''){
                if(is_numeric($get_logoid)){
                    $get_logo_url = wp_get_attachment_url($get_logoid);
                }
                else{
                    $get_logo_url = $get_logoid;
                }
            }
            else{
                $get_logo_url = esc_url(WPF_PLUGIN_URL . 'images/Logo-WPFeedback.svg');
            }

        }
        return $get_logo_url;
    }
}

/*
 * This function is used to display the success/error notice for settings saving. This function is not used currently.
 *
 * @input NULL
 * @return NULL
 */
if (!function_exists('wpf_admin_notice_success')) {
    function wpf_admin_notice_success()
    {
        if (isset($_GET['wpf_setting']) && $_GET['wpf_setting'] == 1) {
            ?>
            <div class="notice notice-success is-dismissible">
                <p><?php _e('Your settings have been saved!', 'wpfeedback'); ?></p>
            </div>
        <?php }

        if (isset($_GET['wpf_setting']) && $_GET['wpf_setting'] == 0) {
            ?>
            <div class="error notice is-dismissible">
                <p><?php _e('Your Settings not saved. ', 'wpfeedback'); ?></p>
            </div>
        <?php }
    }
}
//add_action( 'admin_notices', 'wpf_admin_notice_success' );

/*
 * This function is used to get the role of current logged in user. This function is not used currently.
 *
 * @input NULL
 * @return String
 */
if (!function_exists('wpf_get_current_user_roles')) {
    function wpf_get_current_user_roles()
    {
        if (is_user_logged_in()) {
            $user = wp_get_current_user();
            $roles = ( array )$user->roles;
            return $roles[0];
        } else {
            return 'Guest';
        }
    }
}

/*
 * This function is used to get the information of the requested user.
 *
 * @input Int
 * @return Array
 */
if (!function_exists('wpf_get_current_user_information')) {
    function wpf_get_current_user_information($author_id='')
    {
        $response = array();
        if($author_id!=''){
            $user = get_userdata($author_id);
            $user_details = ( array )$user->data;
            $roles = ( array )$user->roles;
            $roles = array_values($roles);
            $response['display_name'] = $user_details['display_name'];
            $response['user_id'] = $user_details['ID'];
            $response['role'] = $roles[0];
            return $response;
        }
        elseif (is_user_logged_in() == true) {
            $user = wp_get_current_user();
            $user_details = ( array )$user->data;
            $roles = ( array )$user->roles;
            $roles = array_values($roles);
            $response['display_name'] = $user_details['display_name'];
            $response['user_id'] = $user_details['ID'];
            $response['role'] = $roles[0];
            return $response;
        } else {
            $response['display_name'] = 'Guest';
            $response['user_id'] = 0;
            $response['role'] = 'Guest';
            return $response;
        }
    }
}

/*
 * This function is used to get the time difference between two timestamps. It is basically used to get  the time difference between current time and the time when comment was posted.
 *
 * @input Timestamp, Timestamp
 * @return Array
 */
if (!function_exists('wpfb_time_difference')) {
    function wpfb_time_difference($datetime1, $datetime2)
    {
        $response = array();
        $interval = date_diff($datetime1, $datetime2);
        if ($interval->y == 0) {
            if ($interval->m == 0) {
                if ($interval->d == 0) {
                    if ($interval->h == 0) {
                        if ($interval->i == 0) {
                            $comment_time = $interval->s .__(' seconds ago','wpfeedback');
                        } else {
                            $comment_time = $interval->i .__(' minutes ago','wpfeedback');
                        }
                    } else {
                        $comment_time = $interval->h .__(' hours ago','wpfeedback');
                    }
                } else {
                    $comment_time = $interval->d . __(' days ago','wpfeedback');
                }
            } else {
                $comment_time = $interval->m . __(' months ago','wpfeedback');
            }
        } else {
            $comment_time = $interval->y . __(' years ago','wpfeedback');
        }
        $response['interval'] = $interval;
        $response['comment_time'] = $comment_time;
        return $response;
    }
}

/*
 * This function is used to get the listing of status and priorities inside the Tasks Center.
 *
 * @input String
 * @return String
 */
if (!function_exists('wp_feedback_get_texonomy_selectbox')) {
    function wp_feedback_get_texonomy_selectbox($my_term)
    {
        $terms = get_terms(array(
            'taxonomy' => $my_term,
            'hide_empty' => false,
        ));
        if (!empty($terms) && !is_wp_error($terms)) {
            echo '<select id="task_' . $my_term . '_attr" onchange="' . $my_term . '_changed(this);">';
            foreach ($terms as $term) {
                if($term->name=='In Progress'){
                    $term->name = 'In Prog';
                }elseif ($term->name=='Pending Review'){
                    $term->name = 'Pending';
                }else{
                    $term->name = $term->name;
                }
                echo '<option name="' . $my_term . '" value="' . $term->slug . '" class="wpf_task" id="wpf_' . $term->slug . '"/>' . __($term->name,'wpfeedback') . '</option>';
            }
            echo '</select>';
        }
    }
}

/*
 * This function is used to check if WP FeedBack is enabled on the website.
 *
 * @input Int
 * @return Boolean
 */
if (!function_exists('wpf_check_if_enable')) {
    function wpf_check_if_enable($author_id='')
    {
        if($author_id==''){
            $current_user_information = wpf_get_current_user_information();
            $user = wp_get_current_user();
        }
        else{
            $current_user_information = wpf_get_current_user_information($author_id);
            $user = get_userdata($author_id);
        }
        $current_role = $current_user_information['role'];
        $wpf_license = get_option('wpf_license');
        $wpf_enabled = get_option('wpf_enabled');
        $wpf_selcted_role = get_option('wpf_selcted_role');
        $wpf_allow_guest = get_option('wpf_allow_guest');
        $selected_roles = explode(',', $wpf_selcted_role);
        $roles = array();
        $user_details = ( array )$user->data;
        $roles = ( array )$user->roles;
        $roles = array_values($roles);

        if ($wpf_license == 'valid' && $wpf_enabled == 'yes' && ( !empty(array_intersect($roles, $selected_roles) ) || $wpf_allow_guest == 'yes')) {
            $wpf_access_output = 1;
        }else {
            $wpf_access_output = 0;
        }
        return $wpf_access_output;
    }
}

/*
 * This function is used to get extra user settings for the WP FeedBack.
 *
 * @input Object
 * @return NULL
 */
add_action( 'show_user_profile', 'wpf_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'wpf_show_extra_profile_fields' );
if (!function_exists('wpf_show_extra_profile_fields')) {
    function wpf_show_extra_profile_fields($user)
    {
        $selected_roles = get_option('wpf_selcted_role');
        $wpf_enabled = get_option('wpf_enabled');
        $selected_roles = explode(',', $selected_roles);
        if ((array_intersect($user->roles, $selected_roles) && $wpf_enabled == 'yes') || current_user_can('administrator'))       {
            $notifications_html = wpf_get_allowed_notification_list($user->ID, 'no');
            ?>
            <h3><?php _e('WP Feedback Information', 'wpfeedback'); ?></h3>

            <table class="form-table wpf_fields">
                <tr>
                    <?php $wpf_get_user_type = esc_attr(get_the_author_meta('wpf_user_type', $user->ID));
                    ?>
                    <th><label for="wpf_user_type"><?php _e("User Type",'wpfeedback'); ?></label></th>
                    <td>
                        <select id="wpf_user_type" name="wpf_user_type">
                            <option value="" <?php if ($wpf_get_user_type == '') {
                                echo 'selected';
                            } ?>><?php _e('Select','wpfeedback') ?>
                            </option>
                            <option value="king" <?php if ($wpf_get_user_type == 'king') {
                                echo 'selected';
                            } ?>><?php echo get_option('wpf_customisations_client') ? get_option('wpf_customisations_client') : 'Client (Website Owner)'; ?></option>
                            <option value="advisor" <?php if ($wpf_get_user_type == 'advisor') {
                                echo 'selected';
                            } ?>><?php echo get_option('wpf_customisations_webmaster') ? get_option('wpf_customisations_webmaster') : 'Webmaster'; ?></option>
                            <option value="council" <?php if ($wpf_get_user_type == 'council') {
                                echo 'selected';
                            } ?>><?php echo get_option('wpf_customisations_others') ? get_option('wpf_customisations_others') : 'Others'; ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="city"><?php _e("Email notifications",'wpfeedback'); ?></label></th>
                    <td>
                        <?php echo $notifications_html; ?>
                    </td>
                </tr>
            </table>
        <?php }
    }
}

/*
 * This function is used to save the extra user settings for the WP FeedBack.
 *
 * @input Int
 * @return Boolean
 */
add_action( 'personal_options_update', 'wpf_save_user_profile_fields' );
add_action( 'edit_user_profile_update', 'wpf_save_user_profile_fields' );
if (!function_exists('wpf_save_user_profile_fields')) {
    function wpf_save_user_profile_fields($user_id)
    {
        $user = get_userdata( $user_id );
        $selected_roles = get_option('wpf_selcted_role');
        $wpf_enabled = get_option('wpf_enabled');
        $selected_roles = explode(',', $selected_roles);
        if ((array_intersect($user->roles, $selected_roles) && $wpf_enabled == 'yes' && current_user_can('edit_user', $user_id)) || current_user_can('administrator')) {
            if ($_POST['wpf_user_type'] && ($_POST['wpf_user_type']=='king' || $_POST['wpf_user_type']=='advisor' || $_POST['wpf_user_type']=='council')) {
                update_user_meta($user_id, 'wpf_user_type', $_POST['wpf_user_type']);
            }else{
                update_user_meta($user_id, 'wpf_user_type', '');
            }
            /*foreach ($_POST as $key=>$val){
                $_POST[$key]=filter_var($val,FILTER_SANITIZE_STRING);
            }*/
            update_user_meta($user_id, 'wpf_every_new_task', $_POST['wpf_every_new_task']);
            update_user_meta($user_id, 'wpf_every_new_comment', $_POST['wpf_every_new_comment']);
            update_user_meta($user_id, 'wpf_every_new_complete', $_POST['wpf_every_new_complete']);
            update_user_meta($user_id, 'wpf_every_status_change', $_POST['wpf_every_status_change']);
            if(isset($_POST['wpf_daily_report'])){
                update_user_meta($user_id, 'wpf_daily_report', $_POST['wpf_daily_report']);
            }
            if(isset($_POST['wpf_weekly_report'])){
                update_user_meta($user_id, 'wpf_weekly_report', $_POST['wpf_weekly_report']);
            }
            if(isset($_POST['wpf_auto_daily_report'])){
                update_user_meta($user_id, 'wpf_auto_daily_report', $_POST['wpf_auto_daily_report']);
            }
            if(isset($_POST['wpf_auto_weekly_report'])){
                update_user_meta($user_id, 'wpf_auto_weekly_report', $_POST['wpf_auto_weekly_report']);
            }
        }else{
            return false;
        } 
    }
}

/*
 * This function is used to get the allowed notification list to be displayed on the users extra settings.
 *
 * @input Int, String
 * @return String
 */
if (!function_exists('wpf_get_allowed_notification_list')) {
    function wpf_get_allowed_notification_list($userid, $default = 'no')
    {
        /*global $current_user;
        $user = $current_user;*/
        $response = '';
        $wpf_every_new_task = get_option('wpf_every_new_task');
        $wpf_every_new_comment = get_option('wpf_every_new_comment');
        $wpf_every_new_complete = get_option('wpf_every_new_complete');
        $wpf_every_status_change = get_option('wpf_every_status_change');
        $wpf_daily_report = get_option('wpf_daily_report');
        $wpf_weekly_report = get_option('wpf_weekly_report');
        $wpf_auto_daily_report = get_option('wpf_auto_daily_report');
        $wpf_auto_weekly_report = get_option('wpf_auto_weekly_report');


        if ($wpf_every_new_task == 'yes') {
            if (get_the_author_meta('wpf_every_new_task', $userid) == 'yes') {
                $checked = 'checked';
            } else {
                $checked = '';
            }
            if ($default == 'yes') {
                $checked = 'checked';
            }
            $response .= '<div class="wpf_checkbox"><input type="checkbox" name="wpf_every_new_task" value="yes"
                           id="wpf_every_new_task" ' . $checked . ' /><label for="wpf_every_new_task">' . __('Receive email notification for every new task', 'wpfeedback') . '</label></div>';
        }
        if ($wpf_every_new_comment == 'yes') {
            if (get_the_author_meta('wpf_every_new_comment', $userid) == 'yes') {
                $checked = 'checked';
            } else {
                $checked = '';
            }
            if ($default == 'yes') {
                $checked = 'checked';
            }
            $response .= '<div class="wpf_checkbox"><input type="checkbox" name="wpf_every_new_comment" value="yes"
                           id="wpf_every_new_comment" ' . $checked . ' /><label for="wpf_every_new_comment">' . __('Receive email notification for every new comment', 'wpfeedback') . '</label></div>';
        }
        if ($wpf_every_new_complete == 'yes') {
            if (get_the_author_meta('wpf_every_new_complete', $userid) == 'yes') {
                $checked = 'checked';
            } else {
                $checked = '';
            }
            if ($default == 'yes') {
                $checked = 'checked';
            }
            $response .= '<div class="wpf_checkbox"><input type="checkbox" name="wpf_every_new_complete" value="yes"
                           id="wpf_every_new_complete" ' . $checked . ' /><label for="wpf_every_new_complete">' . __('Receive email notification when a task is marked as complete', 'wpfeedback') . '</label></div>';
        }
        if ($wpf_every_status_change == 'yes') {
            if (get_the_author_meta('wpf_every_status_change', $userid) == 'yes') {
                $checked = 'checked';
            } else {
                $checked = '';
            }
            if ($default == 'yes') {
                $checked = 'checked';
            }
            $response .= '<div class="wpf_checkbox"><input type="checkbox" name="wpf_every_status_change" value="yes"
                           id="wpf_every_status_change" ' . $checked . ' /><label for="wpf_every_status_change">' . __('Receive email notification for every status change', 'wpfeedback') . '</label></div>';
        }
        /*if($wpf_daily_report=='yes'){
            if(get_the_author_meta('wpf_daily_report', $userid) == 'yes'){
                $checked='checked';
            }
            else{
                $checked='';
            }
            if($default=='yes'){
                $checked='checked';
            }
            $response.='<div class="wpf_checkbox"><input type="checkbox" name="wpf_daily_report" value="yes"
                               id="wpf_daily_report" '.$checked.' /><label for="wpf_daily_report">'.__('Receive email notification for  daily report', 'wpfeedback').'</label></div>';
        }
        if($wpf_weekly_report=='yes'){
            if(get_the_author_meta('wpf_weekly_report', $userid) == 'yes'){
                $checked='checked';
            }
            else{
                $checked='';
            }
            if($default=='yes'){
                $checked='checked';
            }
            $response.='<div class="wpf_checkbox"><input type="checkbox" name="wpf_weekly_report" value="yes"
                               id="wpf_weekly_report" '.$checked.' /><label for="wpf_weekly_report">'.__('Receive email notification for weekly report', 'wpfeedback').'</label></div>';
        }*/
        if ($wpf_auto_daily_report == 'yes') {
            if (get_the_author_meta('wpf_auto_daily_report', $userid) == 'yes') {
                $checked = 'checked';
            } else {
                $checked = '';
            }
            if ($default == 'yes') {
                $checked = 'checked';
            }
            $response .= '<div class="wpf_checkbox"><input type="checkbox" name="wpf_auto_daily_report" value="yes"
                           id="wpf_auto_daily_report" ' . $checked . ' /><label for="wpf_auto_daily_report">' . __('Auto receive email notification for daily report', 'wpfeedback') . '</label></div>';
        }
        if ($wpf_auto_weekly_report == 'yes') {
            if (get_the_author_meta('wpf_auto_weekly_report', $userid) == 'yes') {
                $checked = 'checked';
            } else {
                $checked = '';
            }
            if ($default == 'yes') {
                $checked = 'checked';
            }
            $response .= '<div class="wpf_checkbox"><input type="checkbox" name="wpf_auto_weekly_report" value="yes"
                           id="wpf_auto_weekly_report" ' . $checked . ' /><label for="wpf_auto_weekly_report">' . __('Auto receive email notification for weekly report', 'wpfeedback') . '</label></div>';
        }

        return $response;
    }
}

/*
 * This function is used to get the WP FeedBack user type.
 *
 * @input NULL
 * @return String
 */
if (!function_exists('wpf_user_type')) {
    function wpf_user_type()
    {
        global $current_user;
        $wpf_get_user_type = '';
        $wpf_get_user_type = esc_attr(get_the_author_meta('wpf_user_type', $current_user->ID));
        return $wpf_get_user_type;
    }
}

/*
 * This function is used to verify if the uploaded file is valid or not.
 *
 * @input File
 * @return Boolean
 */
if (!function_exists('wpf_verify_file_upload')) {
    function wpf_verify_file_upload($server, $file_data)
    {
        $allowed_file_types = array('image/jpeg', 'image/png', 'image/gif', 'application/pdf', 'text/plain', 'application/octet-stream', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','video/webm','video/mp4','video/mov','video/wmv','video/avi');
            if (function_exists('finfo_open')) {
                // $response=0;
                $imgdata = base64_decode($file_data);
                $f = finfo_open();

                $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);
                if (in_array($mime_type, $allowed_file_types)) {
                    $response = 0;
                } else {
                    $response = 1;
                }
            } else {
                $response = 0;
            }
        return $response;
    }
}

/*
 * This function is used to verify if the uploaded file extension is proper or not.
 *
 * @input String
 * @return Boolean
 */
if (!function_exists('wpf_verify_file_upload_type')) {
    function wpf_verify_file_upload_type($server, $mime_type)
    {
        $allowed_file_types = array('image/jpeg', 'image/png', 'image/gif', 'application/pdf', 'text/plain', 'application/octet-stream', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','video/webm','video/mp4','video/mov','video/wmv','video/avi');
            if (!empty($mime_type)) {
                if (in_array($mime_type, $allowed_file_types)) {
                    $response = 0;
                } else {
                    $response = 1;
                }
            } else {
                $response = 0;
            }
        return $response;
    }
}

/*
 * This function is used to get the list of the pages on the website. It is called to get the dropdown list when creating a general task from backend.
 *
 * @input String
 * @return JSON
 */
if (!function_exists('wpf_get_page_list')) {
    function wpf_get_page_list($type='task_page')
    {
        $response = array();

        if ( class_exists( 'WooCommerce' ) ) {
            $wpf_default_wp_post_types = array("page" => "page", "post" => "post", "product" => "product");
        }else {
            $wpf_default_wp_post_types = array("page" => "page", "post" => "post");
        }

        $wpf_wp_cpts = get_post_types(array('public' => true, 'exclude_from_search' => true, '_builtin' => false));
        $wpf_post_types = array_merge($wpf_default_wp_post_types, $wpf_wp_cpts);


        foreach ($wpf_post_types as $wpf_post_type) {
            $objType = get_post_type_object($wpf_post_type);
            if($wpf_post_type == 'page'){
                $numberposts = -1;
            }
            else{
                $numberposts = 10;
            }
            $wpf_temp_arg = array(
                'post_type' => $wpf_post_type,
                'numberposts' => $numberposts,
            );
            $posts = get_posts($wpf_temp_arg);
            $wpf_count_post = count($posts);
            if ($wpf_count_post) {
                foreach ($posts as $post) {
                    if($type=='task_page') {
                        $response[$objType->labels->singular_name][$post->ID] = htmlspecialchars($post->post_title, ENT_QUOTES, 'UTF-8');
                    }
                    else{
                        $temp_res = array(
                            'id' => $post->ID,
                            'name' => htmlspecialchars($post->post_title, ENT_QUOTES, 'UTF-8'),
                            'type' => $objType->labels->singular_name
                        );
                        $response[] = $temp_res;
                    }
                }
            }
        }
        return json_encode($response);
    }
}

/*
 * This function is used to deregister the scripts of the plugins that are conflicting with the WP FeedBack.
 *
 * @input NULL
 * @return NULL
 */
if (!function_exists('wpf_mootools_deregister_javascript')) {
    function wpf_mootools_deregister_javascript()
    {
        if (!is_admin()) {
            wp_deregister_script('mootools-local');
            wp_deregister_script('enlighter-local');
            wp_deregister_script('dct-carousel-jquery');
            wp_deregister_script('onepress-js-plugins');
        }
    }
}
add_action( 'wp_print_scripts', 'wpf_mootools_deregister_javascript', 99 );

/*
 * This function is used to strip all the code elements from the data.
 *
 * @input String
 * @return String
 */
if (!function_exists('wpf_test_input')) {
    function wpf_test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

/*
 * This function is used by all the ajax request to make user that they are coming from authentic source.
 *
 * @input NULL
 * @return String
 */
function wpf_security_check(){
    $roles = array();
    $user = wp_get_current_user();
    $user_details = ( array )$user->data;
    $roles = ( array )$user->roles;
    $roles = array_values($roles);
    if ( ! check_ajax_referer( 'wpfeedback-script-nonce', 'wpf_nonce' ) ) {
        echo 'Invalid security token sent.';
        wp_die();
    }
    else{
        $currnet_user_information = wpf_get_current_user_information();

        $selected_roles = get_option('wpf_selcted_role');
        $selected_roles = explode(',', $selected_roles);
        if (!in_array("administrator", $selected_roles)) {
            array_push($selected_roles,"administrator");
        }
        $wpf_allow_guest = get_option('wpf_allow_guest');
        if($wpf_allow_guest=='yes'){
            $selected_roles[]='Guest';
            $roles[] = 'Guest';
        }

        if(empty(array_intersect($roles, $selected_roles))){
            echo 'Invalid user.';
            wp_die();
        }
/*        if(!in_array($currnet_user_information['role'], $selected_roles) ){
            echo 'Invalid user.';
            wp_die();
        }*/
    }
}

add_filter( 'get_comment_text', 'make_clickable', 99 );

/*
 * This function is to get the listing of status and priority for the sidebar filters.
 *
 * @input String
 * @return String
 */
if (!function_exists('wp_feedback_get_texonomy_filter')) {
    function wp_feedback_get_texonomy_filter($my_term)
    {
        $output = '';
        $terms = get_terms(array(
            'taxonomy' => $my_term,
            'hide_empty' => false,
            'orderby'  => 'id',
        ));
        if (!empty($terms) && !is_wp_error($terms)) {
           $output .=  '<ul class="wpf_filter_checkbox" id="wpf_sidebar_filter_'.$my_term.'">';
            foreach ($terms as $term) {
                if($term->name=='In Progress'){
                    $term->name = 'In Prog';
                }elseif ($term->name=='Pending Review'){
                    $term->name = 'Pending';
                }else{
                    $term->name = $term->name;
                }
                $output .= '<li><input type="checkbox" name="wpf_filter_' . $my_term . '" value="' . $term->slug . '" class="wp_feedback_task" id="wpf_sidebar_filter_' . $term->slug . '" /><label for="wpf_sidebar_filter_' . $term->slug . '">' . __($term->name, 'wpfeedback') . '</label></li>';
            }
            $output .= '</ul><a class="wpf_sidebar_filter_reset_'.$my_term.'" href="javascript:void(0)">'.__('Reset', 'wpfeedback').'</a>';
            return $output;
        }
    }
}

/*
 * This function is used to encrypt and decrypt the license key.
 *
 * @input String, String
 * @return String
 */
function wpf_crypt_key( $string, $action = 'e' ) {
    $wpf_decr_key = get_option('wpf_decr_key');
    $wpf_decr_checksum = get_option('wpf_decr_checksum');

    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $wpf_decr_key );
    $iv = substr( hash( 'sha256', $wpf_decr_checksum ), 0, 16 );

    if( $action == 'e' ) {
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }
    else if( $action == 'd' ){
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }

    return $output;
}

/*========WPF Login Form========*/
/*
 * This function is used to get the login form.
 *
 * @input NULL
 * @return String
 */
function wpf_login_form(){
    $output = '';
    $wpf_enabled = get_option('wpf_enabled');
    if(!is_user_logged_in() && $wpf_enabled == 'yes'){
        $output = '<div id="login_form_content"><p><b>Dive straight into the feedback!</b></br>Login below and you can start commenting using your own user instantly</p><form id="wpf_login" method="post"><div class="wpf_user"><label for="username"></label><input id="username" placeholder="Username OR Email Address" type="text" name="username"></div><div class="wpf_password"><label for="password"></label><input id="password" placeholder="Password" type="password" name="password"></div>'. wp_nonce_field( 'wpfeedback-script-nonce', 'wpf_security', true, false ).'<input class="wpf_submit_button" type="submit" value="Login and start commenting" name="submit"><p class="wpf_status"></p></form></div>';
    }
    return $output;
}
add_shortcode('wpf_login_form','wpf_login_form');

// used for tracking error messages
/*
 * This function is used to manage the errors generated while logging in from WP FeedBack login modal.
 *
 * @input NULL
 * @return String
 */
function wpf_user_errors(){
    static $wp_error; // Will hold global variable safely
    return isset($wp_error) ? $wp_error : ($wp_error = new WP_Error(null, null, null));
}

/*
 * This function is used to handle login from the WP FeedBack login modal.
 *
 * @input NULL
 * @return JSON
 */
function wpf_ajax_login(){
    global $wpdb;
    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'wpfeedback-script-nonce', 'wpf_security' );

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;
    $user_name = $_POST['username'];
    $user_login ='';
    $user = '';
    //$user = get_userdatabylogin($_POST['username']);
    $resultsap = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}users WHERE user_login = %s OR user_email = %s limit 1", $user_name, $user_name ) , ARRAY_A);
    if($resultsap){
        $user_login = ($resultsap[0][user_login] );
        // this returns the user_login name and other info from the user name
        $user = get_userdatabylogin($user_login);
    }
    if(!$user) {
        // if the user name doesn't exist
        wpf_user_errors()->add('empty_username', __('Invalid username'));
    }

    if(!isset($_POST['password']) || $_POST['password'] == '') {
        // if no password was entered
        wpf_user_errors()->add('empty_password', __('Please enter a password'));
    }

    // check the user's login with their password
    if(!wp_check_password($_POST['password'], $user->user_pass, $user->ID)) {
        // if the password is incorrect for the specified user
        wpf_user_errors()->add('empty_password', __('Incorrect password'));
    }
    // retrieve all error messages
    $errors = wpf_user_errors()->get_error_messages();
    //$user_signon = wp_signon( $info, false );
    if ( !empty($errors) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
    } else {
        wp_setcookie($user_login, $_POST['password'], true);
        wp_set_current_user($user->ID, $_POST['username']);
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...')));
    }
    die();
}
// Enable the user with no privileges to run ajax_login() in AJAX
add_action( 'wp_ajax_nopriv_wpf_ajaxlogin', 'wpf_ajax_login' );

/*
 * This function is used to start the color picker.
 *
 * @input NULL
 * @return NULL
 */
add_action( 'wp_enqueue_scripts', 'wpf_enqueue_color_picker' );
function wpf_enqueue_color_picker( $hook_suffix ) {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'iris', admin_url( 'js/iris.min.js' ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false, 1 );
}

/*=====================Graphics feature Start=====================*/
/*
 * This function is used to get the list of the graphics version on the graphics cpt.
 *
 * @input Int
 * @return String
 */
function wpf_grapgics_version_list($post_id){
    global $post;
    $output='';
    $i = '';
    $all_graphics_ids_array = array();
    $get_current_graphics = get_post_meta($post_id,'_thumbnail_id',true);
    $all_graphics_ids_string = get_post_meta($post_id,'_wpf_graphics_img_id',true);
    if($all_graphics_ids_string){
        $all_graphics_ids_array = explode(',',$all_graphics_ids_string);
        $i = count($all_graphics_ids_array);
        $current_version = $i+1;
        $output =  '<select id="wpf_graphics_version" onchange="change_graphics_version(this)"> <option name="wpf_graphics_id" value="' . $get_current_graphics . '" class="wpf_graphics_version">' . __("Version","wpfeedback") . ' '.$current_version.'</option> ';
        rsort($all_graphics_ids_array);
        foreach ($all_graphics_ids_array as $all_graphics_id) {
            $output .= '<option name="wpf_graphics_id" value="' . $all_graphics_id . '" class="wpf_graphics_version" > ' .__("Version","wpfeedback") . " " .$i.' </option>';
            $i--;
        }
        $output .= '</select>';
    }else{
         $output = '<select id="wpf_graphics_version" onchange="change_graphics_version(this)">';
         $output .= '<option name="wpf_graphics_id" value="' . $get_current_graphics . '" class="wpf_graphics_version" >' . __("Version 1","wpfeedback") . " ".$i.'</option>';
          $output .= '</select>';
    }
    return $output;
}

/*
 * This function is used to define all the tags and theme color for WP FeedBack.
 *
 * @input NULL
 * @return NULL
 */
function wpf_all_tags(){
    $task_list_tags_array = '';
    $wpf_task_tags_obj = $terms = get_terms(array(
            'taxonomy' => 'wpf_tag',
            'hide_empty' => false,
        ));
    if ( ! empty( $wpf_task_tags_obj ) && ! is_wp_error( $wpf_task_tags_obj ) ) {
        //$task_list_tags_array = '["';
        $task_list_tags_array .= implode('","',wp_list_pluck($wpf_task_tags_obj, 'name'));
        //$task_list_tags_array .= '"]';
    }?>
    <script type="text/javascript">var wpf_all_tags = ["<?php echo $task_list_tags_array; ?>"]; </script>
    <style type="text/css">
        :root {
            --main-wpf-color: #<?php echo get_option('wpf_color'); ?>;
            --seco-bg-color: #8cb54b;
        }
    </style>
    <?php 
}
add_action('wp_footer','wpf_all_tags');
add_action('admin_footer','wpf_all_tags');

/*
 * This function is used to get the unique elements from the object.
 *
 * @input Array, Boolean
 * @return Array
 */
function wpf_object_array_unique($array, $keep_key_assoc = false){
    $duplicate_keys = array();
    $tmp = array();

    foreach ($array as $key => $val){
        if (is_object($val))
            $val = (array)$val;

        if (!in_array($val, $tmp))
            $tmp[] = $val;
        else
            $duplicate_keys[] = $key;
    }

    foreach ($duplicate_keys as $key)
        unset($array[$key]);

    return $keep_key_assoc ? $array : array_values($array);
}

/*
 * This function is used to check if the caching plugin is active on the website and deregister the WP FeedBack CSS and JS if found.
 *
 * @input NULL
 * @return NULL
 */
function wpf_check_for_caching_plugin() {
    if ( is_plugin_active('wp-rocket/wp-rocket.php') ) {
        $wp_rocket_settings = get_option('wp_rocket_settings');
        $wp_rocket_settings['exclude_css'][] = '/wp-content/plugins/wpfeedback/css/(.*).css';
        $wp_rocket_settings['exclude_js'][] = '/wp-content/plugins/wpfeedback/js/(.*).js';
        update_option('wp_rocket_settings',$wp_rocket_settings);
    }

    if ( is_plugin_active('fast-velocity-minify/fvm.php') ) {
        $wpf_fvm_options = get_option('fastvelocity_min_ignorelist');
        $wpf_update_fastvelocity_option = get_option('wpf_update_fastvelocity_option');
        $wpf_fvm_options = explode(PHP_EOL, $wpf_fvm_options);
        array_push($wpf_fvm_options,'/wpfeedback/');
        if($wpf_update_fastvelocity_option != 'yes'){
            update_option('wpf_update_fastvelocity_option', 'yes','no');
            update_option('fastvelocity_min_ignorelist', implode(PHP_EOL, $wpf_fvm_options));

        }
    }
    if ( is_plugin_active('breeze/breeze.php') ) {
        $get_breeze_advanced_settings = get_option('wpf_update_breeze_option');
        $breeze_advanced_settings = get_option('breeze_advanced_settings');
        $breeze_advanced_settings['breeze-exclude-css'][] = '/wp-content/plugins/wpfeedback/css/(.*).css';
        $breeze_advanced_settings['breeze-exclude-js'][] = '/wp-content/plugins/wpfeedback/js/(.*).js';
        if($get_breeze_advanced_settings != 'yes'){
        update_option('breeze_advanced_settings',$breeze_advanced_settings);
        update_option('wpf_update_breeze_option', 'yes','no');
        }
    }
    if (defined('WPFC_WP_PLUGIN_DIR')) {
        $rules_std = array();

        $new_rule1 = new stdClass;
        $new_rule2 = new stdClass;
        $new_rule1->prefix = "contain";
        $new_rule1->content = "wp-content/plugins/wpfeedback/css";
        $new_rule1->type = "css";
        $new_rule2->prefix = "contain";
        $new_rule2->content = "wp-content/plugins/wpfeedback/js";
        $new_rule2->type = "js";

        $wpfeedback_WpFastestCache_save = get_option("wpf_WpFastestCache_option");
        if($wpfeedback_WpFastestCache_save != 'true'){
            $get_rules_json = get_option("WpFastestCacheExclude");
            if($get_rules_json === false) {
                array_push($rules_std, $new_rule1);
                array_push($rules_std, $new_rule2);
                update_option("WpFastestCacheExclude", json_encode($rules_std), "yes");
                update_option("wpf_WpFastestCache_option", 'true', "no");
            }else{
                $rules_std = json_decode($get_rules_json);

                if(!is_array($rules_std)){
                    $rules_std = array();
                }
                array_push($rules_std, $new_rule1);
                array_push($rules_std, $new_rule2);
                update_option("WpFastestCacheExclude", json_encode($rules_std), "yes");
                update_option("wpf_WpFastestCache_option", 'true', "no");
            }
        }
    }
}
add_action( 'admin_init', 'wpf_check_for_caching_plugin' );

/*
 * This function is used to get the count of comments for post.
 *
 * @input Int, Int
 * @return Int
 */
add_action( 'wp_count_comments','wpfeedback_filter_comment_count', 20, 2 );
function wpfeedback_filter_comment_count( $stats, $post_id ) {
    global $wpdb;

    if ( 0 === $post_id ) {
        $stats = wpfeedback_get_comment_count();
    }

    return $stats;
}

/*
 * This function is used to get the count of the comment.
 *
 * @input NULL
 * @return Int
 */
function wpfeedback_get_comment_count() {
    global $wpdb;

    $stats = get_transient( 'wpfeedback_comment_count' );
    if ( ! $stats ) {
        $stats = array();

        $count = $wpdb->get_results( "SELECT comment_approved, COUNT( * ) AS num_comments FROM {$wpdb->comments} WHERE comment_type NOT IN('wp_feedback') GROUP BY comment_approved", ARRAY_A );

        $total = 0;
        $stats = array();
        $approved = array( '0' => 'moderated', '1' => 'approved', 'spam' => 'spam', 'trash' => 'trash', 'post-trashed' => 'post-trashed' );

        foreach ( (array) $count as $row ) {
            // Don't count post-trashed toward totals
            if ( 'post-trashed' != $row['comment_approved'] && 'trash' != $row['comment_approved'] ) {
                $total += $row['num_comments'];
            }
            if ( isset( $approved[ $row['comment_approved'] ] ) ) {
                $stats[ $approved[ $row['comment_approved'] ] ] = $row['num_comments'];
            }
        }

        $stats['total_comments'] = $total;
        $stats['all']            = $total;

        foreach ( $approved as $key ) {
            if ( empty( $stats[ $key ] ) ) {
                $stats[ $key ] = 0;
            }
        }

        $stats = (object) $stats;
        set_transient( 'wpfeedback_comment_count', $stats );
    }

    return $stats;
}

/*
 * This function is used create the options for the bulk updates of status and priority.
 *
 * @input String
 * @return String
 */
if (!function_exists('wpf_bulk_update_get_texonomy_selectbox')) {
    function wpf_bulk_update_get_texonomy_selectbox($my_term)
    {
        $terms = get_terms(array(
            'taxonomy' => $my_term,
            'hide_empty' => false,
        ));
        if (!empty($terms) && !is_wp_error($terms)) {
            echo '<select id="task_' . $my_term . '_attr" ><option name="' . $my_term . '" value="" class="wpf_task" id="wpf_critical">'. __("Select Option","wpfeedback").'</option>';
            foreach ($terms as $term) {
                if($term->name=='In Progress'){
                    $term->name = 'In Prog';
                }elseif ($term->name=='Pending Review'){
                    $term->name = 'Pending';
                }else{
                    $term->name = $term->name;
                }
                echo '<option name="' . $my_term . '" value="' . $term->slug . '" class="wpf_task" id="wpf_' . $term->slug . '"/>' . __($term->name,'wpfeedback') . '</option>';
            }
            echo '</select>';
        }
    }
}

/*
 * This function is used to remove the CSS of WP Feedback on Graphics Page if Astra Theme is detected.
 *
 * @input NULL
 * @return String
 */
add_filter( 'style_loader_src', 'wpf_remove_astra_css_on_grapgics_page',10,1);
function wpf_remove_astra_css_on_grapgics_page($href){
    if(is_singular('wpf_graphics')) {
        if (strpos($href, "style.min.css") == true) {
            return $href ='';
        }
    }
    return $href;
};