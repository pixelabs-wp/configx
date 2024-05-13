<?php
/*
  Title: Limit Access to WP REST API
  Category: Security
  Description: Add description here
*/

function restrict_rest_api_access() {
    // Check if the user is not logged in
    if (!is_user_logged_in()) {
        // Disable REST API for non-authenticated users
        add_filter('rest_authentication_errors', function () {
            return new WP_Error('rest_api_access_denied', __('REST API access is restricted for non-authenticated users.'), array('status' => rest_authorization_required_code()));
        });
    }
}

add_action('init', 'restrict_rest_api_access');


?>