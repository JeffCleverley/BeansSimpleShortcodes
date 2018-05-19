<?php

namespace LearningCurve\BeansSimpleShortcodes;

function configuration() {

	$shortcodes_array = array();

	$shortcodes = array(
		'date_posted',
//		'date_updated',
//		'time_posted',
//		'time_updated',
//		'post_author',
//		'post_author_link',
//		'post_comments',
//		'post_tags',
//		'post_categories',
//		'post_terms',
//		'post_edit',
//		'copyright',
//		'childtheme_link',
//		'theme_link',
//		'wordpress_link',
//		'site_title',
//		'home_link',
//		'loginout',
	);

	foreach ( $shortcodes as $key => $shortcodes_item ) {

		ob_start();
		require __DIR__ . "/shortcodes-admin-text/" . $shortcodes_item . "/shortcode-label.php";
		$shortcode_label = ob_get_clean();

		ob_start();
		require __DIR__ . "/shortcodes-admin-text/" . $shortcodes_item . "/shortcode-attributes.php";
		$attributes_description = ob_get_clean();

		$shortcodes_array[ $shortcodes_item ]['shortcode_description'] = __( $shortcode_label, BEANS_SIMPLE_SHORTCODES );
		$shortcodes_array[ $shortcodes_item ]['attributes_description'] = __( $attributes_description, BEANS_SIMPLE_SHORTCODES );

	};

	return $shortcodes_array;

//		'time_posted' => 'Shortcode to display the time a post was published. Supported attributes are <strong>before</strong>, <strong>after</strong>, and <strong>time-format</strong>: ',
//		'time_updated' => 'Shortcode to display the time a post was last updated and modified. Supported attributes are <strong>before</strong>, <strong>after</strong>, and <strong>time-format</strong>: ',
//		'post_author' => 'Shortcode that displays the unlinked post author\'s name. Supported attributes are <strong>before</strong> and <strong>after</strong>: ',
//		'post_author_link' => 'Shortcode that displays the post author\'s name as a link. Supported attributes are <strong>before</strong> and <strong>after</strong>: ',
//		'post_comments' => 'Shortcode that displays a link to the current post\'s comments. Supported attributes are <strong>before</strong>, <strong>after</strong>, <strong>no-comments</strong>, <strong>one-comment</strong>, and <strong>more-comments</strong>:',
//		'post_tags' => 'Shortcode that displays the post tag links. Supported attributes are <strong>before</strong>, <strong>after</strong>, and <strong>sep</strong>: ',
//		'post_categories' => 'Shortcode that displays the categories links list. Supported attributes are <strong>before</strong>, <strong>after</strong>, and <strong>sep</strong>: ',
//		'post_terms' => 'Shortcode that displays a linked list of taxonomy terms for the post. Supported attributes are <strong>before</strong>, <strong>after</strong>, <strong>sep</strong>, and <strong>taxonomy</strong>: ',
//		'post_edit' => 'Shortcode that displays the edit post link. Supported attributes are <strong>before</strong>, <strong>after</strong>, and <strong>link</strong>: ',
//		'copyright' => 'Shortcode that adds a visual copyright notice. Supported attributes are <strong>before</strong>, <strong>after</strong>, <strong>copyright</strong>, and <strong>first-year</strong>: ',
//		'childtheme_link' => 'Shortcode that adds a link to the child theme. Supported attributes are <strong>before</strong>, <strong>after</strong>, <strong>child-theme-name</strong>, and <strong>child-theme-url</strong>: ',
//		'theme_link' => 'Shortcode that adds a link to the Beans Theme Framework. Supported attributes are <strong>before</strong>, <strong>after</strong>, <strong>beans</strong>, and <strong>beans-url</strong>: ',
//		'wordpress_link' => 'Shortcode that adds a link to WordPress.org. Supported attributes are <strong>before</strong>, <strong>after</strong>, <strong>wordpress</strong>, and <strong>wordpress-url</strong>:',
//		'site_title' => 'Shortcode displays the unlinked site title. Supported attributes are <strong>before</strong> and <strong>after</strong>: ',
//		'home_link' => 'Shortcode displays a link to the home page. Supported attributes are <strong>before</strong> and <strong>after</strong>: ',
//		'loginout' => 'Shortcode displays an admin login / logout link depending on whether a user is logged in or out. <br>Supported attributes are <strong>before-login</strong>, <strong>before-logout</strong>, <strong>after-login</strong>, <strong>after-logout</strong>, <strong>login-text</strong>, <strong>logout-text</strong>, <strong>login-redirect</strong>, and <strong>logout-redirect</strong>:',
//	);
}