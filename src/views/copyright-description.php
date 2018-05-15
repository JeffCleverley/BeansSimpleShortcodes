<?php

$before     = __( '<p>before="" - Displayed before the Copyright notice (defaults to empty string).</p>', BEANS_SIMPLE_SHORTCODES );
$after      = __( '<p>after=""   - Displayed after the Copyright notice (defaults to empty string).</p>', BEANS_SIMPLE_SHORTCODES );
$copyright  = __( '<p>copyright="" - Copyright character (defaults to &#x000A9;).</p>', BEANS_SIMPLE_SHORTCODES );
$first_year = __( '<p>first-year="" - The year copyright first applies (defaults to empty string).</p>', BEANS_SIMPLE_SHORTCODES );

ob_start();

beans_output_e( "beans_simple_shortcodes_{$shortcode}_before_settings_text", $before );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_after_settings_text", $after );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_character", $copyright );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_first_year", $first_year );

return ob_get_clean();