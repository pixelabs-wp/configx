<?php
/*
  Title: Change login url
  Category: Security
  Description: Add description here
*/

function custom_login_page() {
    $new_login_slug = 'account-login'; // Your new login URL slug

    global $pagenow;
    if ($pagenow === 'wp-login.php' && !is_user_logged_in()) {
        wp_redirect(home_url($new_login_slug));
        exit;
    }
}

function custom_login_url($login_url, $redirect = '', $force_reauth = false) {
    return home_url('account-login/' . ($redirect ? "?redirect_to=$redirect" : ''));
}

function custom_login_init(){
    add_action('init', 'custom_login_page');
    add_filter('login_url', 'custom_login_url', 10, 3);
}

add_action('plugins_loaded', 'custom_login_init');


?>