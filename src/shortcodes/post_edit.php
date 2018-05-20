<?php

namespace LearningCurve\BeansSimpleShortcodes;

/**********************************************************************************************************************
 **********************************************************************************************************************
 *
 *      [beans_post_edit]
 *
 * Shortcode that displays the edit post link, inside a span element, for logged in users.
 *
 * Supported shortcode attributes are:
 *          before          Output before link but inside span, default is empty string.
 *          after           Output after link but inside span, default is empty string.
 *          span-class      Additional classes to add to the span element, default is empty string.
 *          span-style      Inline CSS to style the span element, default is empty string.
 *          link-class      Additional classes to add to the link anchor element, default is empty string.
 *          link-style      Inline CSS to style the link anchor element, default is empty string.
 *          link-text       Link text, default is '(Edit)'.
 *
 * Defaults pass through `post_edit_shortcode_defaults` filter.
 * Output passes through `post_edit_shortcode` filter before returning.
 *
 * @since   1.0
 *
 * @param   array|string $atts Shortcode attributes. Empty string if no attributes.
 *
 * @return  string $output Returns empty string if current user doesn't have edit capability.
 *                         Otherwise returns output for [beans_post_edit] shortcode.
 */
function post_edit_shortcode( $atts ) {

	global $post;

	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return '';
	}

	$defaults = array(
		'before'     => '',
		'after'      => '',
		'span-class' => '',
		'span-style' => '',
		'link-class' => '',
		'link-style' => '',
		'link-text'  => __( '(Edit)', BEANS_SIMPLE_SHORTCODES ),
	);

	/**
	 * Post edit shortcode defaults filter.
	 *
	 * Allows the default args in the post edit shortcode function to be more easily filtered.
	 *
	 * @since   1.0
	 *
	 * @param   array $defaults The default args array.
	 */
	$defaults = apply_filters( 'post_edit_shortcode_defaults', $defaults );

	$atts = shortcode_atts( $defaults, $atts, 'post_edit' );

	// Use the output buffer to ensure everything renders in order
	ob_start();

	beans_open_markup_e( 'beans_simple_post_edit_link_span', 'span', array(
		'class' => $atts['span-class'],
		'style' => 'color:inherit; ' . $atts['span-style'],
	) );

	beans_output_e( 'beans_simple_post_edit_link_text_prefix', $atts['before'] );

	beans_open_markup_e( 'beans_simple_post_edit_link', 'a', array(
		'href' => get_edit_post_link(),
		'class' => $atts['link-class'],
		'style' => $atts['link-style'],
	) );

	beans_output_e( 'beans_simple_post_edit_link_text', $atts['link-text'] );

	beans_close_markup_e( 'beans_simple_post_edit_link', 'a' );

	beans_output_e( 'beans_simple_post_edit_link_text_suffix', $atts['after'] );

	beans_close_markup_e( 'beans_simple_post_meta_edit_link_span', 'span' );

	$output = ob_get_clean();

	/**
	 * Post edit shortcode filter.
	 *
	 * Allows the output and the attributes of the post edit shortcode function to be filtered.
	 *
	 * @since   1.0
	 *
	 * @param   string $output   The returned output of the shortcode.
	 * @param   array  $defaults The shortcode attributes array.
	 */
	return apply_filters( 'post_edit_shortcode', $output, $atts );

}