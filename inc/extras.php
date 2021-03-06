<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package UnderStrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

add_filter( 'body_class', 'almustawa_body_classes' );

if ( ! function_exists( 'almustawa_body_classes' ) ) {
	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 *
	 * @return array
	 */
	function almustawa_body_classes( $classes ) {
		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}
		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		return $classes;
	}
}

if ( function_exists( 'almustawa_adjust_body_class' ) ) {
	/*
	 * almustawa_adjust_body_class() deprecated in v0.9.4. We keep adding the
	 * filter for child themes which use their own almustawa_adjust_body_class.
	 */
	add_filter( 'body_class', 'almustawa_adjust_body_class' );
}

// Filter custom logo with correct classes.
add_filter( 'get_custom_logo', 'almustawa_change_logo_class' );

if ( ! function_exists( 'almustawa_change_logo_class' ) ) {
	/**
	 * Replaces logo CSS class.
	 *
	 * @param string $html Markup.
	 *
	 * @return string
	 */
	function almustawa_change_logo_class( $html ) {

		$html = str_replace( 'class="custom-logo"', 'class="img-fluid"', $html );
		$html = str_replace( 'class="custom-logo-link"', 'class="navbar-brand custom-logo-link"', $html );
		$html = str_replace( 'alt=""', 'title="Home" alt="logo"', $html );

		return $html;
	}
}

if ( ! function_exists( 'almustawa_post_nav' ) ) {
	/**
	 * Display navigation to next/previous post when applicable.
	 */
	function almustawa_post_nav() {
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}
		?>
		<nav class="container navigation post-navigation">
			<h2 class="sr-only"><?php esc_html_e( 'Post navigation', 'almustawa' ); ?></h2>
			<div class="row nav-links justify-content-between">
				<?php
				if ( get_previous_post_link() ) {
					previous_post_link( '<span class="nav-previous">%link</span>', _x( '<i class="fa fa-angle-left"></i>&nbsp;%title', 'Previous post link', 'almustawa' ) );
				}
				if ( get_next_post_link() ) {
					next_post_link( '<span class="nav-next">%link</span>', _x( '%title&nbsp;<i class="fa fa-angle-right"></i>', 'Next post link', 'almustawa' ) );
				}
				?>
			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
	}
}

if ( ! function_exists( 'almustawa_pingback' ) ) {
	/**
	 * Add a pingback url auto-discovery header for single posts of any post type.
	 */
	function almustawa_pingback() {
		if ( is_singular() && pings_open() ) {
			echo '<link rel="pingback" href="' . esc_url( get_bloginfo( 'pingback_url' ) ) . '">' . "\n";
		}
	}
}
add_action( 'wp_head', 'almustawa_pingback' );

if ( ! function_exists( 'almustawa_mobile_web_app_meta' ) ) {
	/**
	 * Add mobile-web-app meta.
	 */
	function almustawa_mobile_web_app_meta() {
		echo '<meta name="mobile-web-app-capable" content="yes">' . "\n";
		echo '<meta name="apple-mobile-web-app-capable" content="yes">' . "\n";
		echo '<meta name="apple-mobile-web-app-title" content="' . esc_attr( get_bloginfo( 'name' ) ) . ' - ' . esc_attr( get_bloginfo( 'description' ) ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'almustawa_mobile_web_app_meta' );

if ( ! function_exists( 'almustawa_default_body_attributes' ) ) {
	/**
	 * Adds schema markup to the body element.
	 *
	 * @param array $atts An associative array of attributes.
	 * @return array
	 */
	function almustawa_default_body_attributes( $atts ) {
		$atts['itemscope'] = '';
		$atts['itemtype']  = 'http://schema.org/WebSite';
		return $atts;
	}
}
add_filter( 'almustawa_body_attributes', 'almustawa_default_body_attributes' );

// Escapes all occurances of 'the_archive_description'.
add_filter( 'get_the_archive_description', 'almustawa_escape_the_archive_description' );

if ( ! function_exists( 'almustawa_escape_the_archive_description' ) ) {
	/**
	 * Escapes the description for an author or post type archive.
	 *
	 * @param string $description Archive description.
	 * @return string Maybe escaped $description.
	 */
	function almustawa_escape_the_archive_description( $description ) {
		if ( is_author() || is_post_type_archive() ) {
			return wp_kses_post( $description );
		}

		/*
		 * All other descriptions are retrieved via term_description() which returns
		 * a sanitized description.
		 */
		return $description;
	}
} // End of if function_exists( 'almustawa_escape_the_archive_description' ).

// Escapes all occurances of 'the_title()' and 'get_the_title()'.
add_filter( 'the_title', 'almustawa_kses_title' );

// Escapes all occurances of 'the_archive_title' and 'get_the_archive_title()'.
add_filter( 'get_the_archive_title', 'almustawa_kses_title' );

if ( ! function_exists( 'almustawa_kses_title' ) ) {
	/**
	 * Sanitizes data for allowed HTML tags for post title.
	 *
	 * @param string $data Post title to filter.
	 * @return string Filtered post title with allowed HTML tags and attributes intact.
	 */
	function almustawa_kses_title( $data ) {
		// Tags not supported in HTML5 are not allowed.
		$allowed_tags = array(
			'abbr'             => array(),
			'aria-describedby' => true,
			'aria-details'     => true,
			'aria-label'       => true,
			'aria-labelledby'  => true,
			'aria-hidden'      => true,
			'b'                => array(),
			'bdo'              => array(
				'dir' => true,
			),
			'blockquote'       => array(
				'cite'     => true,
				'lang'     => true,
				'xml:lang' => true,
			),
			'cite'             => array(
				'dir'  => true,
				'lang' => true,
			),
			'dfn'              => array(),
			'em'               => array(),
			'i'                => array(
				'aria-describedby' => true,
				'aria-details'     => true,
				'aria-label'       => true,
				'aria-labelledby'  => true,
				'aria-hidden'      => true,
				'class'            => true,
			),
			'code'             => array(),
			'del'              => array(
				'datetime' => true,
			),
			'ins'              => array(
				'datetime' => true,
				'cite'     => true,
			),
			'kbd'              => array(),
			'mark'             => array(),
			'pre'              => array(
				'width' => true,
			),
			'q'                => array(
				'cite' => true,
			),
			's'                => array(),
			'samp'             => array(),
			'span'             => array(
				'dir'      => true,
				'align'    => true,
				'lang'     => true,
				'xml:lang' => true,
			),
			'small'            => array(),
			'strong'           => array(),
			'sub'              => array(),
			'sup'              => array(),
			'u'                => array(),
			'var'              => array(),
		);
		$allowed_tags = apply_filters( 'almustawa_kses_title', $allowed_tags );

		return wp_kses( $data, $allowed_tags );
	}
} // End of if function_exists( 'almustawa_kses_title' ).


/**
 * Contact Info Shortcode
 * @description [contact_info]
 *
 * @return string
 * @since 1.0.0
 */
if( !function_exists('almustawa_contact_info_shortcode') ) {
	function almustawa_contact_info_shortcode($args, $content) {

		$email = get_theme_mod('emails');
		$phone_numbers = get_theme_mod('phone_numbers');
		$address = get_theme_mod('address');
		$working_hours = get_theme_mod('working_hours');

		$html = '';
		$html .= '<ul class="contact-info list-style-one">';
		if($email) {
			$html .= '<li><span class="icon fa fa-envelope"></span>'.esc_html($email).'</li>';
		}
		if($phone_numbers) {
			$html .= '<li><span class="icon fa fa-phone"></span>'.$phone_numbers.'</li>';
		}
		if($address) {
			$html .= '<li><span class="icon fa fa-map-marker"></span>'.esc_html($address).'</li>';
		}
		if($working_hours){
			$html .= '<li><span class="icon fa fa-clock-o"></span>'.esc_html($working_hours).' </li>';
		}
		
		$html .= '</ul>';
		return $html;
	}
	add_shortcode( 'contact_info' , 'almustawa_contact_info_shortcode' );
}


/**
 * Social Link Shortcode
 * @description [social_link]
 *
 * @return string
 * @since 1.0.0
 */
if( !function_exists('almustawa_social_link_shortcode') ) {
	function almustawa_social_link_shortcode($args, $content) {

		$facebook = get_theme_mod('facebook');
		$twitter = get_theme_mod('twitter');
		$linkedin = get_theme_mod('linkedin');
		$instagram = get_theme_mod('instagram');
		$pinterest = get_theme_mod('pinterest');


		$html = '';
		$html .= '<div class="upper-column">';
			$html .= '<ul class="social-links">';
				if(!empty($facebook)){
					$html .= '<li><a href="'.esc_attr($facebook).'"><span class="fa fa-facebook"></span></a></li>';
				}
				if(!empty($twitter)){
					$html .= '<li><a href="'.esc_attr($twitter).'"><span class="fa fa-twitter"></span></a></li>';
				}
				if(!empty($linkedin)) {
					$html .= '<li><a href="'.esc_attr($linkedin).'"><span class="fa fa-linkedin"></span></a></li>';
				}
				if(!empty($instagram)) {
					$html .= '<li><a href="'.esc_attr($instagram).'"><span class="fa fa-instagram"></span></a></li>';
				}
				if(!empty($pinterest)) {
					$html .= '<li><a href="'.esc_attr($pinterest).'"><span class="fa fa-pinterest"></span></a></li>';
				}

				$html .= '</ul>';
		$html .= '</div><!-- ./upper-column -->';
		return $html;
	}
	add_shortcode( 'social_link' , 'almustawa_social_link_shortcode' );
}
