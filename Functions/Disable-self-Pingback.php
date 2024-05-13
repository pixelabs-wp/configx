<?php
/*
  Title: Disable self Pingback
  Category: Security
  Description: Add description here
*/

function disable_self_pingback( &$links ) {
    foreach ( $links as $l => $link ) {
        if ( 0 === strpos( $link, get_option( 'home' ) ) ) {
            unset( $links[$l] );
        }
    }
}

add_action( 'pre_ping', 'disable_self_pingback' );


?>