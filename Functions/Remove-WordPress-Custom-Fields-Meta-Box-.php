<?php
/*
  Title: Remove WordPress Custom Fields Meta Box 
  Category: Bloat Remover and Speed Optimization
  Description: Add description here
*/

function remove_custom_fields_meta_box() {
    foreach ( ['post', 'page'] as $post_type ) {
        // If you want to remove the meta box only for certain post types, adjust the array above
        remove_meta_box('postcustom', $post_type, 'normal');
    }
}

add_action('admin_menu', 'remove_custom_fields_meta_box');


?>