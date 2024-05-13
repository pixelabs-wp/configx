<?php
/*
  Title: Auto-Logout Idle Users after 15 Minutes
  Category: Security
  Description: Add description here
*/

function auto_logout_idle_users() {
    $idle_timeout = 900; // Define the idle timeout in seconds (15 minutes = 900 seconds)

    // Check if the user is logged in
    if (is_user_logged_in()) {
        $user = wp_get_current_user();
        $last_activity = get_user_meta($user->ID, 'last_activity', true);

        // Check if the user's last activity time is set and exceeds the idle timeout
        if (!empty($last_activity) && (time() - $last_activity) > $idle_timeout) {
            // Log the user out
            wp_logout();

            // Redirect to the login page or any other desired page
            wp_redirect(home_url('/login/')); // Replace '/login/' with the URL you want to redirect to
            exit();
        } else {
            // Update the user's last activity time
            update_user_meta($user->ID, 'last_activity', time());
        }
    }
}

add_action('init', 'auto_logout_idle_users');


?>