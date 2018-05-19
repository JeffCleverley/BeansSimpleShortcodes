<?php
namespace LearningCurve\BeansSimpleShortcodes;

class Beans_Simple_Shortcodes_Core {

	/**
	 * The plugin textdomain, for translations.
	 */
	public $plugin_textdomain;

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

		$this->plugin_textdomain  = Beans_Simple_Shortcodes()->plugin_textdomain;
		$this->enabled_shortcodes = Beans_Simple_Shortcodes()->enabled_shortcodes;

	}

	/**
	 * Initialize
	 */
	public function init() {

		array_map( array( $this, 'register_shortcodes' ), $this->enabled_shortcodes );

	}

	/**
	 * Add each shortcodes and it's functionality.
	 */
	public function register_shortcodes( $enabled_shortcode ) {

		$this->enabled_shortcode = $enabled_shortcode;

		add_shortcode( 'beans_' . $this->enabled_shortcode, __NAMESPACE__ . '\\' . $this->enabled_shortcode . '_shortcode' );

		include_once __DIR__ . "/shortcodes/" . $enabled_shortcode . ".php";

	}

	/**********************************************************************************************************************
	 **********************************************************************************************************************
	 *
	 *      [beans_childtheme_link]
	 *
	 * Shortcode that adds a link to the child theme within a span element, if the details are defined.
	 *
	 * Outputted child theme details can still be adjusted using shortcode attributes.
	 *
	 * Supported shortcode attributes are:
	 *          before              Output after link but inside span, default is empty string.
	 *          after               Output after link but inside span, default is empty string.
	 *          child-theme-name    Name of the child theme, default is the defined CHILD_THEME_NAME.
	 *          child-theme-url     URL of the child theme, default is the defined CHILD_THEME_URL.
	 *
	 * Defaults pass through `childtheme_link_shortcode_defaults` filter.
	 * Output passes through `childtheme_link_shortcode` filter before returning.
	 *
	 * @since   1.0
	 *
	 * @param   array|string $atts Shortcode attributes. Empty string if no attributes.
	 *
	 * @return  string $output Return empty string early if not a child theme.
	 *                         Return empty string if `CHILD_THEME_NAME` or `CHILD_THEME_URL` are not defined.
	 *                         Otherwise returns output for [beans_childtheme_link] shortcode.
	 */
	function childtheme_link_shortcode( $atts ) {

		if ( ! is_child_theme() ) {
			return '';
		}

		if ( ! defined( 'CHILD_THEME_NAME' ) || ! defined( 'CHILD_THEME_URL' ) ) {
			return '';
		}

		$defaults = array(
			'after'            => '',
			'before'           => '',
			'child-theme-name' => CHILD_THEME_NAME,
			'child-theme-url'  => CHILD_THEME_URL,
		);

		/**
		 * Child theme Link shortcode defaults filter.
		 *
		 * Allows the default args in the Child Theme Link shortcode function to be more easily filtered.
		 *
		 * @since   1.0
		 *
		 * @param   array $defaults The default args array.
		 */
		$defaults = apply_filters( 'childtheme_link_shortcode_defaults', $defaults );

		$atts = shortcode_atts( $defaults, $atts, 'childtheme_link' );

		// Use the output buffer to ensure everything renders in order
		ob_start();

		beans_open_markup_e( 'beans_simple_childtheme_link_span', 'span', array(
			'style' => 'color:inherit;',
		) );

		beans_output_e( 'beans_simple_childtheme_link_text_prefix', $atts['before'] );

		beans_open_markup_e( 'beans_simple_childtheme_link', 'a', array(
			'href' => $atts['child-theme-url'],
		) );

		beans_output_e( 'beans_simple_childtheme_link_text', $atts['child-theme-name'] );

		beans_close_markup_e( 'beans_simple_childtheme_link', 'a' );

		beans_output_e( 'beans_simple_childtheme_link_text_suffix', $atts['after'] );

		beans_close_markup_e( 'beans_simple_childtheme_link_span', 'span' );

		$output = ob_get_clean();

		/**
		 * Child theme link shortcode filter.
		 *
		 * Allows the output and the attributes of the Child theme link shortcode function to be filtered.
		 *
		 * @since   1.0
		 *
		 * @param   string $output   The returned output of the shortcode.
		 * @param   array  $defaults The shortcode attributes array.
		 */
		return apply_filters( 'childtheme_link_shortcode', $output, $atts );

	}


	/**********************************************************************************************************************
	 **********************************************************************************************************************
	 *
	 *      [beans_theme_link]
	 *
	 * Shortcode that adds a link to the Beans Theme Framework within a span element.
	 *
	 * Supported shortcode attributes are:
	 *          before      Output after link but inside span, default is empty string.
	 *          after       Output after link but inside span, default is empty string.
	 *          beans       Name of Beans theme, default is 'Beans'.
	 *          beans-url   Url of the Beans theme framework, default is https://getbeans.io/.
	 *
	 * Defaults pass through `beans_link_shortcode_defaults` filter.
	 * Output passes through `beans_link_shortcode` filter before returning.
	 *
	 * @since   1.1.0
	 *
	 * @param   array|string $atts Shortcode attributes. Empty string if no attributes.
	 *
	 * @return  string $output Output for [beans_link] shortcode.
	 */
	function theme_link_shortcode( $atts ) {

		$defaults = array(
			'before'    => '',
			'after'     => '',
			'beans'     => __( 'Beans', BEANS_SIMPLE_SHORTCODES ),
			'beans-url' => 'https://getbeans.io',
		);

		/**
		 * Beans Link shortcode defaults filter.
		 *
		 * Allows the default args in the Beans Link shortcode function to be more easily filtered.
		 *
		 * @since   1.0
		 *
		 * @param   array $defaults The default args array.
		 */
		$defaults = apply_filters( 'beans_link_shortcode_defaults', $defaults );

		$atts = shortcode_atts( $defaults, $atts, 'beans_link' );

		// Use the output buffer to ensure everything renders in order
		ob_start();

		beans_open_markup_e( 'beans_simple_beans_link_span', 'span', array(
			'style' => 'color:inherit;',
		) );

		beans_output_e( 'beans_simple_beans_link_text_prefix', $atts['before'] );

		beans_open_markup_e( 'beans_simple_beans_link', 'a', array(
			'href' => $atts['beans-url'],
		) );

		beans_output_e( 'beans_simple_beans_link_text', $atts['beans'] );

		beans_close_markup_e( 'beans_simple_beans_link', 'a' );

		beans_output_e( 'beans_simple_beans_link_text_suffix', $atts['after'] );

		beans_close_markup_e( 'beans_simple_beans_link_span', 'span' );

		$output = ob_get_clean();

		/**
		 * Beans link shortcode filter.
		 *
		 * Allows the output and the attributes of the Beans theme link shortcode function to be filtered.
		 *
		 * @since   1.0
		 *
		 * @param   string $output   The returned output of the shortcode.
		 * @param   array  $defaults The shortcode attributes array.
		 */
		return apply_filters( 'beans_link_shortcode', $output, $atts );

	}


	/**********************************************************************************************************************
	 * ********************************************************************************************************************
	 *
	 *      [beans_wordpress_link]
	 *
	 * Shortcode that adds a link to WordPress.org inside a span element.
	 *
	 * Supported shortcode attributes are:
	 *          before          Output before link but inside span, default is empty string.
	 *          after           Output after link but inside span, default is empty string.
	 *          wordpress       Name of Beans theme, default is 'Beans.
	 *          wordpress-url   Url of the Beans theme framework, default is https://wordpress.org/.
	 *
	 * Defaults pass through `wordpress_link_shortcode_defaults` filter.
	 * Output passes through `wordpress_link_shortcode` filter before returning.
	 *
	 * @since 1.1.0
	 *
	 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
	 *
	 * @return string $output Output for [beans_wordpress_link] shortcode.
	 */
	function wordpress_link_shortcode( $atts ) {

		$defaults = array(
			'before'        => '',
			'after'         => '',
			'wordpress'     => __( 'WordPress', BEANS_SIMPLE_SHORTCODES ),
			'wordpress-url' => 'https://wordpress.org/',
		);

		/**
		 * WordPress Link shortcode defaults filter.
		 *
		 * Allows the default args in the WordPress Link shortcode function to be more easily filtered.
		 *
		 * @since   1.0
		 *
		 * @param   array $defaults The default args array.
		 */
		$defaults = apply_filters( 'wordpress_link_shortcode_defaults', $defaults );

		$atts = shortcode_atts( $defaults, $atts, 'wordpress_link' );

		// Use the output buffer to ensure everything renders in order
		ob_start();

		beans_open_markup_e( 'beans_simple_wordpress_link_span', 'span', array(
			'style' => 'color:inherit;',
		) );

		beans_output_e( 'beans_simple_wordpress_link_text_prefix', $atts['before'] );

		beans_open_markup_e( 'beans_simple_wordpress_link', 'a', array(
			'href' => $atts['wordpress-url'],
		) );

		beans_output_e( 'beans_simple_wordpress_link_text', $atts['wordpress'] );

		beans_close_markup_e( 'beans_simple_wordpress_link', 'a' );

		beans_output_e( 'beans_simple_wordpress_link_text_suffix', $atts['after'] );

		beans_close_markup_e( 'beans_simple_wordpress_link_span', 'span' );

		$output = ob_get_clean();

		/**
		 * WordPress link shortcode filter.
		 *
		 * Allows the output and the attributes of the WordPress link shortcode function to be filtered.
		 *
		 * @since   1.0
		 *
		 * @param   string $output   The returned output of the shortcode.
		 * @param   array  $defaults The shortcode attributes array.
		 */
		return apply_filters( 'wordpress_link_shortcode', $output, $atts );

	}


	/**********************************************************************************************************************
	 **********************************************************************************************************************
	 *
	 *      [beans_site_title]
	 *
	 * Shortcode displays the unlinked site title inside a span element
	 *
	 * Supported shortcode attributes are:
	 *          before      Output before link but inside span, default is empty string.
	 *          after       Output after link but inside span, default is empty string.
	 *
	 * Defaults pass through `wordpress_link_shortcode_defaults` filter.
	 * Output passes through `site_title_shortcode` filter before returning.
	 *
	 * @since   1.0
	 *
	 * @param   array|string $atts Shortcode attributes. Empty string if no attributes.
	 *
	 * @return  string $output Output for [beans_site_title] shortcode.
	 */
	function site_title_shortcode( $atts ) {

		$defaults = array(
			'before' => '',
			'after'  => '',
		);

		/**
		 * Site title shortcode defaults filter.
		 *
		 * Allows the default args in the site title shortcode function to be more easily filtered.
		 *
		 * @since   1.0
		 *
		 * @param   array $defaults The default args array.
		 */
		$defaults = apply_filters( 'site_title_shortcode_defaults', $defaults );

		$atts = shortcode_atts( $defaults, $atts, 'site_title' );

		// Use the output buffer to ensure everything renders in order
		ob_start();

		beans_open_markup_e( 'beans_simple_site_title', 'span', array(
			'style' => 'color:inherit;',
		) );

		beans_output_e( 'beans_simple_site_title_text_prefix', $atts['before'] );

		beans_output_e( 'beans_simple_site_title_text', get_bloginfo( 'name' ) );

		beans_output_e( 'beans_simple_site_title_text_suffix', $atts['after'] );

		beans_close_markup_e( 'beans_simple_site_title', 'span' );

		$output = ob_get_clean();

		/**
		 * Site title shortcode filter.
		 *
		 * Allows the output and the attributes of the site title shortcode function to be filtered.
		 *
		 * @since   1.0
		 *
		 * @param   string $output   The returned output of the shortcode.
		 * @param   array  $defaults The shortcode attributes array.
		 */
		return apply_filters( 'site_title_shortcode', $output, $atts );

	}

	/**********************************************************************************************************************
	 **********************************************************************************************************************
	 *
	 *      [beans_home_link]
	 *
	 * Shortcode displays a link to the home page inside a span element
	 *
	 * Supported shortcode attributes are:
	 *          before      Output before link but inside span, default is empty string.
	 *          after       Output after link but inside span, default is empty string.
	 *
	 * Defaults pass through `home_link_shortcode_defaults` filter.
	 * Output passes through `home_link_shortcode` filter before returning.
	 *
	 * @since   1.0
	 *
	 * @param   array|string $atts Shortcode attributes. Empty string if no attributes.
	 *
	 * @return  string $output Output for [beans_home_link] shortcode.
	 */
	function home_link_shortcode( $atts ) {

		$defaults = array(
			'after'  => '',
			'before' => '',
		);

		/**
		 * Home link shortcode defaults filter.
		 *
		 * Allows the default args in the home link shortcode function to be more easily filtered.
		 *
		 * @since   1.0
		 *
		 * @param   array $defaults The default args array.
		 */
		$defaults = apply_filters( 'home_link_shortcode_defaults', $defaults );

		$atts = shortcode_atts( $defaults, $atts, 'home_link' );

		// Use the output buffer to ensure everything renders in order
		ob_start();

		beans_open_markup_e( 'beans_simple_home_link_span', 'span', array(
			'style' => 'color:inherit;',
		) );

		beans_output_e( 'beans_simple_home_link_text_prefix', $atts['before'] );

		beans_open_markup_e( 'beans_simple_home_link', 'a', array(
			'href' => home_url(),
		) );

		beans_output_e( 'beans_simple_home_link_text', get_bloginfo( 'name' ) );

		beans_close_markup_e( 'beans_simple_home_link', 'a' );

		beans_output_e( 'beans_simple_home_link_text_suffix', $atts['after'] );

		beans_close_markup_e( 'beans_simple_home_link_span', 'span' );

		$output = ob_get_clean();

		/**
		 * Home link shortcode filter.
		 *
		 * Allows the output and the attributes of the home link shortcode function to be filtered.
		 *
		 * @since   1.0
		 *
		 * @param   string $output   The returned output of the shortcode.
		 * @param   array  $defaults The shortcode attributes array.
		 */
		return apply_filters( 'home_link_shortcode', $output, $atts );

	}

	/**********************************************************************************************************************
	 **********************************************************************************************************************
	 *
	 *      [beans_loginout]
	 *
	 * Shortcode displays an admin login / logout link inside a span element, depending on whether a user is logged in or out.
	 *
	 * Support shortcode attributes are:
	 *      before-login        Output before login link but inside the span, default is empty string.
	 *      before-logout       Output before logout link but inside the span, default is empty string.
	 *      after-login         Output after login link but inside the span, default is empty string.
	 *      after-logout        Output after logout link but inside the span, default is empty string.
	 *      login-text          Text for the login link, default is 'Log in'.
	 *      logout-text         Text for the login link, default is 'Log out'.
	 *      login-redirect      Redirect page path after login, default is empty string - must be absolute path.
	 *      logout-redirect     Redirect page path after logout, default is home_url() - must be absolute path.
	 *
	 * Defaults pass through `loginout_shortcode_defaults` filter.
	 * Output passes through `loginout_shortcode` filter before returning.
	 *
	 * @since   1.0
	 *
	 * @param   array|string $atts Shortcode attributes. Empty string if no attributes.
	 *
	 * @return  string $output Output for [beans_loginout] shortcode.
	 */
	function loginout_shortcode( $atts ) {

		$defaults = array(
			'before-login'    => '',
			'before-logout'   => '',
			'after-login'     => '',
			'after-logout'    => '',
			'login-text'      => __( 'Log in', BEANS_SIMPLE_SHORTCODES ),
			'logout-text'     => __( 'Log out', BEANS_SIMPLE_SHORTCODES ),
			'login-redirect'  => '',
			'logout-redirect' => home_url(),
		);

		/**
		 * Loginout shortcode defaults filter.
		 *
		 * Allows the default args in the loginout shortcode function to be more easily filtered.
		 *
		 * @since   1.0
		 *
		 * @param   array $defaults The default args array.
		 */
		$defaults = apply_filters( 'home_link_shortcode_defaults', $defaults );

		$atts = shortcode_atts( $defaults, $atts, 'loginout' );

		// Use the output buffer to ensure everything renders in order
		ob_start();

		beans_open_markup_e( 'beans_simple_loginout_span', 'span', array(
			'style' => 'color:inherit;',
		) );

		if ( ! is_user_logged_in() ) {

			beans_output_e( 'beans_simple_login_text_prefix', $atts['before-login'] );

			beans_open_markup_e( 'beans_simple_login_link', 'a', array(
				'href' => esc_url( wp_login_url( $atts['login-redirect'] ) ),
			) );

			beans_output_e( 'beans_simple_login_text', $atts['login-text'] );

			beans_close_markup_e( 'beans_simple_login_link', 'a' );

			beans_output_e( 'beans_simple_login_text_suffix', $atts['after-login'] );

		} else {

			beans_output_e( 'beans_simple_logout_text_prefix', $atts['before-logout'] );

			beans_open_markup_e( 'beans_simple_logout_link', 'a', array(
				'href' => esc_url( wp_logout_url( $atts['logout-redirect'] ) ),
			) );

			beans_output_e( 'beans_simple_logout_text', $atts['logout-text'] );

			beans_close_markup_e( 'beans_simple_logout_link', 'a' );

			beans_output_e( 'beans_simple_logout_text_suffix', $atts['after-logout'] );
		}

		beans_close_markup_e( 'beans_simple_loginout_span', 'span' );

		$output = ob_get_clean();

		/**
		 * Loginout shortcode filter.
		 *
		 * Allows the output and the attributes of the loginout shortcode function to be filtered.
		 *
		 * @since   1.0
		 *
		 * @param   string $output   The returned output of the shortcode.
		 * @param   array  $defaults The shortcode attributes array.
		 */
		return apply_filters( 'loginout_shortcode', $output, $atts );

	}
}
