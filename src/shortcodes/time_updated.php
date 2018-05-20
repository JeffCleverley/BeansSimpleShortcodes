<?php
namespace LearningCurve\BeansSimpleShortcodes;

/**********************************************************************************************************************
 **********************************************************************************************************************
 *
 *      [beans_time_updated]
 *
 * Shortcode to display the time a post was last updated and modified within a span element.
 *
 * Support shortcode attributes are:
 *          before          Output before the time inside the span, defaults to 'Updated at '.
 *          after           Output after the time inside the span, defaults to empty string.
 *          class           Additional classes to add to the span element, defaults to an empty string.
 *          style           Inline CSS styling to add to the span element, defaults to an empty string.
 *          time-format     Time format for output, defaults to user set WordPress time format.
 *                          Other acceptable formats found here: https://codex.wordpress.org/Formatting_Date_and_Time
 *
 * Defaults pass through `time_updated_shortcode_defaults` filter.
 * Output passes through `time_updated_shortcode` filter before returning.
 *
 * @since   1.0
 *
 * @param   array|string $atts Array of shortcode attribute values. Empty String if no submitted attributes.
 *
 * @return  string $output Output for [beans_time_updated] shortcode.
 */
function time_updated_shortcode( $atts ) {

	$defaults = array(
		'before'      => __( 'Updated at ', BEANS_SIMPLE_SHORTCODES ),
		'after'       => '',
		'class'       => '',
		'style'       => '',
		'time-format' => get_option( 'time_format' ),
	);

	/**
	 * Time updated shortcode defaults filter.
	 *
	 * Allows the default args in the time updated shortcode function to be more easily filtered.
	 *
	 * @since   1.0
	 *
	 * @param   array $defaults The default args array.
	 */
	$defaults = apply_filters( 'time_updated_shortcode_defaults', $defaults );

	$atts = shortcode_atts( $defaults, $atts, 'time_updated' );

	$atts['time-updated'] = get_the_modified_time( $atts['time-format'] );

	// Use the output buffer to ensure everything renders in order
	ob_start();

	beans_open_markup_e( 'beans_simple_post_meta_time_updated_span', 'span', array(
		'class' => $atts['class'],
		'style' => 'color: inherit; ' . $atts['style'],
	) );

	beans_output_e( 'beans_simple_post_meta_time_updated_prefix', $atts['before'] );

	beans_open_markup_e( 'beans_simple_post_meta_time_updated', 'time', array(
		'datetime' => get_the_time( 'c' ),
		'itemprop' => 'timeUpdated',
	) );

	beans_output_e( 'beans_simple_post_meta_time_updated_text', $atts['time-updated'] );

	beans_close_markup_e( 'beans_simple_post_meta_time_updated', 'time' );

	beans_output_e( 'beans_simple_post_meta_time_updated_suffix', $atts['after'] );

	beans_close_markup_e( 'beans_simple_post_meta_time_updated_span', 'span' );

	$output = ob_get_clean();

	/**
	 * Time updated shortcode filter.
	 *
	 * Allows the output and the attributes of the time updated shortcode function to be filtered.
	 *
	 * @since   1.0
	 *
	 * @param   string $output   The returned output of the shortcode.
	 * @param   array  $defaults The shortcode attributes array.
	 */
	return apply_filters( 'time_updated_shortcode', $output, $atts );

}