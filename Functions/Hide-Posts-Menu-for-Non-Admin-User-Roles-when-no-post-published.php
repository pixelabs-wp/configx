<?php
/*
  Title: Hide Posts Menu for Non-Admin User Roles when no post published
  Category: User Roles and Restrictions
  Description: Add description here
*/

function hide_posts_menu_for_non_admins() {
    // Check if the current user is not an administrator
    if (!current_user_can('administrator')) {
        // Get the number of posts
        $post_count = wp_count_posts()->publish;

        // If there are no posts, remove the Posts menu
        if ($post_count == 0) {
            remove_menu_page('edit.php');
        }
    }
}

add_action('admin_menu', 'hide_posts_menu_for_non_admins');


?>