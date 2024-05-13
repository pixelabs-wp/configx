<?php
/*
  Title: Remove WLManifest Link (Windows Live Writer)
  Category: Bloat Remover and Speed Optimization
  Description: Add description here
*/

function remove_wlmanifest_link() {
    remove_action('wp_head', 'wlwmanifest_link');
}

add_action('init', 'remove_wlmanifest_link');


?>