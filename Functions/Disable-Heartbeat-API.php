<?php
/*
  Title: Disable Heartbeat API
  Category: Bloat Remover and Speed Optimization
  Description: Add description here
*/

function disable_heartbeat_api() {
    wp_deregister_script('heartbeat');
}

add_action('init', 'disable_heartbeat_api');


?>