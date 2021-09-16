<?php
/**
 * The template for displaying the front (home) page
 *
 * This displays only the front page, and affects no other pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package NCS4_Pro
 *
 */

get_header();
?>
  <style><?php include get_stylesheet_directory() . '/front-page.css'; ?></style>
  <main id="primary" class="site-main site-main__front-page">

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <div class="entry-content entry-content__front-page">
        <?php
        the_content();
        ?>
      </div><!-- .entry-content -->
    </article><!-- #post-<?php the_ID(); ?> -->
  </main><!-- .site-main -->

<?php
get_footer();
