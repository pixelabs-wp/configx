<?php
/*
  Title: Hide Help in wp-admin
  Category: Branding and Design
  Description: Add description here
*/

function hide_help_tab() {
    echo '<style>
        #contextual-help-link-wrap { display: none !important; }
    </style>';
}
add_action('admin_head', 'hide_help_tab');


?>