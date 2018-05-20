<?php

namespace LearningCurve\BeansSimpleShortcodes;

/**********************************************************************************************************************
 **********************************************************************************************************************
 *
 *      [beans_post_author_link]
 *
 * Outputs the post author's name as a link to the author's url within a span element.
 *
 * Supported shortcode attributes are:
 *          before          Output before the link but inside the span, default is 'By '.
 *          after           Output after the link but inside the span, default is empty string.
 *          span-class      Additional classes to add to the span element, default is empty string.
 *          span-style      Inline CSS to style the span element, default is empty string.
 *          link-class      Additional classes to add to the link anchor element, default is empty string.
 *          link-style      Inline CSS to style the link anchor element, default is empty string.
 *
 * Defaults pass through `post_author_link_shortcode_defaults` filter.
 * Output passes through `post_author_link_shortcode` filter before returning.
 *
 * @since   1.0
 *
 * @param   array|string $atts Array of shortcode attribute values. Empty String if no submitted attributes.
 *
 * @return  string $output Return empty string if the post type doesn't support 'author'.
 *                         Return empty string if post has no author assigned.
 *                         Otherwise return output for [beans_post_author_link] shortcode.
 */
function post_author_link_shortcode( $atts ) {

	if ( ! post_type_supports( get_post_type(), 'author' ) ) {
		return '';
	}

	$author = get_the_author(); // Automatically escaped.

	if ( ! $author ) {
		return '';
	}

	$defaults = array(
		'before'     => __( 'By ', BEANS_SIMPLE_SHORTCODES ),
		'after'      => '',
		'span-class' => '',
		'span-style' => '',
		'link-class' => '',
		'link-style' => '',
	);

	/**
	 * Post author link shortcode defaults filter.
	 *
	 * Allows the default args in the post author link shortcode function to be more easily filtered.
	 *
	 * @since   1.0
	 *
	 * @param   array $defaults The default args array.
	 */
	$defaults = apply_filters( 'post_author_link_shortcode_defaults', $defaults );

	$atts = shortcode_atts( $defaults, $atts, 'post_author_link' );

	// Use the output buffer to ensure everything renders in order
	ob_start();

	beans_open_markup_e( 'beans_simple_post_meta_author_link_span', 'span', array(
		'class' => $atts['span-class'],
		'style' => 'color:inherit; ' . $atts['span-style'],
	) );

	beans_output_e( 'beans_simple_post_meta_author_link_prefix', $atts['before'] );

	beans_open_markup_e( 'beans_simple_post_meta_author_link', 'a', array(
		'href'      => get_author_posts_url( get_the_author_meta( 'ID' ) ), // Automatically escaped
		'rel'       => 'author',
		'itemprop'  => 'author',
		'itemscope' => '',
		'itemtype'  => 'http://schema.org/Person',
		'class' => $atts['link-class'],
		'style' => $atts['link-style'],
	) );

	beans_output_e( 'beans_simple_post_meta_author_text', $author );

	beans_selfclose_markup_e( 'beans_simple_post_meta_author_name_meta', 'meta', array(
		'itemprop' => 'name',
		'content'  => $author, // Automatically escaped.
	) );

	beans_close_markup_e( 'beans_simple_post_meta_author_link', 'a' );

	beans_output_e( 'beans_simple_post_meta_author_link_suffix', $atts['after'] );

	beans_close_markup_e( 'beans_simple_post_meta_author_link_span', 'span' );

	$output = ob_get_clean();

	/**
	 * Post author link shortcode filter.
	 *
	 * Allows the output and the attributes of the post author link shortcode function to be filtered.
	 *
	 * @since   1.0
	 *
	 * @param   string $output   The returned output of the shortcode.
	 * @param   array  $defaults The shortcode attributes array.
	 */
	return apply_filters( 'post_author_link_shortcode', $output, $atts );

}
