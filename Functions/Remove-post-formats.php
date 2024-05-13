<?php
/*
  Title: Remove post formats
  Category: Tweaks
  Description: Add description here
*/

function remove_post_formats_support() {
    remove_theme_support('post-formats');
}

add_action('after_setup_theme', 'remove_post_formats_support');



?>