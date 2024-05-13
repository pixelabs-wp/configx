<?php
/*
  Title: HTTP Security Headers
  Category: Security
  Description: Add description here
*/

function add_http_security_headers() {
    // Set X-Content-Type-Options header
    header('X-Content-Type-Options: nosniff');

    // Set X-Frame-Options header to prevent clickjacking
    header('X-Frame-Options: SAMEORIGIN');

    // Set Content-Security-Policy header
    $csp_directives = array(
        "default-src 'self'",
        "script-src 'self' 'unsafe-inline' 'unsafe-eval'",
        "style-src 'self' 'unsafe-inline'",
        "img-src 'self' data:",
        "font-src 'self'",
        "frame-ancestors 'self'",
    );

    header('Content-Security-Policy: ' . implode(';', $csp_directives));

    // Set Referrer-Policy header
    header('Referrer-Policy: no-referrer-when-downgrade');
}

add_action('send_headers', 'add_http_security_headers');


?>