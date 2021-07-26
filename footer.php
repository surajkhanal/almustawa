<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package UnderStrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

$container = get_theme_mod('almustawa_container_type');
?>

<?php get_template_part('sidebar-templates/sidebar', 'footerfull'); ?>

<footer class="footer">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 mb-4">
				<?php if (is_active_sidebar('footer1')) : ?>

					<?php dynamic_sidebar('footer1'); ?>

				<?php endif; ?>
			</div>
			<div class="col-lg-4 mb-4">
				<?php if (is_active_sidebar('footer2')) : ?>

					<?php dynamic_sidebar('footer2'); ?>

				<?php endif; ?>
			</div>
			<div class="col-lg-4 mb-4">
				<?php if (is_active_sidebar('footer3')) : ?>

					<?php dynamic_sidebar('footer3'); ?>

				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="footer-bottom">
		<div class="container">
			<p class="text-center">© <?php echo date('Y');?> Al Mustawa Transport. All right reserved.</p>
		</div>
	</div>
</footer>

</div><!-- #page we need this extra closing tag here -->

<a href="#top" id="to-top-button" title="Return to Top" style="bottom: 32px; opacity: 1;">
	<span class="icon fa fa-chevron-up"></span>
</a>

<?php wp_footer(); ?>

</body>

</html>