<?php
/*
  Title: Disable XMLRPC 
  Category: Security
  Description: Add description here
*/

function disable_xmlrpc() {
    // Disable XML-RPC
    add_filter('xmlrpc_enabled', '__return_false');

    // Optional: Remove xmlrpc.php from the HTTP headers
    remove_action('wp_head', 'rsd_link');
}
add_action('init', 'disable_xmlrpc');


?>