<?php
/**
 * BuddyPress Members Directory
 *
 * @since 3.0.0
 * @version 6.0.0
 */

?>
<?php reblex_display_block(5371); // Connect Header ?>
  <div class="ncs4-site-margin ncs4-site-margin__size-small">
    <p style="margin-bottom:1.5em"><em>This page is currently under construction and will be updated soon.</em></p>
    <?php bp_nouveau_before_members_directory_content(); ?>

	  <?php if ( ! bp_nouveau_is_object_nav_in_sidebar() ) : ?>

		<?php bp_get_template_part( 'common/nav/directory-nav' ); ?>

	  <?php endif; ?>

	  <div class="screen-content">

	    <?php bp_get_template_part( 'common/search-and-filters-bar' ); ?>

      <div id="members-dir-list" class="members dir-list" data-bp-list="members">
        <div id="bp-ajax-loader"><?php bp_nouveau_user_feedback( 'directory-members-loading' ); ?></div>
      </div><!-- #members-dir-list -->

		  <?php bp_nouveau_after_members_directory_content(); ?>
    </div><!-- // .screen-content -->
  </div><!-- // .ncs4-site-margin -->
<?php bp_nouveau_after_directory_page(); ?>
