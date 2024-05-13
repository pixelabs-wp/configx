<?php
/*
  Title: Hide the WP Version in frontend source code and backend 
  Category: Security
  Description: Add description here
*/

function remove_wordpress_version() {
    // Remove WordPress version from the front end
    remove_action('wp_head', 'wp_generator');

    // Remove WordPress version from the admin footer
    add_filter('admin_footer_text', 'remove_wp_version_from_admin_footer');
}
add_action('init', 'remove_wordpress_version');

function remove_wp_version_from_admin_footer($text) {
    return preg_replace('/\s?WordPress\s\d+\.\d+(\.\d+)?/', '', $text);
}

?>