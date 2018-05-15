<?php

$before       = __( '<p>before="" - Displayed before the updated date (defaults to empty string).</p>', BEANS_SIMPLE_SHORTCODES );
$after        = __( '<p>after=""   - Displayed after the updated date (defaults to empty string).</p>', BEANS_SIMPLE_SHORTCODES );
$date_format  = __( '<p>date-format="" - Date format (defaults to current WordPress setting).</p>', BEANS_SIMPLE_SHORTCODES );
$date_formats = __( 'Acceptable date formats can be found here: ', BEANS_SIMPLE_SHORTCODES );
$date_formats .= '<a href="https://codex.wordpress.org/Formatting_Date_and_Time">https://codex.wordpress.org/Formatting_Date_and_Time</a>';

ob_start();

beans_output_e( "beans_simple_shortcodes_{$shortcode}_before_settings_text", $before );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_after_settings_text", $after );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_format", $date_format );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_alternative_formats", $date_formats );

return ob_get_clean();