<?php
/*
  Title: Disable Quick Edit for Non-Admin User Roles
  Category: User Roles and Restrictions
  Description: Add description here
*/

function remove_quick_edit_for_non_admins($actions, $post) {
    // Check if the current user is not an administrator
    if (!current_user_can('administrator')) {
        // Remove the Quick Edit link
        unset($actions['inline hide-if-no-js']);
    }
    return $actions;
}

add_filter('post_row_actions', 'remove_quick_edit_for_non_admins', 10, 2);
add_filter('page_row_actions', 'remove_quick_edit_for_non_admins', 10, 2);


?>