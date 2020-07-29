var clone,wpf_bootstrap_version,wpf_popover_template;
jQuery_WPF(window).on('load', function(){
    wpf_bootstrap_version_tmp = jQuery_WPF.fn.popover.Constructor.VERSION;
    if(wpf_bootstrap_version_tmp != null){
        var wpf_bootstrap_version_arr = wpf_bootstrap_version_tmp.split('.');
        wpf_bootstrap_version = wpf_bootstrap_version_arr[0];
        if (wpf_bootstrap_version == 3) {
            wpf_popover_template = '<div class="popover wpf_comment_container" role="tooltip"><div class="arrow wpf_arrow"></div><h3 class="popover-header"></h3><div class="popover-content"></div></div>';
        } else {
            wpf_popover_template = '<div class="popover wpf_comment_container" role="tooltip"><div class="arrow wpf_arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>';
        }
    }else{ 
        wpf_popover_template = '<div class="popover wpf_comment_container" role="tooltip"><div class="arrow wpf_arrow"></div><h3 class="popover-header"></h3><div class="popover-content"></div></div>';
    }
    jQuery_WPF('#wpadminbar').attr("data-html2canvas-ignore", "true");
    init_popover();
});

function init_popover() {
    jQuery_WPF('[rel="popover"]').popover({
        html: true,
        trigger: 'click',
        template: wpf_popover_template,
        content: function () {
            if (jQuery_WPF(jQuery_WPF(this).data('popover-content')).clone(true).hasClass('hide')) {
                clone = jQuery_WPF(jQuery_WPF(this).data('popover-content')).clone(true).removeClass('hide');
            }
            $clone = jQuery_WPF('#popoverContent').remove().html();
            return clone;
        }
    });

    jQuery_WPF('.wpf_comment_container .nav-tabs a').click(function (e) {
        e.preventDefault();
        jQuery_WPF(this).tab('show');
        return false;
    });
    jQuery_WPF('.wpf_comment_container .nav-tabs a').on('touchstart', function (e) {
        e.preventDefault();
        jQuery_WPF(this).tab('show');
        return false;
    });
    jQuery_WPF('[data-toggle="popover"]').on('inserted.bs.popover', function () {
        setTimeout(function(){ jQuery_WPF('#comment-'+id).focus(); }, 100);
        jQuery_WPF('.popover').attr("data-html2canvas-ignore", "true");
    });
}
/*popup for new task*/
function init_custom_popover(id) {
    var clone;
    var clone1;
    jQuery_WPF('[rel="popover-' + id + '"]').popover({
        html: true,
        trigger: 'click',
        placement: 'auto',
        template: wpf_popover_template,
        content: function () {
            if (jQuery_WPF(jQuery_WPF(this).data('popover-content')).clone(true).hasClass('hide')) {
                clone1 = jQuery_WPF(jQuery_WPF(this).data('popover-content')).clone(true).removeClass('hide');
            }
            $clone1 = jQuery_WPF('#popover-content-c' + id).remove().html();
            return clone1;
        }
    });
    
    jQuery_WPF('#sharetasklink-tab-' + id).hide();
    jQuery_WPF('#wpfbsysinfo-' + id + ' .wpf_tag_autocomplete').hide();
    jQuery_WPF('#wpfbsysinfo-' + id + ' .wpf_icon_title').hide();
    jQuery_WPF('[rel="popover-' + id + '"]').popover('show');
    setTimeout(function(){ jQuery_WPF('#comment-'+id).focus(); }, 100);

    /*jQuery_WPF('.wpf_comment_container .nav-tabs a').click(function (e) {
        e.preventDefault();
        jQuery_WPF(this).tab('show');
        var selector = jQuery_WPF(this).attr('href');
        jQuery_WPF('.wpf_comment_container .tab-content .tab-pane').removeClass('active');
        jQuery_WPF(selector).addClass('active');
        return false;
    });*/
    jQuery_WPF('#myTab-' + id + ' a').click(function (e) {
        if(jQuery_WPF(this).hasClass('active')){
            var tab_content_id= jQuery_WPF(this).attr('href');
            console.log(tab_content_id);
            jQuery_WPF(tab_content_id).removeClass('active');
            jQuery_WPF(this).removeClass('active');
            return false;
        }
    }); 
    jQuery_WPF('.wpf_comment_container .nav-tabs a').on('touchstart', function (e) {
        e.preventDefault();
        jQuery_WPF(this).tab('show');
        return false;
    });
    /*jQuery_WPF('.close').click(function (e) {
        jQuery_WPF(this).parents('.popover').popover('hide');
    });*/

    jQuery_WPF(document).on("click", ".close" , function(e){
        jQuery_WPF(this).parents(".popover").popover('hide');
    });

    jQuery_WPF('[data-toggle="popover"]').on('inserted.bs.popover', function () {
        setTimeout(function(){ jQuery_WPF('#comment-'+id).focus(); }, 100);
        jQuery_WPF('.popover').attr("data-html2canvas-ignore", "true");
    });
    jQuery_WPF('#wpfbscreenshot-tab-' + id).click(function (e) {
        jQuery_WPF(this).parents('.popover').attr("data-html2canvas-ignore", "true");
    });
    jQuery_WPF('.wpf_task_temp_delete_btn').click(function(){
        var btn_taskid = jQuery_WPF(this).data('btn_elemid');
        jQuery_WPF('.wpfbsysinfo_temp_delete_task_id_'+btn_taskid).show();
    });
    jQuery_WPF('.wpf_task_temp_delete').click(function(){
        var elemid = jQuery_WPF(this).data('elemid');
        jQuery_WPF('#popover-content-c'+elemid+' .close').trigger('click');
        jQuery_WPF('#bubble-'+elemid).remove();
        comment_count--;
    });
    jQuery_WPF(document).find("#wpf_delete_container_"+id).on("click",".wpf_task_delete_btn",function(e) {
        var btn_elemid = jQuery_WPF(this).data('btn_elemid');
        jQuery_WPF('.wpfbsysinfo_delete_task_id_'+btn_elemid).show();
    });
    jQuery_WPF(document).find("#wpf_delete_container_"+id).on("click",".wpf_task_delete",function(e) {
        var elemid = jQuery_WPF(this).data('elemid');
        var task_id = jQuery_WPF(this).data('taskid');
        wpf_delete_task(elemid,task_id);
        jQuery_WPF('#popover-content-c'+elemid+' .close').trigger('click');
        jQuery_WPF('#bubble-'+elemid).remove();
        comment_count--;
    });
    jQuery_WPF("#wpf_uploadfile_"+id).change(function () {
        wpf_upload_file(this);
    });
    /*jQuery_WPF('.wpf_task_uploaded_image').on('click',function(){
        var redirectWindow = window.open(jQuery_WPF(this).attr("src"), '_blank');
        redirectWindow.location;
    });
    */
    jQuery_WPF( function() {
        jQuery_WPF( "#bubble-"+id ).draggable({ containment: "body" });
    });
}

function init_custom_popover_first(id) {
    var clone;
    var clone1;
    jQuery_WPF('[rel="popover-' + id + '"]').popover({
        html: true,
        trigger: 'click',
        placement: 'auto',
        template: wpf_popover_template,
        content: function () {
            if (jQuery_WPF(jQuery_WPF(this).data('popover-content')).clone(true).hasClass('hide')) {
                clone1 = jQuery_WPF(jQuery_WPF(this).data('popover-content')).clone(true).removeClass('hide');
            }
            $clone1 = jQuery_WPF('#popover-content-c' + id).remove().html();
            return clone1;
        }
    });
    jQuery_WPF('.wpf_comment_container .nav-tabs a').click(function (e) {
        e.preventDefault();
        jQuery_WPF(this).tab('show');
        return false;
    });
    jQuery_WPF('.wpf_comment_container .nav-tabs a').on('touchstart', function (e) {
        e.preventDefault();
        jQuery_WPF(this).tab('show');
        return false;
    });

    jQuery_WPF('#myTab-' + id + ' a').click(function (e) {
        if(jQuery_WPF(this).hasClass('active')){
            var tab_content_id= jQuery_WPF(this).attr('href');
            console.log(tab_content_id);
            jQuery_WPF(tab_content_id).removeClass('active');
            jQuery_WPF(this).removeClass('active');
            return false;
        }
    });

    jQuery_WPF('a.wpfb-point').click(function (e) {
        var text_id = jQuery_WPF(this).text();
        setTimeout(function(){     jQuery_WPF('#comment-'+text_id).focus(); }, 100);
        });
        
    jQuery_WPF('[data-toggle="popover"]').on('inserted.bs.popover', function () {
        jQuery_WPF('.popover').attr("data-html2canvas-ignore", "true");
        jQuery_WPF('#task_comments_' + id).animate({scrollTop: jQuery_WPF('#task_comments_' + id).prop("scrollHeight")}, 2000);

    });
    jQuery_WPF("#wpf_uploadfile_"+id).change(function () {
        wpf_upload_file(this);
    });
    /*jQuery_WPF('.wpf_task_uploaded_image').on('click',function(){
        var redirectWindow = window.open(jQuery_WPF(this).attr("src"), '_blank');
        redirectWindow.location;
    });*/
}