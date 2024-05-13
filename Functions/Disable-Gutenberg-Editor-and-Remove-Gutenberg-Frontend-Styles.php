<?php
/*
  Title: Disable Gutenberg Editor and Remove Gutenberg Frontend Styles
  Category: User Roles and Restrictions
  Description: Add description here
*/

add_filter('use_block_editor_for_post', '__return_false');
add_filter('use_widgets_block_editor', '__return_false');

add_action('wp_enqueue_scripts', function() {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('global-styles');
}, 20);


?>