<?php
namespace LearningCurve\BeansSimpleShortcodes;

class Beans_Simple_Shortcodes {

	/**
	 * Plugin version
	 */
	public $plugin_version = '0.1';

	/**
	 * The plugin textdomain, for translations.
	 */
	public $plugin_textdomain = 'beans-simple-shortcodes';

	/**
	 * The url to the plugin directory.
	 */
	public $plugin_dir_url;

	/**
	 * The path to the plugin directory.
	 */
	public $plugin_dir_path;

	/**
	 * The array of shortcodes and their information.
	 */
	public $shortcodes_library;

	/**
	 * The array of enabled shortcodes.
	 */
	public $enabled_shortcodes;

	/**
	 * Core functionality.
	 */
	public $core;

	/**
	 * Admin menu and settings page.
	 */
	public $admin;

	/**
	 * Constructor.
	 *
	 * @since 1.0
	 */
	function __construct() {

		$this->plugin_dir_url  = plugin_dir_url( __FILE__ );
		$this->plugin_dir_path = plugin_dir_path( __FILE__ );
		$this->shortcodes_library = array(
			'date_posted' => 'Shortcode to display the date a post was published. Supported attributes are <strong>before</strong>, <strong>after</strong>, and <strong>date-format</strong>: ',
			'date_updated' => 'Shortcode to display the date a post was last updated and modified. Supported attributes are <strong>before</strong>, <strong>after</strong>, and <strong>date-format</strong>: ',
			'time_posted' => 'Shortcode to display the time a post was published. Supported attributes are <strong>before</strong>, <strong>after</strong>, and <strong>time-format</strong>: ',
			'time_updated' => 'Shortcode to display the time a post was last updated and modified. Supported attributes are <strong>before</strong>, <strong>after</strong>, and <strong>time-format</strong>: ',
			'post_author' => 'Shortcode that displays the unlinked post author\'s name. Supported attributes are <strong>before</strong> and <strong>after</strong>: ',
			'post_author_link' => 'Shortcode that displays the post author\'s name as a link. Supported attributes are <strong>before</strong> and <strong>after</strong>: ',
			'post_comments' => 'Shortcode that displays a link to the current post\'s comments. Supported attributes are <strong>before</strong>, <strong>after</strong>, <strong>no-comments</strong>, <strong>one-comment</strong>, and <strong>more-comments</strong>:',
			'post_tags' => 'Shortcode that displays the post tag links. Supported attributes are <strong>before</strong>, <strong>after</strong>, and <strong>sep</strong>: ',
			'post_categories' => 'Shortcode that displays the categories links list. Supported attributes are <strong>before</strong>, <strong>after</strong>, and <strong>sep</strong>: ',
			'post_terms' => 'Shortcode that displays a linked list of taxonomy terms for the post. Supported attributes are <strong>before</strong>, <strong>after</strong>, <strong>sep</strong>, and <strong>taxonomy</strong>: ',
			'post_edit' => 'Shortcode that displays the edit post link. Supported attributes are <strong>before</strong>, <strong>after</strong>, and <strong>link</strong>: ',
			'copyright' => 'Shortcode that adds a visual copyright notice. Supported attributes are <strong>before</strong>, <strong>after</strong>, <strong>copyright</strong>, and <strong>first-year</strong>: ',
			'childtheme_link' => 'Shortcode that adds a link to the child theme. Supported attributes are <strong>before</strong>, <strong>after</strong>, <strong>child-theme-name</strong>, and <strong>child-theme-url</strong>: ',
			'theme_link' => 'Shortcode that adds a link to the Beans Theme Framework. Supported attributes are <strong>before</strong>, <strong>after</strong>, <strong>beans</strong>, and <strong>beans-url</strong>: ',
			'wordpress_link' => 'Shortcode that adds a link to WordPress.org. Supported attributes are <strong>before</strong>, <strong>after</strong>, <strong>wordpress</strong>, and <strong>wordpress-url</strong>:',
			'site_title' => 'Shortcode displays the unlinked site title. Supported attributes are <strong>before</strong> and <strong>after</strong>: ',
			'home_link' => 'Shortcode displays a link to the home page. Supported attributes are <strong>before</strong> and <strong>after</strong>: ',
			'loginout' => 'Shortcode displays an admin login / logout link depending on whether a user is logged in or out. <br>Supported attributes are <strong>before-login</strong>, <strong>before-logout</strong>, <strong>after-login</strong>, <strong>after-logout</strong>, <strong>login-text</strong>, <strong>logout-text</strong>, <strong>login-redirect</strong>, and <strong>logout-redirect</strong>:',
		);

		foreach ( $this->shortcodes_library as $shortcode => $shortcode_intro ) {

			if ( get_option( "beans_simple_deactivate_{$shortcode}_shortcode_checkbox" ) ) {
				continue;
			}

			$this->enabled_shortcodes[] = $shortcode;
		}

	}

	/**
	 * Initialize.
	 *
	 * @since 1.0
	 */
	public function init() {

		add_action( 'beans_after_init', array( $this, 'instantiate' ) );

	}


	/**
	 * Include the class file, instantiate the classes, create objects.
	 *
	 * @since 1.0
	 */
	public function instantiate() {

		require_once( $this->plugin_dir_path . 'class-beans-simple-shortcodes-core.php' );
		$this->core = new Beans_Simple_Shortcodes_Core;
		$this->core->init();

		if ( is_admin() ) {
			require_once( $this->plugin_dir_path . 'class-beans-simple-shortcodes-admin.php' );
			$this->admin = new Beans_Simple_Shortcodes_Admin;
			$this->admin->init();
		}

	}

}

/**
 * Helper function to retrieve the static object without using globals.
 *
 * @since 1.0
 */
function Beans_Simple_Shortcodes() {

	static $object;

	if ( null == $object ) {
		$object = new Beans_Simple_Shortcodes();
	}

	return $object;

}

/**
 * Initialize the object on `plugins_loaded`.
 */
add_action( 'plugins_loaded', array( Beans_Simple_Shortcodes(), 'init' ) );
