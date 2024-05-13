<?php
/*
  Title: Disable Auto-Updates of WordPress
  Category: Tweaks
  Description: Add description here
*/

function disable_all_automatic_updates( $value ) {
    return true;
}

add_filter('automatic_updater_disabled', 'disable_all_automatic_updates');


?>