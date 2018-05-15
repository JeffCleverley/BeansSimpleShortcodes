<?php

$before    = __( '<p>before="" - Displayed before the theme Beans framework link (defaults to empty string).</p>', BEANS_SIMPLE_SHORTCODES );
$after     = __( '<p>after=""   - Displayed after the theme Beans framework link (defaults to empty string).</p>', BEANS_SIMPLE_SHORTCODES );
$beans     = __( '<p>beans="" - Name of the Beans theme framework (defaults to \'Beans\').</p>', BEANS_SIMPLE_SHORTCODES );
$beans_url = __( '<p>beans-url="" - URL of the Beans theme framework (defaults to \'https://getbeans.io\').</p>', BEANS_SIMPLE_SHORTCODES );

ob_start();

beans_output_e( "beans_simple_shortcodes_{$shortcode}_before_settings_text", $before );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_after_settings_text", $after );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_text", $beans );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_url", $beans_url );

return ob_get_clean();