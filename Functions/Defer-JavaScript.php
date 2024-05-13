<?php
/*
  Title: Defer JavaScript
  Category: Bloat Remover and Speed Optimization
  Description: Add description here
*/

function defer_parsing_of_js($url) {
    if (is_admin() || strpos($url, 'jquery.js') !== false) {
        return $url; // Don't modify scripts in the admin area or jQuery
    }

    if (strpos($url, '?ver=')) {
        $url = remove_query_arg('ver', $url); // Remove version query string
    }

    return $url . '" defer="defer'; // Add defer attribute
}

add_filter('script_loader_src', 'defer_parsing_of_js');


?>