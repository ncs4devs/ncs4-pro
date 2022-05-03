<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package NCS4_Pro
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header ncs4-site-margin ncs4-site-margin__size-large">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->
      <div class="archive-content ncs4-site-margin ncs4-site-margin__size-large">
        <div class="archive-content__inner">
          <?php
		      /* Start the Loop */
          while ( have_posts() ) :
            the_post();

            /*
	           * Include the Post-Type-specific template for the content.
		        * If you want to override this in a child theme, then include a file
		        * called content-___.php (where ___ is the Post Type name) and that will be used instead.
		        */
            get_template_part( 'template-parts/content', get_post_type() );

          endwhile;
          ?>
        </div><!-- .archive-content__inner -->
        <?php
        the_posts_navigation();
        ?>
     </div><!-- .archive-content -->
    <?php
		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
    <style><?php include get_stylesheet_directory() . '/archive.css'; ?></style>
	</main><!-- #main -->

<?php
get_footer();
