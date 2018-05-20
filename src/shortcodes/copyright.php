<?php

namespace LearningCurve\BeansSimpleShortcodes;

/**********************************************************************************************************************
 **********************************************************************************************************************
 *
 *      [beans_copyright]
 *
 * Shortcode that adds a visual copyright notice inside a span element.
 *
 * Supported shortcode attributes are:
 *          before      Output before notice but inside the span, default is empty string.
 *          after       Output after notice but inside the span, default is empty string.
 *          copyright   Copyright notice, default is copyright character like (c).
 *          first year  Copyright first applies, default is empty string.
 *          class       Additional classes to add to the span element, defaults to an empty string.
 *          style       Inline CSS styling to add to the span element, defaults to an empty string.
 *
 * If the 'first' attribute is not empty, and not equal to the current year, then
 * output will be formatted as first-current year (e.g. 1998-2020).
 * Otherwise, output is just given as the current year.
 *
 * Defaults pass through `copyright_shortcode_defaults` filter.
 * Output passes through `copyright_shortcode` filter before returning.
 *
 * @since   1.0
 *
 * @param   array|string $atts Shortcode attributes. Empty string if no attributes.
 *
 * @return  string $output Output for [beans_footer_copyright] shortcode.
 */
function copyright_shortcode( $atts ) {

	$defaults = array(
		'before'    => '',
		'after'     => '',
		'copyright' => '&#x000A9;',
		'first'     => '',
		'class'     => '',
		'style'     => '',
	);

	/**
	 * Copyright shortcode defaults filter.
	 *
	 * Allows the default args in the copyright shortcode function to be more easily filtered.
	 *
	 * @since   1.0
	 *
	 * @param   array $defaults The default args array.
	 */
	$defaults = apply_filters( 'copyright_shortcode_defaults', $defaults );

	$atts = shortcode_atts( $defaults, $atts, 'copyright' );

	$copyright = $atts['copyright'] . '&nbsp;';

	if ( '' !== $atts['first'] && date( 'Y' ) !== $atts['first'] ) {
		$copyright .= $atts['first'] . '&#x02013;';
	}

	$copyright .= date( 'Y' );

	// Use the output buffer to ensure everything renders in order
	ob_start();

	beans_open_markup_e( 'beans_simple_copyright_span', 'span', array(
		'class' => $atts['class'],
		'style' => 'color:inherit; ' . $atts['style'],
	) );

	beans_output_e( 'beans_simple_copyright_text_prefix', $atts['before'] );

	beans_output_e( 'beans_simple_copyright', $copyright );

	beans_output_e( 'beans_simple_copyright_text_suffix', $atts['after'] );

	beans_close_markup_e( 'beans_simple_copyright_span', 'span' );

	$output = ob_get_clean();

	/**
	 * Copyright shortcode filter.
	 *
	 * Allows the output and the attributes of the copyright shortcode function to be filtered.
	 *
	 * @since   1.0
	 *
	 * @param   string $output   The returned output of the shortcode.
	 * @param   array  $defaults The shortcode attributes array.
	 */
	return apply_filters( 'copyright_shortcode', $output, $atts );

}