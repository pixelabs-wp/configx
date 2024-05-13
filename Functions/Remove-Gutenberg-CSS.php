<?php
/*
  Title: Remove Gutenberg CSS
  Category: Bloat Remover and Speed Optimization
  Description: Add description here
*/

function remove_gutenberg_css(){
    // Deregister Gutenberg/block styles for the front end
    wp_dequeue_style('wp-block-library'); // WordPress core
    wp_dequeue_style('wp-block-library-theme'); // Theme’s block styles

    // Deregister Gutenberg/block styles for the backend/editor
    wp_dequeue_style('wp-editor'); // Editor only
    wp_dequeue_style('wp-edit-blocks'); // Editor blocks
}

add_action('wp_enqueue_scripts', 'remove_gutenberg_css', 100);
add_action('admin_enqueue_scripts', 'remove_gutenberg_css', 100);


?>