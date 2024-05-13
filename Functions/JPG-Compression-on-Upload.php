<?php
/*
  Title: JPG Compression on Upload
  Category: Bloat Remover and Speed Optimization
  Description: Add description here
*/

function set_custom_jpeg_compression_quality($quality) {
    // Set the JPEG compression level to 70%
    return 70;
}

add_filter('jpeg_quality', 'set_custom_jpeg_compression_quality');


?>