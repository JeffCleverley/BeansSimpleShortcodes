<?php
/**
 * Loads the Beans Simple Shortcodes Plugin
 *
 * @package    LearningCurve\BeansSimpleShortcodes
 * @since      1.0
 * @author     Jeff Cleverley
 * @link       https://learningcurve.xyz
 * @license    GNU-2.0+
 *
 * @wordpress-plugin
 * Plugin Name:     Beans Simple Shortcodes
 * Plugin URI:      http://github.com/JeffCleverley/BeansSimpleShortcodes
 * Description:     Beans Simple Shortcodes adds a selection of useful shortcodes for displaying post, theme, and author information more easily.
 * Version:         1.0
 * Author:          Jeff Cleverley
 * Author URI:      https://learningcurve.xyz
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:     beans-simple-shortcodes
 * Requires WP:     4.6
 * Requires PHP:    5.6
 */

namespace LearningCurve\BeansSimpleShortcodes;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Hello, Hello, Hello, what\'s going on here then?' );
}

define( 'BEANS_SIMPLE_SHORTCODES', 'beans-simple-shortcodes' ); //Text domain
define( 'BEANS_SIMPLE_SHORTCODES_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'BEANS_SIMPLE_SHORTCODES_DIR_PATH', plugin_dir_path( __FILE__ ) );


register_activation_hook( __FILE__, __NAMESPACE__ . '\deactivate_when_beans_not_activated_theme' );
add_action( 'switch_theme', __NAMESPACE__ . '\deactivate_when_beans_not_activated_theme' );
/**
 * If Beans is not the activated theme, deactivate this plugin and pop a die message when not switching themes.
 *
 * @since 1.0
 *
 * @return void
 */
function deactivate_when_beans_not_activated_theme() {

	// If Beans is the active theme, bail out.
	$theme = wp_get_theme();

	if ( in_array( $theme->template, array( 'beans', 'tm-beans' ), true ) ) {
		return;
	}

	deactivate_plugins( plugin_basename( __FILE__ ) );

	if ( current_filter() !== 'switch_theme' ) {
		$message = __( 'Sorry, you can\'t activate this plugin unless the <a href="https://www.getbeans.io" target="_blank">Beans</a> framework is installed and a child theme is activated.', BEANS_SIMPLE_SHORTCODES );
		wp_die( wp_kses_post( $message ) );
	}

}

/**
 * Autoload the plugin's files.
 *
 * @since 1.0
 *
 * @return void
 */
function autoload_files() {

	$files = array(
		'/config/shortcodes.php',
		'class-beans-simple-shortcodes.php',
	);

	foreach ( $files as $file ) {
		require __DIR__ . '/src/' . $file;
	}

}


/**
 * Launch the plugin.
 *
 * @since 1.0
 *
 * @return void
 */
function launch() {

	autoload_files();

}

launch();


