<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package NCS4_Pro
 */

get_header();
?>

	<main id="primary" class="site-main">

		<section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Error 404: Page not found', 'ncs4-pro' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content" style="margin-bottom: 5rem;">
        <p>The page &ldquo;<?= $_SERVER['REQUEST_URI'] ?>&rdquo; could not be found.</p>
				<p><a href="/">Return home</a></p>
			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
