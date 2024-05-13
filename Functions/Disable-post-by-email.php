<?php
/*
  Title: Disable post by email
  Category: Security
  Description: Add description here
*/


function disable_post_by_email() {
    // Unset the Post by Email settings
    update_option('mailserver_url', '');
    update_option('mailserver_login', '');
    update_option('mailserver_pass', '');
    update_option('mailserver_port', '');
}

add_action('admin_init', 'disable_post_by_email');


?>