<?php

namespace LearningCurve\BeansSimpleShortcodes;

class Beans_Simple_Shortcodes {

	/**
	 * Plugin version
	 */
	public $plugin_version = '0.1';

	/**
	 * To store the plugin textdomain, for translations.
	 */
	public $plugin_textdomain;

	/**
	 * To store the path to the plugin directory.
	 */
	public $plugin_dir_path;

	/**
	 * To store the array of shortcodes and their information.
	 */
	public $shortcodes_library;

	/**
	 * To store the array of enabled shortcodes.
	 */
	public $enabled_shortcodes;

	/**
	 * To store the shortcode registry object.
	 */
	public $registry;

	/**
	 * To store the shortcode admin object.
	 */
	public $admin;

	/**
	 * Constructor.
	 *
	 * @since 1.0
	 *
	 * @param $shortcodes array Multidimensional array containing shortcodes and their information.
	 * @param $beans_simple_shortcodes_dir_path string  Absolute path to plugin directory.
	 * @param $text_domain string Text domain for translations
	 */
	function __construct( $shortcodes, $beans_simple_shortcodes_dir_path, $text_domain ) {

		$this->plugin_dir_path    = $beans_simple_shortcodes_dir_path;
		$this->shortcodes_library = $shortcodes;
		$this->plugin_textdomain  = $text_domain;

		foreach ( $this->shortcodes_library as $shortcode => $shortcode_descriptions_array ) {

			if ( get_option( "beans_simple_deactivate_{$shortcode}_shortcode_checkbox" ) ) {
				continue;
			}

			$this->enabled_shortcodes[] = $shortcode;
		}

	}

	/**
	 * Initialize.
	 *
	 * Hook in the method to instantiate the plugin admin and registry object after Beans theme initialisation.
	 *
	 * @since 1.0
	 */
	public function init() {

		add_action( 'beans_after_init', array( $this, 'instantiate' ) );

	}


	/**
	 * Include the class files, instantiate the classes, create objects.
	 *
	 * @since 1.0
	 */
	public function instantiate() {

		require_once( $this->plugin_dir_path . 'src/class-beans-simple-shortcodes-registry.php' );
		$this->registry = new Beans_Simple_Shortcodes_Registry;
		$this->registry->init();

		if ( is_admin() ) {
			require_once( $this->plugin_dir_path . 'src/class-beans-simple-shortcodes-admin.php' );
			$this->admin = new Beans_Simple_Shortcodes_Admin;
			$this->admin->init();
		}

	}

}

/**
 * Helper function to retrieve the static object without using globals.
 * Feed the shortcodes array for registration into the Beans_Simple_Shortcodes object for construction
 *
 * @since 1.0
 */
function Beans_Simple_Shortcodes() {

	$shortcodes = configure_shortcodes_registration_array();

	static $object;

	if ( null == $object ) {
		$object = new Beans_Simple_Shortcodes(
			$shortcodes,
			BEANS_SIMPLE_SHORTCODES_DIR_PATH,
			BEANS_SIMPLE_SHORTCODES
		);
	}

	return $object;

}

/**
 * Initialize the object on `plugins_loaded`.
 */
add_action( 'plugins_loaded', array( Beans_Simple_Shortcodes(), 'init' ) );
