<?php
/*
  Title: Remove author pages
  Category: Bloat Remover and Speed Optimization
  Description: Add description here
*/

function disable_author_pages() {
    global $wp_query;

    if (is_author()) {
        // Redirect to homepage, set status to 301 for permanent redirect
        wp_redirect(get_home_url(), 301);
        exit;
    }
}

add_action('template_redirect', 'disable_author_pages');


?>