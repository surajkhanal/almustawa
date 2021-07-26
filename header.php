<?php

/**
 * The header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package UnderStrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

$container = get_theme_mod('almustawa_container_type');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php almustawa_body_attributes(); ?>>
	<?php do_action('wp_body_open'); ?>
	<div class="site" id="page">
		<a id="top"></a>
		<!-- ******************* The Navbar Area ******************* -->
		<header class="main-header" id="wrapper-navbar">

			<a class="skip-link sr-only sr-only-focusable" href="#content"><?php esc_html_e('Skip to content', 'almustawa'); ?></a>

			<div class="header-top">
				<div class="container header-top-inner">
					<div class="top-left ">
						<ul class="info-box ">
							<li><i class="fa fa-phone"></i><?php echo get_theme_mod('phone_numbers'); ?></li>
							<!-- <li><i class="fa fa-envelope-open"></i><?php //echo get_theme_mod('emails'); ?></li> -->
							<li><i class="fa fa-clock-o"></i><?php echo get_theme_mod('working_hours'); ?></li>
						</ul>
					</div>
					<div class="top-right">
						<?php echo do_shortcode('[social_link]'); ?>
					</div>
				</div>
			</div>

			<nav id="main-nav" class="navbar navbar-expand-md navbar-light bg-white shadow-sm" aria-labelledby="main-nav-label">

				<h2 id="main-nav-label" class="sr-only">
					<?php esc_html_e('Main Navigation', 'almustawa'); ?>
				</h2>

				<?php if ('container' === $container) : ?>
					<div class="container">
					<?php endif; ?>

					<!-- Your site title as branding in the menu -->
					<?php if (!has_custom_logo()) { ?>

						<?php if (is_front_page() && is_home()) : ?>

							<h1 class="navbar-brand mb-0"><a rel="home" href="<?php echo esc_url(home_url('/')); ?>" itemprop="url"><?php bloginfo('name'); ?></a></h1>

						<?php else : ?>

							<a class="navbar-brand" rel="home" href="<?php echo esc_url(home_url('/')); ?>" itemprop="url"><?php bloginfo('name'); ?></a>

						<?php endif; ?>

					<?php
					} else {
						the_custom_logo();
					}
					?>
					<!-- end custom logo -->

					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'almustawa'); ?>">
						<span class="navbar-toggler-icon"></span>
					</button>

					<!-- The WordPress Menu goes here -->
					<?php
					wp_nav_menu(
						array(
							'theme_location'  => 'primary',
							'container_class' => 'collapse navbar-collapse',
							'container_id'    => 'navbarNavDropdown',
							'menu_class'      => 'navbar-nav ml-auto',
							'fallback_cb'     => '',
							'menu_id'         => 'main-menu',
							'depth'           => 2,
							'walker'          => new Almustawa_WP_Bootstrap_Navwalker(),
						)
					);
					?>
					<!-- <a href="#order" class="btn btn-primary btn-order">Order Now</a> -->
					<?php if ('container' === $container) : ?>
					</div><!-- .container -->
				<?php endif; ?>

			</nav><!-- .site-navigation -->

		</header><!-- #wrapper-navbar end -->