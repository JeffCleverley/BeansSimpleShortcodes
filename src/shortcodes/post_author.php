<?php

namespace LearningCurve\BeansSimpleShortcodes;

/**********************************************************************************************************************
 **********************************************************************************************************************
 *
 *      [beans_post_author]
 *
 * Shortcode that displays the unlinked post author's name in a span element.
 *
 * Supported shortcode attributes are:
 *          before      Output before the post author's name inside the span, default is 'By '.
 *          after       Output  after the post author's name inside the span, default is an empty string.
 *          class       Additional classes to add to the span element, defaults to an empty string.
 *          style       Inline CSS styling to add to the span element, defaults to an empty string.
 *
 * Output passes through `post_author_shortcode` filter before returning.
 *
 * @since   1.0
 *
 * @param   array|string $atts Array of shortcode attribute values. Empty String if no submitted attributes.
 *
 * @return  string $output Return empty string if the post type doesn't support 'author'.
 *                         Return empty string if post has no author assigned.
 *                         Otherwise return output for [beans_post_author] shortcode.
 */
function post_author_shortcode( $atts ) {

	if ( ! post_type_supports( get_post_type(), 'author' ) ) {
		return '';
	}

	$author = get_the_author();

	if ( ! $author ) {
		return '';
	}

	$defaults = array(
		'before' => __( 'By ', BEANS_SIMPLE_SHORTCODES ),
		'after'  => '',
		'class'  => '',
		'style'  => '',
	);

	/**
	 * Post author shortcode defaults filter.
	 *
	 * Allows the default args in the post author shortcode function to be more easily filtered.
	 *
	 * @since   1.0
	 *
	 * @param   array $defaults The default args array.
	 */
	$defaults = apply_filters( 'post_author_shortcode_defaults', $defaults );

	$atts = shortcode_atts( $defaults, $atts, 'post_author' );

	$author = esc_html( $author );

	// Use the output buffer to ensure everything renders in order
	ob_start();

	beans_open_markup_e( 'beans_simple_post_meta_author_span', 'span', array(
		'class' => $atts['class'],
		'style' => 'color: inherit; ' . $atts['style'],
		'itemprop'  => 'author',
		'itemscope' => '',
		'itemtype'  => 'http://schema.org/Person',
	) );

	beans_output_e( 'beans_simple_post_meta_author_prefix', $atts['before'] );

	beans_output_e( 'beans_simple_post_meta_author_text', $author );

	beans_selfclose_markup_e( 'beans_simple_post_meta_author_name_meta', 'meta', array(
		'itemprop' => 'name',
		'content'  => $author,
	) );

	beans_output_e( 'beans_simple_post_meta_author_suffix', $atts['after'] );

	beans_close_markup_e( 'beans_simple_post_meta_author_span', 'span' );

	$output = ob_get_clean();

	/**
	 * Post author shortcode filter.
	 *
	 * Allows the output and the attributes of the post author shortcode function to be filtered.
	 *
	 * @since   1.0
	 *
	 * @param   string $output   The returned output of the shortcode.
	 * @param   array  $defaults The shortcode attributes array.
	 */
	return apply_filters( 'post_author_shortcode', $output, $atts );

}