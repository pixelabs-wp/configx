<?php
/*
  Title: Redirect 404 Error to Homepage
  Category: Tweaks
  Description: Add description here
*/

function redirect_404_to_homepage() {
    if (is_404()) {
        // Redirect all 404 errors to the homepage
        wp_redirect(home_url(), 301); 
        exit;
    }
}

add_action('template_redirect', 'redirect_404_to_homepage');


?>