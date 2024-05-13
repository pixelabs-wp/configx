<?php
/*
  Title: Add Filesize to Media Library
  Category: Tweaks
  Description: Add description here
*/

function add_file_size_column_to_media_library($columns) {
    $columns['file_size'] = 'File Size';
    return $columns;
}

add_filter('manage_media_columns', 'add_file_size_column_to_media_library');

function display_file_size_column_in_media_library($column_name, $id) {
    if ('file_size' === $column_name) {
        $file_path = get_attached_file($id);
        
        if (file_exists($file_path)) {
            $file_size = filesize($file_path);

            if ($file_size < 1024) {
                echo $file_size . ' B';
            } elseif ($file_size < 1048576) {
                echo round($file_size / 1024, 2) . ' KB';
            } else {
                echo round($file_size / 1048576, 2) . ' MB';
            }
        } else {
            echo 'N/A';
        }
    }
}

add_action('manage_media_custom_column', 'display_file_size_column_in_media_library', 10, 2);


?>