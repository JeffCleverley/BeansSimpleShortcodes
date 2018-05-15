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
	 * The array of shortcodes and their information.
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
		$this->enabled_shortcodes = Beans_Simple_Shortcodes()->enabled_shortcodes;

	}

	/**
	 * Initialize.
	 *
	 * @since 1.0
	 */
	public function init() {

		add_action( 'admin_menu', array( $this, 'admin_menu' ), 150 );

		foreach ( $this->shortcodes_library as $shortcode => $shortcode_intro ) {

			add_action( 'admin_init', function () use ( $shortcode, $shortcode_intro ) {
				$this->register_shortcodes_admin( $shortcode, $shortcode_intro );
			} );

		}

	}

	/**
	 * Add beans simple edits menu.
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
	 * Beans options page content.
	 */
	public function display_simple_shortcodes_settings_screen() {

		require __DIR__ . "/views/admin.php";

	}


	public function register_shortcodes_admin( $shortcode, $shortcode_intro ) {

		$label = __( $shortcode_intro, $this->plugin_textdomain );
		ob_start();
		beans_output_e( "beans_simple_shortcodes_{$shortcode}_label_text", $label );
		$label = ob_get_clean();

		$shortcode_attributes_description = include __DIR__ . "/views/{$shortcode}-description.php";

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

