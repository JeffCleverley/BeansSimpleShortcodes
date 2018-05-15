<?php

$before   = __( '<p>before="" - Displayed before the taxonomy terms link list (defaults to \'Filed under: \').</p>', BEANS_SIMPLE_SHORTCODES );
$after    = __( '<p>after=""   - Displayed after the taxonomy terms link list (defaults to empty string).</p>', BEANS_SIMPLE_SHORTCODES );
$sep      = __( '<p>sep=""   - Separator displayed between items in the list (defaults to \', \').</p>', BEANS_SIMPLE_SHORTCODES );
$taxonomy = __( '<p>taxonomy=""   - Name of the taxonomy to display (defaults to \'category\').</p>', BEANS_SIMPLE_SHORTCODES );


ob_start();

beans_output_e( "beans_simple_shortcodes_{$shortcode}_before_settings_text", $before );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_after_settings_text", $after );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_separator", $sep );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_taxonomy", $taxonomy );

return ob_get_clean();