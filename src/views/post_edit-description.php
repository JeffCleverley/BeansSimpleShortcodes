<?php

$before = __( '<p>before="" - Displayed before the post edit link (defaults to empty string).</p>', BEANS_SIMPLE_SHORTCODES );
$after  = __( '<p>after=""  - Displayed after the post edit link (defaults to empty string).</p>', BEANS_SIMPLE_SHORTCODES );
$link   = __( '<p>link=""   - Link text to be displayed (defaults to \'(Edit)\').</p>', BEANS_SIMPLE_SHORTCODES );


ob_start();

beans_output_e( "beans_simple_shortcodes_{$shortcode}_before_settings_text", $before );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_after_settings_text", $after );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_link_text", $link );

return ob_get_clean();