<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package NCS4_Pro
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

  <?php ncs4_pro_post_thumbnail(); ?>

  <header class="entry-header ncs4-site-margin ncs4-site-margin__size-small">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
    ?>
    <hr class="post-title-seperator">
    <div class="entry-meta">
      <?php
      ncs4_pro_posted_on();
      //ncs4_pro_posted_by();
      ?>
    </div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
    if (is_archive() && has_excerpt()):
      ?>
      <div class="entry-excerpt ncs4-site-margin ncs4-site-margin__size-small">
        <?php
        the_excerpt(
  			 sprintf(
  				  wp_kses(
  					 /* translators: %s: Name of current post. Only visible to screen readers */
  					 __( 'Read more<span class="screen-reader-text"> "%s"</span>', 'ncs4-pro' ),
  					 array(
  						  'span' => array(
  							 'class' => array(),
  						  ),
  					 )
  				  ),
  				  wp_kses_post( get_the_title() )
  			 )
  		  );
        ?>
      </div><!-- .entry-excerpt -->
      <?php
    else:
      echo ncs4_get_the_content(
        __( 'Read more<span class="screen-reader-text"> "%s"</span>', 'ncs4-pro' )
      );
    endif;

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ncs4-pro' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer ncs4-site-margin ncs4-site-margin__size-small">
		<?php ncs4_pro_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
