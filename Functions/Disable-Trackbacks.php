<?php
/*
  Title: Disable Trackbacks
  Category: Security
  Description: Add description here
*/

function disable_trackbacks() {
    // Disable trackbacks
    update_option('default_pingback_flag', '0');
    update_option('default_ping_status', 'closed');

    // Remove pingback XML-RPC methods
    add_filter('xmlrpc_methods', function ($methods) {
        unset($methods['pingback.ping']);
        unset($methods['pingback.extensions.getPingbacks']);
        return $methods;
    });

    // Remove X-Pingback header
    add_filter('wp_headers', function ($headers) {
        unset($headers['X-Pingback']);
        return $headers;
    });
}

add_action('init', 'disable_trackbacks');


?>