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
	 *
	 * @since 1.0
	 */
	public function __construct() {

		$this->enabled_shortcodes = Beans_Simple_Shortcodes()->enabled_shortcodes;

	}

	/**
	 * Initialize
	 *
	 * Map each of the enabled shortcodes to a method to add them.
	 *
	 * @since 1.0
	 */
	public function init() {

		array_map( array( $this, 'add_enabled_shortcodes' ), $this->enabled_shortcodes );

	}

	/**
	 * Add each shortcodes and it's functionality by registering the shortcode
	 * and then including it from the shortcodes directory
	 *
	 * @since 1.0
	 *
	 * @param $enabled_shortcode string The individual shortcode to add.
	 */
	public function add_enabled_shortcodes( $enabled_shortcode ) {

		$this->enabled_shortcode = $enabled_shortcode;

		add_shortcode( 'beans_' . $this->enabled_shortcode, __NAMESPACE__ . '\\' . $this->enabled_shortcode . '_shortcode' );

		include_once __DIR__ . "/shortcodes/" . $enabled_shortcode . ".php";

	}

}
