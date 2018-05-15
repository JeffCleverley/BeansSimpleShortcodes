<?php

namespace LearningCurve\BeansSimpleShortcodes;

//add_action( 'init', __NAMESPACE__ . '\map_beans_shortcodes' );
/**
 * Map an array of shortcodes to a callback function that will register them.
 *
 * @since   1.0
 */
function map_beans_shortcodes() {

	$shortcodes_array = array(
		'date_posted',
		'date_updated',
		'time_posted',
		'time_updated',
		'post_author',
		'post_author_link',
		'post_comments',
		'post_tags',
		'post_categories',
		'post_terms',
		'post_edit',
		'copyright',
		'childtheme_link',
		'theme_link',
		'wordpress_link',
		'site_title',
		'home_link',
		'loginout',
	);

	$shortcodes_to_register = array();

	foreach ( $shortcodes_array as $shortcode )  {

		if ( get_option( "beans_simple_deactivate_{$shortcode}_shortcode_checkbox" ) ) {
			continue;
		}

		$shortcodes_to_register[] = $shortcode;
	}

	array_map( __NAMESPACE__ . '\register_shortcodes', $shortcodes_to_register );

}

/**
 * Callback used by array_map() to register each shortcode.
 *
 * @since   1.0
 *
 * @param   string $shortcodes_array_item Individual item from the shortcode array.
 */
function register_shortcodes( $shortcodes_array_item ) {

	add_shortcode( 'beans_' . $shortcodes_array_item, __NAMESPACE__ . '\\' . $shortcodes_array_item . '_shortcode' );

}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///                                                                                                                 ///
///                                         BEANS SIMPLE SHORTCODES                                                 ///
///                                                                                                                 ///
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


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
		'style' => 'color: inherit',
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


/**********************************************************************************************************************
 **********************************************************************************************************************
 *
 *      [beans_date_updated]
 *
 * Shortcode to display the date a post was last updated and modified.
 *
 * Support shortcode attributes are:
 *          before          Output before the date, Defaults to 'Updated on '.
 *          after           Output before the date, Defaults to an empty string.
 *          date-format     Date format for output, defaults to user set WordPress date format option.
 *                          Other acceptable formats found here: https://codex.wordpress.org/Formatting_Date_and_Time
 *
 * Defaults pass through `date_updated_shortcode_defaults` filter.
 * Output passes through `date_updated_shortcode` filter before returning.
 *
 * @since   1.0
 *
 * @param   array|string $atts Array of shortcode attribute values. Empty String if no submitted attributes.
 *
 * @return  string $output Output for [beans_date_updated] shortcode.
 */
function date_updated_shortcode( $atts ) {

	$defaults = array(
		'before'      => __( 'Updated on ', BEANS_SIMPLE_SHORTCODES ),
		'after'       => '',
		'date-format' => get_option( 'date_format' ),
	);

	/**
	 * Date updated shortcode defaults filter.
	 *
	 * Allows the default args in the date updated shortcode function to be more easily filtered.
	 *
	 * @since   1.0
	 *
	 * @param   array $defaults The default args array.
	 */
	$defaults = apply_filters( 'date_updated_shortcode_defaults', $defaults );

	$atts = shortcode_atts( $defaults, $atts, 'date_updated' );

	$atts['date-updated'] = get_the_modified_time( $atts['date-format'] );

	// Use the output buffer to ensure everything renders in order
	ob_start();

	beans_open_markup_e( 'beans_simple_post_meta_date_updated_span', 'span', array(
		'style' => 'color: inherit',
	) );

	beans_output_e( 'beans_simple_post_meta_date_updated_prefix', $atts['before'] );

	beans_open_markup_e(
		'beans_simple_post_meta_date_updated',
		'time', array(
			'datetime' => get_the_modified_time( 'c' ),
			'itemprop' => 'dateUpdated',
		)
	);

	beans_output_e( 'beans_simple_post_meta_date_updated_text', $atts['date-updated'] );

	beans_close_markup_e( 'beans_simple_post_meta_date_updated', 'time' );

	beans_output_e( 'beans_simple_post_meta_date_updated_text_suffix', $atts['after'] );

	beans_close_markup_e( 'beans_simple_post_meta_date_updated_span', 'span' );

	$output = ob_get_clean();

	/**
	 * Date updated shortcode filter.
	 *
	 * Allows the output and the attributes of the date updated shortcode function to be filtered.
	 *
	 * @since   1.0
	 *
	 * @param   string $output   The returned output of the shortcode.
	 * @param   array  $defaults The shortcode attributes array.
	 */
	return apply_filters( 'date_updated_shortcode', $output, $atts );

}


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
		'style' => 'color: inherit',
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
		'style' => 'color: inherit',
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


/**********************************************************************************************************************
 **********************************************************************************************************************
 *
 *      [beans_post_author]
 *
 * Shortcode that displays the unlinked post author's name in a span element.
 *
 * Supported shortcode attributes are:
 *          before      Output before the post author's name inside the span, default is 'By '.
 *          after       Output  after the post author's name inside the span, default is an empty string.
 *
 * Output passes through `post_author_shortcode` filter before returning.
 *
 * @since   1.0
 *
 * @param   array|string $atts Array of shortcode attribute values. Empty String if no submitted attributes.
 *
 * @return  string $output Return empty string if the post type doesn't support 'author'.
 *                         Return empty string if post has no author assigned.
 *                         Otherwise return output for [beans_post_author] shortcode.
 */
function post_author_shortcode( $atts ) {

	if ( ! post_type_supports( get_post_type(), 'author' ) ) {
		return '';
	}

	$author = get_the_author();

	if ( ! $author ) {
		return '';
	}

	$defaults = array(
		'before' => __( 'By ', BEANS_SIMPLE_SHORTCODES ),
		'after'  => '',
	);

	/**
	 * Post author shortcode defaults filter.
	 *
	 * Allows the default args in the post author shortcode function to be more easily filtered.
	 *
	 * @since   1.0
	 *
	 * @param   array $defaults The default args array.
	 */
	$defaults = apply_filters( 'post_author_shortcode_defaults', $defaults );

	$atts = shortcode_atts( $defaults, $atts, 'post_author' );

	$author = esc_html( $author );

	// Use the output buffer to ensure everything renders in order
	ob_start();

	beans_open_markup_e( 'beans_simple_post_meta_author_span', 'span', array(
		'style'     => 'color: inherit',
		'itemprop'  => 'author',
		'itemscope' => '',
		'itemtype'  => 'http://schema.org/Person',
	) );

	beans_output_e( 'beans_simple_post_meta_author_prefix', $atts['before'] );

	beans_output_e( 'beans_simple_post_meta_author_text', $author );

	beans_selfclose_markup_e( 'beans_simple_post_meta_author_name_meta', 'meta', array(
		'itemprop' => 'name',
		'content'  => $author,
	) );

	beans_output_e( 'beans_simple_post_meta_author_suffix', $atts['after'] );

	beans_close_markup_e( 'beans_simple_post_meta_author_span', 'span' );

	$output = ob_get_clean();

	/**
	 * Post author shortcode filter.
	 *
	 * Allows the output and the attributes of the post author shortcode function to be filtered.
	 *
	 * @since   1.0
	 *
	 * @param   string $output   The returned output of the shortcode.
	 * @param   array  $defaults The shortcode attributes array.
	 */
	return apply_filters( 'post_author_shortcode', $output, $atts );

}


/**********************************************************************************************************************
 **********************************************************************************************************************
 *
 *      [beans_post_author_link]
 *
 * Outputs the post author's name as a link to the author's url within a span element.
 *
 * Supported shortcode attributes are:
 *          before      Output before the link but inside the span, default is 'By '.
 *          after       Output after the link but inside the span, default is empty string.
 *
 * Defaults pass through `post_author_link_shortcode_defaults` filter.
 * Output passes through `post_author_link_shortcode` filter before returning.
 *
 * @since   1.0
 *
 * @param   array|string $atts Array of shortcode attribute values. Empty String if no submitted attributes.
 *
 * @return  string $output Return empty string if the post type doesn't support 'author'.
 *                         Return empty string if post has no author assigned.
 *                         Otherwise return output for [beans_post_author_link] shortcode.
 */
function post_author_link_shortcode( $atts ) {

	if ( ! post_type_supports( get_post_type(), 'author' ) ) {
		return '';
	}

	$author = get_the_author(); // Automatically escaped.

	if ( ! $author ) {
		return '';
	}

	$defaults = array(
		'before' => __( 'By ', BEANS_SIMPLE_SHORTCODES ),
		'after'  => '',
	);

	/**
	 * Post author link shortcode defaults filter.
	 *
	 * Allows the default args in the post author link shortcode function to be more easily filtered.
	 *
	 * @since   1.0
	 *
	 * @param   array $defaults The default args array.
	 */
	$defaults = apply_filters( 'post_author_link_shortcode_defaults', $defaults );

	$atts = shortcode_atts( $defaults, $atts, 'post_author_link' );

	// Use the output buffer to ensure everything renders in order
	ob_start();

	beans_open_markup_e( 'beans_simple_post_meta_author_link_span', 'span', array(
		'style' => 'color: inherit',
	) );

	beans_output_e( 'beans_simple_post_meta_author_link_prefix', $atts['before'] );

	beans_open_markup_e( 'beans_simple_post_meta_author_link', 'a', array(
		'href'      => get_author_posts_url( get_the_author_meta( 'ID' ) ), // Automatically escaped
		'rel'       => 'author',
		'itemprop'  => 'author',
		'itemscope' => '',
		'itemtype'  => 'http://schema.org/Person',
	) );

	beans_output_e( 'beans_simple_post_meta_author_text', $author );

	beans_selfclose_markup_e( 'beans_simple_post_meta_author_name_meta', 'meta', array(
		'itemprop' => 'name',
		'content'  => $author, // Automatically escaped.
	) );

	beans_close_markup_e( 'beans_simple_post_meta_author_link', 'a' );

	beans_output_e( 'beans_simple_post_meta_author_link_suffix', $atts['after'] );

	beans_close_markup_e( 'beans_simple_post_meta_author_link_span', 'span' );

	$output = ob_get_clean();

	/**
	 * Post author link shortcode filter.
	 *
	 * Allows the output and the attributes of the post author link shortcode function to be filtered.
	 *
	 * @since   1.0
	 *
	 * @param   string $output   The returned output of the shortcode.
	 * @param   array  $defaults The shortcode attributes array.
	 */
	return apply_filters( 'post_author_link_shortcode', $output, $atts );

}


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
		'style' => 'color:inherit;',
	) );

	beans_output_e( 'beans_simple_post_meta_comments_text_prefix', $atts['before'] );

	beans_open_markup_e( $id, 'a', array(
		'href' => get_comments_link(), // Automatically escaped.
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


/**********************************************************************************************************************
 **********************************************************************************************************************
 *
 *      [beans_post_tags]
 *
 * Shortcode that displays the post tag links list within a span element.
 *
 * Supported shortcode attributes are:
 *          before      Output before link but inside the span, default is 'Tagged with: '.
 *          after       Output after link but inside the span, default is empty string.
 *          sep         Separator string between tags, default is ', '.
 *
 * Defaults pass through `post_tags_shortcode_defaults` filter.
 * Output passes through `post_tags_shortcode` filter before returning.
 *
 * @since   1.0
 *
 * @param   array|string $atts Shortcode attributes. Empty string if no attributes.
 *
 * @return  string $output Returns empty string if the `post_tag` taxonomy is not associated with the current post type.
 *                         Returns empty string if tag list is empty.
 *                         Returns empty string if calling tag list causes error.
 *                         Otherwise, returns output for [beans_post_tags] shortcode.
 */
function post_tags_shortcode( $atts ) {

	if ( ! is_object_in_taxonomy( get_post_type(), 'post_tag' ) ) {
		return '';
	}

	$defaults = array(
		'before' => __( 'Tagged with: ', BEANS_SIMPLE_SHORTCODES ),
		'after'  => '',
		'sep'    => ', ',
	);

	/**
	 * Post tags shortcode defaults filter.
	 *
	 * Allows the default args in the post tags shortcode function to be more easily filtered.
	 *
	 * @since   1.0
	 *
	 * @param   array $defaults The default args array.
	 */
	$defaults = apply_filters( 'post_tags_shortcode_defaults', $defaults );

	$atts = shortcode_atts( $defaults, $atts, 'post_tags' );

	$tags = get_the_tag_list( null, $atts['sep'] );

	if ( is_wp_error( $tags ) ) {
		return '';
	}

	if ( empty( $tags ) ) {
		return '';
	}

	// Use the output buffer to ensure everything renders in order
	ob_start();

	beans_open_markup_e(
		'beans_simple_post_meta_tags',
		'span',
		array(
			'style' => 'color:inherit;',
		)
	);

	beans_output_e( 'beans_simple_post_meta_tags_text_prefix', $atts['before'] );

	beans_output_e( 'beans_simple_post_meta_tags_text', $tags );

	beans_output_e( 'beans_simple_post_meta_tags_text_suffix', $atts['after'] );

	beans_close_markup_e( 'beans_simple_post_meta_tags', 'span' );

	$output = ob_get_clean();

	/**
	 * Post tags shortcode filter.
	 *
	 * Allows the output and the attributes of the post tags shortcode function to be filtered.
	 *
	 * @since   1.0
	 *
	 * @param   string $output   The returned output of the shortcode.
	 * @param   array  $defaults The shortcode attributes array.
	 */
	return apply_filters( 'post_tags_shortcode', $output, $atts );

}


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

	beans_open_markup_e(
		'beans_simple_post_meta_categories',
		'span',
		array(
			'style' => 'color:inherit;',
		)
	);

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


/**********************************************************************************************************************
 **********************************************************************************************************************
 *
 *      [beans_post_terms]
 *
 * Shortcode that displays a linked list of taxonomy terms for the post within a span element. Defaults to the 'category' taxonomy.
 *
 * Supported shortcode attributes are:
 *          before      Output before links list but inside the span, default is 'Filed under: '.
 *          after       Output after link but inside the span, default is empty string.
 *          sep         Separator string between tags, default is ', '.
 *          taxonomy    Name of the taxonomy to display, default is 'category'.
 *
 * Defaults pass through `post_terms_shortcode_defaults` filter.
 * Output passes through `post_terms_shortcode` filter before returning.
 *
 * @since   1.6.0
 *
 * @param   array|string $atts Shortcode attributes. Empty string if no attributes.
 *
 * @return  string $output Returns empty string if term list is empty.
 *                         Returns empty string if calling category list causes WP error.
 *                         Otherwise returns output for [beans_post_terms] shortcode.
 */
function post_terms_shortcode( $atts ) {

	$defaults = array(
		'before'   => __( 'Filed under: ', BEANS_SIMPLE_SHORTCODES ),
		'after'    => '',
		'sep'      => ', ',
		'taxonomy' => 'category',
	);

	/**
	 * Post terms shortcode defaults filter.
	 *
	 * Allows the default args in the post terms shortcode function to be more easily filtered.
	 *
	 * @since   1.0
	 *
	 * @param   array $defaults The default args array.
	 */
	$defaults = apply_filters( 'post_terms_shortcode_defaults', $defaults );

	$atts = shortcode_atts( $defaults, $atts, 'post_terms' );

	$terms = get_the_term_list( get_the_ID(), $atts['taxonomy'], null, $atts['sep'], null );

	if ( is_wp_error( $terms ) ) {
		return '';
	}

	if ( empty( $terms ) ) {
		return '';
	}

	// Use the output buffer to ensure everything renders in order
	ob_start();

	beans_open_markup_e(
		'beans_simple_post_meta_terms',
		'span',
		array(
			'style' => 'color:inherit;',
		)
	);

	beans_output_e( 'beans_simple_post_meta_terms_text_prefix', $atts['before'] );

	beans_output_e( 'beans_simple_post_meta_terms_text', $terms );

	beans_output_e( 'beans_simple_post_meta_terms_text_suffix', $atts['after'] );

	beans_close_markup_e( 'beans_simple_post_meta_terms', 'span' );

	$output = ob_get_clean();

	/**
	 * Post terms shortcode filter.
	 *
	 * Allows the output and the attributes of the post terms shortcode function to be filtered.
	 *
	 * @since   1.0
	 *
	 * @param   string $output   The returned output of the shortcode.
	 * @param   array  $defaults The shortcode attributes array.
	 */
	return apply_filters( 'post_terms_shortcode', $output, $terms, $atts );

}


/**********************************************************************************************************************
 **********************************************************************************************************************
 *
 *      [beans_post_edit]
 *
 * Shortcode that displays the edit post link, inside a span element, for logged in users.
 *
 * Supported shortcode attributes are:
 *          before      Output before link but inside span, default is empty string.
 *          after       Output after link but inside span, default is empty string.
 *          link        Link text, default is '(Edit)'.
 *
 * Defaults pass through `post_edit_shortcode_defaults` filter.
 * Output passes through `post_edit_shortcode` filter before returning.
 *
 * @since   1.0
 *
 * @param   array|string $atts Shortcode attributes. Empty string if no attributes.
 *
 * @return  string $output Returns empty string if current user doesn't have edit capability.
 *                         Otherwise returns output for [beans_post_edit] shortcode.
 */
function post_edit_shortcode( $atts ) {

	global $post;

	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return '';
	}

	$defaults = array(
		'before'    => '',
		'after'     => '',
		'link-text' => __( '(Edit)', BEANS_SIMPLE_SHORTCODES ),
	);

	/**
	 * Post edit shortcode defaults filter.
	 *
	 * Allows the default args in the post edit shortcode function to be more easily filtered.
	 *
	 * @since   1.0
	 *
	 * @param   array $defaults The default args array.
	 */
	$defaults = apply_filters( 'post_edit_shortcode_defaults', $defaults );

	$atts = shortcode_atts( $defaults, $atts, 'post_edit' );

	// Use the output buffer to ensure everything renders in order
	ob_start();

	beans_open_markup_e(
		'beans_simple_post_edit_link_span',
		'span',
		array(
			'style' => 'color:inherit;',
		)
	);

	beans_output_e( 'beans_simple_post_edit_link_text_prefix', $atts['before'] );

	beans_open_markup_e(
		'beans_simple_post_edit_link',
		'a',
		array(
			'href' => get_edit_post_link(),
		)
	);

	beans_output_e( 'beans_simple_post_edit_link_text', $atts['link-text'] );

	beans_close_markup_e( 'beans_simple_post_edit_link', 'a' );

	beans_output_e( 'beans_simple_post_edit_link_text_suffix', $atts['after'] );

	beans_close_markup_e( 'beans_simple_post_meta_edit_link_span', 'span' );

	$output = ob_get_clean();

	/**
	 * Post edit shortcode filter.
	 *
	 * Allows the output and the attributes of the post edit shortcode function to be filtered.
	 *
	 * @since   1.0
	 *
	 * @param   string $output   The returned output of the shortcode.
	 * @param   array  $defaults The shortcode attributes array.
	 */
	return apply_filters( 'post_edit_shortcode', $output, $atts );

}


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
		'style' => 'color:inherit;',
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
 *          before              Output after link but inside span, default is empty string.
 *          after               Output after link but inside span, default is empty string.
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
		'style' => 'color:inherit;',
	) );

	beans_output_e( 'beans_simple_childtheme_link_text_prefix', $atts['before'] );

	beans_open_markup_e( 'beans_simple_childtheme_link', 'a', array(
		'href' => $atts['child-theme-url'],
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


/**********************************************************************************************************************
 **********************************************************************************************************************
 *
 *      [beans_theme_link]
 *
 * Shortcode that adds a link to the Beans Theme Framework within a span element.
 *
 * Supported shortcode attributes are:
 *          before      Output after link but inside span, default is empty string.
 *          after       Output after link but inside span, default is empty string.
 *          beans       Name of Beans theme, default is 'Beans'.
 *          beans-url   Url of the Beans theme framework, default is https://getbeans.io/.
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
		'style' => 'color:inherit;',
	) );

	beans_output_e( 'beans_simple_beans_link_text_prefix', $atts['before'] );

	beans_open_markup_e( 'beans_simple_beans_link', 'a', array(
		'href' => $atts['beans-url'],
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
 *          wordpress       Name of Beans theme, default is 'Beans.
 *          wordpress-url   Url of the Beans theme framework, default is https://wordpress.org/.
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
		'style' => 'color:inherit;',
	) );

	beans_output_e( 'beans_simple_wordpress_link_text_prefix', $atts['before'] );

	beans_open_markup_e( 'beans_simple_wordpress_link', 'a', array(
		'href' => $atts['wordpress-url'],
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
		'style' => 'color:inherit;',
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

/**********************************************************************************************************************
 **********************************************************************************************************************
 *
 *      [beans_home_link]
 *
 * Shortcode displays a link to the home page inside a span element
 *
 * Supported shortcode attributes are:
 *          before      Output before link but inside span, default is empty string.
 *          after       Output after link but inside span, default is empty string.
 *
 * Defaults pass through `home_link_shortcode_defaults` filter.
 * Output passes through `home_link_shortcode` filter before returning.
 *
 * @since   1.0
 *
 * @param   array|string $atts Shortcode attributes. Empty string if no attributes.
 *
 * @return  string $output Output for [beans_home_link] shortcode.
 */
function home_link_shortcode( $atts ) {

	$defaults = array(
		'after'  => '',
		'before' => '',
	);

	/**
	 * Home link shortcode defaults filter.
	 *
	 * Allows the default args in the home link shortcode function to be more easily filtered.
	 *
	 * @since   1.0
	 *
	 * @param   array $defaults The default args array.
	 */
	$defaults = apply_filters( 'home_link_shortcode_defaults', $defaults );

	$atts = shortcode_atts( $defaults, $atts, 'home_link' );

	// Use the output buffer to ensure everything renders in order
	ob_start();

	beans_open_markup_e( 'beans_simple_home_link_span', 'span', array(
		'style' => 'color:inherit;',
	) );

	beans_output_e( 'beans_simple_home_link_text_prefix', $atts['before'] );

	beans_open_markup_e( 'beans_simple_home_link', 'a', array(
		'href' => home_url(),
	) );

	beans_output_e( 'beans_simple_home_link_text', get_bloginfo( 'name' ) );

	beans_close_markup_e( 'beans_simple_home_link', 'a' );

	beans_output_e( 'beans_simple_home_link_text_suffix', $atts['after'] );

	beans_close_markup_e( 'beans_simple_home_link_span', 'span' );

	$output = ob_get_clean();

	/**
	 * Home link shortcode filter.
	 *
	 * Allows the output and the attributes of the home link shortcode function to be filtered.
	 *
	 * @since   1.0
	 *
	 * @param   string $output   The returned output of the shortcode.
	 * @param   array  $defaults The shortcode attributes array.
	 */
	return apply_filters( 'home_link_shortcode', $output, $atts );

}

/**********************************************************************************************************************
 **********************************************************************************************************************
 *
 *      [beans_loginout]
 *
 * Shortcode displays an admin login / logout link inside a span element, depending on whether a user is logged in or out.
 *
 * Support shortcode attributes are:
 *      before-login        Output before login link but inside the span, default is empty string.
 *      before-logout       Output before logout link but inside the span, default is empty string.
 *      after-login         Output after login link but inside the span, default is empty string.
 *      after-logout        Output after logout link but inside the span, default is empty string.
 *      login-text          Text for the login link, default is 'Log in'.
 *      logout-text         Text for the login link, default is 'Log out'.
 *      login-redirect      Redirect page path after login, default is empty string - must be absolute path.
 *      logout-redirect     Redirect page path after logout, default is home_url() - must be absolute path.
 *
 * Defaults pass through `loginout_shortcode_defaults` filter.
 * Output passes through `loginout_shortcode` filter before returning.
 *
 * @since   1.0
 *
 * @param   array|string $atts Shortcode attributes. Empty string if no attributes.
 *
 * @return  string $output Output for [beans_loginout] shortcode.
 */
function loginout_shortcode( $atts ) {

	$defaults = array(
		'before-login'    => '',
		'before-logout'   => '',
		'after-login'     => '',
		'after-logout'    => '',
		'login-text'      => __( 'Log in', BEANS_SIMPLE_SHORTCODES ),
		'logout-text'     => __( 'Log out', BEANS_SIMPLE_SHORTCODES ),
		'login-redirect'  => '',
		'logout-redirect' => home_url(),
	);

	/**
	 * Loginout shortcode defaults filter.
	 *
	 * Allows the default args in the loginout shortcode function to be more easily filtered.
	 *
	 * @since   1.0
	 *
	 * @param   array $defaults The default args array.
	 */
	$defaults = apply_filters( 'home_link_shortcode_defaults', $defaults );

	$atts = shortcode_atts( $defaults, $atts, 'loginout' );

	// Use the output buffer to ensure everything renders in order
	ob_start();

	beans_open_markup_e( 'beans_simple_loginout_span', 'span', array(
		'style' => 'color:inherit;',
	) );

	if ( ! is_user_logged_in() ) {

		beans_output_e( 'beans_simple_login_text_prefix', $atts['before-login'] );

		beans_open_markup_e( 'beans_simple_login_link', 'a', array(
			'href' => esc_url( wp_login_url( $atts['login-redirect'] ) ),
		) );

		beans_output_e( 'beans_simple_login_text', $atts['login-text'] );

		beans_close_markup_e( 'beans_simple_login_link', 'a' );

		beans_output_e( 'beans_simple_login_text_suffix', $atts['after-login'] );

	} else {

		beans_output_e( 'beans_simple_logout_text_prefix', $atts['before-logout'] );

		beans_open_markup_e( 'beans_simple_logout_link', 'a', array(
			'href' => esc_url( wp_logout_url( $atts['logout-redirect'] ) ),
		) );

		beans_output_e( 'beans_simple_logout_text', $atts['logout-text'] );

		beans_close_markup_e( 'beans_simple_logout_link', 'a' );

		beans_output_e( 'beans_simple_logout_text_suffix', $atts['after-logout'] );
	}

	beans_close_markup_e( 'beans_simple_loginout_span', 'span' );

	$output = ob_get_clean();

	/**
	 * Loginout shortcode filter.
	 *
	 * Allows the output and the attributes of the loginout shortcode function to be filtered.
	 *
	 * @since   1.0
	 *
	 * @param   string $output   The returned output of the shortcode.
	 * @param   array  $defaults The shortcode attributes array.
	 */
	return apply_filters( 'loginout_shortcode', $output, $atts );

}
