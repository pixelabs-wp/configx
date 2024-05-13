<?php
/*
  Title: Revisions Control (max. revisions of 50)
  Category: Bloat Remover and Speed Optimization
  Description: Add description here
*/

function limit_post_revisions($num, $post) {
    if ($post->post_type == 'post' || $post->post_type == 'page') {
        return 50; // Change this number to your desired maximum number of revisions
    }
    return $num;
}

add_filter('wp_revisions_to_keep', 'limit_post_revisions', 10, 2);


?>