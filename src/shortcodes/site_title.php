<?php
namespace LearningCurve\BeansSimpleShortcodes;

/**********************************************************************************************************************
 **********************************************************************************************************************
 *
 *      [beans_site_title]
 *
 * Shortcode displays the unlinked site title inside a span element
 *
 * Supported shortcode attributes are:
 *          before      Output before link but inside span, default is empty string.
 *          after       Output after link but inside span, default is empty string.
 *          class       Additional classes to add to the span element, defaults to an empty string.
 *          style       Inline CSS styling to add to the span element, defaults to an empty string.
 *
 * Defaults pass through `wordpress_link_shortcode_defaults` filter.
 * Output passes through `site_title_shortcode` filter before returning.
 *
 * @since   1.0
 *
 * @param   array|string $atts Shortcode attributes. Empty string if no attributes.
 *
 * @return  string $output Output for [beans_site_title] shortcode.
 */
function site_title_shortcode( $atts ) {

	$defaults = array(
		'before' => '',
		'after'  => '',
		'class'  => '',
		'style'  => '',
	);

	/**
	 * Site title shortcode defaults filter.
	 *
	 * Allows the default args in the site title shortcode function to be more easily filtered.
	 *
	 * @since   1.0
	 *
	 * @param   array $defaults The default args array.
	 */
	$defaults = apply_filters( 'site_title_shortcode_defaults', $defaults );

	$atts = shortcode_atts( $defaults, $atts, 'site_title' );

	// Use the output buffer to ensure everything renders in order
	ob_start();

	beans_open_markup_e( 'beans_simple_site_title', 'span', array(
		'class' => $atts['class'],
		'style' => 'color: inherit; ' . $atts['style'],
	) );

	beans_output_e( 'beans_simple_site_title_text_prefix', $atts['before'] );

	beans_output_e( 'beans_simple_site_title_text', get_bloginfo( 'name' ) );

	beans_output_e( 'beans_simple_site_title_text_suffix', $atts['after'] );

	beans_close_markup_e( 'beans_simple_site_title', 'span' );

	$output = ob_get_clean();

	/**
	 * Site title shortcode filter.
	 *
	 * Allows the output and the attributes of the site title shortcode function to be filtered.
	 *
	 * @since   1.0
	 *
	 * @param   string $output   The returned output of the shortcode.
	 * @param   array  $defaults The shortcode attributes array.
	 */
	return apply_filters( 'site_title_shortcode', $output, $atts );

}