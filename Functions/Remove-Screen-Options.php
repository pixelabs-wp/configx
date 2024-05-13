<?php
/*
  Title: Remove Screen Options
  Category: User Roles and Restrictions
  Description: Add description here
*/

function remove_screen_options_tab() {
    if (!current_user_can('administrator')) {
        echo '<style type="text/css">
            #screen-options-link-wrap {
                display: none;
            }
        </style>';
    }
}

add_action('admin_head', 'remove_screen_options_tab');


?>