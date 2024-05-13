<?php
/*
  Title: Disable Menu Item for Non-Admin User Roles: Site Health
  Category: User Roles and Restrictions
  Description: Add description here
*/

function remove_site_health_menu_for_non_admins() {
    // Check if the current user is not an administrator
    if (!current_user_can('administrator')) {
        // Remove the "Site Health" menu item
        remove_submenu_page('tools.php', 'site-health.php');
    }
}

add_action('admin_menu', 'remove_site_health_menu_for_non_admins');


?>