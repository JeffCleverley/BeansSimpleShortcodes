<?php
namespace LearningCurve\BeansSimpleShortcodes;

/**********************************************************************************************************************
 **********************************************************************************************************************
 *
 *      [beans_time_posted]
 *
 * Shortcode to display the time a post was published inside a span element
 *
 * Support shortcode attributes are:
 *          before          Output before the time inside the span, defaults to 'Posted at '.
 *          after           Output after the time inside the span, defaults to an empty string.
 *          class           Additional classes to add to the span element, defaults to an empty string.
 *          style           Inline CSS styling to add to the span element, defaults to an empty string.
 *          time-format     Time format for output, defaults to user set WordPress time format option.
 *                          Other acceptable formats found here: https://codex.wordpress.org/Formatting_Date_and_Time
 *
 * Defaults pass through `time_posted_shortcode_defaults` filter.
 * Output passes through `time_posted_shortcode` filter before returning.
 *
 * @since   1.0
 *
 * @param   array|string $atts Array of shortcode attribute values. Empty String if no submitted attributes.
 *
 * @return  string $output Output for [beans_time_posted] shortcode.
 */
function time_posted_shortcode( $atts ) {

	$defaults = array(
		'before'      => __( 'Posted at ', BEANS_SIMPLE_SHORTCODES ),
		'after'       => '',
		'class'       => '',
		'style'       => '',
		'time-format' => get_option( 'time_format' ),
	);

	/**
	 * Time posted shortcode defaults filter.
	 *
	 * Allows the default args in the time posted shortcode function to be more easily filtered.
	 *
	 * @since   1.0
	 *
	 * @param   array $defaults The default args array.
	 */
	$defaults = apply_filters( 'time_posted_shortcode_defaults', $defaults );

	$atts = shortcode_atts( $defaults, $atts, 'time_posted' );

	$atts['time-posted'] = get_the_time( $atts['time-format'] );

	// Use the output buffer to ensure everything renders in order
	ob_start();

	beans_open_markup_e( 'beans_simple_post_meta_time_posted_span', 'span', array(
		'class' => $atts['class'],
		'style' => 'color: inherit; ' . $atts['style'],
	) );

	beans_output_e( 'beans_simple_post_meta_time_posted_text_prefix', $atts['before'] );

	beans_open_markup_e( 'beans_simple_post_meta_time_posted', 'time', array(
		'datetime' => get_the_time( 'c' ),
		'itemprop' => 'timePublished',
	) );

	beans_output_e( 'beans_simple_post_meta_time_posted_text', $atts['time-posted'] );

	beans_close_markup_e( 'beans_simple_post_meta_time_posted', 'time' );

	beans_output_e( 'beans_simple_post_meta_time_posted_text_suffix', $atts['after'] );

	beans_close_markup_e( 'beans_simple_post_meta_time_posted_span', 'span' );

	$output = ob_get_clean();

	/**
	 * Time posted shortcode filter.
	 *
	 * Allows the output and the attributes of the time posted shortcode function to be filtered.
	 *
	 * @since   1.0
	 *
	 * @param   string $output   The returned output of the shortcode.
	 * @param   array  $defaults The shortcode attributes array.
	 */
	return apply_filters( 'time_posted_shortcode', $output, $atts );

}