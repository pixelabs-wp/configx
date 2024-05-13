<?php
/*
  Title: Remove Shortlink Headers
  Category: Bloat Remover and Speed Optimization
  Description: Add description here
*/

function remove_shortlink_headers() {
    // Remove shortlink from HTTP headers
    remove_action('template_redirect', 'wp_shortlink_header', 11);

    // Remove shortlink from HTML head
    remove_action('wp_head', 'wp_shortlink_wp_head', 10);
}

add_action('init', 'remove_shortlink_headers');


?>