<?php

namespace LearningCurve\BeansSimpleShortcodes;

/**
 * Configure a multidimensional array of shortcodes and their descriptions and attributes documentation.
 * To be fed into the objects and used to register the shortcodes and their admin metaboxes.
 *
 * @since 1.0
 *
 * @return array
 */
function configure_shortcodes_registration_array() {

	$shortcodes_array = array();

	$shortcodes = array(
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

	foreach ( $shortcodes as $key => $shortcodes_item ) {

		ob_start();
		require BEANS_SIMPLE_SHORTCODES_DIR_PATH . "src/views/admin-metabox-text/" . $shortcodes_item . "/shortcode-label.php";
		$shortcode_label = ob_get_clean();

		ob_start();
		require BEANS_SIMPLE_SHORTCODES_DIR_PATH . "src/views/admin-metabox-text/" . $shortcodes_item . "/shortcode-attributes.php";
		$attributes_description = ob_get_clean();

		$shortcodes_array[ $shortcodes_item ]['shortcode_description']  = __( $shortcode_label, BEANS_SIMPLE_SHORTCODES );
		$shortcodes_array[ $shortcodes_item ]['attributes_description'] = __( $attributes_description, BEANS_SIMPLE_SHORTCODES );

	};

	return $shortcodes_array;

}