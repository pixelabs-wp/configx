<?php
/*
  Title: Asynchronous Loading
  Category: Bloat Remover and Speed Optimization
  Description: Add description here
*/

function add_async_to_all_scripts() {
    if (is_admin()) {
        return; // Do not modify script loading in the admin area
    }

    global $wp_scripts;
    if ($wp_scripts instanceof WP_Scripts) {
        foreach ($wp_scripts->registered as $handle => $script) {
            // Add 'async' attribute to the script tag
            $wp_scripts->add_data($handle, 'async', true);
        }
    }
}

add_action('wp_print_scripts', 'add_async_to_all_scripts');


?>