<?php
/*
  Title: Sanitize filename on upload
  Category: Tweaks
  Description: Add description here
*/

function sanitize_filename_on_upload($filename) {
    // Remove special characters
    $sanitized_filename = remove_accents($filename); // Convert accents to standard characters
    $sanitized_filename = preg_replace('/[^A-Za-z0-9-_. ]/', '', $sanitized_filename); // Remove any character that is not a letter, number, dash, underscore, period, or space
    $sanitized_filename = str_replace(array('\'', '"'), '', $sanitized_filename); // Remove single and double quotes
    $sanitized_filename = str_replace(' ', '-', $sanitized_filename); // Replace spaces with dashes

    // Lowercase the filename
    $sanitized_filename = strtolower($sanitized_filename);

    return $sanitized_filename;
}

add_filter('sanitize_file_name', 'sanitize_filename_on_upload', 10);


?>