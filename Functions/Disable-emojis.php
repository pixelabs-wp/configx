<?php
/*
  Title: Disable emojis
  Category: Bloat Remover and Speed Optimization
  Description: Add description here
*/

function disable_emojis() {
    // Remove the emoji script from the front end
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');    

    // Remove from email
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

    // Remove from RSS feeds
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');

    // Remove from embeds
    remove_filter('embed_head', 'print_emoji_detection_script');

    // Remove the emoji related styles and scripts from TinyMCE, the classic editor
    add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');

    // Filter to remove the DNS prefetch
    add_filter('emoji_svg_url', '__return_false');
}

function disable_emojis_tinymce($plugins) {
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
}

add_action('init', 'disable_emojis');


?>