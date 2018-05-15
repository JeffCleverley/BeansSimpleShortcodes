<?php

$before = __( '<p>before="" - Displayed before the site title (defaults to empty string).</p>', BEANS_SIMPLE_SHORTCODES );
$after  = __( '<p>after=""   - Displayed after the site title (defaults to empty string).</p>', BEANS_SIMPLE_SHORTCODES );

ob_start();

beans_output_e( "beans_simple_shortcodes_{$shortcode}_before_settings_text", $before );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_after_settings_text", $after );

return ob_get_clean();