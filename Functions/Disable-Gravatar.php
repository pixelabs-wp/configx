<?php
/*
  Title: Disable Gravatar
  Category: Bloat Remover and Speed Optimization
  Description: Add description here
*/

function disable_gravatar($avatar, $id_or_email, $size, $default, $alt, $args) {
    // You can return an empty string to remove the avatar completely
    // return '';

    // Or return a path to a default image hosted on your server (optional)
    // return 'path_to_your_default_image';

    // For this example, let's just return a blank image
    return includes_url('images/blank.jpg');
}

add_filter('get_avatar', 'disable_gravatar', 10, 6);


?>