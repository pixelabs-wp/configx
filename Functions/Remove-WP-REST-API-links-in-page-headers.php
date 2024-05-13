<?php
/*
  Title: Remove WP REST API links in page headers
  Category: Bloat Remover and Speed Optimization
  Description: Add description here
*/

function remove_rest_api_links() {
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
    remove_action('template_redirect', 'rest_output_link_header', 11, 0);
}

add_action('after_setup_theme', 'remove_rest_api_links');

?>