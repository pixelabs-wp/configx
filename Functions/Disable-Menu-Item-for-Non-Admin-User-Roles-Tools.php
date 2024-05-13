<?php
/*
  Title: Disable Menu Item for Non-Admin User Roles: Tools
  Category: User Roles and Restrictions
  Description: Add description here
*/

function remove_tools_menu_for_non_admins() {
    // Check if the current user is not an administrator
    if (!current_user_can('administrator')) {
        // Remove the "Tools" menu item
        remove_menu_page('tools.php');
    }
}

add_action('admin_menu', 'remove_tools_menu_for_non_admins');


?>
