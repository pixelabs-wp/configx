<?php
/*
  Title: Automatically fills out alt text field based on image file name and automatically deletes the dash between the filename words
  Category: Tweaks
  Description: Add description here
*/

function set_image_alt_text_on_upload($attachment_id) {
    // Check if the attachment is an image
    if(wp_attachment_is_image($attachment_id)) {
        // Get the file name
        $file = get_attached_file($attachment_id);
        $file_name = pathinfo($file, PATHINFO_FILENAME);

        // Replace hyphens with spaces
        $alt_text = str_replace('-', ' ', $file_name);

        // Update the image's alt text
        update_post_meta($attachment_id, '_wp_attachment_image_alt', $alt_text);
    }
}
add_action('add_attachment', 'set_image_alt_text_on_upload');



?>