<?php
namespace LearningCurve\BeansSimpleShortcodes;

/**********************************************************************************************************************
 **********************************************************************************************************************
 *
 *      [beans_post_tags]
 *
 * Shortcode that displays the post tag links list within a span element.
 *
 * Supported shortcode attributes are:
 *          before      Output before link but inside the span, default is 'Tagged with: '.
 *          after       Output after link but inside the span, default is empty string.
 *          sep         Separator string between tags, default is ', '.
 *          class       Additional classes to add to the span element, defaults to an empty string.
 *          style       Inline CSS styling to add to the span element, defaults to an empty string.
 *
 * Defaults pass through `post_tags_shortcode_defaults` filter.
 * Output passes through `post_tags_shortcode` filter before returning.
 *
 * @since   1.0
 *
 * @param   array|string $atts Shortcode attributes. Empty string if no attributes.
 *
 * @return  string $output Returns empty string if the `post_tag` taxonomy is not associated with the current post type.
 *                         Returns empty string if tag list is empty.
 *                         Returns empty string if calling tag list causes error.
 *                         Otherwise, returns output for [beans_post_tags] shortcode.
 */
function post_tags_shortcode( $atts ) {

	if ( ! is_object_in_taxonomy( get_post_type(), 'post_tag' ) ) {
		return '';
	}

	$defaults = array(
		'before' => __( 'Tagged with: ', BEANS_SIMPLE_SHORTCODES ),
		'after'  => '',
		'sep'    => ', ',
		'class'  => '',
		'style'  => '',
	);

	/**
	 * Post tags shortcode defaults filter.
	 *
	 * Allows the default args in the post tags shortcode function to be more easily filtered.
	 *
	 * @since   1.0
	 *
	 * @param   array $defaults The default args array.
	 */
	$defaults = apply_filters( 'post_tags_shortcode_defaults', $defaults );

	$atts = shortcode_atts( $defaults, $atts, 'post_tags' );

	$tags = get_the_tag_list( null, $atts['sep'] );

	if ( is_wp_error( $tags ) ) {
		return '';
	}

	if ( empty( $tags ) ) {
		return '';
	}

	// Use the output buffer to ensure everything renders in order
	ob_start();

	beans_open_markup_e( 'beans_simple_post_meta_tags', 'span', array(
		'class' => $atts['class'],
		'style' => 'color: inherit; ' . $atts['style'],
	) );

	beans_output_e( 'beans_simple_post_meta_tags_text_prefix', $atts['before'] );

	beans_output_e( 'beans_simple_post_meta_tags_text', $tags );

	beans_output_e( 'beans_simple_post_meta_tags_text_suffix', $atts['after'] );

	beans_close_markup_e( 'beans_simple_post_meta_tags', 'span' );

	$output = ob_get_clean();

	/**
	 * Post tags shortcode filter.
	 *
	 * Allows the output and the attributes of the post tags shortcode function to be filtered.
	 *
	 * @since   1.0
	 *
	 * @param   string $output   The returned output of the shortcode.
	 * @param   array  $defaults The shortcode attributes array.
	 */
	return apply_filters( 'post_tags_shortcode', $output, $atts );

}