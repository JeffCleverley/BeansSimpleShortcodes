<?php
namespace LearningCurve\BeansSimpleShortcodes;

class Beans_Simple_Shortcodes_Registry {

	/**
	 * The array of enabled shortcodes.
	 */
	public $enabled_shortcodes;

	/**
	 * A single shortcode string
	 *
	 * Will be overwritten repeatedly as each shortcode from the array is mapped to it and processed.
	 */
	public $enabled_shortcode;


	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->enabled_shortcodes = Beans_Simple_Shortcodes()->enabled_shortcodes;

	}

	/**
	 * Initialize
	 */
	public function init() {

		array_map( array( $this, 'add_enabled_shortcodes' ), $this->enabled_shortcodes );

	}

	/**
	 * Add each shortcodes and it's functionality.
	 */
	public function add_enabled_shortcodes( $enabled_shortcode ) {

		$this->enabled_shortcode = $enabled_shortcode;

		add_shortcode( 'beans_' . $this->enabled_shortcode, __NAMESPACE__ . '\\' . $this->enabled_shortcode . '_shortcode' );

		include_once __DIR__ . "/shortcodes/" . $enabled_shortcode . ".php";

	}

}
