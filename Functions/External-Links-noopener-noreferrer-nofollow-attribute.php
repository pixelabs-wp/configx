<?php
/*
  Title: External Links: rel="noopener noreferrer nofollow" attribute
  Category: Tweaks
  Description: Add description here
*/

function add_rel_to_external_links($content) {
    $site_url = get_bloginfo('url');

    // Use regular expression to find all external links
    $pattern = '/<a (?!.*? rel=)["\']?([^"\'>]+)["\']? href=["\']?((https?:\/\/|\/\/)[^"\'>]+)["\']?/i';
    $replacement = '<a $1 href="$2" rel="noopener noreferrer nofollow"';

    // Replace the links in content
    $content = preg_replace_callback($pattern, function($matches) use ($site_url) {
        if (strpos($matches[2], $site_url) === false) { // Check if the link is external
            return $replacement;
        } else {
            return $matches[0]; // Return the original link if it's internal
        }
    }, $content);

    return $content;
}

add_filter('the_content', 'add_rel_to_external_links');


?>