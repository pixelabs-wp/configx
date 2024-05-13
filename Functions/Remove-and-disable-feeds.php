<?php
/*
  Title: Remove and disable feeds
  Category: Bloat Remover and Speed Optimization
  Description: Add description here
*/

function disable_wp_feeds() {
    wp_redirect(home_url(), 302);
    exit;
}

function remove_feed_links() {
    remove_theme_support('automatic-feed-links');
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);
}

add_action('do_feed', 'disable_wp_feeds', 1);
add_action('do_feed_rdf', 'disable_wp_feeds', 1);
add_action('do_feed_rss', 'disable_wp_feeds', 1);
add_action('do_feed_rss2', 'disable_wp_feeds', 1);
add_action('do_feed_atom', 'disable_wp_feeds', 1);
add_action('do_feed_rss2_comments', 'disable_wp_feeds', 1);
add_action('do_feed_atom_comments', 'disable_wp_feeds', 1);

add_action('init', 'remove_feed_links');


?>