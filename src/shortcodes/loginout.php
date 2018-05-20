<?php

namespace LearningCurve\BeansSimpleShortcodes;

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
 *      span-class          Additional classes to add to the span element, default is empty string.
 *      span-style          Inline CSS to style the span element, default is empty string.
 *      link-class          Additional classes to add to the link anchor element, default is empty string.
 *      link-style          Inline CSS to style the link anchor element, default is empty string.
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
		'span-class'      => '',
		'span-style'      => '',
		'link-class'      => '',
		'link-style'      => '',
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
		'class' => $atts['span-class'],
		'style' => 'color:inherit; ' . $atts['span-style'],
	) );

	if ( ! is_user_logged_in() ) {

		beans_output_e( 'beans_simple_login_text_prefix', $atts['before-login'] );

		beans_open_markup_e( 'beans_simple_login_link', 'a', array(
			'href' => esc_url( wp_login_url( $atts['login-redirect'] ) ),
			'class' => $atts['link-class'],
			'style' => $atts['link-style'],
		) );

		beans_output_e( 'beans_simple_login_text', $atts['login-text'] );

		beans_close_markup_e( 'beans_simple_login_link', 'a' );

		beans_output_e( 'beans_simple_login_text_suffix', $atts['after-login'] );

	} else {

		beans_output_e( 'beans_simple_logout_text_prefix', $atts['before-logout'] );

		beans_open_markup_e( 'beans_simple_logout_link', 'a', array(
			'href' => esc_url( wp_logout_url( $atts['logout-redirect'] ) ),
			'class' => $atts['link-class'],
			'style' => $atts['link-style'],
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