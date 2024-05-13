<?php
/*
  Title: Disable Embed Scripts
  Category: Security
  Description: Add description here
*/

function disable_embed_scripts() {
    // Remove oEmbed JavaScript
    remove_action('wp_head', 'wp_oembed_add_host_js');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    
    // Remove oEmbed REST API endpoint
    remove_action('rest_api_init', 'wp_oembed_register_route');
    
    // Disable the REST API endpoint for oEmbed
    add_filter('embed_oembed_discover', '__return_false');
    
    // Disable XML-RPC methods for embedding
    add_filter('xmlrpc_methods', function ($methods) {
        unset($methods['pingback.ping']);
        unset($methods['pingback.extensions.getPingbacks']);
        return $methods;
    });
    
    // Disable X-Pingback header
    add_filter('wp_headers', function ($headers) {
        unset($headers['X-Pingback']);
        return $headers;
    });
}

add_action('init', 'disable_embed_scripts');


?>