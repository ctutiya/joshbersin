/* global tippy */
(function ($) {

})(jQuery);

jQuery_WPF(document).ready(function () {
    jQuery_WPF("ul#all_wpf_list li.wpf_list a").first().trigger('click');
    jQuery_WPF("ul#all_wpf_list li.wpf_list a").first().parent().addClass('active');

    /*STEP 1 BUTTON*/
    jQuery_WPF('#wpf_initial_setup_first_step_button').on('click',function (e) {
        if(jQuery_WPF('input[name="wpfeedback_licence_key"]').val()==''){
            jQuery_WPF('input[name="wpfeedback_licence_key"]').attr('style','border:1px solid red;');
            return false;
        }
        jQuery_WPF.ajax({
            url:ajaxurl,
            method: 'POST',
            data:{action: 'wpf_license_verify_and_store',wpf_nonce:wpf_nonce,wpf_license_key:jQuery_WPF('input[name="wpfeedback_licence_key"]').val()},
            beforeSend: function(){
                jQuery_WPF('.wpf_loader_admin').show();
            },
            success: function (data) {
                jQuery_WPF('.wpf_loader_admin').hide();
                if(data==1){
                    jQuery_WPF('#wpf_initial_settings_first_step').hide();
                    jQuery_WPF('#wpf_initial_settings_second_step').show();
                    jQuery_WPF('#wpf_license_key_valid').show();
                    jQuery_WPF('#wpf_license_key_invalid').hide();
                }
                else{
                    jQuery_WPF('#wpf_license_validation_error').show();
                    jQuery_WPF('#wpf_license_key_invalid').show();
                    jQuery_WPF('#wpf_license_key_valid').hide();
                }
            }
        });
       return false;
    });

    /*STEP 2 BUTTONS*/
    jQuery_WPF('#wpf_initial_setup_second_step_button').on('click',function (e) {
        var task_notify_roles = [];
        jQuery_WPF.each(jQuery_WPF('input[name=roles_list]:checked'), function(){
            task_notify_roles.push(jQuery_WPF(this).val());
        });
        task_notify_roles =task_notify_roles.join(",");
        var wpf_allow_guest = jQuery_WPF('#wpf_allow_guest:checkbox:checked').length;
        jQuery_WPF.ajax({
            url:ajaxurl,
            method: 'POST',
            data:{action: 'wpf_update_roles',wpf_nonce:wpf_nonce,task_notify_roles:task_notify_roles,wpf_allow_guest:wpf_allow_guest},
            beforeSend: function(){
                jQuery_WPF('.wpf_loader_admin').show();
            },
            success: function (data) {
                jQuery_WPF('.wpf_loader_admin').hide();
                if(data==1){
                    if(jQuery_WPF('.wpf_global_settings').is(':checked')){
                        jQuery_WPF('#wpf_initial_settings_second_step').hide();
                        jQuery_WPF('#wpf_initial_settings_fourth_step').show();
                    }else{
                        jQuery_WPF('#wpf_initial_settings_second_step').hide();
                        jQuery_WPF('#wpf_initial_settings_third_step').show();
                    }
                }
            }
        });
        return false;
    });
    jQuery_WPF('#wpf_initial_setup_second_step_prev_button').on('click',function (e) {
        jQuery_WPF('#wpf_initial_settings_first_step').show();
        jQuery_WPF('#wpf_initial_settings_second_step').hide();
        return false;
    });

    /*STEP 3 BUTTONS*/
    jQuery_WPF('#wpf_initial_setup_third_step_button').on('click',function (e) {
        var wpf_every_new_task = jQuery_WPF('#wpf_every_new_task:checkbox:checked').length;
        var wpf_every_new_comment = jQuery_WPF('#wpf_every_new_comment:checkbox:checked').length;
        var wpf_every_new_complete = jQuery_WPF('#wpf_every_new_complete:checkbox:checked').length;
        var wpf_every_status_change = jQuery_WPF('#wpf_every_status_change:checkbox:checked').length;
        var wpf_daily_report = jQuery_WPF('#wpf_daily_report:checkbox:checked').length;
        var wpf_weekly_report = jQuery_WPF('#wpf_weekly_report:checkbox:checked').length;
        var wpf_auto_daily_report = jQuery_WPF('#wpf_auto_daily_report:checkbox:checked').length;
        var wpf_auto_weekly_report = jQuery_WPF('#wpf_auto_weekly_report:checkbox:checked').length;
        
        jQuery_WPF.ajax({
            url:ajaxurl,
            method: 'POST',
            data:{action: 'wpf_update_notifications',wpf_nonce:wpf_nonce,wpf_every_new_task:wpf_every_new_task,wpf_every_new_comment:wpf_every_new_comment,wpf_every_new_complete:wpf_every_new_complete,wpf_every_status_change:wpf_every_status_change,wpf_daily_report:wpf_daily_report,wpf_weekly_report:wpf_weekly_report,wpf_auto_daily_report:wpf_auto_daily_report,wpf_auto_weekly_report:wpf_auto_weekly_report},
            beforeSend: function(){
                jQuery_WPF('.wpf_loader_admin').show();
            },
            success: function (data) {
                jQuery_WPF('.wpf_loader_admin').hide();
                if(data==1){
                    jQuery_WPF('#wpf_initial_settings_third_step').hide();
                    jQuery_WPF('#wpf_initial_settings_fourth_step').show();
                }
            }
        });
        return false;
    });
    jQuery_WPF('#wpf_initial_setup_third_step_prev_button').on('click',function (e) {
        jQuery_WPF('#wpf_initial_settings_second_step').show();
        jQuery_WPF('#wpf_initial_settings_third_step').hide();
        return false;
    });
    jQuery_WPF(document).find("#wpf_delete_task_container").on("click",".wpf_task_delete",function(e){
        var elemid = jQuery_WPF(this).data('elemid');
        var task_id = jQuery_WPF(this).data('taskid');
        wpf_admin_delete_task(elemid,task_id);
    });

    jQuery_WPF('#wpf_support_submit').on('click',function () {
        var errors = false;
        var wpf_support_subject = jQuery_WPF('#wpf_support_subject').val();
        var wpf_support_name = jQuery_WPF('#wpf_support_name').val();
        var wpf_support_email = jQuery_WPF('#wpf_support_email').val();
        var wpf_support_message = jQuery_WPF('#wpf_support_message').val();
        var wpf_support_site_health_info = jQuery_WPF('#wpf_support_site_health_info').val();
        if(wpf_support_subject==''){
            errors = true;
            jQuery_WPF('#wpf_support_subject').css('border-color', 'red');
        }
        if(wpf_support_name==''){
            errors = true;
            jQuery_WPF('#wpf_support_name').css('border-color', 'red');
        }
        if(wpf_support_email==''){
            errors = true;
            jQuery_WPF('#wpf_support_email').css('border-color', 'red');
        }
        if(wpf_support_message==''){
            errors = true;
            jQuery_WPF('#wpf_support_message').css('border-color', 'red');
        }
        if(errors==true){
            return false;
        }
        jQuery_WPF.ajax({
            url:ajaxurl,
            method: 'POST',
            data:{action: 'wpf_user_support',wpf_nonce:wpf_nonce,wpf_support_name:wpf_support_name,wpf_support_email:wpf_support_email,wpf_support_subject:wpf_support_subject,wpf_support_message:wpf_support_message,wpf_support_site_health_info:wpf_support_site_health_info},
            beforeSend: function(){
                jQuery_WPF('.wpf_loader_admin').show();
            },
            success: function (data) {
                jQuery_WPF('.wpf_loader_admin').hide();
                if(data==1){
                    jQuery_WPF('#wpf_user_support'). trigger("reset");
                    jQuery_WPF('#wpf_support_sent').show();
                }
                else{
                    jQuery_WPF('#wpf_support_submit_error').show();
                }

            }
        });
    });

    jQuery_WPF('#wpf_support_subject').on('change',function () {
        jQuery_WPF(this).css('border-color', '');
    });

    jQuery_WPF('#wpf_support_message').on('change',function () {
        jQuery_WPF(this).css('border-color', '');
    });

    jQuery_WPF(document).find("#wpf_attributes_content").on("click",".wpf_task_delete_btn",function(e) {
        jQuery_WPF('#wpf_task_delete').show();
    });

    jQuery_WPF('.wpf_global_settings').change(function () {
        var checked = this.checked;
        var wpf_global_settings = 'no';
        if(this.checked){
            wpf_global_settings = 'yes';
        }
        jQuery_WPF.ajax({
            url:ajaxurl,
            method: 'POST',
            data:{action: 'wpf_global_settings',wpf_nonce:wpf_nonce,wpf_global_settings:wpf_global_settings},
            beforeSend: function(){
                jQuery_WPF('.wpf_loader_admin').show();
            },
            success: function (data) {
                jQuery_WPF('.wpf_loader_admin').hide();
                if(data==1){
                    jQuery_WPF('#wpf_global_settings_overlay').show();
                    jQuery_WPF('#wpf_global_settings_overlay .wpf_global_settings').attr("checked", "checked");
                     jQuery_WPF('wpf_global_erro_msg').hide();
                }else if(data==3){
                    jQuery_WPF('#wpf_global_erro_msg').show();
                    jQuery_WPF('.wpf_global_settings').removeAttr('checked');
                }
                else{
                    jQuery_WPF('wpf_global_erro_msg').hide();
                    jQuery_WPF('#wpf_global_settings_overlay').hide();
                    jQuery_WPF('.wpf_global_settings').removeAttr('checked');
                }
            }
        });

    });
});

function wpf_initial_setup_done(site_url) {
    jQuery_WPF.ajax({
        url:ajaxurl,
        method: 'POST',
        data:{action: 'wpf_initial_setup_done',wpf_nonce:wpf_nonce},
        beforeSend: function(){
            jQuery_WPF('.wpf_loader_admin').show();
        },
        success: function (data) {
            jQuery_WPF('.wpf_loader_admin').hide();
            if(data==1){
                console.log(site_url);
                window.location=site_url;
            }
        }
    });
}

function openWPFTab(wpfTab) {
    var i;
    var x = document.getElementsByClassName("wpf_container");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    document.getElementById(wpfTab).style.display = "block";
}

/*Showing active tab*/
var btnContainer = document.getElementById("wpf_tabs_container");
if(btnContainer!=null){
    var btns = btnContainer.getElementsByClassName("wpf_tab_item");
    for (var i = 0; i < btns.length; i++) {
        btns[i].addEventListener("click", function () {
            var current = document.getElementsByClassName("active");
            current[0].className = current[0].className.replace(" active", "");
            this.className += " active";
        });
    }
}

/*Reset Setting*/
function wpfeedback_reset_setting() {
    jQuery_WPF.ajax({
        method: "POST",
        url: ajaxurl,
        data: {action: "wpfeedback_reset_setting",wpf_nonce:wpf_nonce},
        success: function (data) {
            if (data == 1) {
                location.reload();
            }
        }
    });
}

function wpf_admin_delete_task(id,task_id){
    var task_info = [];
    task_info['task_id'] = task_id;
    task_info['task_no']=id;
    var task_info_obj = jQuery_WPF.extend({}, task_info);
    var wpf_task_num_top= jQuery_WPF('wpf_task_details .wpf_task_num_top').text();
    jQuery_WPF.ajax({
        method : "POST",
        url : ajaxurl,
        data : {action: "wpfb_delete_task",wpf_nonce:wpf_nonce,task_info:task_info_obj},
        beforeSend: function(){
            jQuery_WPF('.wpf_loader_admin').show();
        },
        success : function(data){
            if(id == wpf_task_num_top){
                jQuery_WPF("#wpf_task_details #wpf_message_content,#wpf_task_details #wpf_message_form,#wpf_task_details .wpf_chat_top").hide();
            }
            jQuery_WPF('li.post_'+task_id).remove();
            jQuery_WPF('.wpf_loader_admin').hide();
            if(jQuery_WPF("ul#all_wpf_list li.wpf_list a:first-child").first().length==0 && id != ''){
                location.reload();
            }
            else{
                jQuery_WPF("ul#all_wpf_list li.wpf_list a:first-child").first().trigger('click');
                jQuery_WPF("ul#all_wpf_list li.wpf_list a").first().parent().addClass('active');
            }
        }
    });
}

function wpf_send_report(type) {
    jQuery_WPF.ajax({
        method: "POST",
        url: ajaxurl,
        data: {action: "wpf_send_email_report",wpf_nonce:wpf_nonce, type:type, forced: "yes"},
        beforeSend: function(){
            jQuery_WPF('.wpf_loader_admin').show();
        },
        success: function (data) {
            jQuery_WPF('.wpf_loader_admin').hide();
            jQuery_WPF('#wpf_back_report_sent_span').show();
            setTimeout(function() {
                jQuery_WPF('#wpf_back_report_sent_span').hide();
            }, 3000);
        }
    });
}

function wpf_upload_file_admin(wpf_taskid){
    var elemid = jQuery_WPF(this).attr('data-elemid'), task_info=[];
    var wpf_file = jQuery_WPF('#wpf_uploadfile')[0].files[0];
    var wpf_comment = '';
    var wpf_upload_form = new FormData();
    wpf_upload_form.append('action', 'wpf_upload_file');
    wpf_upload_form.append("wpf_nonce", wpf_nonce);
    wpf_upload_form.append("wpf_taskid", wpf_taskid);
    wpf_upload_form.append("wpf_upload_file", wpf_file);
    wpf_upload_form.append('task_config_author_name', current_user_name);
    if(wpf_file){
        jQuery_WPF.ajax({
            type: 'POST',
            url: ajaxurl,
            data: wpf_upload_form,
            contentType: false,
            processData: false,
            beforeSend: function(){
                jQuery_WPF('.wpf_loader_admin').show();
            },
            success: function (data) {
                var response = JSON.parse(data);
                jQuery_WPF('.wpf_loader_admin').hide();

                if(response.status==1){
                    jQuery_WPF("input[name=wpf_uploadfile]").val('');

                    if(response.type==1){
                        var comment_html = '<li class="chat_author"><level class="wpf-author">ME just now</level><p class="task_text"><a href="'+response.message+'" target="_blank"><div class="tag_img" style="width: 275px;height: 183px;"><img style="width: 100%;" class="wpfb_task_screenshot" src="'+response.message+'" /></div></a><p></li>';
                    }
                    else{
                        var wpf_download_file  = response.message.split("/").pop();
                        var comment_html = '<li class="chat_author"><level class="wpf-author">ME just now</level><p class="task_text"><a href="'+response.message+'" download="'+wpf_download_file+'"><div class="meassage_area_main"><i class="gg-software-download"></i> '+ wpf_download_file+'</div></a></p></li>';
                    }
                    jQuery_WPF('ul#wpf_message_list').append(comment_html);
                    jQuery_WPF('#wpf_message_content').animate({scrollTop: jQuery_WPF('#wpf_message_content').prop("scrollHeight")}, 2000);
                }
                else{
                    jQuery_WPF('#wpf_upload_error').show();
                    setTimeout(function() {
                        jQuery_WPF('#wpf_upload_error').hide();
                    }, 5000);
                }
            }
        });
    }
}

function wpf_general_comment(){
    wpf_open_tab('wpf_message_content');
    jQuery_WPF("#wpf_edit_title").hide();
    jQuery_WPF("#wpf_task_tabs_container").hide();
    chat_form = get_wpf_message_form();
    jQuery_WPF('#wpf_message_form').html(chat_form);
    var wpf_all_info_array = JSON.parse(wpf_all_pages);
    var wpfb_all_pages_html = '<select class="wpf_page_list" id="wpf_page_list">';
    wpfb_all_pages_html+='<option value="">'+wpf_general_task_option+'</option>';

    for (var key in wpf_all_info_array){

        if (wpf_all_info_array.hasOwnProperty(key)) {
            wpfb_all_pages_html+='<optgroup label="'+key+'">';
            for (var key_1 in wpf_all_info_array[key]){
                if (wpf_all_info_array[key].hasOwnProperty(key_1)) {
                    wpfb_all_pages_html+='<option value="'+key_1+'">'+ wpf_all_info_array[key][key_1] + '</option>';
                }
            }
            wpfb_all_pages_html+='</optgroup>';
        }

    }
    wpfb_all_pages_html+='</select>';

    var curr_browser = get_browser();
    html_element_width = window.screen.width;
    html_element_height = window.screen.height;

    var additional_info_html = '<p>Resolution: ' + html_element_width + ' X ' +html_element_height+'</p><p>Browser: ' + curr_browser['name']+' '+curr_browser['version'] + '</p><p>User Name: ' + current_user_name + '</p><p>User IP: ' + ipaddress + '</p>';
    jQuery_WPF("div#wpf_attributes_content #additional_information").html(additional_info_html);

    jQuery_WPF("#wpf_task_details #send_chat").attr("onclick","wpf_generate_front_task()");
    jQuery_WPF('#task_task_status_attr').removeAttr("onchange");
    jQuery_WPF('#task_task_priority_attr').removeAttr("onchange");
    jQuery_WPF('#wpf_attributes_content input[name="author_list_task"]').removeAttr("onclick");
    jQuery_WPF('#wpfb_attr_task_page_link').removeAttr("href");
    jQuery_WPF('#wpf_delete_task_container .wpf_task_delete_btn').remove();
    jQuery_WPF('#wpf_attributes_content input[name=author_list_task]').attr('checked', false);
    jQuery_WPF('.wpf_upload_button.wpf_button').hide();

    jQuery_WPF('div#wpf_task_details .wpf_task_main_top .wpf_task_title_top').html('');
    jQuery_WPF('div#wpf_task_details .wpf_task_num_top').html('');
    jQuery_WPF('div#wpf_task_details #wpf_message_list').html('');
    jQuery_WPF("input[type=text],input[type=hidden], textarea").val("");
    jQuery_WPF("#task_task_priority_attr").val("low");
    jQuery_WPF("#task_task_status_attr").val("open");


    jQuery_WPF('div#wpf_task_details .wpf_task_main_top .wpf_task_title_top').html(wpfb_all_pages_html);
    jQuery_WPF('div#wpf_task_details .wpf_task_num_top').html(comment_count);
    jQuery_WPF('div#wpf_task_details .wpf_task_details_top').html('By '+current_user_name+' '+wpf_comment_time);
    
    jQuery_WPF('div#wpf_task_details #wpf_message_list').html('');
    jQuery_WPF("input[type=text],input[type=hidden], textarea").val("");
    jQuery_WPF("#task_task_priority_attr").val("low");
    jQuery_WPF("#task_task_status_attr").val("open");
    jQuery_WPF('#all_tag_list').html('');
    jQuery_WPF('.wpf_task_tags').hide();
}

function wpf_generate_front_task(){
    var wpf_comment = jQuery_WPF('#wpf_comment').val();
    var curr_browser = get_browser();
    var new_task = Array();
    var current_page_id = jQuery_WPF('#wpf_page_list').val();
    var task_priority = jQuery_WPF('#wpf_attributes_content #task_task_priority_attr').val();
    var task_status = jQuery_WPF('#wpf_attributes_content #task_task_status_attr').val();
    var task_notify_users = [];
    var task_comment = jQuery_WPF('#wpf_comment').val();
    jQuery_WPF.each(jQuery_WPF('#wpf_attributes_content input[name=author_list_task]:checked'), function(){
        task_notify_users.push(jQuery_WPF(this).val());
    });
    task_notify_users =task_notify_users.join(",");
    new_task['task_number']=comment_count;
    new_task['task_priority']=task_priority;
    new_task['task_status']=task_status;
    new_task['task_config_author_browser']=curr_browser['name'];
    new_task['task_config_author_browserVersion']=curr_browser['version'];
    new_task['task_config_author_browserOS']=curr_browser['OS'];
    new_task['task_config_author_ipaddress']=ipaddress;
    new_task['task_config_author_name']=current_user_name;
    new_task['task_config_author_id']=current_user_id;
    new_task['task_config_author_resX']=window.screen.width;
    new_task['task_config_author_resY']=window.screen.height;
    new_task['task_title']=task_comment;
    new_task['current_page_id']=current_page_id;
    new_task['task_comment_message']=task_comment;
    new_task['task_notify_users']=task_notify_users;
    new_task['task_type']='general';

    var new_task_obj = jQuery_WPF.extend({}, new_task);
   
     if (jQuery_WPF('#wpf_comment').val().trim().length > 0 && task_notify_users.length > 0 && jQuery_WPF('#wpf_page_list').val()) {
        jQuery_WPF.ajax({
            method : "POST",
            url : ajaxurl,
            data : {action: "wpf_add_new_task",wpf_nonce:wpf_nonce,new_task:new_task_obj},
            beforeSend: function(){
                jQuery_WPF('.wpf_loader_admin').show();
            },
            success : function(data){
                location.reload();
            }
        });
     }
    else {
        if(!jQuery_WPF('#wpf_page_list').val() ){
            jQuery_WPF("p.form-submit.chat_button #wpf_error_page").remove();
            jQuery_WPF("p.form-submit.chat_button #wpf_error").remove();
            jQuery_WPF("#wpf_page_list").css('border', '1px solid red');
            jQuery_WPF("p.form-submit.chat_button").append('<p id="wpf_error_page">Page/post must be selected to post a comment</span>');
        }
        else if(task_notify_users.length == 0){
            jQuery_WPF("#wpf_page_list").removeAttr('style');
            jQuery_WPF("p.form-submit.chat_button #wpf_error_page").remove();
            jQuery_WPF("p.form-submit.chat_button #wpf_error").remove();
            jQuery_WPF("p.form-submit.chat_button").append('<p id="wpf_error">'+wpf_task_text_error_msg+'</span>');
        }else{
            jQuery_WPF("#wpf_page_list").removeAttr('style');
            jQuery_WPF("#wpf_comment").css('border', '1px solid red');
            jQuery_WPF("#wpf_comment").focus();
        }
        jQuery_WPF("#wpf_loader_admin").hide();
        jQuery_WPF("#get_masg_loader").hide();
        /*jQuery_WPF('ul#wpf_message_list').animate({scrollTop: jQuery_WPF("ul#wpf_message_list li").last().offset().top}, 1000);*/
    }
    
}

function wpf_edit_license() {
    jQuery_WPF('#wpfeedback_licence_key').prop('disabled',false);
    jQuery_WPF('#wpfeedback_licence_key').attr('type','text');
    jQuery_WPF('#wpfeedback_licence_key').val('');

}
/*resync dashboard */
function wpf_resync_dashboard() {
    jQuery_WPF.ajax({
        method: "POST",
        url: ajaxurl,
        data: {action: "wpf_resync_dashboard",wpf_nonce:wpf_nonce},
        beforeSend: function(){
                jQuery_WPF('.wpf_loader_admin').show();
            },
        success: function (data) {
            if (data == 1) {
                var url = window.location.href+'&resync_dashboard=1';
                window.location.href = url;
            }else{
                var url = window.location.href+'&resync_dashboard=2';
            }
        }
    });
}
function wpf_edit_title(){
    jQuery_WPF("#wpf_edit_title_box").toggle();
    var wpf_task_title = jQuery_WPF('#wpf_task_details .wpf_chat_top .wpf_task_title_top').text();
    jQuery_WPF("#wpf_title_val").val(wpf_task_title);
}

function wpf_update_title(){
    var wpf_new_task_title = jQuery_WPF("#wpf_title_val").val();
    var wpf_task_id = jQuery_WPF('#comment_post_ID').val();
    if(wpf_new_task_title !='' && wpf_task_id !=''){
        jQuery_WPF.ajax({
        method: "POST",
        url: ajaxurl,
        data: {action: "wpf_update_title",wpf_new_task_title:wpf_new_task_title,wpf_task_id:wpf_task_id,wpf_nonce:wpf_nonce},
            success: function (data) {
                var wpf_task_info = JSON.parse(data);
                jQuery_WPF("#wpf_edit_title_box").toggle();
                 jQuery_WPF("#wpf_title_val").val();
                jQuery_WPF('#wpf_task_details .wpf_chat_top .wpf_task_title_top').text(wpf_task_info.wpf_new_task_title);
                jQuery_WPF('#wpf-task-'+wpf_task_info.wpf_task_id+' .wpf_chat_top .wpf_task_pagename').text(wpf_task_info.wpf_new_task_title);
                jQuery_WPF('#wpf-task-'+wpf_task_info.wpf_task_id+' .wpf_chat_top .wpf_task_pagename').text(wpf_task_info.wpf_new_task_title);
                jQuery_WPF('#wpf-task-'+wpf_task_info.wpf_task_id).data('task_page_title',wpf_task_info.wpf_new_task_title);
            }
        });
    }
    
}

/*function wpf_search_tags(ele) {

}
*/
function wpf_add_tag_admin() {
    var tag_name = jQuery_WPF('#wpf_tags').val();
    var task_id = jQuery_WPF('#comment_post_ID').val();;
    var wpf_task_tag_info = [];
    wpf_task_tag_info['wpf_task_tag_name'] = tag_name;
    wpf_task_tag_info['wpf_task_id']=task_id;
    var wpf_task_tag_info_obj = jQuery_WPF.extend({}, wpf_task_tag_info);

    if(task_id !='' && tag_name !=''){
        jQuery_WPF.ajax({
            method : "POST",
            url : ajaxurl,
            data : {action: "wpfb_set_task_tag",wpf_nonce:wpf_nonce,wpf_task_tag_info:wpf_task_tag_info_obj},
            beforeSend: function(){
                jQuery_WPF('.wpf_loader_'+task_id).show();
            },
            success : function(data){
                var task_tag_info = JSON.parse(data);
                if(task_tag_info.wpf_tag_type != 'already_exit'){
                    jQuery_WPF('#wpf_tags').attr('style','border: 1px solid #ccc;');
                    jQuery_WPF('.wpf_loader').hide();
                    jQuery_WPF('#wpf_tags').val('');
                    jQuery_WPF('#all_tag_list').append("<span class='wpf_tag_name "+task_tag_info.wpf_task_tag_slug+"'>"+task_tag_info.wpf_task_tag_name+"<a href='javascript:void(0)' onclick='wpf_delete_tag(\""+task_tag_info.wpf_task_tag_name+"\",\""+task_tag_info.wpf_task_tag_slug+"\","+task_id+")'><i class='gg-close-o'></i></a></span>");
                }else{
                    jQuery_WPF('#wpf_tags').attr('style','border: 1px solid red;');
                }
            }
        });
    }
}

function wpf_delete_tag(wpf_task_tag_name,wpf_task_tag_slug, id){
    var wpf_task_tag_info = [];
    wpf_task_tag_info['wpf_task_tag_slug'] = wpf_task_tag_slug;
    wpf_task_tag_info['wpf_task_tag_name'] = wpf_task_tag_name;
    wpf_task_tag_info['wpf_task_id']=id;
    var wpf_task_tag_info_obj = jQuery_WPF.extend({}, wpf_task_tag_info);
    if(id !='' && wpf_task_tag_slug !=''){
        jQuery_WPF.ajax({
            method : "POST",
            url : ajaxurl,
            data : {action: "wpfb_delete_task_tag",wpf_nonce:wpf_nonce,wpf_task_tag_info:wpf_task_tag_info_obj},
            beforeSend: function(){
                jQuery_WPF('.wpf_loader_'+id).show();
            },
            success : function(data){
                var task_tag_info = JSON.parse(data);
                if(task_tag_info.wpf_msg == 1 ){
                    jQuery_WPF('#all_tag_list '+'.'+task_tag_info.wpf_task_tag_slug).remove();
                }
            }
        });
    } 
}

function wpf_tag_autocomplete(inp, arr) {
    var currentFocus;
    if(inp){
        inp.addEventListener("input", function(e) {
            var a, b, i, val = this.value;
            wpf_tag_closeAllLists();
            if (!val) { return false;}
            currentFocus = -1;
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "wpf_tag_autocomplete-list");
            a.setAttribute("class", "wpf_tag_autocomplete-items");
            this.parentNode.appendChild(a);
            for (i = 0; i < arr.length; i++) {
                if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                    b = document.createElement("DIV");
                    b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                    b.innerHTML += arr[i].substr(val.length);
                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                    b.addEventListener("click", function(e) {
                        inp.value = this.getElementsByTagName("input")[0].value;
                        wpf_tag_closeAllLists();
                    });
                    a.appendChild(b);
                }
            }
        });
        inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "wpf_tag_autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
                currentFocus++;
                wpf_tag_addActive(x);
            } else if (e.keyCode == 38) {
                currentFocus--;
                wpf_tag_addActive(x);
            } else if (e.keyCode == 13) {
                e.preventDefault();
                if (currentFocus > -1) {
                    if (x) x[currentFocus].click();
                }
                wpf_add_tag(this.id);
            }
        });
        function wpf_tag_addActive(x) {
            if (!x) return false;
            wpf_tag_removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            x[currentFocus].classList.add("wpf_tag_autocomplete-active");
        }
        function wpf_tag_removeActive(x) {
            for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("wpf_tag_autocomplete-active");
            }
        }
        function wpf_tag_closeAllLists(elmnt) {
            var x = document.getElementsByClassName("wpf_tag_autocomplete-items");
            for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
            }
        }
        document.addEventListener("click", function (e) {
            wpf_tag_closeAllLists(e.target);
        });
    }
}

jQuery_WPF('#wpf_display_all_taskmeta_tasktab').click(function(){
    jQuery_WPF('#wpf_display_all_taskmeta_tasktab').parent().toggleClass("wpf_isSelected");
    if(jQuery_WPF('ul#all_wpf_list  li .wpf_task_meta').hasClass('wpf_active')){
        jQuery_WPF('ul#all_wpf_list li .wpf_task_meta').removeClass('wpf_active');
    }else{
        jQuery_WPF('ul#all_wpf_list li .wpf_task_meta').addClass('wpf_active');
    }
});

function wpf_tasks_tabs(tab) {
    jQuery_WPF('#wpf_task_bulk_tab').parent().toggleClass("wpf_isSelected");
    if(jQuery_WPF('#wpf_task_bulk_tab').is(":checked")) {
        jQuery_WPF('#wpf_task_tab_title').html(wpf_bulk_editing_tasks);
        jQuery_WPF('.wpf_tasks-list').addClass('wpf_bulk_edit_mode');
        jQuery_WPF('#wpf_add_general_task').hide();
        jQuery_WPF('.wpf_task_num_top').hide();
        jQuery_WPF('#wpf_task_all_tab').removeClass('active');
        jQuery_WPF('ul#all_wpf_list li .wpf_task_id').addClass('wpf_active');
        jQuery_WPF('ul#all_wpf_list #wpf_bulk_select_task_checkbox').addClass('wpf_active');
        jQuery_WPF('#wpf_bulk_select_task_checkbox').show();

        jQuery_WPF('#wpf_task_details').hide();
        jQuery_WPF('#wpf_attributes_content').hide();
        jQuery_WPF('#wpf_bulk_update_content').show();
    }
    else{
        jQuery_WPF('#wpf_task_tab_title').html(wpf_tasks_found);
        jQuery_WPF('.wpf_tasks-list').removeClass('wpf_bulk_edit_mode');
        jQuery_WPF('#wpf_add_general_task').show();
        jQuery_WPF('.wpf_task_num_top').show();
        jQuery_WPF('#wpf_task_all_tab').addClass('active');
        jQuery_WPF('#wpf_task_bulk_tab').removeClass('active');
        jQuery_WPF('ul#all_wpf_list li .wpf_task_id').removeClass('wpf_active');
        jQuery_WPF('ul#all_wpf_list #wpf_bulk_select_task_checkbox').removeClass('wpf_active');
        jQuery_WPF('#wpf_task_details').show();
        jQuery_WPF('#wpf_attributes_content').show();
        jQuery_WPF('#wpf_bulk_update_content').hide();
        jQuery_WPF('#wpf_bulk_select_task_checkbox').hide();
        jQuery_WPF("ul#all_wpf_list li.wpf_list input[name='wpf_task_id']:checked").prop("checked", false);

        jQuery_WPF('#wpf_task_details').show();
        jQuery_WPF('#wpf_attributes_content').show();
        jQuery_WPF('#wpf_bulk_update_content').hide();
    }
}

function wpf_open_tab(show) {
    if(show=='wpf_task_screenshot_tab'){
        jQuery_WPF('#wpf_task_screenshot_tab').show();
        jQuery_WPF('#wpf_message_content').hide();
        jQuery_WPF('#wpf_message_form').hide();
        jQuery_WPF('#wpf_task_tabs_container .wpf_task_tab_item').removeClass('active');
        jQuery_WPF('#wpf_task_tabs_container .wpf_task_screenshot_tab').addClass('active');
    }
    else{
        jQuery_WPF('#wpf_task_screenshot_tab').hide();
        jQuery_WPF('#wpf_message_content').show();
        jQuery_WPF('#wpf_message_form').show();
        jQuery_WPF('#wpf_task_tabs_container .wpf_task_tab_item').removeClass('active');
        jQuery_WPF('#wpf_task_tabs_container .wpf_message_content').addClass('active');
    }
}

jQuery_WPF(document).on("click", "#wpf_select_all_task" , function(){
    if(jQuery_WPF('#wpf_select_all_task').is(":checked")){
        jQuery_WPF( '.wpf_list input[type="checkbox"]' ).prop('checked', this.checked).parent().addClass('active');
    }
    else{
        jQuery_WPF( '.wpf_list input[type="checkbox"]' ).prop('checked', this.checked).parent().removeClass('active');
    }
});

jQuery_WPF( '#wpf_conformation_box_show' ).click( function () {
    var selected_tasks = jQuery_WPF('.wpf_list input[type="checkbox"]:checked').length;
    if(selected_tasks > 0){
        jQuery_WPF('#wpf_update_option_container').show();
    }
});

jQuery_WPF('.wpf_task_id').on('click',function(){
    if(jQuery_WPF(this).is(":checked")){
        jQuery_WPF(this).parent().addClass('active');
    }else{
        jQuery_WPF(this).parent().removeClass('active');
    }

});

function wpf_bulk_update() {
    var wpf_task_ids = [];
    jQuery_WPF.each(jQuery_WPF("ul#all_wpf_list li.wpf_list input[name='wpf_task_id']:checked"), function () {
        wpf_task_ids.push(jQuery_WPF(this).val());
    });
    var wpf_task_priority_attr = jQuery_WPF("#wpf_bulk_update_content select#task_task_priority_attr"). val();
    var wpf_task_task_status_attr = jQuery_WPF("#wpf_bulk_update_content select#task_task_status_attr"). val();
    if(wpf_task_ids != '' && (wpf_task_priority_attr != '' || wpf_task_task_status_attr != '')){
        jQuery_WPF.ajax({
            method : "POST",
            url : ajaxurl,
            data : {action: "wpf_bulk_update_tasks",wpf_nonce:wpf_nonce,wpf_task_task_status_attr:wpf_task_task_status_attr,wpf_task_priority_attr:wpf_task_priority_attr,wpf_task_ids:wpf_task_ids},
            beforeSend: function(){
                jQuery_WPF('.wpf_loader_admin').show();
            },
            success : function(data){
                var task_response_info = JSON.parse(data);
                console.log(task_response_info.wpf_msg);
                if(task_response_info.wpf_msg == 1 ){
                    jQuery_WPF.ajax({
                        method: "POST",
                        url: ajaxurl,
                        data: {
                            action: "wpfeedback_get_post_list_ajax",
                            wpf_nonce:wpf_nonce
                        },
                        success: function (data) {
                            jQuery_WPF('.wpf_loader_admin').hide();
                            jQuery_WPF('#all_wpf_list').html(data);
                            jQuery_WPF("#wpf_display_all_taskmeta_tasktab").trigger('click');
                            jQuery_WPF("#wpf_display_all_taskmeta_tasktab").prop("checked", true);
                            jQuery_WPF("#wpf_task_bulk_tab").trigger('click');
                            jQuery_WPF("#wpf_task_bulk_tab").prop("checked", true);
                            wpf_tasks_tabs('bulk');
                            jQuery_WPF.each(wpf_task_ids,function (index, value) {
                                jQuery_WPF("#wpf_"+value).prop("checked", true);
                                //jQuery_WPF("#all_wpf_list li.post_"+value).addClass('active');
                                
                            });

                        }
                    });
                }
            }
        });
    }
}

jQuery_WPF(document).find("#wpf_bulk_delete_task_container").on("click",".wpf_bulk_task_delete_btn",function(e) {
    jQuery_WPF('#wpf_bulk_task_delete').show();
});

jQuery_WPF(document).find("#wpf_bulk_delete_task_container").on("click",".wpf_bulk_task_delete",function(e){
    var wpf_task_ids = [];
    var selected_tasks = jQuery_WPF("ul#all_wpf_list li.wpf_list input[name='wpf_task_id']:checked").length;
    if(selected_tasks > 0) {
        jQuery_WPF.each(jQuery_WPF("ul#all_wpf_list li.wpf_list input[name='wpf_task_id']:checked"), function () {
            var elemid = '';
            var task_id = jQuery_WPF(this).val();
            wpf_admin_delete_task(elemid, task_id);
        });
        jQuery_WPF('#wpf_bulk_task_delete').hide();
    }
});