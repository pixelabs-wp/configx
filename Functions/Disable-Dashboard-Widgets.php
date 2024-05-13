<?php
/*
  Title: Disable Dashboard Widgets
  Category: Branding and Design
  Description: Add description here
*/

function disable_all_dashboard_widgets() {
    // Remove standard dashboard widgets
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal');   // Right Now
    remove_meta_box('dashboard_activity', 'dashboard', 'normal');     // Activity
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');    // Quick Draft
    remove_meta_box('dashboard_primary', 'dashboard', 'side');        // WordPress News

    // Additional standard widgets can be removed similarly
}

add_action('wp_dashboard_setup', 'disable_all_dashboard_widgets');


?>