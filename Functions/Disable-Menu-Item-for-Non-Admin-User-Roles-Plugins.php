<?php
/*
  Title: Disable Menu Item for Non-Admin User Roles: Plugins
  Category: User Roles and Restrictions
  Description: Add description here
*/

function remove_plugins_menu_for_non_admins() {
    // Check if the current user is not an administrator
    if (!current_user_can('administrator')) {
        // Remove the "Plugins" menu item
        remove_menu_page('plugins.php');
    }
}

add_action('admin_menu', 'remove_plugins_menu_for_non_admins');


?>