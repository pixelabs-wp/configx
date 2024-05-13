<?php
/*
  Title: Remove Query Strings
  Category: Bloat Remover and Speed Optimization
  Description: Add description here
*/

function remove_query_strings_from_static_resources($src) {
    if (is_admin()) {
        return $src; // Don't modify URLs in the admin area
    }

    if (strpos($src, '?ver=')) {
        $src = remove_query_arg('ver', $src);
    }

    return $src;
}

add_filter('script_loader_src', 'remove_query_strings_from_static_resources', 15);
add_filter('style_loader_src', 'remove_query_strings_from_static_resources', 15);


?>