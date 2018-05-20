<?php
namespace LearningCurve\BeansSimpleShortcodes;

/**********************************************************************************************************************
 **********************************************************************************************************************
 *
 *      [beans_theme_link]
 *
 * Shortcode that adds a link to the Beans Theme Framework within a span element.
 *
 * Supported shortcode attributes are:
 *          before          Output after link but inside span, default is empty string.
 *          after           Output after link but inside span, default is empty string.
 *          beans           Name of Beans theme, default is 'Beans'.
 *          beans-url       Url of the Beans theme framework, default is https://getbeans.io/.
 *          span-class      Additional classes to add to the span element, default is empty string.
 *          span-style      Inline CSS to style the span element, default is empty string.
 *          link-class      Additional classes to add to the link anchor element, default is empty string.
 *          link-style      Inline CSS to style the link anchor element, default is empty string.
 *
 * Defaults pass through `beans_link_shortcode_defaults` filter.
 * Output passes through `beans_link_shortcode` filter before returning.
 *
 * @since   1.1.0
 *
 * @param   array|string $atts Shortcode attributes. Empty string if no attributes.
 *
 * @return  string $output Output for [beans_link] shortcode.
 */
function theme_link_shortcode( $atts ) {

	$defaults = array(
		'before'    => '',
		'after'     => '',
		'beans'     => __( 'Beans', BEANS_SIMPLE_SHORTCODES ),
		'beans-url' => 'https://getbeans.io',
		'span-class' => '',
		'span-style' => '',
		'link-class' => '',
		'link-style' => '',
	);

	/**
	 * Beans Link shortcode defaults filter.
	 *
	 * Allows the default args in the Beans Link shortcode function to be more easily filtered.
	 *
	 * @since   1.0
	 *
	 * @param   array $defaults The default args array.
	 */
	$defaults = apply_filters( 'beans_link_shortcode_defaults', $defaults );

	$atts = shortcode_atts( $defaults, $atts, 'beans_link' );

	// Use the output buffer to ensure everything renders in order
	ob_start();

	beans_open_markup_e( 'beans_simple_beans_link_span', 'span', array(
		'class' => $atts['span-class'],
		'style' => 'color:inherit; ' . $atts['span-style'],
	) );

	beans_output_e( 'beans_simple_beans_link_text_prefix', $atts['before'] );

	beans_open_markup_e( 'beans_simple_beans_link', 'a', array(
		'href' => $atts['beans-url'],
		'class' => $atts['link-class'],
		'style' => $atts['link-style'],
	) );

	beans_output_e( 'beans_simple_beans_link_text', $atts['beans'] );

	beans_close_markup_e( 'beans_simple_beans_link', 'a' );

	beans_output_e( 'beans_simple_beans_link_text_suffix', $atts['after'] );

	beans_close_markup_e( 'beans_simple_beans_link_span', 'span' );

	$output = ob_get_clean();

	/**
	 * Beans link shortcode filter.
	 *
	 * Allows the output and the attributes of the Beans theme link shortcode function to be filtered.
	 *
	 * @since   1.0
	 *
	 * @param   string $output   The returned output of the shortcode.
	 * @param   array  $defaults The shortcode attributes array.
	 */
	return apply_filters( 'beans_link_shortcode', $output, $atts );

}