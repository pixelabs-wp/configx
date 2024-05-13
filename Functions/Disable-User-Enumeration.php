<?php
/*
  Title: Disable User Enumeration
  Category: Security
  Description: Add description here
*/

// Disable User Enumeration in WordPress
function custom_disable_user_enumeration($redirect, $request) {
    if (preg_match('/\?author=([0-9]*)/i', $request)) {
        return home_url('/');
    }
    return $redirect;
}

add_filter('redirect_canonical', 'custom_disable_user_enumeration', 10, 2);

// Optionally, you can also return a 404 error for author archives
function custom_disable_author_archive() {
    if (is_author()) {
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
    }
}

add_action('template_redirect', 'custom_disable_author_archive');


?>