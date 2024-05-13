<?php
/*
  Title: Add date of last login to each user
  Category: Tweaks
  Description: Add description here
*/

function update_last_login( $user_login, $user ) {
    // Update user meta with the current timestamp
    update_user_meta( $user->ID, 'last_login', current_time('mysql') );
}

add_action('wp_login', 'update_last_login', 10, 2);

function add_last_login_column( $columns ) {
    $columns['last_login'] = 'Last Login';
    return $columns;
}

add_filter('manage_users_columns', 'add_last_login_column');

function show_last_login_column_content( $value, $column_name, $user_id ) {
    if ( 'last_login' == $column_name ) {
        return get_user_meta( $user_id, 'last_login', true );
    }
    return $value;
}

add_action('manage_users_custom_column', 'show_last_login_column_content', 10, 3);


?>