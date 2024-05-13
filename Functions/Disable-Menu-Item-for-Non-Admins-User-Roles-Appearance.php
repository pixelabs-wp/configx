<?php
/*
  Title: Disable Menu Item for Non-Admins User Roles: Appearance
  Category: User Roles and Restrictions
  Description: Add description here
*/

function remove_appearance_menu_for_non_admins() {
    // Check if the current user is not an administrator
    if (!current_user_can('administrator')) {
        // Remove the "Appearance" menu item
        remove_menu_page('themes.php');
    }
}

add_action('admin_menu', 'remove_appearance_menu_for_non_admins');


?>