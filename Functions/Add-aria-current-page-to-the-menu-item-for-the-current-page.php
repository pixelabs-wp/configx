<?php
/*
  Title: Add aria-current="page" to the menu item for the current page
  Category: Tweaks
  Description: Add description here
*/

function add_aria_current_attr_to_nav_menu($atts, $item, $args) {
    // Check if the menu item is the current item
    if (isset($item->current) && $item->current) {
        $atts['aria-current'] = 'page';
    }
    return $atts;
}

add_filter('nav_menu_link_attributes', 'add_aria_current_attr_to_nav_menu', 10, 3);


?>