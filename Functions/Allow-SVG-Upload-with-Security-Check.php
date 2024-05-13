<?php
/*
  Title: Allow SVG Upload with Security Check 
  Category: Security
  Description: Add description here
*/

function svg_upload_allow($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'svg_upload_allow');

function check_svg($checked, $file, $filename, $mimes) {
    if (!$checked['type']) {
        $check_filetype = wp_check_filetype($filename, $mimes);
        $ext = $check_filetype['ext'];
        $type = $check_filetype['type'];
        $proper_filename = $filename;

        if ($type && 0 === strpos($type, 'image/') && $ext !== 'svg') {
            $ext = $type = false;
        }

        $checked = compact('ext', 'type', 'proper_filename');
    }

    if ($checked['type'] === 'image/svg+xml') {
        // Run additional checks to validate the SVG file
        if (!svg_security_check($file)) {
            $checked = array('type' => false, 'ext' => false, 'proper_filename' => false);
        }
    }

    return $checked;
}
add_filter('wp_check_filetype_and_ext', 'check_svg', 10, 4);

function svg_security_check($file) {
    $svg = file_get_contents($file);

    // Check for malicious code in SVG
    if (strpos($svg, '<script') !== false) {
        return false;
    }

    return true;
}


?>