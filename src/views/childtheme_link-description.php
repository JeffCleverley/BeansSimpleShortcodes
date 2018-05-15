<?php

$warning          = __( '<p>If CHILD_THEME_NAME and CHILD THEME URL are not defined shortcode is disabled. These Attributes may be overridden though.</p>', BEANS_SIMPLE_SHORTCODES );
$before           = __( '<p>before="" - Displayed before the date (defaults to empty string).</p>', BEANS_SIMPLE_SHORTCODES );
$after            = __( '<p>after=""   - Displayed after the date (defaults to empty string).</p>', BEANS_SIMPLE_SHORTCODES );
$child_theme_name = __( '<p>child-theme-name="" - Name of the child theme (defaults to defined CHILD_THEME_NAME).</p>', BEANS_SIMPLE_SHORTCODES );
$child_theme_url  = __( '<p>child-theme-url="" - URL of the child theme (defaults to defined CHILD_THEME_NAME).</p>', BEANS_SIMPLE_SHORTCODES );

ob_start();

beans_output_e( "beans_simple_shortcodes_{$shortcode}_warning_settings_text", $warning );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_before_settings_text", $before );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_after_settings_text", $after );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_name", $child_theme_name );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_url", $child_theme_url );

return ob_get_clean();