<?php get_header(); ?>

  <main
    id="primary"
    class="site-main site-main_redirect"
  >
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <div class="entry-content">
        <div
          class="ncs4-site-margin ncs4-site-margin__size-small wp-block-ncs4-custom-blocks-margin"
        >
          Lorem Ipsum dolor sit amet
        </div><!-- .ncs4-site-margin -->
      </div><!-- .entry-content -->
    </article><!-- #post-<?php the_ID(); ?> -->
  </main><!-- .site-main -->

<?php get_footer(); ?>
