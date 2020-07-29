jQuery_WPF(document).ready(function() {

    function wpf_check_url_parameter(name) {
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regexS = "[\\?&]" + name + "=([^&#]*)";
    var regex = new RegExp(regexS);
    var results = regex.exec(window.location.href);
    if (results == null)
        return "";
    else
        return decodeURIComponent(results[1].replace(/\+/g, " "));
    }
    /*Show the login dialog box on*/
    var wpf_login = wpf_check_url_parameter('wpf_login');
    if(wpf_login != ''){
        jQuery_WPF('#wpf_login_container').show();
    }

    jQuery_WPF(document).on("click", ".wpf_login_close" , function(e){
        jQuery_WPF("#wpf_login_container").hide();
    });

    /*Perform AJAX login on form submit*/
    jQuery_WPF('form#wpf_login').on('submit', function(e){
        jQuery_WPF('form#wpf_login p.wpf_status').show().text(wpf_ajax_login_object.loadingmessage);
        jQuery_WPF.ajax({
            type: 'POST',
            dataType: 'json',
            url: wpf_ajax_login_object.ajaxurl,
            data: { 
                'action': 'wpf_ajaxlogin', /*calls wp_ajax_nopriv_ajaxlogin*/
                'username': jQuery_WPF('form#wpf_login #username').val(), 
                'password': jQuery_WPF('form#wpf_login #password').val(), 
                'wpf_security': jQuery_WPF('form#wpf_login #wpf_security').val() },
            success: function(data){
                jQuery_WPF('form#wpf_login p.wpf_status').text(data.message);
                if (data.loggedin == true){
                    /*document.location.href = wpf_ajax_login_object.redirecturl;*/
                    location.reload();
                }
            }
        });
        e.preventDefault();
    });

});