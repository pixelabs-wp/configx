<?php
/*
  Title: Add custom CSS box for Pages and Posts
  Category: Tweaks
  Description: Add description here
*/

// Add meta box
function add_custom_css_meta_box() {
    $screens = ['post', 'page'];
    foreach ($screens as $screen) {
        add_meta_box(
            'custom_css_box',          // Unique ID
            'Custom CSS',              // Box title
            'custom_css_meta_box_html', // Content callback
            $screen                    // Post type
        );
    }
}
add_action('add_meta_boxes', 'add_custom_css_meta_box');

// HTML for the meta box
function custom_css_meta_box_html($post) {
    $custom_css = get_post_meta($post->ID, '_custom_css', true);
    echo '<textarea style="width:100%;" id="custom_css" name="custom_css">'.esc_textarea($custom_css).'</textarea>';
}

// Save the CSS
function save_post_custom_css($post_id) {
    if (array_key_exists('custom_css', $_POST)) {
        update_post_meta(
            $post_id,
            '_custom_css',
            $_POST['custom_css']
        );
    }
}
add_action('save_post', 'save_post_custom_css');

// Enqueue the CSS in the frontend
function enqueue_custom_css() {
    if (is_singular()) {
        global $post;
        $custom_css = get_post_meta($post->ID, '_custom_css', true);
        if (!empty($custom_css)) {
            echo '<style type="text/css">'.$custom_css.'</style>';
        }
    }
}
add_action('wp_head', 'enqueue_custom_css');


?>