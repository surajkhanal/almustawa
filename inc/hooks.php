<?php
/**
 * Custom hooks
 *
 * @package UnderStrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'almustawa_site_info' ) ) {
	/**
	 * Add site info hook to WP hook library.
	 */
	function almustawa_site_info() {
		do_action( 'almustawa_site_info' );
	}
}

add_action( 'almustawa_site_info', 'almustawa_add_site_info' );
if ( ! function_exists( 'almustawa_add_site_info' ) ) {
	/**
	 * Add site info content.
	 */
	function almustawa_add_site_info() {
		$the_theme = wp_get_theme();

		$site_info = sprintf(
			'<a href="%1$s">%2$s</a><span class="sep"> | </span>%3$s(%4$s)',
			esc_url( __( 'https://wordpress.org/', 'almustawa' ) ),
			sprintf(
				/* translators: WordPress */
				esc_html__( 'Proudly powered by %s', 'almustawa' ),
				'WordPress'
			),
			sprintf( // WPCS: XSS ok.
				/* translators: 1: Theme name, 2: Theme author */
				esc_html__( 'Theme: %1$s by %2$s.', 'almustawa' ),
				$the_theme->get( 'Name' ),
				'<a href="' . esc_url( __( 'https://almustawa.com', 'almustawa' ) ) . '">almustawa.com</a>'
			),
			sprintf( // WPCS: XSS ok.
				/* translators: Theme version */
				esc_html__( 'Version: %1$s', 'almustawa' ),
				$the_theme->get( 'Version' )
			)
		);

		echo apply_filters( 'almustawa_site_info_content', $site_info ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
