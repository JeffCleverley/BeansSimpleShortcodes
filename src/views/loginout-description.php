<?php

$before_login    = __( '<p>before-login="" - Displayed before the login link (defaults to empty string).</p>', BEANS_SIMPLE_SHORTCODES );
$after_login     = __( '<p>after-login=""   - Displayed after the login link (defaults to empty string).</p>', BEANS_SIMPLE_SHORTCODES );
$before_logout   = __( '<p>before-logout="" - Displayed before the logout link (defaults to empty string).</p>', BEANS_SIMPLE_SHORTCODES );
$after_logout    = __( '<p>after-logout=""   - Displayed after the logout link (defaults to empty string).</p>', BEANS_SIMPLE_SHORTCODES );
$login_text      = __( '<p>login-text="" - The login link text (defaults is \'login\').</p>', BEANS_SIMPLE_SHORTCODES );
$logout_text     = __( '<p>logout-text=""   - The logout link text (defaults to  \'logout\').</p>', BEANS_SIMPLE_SHORTCODES );
$login_redirect  = __( '<p>login-redirect="" - Page to redirect to after login (defaults to empty string).</p>', BEANS_SIMPLE_SHORTCODES );
$logout_redirect = __( '<p>logout-redirect=""   - Page to redirect to after logout (defaults is homepage via home_url() ).</p>', BEANS_SIMPLE_SHORTCODES );


ob_start();

beans_output_e( "beans_simple_shortcodes_{$shortcode}_before_login_text", $before_login );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_after_login_text", $after_login );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_before_logout_text", $before_logout );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_after_logout_text", $after_logout );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_login_text", $login_text );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_logout_text", $logout_text );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_login_redirect", $login_redirect );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_logout_redirect", $logout_redirect );


return ob_get_clean();