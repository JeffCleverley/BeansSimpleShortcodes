<?php

$before        = __( '<p>before="" - Displayed before the link to the post comments (defaults to empty string).</p>', BEANS_SIMPLE_SHORTCODES );
$after         = __( '<p>after=""   - Displayed after the link to the post comments (defaults to empty string).</p>', BEANS_SIMPLE_SHORTCODES );
$no_comments   = __( '<p>no-comments="" - Text when there are no comments (defaults to \'Leave a comment\').</p>', BEANS_SIMPLE_SHORTCODES );
$one_comment   = __( '<p>one-comment=""   - Text when there is one comment (defaults to \'1 comment\').</p>', BEANS_SIMPLE_SHORTCODES );
$more_comments = __( '<p>more-comments="" - Text when there are multiple comments (defaults to \'%s comments\').</p>', BEANS_SIMPLE_SHORTCODES );

ob_start();

beans_output_e( "beans_simple_shortcodes_{$shortcode}_before_settings_text", $before );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_after_settings_text", $after );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_no_comments_text", $no_comments );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_one_comment_text", $one_comment );
beans_output_e( "beans_simple_shortcodes_{$shortcode}_more_comments_text", $more_comments );

return ob_get_clean();