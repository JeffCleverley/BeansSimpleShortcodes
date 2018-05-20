<?php
namespace LearningCurve\BeansSimpleShortcodes;

/**********************************************************************************************************************
 **********************************************************************************************************************
 *
 *      [beans_post_categories]
 *
 * Shortcode that displays the categories links list within a span element.
 *
 * Supported shortcode attributes are:
 *          before      Output before link list but inside span, default is 'Filed under: ',
 *          after       Output after link list but inside span, default is an empty string,
 *          sep         Separator string between tags, default is ', '.
 *          class       Additional classes to add to the span element, defaults to an empty string.
 *          style       Inline CSS styling to add to the span element, defaults to an empty string.
 *
 * Defaults pass through `post_categories_shortcode_defaults` filter.
 * Output passes through `post_categories_shortcode` filter before returning.
 *
 * @since   1.0
 *
 * @param   array|string $atts Shortcode attributes. Empty string if no attributes.
 *
 * @return  string $output Returns empty string if the `category` taxonomy is not associated with the current post type.
 *                         Returns empty string if category list is empty.
 *                         Returns empty string if calling category list causes error.
 *                         Otherwise, returns output for [beans_post_categories] shortcode.
 */
function post_categories_shortcode( $atts ) {

	if ( ! is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		return '';
	}

	$defaults = array(
		'before' => __( 'Filed under: ', BEANS_SIMPLE_SHORTCODES ),
		'after'  => '',
		'sep'    => ', ',
		'class'  => '',
		'style'  => '',
	);

	/**
	 * Post categories shortcode defaults filter.
	 *
	 * Allows the default args in the post categories shortcode function to be more easily filtered.
	 *
	 * @since   1.0
	 *
	 * @param   array $defaults The default args array.
	 */
	$defaults = apply_filters( 'post_categories_shortcode_defaults', $defaults );

	$atts = shortcode_atts( $defaults, $atts, 'post_categories' );

	$categories = get_the_category_list( $atts['sep'] );

	if ( is_wp_error( $categories ) ) {
		return '';
	}

	if ( empty( $categories ) ) {
		return '';
	}

	// Use the output buffer to ensure everything renders in order
	ob_start();

	beans_open_markup_e( 'beans_simple_post_meta_categories', 'span', array(
		'class' => $atts['class'],
		'style' => 'color: inherit; ' . $atts['style'],
	) );

	beans_output_e( 'beans_simple_post_meta_categories_text_prefix', $atts['before'] );

	beans_output_e( 'beans_simple_post_meta_categories_text', $categories );

	beans_output_e( 'beans_simple_post_meta_categories_text_suffix', $atts['after'] );

	beans_close_markup_e( 'beans_simple_post_meta_categories', 'span' );

	$output = ob_get_clean();

	/**
	 * Post categories shortcode filter.
	 *
	 * Allows the output and the attributes of the post categories shortcode function to be filtered.
	 *
	 * @since   1.0
	 *
	 * @param   string $output   The returned output of the shortcode.
	 * @param   array  $defaults The shortcode attributes array.
	 */
	return apply_filters( 'post_categories_shortcode', $output, $atts );

}