<?php
/*
  Title: Show the featured images in the admin page list
  Category: Tweaks
  Description: Add description here
*/

function add_featured_image_column_to_pages( $columns ) {
    // Add a new column with the title 'Featured Image'
    $columns['featured_image'] = 'Featured Image';
    return $columns;
}

add_filter('manage_pages_columns', 'add_featured_image_column_to_pages');

function show_featured_image_column_content_for_pages( $column, $post_id ) {
    // Check if the current column is the 'Featured Image' column
    if ( 'featured_image' == $column ) {
        // Get the featured image
        $post_thumbnail = get_the_post_thumbnail($post_id, array(50, 50));

        // Show the featured image, or display a placeholder or message if none is set
        if ($post_thumbnail) {
            echo $post_thumbnail;
        } else {
            echo 'No featured image set';
        }
    }
}

add_action('manage_pages_custom_column', 'show_featured_image_column_content_for_pages', 10, 2);


?>