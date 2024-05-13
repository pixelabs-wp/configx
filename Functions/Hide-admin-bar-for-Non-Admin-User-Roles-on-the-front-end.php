<?php
/*
  Title: Hide admin bar for Non-Admin User Roles on the front-end
  Category: Tweaks
  Description: Add description here
*/

function hide_admin_bar_for_non_admins($show) {
    if (!current_user_can('administrator')) {
        return false;
    }
    return $show;
}

add_filter('show_admin_bar', 'hide_admin_bar_for_non_admins', 10, 1);

?>