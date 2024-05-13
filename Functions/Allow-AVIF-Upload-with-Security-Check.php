<?php
/*
  Title: Allow AVIF Upload with Security Check 
  Category: Security
  Description: Add description here
*/

function allow_avif_upload($mimes) {
    $mimes['avif'] = 'image/avif';
    return $mimes;
}
add_filter('upload_mimes', 'allow_avif_upload');

function check_avif_upload($file, $filename, $mimeType) {
    // Check if the uploaded file is an AVIF file
    if ($mimeType === 'image/avif') {
        // Perform a basic security check: getimagesize() function.
        // Note: This is a basic check and might not detect all kinds of malicious content.
        if (false === getimagesize($file)) {
            // If getimagesize() fails, then it's not a valid image file.
            return [
                'error' => 'The uploaded file is not a valid AVIF image.'
            ];
        }
    }
    return $file;
}
add_filter('wp_handle_upload_prefilter', 'check_avif_upload');


?>