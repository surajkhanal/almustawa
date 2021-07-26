<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package UnderStrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'almustawa_container_type' );
?>

<div class="wrapper" id="error-404-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<div class="col-md-12 content-area" id="primary">

				<main class="site-main" id="main">

					<section class="error-404 not-found">

						<header class="page-header">
							<h1>404</h1>

							<h2 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'almustawa' ); ?></h2>

						</header><!-- .page-header -->

						<div class="page-content">

							<p ><?php esc_html_e( 'Can not find what you need? Take a moment and do a search below or start from our ', 'almustawa' ); ?><a href="/"><strong>Homepage</strong></a>.</p>

							<?php //get_search_form(); ?>

						</div><!-- .page-content -->

					</section><!-- .error-404 -->

				</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #error-404-wrapper -->

<?php
get_footer();
