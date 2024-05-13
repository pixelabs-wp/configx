<?php

/**
 * ConfigX
 *
 * @package       ConfigX
 * @author        Syed Ali Haider
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   ConfigX
 * Plugin URI:    https://www.your-site.com/
 * Description:   ConfigX
 * Version:       1.0.1
 * Author:        Syed Ali Haider
 * Author URI:    https://www.fiverr.com/syedali157
 * Text Domain:   config-x
 * Domain Path:   /languages
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;
// Plugin name
define('CONFIGX_NAME',            'ConfigX');

// Plugin version
define('CONFIGX_VERSION',        '1.0.0');

// Plugin Root File
define('CONFIGX_PLUGIN_FILE',    __FILE__);

// Plugin base
define('CONFIGX_PLUGIN_BASE',    plugin_basename(CONFIGX_PLUGIN_FILE));

// Plugin Folder Path
define('CONFIGX_PLUGIN_DIR',    plugin_dir_path(CONFIGX_PLUGIN_FILE));

// Plugin Folder URL
define('CONFIGX_PLUGIN_URL',    plugin_dir_url(CONFIGX_PLUGIN_FILE));


// Activation Hook
register_activation_hook(__FILE__, 'install_plugin_tables');
register_activation_hook(__FILE__, 'schedule_insert_data_cron');
register_deactivation_hook(__FILE__, 'unschedule_insert_data_cron');


// Create Tables On Activation
function install_plugin_tables()
{
    global $wpdb;

    // Your table names
    $table_name_functions = $wpdb->prefix . 'configx_functions_code';
    $table_name_categories = $wpdb->prefix . 'configx_function_categories';

    // SQL to create the 'configx_functions_code' table
    $sql_functions = "CREATE TABLE $table_name_functions (
        id INT NOT NULL AUTO_INCREMENT,
        function_name VARCHAR(255) NOT NULL,
        category VARCHAR(255) NOT NULL,
        code_snippet TEXT NOT NULL,
        description TEXT NOT NULL,
        file_path VARCHAR(255) NOT NULL,
        status VARCHAR(20) NOT NULL,
        PRIMARY KEY  (id)
    )";

    // SQL to create the 'configx_function_categories' table
    $sql_categories = "CREATE TABLE $table_name_categories (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        PRIMARY KEY  (id)
    )";

    // Include upgrade.php to use dbDelta()
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    // Execute the SQL queries
    dbDelta($sql_functions);
    dbDelta($sql_categories);

    // Read PHP files in the 'functions' folder and insert data
    insert_data_from_functions_folder();
}

// Add Data in Tables From Files
function insert_data_from_functions_folder()
{
    global $wpdb;

    // Define the folder path
    $folder_path = plugin_dir_path(__FILE__) . 'Functions';

    // Get PHP files in the 'functions' folder
    $php_files = glob($folder_path . '/*.php');

    // Loop through each PHP file
    foreach ($php_files as $php_file) {
        // Read file contents
        $file_contents = file_get_contents($php_file);

        // Extract metadata (adjust the regular expression based on your file structure)
        preg_match_all('/\/\*\s*(.*?)\s*\*\//s', $file_contents, $matches);


        $metadata = array();
        foreach ($matches[1] as $match) {
            $lines = explode("\n", $match);
            foreach ($lines as $line) {
                $parts = explode(':', $line, 2);
                if (count($parts) === 2) {
                    $metadata[trim($parts[0])] = trim($parts[1]);
                }
            }
        }

        // Extract code snippet
        $code_snippet = $wpdb->prepare('%s', $file_contents);

        // Insert data into the 'configx_functions_code' table
        $function_name = $metadata['Title'] ?? '';
        $category = $metadata['Category'] ?? '';
        $description = $metadata['Description'] ?? '';
        $file_path = $php_file;
        $status = 'inactive';  // You can set a default status
        $filename = 'Functions/' . basename($file_path);

        $existing_function = $wpdb->get_var($wpdb->prepare("SELECT id FROM " . $wpdb->prefix . "configx_functions_code WHERE function_name = %s", $function_name));
        if (!$existing_function) {
            $wpdb->insert(
                $wpdb->prefix . 'configx_functions_code',
                array(
                    'function_name' => $function_name,
                    'category' => $category,
                    'code_snippet' => $code_snippet,
                    'description' => $description,
                    'file_path' => $filename,
                    'status' => $status,
                )
            );

            // Insert category into the 'configx_function_categories' table if it doesn't exist
            $category_exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM " . $wpdb->prefix . "configx_function_categories WHERE name = %s", $category));

            if (!$category_exists) {
                $wpdb->insert(
                    $wpdb->prefix . 'configx_function_categories',
                    array(
                        'name' => $category,
                    )
                );
            }
        } else {
            // Function with the same name already exists, handle accordingly
            // You may want to log an error, update the existing record, or take other actions
            // For now, let's log an error message
            error_log('Function with name ' . $function_name . ' already exists in the database.');
        }
    }
}

// Import File Function
add_action('wp_ajax_handle_file_upload', 'handle_file_upload_ajax');
function handle_file_upload_ajax()
{
    // Check nonce for security
    // Handle the file upload and move it to the desired location
    if (!empty($_FILES['file'])) {
        $file = $_FILES['file'];
        global $wpdb;
        // Use the WordPress upload directory
        $upload_dir = wp_upload_dir();
        $upload_path = $upload_dir['path'] . '/' . $file['name'];
        $table_name_functions = $wpdb->prefix . 'configx_functions_code';
        if (move_uploaded_file($file['tmp_name'],  $upload_path)) {
            $data = file_get_contents($upload_path);
            $json_data = json_decode($data);
            foreach ($json_data as $value) {
                $wpdb->update(
                    $table_name_functions,
                    array('status' => $value->status),
                    array('function_name' => $value->function_name)
                );
            }
        } else {
            // File upload failure
            wp_send_json_error(array('message' => 'Failed to upload file.'));
        }
    } else {
        // No file uploaded
        wp_send_json_error(array('message' => 'No file uploaded.'));
    }
}

//Update All Status Function
add_action('wp_ajax_update_all_functions_status', 'update_all_functions_status');
add_action('wp_ajax_nopriv_update_all_functions_status', 'update_all_functions_status');
function update_all_functions_status()
{
    global $wpdb;
    $table_name_functions = $wpdb->prefix . 'configx_functions_code';

    // Handle the AJAX request to update all functions here
    $functionsData = json_decode(file_get_contents("php://input"), true);

    foreach ($functionsData as $functionData) {
        $function_id = isset($functionData['functionId']) ? intval($functionData['functionId']) : 0;
        $new_status = isset($functionData['newStatus']) ? sanitize_text_field($functionData['newStatus']) : '';

        $wpdb->update(
            $table_name_functions,
            array('status' => $new_status),
            array('id' => $function_id)
        );
    }

    // Send a response back to the JavaScript
    $response = array('success' => true);
    wp_send_json($response);
}

//On Check Update Function
add_action('wp_ajax_insert_data_from_functions_folder', 'insert_data_from_functions_folder_oncheck');
add_action('wp_ajax_nopriv_insert_data_from_functions_folder', 'insert_data_from_functions_folder_oncheck');
function insert_data_from_functions_folder_oncheck()
{
    // Your existing function code here...

    global $wpdb;

    // Define the folder path
    $folder_path = plugin_dir_path(__FILE__) . 'Functions';

    // Get PHP files in the 'functions' folder
    $php_files = glob($folder_path . '/*.php');
    $id = 0;
    // Loop through each PHP file
    foreach ($php_files as $php_file) {
        // Read file contents
        $file_contents = file_get_contents($php_file);
        
        // Extract metadata (adjust the regular expression based on your file structure)
        preg_match_all('/\/\*\s*(.*?)\s*\*\//s', $file_contents, $matches);
        $metadata = array();
        foreach ($matches[1] as $match) {
            $lines = explode("\n", $match);
            foreach ($lines as $line) {
                $parts = explode(':', $line, 2);
                if (count($parts) === 2) {
                    $metadata[trim($parts[0])] = trim($parts[1]);
                }
            }
        }

        // Extract code snippet
        $code_snippet = $wpdb->prepare('%s', $file_contents);

        // Insert data into the 'configx_functions_code' table
        $function_name = $metadata['Title'] ?? '';
        $category = $metadata['Category'] ?? '';
        $description = $metadata['Description'] ?? '';
        $file_path = $php_file;
        $status = 'inactive';  // You can set a default status
        $filename = 'Functions/' . basename($file_path);

        $existing_function = $wpdb->get_var($wpdb->prepare("SELECT id FROM " . $wpdb->prefix . "configx_functions_code WHERE function_name = %s", $function_name));
        if (!$existing_function) {
            $wpdb->insert(
                $wpdb->prefix . 'configx_functions_code',
                array(
                    'function_name' => $function_name,
                    'category' => $category,
                    'code_snippet' => $code_snippet,
                    'description' => $description,
                    'file_path' => $filename,
                    'status' => $status,
                )
            );

            // Insert category into the 'configx_function_categories' table if it doesn't exist
            $category_exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM " . $wpdb->prefix . "configx_function_categories WHERE name = %s", $category));

            if (!$category_exists) {
                $wpdb->insert(
                    $wpdb->prefix . 'configx_function_categories',
                    array(
                        'name' => $category,
                    )
                );
            }
           
        } else {
            // Function with the same name already exists, handle accordingly
            // You may want to log an error, update the existing record, or take other actions
            // For now, let's log an error message
            error_log('Function with name ' . $function_name . ' already exists in the database.');
        }
        $id = $id + 1;

       
    }
     // Send a response back to the JavaScript
     $response = array('success' => " $id");
     wp_send_json($response);
}

// Export Jsons Function
add_action('wp_ajax_export_data', 'export_data_callback');
add_action('wp_ajax_nopriv_export_data', 'export_data_callback');
function export_data_callback()
{
    global $wpdb;
    $table_name_functions = $wpdb->prefix . 'configx_functions_code';

    // Fetch data from the custom table
    $functions = $wpdb->get_results("SELECT * FROM $table_name_functions", ARRAY_A);

    // Convert the data to JSON
    $json_data = json_encode($functions, JSON_PRETTY_PRINT);

    // Set the response headers for JSON download
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="exported_data.json"');

    // Output the JSON data
    echo $json_data;

    // Make sure to exit after outputting the data
    wp_die();
}

//Enque Js File
function add_script_to_menu_page()
{
    // loading js
    wp_register_script('configx-custom', CONFIGX_PLUGIN_URL . 'custom.js', array('jquery'), false, true);
    wp_enqueue_script('configx-custom');
}

add_action('admin_enqueue_scripts', 'add_script_to_menu_page');
include_once(plugin_dir_path(__FILE__) . 'admin-page.php');
include_once(plugin_dir_path(__FILE__) . 'list-function.php');
include_once(plugin_dir_path(__FILE__) . 'xml.php');

//cron Job Function

function schedule_insert_data_cron() {
    // Check if the cron job is not already scheduled
    if (!wp_next_scheduled('insert_data_cron_event')) {
        // Schedule the cron job to run hourly (you can adjust the schedule as needed)
        wp_schedule_event(time(), 'hourly', 'insert_data_cron_event');
    }
}

// Hook the cron job function to the scheduled event
add_action('insert_data_cron_event', 'insert_data_from_functions_folder_oncheck');

// Unschedule the cron job on plugin deactivation

function unschedule_insert_data_cron() {
    // Unschedule the cron job when the plugin is deactivated
    wp_clear_scheduled_hook('insert_data_cron_event');
}

/**
 * Load the main class for the core functionality
 */
require_once CONFIGX_PLUGIN_DIR . 'core/class-configx.php';

/**
 * The main function to load the only instance
 * of our master class.
 *
 * @author  Syed Ali Haider
 * @since   1.0.0
 * @return  object|Config_X
 */
function CONFIGX()
{
    return Config_X::instance();
}

function load_function()
{
    global $wpdb;

    // Fetch data from the configx_functions_code table
    $table_name = $wpdb->prefix . 'configx_functions_code';
    $functions = $wpdb->get_results("SELECT * FROM " . $table_name . " WHERE status = 'active'");

    foreach ($functions as $function) {
        try {
            // Attempt to include the file
            ob_start();
            include CONFIGX_PLUGIN_DIR . $function->file_path;
            ob_end_clean();
        } catch (Exception $e) {
            // Handle the error: log the error message
            error_log('Error including file ' . $function->file_path . ': ' . $e->getMessage());

            // Change the status in the database to 0
            $wpdb->update('configx_functions_code', array('status' => 0), array('id' => $function->id));

            // Echo an error message
            echo 'Error including file ' . $function->file_path . ': ' . $e->getMessage() . '<br>';
        }
    }
}

add_action('init', 'load_function');


CONFIGX();
