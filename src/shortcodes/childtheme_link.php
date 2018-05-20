<?php

namespace LearningCurve\BeansSimpleShortcodes;

/**********************************************************************************************************************
 **********************************************************************************************************************
 *
 *      [beans_childtheme_link]
 *
 * Shortcode that adds a link to the child theme within a span element, if the details are defined.
 *
 * Outputted child theme details can still be adjusted using shortcode attributes.
 *
 * Supported shortcode attributes are:
 *          before              Output before link but inside span, default is empty string.
 *          after               Output after link but inside span, default is empty string.
 *          span-class          Additional classes to add to the span element, default is empty string.
 *          span-style          Inline CSS to style the span element, default is empty string.
 *          link-class          Additional classes to add to the link anchor element, default is empty string.
 *          link-style          Inline CSS to style the link anchor element, default is empty string.
 *          child-theme-name    Name of the child theme, default is the defined CHILD_THEME_NAME.
 *          child-theme-url     URL of the child theme, default is the defined CHILD_THEME_URL.
 *
 * Defaults pass through `childtheme_link_shortcode_defaults` filter.
 * Output passes through `childtheme_link_shortcode` filter before returning.
 *
 * @since   1.0
 *
 * @param   array|string $atts Shortcode attributes. Empty string if no attributes.
 *
 * @return  string $output Return empty string early if not a child theme.
 *                         Return empty string if `CHILD_THEME_NAME` or `CHILD_THEME_URL` are not defined.
 *                         Otherwise returns output for [beans_childtheme_link] shortcode.
 */
function childtheme_link_shortcode( $atts ) {

	if ( ! is_child_theme() ) {
		return '';
	}

	if ( ! defined( 'CHILD_THEME_NAME' ) || ! defined( 'CHILD_THEME_URL' ) ) {
		return '';
	}

	$defaults = array(
		'after'            => '',
		'before'           => '',
		'span-class'       => '',
		'span-style'       => '',
		'link-class'       => '',
		'link-style'       => '',
		'child-theme-name' => CHILD_THEME_NAME,
		'child-theme-url'  => CHILD_THEME_URL,
	);

	/**
	 * Child theme Link shortcode defaults filter.
	 *
	 * Allows the default args in the Child Theme Link shortcode function to be more easily filtered.
	 *
	 * @since   1.0
	 *
	 * @param   array $defaults The default args array.
	 */
	$defaults = apply_filters( 'childtheme_link_shortcode_defaults', $defaults );

	$atts = shortcode_atts( $defaults, $atts, 'childtheme_link' );

	// Use the output buffer to ensure everything renders in order
	ob_start();

	beans_open_markup_e( 'beans_simple_childtheme_link_span', 'span', array(
		'class' => $atts['span-class'],
		'style' => 'color:inherit; ' . $atts['span-style'],
	) );

	beans_output_e( 'beans_simple_childtheme_link_text_prefix', $atts['before'] );

	beans_open_markup_e( 'beans_simple_childtheme_link', 'a', array(
		'href'  => $atts['child-theme-url'],
		'class' => $atts['link-class'],
		'style' => $atts['link-style'],
	) );

	beans_output_e( 'beans_simple_childtheme_link_text', $atts['child-theme-name'] );

	beans_close_markup_e( 'beans_simple_childtheme_link', 'a' );

	beans_output_e( 'beans_simple_childtheme_link_text_suffix', $atts['after'] );

	beans_close_markup_e( 'beans_simple_childtheme_link_span', 'span' );

	$output = ob_get_clean();

	/**
	 * Child theme link shortcode filter.
	 *
	 * Allows the output and the attributes of the Child theme link shortcode function to be filtered.
	 *
	 * @since   1.0
	 *
	 * @param   string $output   The returned output of the shortcode.
	 * @param   array  $defaults The shortcode attributes array.
	 */
	return apply_filters( 'childtheme_link_shortcode', $output, $atts );

}