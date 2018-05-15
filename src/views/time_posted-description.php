<?php

$before       = __( '<p>before="" - Displayed before the time (defaults to empty string).</p>', BEANS_SIMPLE_SHORTCODES );
$after        = __( '<p>after=""   - Displayed after the time (defaults to empty string).</p>', BEANS_SIMPLE_SHORTCODES );
$time_format  = __( '<p>time-format="" - Time format (defaults to current WordPress setting).</p>', BEANS_SIMPLE_SHORTCODES );
$time_formats = __( 'Acceptable time formats can be found here: ', BEANS_SIMPLE_SHORTCODES );
$time_formats .= '<a href="https://codex.wordpress.org/Formatting_Date_and_Time">https://codex.wordpress.org/Formatting_Date_and_Time</a>';

ob_start();

beans_output_e( "beans_simple_shortcodes_{$shortcode}_before_settings_text", $before );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_after_settings_text", $after );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_format", $time_format );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_alternative_formats", $time_formats );

return ob_get_clean();