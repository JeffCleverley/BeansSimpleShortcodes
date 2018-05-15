<?php

$before        = __( '<p>before="" - Displayed before the WordPress.org link (defaults to empty string).</p>', BEANS_SIMPLE_SHORTCODES );
$after         = __( '<p>after=""   - Displayed after the WordPress.org link (defaults to empty string).</p>', BEANS_SIMPLE_SHORTCODES );
$wordpress     = __( '<p>wordpress="" - WordPress, the one and only (defaults to \'WordPress\').</p>', BEANS_SIMPLE_SHORTCODES );
$wordpress_url = __( '<p>wordpress-url="" - URL of WordPress.org (defaults to \'https://wordpress.org\').</p>', BEANS_SIMPLE_SHORTCODES );

ob_start();

beans_output_e( "beans_simple_shortcodes_{$shortcode}_before_settings_text", $before );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_after_settings_text", $after );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_text", $wordpress );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_url", $wordpress_url );

return ob_get_clean();