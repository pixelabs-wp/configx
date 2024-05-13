<?php
/*
  Title: Hides Admin Notifications for Non-Admin User Roles
  Category: User Roles and Restrictions
  Description: Add description here
*/

function hide_admin_notifications_for_non_admins() {
    if (!current_user_can('administrator')) {
        echo '<style>
            .update-nag, .updated, .error, .is-dismissible { 
                display: none !important; 
            }
        </style>';
    }
}

add_action('admin_head', 'hide_admin_notifications_for_non_admins');


?>