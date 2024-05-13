<?php
/*
  Title: Limit Login Attempts
  Category: Security
  Description: Add description here
*/

function limit_login_attempts($user, $username, $password) {
    // Identifier for the user based on username
    $user_transient = 'failed_login_' . md5($username);

    if (get_transient($user_transient)) {
        return new WP_Error('too_many_failed_logins', 'You have reached the maximum number of login attempts. Please try again in 24 hours.');
    }

    return $user;
}
add_filter('authenticate', 'limit_login_attempts', 30, 3);

function track_login_failures($username) {
    // Identifier for the user based on username
    $user_transient = 'failed_login_' . md5($username);

    // Get current failure count
    $failures = get_transient($user_transient) ? get_transient($user_transient) : 0;

    if ($failures < 9) {
        // Increment the failure count and set/extend the transient
        set_transient($user_transient, $failures + 1, HOUR_IN_SECONDS * 24);
    } else {
        // Block further login attempts for 24 hours
        set_transient($user_transient, 'locked', DAY_IN_SECONDS);
    }
}
add_action('wp_login_failed', 'track_login_failures');


?>