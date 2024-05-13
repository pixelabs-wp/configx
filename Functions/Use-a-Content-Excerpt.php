<?php
/*
  Title: Use a Content Excerpt
  Category: Bloat Remover and Speed Optimization
  Description: Add description here
*/

function custom_archive_excerpt($content) {
    if (is_archive() || is_search()) {
        global $post;
        return get_the_excerpt($post);
    }
    return $content;
}

add_filter('the_content', 'custom_archive_excerpt');


?>