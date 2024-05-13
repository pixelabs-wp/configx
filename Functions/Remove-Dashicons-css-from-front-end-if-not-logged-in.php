<?php
/*
  Title: Remove Dashicons css from front end if not logged in
  Category: Bloat Remover and Speed Optimization
  Description: Add description here
*/

function remove_dashicons_from_frontend_for_guests() {
    if (!is_user_logged_in()) {
        wp_dequeue_style('dashicons');
    }
}

add_action('wp_enqueue_scripts', 'remove_dashicons_from_frontend_for_guests');


?>