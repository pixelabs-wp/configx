<?php
function function_code_menu()
{
    // Check if the current user has the "administrator" role
    if (current_user_can('administrator')) {
        add_menu_page(
            'ConfigX', // Page Title
            'ConfigX', // Menu Title
            'manage_options',
            'config-x',
            'config_x_page', // Callback function to display the list of functions page
            'dashicons-admin-generic',
            25
        );
    }
}
add_action('admin_menu', 'function_code_menu');
?>
