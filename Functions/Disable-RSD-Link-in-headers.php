<?php
/*
  Title: Disable RSD Link in headers
  Category: Bloat Remover and Speed Optimization
  Description: Add description here
*/

function remove_rsd_link() {
    remove_action('wp_head', 'rsd_link');
}

add_action('init', 'remove_rsd_link');


?>