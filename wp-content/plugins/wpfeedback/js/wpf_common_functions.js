function wpf_confirm(title, msg, $true, $false, temp_funct) {
    var $content =  "<div class='wpf_confirm_dialog_overlay'>" +
        "<div class='wpf_confirm_dialog'><header>" +
        " <h3> " + title + " </h3> " +
        "<i class='wpf-close'>X</i>" +
        "</header>" +
        "<div class='wpf_confirm_dialog_msg'>" +
        " <p> " + msg + " </p> " +
        "</div>" +
        "<footer>" +
        "<div class='wpf_confirm_dialog_controls'>" +
        " <button class='wpf_confirm_yes'>" + $true + "</button> " +
        " <button class='wpf_confirm_cancle'>" + $false + "</button> " +
        "</div>" +
        "</footer>" +
        "</div>" +
        "</div>";
    jQuery_WPF('body').prepend($content);
    jQuery_WPF('.wpf_confirm_yes').click(function () {
        jQuery_WPF(this).parents('.wpf_confirm_dialog_overlay').fadeOut(500, function () {
            jQuery_WPF(this).remove();
        });
        window[temp_funct]();
        return true;
    });
    jQuery_WPF('.wpf_confirm_cancle, .wpf-close').click(function () {
        jQuery_WPF(this).parents('.wpf_confirm_dialog_overlay').fadeOut(500, function () {
            jQuery_WPF(this).remove();
        });
        return false;
    });
}