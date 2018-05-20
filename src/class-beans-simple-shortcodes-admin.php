<?php

namespace LearningCurve\BeansSimpleShortcodes;

class Beans_Simple_Shortcodes_Admin {

	/**
	 * Plugin version
	 */
	public $plugin_version;

	/**
	 * The plugin textdomain, for translations.
	 */
	public $plugin_textdomain;

	/**
	 * The array of shortcodes and their information to register their admin metaboxes etc.
	 */
	public $shortcodes_library;

	/**
	 * The array of enabled shortcodes.
	 */
	public $enabled_shortcodes;

	/**
	 * Constructor.
	 *
	 * @since 1.0
	 */
	public function __construct() {

		$this->plugin_version     = Beans_Simple_Shortcodes()->plugin_version;
		$this->plugin_textdomain  = Beans_Simple_Shortcodes()->plugin_textdomain;
		$this->shortcodes_library = Beans_Simple_Shortcodes()->shortcodes_library;
		$this->enabled_shortcodes = Beans_Simple_Shortcodes()->enabled_shortcodes; //TO DO - use this to create opacity change to disabled shortcodes using ajax/js

	}

	/**
	 * Initialize.
	 *
	 * Add the callback to register the admin menu to the 'admin_menu' hook
	 * Loop through the shortcode library array, separate each shortcodes individual array into different array variables.
	 * Then add a callback to 'admin_init' to register each shortcodes admin metabox using these variables.
	 *
	 * @since 1.0
	 */
	public function init() {

		add_action( 'admin_menu', array( $this, 'admin_menu' ), 150 );

		foreach ( $this->shortcodes_library as $shortcode => $shortcode_descriptions ) {

			$shortcode_description  = $shortcode_descriptions['shortcode_description'];
			$attributes_description = $shortcode_descriptions['attributes_description'];

			add_action( 'admin_init', function () use ( $shortcode, $shortcode_description, $attributes_description ) {
				$this->register_admin_metaboxes( $shortcode, $shortcode_description, $attributes_description );
			} );

		}

	}

	/**
	 * Add Beans Simple Shortcodes to the Admin Menu and register the theme page
	 *
	 * @since 1.0
	 */
	public function admin_menu() {

		add_theme_page(
			__( 'Simple Shortcodes', $this->plugin_textdomain ),
			__( 'Simple Shortcodes', $this->plugin_textdomain ),
			'manage_options',
			'beans_simple_shortcodes_settings',
			array(
				$this,
				'display_simple_shortcodes_settings_screen'
			)
		);

	}

	/**
	 * Display the settings screen for Beans Simple Shortcodes.
	 *
	 * @since 1.0
	 */
	public function display_simple_shortcodes_settings_screen() {

		require __DIR__ . "/views/admin-screen.php";

	}

	/**
	 * Register each shortcodes admin metabox.
	 *
	 * @since 1.0
	 *
	 * @param $shortcode string The shortcode
	 * @param $shortcode_intro string The description about the shortcodes function
	 * @param $shortcodes_attributes string The documentation for using the shortcodes attributes
	 */
	public function register_admin_metaboxes( $shortcode, $shortcode_intro, $shortcodes_attributes ) {

		$label = __( $shortcode_intro, $this->plugin_textdomain );
		ob_start();
		beans_output_e( "beans_simple_shortcodes_{$shortcode}_label_text", $label );
		$label = ob_get_clean();

		$shortcode_attributes_description = $shortcodes_attributes;
		ob_start();
		beans_output_e( "beans_simple_shortcodes_{$shortcode}_attributes_description", $shortcode_attributes_description );
		$shortcode_attributes_description = ob_get_clean();

		$checkbox_label = __( "Check this box and click save to <strong>deactivate</strong> the <strong>[beans_{$shortcode}]</strong> shortcode", $this->plugin_textdomain );
		ob_start();
		beans_output_e( "beans_simple_shortcodes_{$shortcode}_checkbox_text", $checkbox_label );
		$checkbox_label = ob_get_clean();

		$fields = array(
			array(
				'id'          => "beans_simple_{$shortcode}_shortcode",
				'label'       => $label,
				'description' => $shortcode_attributes_description,
				'type'        => '',
				'default'     => ''
			),
			array(
				'id'             => "beans_simple_deactivate_{$shortcode}_shortcode_checkbox",
				'checkbox_label' => $checkbox_label,
				'type'           => 'checkbox',
				'default'        => 0,
			),
		);

		beans_register_options(
			$fields,
			'beans_simple_shortcodes_settings',
			"beans_simple_{$shortcode}_shortcode",
			array(
				'title'   => __( "[beans_{$shortcode}]", $this->plugin_textdomain ),
				'context' => 'normal',
			)
		);

	}

}

