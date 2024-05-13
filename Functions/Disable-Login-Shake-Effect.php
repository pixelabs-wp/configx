<?php
/*
  Title: Disable Login Shake Effect
  Category: Security
  Description: Add description here
*/

function disable_login_shake() {
    remove_action('login_head', 'wp_shake_js', 12);
}
add_action('login_init', 'disable_login_shake');


?>
