<?php
/*----------------------------------------------------------------------------------------------- 
						Function to redirect user when user is not login - Start
----------------------------------------------------------------------------------------------- */

function restrict_access_to_change_password_page() {
    if ( ! is_user_logged_in() ) {
        if ( is_page( 'change-password' ) || is_page( 'any-other-page' ) ) {
            wp_redirect( home_url( '/login' ) );
            exit;
        }
    }
}
add_action( 'template_redirect', 'restrict_access_to_change_password_page' );

/*----------------------------------------------------------------------------------------------- 
						Function to redirect user when user is not login - End
----------------------------------------------------------------------------------------------- */