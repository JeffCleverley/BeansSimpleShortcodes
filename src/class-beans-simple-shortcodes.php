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
	function __construct( $shortcodes ) {

		$this->plugin_dir_url  = plugin_dir_url( __FILE__ );
		$this->plugin_dir_path = plugin_dir_path( __FILE__ );
		$this->shortcodes_library = $shortcodes;

		foreach ( $this->shortcodes_library as $shortcode => $shortcode_descriptions ) {

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

//		require_once( $this->plugin_dir_path . 'class-beans-simple-shortcodes-core.php' );
//		$this->core = new Beans_Simple_Shortcodes_Core;
//		$this->core->init();

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

	$shortcodes = configuration();

	static $object;

	if ( null == $object ) {
		$object = new Beans_Simple_Shortcodes( $shortcodes );
	}

	return $object;

}

/**
 * Initialize the object on `plugins_loaded`.
 */
add_action( 'plugins_loaded', array( Beans_Simple_Shortcodes(), 'init' ) );
