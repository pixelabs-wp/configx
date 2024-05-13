<?php
/*
  Title: Disable Comments on Posts, Pages and Media
  Category: User Roles and Restrictions
  Description: Add description here
*/


function disable_comments_on_all_types() {
    // Disable comments on future posts
    update_option('default_comment_status', 'closed');

    // Close comments on existing posts, pages and attachments
    global $wpdb;
    $wpdb->query( $wpdb->prepare("UPDATE $wpdb->posts SET comment_status = 'closed', ping_status = 'closed' WHERE post_type IN ('post', 'page', 'attachment')") );
}

// Run the function upon theme setup or plugin activation
add_action('after_setup_theme', 'disable_comments_on_all_types');


?>