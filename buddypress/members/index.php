<?php
/**
 * BuddyPress Members Directory
 *
 * @since 3.0.0
 * @version 6.0.0
 */

?>
<link rel="stylesheet" href="<?= get_stylesheet_directory_uri() . '/buddypress/members/members.css'?>" type="text/css">
<?php reblex_display_block(5371); // Connect Header ?>
  <div class="ncs4-site-margin ncs4-site-margin__size-small">
    <h1>Member Directory</h1>
    <p style="margin-bottom:1.5em"><em>This page is currently under construction and will be updated soon.</em></p>
    <?php bp_nouveau_before_members_directory_content(); ?>

	  <?php if ( ! bp_nouveau_is_object_nav_in_sidebar() ) : ?>

		<?php bp_get_template_part( 'common/nav/directory-nav' ); ?>

	  <?php endif; ?>

    <?php require __DIR__ . "/bpFunctions.php";?>

	  <div class="screen-content">

	    <?php bp_get_template_part( 'common/search-and-filters-bar' ); ?>

      <div id="members-dir-list" data-bp-list="members">

        <?php if ( bp_has_members( bp_ajax_querystring( 'members' ) ) ) : ?>
        
        <div id="pag-top" class="pagination">

          <div class="pag-count" id="member-dir-count-top">

            <?php bp_members_pagination_count(); ?>

          </div>

          <div class="pagination-links" id="member-dir-pag-top">

            <?php bp_members_pagination_links(); ?>

          </div>

        </div> <!---pag-top--->

        <?php do_action( 'bp_before_directory_members_list' ); ?>

        <ul id="members-list" role="main">

          <?php while ( bp_members() ) : bp_the_member(); ?>

            <li class="item-entry">
              <div class="item-avatar">
                <a href="<?php bp_member_permalink();?>" class="avatar">
                  <?php bp_member_avatar("type=full&width=150&height=150"); ?>
                </a>
              </div>

              <div class="item">
                <div class="item-title"><p class="item-title" href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></p>
                </div>

                <?php do_action( 'bp_directory_members_item' ); ?>

                <?php
                /***
                 * If you want to show specific profile fields here you can,
                 * but it'll add an extra query for each member in the loop
                 * (only one regardless of the number of fields you show):
                 *
                 * bp_member_profile_data( 'field=the field name' );
                */
                ?>

                
                <div><p class="organization-name"><?= bp_profile_field_data(array('field' => 2, 'user_id'=>bp_get_member_user_id())); ?></p></div>
                <div class="item-meta last-activity"><?php bp_member_last_active(); ?></div>
                <div class="item-meta friendship-button"><?php hibuddy_send_private_message_button(); ?></div>
                <div class="item-meta friendship-button"><span class="activity"><?php bp_add_friend_button()?></span></div>
                <div class="action"><?php do_action( 'bp_directory_members_actions' ); ?></div>

              </div> <!---items--->

              <div class="clear"></div>
            </li>
          <?php endwhile; ?>

        </ul> <!---members list--->

        <?php do_action( 'bp_after_directory_members_list' ); ?>

        <?php bp_member_hidden_fields(); ?>

        <!-- <div id="pag-bottom" class="pagination">

          <div class="pag-count" id="member-dir-count-bottom">

              <//?php bp_members_pagination_count(); ?>

          </div>

          <div class="pagination-links" id="member-dir-pag-bottom">

            <//?php bp_members_pagination_links(); ?>

          </div>

        </div> -->

        <?php else: ?>

          <div id="message" class="info">
            <p><?php _e( "Sorry, no members were found.", 'buddypress' ); ?></p>
          </div>

        <?php endif; ?>

      </div><!-- #members-dir-list -->

		  <?php bp_nouveau_after_members_directory_content(); ?>
    </div><!-- // .screen-content -->
  </div><!-- // .ncs4-site-margin -->
<?php bp_nouveau_after_directory_page(); ?>


