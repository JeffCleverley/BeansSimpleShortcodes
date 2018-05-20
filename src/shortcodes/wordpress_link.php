<?php

namespace LearningCurve\BeansSimpleShortcodes;

/**********************************************************************************************************************
 * ********************************************************************************************************************
 *
 *      [beans_wordpress_link]
 *
 * Shortcode that adds a link to WordPress.org inside a span element.
 *
 * Supported shortcode attributes are:
 *          before          Output before link but inside span, default is empty string.
 *          after           Output after link but inside span, default is empty string.
 *          wordpress       Name of Beans theme, default is 'WordPress'.
 *          wordpress-url   Url of the Beans theme framework, default is https://wordpress.org/.
 *          span-class      Additional classes to add to the span element, default is empty string.
 *          span-style      Inline CSS to style the span element, default is empty string.
 *          link-class      Additional classes to add to the link anchor element, default is empty string.
 *          link-style      Inline CSS to style the link anchor element, default is empty string.
 *
 * Defaults pass through `wordpress_link_shortcode_defaults` filter.
 * Output passes through `wordpress_link_shortcode` filter before returning.
 *
 * @since 1.1.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 *
 * @return string $output Output for [beans_wordpress_link] shortcode.
 */
function wordpress_link_shortcode( $atts ) {

	$defaults = array(
		'before'        => '',
		'after'         => '',
		'wordpress'     => __( 'WordPress', BEANS_SIMPLE_SHORTCODES ),
		'wordpress-url' => 'https://wordpress.org/',
		'span-class'    => '',
		'span-style'    => '',
		'link-class'    => '',
		'link-style'    => '',
	);

	/**
	 * WordPress Link shortcode defaults filter.
	 *
	 * Allows the default args in the WordPress Link shortcode function to be more easily filtered.
	 *
	 * @since   1.0
	 *
	 * @param   array $defaults The default args array.
	 */
	$defaults = apply_filters( 'wordpress_link_shortcode_defaults', $defaults );

	$atts = shortcode_atts( $defaults, $atts, 'wordpress_link' );

	// Use the output buffer to ensure everything renders in order
	ob_start();

	beans_open_markup_e( 'beans_simple_wordpress_link_span', 'span', array(
		'class' => $atts['span-class'],
		'style' => 'color:inherit; ' . $atts['span-style'],
	) );

	beans_output_e( 'beans_simple_wordpress_link_text_prefix', $atts['before'] );

	beans_open_markup_e( 'beans_simple_wordpress_link', 'a', array(
		'href' => $atts['wordpress-url'],
		'class' => $atts['link-class'],
		'style' => $atts['link-style'],
	) );

	beans_output_e( 'beans_simple_wordpress_link_text', $atts['wordpress'] );

	beans_close_markup_e( 'beans_simple_wordpress_link', 'a' );

	beans_output_e( 'beans_simple_wordpress_link_text_suffix', $atts['after'] );

	beans_close_markup_e( 'beans_simple_wordpress_link_span', 'span' );

	$output = ob_get_clean();

	/**
	 * WordPress link shortcode filter.
	 *
	 * Allows the output and the attributes of the WordPress link shortcode function to be filtered.
	 *
	 * @since   1.0
	 *
	 * @param   string $output   The returned output of the shortcode.
	 * @param   array  $defaults The shortcode attributes array.
	 */
	return apply_filters( 'wordpress_link_shortcode', $output, $atts );

}