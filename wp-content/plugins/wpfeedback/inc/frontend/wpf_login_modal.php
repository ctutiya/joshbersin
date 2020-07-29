<?php 
$wpf_skip_btn = '';
$wpf_colse_btn = '';
$wpf_allow_guest = get_option('wpf_allow_guest');
    if($wpf_allow_guest == 'yes'){
    	$wpf_skip_btn = '<a href="javascript:void(0)" class="wpf_skip wpf_login_close" data-dismiss="alert">'.__('Skip the login','wpfeedback').'</a>';
    }else {
    	$wpf_colse_btn = '<a href="javascript:void(0)" class="wpf_login_close" data-dismiss="alert">×</a>';
    }
?>
<div class="wpf_wizard_container wpf_comment_container wpf_hide" data-html2canvas-ignore="true" id="wpf_login_container">
    <div class="wpf_wizard_modal">
    	<?php echo $wpf_colse_btn; ?>
    	<div class='wpfeedback_image-preview-wrapper'><img alt="WP Feedback" title="WP Feedback" id='wpf_image-preview' src='<?php echo get_wpf_logo(); ?>' height='100'></div>
        <div class="wpf_loader wpf_loader_wizard wpf_hide"></div>
        <?php echo do_shortcode('[wpf_login_form]');?>
        <?php echo $wpf_skip_btn; ?>
    </div>
</div>