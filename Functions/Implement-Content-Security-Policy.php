<?php
/*
  Title: Implement Content Security Policy
  Category: Security
  Description: Add description here
*/

function add_content_security_policy_headers() {
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://ajax.googleapis.com; style-src 'self' 'unsafe-inline'; img-src 'self' data:; font-src 'self'; connect-src 'self';");
}

add_action('send_headers', 'add_content_security_policy_headers');


?>