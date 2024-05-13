<?php
/*
  Title: Rename blog post Uncategorized category into News
  Category: Tweaks
  Description: Add description here
*/

function rename_uncategorized_to_news() {
    // Get the 'Uncategorized' category data
    $uncategorized = get_term_by('name', 'Uncategorized', 'category');

    // Check if 'Uncategorized' category exists
    if ($uncategorized) {
        // Rename 'Uncategorized' to 'News'
        wp_update_term($uncategorized->term_id, 'category', array(
            'name' => 'News',
            'slug' => 'news'
        ));
    }
}

// Hook the function to WordPress initialization
add_action('init', 'rename_uncategorized_to_news');


?>