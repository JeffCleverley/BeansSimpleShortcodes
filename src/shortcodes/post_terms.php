<?php

namespace LearningCurve\BeansSimpleShortcodes;

/**********************************************************************************************************************
 **********************************************************************************************************************
 *
 *      [beans_post_terms]
 *
 * Shortcode that displays a linked list of taxonomy terms for the post within a span element. Defaults to the 'category' taxonomy.
 *
 * Supported shortcode attributes are:
 *          before      Output before links list but inside the span, default is 'Filed under: '.
 *          after       Output after link but inside the span, default is empty string.
 *          sep         Separator string between term links, default is ', '.
 *          taxonomy    Name of the taxonomy to display, default is 'category'.
 *          class       Additional classes to add to the span element, defaults to an empty string.
 *          style       Inline CSS styling to add to the span element, defaults to an empty string.
 *
 * Defaults pass through `post_terms_shortcode_defaults` filter.
 * Output passes through `post_terms_shortcode` filter before returning.
 *
 * @since   1.6.0
 *
 * @param   array|string $atts Shortcode attributes. Empty string if no attributes.
 *
 * @return  string $output Returns empty string if term list is empty.
 *                         Returns empty string if calling category list causes WP error.
 *                         Otherwise returns output for [beans_post_terms] shortcode.
 */
function post_terms_shortcode( $atts ) {

	$defaults = array(
		'before'   => __( 'Filed under: ', BEANS_SIMPLE_SHORTCODES ),
		'after'    => '',
		'sep'      => ', ',
		'taxonomy' => 'category',
		'class'    => '',
		'style'    => '',
	);

	/**
	 * Post terms shortcode defaults filter.
	 *
	 * Allows the default args in the post terms shortcode function to be more easily filtered.
	 *
	 * @since   1.0
	 *
	 * @param   array $defaults The default args array.
	 */
	$defaults = apply_filters( 'post_terms_shortcode_defaults', $defaults );

	$atts = shortcode_atts( $defaults, $atts, 'post_terms' );

	$terms = get_the_term_list( get_the_ID(), $atts['taxonomy'], null, $atts['sep'], null );

	if ( is_wp_error( $terms ) ) {
		return '';
	}

	if ( empty( $terms ) ) {
		return '';
	}

	// Use the output buffer to ensure everything renders in order
	ob_start();

	beans_open_markup_e( 'beans_simple_post_meta_terms', 'span', array(
		'class' => $atts['class'],
		'style' => 'color: inherit; ' . $atts['style'],
	) );

	beans_output_e( 'beans_simple_post_meta_terms_text_prefix', $atts['before'] );

	beans_output_e( 'beans_simple_post_meta_terms_text', $terms );

	beans_output_e( 'beans_simple_post_meta_terms_text_suffix', $atts['after'] );

	beans_close_markup_e( 'beans_simple_post_meta_terms', 'span' );

	$output = ob_get_clean();

	/**
	 * Post terms shortcode filter.
	 *
	 * Allows the output and the attributes of the post terms shortcode function to be filtered.
	 *
	 * @since   1.0
	 *
	 * @param   string $output   The returned output of the shortcode.
	 * @param   array  $defaults The shortcode attributes array.
	 */
	return apply_filters( 'post_terms_shortcode', $output, $terms, $atts );

}