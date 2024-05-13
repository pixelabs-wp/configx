<?php
/*
  Title: Disable Menu Item for Non-Admins User Roles: Settings
  Category: User Roles and Restrictions
  Description: Add description here
*/

function remove_settings_menu_for_non_admins() {
    // Check if the current user is not an administrator
    if (!current_user_can('administrator')) {
        // Remove the "Settings" menu item
        remove_menu_page('options-general.php');
    }
}


?>