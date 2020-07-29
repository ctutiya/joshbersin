<?php
/*
 * wpf_ajax_functions.php
 * This file contains the code for all methods that are been called from the frontend using ajax requests.
 */

/*
 * This function is used to load the tasks on the "Tasks Center". It is been called from function wpf_backed_scripts() wpfeedback.php
 *
 * @input NULL
 * @return String ( Listing of Task Embedded with HTML Elements.)
 */
add_action('wp_ajax_wpfeedback_get_post_list_ajax', 'wpfeedback_get_post_list_ajax');
add_action('wp_ajax_nopriv_wpfeedback_get_post_list_ajax', 'wpfeedback_get_post_list_ajax');
if (!function_exists('wpfeedback_get_post_list_ajax')) {
    function wpfeedback_get_post_list_ajax()
    {
        global $wpdb, $current_user;
        $output = '';
        $post_title_query = '';
        if(is_user_logged_in() && is_admin()){
            wpf_security_check();
            $all_task_types_array = array('publish','wpf_admin');
            $all_task_types_meta = '';
            $all_task_types_meta_array = array();
            //$all_task_types_array = explode(",", $all_task_types);
            $all_task_types_string = "'" . implode("', '", $all_task_types_array) . "'";

            if ($_POST['task_types'] != '') {
                $all_task_types = $_POST['task_types'];
                $all_task_types_array = explode(",", $all_task_types);
                $all_task_types_string = "'" . implode("', '", $all_task_types_array) . "'";
            }

            if ($_POST['task_types_meta'] != '') {
                $task_types_meta = $_POST['task_types_meta'];
                $all_task_types_meta_array = explode(",", $task_types_meta);
                $all_task_types_meta_string = "'" . implode("', '", $all_task_types_meta_array) . "'";
            }
            //echo $all_task_types_string; exit;
            //echo $all_task_types_string; exit;
            $allStatus = array('complete', 'open', 'pending-review', 'in-progress', 'critical', 'high', 'low', 'medium');
            if ($_POST['task_status'] != '') {
                $task_status = $_POST['task_status'];
                $task_status_array = explode(",", $task_status);
                $task_status = $task_status_array;
            } else {
                $task_status = array('complete', 'open', 'pending-review', 'in-progress');
            }

            if ($_POST['task_priority'] != '') {
                $task_priority = $_POST['task_priority'];
                $task_priority_array = explode(",", $task_priority);
                $task_priority = $task_priority_array;
            } else {
                $task_priority = array('critical', 'high', 'low', 'medium');
            }

            if ($_POST['author_list'] != '') {
                $author_list = $_POST['author_list'];
                $author_list_array = explode(",", $author_list);
                $author_list = $author_list_array;
            } else {
                $author_list = array();
            }

            if($_POST['task_title'] != ''){
                $task_title = $_POST['task_title'];
            }

            $meta_query = '';
            $i = 1;
            $count_author = count($author_list);
            foreach ($author_list as $key) {
                if ($i == 1) {
                    $meta_query .= ' AND ( ';
                }
                $meta_query .= "find_in_set($key,meta_value) <> 0";
                if ($i < $count_author) {
                    $meta_query .= " OR ";

                }
                if ($i == $count_author && $count_author > 0) {
                    $meta_query .= ' )';
                }
                $i++;
            }
            $task_status_meta = "'" . implode("', '", $task_status) . "'";
            $task_priority_meta = "'" . implode("', '", $task_priority) . "'";
            $query = "SELECT DISTINCT p.ID, p.* FROM {$wpdb->prefix}posts as p JOIN {$wpdb->prefix}postmeta as pm on pm.post_id = p.ID WHERE p.post_type = 'wpfeedback' AND pm.meta_key LIKE 'task_notify_users' $meta_query AND p.post_status IN ($all_task_types_string)";
            $comment_info = $wpdb->get_results($query, OBJECT);

            foreach ($comment_info as $key => $wpf_post) {
                $wpf_post_ids[] = $wpf_post->ID;
            }
            $count_comment = count($wpf_post_ids);
            $all_post = implode(',', $wpf_post_ids);
            if($count_comment == 0 && $_POST['author_list'] != ''){
                $wpf_post_ids = array(-1);
            }
            /*print_r($all_task_types_array);
            exit;*/
            if (in_array('general', $all_task_types_meta_array) AND in_array('graphics', $all_task_types_meta_array)) {
                $args = array(
                    'numberposts' => -1, // -1 is for all
                    'post_type' => 'wpfeedback',
                    'post_status' => $all_task_types_array,
                    'post__in' => $wpf_post_ids,
                    'orderby' => 'title',
                    'order' => 'DESC', // or 'DESC'
                    /*'author__in'  => $author_list,*/
                    'orderby' => 'date',
                    'meta_query' => array(
                        array(         // restrict posts based on meta values
                            'key' => 'task_type',  // which meta to query
                            'value' => array ( 'general', 'graphics' ),
                             // value for comparison
                            'compare' => 'IN',          // method of comparison
                        )
                    ),
                    'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'task_status',
                            'field' => 'slug',
                            'terms' => $task_status,
                        ),
                        array(
                            'taxonomy' => 'task_priority',
                            'field' => 'slug',
                            'terms' => $task_priority,
                        )
                    )
                );
            }
            elseif (in_array('general', $all_task_types_meta_array)) {
                $args = array(
                    'numberposts' => -1, // -1 is for all
                    'post_type' => 'wpfeedback',
                    'post_status' => $all_task_types_array,
                    'post__in' => $wpf_post_ids,
                    'orderby' => 'title',
                    'order' => 'DESC', // or 'DESC'
                    /*'author__in'  => $author_list,*/
                    'orderby' => 'date',
                    'meta_query' => array(
                        array(         // restrict posts based on meta values
                            'key' => 'task_type',  // which meta to query
                            'value' => 'general',  // value for comparison
                            'compare' => '=',          // method of comparison
                        )
                    ),
                    'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'task_status',
                            'field' => 'slug',
                            'terms' => $task_status,
                        ),
                        array(
                            'taxonomy' => 'task_priority',
                            'field' => 'slug',
                            'terms' => $task_priority,
                        )
                    )
                );
            }
            elseif(in_array('graphics', $all_task_types_meta_array)){
                $args = array(
                    'numberposts' => -1, // -1 is for all
                    'post_type' => 'wpfeedback',
                    'post_status' => $all_task_types_array,
                    'post__in' => $wpf_post_ids,
                    'orderby' => 'title',
                    'order' => 'DESC', // or 'DESC'
                    /*'author__in'  => $author_list,*/
                    'orderby' => 'date',
                    'meta_query' => array(
                        array(         // restrict posts based on meta values
                            'key' => 'task_type',  // which meta to query
                            'value' => 'graphics',  // value for comparison
                            'compare' => '=',          // method of comparison
                        )
                    ),
                    'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'task_status',
                            'field' => 'slug',
                            'terms' => $task_status,
                        ),
                        array(
                            'taxonomy' => 'task_priority',
                            'field' => 'slug',
                            'terms' => $task_priority,
                        )
                    )
                );
            } 
            else{
                if($count_comment == 0 ){
                        $args = array(
                        'numberposts' => 0, // -1 is for all
                        'post_type' => 'wpfeedback',
                        'post_status' => $all_task_types_array,
                        'post__in' => $wpf_post_ids,
                        'orderby' => 'title',
                        'order' => 'DESC', // or 'DESC'
                        /*'author__in'  => $author_list,*/
                        'orderby' => 'date',
                        'tax_query' => array(
                            'relation' => 'AND',
                            array(
                                'taxonomy' => 'task_status',
                                'field' => 'slug',
                                'terms' => $task_status,
                            ),
                            array(
                                'taxonomy' => 'task_priority',
                                'field' => 'slug',
                                'terms' => $task_priority,
                            )
                        )
                    );
                }
                else{
                    $args = array(
                        'numberposts' => -1, // -1 is for all
                        'post_type' => 'wpfeedback',
                        'post_status' => $all_task_types_array,
                        'post__in' => $wpf_post_ids,
                        'orderby' => 'title',
                        'order' => 'DESC', // or 'DESC'
                        /*'author__in'  => $author_list,*/
                        'orderby' => 'date',
                        'tax_query' => array(
                            'relation' => 'AND',
                            array(
                                'taxonomy' => 'task_status',
                                'field' => 'slug',
                                'terms' => $task_status,
                            ),
                            array(
                                'taxonomy' => 'task_priority',
                                'field' => 'slug',
                                'terms' => $task_priority,
                            )
                        )
                    );
                }    
            }    
            // Get the posts
            if($task_title!=""){
                $task_title_arr = explode(' ',$task_title);
                if(count($task_title_arr)>1){
                    $task_title_query['s'] = $task_title;
                    $args = array_merge($task_title_query, $args);
                    $myposts = get_posts($args);
                    foreach ($task_title_arr as $keyword){
                        $args['s']=$keyword;
                        $task_title_query['s'] = $keyword;
                        $args = array_merge($task_title_query, $args);
                        $myposts_temp = get_posts($args);
                        $myposts = array_merge($myposts, $myposts_temp);
                    }
                    $myposts = wpf_object_array_unique($myposts);
                }
                else{
                    $task_title_query['s'] = $task_title;
                    $args = array_merge($task_title_query, $args);
                    $myposts = get_posts($args);
                }

            }
            else{
                $myposts = get_posts($args);
            }
            if ($myposts):
                // Loop the posts
                $i = count($myposts);
                $output .= '<ul id="all_wpf_list" style="list-style-type: none; font-size:12px;">';
                foreach ($myposts as $mypost):
                    $post_id = $mypost->ID;
                    $get_post_date = $mypost->post_date;
                    $date = date_create($get_post_date);
                    $post_date = date_format($date, "d/m/Y H:i");
                    $author_id = $mypost->post_author;
                    $post_title = $mypost->post_title;
                    $task_page_url = get_post_meta($post_id, "task_page_url", true);
                    $wpf_task_screenshot = get_post_meta($post_id, "wpf_task_screenshot", true);
                    $task_page_title = get_post_meta($post_id, "task_page_title", true);
                    $task_config_author_name = get_post_meta($post_id, "task_config_author_name", true);
                    $task_notify_users = get_post_meta($post_id, "task_notify_users", true);
                    $task_config_author_resX = get_post_meta($post_id, "task_config_author_resX", true);
                    $task_config_author_resY = get_post_meta($post_id, "task_config_author_resY", true);
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

                    $output .= '<li class="post_' . $post_id . ' ' . $task_status[0]->slug . ' wpf_list"><a href="javascript:void(0)" class="'.$task_status[0]->slug.'"  id="wpf-task-' . $post_id . '"  data-wpf_task_screenshot="'.$wpf_task_screenshot.'" data-wpf_task_status=' . $wpf_task_status . ' data-task_type="' . $task_type . '" data-task_author_name="' . $task_config_author_name . '" data-task_config_author_ipaddress=' . $task_config_author_ipaddress . ' data-task_config_author_browserVersion=' . $task_config_author_browserVersion . ' data-task_config_author_res="' . $task_config_author_resX . ' X ' . $task_config_author_resY . '" data-task_config_author_browser="' . $task_config_author_browser . '" data-task_config_author_name="' .__('By ', 'wpfeedback'). $task_config_author_name . " " . $post_date . '" data-task_notify_users="' . $task_notify_users . '" data-task_page_url="' . $task_page_url . '" data-task_page_title="' . $post_title . '" data-task_priority="' . $task_priority[0]->slug . '" data-task_status="' . $task_status[0]->slug . '" onclick="get_wpf_chat(this,true)" data-postid="' . $post_id . '" data-uid="' . $author_id . '"  data-task_no=' . $task_comment_id . '><div class="wpf_chat_top"><input type="checkbox" value="'.$post_id.'" name="wpf_task_id" id="wpf_'.$post_id.'" class="wpf_task_id" style="display:none;"><div class="wpf_task_num_top">' . $bubble_label . '</div><div class="wpf_task_main_top"><div class="wpf_task_details_top">By ' . $author . ' <span>' .$curr_task_time['comment_time'].'</span></div><div class="wpf_task_pagename">' . $task_page_title . ' </div><div class="wpf_task_title_top">' . $post_title . '</div></div><div class="wpf_task_meta"><div class="wpf_task_meta_icon"><i class="gg-chevron-left"></i></div><div class="wpf_task_meta_details">'. ' ' . $admin_tag . ' ' . $general .$wpf_task_status_label.$wpf_task_priority_label.$wpfb_tags_html.'</div></div></div></a></li>';
                    $i--;
                endforeach;
                wp_reset_postdata();
                $output .= '</ul>';
            endif;
            if ($_POST['task_status'] || $_POST['task_priority'] || $_POST['author_list']) {
                //Comment
                echo $output;
                exit;
            } else {
                //Comment
                echo $output;
                exit;
            }
        }else{
            echo $output;
            exit;
        }
    }
}

/*
 * This function is used to load the task comments on the "Tasks Center". It is been called from function wpf_backed_scripts() in wpfeedback.php
 *
 * @input Array ( $_POST )
 * @return String ( Listing of Comments in Task Embedded with HTML Elements.)
 */
add_action('wp_ajax_list_wpf_comment_func', 'list_wpf_comment_func');
if (!function_exists('list_wpf_comment_func')) {
    function list_wpf_comment_func()
    {
        if(is_user_logged_in() && is_admin()){
            global $wpdb, $current_user;
            wpf_security_check();
            $response = array();
            $response['data'] = '';
            $comment = "";
            $post_id = $_POST['post_id'];
            $post_author_id = $_POST['post_author_id'];
            $click = $_POST['click'];
            $current_user_id = $current_user->ID;
            if ($post_id) {

                $wpf_task_tags_obj = get_the_terms( $post_id, 'wpf_tag' );
                if ( ! empty( $wpf_task_tags_obj ) && ! is_wp_error( $wpf_task_tags_obj ) ) {
                    foreach ( $wpf_task_tags_obj as $term ) {
                        $response['wpf_tags'] .= '<span class="wpf_tag_name '.$term->slug.'">'.$term->name.'<a href="javascript:void(0)" onclick="wpf_delete_tag(\''.$term->name.'\',\''.$term->slug.'\','.$post_id.')" data-tag_slug="'.$term->slug.'"><i class="gg-close-o"></i></a></span>';
                    }
                    //$response['task_list_tags'] = wp_list_pluck($wpf_task_tags_obj, 'name');
                }else{
                    $response['wpf_tags'] = '';
                }
                //$response['task_list_tags'] = $task_list_tags_array;
                //Old Logic to get comment list in admin side. Was creating issues Security
                /*$comment_info = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}comments WHERE comment_approved = 1 AND comment_post_ID =$post_id AND comment_type LIKE 'wp_feedback'  ORDER BY comment_ID ASC");*/
                $args = array(
                    'post_id' => $post_id,
                    'type' => 'wp_feedback',
                    'orderby'  => 'comment_date',
                    'order' => 'ASC',
                );
                $comments_info = get_comments( $args );
                // display the results
                if ($comments_info) {
                    foreach ($comments_info as $comment) {
                        $task_date = get_comment_date('Y-m-d H:i:s', $comment->comment_ID);
                        $task_date1 = date_create($task_date);
                        //Old Logic to get current time. Was creating issues when displaying message
                        //$task_date2 = new DateTime('now');

                        //New Logic to get current time.
                        $wpf_wp_current_timestamp = date('Y-m-d H:i:s', current_time('timestamp', 0));
                        $task_date2 = date_create($wpf_wp_current_timestamp);

                        $curr_comment_time = wpfb_time_difference($task_date1, $task_date2);
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
                            $temp_filetype = wp_check_filetype($comment->comment_content);
                            $file_name = preg_replace('/\.[^.]+$/', '', basename($comment->comment_content));
                            if ($temp_filetype['type'] == 'image/png' || $temp_filetype['type'] == 'image/gif' || $temp_filetype['type'] == 'image/jpeg') {
                                $comment = '<a href="' . $comment->comment_content . '" target=_blank><div class="tag_img" style="width: 275px;height: 183px;"><img src="' . $comment->comment_content . '" style="width: 100%;" class="wpfb_task_screenshot"></div></a>';
                            } else {
                                $comment = '<a href="' . $comment->comment_content . '" download><div class="tag_img" style="width: 275px;height: 183px;"><i class="gg-software-download"></i> ' . $file_name . '</div></a>';
                            }
                        }
                        else if (wp_http_validate_url($comment->comment_content) && !strpos($comment->comment_content, 'wp-content/uploads')) {
                            $idVideo = $comment->comment_content;
                            $link = explode("?v=",$idVideo);
                            if ($link[0] == 'https://www.youtube.com/watch') {
                                $youtubeUrl = "http://www.youtube.com/oembed?url=$idVideo&format=json";
                                $docHead = get_headers($youtubeUrl);
                                if (substr($docHead[0], 9, 3) !== "404") {
                                    //$comment_type=3;
                                    $comment = '<iframe width="100%" height="150" src="https://www.youtube.com/embed/'.$link[1].'" type="text/html" width="500" height="265" frameborder="0" allowfullscreen></iframe>';
                                }
                                else {
                                    $comment =$comment->comment_content;
                                }
                            }else{
                                $comment =get_comment_text($comment->comment_ID);
                            }
                        }
                        else {
                            $comment = $comment->comment_content;
                        }
                        $response['data'] .= '<li class=' . $class . ' title="' . $curr_comment_time['comment_time'] . '"><level class="wpf-author">' . $author . ' <span>' . $curr_comment_time['comment_time'] . '</span></level><p class="task_text">' . nl2br($comment) . '</p></div></li>';
                    }
                } else {
                    $response['data'] = '<li id="wpf_not_found">No comments found</li>';
                }
            } else {
                $response['data'] = '<li id="wpf_not_found">No comments found</li>';
            }
            echo json_encode($response);
            die();
        }
        else{
            $response = '<li id="wpf_not_found">Something wrong</li>';
            echo $response;
            die();
        }
    }
}

/*
 * This function is used to add new comments from the "Tasks Center". It is been called from function wpf_backed_scripts() in wpfeedback.php. The function hadles posting of all types of comments like text, images files etc.
 *
 * @input Array ( $_POST )
 * @return String (HTML to add comment to the chat)
 */
add_action('wp_ajax_insert_wpf_comment_func', 'insert_wpf_comment_func');
add_action('wp_ajax_nopriv_insert_wpf_comment_func', 'insert_wpf_comment_func');
if (!function_exists('insert_wpf_comment_func')) {
    function insert_wpf_comment_func()
    {
        global $wpdb;
        wpf_security_check();
        $wpf_every_new_task = get_option('wpf_every_new_task');
        $wpf_comment = $_POST['wpf_comment'];
        $post_id = $_POST['post_id'];
        $author_id = $_POST['author_id'];
        $task_notify_users = $_POST['task_notify_users'];
        $user_info = get_userdata($author_id);
        $blogtime = date('Y-m-d H:i:s', current_time('timestamp', 0));

        $commentdata = array(
            'comment_post_ID' => $post_id,
            'comment_author' => $user_info->first_name . ' ' . $user_info->last_name,
            'comment_author_email' => $user_info->user_email,
            'comment_author_url' => '',
            'comment_content' => stripslashes(html_entity_decode($wpf_comment, ENT_QUOTES, 'UTF-8')),
            'comment_approved' => 1, 
            'comment_type' => 'wp_feedback',
            'comment_parent' => 0,
            'user_id' => $author_id,
            'comment_date' => $blogtime,
        );
        if ($wpf_comment) {
            $wpdb->insert($wpdb->prefix . 'comments', $commentdata);
            $comment_id = $wpdb->insert_id;
            $sender_id = $author_id;
            $msg = $wpf_comment;
            //send_user_notification_for_msg($sender_id,$receiver_id,$msg);
        }
        if ($comment_id) {
            if($post_id){
                $get_task_status = get_the_terms( $post_id, 'task_status' );
                $task_status = $get_task_status[0]->slug;
                if($task_status == 'complete'){
                    wp_set_object_terms($post_id, 'open', 'task_status', false);
                }
            }
            if ($wpf_every_new_task == 'yes') {
                wpf_send_email_notification($post_id, $comment_id, $task_notify_users, 'new_reply');
            }
            do_action('wpf_crm_new_comment_action',$comment_id);
            $comment_info = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}comments WHERE comment_ID =$comment_id AND comment_type LIKE 'wp_feedback' ORDER BY comment_ID ASC");
            // display the results
            foreach ($comment_info as $info) {
                $class = "chat_author";
                $task_date = get_comment_date('Y-m-d H:i:s', $info->comment_ID);
                $task_date1 = date_create($task_date);
                //Old Logic to get current time. Was creating issues when displaying message
                //$task_date2 = new DateTime('now');

                //New Logic to get current time.
                $wpf_wp_current_timestamp = date('Y-m-d H:i:s', current_time('timestamp', 0));
                $task_date2 = date_create($wpf_wp_current_timestamp);

                $curr_comment_time = wpfb_time_difference($task_date1, $task_date2);
                $author_id = $info->user_id;
                if ($author_id) {
                    $author = get_the_author_meta('display_name', $info->user_id);
                } else {
                    $author = 'ME';
                }

                if (strpos($info->comment_content, 'wp-content/uploads') !== false) {
                    $temp_filetype = wp_check_filetype($info->comment_content);
                    $file_name = preg_replace('/\.[^.]+$/', '', basename($info->comment_content));
                    if ($temp_filetype['type'] == 'image/png' || $temp_filetype['type'] == 'image/gif' || $temp_filetype['type'] == 'image/jpeg') {
                        $comment = '<a href="' . $info->comment_content . '" target=_blank><div class="tag_img" style="width: 275px;height: 183px;"><img src="' . $info->comment_content . '" style="width: 100%;" class="wpfb_task_screenshot"></div></a>';
                    }
                    else {
                        $comment = '<a href="' . $info->comment_content . '" download><div class="tag_img" style="width: 275px;height: 183px;"><i class="gg-software-download"></i> ' . $file_name . '</div></a>';
                    }
                }
                else if (wp_http_validate_url($info->comment_content) && !strpos($info->comment_content, 'wp-content/uploads')) {
                    $idVideo = $info->comment_content;
                    $link = explode("?v=",$idVideo);
                    if ($link[0] == 'https://www.youtube.com/watch') {
                        $youtubeUrl = "http://www.youtube.com/oembed?url=$idVideo&format=json";
                        $docHead = get_headers($youtubeUrl);
                        if (substr($docHead[0], 9, 3) !== "404") {
                            //$comment_type=3;
                            $comment = '<iframe width="100%" height="150" src="https://www.youtube.com/embed/'.$link[1].'" type="text/html" width="500" height="265" frameborder="0" allowfullscreen></iframe>';
                        }
                        else {
                            $comment =$info->comment_content;
                        }
                    }else{
                        $comment =get_comment_text($info->comment_ID);
                    }
                }
                else {
                    $comment = $info->comment_content;
                }
                $profile_image = "<div class='chat_initials'>".$author. " <span>". __("just now","wpfeedback")."</span></div>";
                echo '<li class=' . $class . '><level class="chat-author">' . $profile_image . '</level><div class="meassage_area_main"><p class="chat_text">' . nl2br($comment) . '</p></div></li>';
            }
        } else {
            echo 'sorry this is duplicate msg.';
        }
        die();

    }
}

/*
 * This function is used to get the email of current user. This function is not used currently.
 *
 * @input NULL
 * @return String
 */
add_action('wp_ajax_wpf_notify_admin_add_ons_func', 'wpf_notify_admin_add_ons_func');
if (!function_exists('wpf_notify_admin_add_ons_func')) {
    function wpf_notify_admin_add_ons_func()
    {
        wpf_security_check();
        $current_user_id = get_current_user_id();
        $user_info = get_userdata($current_user_id);
        echo $user_info->user_email;
        echo $add_ons_name = $_POST['add_ons'];
        exit;
    }
}

/*
 * This function is used to create a new task. This function is used to create task from Frontend Pages, Backend Tasks Center, Graphics and API.
 *
 * @input Array ( $_POST['new_task'] )
 * @return Int (Task ID)
 */
add_action('wp_ajax_wpf_add_new_task','wpf_add_new_task');
add_action('wp_ajax_nopriv_wpf_add_new_task','wpf_add_new_task');
if (!function_exists('wpf_add_new_task')) {
    function wpf_add_new_task()
    {
        global $wpdb, $current_user;
        wpf_security_check();
        if ($current_user->ID == 0) {
            $user_id = get_option('wpf_website_client');
        } else {
            $user_id = $current_user->ID;
        }

//    Old logic to count latest task bubble number, was changed after the delete task feature was introduced
//    $comment_count_obj = wp_count_posts('wpfeedback');
//    $comment_count = $comment_count_obj->publish+1;

//    New logic to count latest task bubble number
        $table = $wpdb->prefix . 'postmeta';
        $latest_count = $wpdb->get_results("SELECT meta_value FROM $table WHERE meta_key = 'task_comment_id' ORDER BY meta_id DESC LIMIT 1 ");
        $comment_count = $latest_count[0]->meta_value + 1;

        $wpf_every_new_task = get_option('wpf_every_new_task');
        $task_data = $_POST['new_task'];

        foreach ($task_data as $key=>$val){
            $task_data[$key]=filter_var($val,FILTER_SANITIZE_STRING);
        }

        if ($task_data['task_page_title'] == '') {
            $task_data['task_page_title'] = get_the_title($task_data['current_page_id']);
        }
        if ($task_data['task_page_url'] == '') {
            $task_data['task_page_url'] = $current_page_url = get_permalink($task_data['current_page_id']);
        }

        if ($task_data['wpf_current_screen'] != '') {
            $wpf_current_screen = $task_data['wpf_current_screen'];
            $post_status = 'wpf_admin';
        } else {
            $wpf_current_screen = '';
            $post_status = 'publish';
        }

        $new_task = array(
            'post_content' => '',
            'post_status' => $post_status,
            'post_title' => stripslashes(html_entity_decode($task_data['task_title'], ENT_QUOTES, 'UTF-8')),
            'post_type' => 'wpfeedback',
            'post_author' => $user_id,
            'post_parent' => $task_data['current_page_id']
        );
        $task_id = wp_insert_post($new_task);
        $task_data['task_element_path'] = str_replace(".active_comment", "", $task_data['task_element_path']);
        $task_data['task_element_path'] = str_replace(".logged-in.admin-bar", "", $task_data['task_element_path']);
        $task_data['task_element_path'] = str_replace(".no-customize-support", "", $task_data['task_element_path']);
        $task_data['task_element_path'] = str_replace(".customize-support", "", $task_data['task_element_path']);
        $task_data['task_element_path'] = str_replace(".gf_browser_chrome", "", $task_data['task_element_path']);
        $task_data['task_element_path'] = str_replace(".gf_browser_gecko", "", $task_data['task_element_path']);
        $task_data['task_element_path'] = str_replace(".wpfb_task_bubble", "", $task_data['task_element_path']);
        add_post_meta($task_id, 'task_config_author_browser', $task_data['task_config_author_browser']);
        add_post_meta($task_id, 'task_config_author_browserVersion', $task_data['task_config_author_browserVersion']);
        add_post_meta($task_id, 'task_config_author_browserOS', $task_data['task_config_author_browserOS']);
        add_post_meta($task_id, 'task_config_author_ipaddress', $task_data['task_config_author_ipaddress']);
        add_post_meta($task_id, 'task_config_author_name', $task_data['task_config_author_name']);
        add_post_meta($task_id, 'task_config_author_id', $user_id);
        add_post_meta($task_id, 'task_config_author_resX', $task_data['task_config_author_resX']);
        add_post_meta($task_id, 'task_config_author_resY', $task_data['task_config_author_resY']);
        add_post_meta($task_id, 'task_title', $task_data['task_title']);
        add_post_meta($task_id, 'task_page_url', $task_data['task_page_url']);
        add_post_meta($task_id, 'task_page_title', $task_data['task_page_title']);
        add_post_meta($task_id, 'task_comment_message', $task_data['task_comment_message']);
        add_post_meta($task_id, 'task_element_path', $task_data['task_element_path']);
        add_post_meta($task_id, 'wpfb_task_bubble', $task_data['task_clean_dom_elem_path']);
        add_post_meta($task_id, 'task_element_html', $task_data['task_element_html']);
        add_post_meta($task_id, 'task_X', $task_data['task_X']);
        add_post_meta($task_id, 'task_Y', $task_data['task_Y']);
        add_post_meta($task_id, 'task_elementX', $task_data['task_elementX']);
        add_post_meta($task_id, 'task_elementY', $task_data['task_elementY']);
        add_post_meta($task_id, 'task_relativeX', $task_data['task_relativeX']);
        add_post_meta($task_id, 'task_relativeY', $task_data['task_relativeY']);
        add_post_meta($task_id, 'task_notify_users', $task_data['task_notify_users']);
        add_post_meta($task_id, 'task_element_height', $task_data['task_element_height']);
        add_post_meta($task_id, 'task_element_width', $task_data['task_element_width']);
        add_post_meta($task_id, 'task_comment_id', $comment_count);
        add_post_meta($task_id, 'task_type', $task_data['task_type']);
        add_post_meta($task_id, 'task_top', $task_data['task_top']);
        add_post_meta($task_id, 'task_left', $task_data['task_left']);

        if ($wpf_current_screen != '') {
            add_post_meta($task_id, 'wpf_current_screen', $wpf_current_screen);
        }

        wp_set_object_terms($task_id, $task_data['task_status'], 'task_status', true);
        wp_set_object_terms($task_id, $task_data['task_priority'], 'task_priority', true);

        $task_comment_message = wpf_test_input($task_data['task_comment_message']);

        $comment_time = date('Y-m-d H:i:s', current_time('timestamp', 0));
        $commentdata = array(
            'comment_post_ID' => $task_id,
            'comment_author' => $task_data['task_config_author_name'],
            'comment_author_email' => '',
            'comment_author_url' => '',
            'comment_content' => stripslashes(html_entity_decode($task_comment_message, ENT_QUOTES, 'UTF-8')),
            'comment_approved' => 1, 
            'comment_type' => 'wp_feedback',
            'comment_parent' => 0,
            'user_id' => $user_id,
            'comment_date' => $comment_time
        );
        $comment_id = $wpdb->insert("{$wpdb->prefix}comments", $commentdata);
        if ($wpf_every_new_task == 'yes') {
            wpf_send_email_notification($task_id, $comment_id, $task_data['task_notify_users'], 'new_task');
        }
        do_action('wpf_crm_new_task_action',$task_id);
        //ob_clean();
        echo $task_id;
        exit;
    }
}

/*
 * This function is used to create a new comment for the task. This function is used to create comment from Frontend Pages, Backend Tasks Center And Graphics.
 *
 * @input Array ( $_POST['new_task'] )
 * @return String (Message)
 */
add_action('wp_ajax_wpfb_add_comment','wpfb_add_comment');
add_action('wp_ajax_nopriv_wpfb_add_comment','wpfb_add_comment');
if (!function_exists('wpfb_add_comment')) {
    function wpfb_add_comment()
    {
        global $wpdb;
        wpf_security_check();
        $enabled_wpfeedback = wpf_check_if_enable();
        $wpf_every_new_comment = get_option('wpf_every_new_comment');
        if($enabled_wpfeedback == 1){
            $task_data = $_POST['new_task'];
            $task_id = $task_data['post_id'];
            $comment_time = date('Y-m-d H:i:s', current_time('timestamp', 0));
            $task_comment_message = wpf_test_input($task_data['task_comment_message']);
            $commentdata = array(
                'comment_post_ID' => $task_data['post_id'],
                'comment_author' => $task_data['task_config_author_name'],
                'comment_author_email' => '',
                'comment_author_url' => '',
                'comment_content' => $task_comment_message,
                'comment_approved' => 1, 
                'comment_type' => 'wp_feedback',
                'comment_parent' => 0,
                'user_id' => $task_data['task_config_author_id'],
                'comment_date' => $comment_time
            );

            $comment_id = $wpdb->insert("{$wpdb->prefix}comments", $commentdata);
            $comment_id = $wpdb->insert_id;
            if ($wpf_every_new_comment == 'yes') {
                wpf_send_email_notification($task_data['post_id'], $comment_id, $task_data['task_notify_users'], 'new_reply');
            }
            if($task_data['task_status']=='complete'){
                wp_set_object_terms($task_data['post_id'], 'open', 'task_status', false);
            }
            //ob_clean();
            // echo $comment_id;
            do_action('wpf_crm_new_comment_action',$comment_id);
            echo $task_comment_message;
        }else{
            echo 0;
        }
        exit;
    }
}

/*
 * This function is used to load all the tasks. This function is used to load tasks on Frontend Sidebar, Backend Sidebar and Graphics Sidebar.
 *
 * @input Array ( $_POST )
 * @return JSON (Listing of all tasks)
 */
add_action('wp_ajax_load_wpfb_tasks','load_wpfb_tasks');
add_action('wp_ajax_nopriv_load_wpfb_tasks','load_wpfb_tasks');
if (!function_exists('load_wpfb_tasks')) {
    function load_wpfb_tasks(){
        wpf_security_check();
        ob_clean();
        global $wpdb,$current_user;
        $current_user_id = $current_user->ID;
        $comment = "";
        $response = array();
        if($_POST['current_page_id'] && $_POST['current_page_id']!=''){
            $args = array(
                'post_parent' => $_POST['current_page_id'],
                'post_type'   => 'wpfeedback',
                'numberposts' => -1,
                'post_status' => 'any',
                'orderby'    => 'date',
                'order'       => 'DESC'
            );
            $wpfb_tasks = get_children( $args );
        }
        elseif ($_POST['task_id']){
            $args = array(
                'include'=>$_POST['task_id'],
                'post_type'=>'wpfeedback'
            );
            $wpfb_tasks = get_posts( $args );
        }
        else{
            $args = array(
                'post_type'   => 'wpfeedback',
                'numberposts' => -1,
                'post_status' => 'any',
                'orderby'    => 'date',
                'order'       => 'DESC'
            );
            $wpfb_tasks = get_posts( $args );
        }
        if($wpfb_tasks) {
            foreach ($wpfb_tasks as $wpfb_task) {
                $task_date = get_the_time('Y-m-d H:i:s', $wpfb_task->ID);
                $metas = get_post_meta($wpfb_task->ID);
                $task_priority = get_the_terms($wpfb_task->ID, 'task_priority');
                $task_status = get_the_terms($wpfb_task->ID, 'task_status');
                $task_tags = get_the_terms($wpfb_task->ID, 'wpf_tag');
                $post_title = esc_html(get_the_title($wpfb_task->ID));
                $temp_tag_counter = 0;
                if(is_array($task_tags) && !empty($task_tags)) {
                    foreach ($task_tags as $task_tag => $task_tags_value) {
                        $response[$wpfb_task->ID]['wpf_tags'][$temp_tag_counter]['slug'] = $task_tags_value->slug;
                        $response[$wpfb_task->ID]['wpf_tags'][$temp_tag_counter]['name'] = $task_tags_value->name;
                        $temp_tag_counter++;
                    }
                }
                foreach ($metas as $key => $value) {
                    if ($key == 'task_title') {
                        $response[$wpfb_task->ID][$key] = $post_title;
                    } else {
                        $response[$wpfb_task->ID][$key] = $value[0];
                    }
                    $response[$wpfb_task->ID]['task_priority'] = $task_priority[0]->slug;
                    $response[$wpfb_task->ID]['task_status'] = $task_status[0]->slug;
                    $response[$wpfb_task->ID]['current_user_id'] = $current_user_id;

                    $task_date1 = date_create($task_date);
//          Old Logic to get current time. Was creating issues when displaying message
//			$task_date2 = new DateTime('now');

//          New Logic to get current time.
                    $wpf_wp_current_timestamp = date('Y-m-d H:i:s', current_time('timestamp', 0));
                    $task_date2 = date_create($wpf_wp_current_timestamp);


                    $curr_comment_time = wpfb_time_difference($task_date1, $task_date2);

                    $response[$wpfb_task->ID]['task_time'] = $curr_comment_time['comment_time'];
                }

                $args = array(
                    'post_id' => $wpfb_task->ID,
                    'type' => 'wp_feedback',
                    'orderby'  => 'comment_date',
                    'order' => 'ASC',
                );
                $comments_info = get_comments($args);

                if ($comments_info) {
                    foreach ($comments_info as $comment) {
                        $comment_type = 0;
                        if (strpos($comment->comment_content, 'wp-content/uploads') !== false) {
//                    print_r(wp_check_filetype($comment->comment_content));
                            $temp_filetype = wp_check_filetype($comment->comment_content);
                            $response[$wpfb_task->ID]['comments'][$comment->comment_ID]['filetype'] = $temp_filetype;
                            if ($temp_filetype['type'] == 'image/png' || $temp_filetype['type'] == 'image/gif' || $temp_filetype['type'] == 'image/jpeg') {
                                $comment_type = 1;
                            } else {
                                $comment_type = 2;
                            }
                            $response[$wpfb_task->ID]['comments'][$comment->comment_ID]['message'] = $comment->comment_content;
                        } else if (wp_http_validate_url($comment->comment_content) && !strpos($comment->comment_content, 'wp-content/uploads')) {
                            $idVideo = $comment->comment_content;
                            $link = explode("?v=", $idVideo);
                            if ($link[0] == 'https://www.youtube.com/watch') {
                                $youtubeUrl = "http://www.youtube.com/oembed?url=$idVideo&format=json";
                                $docHead = get_headers($youtubeUrl);
                                if (substr($docHead[0], 9, 3) !== "404") {
                                    $comment_type = 3;
                                    $response[$wpfb_task->ID]['comments'][$comment->comment_ID]['message'] = $link[1];
                                } else {
                                    $response[$wpfb_task->ID]['comments'][$comment->comment_ID]['message'] = $comment->comment_content;
                                }
                            } else {
                                $response[$wpfb_task->ID]['comments'][$comment->comment_ID]['message'] = get_comment_text($comment->comment_ID);
                            }

                        } else {
                            $response[$wpfb_task->ID]['comments'][$comment->comment_ID]['message'] = get_comment_text($comment->comment_ID);
                        }

                        $response[$wpfb_task->ID]['comments'][$comment->comment_ID]['comment_type'] = $comment_type;
                        $response[$wpfb_task->ID]['comments'][$comment->comment_ID]['author'] = $comment->comment_author;

                        $datetime1 = date_create($comment->comment_date);

//        	 	Old Logic to get current time. Was creating issues when displaying message
//				$datetime2 = new DateTime('now');

//              New Logic to get current time.
                        $wpf_wp_current_timestamp = date('Y-m-d H:i:s', current_time('timestamp', 0));
                        $datetime2 = date_create($wpf_wp_current_timestamp);

                        $curr_comment_time = wpfb_time_difference($datetime1, $datetime2);

                        $response[$wpfb_task->ID]['comments'][$comment->comment_ID]['time'] = $curr_comment_time['comment_time'];
                        $response[$wpfb_task->ID]['comments'][$comment->comment_ID]['time_full'] = $curr_comment_time['interval'];
                        $response[$wpfb_task->ID]['comments'][$comment->comment_ID]['user_id'] = $comment->user_id;
                    }
                }
            }
        }
        ob_end_clean();
        echo json_encode($response);
        exit;
    }
}

/*
 * This function is used to set the priority of the tasks. This function is used to set priority from Frontend Pages, Backend Pages, Backend Tasks Center and Graphics Tasks.
 *
 * @input Array ( $_POST['task_info'] )
 * @return Boolean
 */
add_action('wp_ajax_wpfb_set_task_priority','wpfb_set_task_priority');
add_action('wp_ajax_nopriv_wpfb_set_task_priority','wpfb_set_task_priority');
if (!function_exists('wpfb_set_task_priority')) {
    function wpfb_set_task_priority()
    {

        wpf_security_check();

        $task_info = $_POST['task_info'];
        if (wp_set_object_terms($task_info['task_id'], $task_info['task_priority'], 'task_priority', false)) {
            do_action('wpf_crm_update_task_priority_action',$task_info);
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }
}

/*
 * This function is used to set the status of the tasks and send notifications to the user based on the status. This function is used to set status from Frontend Pages, Backend Pages, Backend Tasks Center and Graphics Tasks.
 *
 * @input Array ( $_POST['task_info'] )
 * @return Boolean
 */
add_action('wp_ajax_wpfb_set_task_status','wpfb_set_task_status');
add_action('wp_ajax_nopriv_wpfb_set_task_status','wpfb_set_task_status');
if (!function_exists('wpfb_set_task_status')) {
    function wpfb_set_task_status()
    {

        wpf_security_check();

        $wpf_every_status_change = get_option('wpf_every_status_change');
        $wpf_every_new_complete = get_option('wpf_every_new_complete');
        $task_info = $_POST['task_info'];
        if (wp_set_object_terms($task_info['task_id'], $task_info['task_status'], 'task_status', false)) {
            do_action('wpf_crm_update_task_status_action',$task_info);
            if ($task_info['task_status'] == 'complete' && $wpf_every_new_complete == 'yes') {
                wpf_send_email_notification($task_info['task_id'], 0, $task_info['task_notify_users'], 'task_completed');
            } else {
                if ($wpf_every_status_change == 'yes') {
                    wpf_send_email_notification($task_info['task_id'], 0, $task_info['task_notify_users'], 'task_status_changed');
                }
            }
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }
}

/*
 * This function is used to set the notify users for the task. This function is used to set notify users from Frontend Pages, Backend Pages, Backend Tasks Center and Graphics Tasks.
 *
 * @input Array ( $_POST['task_info'] )
 * @return Boolean
 */
add_action('wp_ajax_wpfb_set_task_notify_users','wpfb_set_task_notify_users');
add_action('wp_ajax_nopriv_wpfb_set_task_notify_users','wpfb_set_task_notify_users');
if (!function_exists('wpfb_set_task_notify_users')) {
    function wpfb_set_task_notify_users()
    {
        wpf_security_check();
        $task_notify_users = filter_var($_POST['task_info']['task_notify_users'],FILTER_SANITIZE_STRING);
        if (update_post_meta($_POST['task_info']['task_id'], 'task_notify_users', $task_notify_users)) {
            do_action('wpf_crm_update_notify_users_action',$_POST['task_info']);
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }
}

/*
 * This function is used to take the screenshot and add to the task. This function is used to take screenshots from Frontend Pages, Backend Pages, Backend Tasks Center and Graphics Tasks.
 *
 * @input Array ( $_POST )
 * @return Boolean
 */
add_action('wp_ajax_wpfb_save_screenshot','wpfb_save_screenshot_function');
add_action('wp_ajax_nopriv_wpfb_save_screenshot','wpfb_save_screenshot_function');
if (!function_exists('wpfb_save_screenshot_function')) {
    function wpfb_save_screenshot_function()
    {
        global $wpdb, $current_user;

        wpf_security_check();

        if ($current_user->ID == 0) {
            $task_config_author_id = get_option('wpf_website_client');
        } else {
            $task_config_author_id = $current_user->ID;
        }
        $wpf_every_new_comment = get_option('wpf_every_new_comment');
        $upload_dir = wp_upload_dir();

        ini_set('display_errors', 1);

        $image = $_POST['image'];
        $task_screenshot = $_POST['task_screenshot'];
        $post_id = $task_screenshot['post_id'];
        $task_config_author_name = $task_screenshot['task_config_author_name'];
        //$task_config_author_id = $task_screenshot['task_config_author_id'];

        $post_notif_user_str = get_post_meta($post_id, 'task_notify_users', true);
        //$post_notif_users_arr = explode(',',$post_notif_user_str);

        $location = $upload_dir['basedir'] . "/wpfb_screenshots/";
        if (!file_exists($location)) {
            mkdir($location, 0777, true);
        }

        $image_parts = explode("base64,", $image);

        $invalid = wpf_verify_file_upload($_SERVER, $image_parts[1]);

        $image_base64 = base64_decode($image_parts[1]);

        $filename = "screenshot_" . uniqid() . '.jpg';

        $file = $location . $filename;

        if ($invalid == 0) {
            if (file_put_contents($file, $image_base64)) {
                $task_screenshot = $upload_dir['baseurl'] . "/wpfb_screenshots/" . $filename;
                if($_POST['autoscreen']==1){
                    update_post_meta($post_id,'wpf_task_screenshot',$task_screenshot);
                    do_action('wpf_crm_new_task_screenshot_action',$post_id);
                }
                else{
                    $comment_time = date('Y-m-d H:i:s', current_time('timestamp', 0));
                    $commentdata = array(
                        'comment_post_ID' => $post_id,
                        'comment_author' => $task_config_author_name,
                        'comment_author_email' => '',
                        'comment_author_url' => '',
                        'comment_content' => $task_screenshot,
                        'comment_approved' => 1,
                        'comment_type' => 'wp_feedback',
                        'comment_parent' => 0,
                        'user_id' => $task_config_author_id,
                        'comment_date' => $comment_time
                    );
                    $wpdb->insert("{$wpdb->prefix}comments", $commentdata);
                    $comment_id = $wpdb->insert_id;
                    if ($wpf_every_new_comment == 'yes' && $post_id > 0) {
                        wpf_send_email_notification($post_id, $comment_id, $post_notif_user_str, 'new_reply');
                    }
                    do_action('wpf_crm_new_comment_action',$comment_id);
                }
                echo $task_screenshot;
            } else {
                echo 0;
            }
        } else {
            echo 1;
        }
        exit;
    }
}

/*
 * This function is used to reset the White Labeling settings from the backend.
 *
 * @input NULL
 * @return NULL
 */
add_action('wp_ajax_wpfeedback_reset_setting', 'wpfeedback_reset_setting');
add_action('wp_ajax_nopriv_wpfeedback_reset_setting', 'wpfeedback_reset_setting');
if (!function_exists('wpfeedback_reset_setting')) {
    function wpfeedback_reset_setting()
    {
        wpf_security_check();
        update_option('wpf_color', '002157', 'no');
        delete_option('wpf_logo', true);
        echo 1;
        exit;
    }
}

/*
 * This function is used to resync the website with the dashboard app. It will clear the "wpf_check_license_date" and "wpf_initial_sync" which in turn will call the Initial sync from function "wpf_license_key_check_item" in wpf_function.php
 *
 * @input NULL
 * @return NULL
 */
add_action('wp_ajax_wpf_resync_dashboard', 'wpf_resync_dashboard');
add_action('wp_ajax_nopriv_wpf_resync_dashboard', 'wpf_resync_dashboard');
if (!function_exists('wpf_resync_dashboard')) {
    function wpf_resync_dashboard()
    {
        wpf_security_check();
        delete_option( 'wpf_check_license_date' );
        delete_option( 'wpf_initial_sync' );
        echo 1;
        exit;
    }
}

/*
 * This function is used to verify the license from the backend Permissions tab.
 *
 * @input Array ( $_POST )
 * @return Boolean
 */
add_action('wp_ajax_wpf_license_verify_and_store', 'wpf_license_verify_and_store');
add_action('wp_ajax_nopriv_wpf_license_verify_and_store', 'wpf_license_verify_and_store');
if (!function_exists('wpf_license_verify_and_store')) {
    function wpf_license_verify_and_store()
    {
        wpf_security_check();
        $response = 0;
        $wpf_license_key = $_POST['wpf_license_key'];
        $wpf_license = get_option('wpf_license');
        if ($wpf_license == 'valid') {
            $response = 1;
        } else {
            $outputObject = wpf_license_key_license_item($wpf_license_key);
            if ($outputObject['license'] == 'valid') {
                update_option('wpf_license_key', $wpf_license_key, 'no');
                update_option('wpf_license', $outputObject['license'], 'no');
                update_option('wpf_license_expires', $outputObject['expires'], 'no');
                if(!get_option('wpf_decr_key')){
                    update_option('wpf_decr_key', $outputObject['payment_id'],'no');
                    update_option('wpf_decr_checksum', $outputObject['checksum'],'no');
                    $wpf_crypt_key = wpf_crypt_key($wpf_license_key,'e');
                    update_option('wpf_license_key',$wpf_crypt_key,'no');
                }
                if(get_option('wpf_initial_sync')!=1){
                    do_action('wpf_initial_sync',$wpf_license_key);
                }
                $response = 1;
            } else {
                update_option('wpf_license', $outputObject['license'], 'no');
            }
        }
        echo $response;
        exit;
    }
}

/*
 * This function is used to update the roles to be allowed to use plugin from the Permissions tab.
 *
 * @input Array ( $_POST )
 * @return Boolean
 */
add_action('wp_ajax_wpf_update_roles', 'wpf_update_roles');
add_action('wp_ajax_nopriv_wpf_update_roles', 'wpf_update_roles');
if (!function_exists('wpf_update_roles')) {
    function wpf_update_roles()
    {
        wpf_security_check();
        $roles = $_POST['task_notify_roles'];
        $wpf_allow_guest = $_POST['wpf_allow_guest'];
        if ($wpf_allow_guest == 1) {
            update_option('wpf_allow_guest', 'yes', 'no');
        } else {
            update_option('wpf_allow_guest', 'no', 'no');
        }

//    if(update_option('wpf_selcted_role',$roles,'no')){
//        echo 1;
//    }
//    else{
//        echo 0;
//    }

        update_option('wpf_selcted_role', $roles, 'no');
        echo 1;
        exit;
    }
}

/*
 * This function is used to set the Email Notification from the Settings tab.
 *
 * @input Array ( $_POST )
 * @return Boolean
 */
add_action('wp_ajax_wpf_update_notifications', 'wpf_update_notifications');
add_action('wp_ajax_nopriv_wpf_update_notifications', 'wpf_update_notifications');
if (!function_exists('wpf_update_notifications')) {
    function wpf_update_notifications()
    {
        wpf_security_check();
        $wpf_every_new_task = $_POST['wpf_every_new_task'];
        if ($wpf_every_new_task == 1) {
            update_option('wpf_every_new_task', 'yes', 'no');
        }
        $wpf_every_new_comment = $_POST['wpf_every_new_comment'];
        if ($wpf_every_new_comment == 1) {
            update_option('wpf_every_new_comment', 'yes', 'no');
        }
        $wpf_every_new_complete = $_POST['wpf_every_new_complete'];
        if ($wpf_every_new_complete == 1) {
            update_option('wpf_every_new_complete', 'yes', 'no');
        }
        $wpf_every_status_change = $_POST['wpf_every_status_change'];
        if ($wpf_every_status_change == 1) {
            update_option('wpf_every_status_change', 'yes', 'no');
        }
        $wpf_daily_report = $_POST['wpf_daily_report'];
        if ($wpf_daily_report == 1) {
            update_option('wpf_daily_report', 'yes', 'no');
        }
        $wpf_weekly_report = $_POST['wpf_weekly_report'];
        if ($wpf_weekly_report == 1) {
            update_option('wpf_weekly_report', 'yes', 'no');
        }
        $wpf_auto_daily_report = $_POST['wpf_auto_daily_report'];
        if ($wpf_auto_daily_report == 1) {
            update_option('wpf_auto_daily_report', 'yes', 'no');
        }
        $wpf_auto_weekly_report = $_POST['wpf_auto_weekly_report'];
        if ($wpf_auto_weekly_report == 1) {
            update_option('wpf_auto_weekly_report', 'yes', 'no');
        }
        echo 1;
        exit;
    }
}

/*
 * This function is used to set the option that initial setup of the plugin was done from the backend.
 *
 * @input NULL
 * @return Boolean
 */
add_action('wp_ajax_wpf_initial_setup_done', 'wpf_initial_setup_done');
add_action('wp_ajax_nopriv_wpf_initial_setup_done', 'wpf_initial_setup_done');
if (!function_exists('wpf_initial_setup_done')) {
    function wpf_initial_setup_done()
    {
        global $current_user;
        wpf_security_check();
        $user_id = $current_user->ID;
        if (is_user_logged_in() && $user_id != '') {
            update_option('wpf_enabled', 'yes', 'no');
            update_option('wpf_initial_setup', 'yes', 'no');
            echo 1;
        }
        exit;
    }
}

/*
 * This function is used to delete the task from the website. This function is used from Frontend Pages, Backend Pages, Backend Tasks Center and Graphics Tasks.
 *
 * @input Array ( $_POST )
 * @return Boolean
 */
add_action('wp_ajax_wpfb_delete_task','wpfb_delete_task');
add_action('wp_ajax_nopriv_wpfb_delete_task','wpfb_delete_task');
if (!function_exists('wpfb_delete_task')) {
    function wpfb_delete_task()
    {
        wpf_security_check();
        $task_info = $_POST['task_info'];
        if (wp_delete_post($task_info['task_id'])) {
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }
}

/*
 * This function is used to set the step 1 of the user onboarding wizard.
 *
 * @input Array ( $_POST )
 * @return Boolean
 */
add_action('wp_ajax_wpf_update_current_user_first_step', 'wpf_update_current_user_first_step');
add_action('wp_ajax_nopriv_wpf_update_current_user_first_step', 'wpf_update_current_user_first_step');
if (!function_exists('wpf_update_current_user_first_step')) {
    function wpf_update_current_user_first_step()
    {
        global $current_user;
        wpf_security_check();
        $user_id = $current_user->ID;
        if (is_user_logged_in() && $user_id != '') {
            $wpf_user_type = $_POST['wpf_user_type'];
            if ($wpf_user_type && ($wpf_user_type=='king' || $wpf_user_type=='advisor' || $wpf_user_type=='council')) {
                update_user_meta($user_id, 'wpf_user_type', $wpf_user_type);
                update_user_meta($user_id, 'wpf_user_initial_setup', 'yes');
            }
            $wpf_every_new_task = $_POST['wpf_every_new_task'];
            if ($wpf_every_new_task == 'yes') {
                update_user_meta($user_id, 'wpf_every_new_task', $_POST['wpf_every_new_task']);
            } else {
                delete_user_meta($user_id, 'wpf_every_new_task');
            }
            $wpf_every_new_comment = $_POST['wpf_every_new_comment'];
            if ($wpf_every_new_comment == 'yes') {
                update_user_meta($user_id, 'wpf_every_new_comment', $_POST['wpf_every_new_comment']);
            } else {
                delete_user_meta($user_id, 'wpf_every_new_comment');
            }
            $wpf_every_new_complete = $_POST['wpf_every_new_complete'];
            if ($wpf_every_new_complete == 'yes') {
                update_user_meta($user_id, 'wpf_every_new_complete', $_POST['wpf_every_new_complete']);
            } else {
                delete_user_meta($user_id, 'wpf_every_new_complete');
            }
            $wpf_every_status_change = $_POST['wpf_every_status_change'];
            if ($wpf_every_status_change == 'yes') {
                update_user_meta($user_id, 'wpf_every_status_change', $_POST['wpf_every_status_change']);
            } else {
                delete_user_meta($user_id, 'wpf_every_status_change');
            }
            $wpf_daily_report = $_POST['wpf_daily_report'];
            if ($wpf_daily_report == 'yes') {
                update_user_meta($user_id, 'wpf_daily_report', $_POST['wpf_daily_report']);
            } else {
                delete_user_meta($user_id, 'wpf_daily_report');
            }
            $wpf_weekly_report = $_POST['wpf_weekly_report'];
            if ($wpf_weekly_report == 'yes') {
                update_user_meta($user_id, 'wpf_weekly_report', $_POST['wpf_weekly_report']);
            } else {
                delete_user_meta($user_id, 'wpf_weekly_report');
            }
            $wpf_auto_daily_report = $_POST['wpf_auto_daily_report'];
            if ($wpf_auto_daily_report == 'yes') {
                update_user_meta($user_id, 'wpf_auto_daily_report', $_POST['wpf_auto_daily_report']);
            } else {
                delete_user_meta($user_id, 'wpf_auto_daily_report');
            }
            $wpf_auto_weekly_report = $_POST['wpf_auto_weekly_report'];
            if ($wpf_auto_weekly_report == 'yes') {
                update_user_meta($user_id, 'wpf_auto_weekly_report', $_POST['wpf_auto_weekly_report']);
            } else {
                delete_user_meta($user_id, 'wpf_auto_weekly_report');
            }
            update_user_meta($user_id, 'wpf_user_initial_setup', 'yes');
            echo 1;
            exit;
        }else{
            echo 0;
            exit;
        }
    }
}

/*
 * This function is used to set the step 2 of the user onboarding wizard.
 *
 * @input Array ( $_POST )
 * @return Boolean
 */
add_action('wp_ajax_wpf_update_current_user_sec_step', 'wpf_update_current_user_sec_step');
add_action('wp_ajax_wpf_nopriv_update_current_user_sec_step', 'wpf_update_current_user_sec_step');
if (!function_exists('wpf_update_current_user_sec_step')) {
    function wpf_update_current_user_sec_step()
    {
        return 1;
        exit;
    }
}

/*
 * This function is used to upload the files for the task. This function is used from Frontend Pages, Backend Pages, Backend Tasks Center and Graphics Tasks.
 *
 * @input Array ( $_POST and $_FILES)
 * @return JSON
 */
add_action('wp_ajax_wpf_upload_file', 'wpf_upload_file');
add_action('wp_ajax_nopriv_wpf_upload_file', 'wpf_upload_file');
if (!function_exists('wpf_upload_file')) {
    function wpf_upload_file()
    {
        global $wpdb, $current_user;
        wpf_security_check();
        if ($current_user->ID == 0) {
            $user_id = get_option('wpf_website_client');
        } else {
            $user_id = $current_user->ID;
        }

        $wpf_taskid = $_POST['wpf_taskid'];
        require_once(ABSPATH . '/wp-load.php');
        require_once(ABSPATH . 'wp-admin/includes/admin.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        if (!empty($_FILES)) {
            foreach ($_FILES as $file) {
                if (is_array($file)) {

                    $wpf_allowed_filetypes = array("jpg", "png", "gif", "pdf", "doc", "docx" ,"xlsx");
                    $temp_wpf_file_name = $_FILES["wpf_upload_file"]["name"];
                    $temp_wpf_file_type = $_FILES["wpf_upload_file"]["type"];
                    $temp_wpf_file_ext = strtolower(end((explode(".", $temp_wpf_file_name))));

                    $data = file_get_contents($_FILES['wpf_upload_file']['tmp_name']);
                    $data = base64_encode($data);
                    //$invalid = wpf_verify_file_upload($_SERVER, $data);
                    $invalid = wpf_verify_file_upload_type($_SERVER, $temp_wpf_file_type);

                    if($invalid == 0){
                        if(!in_array($temp_wpf_file_ext, $wpf_allowed_filetypes)){
                            $invalid = 1;
                        }
                    }

                    if ($invalid == 0) {
                        $uploadedfile = $file;
                        $upload_overrides = array('test_form' => false);
                        $file_return = wp_handle_upload($uploadedfile, $upload_overrides);
                        if (isset($file_return['error']) || isset($file_return['upload_error_handler'])) {
                            $response = array(
                                'status' => 0,
                                'message' => 'error'
                            );
                        } else {
                            $filename = $file_return['file'];
                            if (in_array($file_return['type'], array('image/jpeg', 'image/png', 'image/gif'))) {
                                $file_type = 1;
                            } else {
                                $file_type = 2;
                            }
                            $attachment = array(
                                'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
                                'post_mime_type' => $file_return['type']
                            );
                            $attachment_id = wp_insert_attachment($attachment, $filename, $wpf_taskid);
                            require_once(ABSPATH . 'wp-admin/includes/image.php');
                            $attachment_data = wp_generate_attachment_metadata($attachment_id, $filename);
                            wp_update_attachment_metadata($attachment_id, $attachment_data);
                            if (0 < intval($attachment_id)) {
                                $attach_id = $attachment_id;
                                $comment_time = date('Y-m-d H:i:s', current_time('timestamp', 0));
                                $commentdata = array(
                                    'comment_post_ID' => $wpf_taskid,
                                    'comment_author' => $_POST['task_config_author_name'],
                                    'comment_author_email' => '',
                                    'comment_author_url' => '',
                                    'comment_content' => $file_return['url'],
                                    'comment_approved' => 1, 
                                    'comment_type' => 'wp_feedback',
                                    'comment_parent' => 0,
                                    'user_id' => $user_id,
                                    'comment_date' => $comment_time
                                );
                                $comment_id = $wpdb->insert("{$wpdb->prefix}comments", $commentdata);
                                /*if($wpf_every_new_task == 'yes') {
                                    wpf_send_email_notification($wpf_taskid, $comment_id, $_POST['task_notify_users'], 'new_comment');
                                }*/
                                $response = array(
                                    'status' => 1,
                                    'type' => $file_type,
                                    'message' => $file_return['url']
                                );
                            }
                        }
                    } else {
                        $response = array(
                            'status' => 0,
                            'message' => 'invalid'
                        );
                    }

                }
            }
        }

        echo json_encode($response);
        die();
    }
}

/*
 * This function is used to get ID of the page by URL. This function is used from Frontend Pages and Graphics Tasks.
 *
 * @input Array ( $_POST )
 * @return JSON
 */
add_action('wp_ajax_wpf_get_page_id_by_url', 'wpf_get_page_id_by_url');
add_action('wp_ajax_nopriv_wpf_get_page_id_by_url', 'wpf_get_page_id_by_url');
if (!function_exists('wpf_get_page_id_by_url')) {
    function wpf_get_page_id_by_url()
    {
        global $wpdb;
        wpf_security_check();
        $siteurl = get_option('siteurl');
        $response = array();
        $current_page_url = $_POST['current_page_url'];

        if (substr($current_page_url, -1) == '/') {
            $current_page_url = substr($current_page_url, 0, -1);
        }

        if (substr($siteurl, -1) == '/') {
            $siteurl = substr($siteurl, 0, -1);
        }

        if ($siteurl == $current_page_url) {
            $home_page_id = get_option('page_on_front');
            if ($home_page_id == 0) {
                $home_page_id = $blog_id = get_option('page_for_posts');
            }
            $query = "SELECT `post_title` FROM `{$wpdb->prefix}posts` WHERE `ID` = '" . $home_page_id . "'";
            $page_info = $wpdb->get_results($query, OBJECT);

            $response['ID'] = $home_page_id;
            $response['post_title'] = $page_info[0]->post_title;
        } else {
            $link_array = explode('/', $current_page_url);
            if (end($link_array) != '') {
                $slug = end($link_array);
            } else {
                $slug = $link_array[count($link_array) - 2];
            }

            $query = "SELECT `ID`,`post_title` FROM `{$wpdb->prefix}posts` WHERE `post_name` = '" . $slug . "'";
            $page_info = $wpdb->get_results($query, OBJECT);
            if ($page_info) {
                $response['ID'] = $page_info[0]->ID;
                $response['post_title'] = $page_info[0]->post_title;
            } else {
                $response['ID'] = 0;
                $response['post_title'] = 0;
            }
        }
        echo json_encode($response);

        exit;
    }
}

/*
 * This function is used to set the normal page element tasks as general task in case if they are orphaned. This function is used from Frontend Pages.
 *
 * @input Array ( $_POST )
 * @return Int
 */
add_action('wp_ajax_wpfb_set_general_comment', 'wpfb_set_general_comment');
add_action('wp_ajax_nopriv_wpfb_set_general_comment', 'wpfb_set_general_comment');
function wpfb_set_general_comment(){
    wpf_security_check();
    echo $wpfb_task_id = $_POST['wpfb_task_id'];
    update_post_meta($wpfb_task_id,'task_type','general');
    exit;
}

/*
 * This function is used to set the general tasks (created by orphaned service) as normal page. This function is used from Frontend Pages.
 *
 * @input Array ( $_POST )
 * @return Int
 */
add_action('wp_ajax_wpf_set_task_element', 'wpf_set_task_element');
add_action('wp_ajax_nopriv_wpf_set_task_element', 'wpf_set_task_element');
function wpf_set_task_element(){
    wpf_security_check();
    $wpf_task_ids = $_POST['wpf_task_ids'];
    foreach ($wpf_task_ids as $wpf_task_id){
        update_post_meta($wpf_task_id,'task_type','element');
    }
    echo 1;
    exit;
}

/*
 * This function is used to set change the title of the task. This function from Backend Tasks Center.
 *
 * @input Array ( $_POST )
 * @return JSON
 */
add_action('wp_ajax_wpf_update_title', 'wpf_update_title');
add_action('wp_ajax_nopriv_wpf_update_title', 'wpf_update_title');
if (!function_exists('wpf_update_title')) {
    function wpf_update_title()
    {
        $response = array();
        wpf_security_check();
        $wpf_new_task_title = trim($_POST['wpf_new_task_title']);
        $wpf_task_id = $_POST['wpf_task_id'];
        if (!empty($wpf_new_task_title) && $wpf_task_id !=''){ 
            $my_post = array(
               'ID' =>  $wpf_task_id,
               'post_title'    => $wpf_new_task_title
            );
            $wpf_task_id = wp_update_post( $my_post );
            if($wpf_task_id){
                $response['wpf_msg'] = 1;
                $response['wpf_new_task_title'] = $wpf_new_task_title;
                $response['wpf_task_id'] = $wpf_task_id;
            }else{
                $response['wpf_msg'] = 0;
            }
            do_action('wpf_crm_update_task_title_action',$response);
        }
       
        echo json_encode($response);
        exit;
    }
}

/*
 * This function is used to set the tag to the task. This function is used from Frontend Pages, Backend Pages and Backend Tasks Center.
 *
 * @input Array ( $_POST )
 * @return JSON
 */
add_action('wp_ajax_wpfb_set_task_tag','wpfb_set_task_tag');
add_action('wp_ajax_nopriv_wpfb_set_task_tag','wpfb_set_task_tag');
if (!function_exists('wpfb_set_task_tag')) {
    function wpfb_set_task_tag(){
        wpf_security_check();
        $response = array();
        $task_list_tags_array = array();
        $response['wpf_tag_type'] = '';
        $response['wpf_task_tag_name'] = '';
        $response['wpf_task_tag_slug'] = '';
        $wpf_task_tag_info = $_POST['wpf_task_tag_info'];
        $wpf_tag_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $wpf_task_tag_info['wpf_task_tag_name'])));
        $wpf_task_tag_info['wpf_task_tag_slug'] = $wpf_tag_slug;
        $wpf_task_tags_obj = get_the_terms( $wpf_task_tag_info['wpf_task_id'], 'wpf_tag' );
        if ( ! empty( $wpf_task_tags_obj ) && ! is_wp_error( $wpf_task_tags_obj ) ) {
            $task_list_tags_array = wp_list_pluck($wpf_task_tags_obj, 'slug');
        }
        if(in_array($wpf_tag_slug, $task_list_tags_array)){
            $response['wpf_task_tag_name'] = $wpf_task_tag_info['wpf_task_tag_name'];
            $response['wpf_msg'] = 0;
            $response['wpf_tag_type'] = 'already_exit';
        }
        else{
            $wpf_term = term_exists( $wpf_tag_slug, 'wpf_tag' );
            if ( $wpf_term !== 0 && $wpf_term !== null ) {
                $wpf_term = wp_set_object_terms($wpf_task_tag_info['wpf_task_id'], $wpf_tag_slug, 'wpf_tag', true);
                if($wpf_term) {
                    $response['wpf_task_tag_name'] = $wpf_task_tag_info['wpf_task_tag_name'];
                    $response['wpf_task_tag_slug'] = $wpf_tag_slug;
                    $response['wpf_msg'] = 1;
                    $response['wpf_term_id'] = $wpf_term[0];
                    $response['wpf_tag_type'] = 'exist';
                    do_action('wpf_crm_update_tag_action',$wpf_task_tag_info);
                } else {
                    $response['wpf_msg'] = 0;
                }
            }else{
                $wpf_term = wp_set_object_terms($wpf_task_tag_info['wpf_task_id'], $wpf_task_tag_info['wpf_task_tag_name'], 'wpf_tag', true);
                if($wpf_term) {
                    $response['wpf_task_tag_slug'] = $wpf_tag_slug;
                    $response['wpf_task_tag_name'] = $wpf_task_tag_info['wpf_task_tag_name'];
                    $response['wpf_msg'] = 1;
                    $response['wpf_tag_type'] = 'new';
                    do_action('wpf_crm_update_tag_action',$wpf_task_tag_info);
                } else {
                    $response['wpf_msg'] = 0;
                }
            }
        }
        
        echo json_encode($response); 
        exit;
    }
}

/*
 * This function is used to delete the tag from the task. This function is used from Frontend Pages, Backend Pages and Backend Tasks Center.
 *
 * @input Array ( $_POST )
 * @return JSON
 */
add_action('wp_ajax_wpfb_delete_task_tag','wpfb_delete_task_tag');
add_action('wp_ajax_nopriv_wpfb_delete_task_tag','wpfb_delete_task_tag');
if (!function_exists('wpfb_delete_task_tag')) {
    function wpfb_delete_task_tag(){
        wpf_security_check();
        $response = array();
        $task_list_tags_array = array();
        $wpf_task_tag_info = $_POST['wpf_task_tag_info'];

        $wpf_task_tag_slug = $wpf_task_tag_info['wpf_task_tag_slug'];
        $wpf_task_id = $wpf_task_tag_info['wpf_task_id']; 

        if($wpf_task_tag_slug !='' && $wpf_task_id != ''){
            $wpf_delete_term =  wp_remove_object_terms($wpf_task_id,$wpf_task_tag_slug,'wpf_tag');
            if($wpf_delete_term){
                $response['wpf_task_tag_slug'] = $wpf_task_tag_info['wpf_task_tag_slug'];
                $response['wpf_task_tag_name'] = $wpf_task_tag_info['wpf_task_tag_name'];
                $response['wpf_task_id'] = $wpf_task_tag_info['wpf_task_id']; 
                $response['wpf_msg'] = 1; 
                do_action('wpf_crm_delete_task_tags_action',$wpf_task_tag_info);
            }else{
                $response['wpf_msg'] = 0; 
            }
        }else{
             $response['wpf_msg'] = 0; 
        }
        
        echo json_encode($response); 
        exit;
    }
}

/*=====================Graphics feature Start=====================*/

/*
 * This function is used to get all the child post of graphics post. This function is used is not used now.
 *
 * @input Int
 * @return Array
 */
if (!function_exists('wpf_get_all_child_post')) {
    function wpf_get_all_child_post($post_parent_id){
        $all_wpfeedback = array();
        $all_post = '';
        $args = array(
                'post_parent' => $post_parent_id,
                'post_type'   => 'wpfeedback',
                'numberposts' => -1,
                'post_status' => 'any',
                'orderby'    => 'date',
                'order'       => 'DESC'
                );
                $wpfb_tasks = get_children( $args );
                if($wpfb_tasks){
                    foreach ($wpfb_tasks as $wpfb_task) {
                    $all_wpfeedback[] = $wpfb_task->ID;
                    }
                    $all_post = implode(',',$all_wpfeedback);
                }
                return $all_post;    
    }
}

/*
 * This function is used to create a graphics. This function is used from Backend Graphics Tab.
 *
 * @input Int
 * @return String (HTML)
 */
if (!function_exists('wpf_create_graphics')) {
    function wpf_create_graphics(){
        global $wpdb, $current_user;
        $graphics_name = stripslashes(html_entity_decode($_POST['wpf_graphics_name'], ENT_QUOTES, 'UTF-8'));
        $new_graphics = array(
            'post_excerpt' => $_POST['wpf_graphics_excerpt'],
            'post_status' => 'publish',
            'post_title' => $graphics_name,
            'post_type' => 'wpf_graphics',
            'post_author' => $current_user->ID
        );
        $graphics_id = wp_insert_post($new_graphics);
        if($graphics_id){
            update_post_meta($graphics_id,'_thumbnail_id',$_POST['wpf_feature_id']);

            echo $output .= '<div class="wpf-col-3" id="'.$graphics_id.'"><a href="javascript:wpf_delete_conformation('.$graphics_id.')" class="wpf_graphics_delete_btn"><i class="gg-trash"></i></a><a target="_blank" href="'.get_permalink($graphics_id).'"><div class="wpf_graphics_thumb" style="background-image:url('.get_the_post_thumbnail_url($graphics_id,'large').')"><div class="wpf_graphics_title">'.$graphics_name.'</div></div></a></div>';
        }
        exit;
    }
    add_action('wp_ajax_wpf_create_graphics','wpf_create_graphics');
    add_action('wp_ajax_nopriv_wpf_create_graphics','wpf_create_graphics');
}

/*
 * This function is used to change background color of graohics. This function is used from Frontend Graphics Post.
 *
 * @input Array ( $_POST )
 * @return Int
 */
if (!function_exists('wpf_update_graphics_color')) {
    function wpf_update_graphics_color(){
        $wpf_graphics_color_name = $_POST['wpf_graphics_color_name'];
        if($wpf_graphics_color_name){
            echo update_option('wpf_graphics_color_name',$wpf_graphics_color_name);
        }else{
            echo 0;
        }
        exit;
    }
    add_action('wp_ajax_wpf_update_graphics_color','wpf_update_graphics_color');
    add_action('wp_ajax_nopriv_wpf_update_graphics_color','wpf_update_graphics_color');
}

/*
 * This function is used to upload a new image to the graphics. This function is used from Frontend Graphics Post.
 *
 * @input Array ( $_POST )
 * @return String
 */
if (!function_exists('wpf_update_graphics_image')) {
    function wpf_update_graphics_image(){
        wpf_security_check();
        $wpf_new_graphics_img_id = $_POST['wpf_graphics_img_id'];
        $current_page_id = $_POST['current_page_id'];
        $get_privious_all_graphics = get_post_meta($current_page_id,'_wpf_graphics_img_id',true);
        $get_current_graphics = get_post_meta($current_page_id,'_thumbnail_id',true);

        if($wpf_new_graphics_img_id && $current_page_id){
            if($get_privious_all_graphics){
                $all_graphics_version = $get_privious_all_graphics.','.$get_current_graphics;
                update_post_meta($current_page_id,'_wpf_graphics_img_id',$all_graphics_version);
            }else{
                update_post_meta($current_page_id,'_wpf_graphics_img_id',$get_current_graphics);
            }
            update_post_meta($current_page_id,'_thumbnail_id',$wpf_new_graphics_img_id);
            echo wpf_grapgics_version_list($current_page_id);
        }else{
            echo wpf_grapgics_version_list($current_page_id);
        }
        exit;
    }
    add_action('wp_ajax_wpf_update_graphics_image','wpf_update_graphics_image');
    add_action('wp_ajax_nopriv_wpf_update_graphics_image','wpf_update_graphics_image');
}

/*
 * This function is used to get image of the graphics. This function is used from Frontend Graphics Post.
 *
 * @input Array ( $_POST )
 * @return String
 */
if (!function_exists('wpf_get_graphics_version')) {
    function wpf_get_graphics_version(){
        $wpf_graphics_id = $_POST['wpf_graphics_id'];
        $current_page_id = $_POST['current_page_id'];
        if($wpf_graphics_id){
           $wpf_graphics_url =  wp_get_attachment_url($wpf_graphics_id);
           if($wpf_graphics_url){
            echo $wpf_graphics_img = $wpf_graphics_url;
           }else{
             $get_current_graphics = get_post_meta($current_page_id,'_thumbnail_id',true);
             echo $get_current_graphics_url =  wp_get_attachment_url($get_current_graphics);
           }
        }else{
            $get_current_graphics = get_post_meta($current_page_id,'_thumbnail_id',true);
            echo $get_current_graphics_url =  wp_get_attachment_url($get_current_graphics);
        }
        exit;
    }
    add_action('wp_ajax_wpf_get_graphics_version','wpf_get_graphics_version');
    add_action('wp_ajax_nopriv_wpf_get_graphics_version','wpf_get_graphics_version');
}

/*
 * This function is used to update the co-ordinates of the task. This function is used from Frontend Graphics Post.
 *
 * @input Array ( $_POST )
 * @return Boolean
 */
if (!function_exists('wpf_graphics_update_task_coordinates')) {
    function wpf_graphics_update_task_coordinates(){
        wpf_security_check();
        $task_info = $_POST['task_info'];
        if($task_info['task_id']){
            update_post_meta($task_info['task_id'],'task_element_width',$task_info['task_element_width']);
            update_post_meta($task_info['task_id'],'task_element_height',$task_info['task_element_height']);
            update_post_meta($task_info['task_id'],'task_top',$task_info['task_top']);
            update_post_meta($task_info['task_id'],'task_left',$task_info['task_left']);
            echo 1;
        }else{
            echo 0;
        }
        exit;
    }
    add_action('wp_ajax_wpf_graphics_update_task_coordinates','wpf_graphics_update_task_coordinates');
    add_action('wp_ajax_nopriv_wpf_graphics_update_task_coordinates','wpf_graphics_update_task_coordinates');
}

/*
 * This function is used to update the co-ordinates of the task. This function is used from Frontend Graphics Post.
 *
 * @input Array ( $_POST )
 * @return Int
 */
if (!function_exists('wpf_completed_graphics')) {
    function wpf_completed_graphics(){
        $wpf_graphics_status = $_POST['wpf_graphics_status'];
        $wpf_graphics_id = $_POST['wpf_graphics_id'];
        if($wpf_graphics_id){
            /*$wpf_all_posts = wpf_get_all_child_post($wpf_graphics_id);
            $wpf_all_posts_array = explode(',', $wpf_all_posts);*/
            if($wpf_graphics_status == 1){
                update_post_meta($wpf_graphics_id,'wpf_complete_graphics','yes');
                /*if($wpf_all_posts_array){
                    foreach ($wpf_all_posts_array as $wpf_post_id) {
                        wp_set_object_terms($wpf_post_id, 'complete', 'task_status', false);
                    }
                }*/
                echo 1;
            }
            else if($wpf_graphics_status == 2){
                delete_post_meta($wpf_graphics_id,'wpf_complete_graphics');
                /*if($wpf_all_posts_array){
                    foreach ($wpf_all_posts_array as $wpf_post_id) {
                        wp_set_object_terms($wpf_post_id, 'open', 'task_status', false);
                    }
                }*/
                echo 2;
            }else{
                echo 0;
            }
            
        }else{
            echo 0;
        }
        exit;
    }
    add_action('wp_ajax_wpf_completed_graphics','wpf_completed_graphics');
    add_action('wp_ajax_nopriv_wpf_completed_graphics','wpf_completed_graphics');
}

/*
 * This function is used to reconnect the general task to the element. This function is used from Frontend Pages and Backend Pages.
 *
 * @input Array ( $_POST )
 * @return Boolean
 */
if (!function_exists('wpf_reconnect_task')) {
    function wpf_reconnect_task(){
        wpf_security_check();
        $new_reconnect_obj = $_POST['new_reconnect_obj'];
        if($new_reconnect_obj['wpf_reconnect_taskid'] != ''){
            update_post_meta($new_reconnect_obj['wpf_reconnect_taskid'],'task_element_path',$new_reconnect_obj['rightArrowParents']);
            update_post_meta($new_reconnect_obj['wpf_reconnect_taskid'],'wpfb_task_bubble',$new_reconnect_obj['dompath']);

            update_post_meta($new_reconnect_obj['wpf_reconnect_taskid'],'task_element_height',$new_reconnect_obj['html_element_height']);
            update_post_meta($new_reconnect_obj['wpf_reconnect_taskid'],'task_element_width',$new_reconnect_obj['html_element_width']);
            update_post_meta($new_reconnect_obj['wpf_reconnect_taskid'],'task_type','element');
            echo 1;
        }else{
            echo 0;
        }
        exit;
    }
    add_action('wp_ajax_wpf_reconnect_task','wpf_reconnect_task');
    add_action('wp_ajax_nopriv_wpf_reconnect_task','wpf_reconnect_task');
}

/*
 * This function is used delete the graphics post. This function is used from Backend Graphics Post.
 *
 * @input Array ( $_POST )
 * @return Boolean
 */
add_action('wp_ajax_wpfb_delete_grapgics','wpfb_delete_grapgics');
add_action('wp_ajax_nopriv_wpfb_delete_grapgics','wpfb_delete_grapgics');
if (!function_exists('wpfb_delete_grapgics')) {
    function wpfb_delete_grapgics()
    {
        wpf_security_check();
        $wpfb_grapgics_id = $_POST['wpfb_grapgics_id'];
        if (wp_delete_post($wpfb_grapgics_id,true)) {
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }
}
/*=====================Graphics feature End=====================*/

/*
 * This function is used to do the bulk updates. This function is used from Backend Tasks Center.
 *
 * @input Array ( $_POST )
 * @return JSON
 */
add_action('wp_ajax_wpf_bulk_update_tasks','wpf_bulk_update_tasks');
add_action('wp_ajax_nopriv_wpf_bulk_update_tasks','wpf_bulk_update_tasks');
if (!function_exists('wpf_bulk_update_tasks')) {
    function wpf_bulk_update_tasks()
    {
        wpf_security_check();
        $wpf_task_ids = $_POST['wpf_task_ids'];
        $wpf_task_priority_attr = $_POST['wpf_task_priority_attr'];
        $wpf_task_task_status_attr = $_POST['wpf_task_task_status_attr'];
        $response = array();
        $task_status_info = array();
        $task_priority_info = array();
        if($wpf_task_task_status_attr){
            foreach ($wpf_task_ids as $wpf_task_id) {
                wp_set_object_terms($wpf_task_id, $wpf_task_task_status_attr, 'task_status', false);
                $task_status_info['task_id'] = $wpf_task_id;
                $task_status_info['task_status'] = $wpf_task_task_status_attr;
                do_action('wpf_crm_update_task_status_action',$task_status_info);
            }
            $response['wpf_msg'] = 1;
        }
        if($wpf_task_priority_attr){
            foreach ($wpf_task_ids as $wpf_task_id) {
                wp_set_object_terms($wpf_task_id, $wpf_task_priority_attr, 'task_priority', false);
                $task_priority_info['task_id'] = $wpf_task_id;
                $task_priority_info['task_priority'] = $wpf_task_task_status_attr;
                do_action('wpf_crm_update_task_priority_action',$task_priority_info);
                //$response['wpf_taskids'][] = $wpf_task_id;
            }
            $response['wpf_msg'] = 1;
        }
        echo json_encode($response);
        exit;
    }
}