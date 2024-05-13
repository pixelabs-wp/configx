<?php
/*
  Title: Remove the ability to upload video files to the Media Library
  Category: User Roles and Restrictions
  Description: Add description here
*/

function disallow_video_uploads($mime_types) {
    // Video mime types to remove
    $video_mimes = array(
        'mp4'  => 'video/mp4',
        'm4v'  => 'video/mp4',
        'mov'  => 'video/quicktime',
        'wmv'  => 'video/x-ms-wmv',
        'avi'  => 'video/x-msvideo',
        'mpg'  => 'video/mpeg',
        'ogv'  => 'video/ogg',
        '3gp'  => 'video/3gpp',
        '3g2'  => 'video/3gpp2',
        'flv'  => 'video/x-flv',
        'mkv'  => 'video/x-matroska',
        'webm' => 'video/webm'
    );

    // Remove video mime types
    foreach ($video_mimes as $ext => $mime) {
        unset($mime_types[$ext]);
    }

    return $mime_types;
}

add_filter('upload_mimes', 'disallow_video_uploads', 1, 1);


?>