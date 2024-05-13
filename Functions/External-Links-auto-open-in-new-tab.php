<?php
/*
  Title: External Links: auto open in new tab
  Category: Tweaks
  Description: Add description here
*/

function open_external_links_in_new_tab($content) {
    // Get the site URL to check against external links
    $site_url = parse_url(get_bloginfo('url'), PHP_URL_HOST);

    // Use a regular expression to find all links in the content
    $pattern = '/<a (?!.*? target=)["\']?([^"\'>]+)["\']? href=["\']?((https?:\/\/|\/\/)[^"\'>]+)["\']?/i';
    $replacement = '<a $1 href="$2" target="_blank"';

    // Replace the links in the content
    $content = preg_replace_callback($pattern, function ($matches) use ($site_url) {
        if (strpos($matches[2], $site_url) === false) { // Check if the link is external
            return $replacement;
        } else {
            return $matches[0]; // Return the original link if it's internal
        }
    }, $content);

    return $content;
}

add_filter('the_content', 'open_external_links_in_new_tab');


?>