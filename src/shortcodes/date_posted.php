<?php
namespace LearningCurve\BeansSimpleShortcodes;

/**********************************************************************************************************************
 **********************************************************************************************************************
 *
 *      [beans_date_posted]
 *
 * Shortcode to display the date a post was published inside a span element.
 *
 * Support shortcode attributes are:
 *          before          Output before the date but inside the span, Defaults to 'Posted on '.
 *          after           Output before the date but inside the span, Defaults to an empty string.
 *          class           Additional classes to add to the span element, defaults to an empty string.
 *          style           Inline CSS styling to add to the span element, defaults to an empty string.
 *          date-format     Date format for output, defaults to user set WordPress date format option.
 *                          Other acceptable formats found here: https://codex.wordpress.org/Formatting_Date_and_Time
 *
 * Defaults pass through `date_posted_shortcode_defaults` filter.
 * Output passes through `date_posted_shortcode` filter before returning.
 *
 * @since   1.0
 *
 * @param   array|string $atts Array of shortcode attribute values. Empty String if no submitted attributes.
 *
 * @return  string $output Output for [beans_date_posted] shortcode.
 */
function date_posted_shortcode( $atts ) {

	$defaults = array(
		'before'      => __( 'Posted on ', BEANS_SIMPLE_SHORTCODES ),
		'after'       => '',
		'class'       => '',
		'style'       => '',
		'date-format' => get_option( 'date_format' ),
	);

	/**
	 * Beans date posted shortcode defaults filter.
	 *
	 * Allows the default args in the beans date posted shortcode function to be more easily filtered.
	 *
	 * @since   1.0
	 *
	 * @param   array $defaults The default args array.
	 */
	$defaults = apply_filters( 'date_posted_shortcode_defaults', $defaults );

	$atts = shortcode_atts( $defaults, $atts, 'date_posted' );

	$atts['date-posted'] = get_the_time( $atts['date-format'] );

	// Use the output buffer to ensure everything renders in order
	ob_start();

	beans_open_markup_e( 'beans_simple_post_meta_date_posted_span', 'span', array(
		'class' => $atts['class'],
		'style' => 'color: inherit; ' . $atts['style'],
	) );

	beans_output_e( 'beans_simple_post_meta_date_posted_prefix', $atts['before'] );

	beans_open_markup_e(
		'beans_simple_post_meta_date_posted',
		'time', array(
			'datetime' => get_the_time( 'c' ),
			'itemprop' => 'datePublished',
		)
	);

	beans_output_e( 'beans_simple_post_meta_date_posted_text', $atts['date-posted'] );

	beans_close_markup_e( 'beans_simple_post_meta_date_posted', 'time' );

	beans_output_e( 'beans_simple_post_meta_date_posted_prefix', $atts['after'] );

	beans_close_markup_e( 'beans_simple_post_meta_date_posted_span', 'span' );

	$output = ob_get_clean();

	/**
	 * Date posted shortcode filter.
	 *
	 * Allows the output and the attributes of the date posted shortcode function to be filtered.
	 *
	 * @since   1.0
	 *
	 * @param   string $output   The returned output of the shortcode.
	 * @param   array  $defaults The shortcode attributes array.
	 */
	return apply_filters( 'date_posted_shortcode', $output, $atts );

}