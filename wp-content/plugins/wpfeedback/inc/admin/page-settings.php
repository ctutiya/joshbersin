<div class="wrap wpfeedback-settings">
    <style>
        div#wpf_launcher{
            display: none !important;
        }
    </style>
    <?php 
    global $current_user;
    $wpf_user_name = $current_user->user_nicename;
    $wpf_user_email = $current_user->user_email;
    $wpfeedback_font_awesome_script = get_option('wpf_font_awesome_script');
    $wpf_user_type = wpf_user_type();

    wp_register_style('wpf_admin_bootstrap_style', WPF_PLUGIN_URL . 'css/bootstrap.min.css', false, WPF_VERSION);
    wp_enqueue_style('wpf_admin_bootstrap_style');

    wp_register_script('wpf_admin_bootstrap_script', WPF_PLUGIN_URL . 'js/bootstrap.min.js', array('jquery'), WPF_VERSION, true);
    wp_enqueue_script('wpf_admin_bootstrap_script');

    if($wpf_user_type=='advisor'){
        $wpf_tab_permission_user = get_option('wpf_tab_permission_user_webmaster') ? 'true' : 'false';
        $wpf_tab_permission_priority = get_option('wpf_tab_permission_priority_webmaster') ? 'true' : 'false';
        $wpf_tab_permission_status = get_option('wpf_tab_permission_status_webmaster') ? 'true' : 'false';
        $wpf_tab_permission_screenshot = get_option('wpf_tab_permission_screenshot_webmaster') ? 'true' : 'false';
        $wpf_tab_permission_information = get_option('wpf_tab_permission_information_webmaster') ? 'true' : 'false';
        $wpf_tab_permission_delete_task = get_option('wpf_tab_permission_delete_task_webmaster') ? 'all' : 'own';
    }
    elseif ($wpf_user_type=='king'){
        $wpf_tab_permission_user = get_option('wpf_tab_permission_user_client') ? 'true' : 'false';
        $wpf_tab_permission_priority = get_option('wpf_tab_permission_priority_client') ? 'true' : 'false';
        $wpf_tab_permission_status = get_option('wpf_tab_permission_status_client') ? 'true' : 'false';
        $wpf_tab_permission_screenshot = get_option('wpf_tab_permission_screenshot_client') ? 'true' : 'false';
        $wpf_tab_permission_information = get_option('wpf_tab_permission_information_client') ? 'true' : 'false';
        $wpf_tab_permission_delete_task = get_option('wpf_tab_permission_delete_task_client') ? 'all' : 'own';
    }
    elseif ($wpf_user_type=='council'){
        $wpf_tab_permission_user = get_option('wpf_tab_permission_user_others') ? 'true' : 'false';
        $wpf_tab_permission_priority = get_option('wpf_tab_permission_priority_others') ? 'true' : 'false';
        $wpf_tab_permission_status = get_option('wpf_tab_permission_status_others') ? 'true' : 'false';
        $wpf_tab_permission_screenshot = get_option('wpf_tab_permission_screenshot_others') ? 'true' : 'false';
        $wpf_tab_permission_information = get_option('wpf_tab_permission_information_others') ? 'true' : 'false';
        $wpf_tab_permission_delete_task = get_option('wpf_tab_permission_delete_task_others') ? 'all' : 'own';
    }
    else{
        $wpf_tab_permission_user = 'false';
        $wpf_tab_permission_priority = 'false';
        $wpf_tab_permission_status = 'false';
        $wpf_tab_permission_screenshot = 'true';
        $wpf_tab_permission_information = 'true';
        $wpf_tab_permission_delete_task = 'own';
    }

    if ($wpfeedback_font_awesome_script == 'yes') { ?>
        <link rel='stylesheet' id='wpf-font-awesome-all'  href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" media="all" crossorigin="anonymous"/>
    <?php } ?>
    <script>
        jQuery(document).ready(function () {
            jQuery_WPF('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <h1><?php //echo esc_html( get_admin_page_title() ); ?></h1>
    <div class="wpf_logo">
        <img src="<?php echo get_wpf_logo(); ?>" alt="WP FeedBack">
    </div>

    <!-- ================= TOP TABS ================-->

    <div class="wpf_tabs_container" id="wpf_tabs_container">
        <button class="wpf_tab_item wpf_tasks active" onclick="openWPFTab('wpf_tasks')"
                style="background-color: #efefef;"><?php _e('Tasks', 'wpfeedback'); ?>
        </button>
        <button class="wpf_tab_item wpf_graphics" onclick="location.href='admin.php?page=wpfeedback_page_graphics'"
                    style="background-color: #efefef;"><?php _e('Graphics', 'wpfeedback'); ?>
        </button>
        <?php if($wpf_user_type == 'advisor' || ($wpf_user_type == '' && current_user_can('administrator') ) ){ ?>
            <button class="wpf_tab_item wpf_settings" onclick="openWPFTab('wpf_settings')"
                    style="background-color: #efefef;"><?php _e('Settings', 'wpfeedback'); ?>
            </button>
        <?php }
        if($wpf_user_type == 'advisor' || ($wpf_user_type == '' && current_user_can('administrator') ) ){ ?>
            <button class="wpf_tab_item wpf_misc" onclick="location.href='admin.php?page=wpfeedback_page_permissions'"
                    style="background-color: #efefef;"><?php _e('Permissions', 'wpfeedback'); ?>
            </button>
        <?php }
        if($wpf_user_type == 'advisor' || $wpf_user_type == 'king' || ($wpf_user_type == '' && current_user_can('administrator') ) ){ ?>
            <button class="wpf_tab_item wpf_addons" onclick="openWPFTab('wpf_addons')" style="background-color: #efefef;">
                <?php _e('Integrate', 'wpfeedback'); ?>
            </button>
        <?php } if($wpf_user_type == 'advisor' || ($wpf_user_type == '' && current_user_can('administrator') ) ){ ?>
            <button class="wpf_tab_item wpf_support" onclick="openWPFTab('wpf_support')" style="background-color: #efefef;">
                <?php _e('Support', 'wpfeedback'); ?>
            </button>
            <a href="https://wpfeedback.co/wpf-pro/#plans" target="_blank" class="wpf_tab_item" style="background-color: #efefef;">
                <button>
                    <?php _e('Upgrade', 'wpfeedback'); ?>
                </button>
            </a>
        <?php } ?>

    </div>

    <!-- ================= TASKS PAGE ================-->
    <?php
        $wpf_daily_report = get_option('wpf_daily_report');
        $wpf_weekly_report = get_option('wpf_weekly_report');
    ?>
    <div id="wpf_tasks" class="wpf_container">
        <?php
        $wpf_license = get_option('wpf_license');
        if($wpf_license !='valid'){
        ?>
		<div id="wpf_tasks_overlay"><div class="wpf_welcome_wrap"><div class="wpf_welcome_title">Welcome to WP FeedBack PRO </div><div class="wpf_welcome_note">It's good to have you here <?php _e($wpf_user_name, 'wpfeedback'); ?>! ❤</div>
			<div class="wpf_welcome_image"><img alt="" src="<?php echo WPF_PLUGIN_URL.'images/WPF-welcome_720.png'; ?>"/></div><div class="wpf_welcome_note">Please click on the <u onclick="location.href='admin.php?page=wpfeedback_page_permissions'">Permissions tab</u> and verify your license to start using the plugin</div></div></div>
        <?php } ?>
        <div class="wpf_section_title">
            <?php _e('Tasks Center', 'wpfeedback'); ?>

            <div class="wpf_report_buttons">
                <span class="wpf_search_box"><i class="gg-search"></i><input onchange="wp_feedback_cat_filter()" type="text" name="wpf_search_title" class="wpf_search_title" value="" id="wpf_search_title" placeholder="<?php _e('Search by task title', 'wpfeedback'); ?>"></span>
                <span id="wpf_back_report_sent_span" class="wpf_hide text-success"><?php _e('Your report was sent', 'wpfeedback'); ?></span>
                <?php
                    if($wpf_daily_report=='yes') {
                        ?>
                        <a href="javascript:wpf_send_report('daily_report')"><i class="gg-mail"></i> <?php _e('Daily Report', 'wpfeedback'); ?></a>
                        <?php
                    }
                    if($wpf_weekly_report=='yes') {
                        ?>
                        <a href="javascript:wpf_send_report('weekly_report')"><i class="gg-mail"></i> <?php _e('Weekly Report', 'wpfeedback'); ?></a>
                        <?php
                    }
            	 ?>
			</div>
        </div>
        <div class="wpf_flex_wrap">
            <div class="wpf_filter_col wpf_gen_col">
                <div class="wpf_filter_status wpf_icon_box">
                    <div class="wpf_title"><?php _e('Filter Tasks', 'wpfeedback'); ?></div>
                    <form method="post" action="#" id="wpf_filter_form">

                        <div class="wpf_task_status_title wpf_icon_title"><i class="gg-screen"></i> <?php _e('Task Types', 'wpfeedback'); ?>
                        </div>
                         <div>
                            <ul class="wp_feedback_filter_checkbox task_type">
                                <li><input onclick="wp_feedback_cat_filter()" type="checkbox" name="task_types_meta" value="general" class="wp_feedback_task_type" id="wpf_task_type_general"><label for="wpf_task_type_general"><?php _e('General', 'wpfeedback'); ?></label></li>
                                
                                <li><input onclick="wp_feedback_cat_filter()" type="checkbox" name="task_types" value="wpf_admin" class="wp_feedback_task_type" id="wpf_task_type_admin"><label for="wpf_task_type_admin"><?php _e('Admin', 'wpfeedback'); ?></label></li>

                                <li><input onclick="wp_feedback_cat_filter()" type="checkbox" name="task_types" value="publish" class="wp_feedback_task_type" id="wpf_task_type_page"><label for="wpf_task_type_page"><?php _e('Page', 'wpfeedback'); ?></label></li>

                                <li><input onclick="wp_feedback_cat_filter()" type="checkbox" name="task_types_meta" value="graphics" class="wp_feedback_task_type" id="wpf_task_type_graphics"><label for="wpf_task_type_graphics"><?php _e('Graphics', 'wpfeedback'); ?></label></li>
                            </ul>
                        </div>

                        <div class="wpf_task_status_title wpf_icon_title"><i class="gg-thermostat"></i><?php _e('Task Status', 'wpfeedback'); ?>
                        </div>
                        <input type="hidden" name="page" value="wpfeedback_page_settings">
                        <div><?php echo wp_feedback_get_texonomy('task_status'); ?></div>
                        <div class="wpf_task_priority_title wpf_icon_title"><i class="gg-danger"></i></i>
                            <?php _e('Task Urgency', 'wpfeedback'); ?>
                        </div>
                        <div><?php echo wp_feedback_get_texonomy('task_priority'); ?></div>
                        <div class="wpf_user_title wpf_icon_title"><i class="gg-profile"></i></i> <?php _e('By Users', 'wpfeedback'); ?></div>
                        <div><?php echo do_shortcode('[wpf_user_list]'); ?></div>
                        <!--<input type="button" name="wp_feedback_filter_btn" value="<?php /*_e('Filter', 'wpfeedback'); */?>" id="wp_feedback_filter_btn"
                               class="wpf_button" onclick="wp_feedback_cat_filter()">-->
                    </form>
                </div>
            </div>
            <div class="wpf_loader_admin hidden"></div>
            <div class="wpf_tasks_col wpf_gen_col">
				<div class="wpf_top_found"><div class="wpf_title" id="wpf_task_tab_title"><?php _e('Tasks Found', 'wpfeedback'); ?></div>
                    <a href="javascript:wpf_general_comment();" title="Click to give your feedback!" data-placement="left" class="wpf_general_comment_btn" id="wpf_add_general_task"><i class="gg-add"></i>  <?php _e('General', 'wpfeedback'); ?></a><div class="wpf_display_all_taskmeta_div"></div>
                </div>
                <div class="wpf_tasks_tabs_wrap">
                    <label><input type="checkbox" name="wpf_task_bulk_tab" class="wpf_task_bulk_tab" id="wpf_task_bulk_tab" onclick="wpf_tasks_tabs('bulk')" /><?php _e('Bulk Action', 'wpfeedback'); ?></label>
                    <label><input type="checkbox" name="wpf_display_all_taskmeta" id="wpf_display_all_taskmeta_tasktab" class="wpf_display_all_taskmeta" /><?php _e('Show Details', 'wpfeedback'); ?></label>
                </div>
                <div id="wpf_bulk_select_task_checkbox" style="display: none;"><label><input type="checkbox" name="wpf_select_all_task" id="wpf_select_all_task" class="wpf_select_all_task"><?php _e('Edit All', 'wpfeedback'); ?></label></div>
                <div class="wpf_tasks-list"><?php echo $tasks = wpfeedback_get_post_list(); ?></div>
            </div>
            <div class="wpf_chat_col wpf_gen_col" id="wpf_task_details">
                <div class="wpf_chat_top">
                    <div class="wpf_task_num_top"></div>
                    <div class="wpf_task_main_top">
                        <div class="wpf_task_title_top"></div><a href="javascript:void(0)" onclick="wpf_edit_title()" id="wpf_edit_title"><i class="gg-pen"></i></a>
                        <div id="wpf_edit_title_box" class="wpf_hide"><input type="text" name="wpf_edit_title" value="" id="wpf_title_val" > 
                        <button id="wpf_title_update_btn" onclick="wpf_update_title()" class="submit wpf_button submit"><i class="gg-check"></i></button>
                        </div>
                        <div class="wpf_task_details_top"></div>
                    </div>
                </div>
				 <div class="wpf_task_tabs_container" id="wpf_task_tabs_container">
                        <a class="wpf_message_content wpf_task_tab_item" onclick="wpf_open_tab('wpf_message_content')" ><?php _e('Comments', 'wpfeedback'); ?></a>
                        <a class="wpf_task_screenshot_tab wpf_task_tab_item active" onclick="wpf_open_tab('wpf_task_screenshot_tab')"><?php _e('Screenshot', 'wpfeedback'); ?></a>
                  </div>
                <?php if($tasks=='<div class="wpf_no_tasks_found"><i class="gg-info"></i> No tasks found</div>'){ ?>
                <div class="wpf_chat_box" id="wpf_message_content">
                    <p class="wpf_no_task_message"><b><?php _e('No Tasks found.', 'wpfeedback'); ?></b><br/><?php _e('Please have a look at the video to understand the process.', 'wpfeedback'); ?></p>
                    <?php
                        if(get_option('wpf_tutorial_video')=='') {
                            ?>
                            <script src="https://fast.wistia.com/embed/medias/cided37ieu.jsonp" async></script>
                            <script src="https://fast.wistia.com/assets/external/E-v1.js" async></script>
                            <div class="wistia_responsive_padding" style="padding:48.75% 0 0 0;position:relative;">
                                <div class="wistia_responsive_wrapper"
                                     style="height:100%;left:0;position:absolute;top:0;width:100%;">
                                    <div class="wistia_embed wistia_async_cided37ieu videoFoam=true"
                                         style="height:100%;position:relative;width:100%">&nbsp;
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        else{
							echo html_entity_decode(get_option('wpf_tutorial_video'));
                        }
                     ?>
                </div>
                <?php } else{ ?>
                <div class="wpf_chat_box wpf_hide" id="wpf_message_content">
                    <ul id="wpf_message_list"></ul>
                </div>
                <?php } ?>
                <div class="wpf_chat_reply wpf_hide" id="wpf_message_form"></div>
                <div class="wpf_task_screenshot_tab" id="wpf_task_screenshot_tab">
                    <a href="#" id="wpf_task_screenshot_link" target="_blank"> <img src="" id="wpf_task_screenshot"></a><div class="wpf_task_screenshot_notice"><?php _e('The screenshot is for reference purposes only. Things may differ depending browsers/devices.', 'wpfeedback'); ?></div>
                    <div class="wpf_view_comments">
                        <a href="javascript:wpf_open_tab('wpf_message_content')" class="wpf_button"><i class="gg-comment"></i><?php _e('View Comments', 'wpfeedback'); ?></a>
                    </div>
                </div>
            </div>
            <div class="wpf_attributes_col wpf_gen_col" id="wpf_attributes_content">
                <div class="wpf_task_attr wpf_task_title">
                    <a href="#" id="wpfb_attr_task_page_link" target="_blank" class="wpf_button"><i class="gg-external"></i>
                        <input type="button" name="wp_feedback_task_page" class="wpf_button" value="<?php _e('Open Task\'s Page', 'wpfeedback'); ?>"></a>
                <div class="wpf_title"><?php _e('Task Attributes', 'wpfeedback'); ?></div>
				</div>

                <div class="wpf_task_attr wpf_task_page">
                    <?php if($wpf_tab_permission_information == 'true'){ ?>
                    <div class="wpf_icon_title"><i class="gg-globe"></i> <?php _e('Additional Information', 'wpfeedback'); ?></div>
                    <div id="additional_information">
                    </div>
                    <?php } ?>
                </div>

                <div class="wpf_task_attr">

                    <?php if($wpf_user_type=='advisor'){ ?>
                        <div class="wpf_task_tags">
                            <div class="wpf_icon_title"><i class="gg-tag"></i> <?php _e('Custom Tags', 'wpfeedback'); ?></div>
                            <div class="wpf_tag_autocomplete"><input type="text" name="wpfeedback_tags" class="wpf_tag" value="" id="wpf_tags" onkeydown="wpf_search_tags(this)" ><button class="wpf_tag_submit_btn" onclick="wpf_add_tag_admin()"><i class="gg-corner-down-left"></i></button></div>
    						<div id="all_tag_list"></div>
                        </div>
                    <?php } ?>
                    <?php if($wpf_tab_permission_status == 'true'){ ?>
                        <div class="wpf_task_status">
                            <div class="wpf_icon_title"><i class="gg-thermostat"></i> <?php _e('Task Status', 'wpfeedback'); ?></div>
                            <?php echo wp_feedback_get_texonomy_selectbox('task_status'); ?>
                        </div>
                    <?php }
                    if($wpf_tab_permission_priority=='true'){ ?>
                        <div class="wpf_task_urgency">
                            <div class="wpf_icon_title"><i class="gg-danger"></i> <?php _e('Task Urgency', 'wpfeedback'); ?></div>
                            <?php echo wp_feedback_get_texonomy_selectbox('task_priority'); ?>
                        </div>
                    <?php } ?>
                    <?php if($wpf_tab_permission_delete_task == 'all'){ ?>
                    <div class="wpf_task_attr wpf_task_title" id="wpf_delete_task_container">
                    </div>
                    <?php } else{ ?>
                            <div class="wpf_task_attr wpf_task_title" id="wpf_delete_task_container"></div>
                    <?php } ?>
                </div>


                <div class="wpf_task_attr wpf_task_users">
                    <?php if($wpf_tab_permission_user == 'true'){ ?>
                    <div class="wpf_icon_title"><i class="gg-profile"></i> <?php _e('Notify Users', 'wpfeedback'); ?></div>
                    <div class="wpf_checkbox">
                        <?php echo do_shortcode('[wpf_user_list_task]'); ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="wpf_bulk_update_col wpf_gen_col" id="wpf_bulk_update_content" style="display: none;">
                <div class="wpf_task_options">
                    <div class="wpf_task_status">
                        <div class="wpf_icon_title"><i class="gg-thermostat"></i> <?php _e('Task Status', 'wpfeedback'); ?></div>
                        <?php echo wpf_bulk_update_get_texonomy_selectbox('task_status'); ?>
                    </div>
                    <div class="wpf_task_urgency">
                        <div class="wpf_icon_title"><i class="gg-danger"></i> <?php _e('Task Urgency', 'wpfeedback'); ?></div>
                        <?php echo wpf_bulk_update_get_texonomy_selectbox('task_priority'); ?>
                    </div>

                    <div class="wpf_task_attr wpf_task_title" id="wpf_bulk_delete_task_container">
                        <a href="javascript:void(0)" class="wpf_bulk_task_delete_btn">
                            <i class="gg-trash"></i> <?php _e('Delete ticket','wpfeedback'); ?>
                        </a>
                        <p class="wpf_hide" id="wpf_bulk_task_delete">Are you sure you want to delete? <a href="javascript:void(0);" class="wpf_bulk_task_delete">Yes</a></p>
                    </div>
                    <input type="button" value="<?php _e('Save Bulk Changes','wpfeedback'); ?>" class="wpf_button" onclick="wpf_bulk_update()">
                </div>
            </div>
        </div>
    </div>

    <!-- ================= SETTINGS PAGE ================-->
    <?php if($wpf_user_type == 'advisor' || ($wpf_user_type == '' && current_user_can('administrator') ) ){ ?>
        <div id="wpf_settings" class="wpf_container" style="display:none">
            <div class="wpf_loader_admin hidden"></div>
            <div id="wpf_global_settings_overlay" <?php if(get_option('wpf_global_settings')!='yes'){ echo "class='wpf_hide'"; }?>>
                <div class="wpf_welcome_wrap"><div class="wpf_welcome_title">Global Settings</div>
                    <p>We are pulling your settings from the Global Settings area within your central dashboard.</p>
                    <div class="wpf_golbalsettings_buttons">
                        <div class="wpf_settings_icon">Local <i class="gg-database"></i></div>
                        <label class="wpf_switch">
                            <input type="checkbox" name="wpf_global_settings" class="wpf_global_settings" <?php if(get_option('wpf_global_settings')=='yes'){ echo "checked"; }?> >
                            <span class="wpf_switch_slider wpf_switch_round"></span>
                        </label>
						<div class="wpf_settings_icon"><i class="gg-cloud"></i> Dashboard</div>
                    </div><p><a href="https://app.wpfeedback.co/settings" target="_blank">Edit your global settings</a></p>
					<div class="wpf_welcome_image"><img alt="" src="<?php echo esc_url(WPF_PLUGIN_URL.'images/global-settings.png'); ?>"/></div>
                    <?php
                    $wpf_license = get_option('wpf_license');
                    $wpf_disable_for_app = get_option('wpf_disable_for_app');
                    if(WPF_EDD_SL_STORE_URL == 'https://wpfeedback.co/' && $wpf_license == 'valid' && $wpf_disable_for_app !='yes'){ ?>
                        <div class="wpf_resync_dashboard">
                            <div class="wpf_title">
                                <input type="button" value="<?php _e('Resync dashboard', 'wpfeedback'); ?>"
                                       class="wpf_button" onclick="wpf_resync_dashboard()"/>
                                <?php if(isset($_GET['resync_dashboard']) && $_GET['resync_dashboard'] == 1){ ?>
                                    <span class="wpf_resync_dashboard_msg" style="color: green; font-size: 12px;"><?php _e('The website should now be resynced/added to the dashboard. Please contact support in case they are not.','wpfeedback') ?></span>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="wpf_section_title"><?php _e('Main Settings', 'wpfeedback'); ?>
                <div class="wpf_report_buttons">
                    <div class="wpf_settings_icon">Local <i class="gg-database"></i></div>
                    <label class="wpf_switch">
                        <input type="checkbox" name="wpf_global_settings" class="wpf_global_settings" <?php if(get_option('wpf_global_settings')=='yes'){ echo "checked"; }?> >
                        <span class="wpf_switch_slider wpf_switch_round"></span>
                    </label>
                    <div class="wpf_settings_icon"><i class="gg-cloud"></i> Dashboard</div>
                </div>
            </div>
            <p id="wpf_global_erro_msg" class="wpf_hide" style="color: red;"><?php _e("There seems to be some issue with enabling the global settings. Please contact support for help.","wpfeedabck"); ?></p>
            <form method="post" action="admin-post.php" >
                <div class="wpf_settings_ctt_wrap">
                    <div class="wpf_settings_col">
                        <div class="wpf_title_section"><?php _e('General Settings', 'wpfeedback'); ?></div>
						<p><?php _e('On this screen, you can manage different settings of the plugin. You can white label it to match your own branding, control which notifications are sent out to the users of this WordPress website and a few other options below this text.','wpfeedback'); ?></p>
                        <p><b><?php _e('You can also control the permissions of WP FeedBack PRO :', 'wpfeedback'); ?></b><?php _e(' you can allow or disallow users to use certain functions, you can even turn on guest mode to allow any visitor to the website to use the tool without needing to long.' , 'wpfeedback'); ?><a href="admin.php?page=wpfeedback_page_permissions"><?php _e('To find these settings, go here.', 'wpfeedback'); ?></a><?php _e('You will also see your license settings on this page.', 'wpfeedback'); ?><br><br></p>
                        <div class="enabled_wpfeedback">
                            <div class="wpf_title_secondery">
                                <input type="checkbox" name="enabled_wpfeedback" value="yes"
                                       id="enabled_wpfeedback" <?php if (get_option('wpf_enabled') == 'yes') {
                                    echo 'checked';} ?>/> <label for="enabled_wpfeedback"><?php _e('Enable WP FeedBack PRO on this website', 'wpfeedback'); ?></label> <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="<?php _e('This is used to disable the plugin on this website, to save you the trouble of having to deactivate it in your plugin settings.', 'wpfeedback'); ?>"><i class="gg-info"></i></a>
                            </div>
                        </div>
                        <div class="wpf_show_front_stikers">
                            <div class="wpf_title_secondery">
                                <input type="checkbox" name="wpf_show_front_stikers" value="yes"
                                       id="wpf_show_front_stikers" <?php if (get_option('wpf_show_front_stikers') == 'yes') {
                                    echo 'checked';
                                } ?>/>
                                <label for="wpf_show_front_stikers"><?php _e('Show task stickers by default', 'wpfeedback'); ?></label> <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="<?php _e('If this is switched off, you will not see stickers unless you open the sidebar while on the front-end', 'wpfeedback'); ?>"><i class="gg-info"></i></a>
                            </div>
                        </div>

                        <div class="wpf_allow_backend_commenting">
                            <div class="wpf_title_secondery">
                                <input type="checkbox" name="wpf_allow_backend_commenting" value="yes"
                                       id="wpf_allow_backend_commenting" <?php if (get_option('wpf_allow_backend_commenting') == 'yes') {
                                    echo 'checked';
                                } ?>/>
                                <label for="wpf_allow_backend_commenting"><?php _e('Remove backend commenting', 'wpfeedback'); ?></label> <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="<?php _e('By default you can create tasks on the front end AND on the back end. By ticking this option on, users will not be able to create tasks on any of the WP admin screens.', 'wpfeedback'); ?>"><i class="gg-info"></i></i></a>
                            </div>
                        </div>

                        <!--<div class="wpfeedback_font_awesome_script">
                            <div class="wpf_title_secondery">
                                <input type="checkbox" name="wpfeedback_font_awesome_script" value="yes"
                                       id="wpfeedback_font_awesome_script" <?php /*if (get_option('wpf_font_awesome_script') == 'yes') {
                                    echo 'checked';
                                } */?>/>
                                <label for="wpfeedback_font_awesome_script"><?php /*_e('Remove Font-Awesome Script', 'wpfeedback'); */?></label> <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="<?php /*_e("ONLY if you already have the script running on all pages of the site. ", 'wpfeedback'); _e('If Font-Awesome is already integrated on this website, you might notice some icons not showing correctly. Ticking this removes WP FeedBack’s integration to avoid this conflict.', 'wpfeedback'); */?>"><i class="gg-info"></i></a>
                            </div>
                             <span><?php /*_e("ONLY if you already have the script running on all pages of the site ", 'wpfeedback'); */?></span>
                        </div>-->

                        <div class="delete_data_wpfeedback">
                            <div class="wpf_title_secondery">
                                <input type="checkbox" name="delete_data_wpfeedback" value="yes"
                                       id="delete_data_wpfeedback" <?php if (get_option('wpf_delete_data') == 'yes') {
                                    echo 'checked';
                                } ?>/>
                                <label for="delete_data_wpfeedback"><?php _e('Remove the data when removing the plugin', 'wpfeedback'); ?></label> <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="<?php _e(' If this is checked on (not recommended), all the tasks and comments will be deleted from the database once the plugin is deactivated and deleted.', 'wpfeedback'); ?>"><i class="gg-info"></i></a>
                            </div>
                        </div>
                        <?php
                            $wpf_license = get_option('wpf_license');
                            $wpf_disable_for_app = get_option('wpf_disable_for_app');
                            if(WPF_EDD_SL_STORE_URL == 'https://wpfeedback.co/' && $wpf_license == 'valid' && $wpf_disable_for_app != 'yes'){ ?>
                                <div class="wpf_resync_dashboard">
                                    <div class="wpf_title">
                                        <input type="button" value="<?php _e('Resync the Central Dashboard', 'wpfeedback'); ?>"
                                               class="wpf_button" onclick="wpf_resync_dashboard()"/>
                                               <?php if(isset($_GET['resync_dashboard']) && $_GET['resync_dashboard'] == 1){ ?>
                                               <span class="wpf_resync_dashboard_msg" style="color: green; font-size: 12px;"><?php _e('Websites should now be resync / added now to the dashboard. Please contact support in case if does not.','wpfeedback') ?></span>
                                           <?php } ?>
                                    </div>
                                </div>
                        <?php } ?>
                        
						<img class="wpf_settings_image" src="<?php echo WPF_PLUGIN_URL.'images/wpfsettings.png'; ?>"/>
                    </div>
                    <div class="wpf_settings_col"><div class="wpf_title_section"><?php _e('White Label', 'wpfeedback'); ?></div>
						<p><?php _e('Here you can rebrand WP FeedBack PRO by changing the main color and the logo.','wpfeedback'); ?><br />
                        <?php _e('You can ', 'wpfeedback'); ?><strong><?php _e('manage Global Settings across all of your websites', 'wpfeedback'); ?></strong> <?php _e('where your license is activated by visiting the general settings screen on your', 'wpfeedback'); ?> <a href="https://app.wpfeedback.co" target="_blank"><?php _e('Central Dashboard', 'wpfeedback'); ?></a>.</p><div class="wpfeedback_replace_logo">
                            <div class="wpf_title"><?php _e('Replace the WP FeedBack logo', 'wpfeedback'); ?> <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="<?php _e('This will replace the logo in the top right of this page and the logo on the notification emails that are sent out.', 'wpfeedback'); ?>"><i class="gg-info"></i></a></div>
                            <span><?php _e('The image should be 180x45 px.', 'wpfeedback'); ?></span>
                            <?php wp_enqueue_media(); ?>
                            <input id="upload_image_button" type="button" class="button"
                                   value="<?php _e('Upload Image','wpfeedback'); ?>"/>
                            <input type='hidden' name='wpfeedback_logo' id='image_attachment_id'
                                   value='<?php echo get_option('wpf_logo'); ?>'>
                            <div class='wpfeedback_image-preview-wrapper'>
                                <img id='wpfeedback_image-preview' src='<?php echo get_wpf_logo(); ?>' height='100'>
                            </div>
                        </div>
                        <div class="wpfeedback_more_emails">
                            <div class="wpf_title"><?php _e('Change the logo link', 'wpfeedback'); ?> <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="<?php _e('This will replace the &quot;Powered by WP FeedBack&quot; link to your own.', 'wpfeedback'); ?>"><i class="gg-info"></i></a></div><span><?php _e('This is great for upselling your clients or making them aware of additional services that you can provide.', 'wpfeedback'); ?></span>
                            <input type="text" name="wpf_powered_link" value="<?php echo get_option('wpf_powered_link'); ?>" class="" />
                        </div>
                        <div class="wpfeedback_main_color">
                            <div class="wpf_title"><?php _e('Change the main color', 'wpfeedback'); ?> <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="<?php _e('Where ever you see the blue, this option will change it to whatever colour you want!', 'wpfeedback'); ?>"><i class="gg-info"></i></a></div><span><?php _e('Replace the WP FeedBack  PRO blue with your own brand color.', 'wpfeedback'); ?></span>
                            <input type="text" name="wpfeedback_color" value="<?php echo get_option('wpf_color'); ?>"
                            class="jscolor" id="wpfeedback_color"/>
                        </div>
                        <div class="wpfeedback_youtube_url">
                            <div class="wpf_title"><?php _e('Change the tutorial video', 'wpfeedback'); ?> <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="<?php _e('The video will be replaced on the frontend wizard as well as tasks screen on backend when empty.', 'wpfeedback'); ?>"><i class="gg-info"></i></a></div><span><?php _e('Replace the WP FeedBack PRO video with your own tutorial video.', 'wpfeedback'); ?></span>
<!--                            <input type="text" name="wpf_tutorial_video" value="" id="wpfeedback_youtube_url" />-->
                            <textarea name="wpf_tutorial_video" id="wpf_tutorial_video"><?php echo get_option('wpf_tutorial_video'); ?></textarea>
                        </div>
                        <div class="wpfeedback_powered_by">
                            <div class="wpf_title">
                                <input type="checkbox" name="wpfeedback_powered_by" value="yes"
                                       id="wpfeedback_powered_by" <?php if (get_option('wpf_powered_by') == 'yes') {
                                    echo 'checked';
                                } ?>/>
                                <label for="wpfeedback_powered_by"><?php _e('Remove mention of "WP FeedBack" from the plugin', 'wpfeedback'); ?></label> <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="<?php _e('Tick this setting to remove the name WP FeedBack. Add your own logo and change the logo link to ensure that the plugin is white labelled entirely.', 'wpfeedback'); ?>"><i class="gg-info"></i></a>
                            </div>
                        </div>
                        <div class="wpfeedback_reset_setting">
                            <div class="wpf_title">
                                <input type="button" value="<?php _e('Reset White Label Settings', 'wpfeedback'); ?>"
                                       class="wpf_button" onclick="wpfeedback_reset_setting()"/>
                            </div>
                        </div>

                    </div>
                    <div class="wpf_settings_col">
                        <input type="hidden" name="action" value="save_wpfeedback_options"/>
                        <?php wp_nonce_field('wpfeedback'); ?>
                        <div class="wpf_title_section"><?php _e('Notifications Settings', 'wpfeedback'); ?></div>
                        <div class="wpfeedback_more_emails">
                            <?php
                            $wpf_from_email = get_option('wpf_from_email');
                            if($wpf_from_email==''){
                                $wpf_from_email = get_option('admin_email');
                            }
                            ?>
                            <div class="wpf_title"><?php _e('Sent from email address', 'wpfeedback'); ?></div><span><?php _e('Set a "From" email address to send all notifications.', 'wpfeedback'); ?></span><br>
                            <input type="text" name="wpf_from_email"
                                      value="<?php echo $wpf_from_email; ?>"/>
                        </div>
                        <div class="wpfeedback_more_emails">
                            <div class="wpf_title"><?php _e('Send email notifications to the following address', 'wpfeedback'); ?></div>
                            <span><?php _e('This option is in addition to the user emails. Seperate with comma for multiple addresses.', 'wpfeedback'); ?></span><br>
                            <input type="text" name="wpfeedback_more_emails"
                                      value="<?php echo get_option('wpf_more_emails'); ?>"/>
                        </div>
                        <div class="wpfeedback_email_notifications">
                            <div class="wpf_title"><?php _e('Email notifications', 'wpfeedback'); ?></div>
                                <p><?php _e('Ticking these on will display <b>them as an option on the front-end wizard for users to choose</b>. For example, if you don\'t want users to choose the option to send 24 hour reports, tick that off and it will not display on the front-end wizard.', 'wpfeedback'); ?></p>
                                <p><?php _e('If a user <b>does not</b> choose to receive any notifications and you\'d like to change that, go to their user profile in the WordPress Admin and they can be ticked on there, you can view more info on notifications here <a href="https://wpfeedback.co/knowledge-base/faq/task-notifications/" target="_blank">here</a>.', 'wpfeedback'); ?></p>
                            <div class="wpf_checkbox">
                                <input type="checkbox" name="wpf_every_new_task" value="yes"
                                       id="wpf_every_new_task" <?php if (get_option('wpf_every_new_task') == 'yes') {
                                    echo 'checked';
                                } ?>/>
                                <label for="wpf_every_new_task"><?php _e('Send email notification for every new task', 'wpfeedback'); ?></label> <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="<?php _e('Allow users to choose this setting on the front-end wizard and inside their WordPress Profile.', 'wpfeedback'); ?>"><i class="gg-info"></i></a>
                            </div>
                            <div class="wpf_checkbox">
                                <input type="checkbox" name="wpf_every_new_comment" value="yes"
                                       id="wpf_every_new_comment" <?php if (get_option('wpf_every_new_comment') == 'yes') {
                                    echo 'checked';
                                } ?>/>
                                <label for="wpf_every_new_comment"><?php _e('Send email notification for every new comment', 'wpfeedback'); ?></label> <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="<?php _e('Allow users to choose this setting on the front-end wizard and inside their WordPress Profile.', 'wpfeedback'); ?>"><i class="gg-info"></i></a>
                            </div>
                            <div class="wpf_checkbox">
                                <input type="checkbox" name="wpf_every_new_complete" value="yes"
                                       id="wpf_every_new_complete" <?php if (get_option('wpf_every_new_complete') == 'yes') {
                                    echo 'checked';
                                } ?>/>
                                <label for="wpf_every_new_complete"><?php _e('Send email notification when a task is marked as complete', 'wpfeedback'); ?></label> <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="<?php _e('Allow users to choose this setting on the front-end wizard and inside their WordPress Profile.', 'wpfeedback'); ?>"><i class="gg-info"></i></a>
                            </div>
                            <div class="wpf_checkbox">
                                <input type="checkbox" name="wpf_every_status_change" value="yes"
                                       id="wpf_every_status_change" <?php if (get_option('wpf_every_status_change') == 'yes') {
                                    echo 'checked';
                                } ?>/>
                                <label for="wpf_every_status_change"><?php _e('Send email notification for every status change', 'wpfeedback'); ?></label> <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="<?php _e('Allow users to choose this setting on the front-end wizard and inside their WordPress Profile.', 'wpfeedback'); ?>"><i class="gg-info"></i></a>
                            </div>
                            <div class="wpf_checkbox">
                                <input type="checkbox" name="wpf_daily_report" value="yes"
                                       id="wpf_daily_report" <?php if (get_option('wpf_daily_report') == 'yes') {
                                    echo 'checked';
                                } ?>/>
                                <label for="wpf_daily_report"><?php _e('Send email notification for last 24 hours report', 'wpfeedback'); ?></label>
                            </div>
                            <div class="wpf_checkbox">
                                <input type="checkbox" name="wpf_weekly_report" value="yes"
                                       id="wpf_weekly_report" <?php if (get_option('wpf_weekly_report') == 'yes') {
                                    echo 'checked';
                                } ?>/>
                                <label for="wpf_weekly_report"><?php _e('Send email notification for last 7 days report', 'wpfeedback'); ?></label>
                            </div>
                            <div class="wpf_checkbox">
                                <input type="checkbox" name="wpf_auto_daily_report" value="yes"
                                       id="wpf_auto_daily_report" <?php if (get_option('wpf_auto_daily_report') == 'yes') {
                                    echo 'checked';
                                } ?>/>
                                <label for="wpf_auto_daily_report"><?php _e('Auto send email notification for daily report', 'wpfeedback'); ?></label> <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="<?php _e('Allow users to choose this setting on the front-end wizard and inside their WordPress Profile.', 'wpfeedback'); ?>"><i class="gg-info"></i></a>
                            </div>
                            <div class="wpf_checkbox">
                                <input type="checkbox" name="wpf_auto_weekly_report" value="yes"
                                       id="wpf_auto_weekly_report" <?php if (get_option('wpf_auto_weekly_report') == 'yes') {
                                    echo 'checked';
                                } ?>/>
                                <label for="wpf_auto_weekly_report"><?php _e('Auto send email notification for weekly report', 'wpfeedback'); ?></label> <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="<?php _e('Allow users to choose this setting on the front-end wizard and inside their WordPress Profile.', 'wpfeedback'); ?>"><i class="gg-info"></i></a>
                            </div>
                            <br>
                        </div>


                        <?php
                        $wpfb_users_json = do_shortcode('[wpf_user_list_front]');
                        $wpfb_users = json_decode($wpfb_users_json);
                        $wpf_website_client = get_option('wpf_website_client');
                        $wpf_website_developer = get_option('wpf_website_developer');
                        ?>
                        <input type="submit" value="<?php _e('Save Changes', 'wpfeedback'); ?>" class="wpf_button"
                               id="wpf_save_setting"/>
                    </div>
                </div>
            </form>
        </div>
    <?php } ?>
    <!-- ================= ADD-ONS PAGE ================-->
    <?php if($wpf_user_type == 'advisor' || $wpf_user_type == 'king' || ($wpf_user_type == '' && current_user_can('administrator') ) ){ ?>
        <div id="wpf_addons" class="wpf_container" style="display:none">
            <div class="wpf_section_title"><?php _e('Zapier Integration', 'wpfeedback'); ?></div>
            <div class="wpf_inner_container">
                <a href="https://wpfeedback.co/knowledge-base/faq/integrate-wp-feedback-to-1500-apps-via-zapier/"
                   target="_blank"><img alt="WP FeedBack PRO and Zapier" class="wpf_integration_image" src="<?php echo WPF_PLUGIN_URL.'images/integrations-image.png'; ?>"/></a>
            </div>
        </div>
    <?php }?>
    <!-- ================= SUPPORT PAGE ================-->
    <?php if($wpf_user_type == 'advisor' || ($wpf_user_type == '' && current_user_can('administrator') ) ){ ?>
    <div id="wpf_support" class="wpf_container">
        <div class="wpf_section_title"><?php _e('Support From WP FeedBack PRO', 'wpfeedback'); ?></div>
        <div id="wpf_user_support_container" class="">
            <div class="wpf_loader_admin wpf_hide"></div>
            <div class="wpf_support_col_left">
                <div class="wpf_facebook_group">
                    <div class="wpf_fb_icon"><i class="gg-heart"></i></div>
                    <div class="wpf_fb_text">
                        <div class="wpf_title"><a href="https://wpfeedback.co/facebook" target="_blank"><?php _e('Join the tribe on Facebook', 'wpfeedback'); ?></a></div>
                        <p>
                            <?php _e('Get faster answers by leveraging the community, we\'re there too of course!', 'wpfeedback'); ?>
                        </p></div>
                </div>
                <div class="wpf_title"><?php _e('Video walkthrough', 'wpfeedback'); ?></div>
                <p class="wpf_walk_video">
                    <script src="https://fast.wistia.com/embed/medias/po8gy5uygu.jsonp" async></script>
                    <script src="https://fast.wistia.com/assets/external/E-v1.js" async></script>
                <div class="wistia_responsive_padding" style="padding:50.63% 0 0 0;position:relative;">
                    <div class="wistia_responsive_wrapper"
                         style="height:100%;left:0;position:absolute;top:0;width:100%;">
                        <div class="wistia_embed wistia_async_po8gy5uygu videoFoam=true"
                             style="height:100%;position:relative;width:100%">
                            <div class="wistia_swatch"
                                 style="height:100%;left:0;opacity:0;overflow:hidden;position:absolute;top:0;transition:opacity 200ms;width:100%;">
                                <img src="https://fast.wistia.com/embed/medias/po8gy5uygu/swatch"
                                     style="filter:blur(5px);height:100%;object-fit:contain;width:100%;" alt=""
                                     onload="this.parentNode.style.opacity=1;"/></div>
                        </div>
                    </div>
                </div>
                </p>
                <div class="wpf_title"><?php _e('These should help', 'wpfeedback'); ?></div>
                <ul dir="ltr">
                    <li><strong><a href="https://wpfeedback.co/knowledge-base/faq/installation/" target="_blank"><?php _e('Licenses and domains', 'wpfeedback'); ?></a></strong><br/>
                        <?php _e('Can&#39;t validate the license? You probably didn&#39;t add the domain. Follow the steps above.', 'wpfeedback'); ?>
                    </li>
                    <li>
                        <strong><a href="https://wpfeedback.co/knowledge-base/faq/integrate-wp-feedback-to-1500-apps-via-zapier/"
                                   target="_blank"><?php _e('Zapier Integration', 'wpfeedback'); ?></a></strong><br/>
                        <?php _e('Step by step guide to integrating WP FeedBack PRO to 1500+ apps - Connect your workflow.', 'wpfeedback'); ?>
                    </li>
                    <li><strong><a href="https://wpfeedback.co/knowledge-base/faq/task-notifications/" target="_blank"><?php _e('Notifications
                                issues', 'wpfeedback'); ?></a>&nbsp;</strong><br/>
                        <?php _e('Can&#39;t send emails? Getting too many emails? Answers inside.', 'wpfeedback'); ?>
                    </li>
                    <li><strong><a href="https://wpfeedback.co/partner-with-us/" target="_blank"><?php _e('Partner with us', 'wpfeedback'); ?></a>&nbsp;</strong><br/>
                        <?php _e('If you&#39;re talking about us and send some peeps over - We wanna pay you!', 'wpfeedback'); ?>
                    </li>
                    <li><a href="https://wpfeedback.co/roadmap" target="_blank"><strong><?php _e('Public Roadmap', 'wpfeedback'); ?></strong></a><br/>
                        <?php _e('If we&#39;re advocating for feedback we better lead by example. You&#39;re invited to request&nbsp;features.', 'wpfeedback'); ?>
                    </li>
                    <li><strong><a href="https://wpandup.org/" target="_blank"><?php _e('Feeling stressed? (WP&amp;UP)', 'wpfeedback'); ?></a></strong><br/>
                        <?php _e('Dealing with clients is hard(!) This amazing charity for the WP community is here to help you grow and relax.', 'wpfeedback'); ?>
                    </li>
                </ul>
            </div>
            <div class="wpf_support_col_right">
                <div class="wpf_title"><?php _e('Create a support ticket', 'wpfeedback'); ?></div>
                <p><b><?php _e('We will reply via email in up to 24 hours (Weekdays)', 'wpfeedback'); ?></b><br><?php _e('Support will only be given in English', 'wpfeedback'); ?></p>
                <form name="wpf_user_support" id="wpf_user_support">
                    <p>
                        <?php _e('We collected your name, email, license key and domain so all you need to do, is tell us what\'s
                        up.', 'wpfeedback'); ?>
                    </p>
                    
                    <div class="wpf_field_label"><b><?php _e('Subject', 'wpfeedback'); ?></b></div>
                    <div class="wpf_field_input"><input type="text" name="wpf_support_subject" id="wpf_support_subject">
                    </div>
                    <div class="wpf_field_label"><b><?php _e('Message', 'wpfeedback'); ?></b></div>
                    <div class="wpf_field_input"><textarea name="wpf_support_message" id="wpf_support_message"></textarea></div>

                    <div class="wpf_support_name_email">
                        <div class="wpf_support_name">
                            <div class="wpf_field_label"><b><?php _e('Name', 'wpfeedback'); ?></b></div>
                            <div class="wpf_field_input"><input type="text" name="wpf_support_name" id="wpf_support_name" value="<?php  echo $wpf_user_name; ?>">
                            </div>
                        </div>
                        <div class="wpf_support_email">
                            <div class="wpf_field_label"><b><?php _e('Email', 'wpfeedback'); ?></b></div>
                            <div class="wpf_field_input"><input type="text" name="wpf_support_email" id="wpf_support_email" value="<?php  echo $wpf_user_email; ?>">
                            </div>
                        </div>
                    </div>

                    <?php
                    global $wp_version;
                    if ($wp_version >= 5.2) {
                        ?>
                        <div class="wpf_field_label"><b><?php _e('Insert Site Health Info', 'wpfeedback'); ?></b> <?php _e('(WP 5.2 and up)', 'wpfeedback'); ?></div>
                        <div class="wpf_field_input"><textarea name="wpf_support_site_health_info"
                                                               id="wpf_support_site_health_info"></textarea></div>
                        <span class="wpf_health_check"><a
                                    href="<?php echo admin_url() . 'site-health.php?tab=debug'; ?>" target="_blank"><?php _e('Click here to get site health info', 'wpfeedback'); ?></a></span>

                        <?php
                    }
                    ?>
                    <input type="button" class="wpf_button" name="wpf_support_submit" id="wpf_support_submit"
                           value="<?php _e('Request Support', 'wpfeedback'); ?>">
                    <span class="wpf_error wpf_hide" id="wpf_support_submit_error"><?php _e('Sorry! Your message was not sent, please try after some time.', 'wpfeedback'); ?></span>
                    <span class="wpf_support_sent wpf_hide" id="wpf_support_sent"><?php _e('Your message was sent to the WP FeedBack PRO Team. Thanks for contacting us. We will reply to this email address shortly:', 'wpfeedback'); ?> <?php echo $current_user->user_email; ?></span>
                </form>
            </div>
        </div>
    </div>
<?php } ?>