<?php

$before = __( '<p>before="" - Displayed before the category link list (defaults to \'Filed under: \').</p>', BEANS_SIMPLE_SHORTCODES );
$after  = __( '<p>after=""   - Displayed after the category link list (defaults to empty string).</p>', BEANS_SIMPLE_SHORTCODES );
$sep    = __( '<p>sep=""   - Displayed between items in the category list (defaults to \', \').</p>', BEANS_SIMPLE_SHORTCODES );


ob_start();

beans_output_e( "beans_simple_shortcodes_{$shortcode}_before_settings_text", $before );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_after_settings_text", $after );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_separator", $sep );

return ob_get_clean();