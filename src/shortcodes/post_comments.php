<?php

namespace LearningCurve\BeansSimpleShortcodes;

/**********************************************************************************************************************
 **********************************************************************************************************************
 *
 *      [beans_post_comments]
 *
 * Shortcode that produces the link to the current post's comments inside a span element.
 *
 * Supported shortcode attributes are:
 *          before          Output before link but inside the span, default is empty string.
 *          after           Output after link but inside the span, default is empty string.
 *          span-class      Additional classes to add to the span element, default is empty string.
 *          span-style      Inline CSS to style the span element, default is empty string.
 *          link-class      Additional classes to add to the link anchor element, default is empty string.
 *          link-style      Inline CSS to style the link anchor element, default is empty string.
 *          no-comments     Text when there are no comments, default is 'Leave a Comment'.
 *          one-comment     Text when there is exactly one comment, default is '1 Comment'.
 *          more-comments   Text when there are multiple comments, use %s character as placeholder for actual number,
 *                          default is '%s Comments'.
 *
 * Defaults pass through `post_comments_shortcode_defaults` filter.
 * Output passes through `post_comments_shortcode` filter before returning.
 *
 * @since   1.0
 *
 * @param   array|string $atts Shortcode attributes. Empty string if no attributes.
 *
 * @return  string $output Return empty string if post does not support `comments`.
 *                         Return empty string if post requires a password.
 *                         Return empty string if comments are closed.
 *                         Otherwise, return output for [beans_post_comments] shortcode.
 */
function post_comments_shortcode( $atts ) {

	global $post;

	if ( ! post_type_supports( get_post_type(), 'comments' ) ) {
		return '';
	}

	if ( post_password_required() ) {
		return '';
	}

	if ( ! comments_open() ) {
		return '';
	}

	$comments_number = (int) get_comments_number( $post->ID );

	$defaults = array(
		'before'        => '',
		'after'         => '',
		'span-class'    => '',
		'span-style'    => '',
		'link-class'    => '',
		'link-style'    => '',
		'no-comments'   => __( 'Leave a Comment', BEANS_SIMPLE_SHORTCODES ),
		'one-comment'   => __( '1 Comment', BEANS_SIMPLE_SHORTCODES ),
		'more-comments' => __( '%s Comments', BEANS_SIMPLE_SHORTCODES ),
	);

	/**
	 * Post comments shortcode defaults filter.
	 *
	 * Allows the default args in the post comments shortcode function to be more easily filtered.
	 *
	 * @since   1.0
	 *
	 * @param   array $defaults The default args array.
	 */
	$defaults = apply_filters( 'post_comments_shortcode_defaults', $defaults );

	$atts = shortcode_atts( $defaults, $atts, 'post_comments' );

	if ( $comments_number < 1 ) {
		$id           = 'beans_simple_post_meta_empty_comment_text';
		$comment_text = $atts['no-comments'];
	}

	if ( 1 === $comments_number ) {
		$id           = 'beans_simple_post_meta_comments_text_singular';
		$comment_text = $atts['one-comment'];
	}

	if ( $comments_number > 1 ) {
		$id           = 'beans_simple_post_meta_comments_text_plural';
		$comment_text = $atts['more-comments'];
	}

	// Use the output buffer to ensure everything renders in order
	ob_start();

	beans_open_markup_e( 'beans_simple_post_meta_comments_span', 'span', array(
		'class' => $atts['span-class'],
		'style' => 'color:inherit; ' . $atts['span-style'],
	) );

	beans_output_e( 'beans_simple_post_meta_comments_text_prefix', $atts['before'] );

	beans_open_markup_e( $id, 'a', array(
		'href' => get_comments_link(), // Automatically escaped.
		'class' => $atts['link-class'],
		'style' => $atts['link-style'],
	) );

	printf( $comment_text, (int) get_comments_number( $post->ID ) );

	beans_close_markup_e( $id, 'a' );

	beans_output_e( 'beans_simple_post_meta_comments_text_suffix', $atts['after'] );

	beans_close_markup_e( 'beans_simple_post_meta_comments_span', 'span' );

	$output = ob_get_clean();

	/**
	 * Post comments shortcode filter.
	 *
	 * Allows the output and the attributes of the post comments shortcode function to be filtered.
	 *
	 * @since   1.0
	 *
	 * @param   string $output   The returned output of the shortcode.
	 * @param   array  $defaults The shortcode attributes array.
	 */
	return apply_filters( 'post_comments_shortcode', $output, $atts );

}