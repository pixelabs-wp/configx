<?php
/*
  Title: Replace Login Error Details to a generic message
  Category: Security
  Description: Add description here
*/

function hide_login_errors(){
    return "Login failed: check your information and try again.";
}
add_filter('login_errors', 'hide_login_errors');


?>