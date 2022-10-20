<?php
/**
 * BuddyPress - Members Loop
 *
 * @since 3.0.0
 * @version 6.0.0
 */

bp_nouveau_before_loop(); ?>

<?php if ( bp_get_current_member_type() ) : ?>
	<p class="current-member-type"><?php bp_current_member_type_message(); ?></p>
<?php endif; ?>

<?php require __DIR__ . "/bpFunctions.php";?>

<?php if ( bp_has_members( bp_ajax_querystring( 'members' ) ) ) : ?>

	<?php bp_nouveau_pagination( 'top' ); ?>

	<ul id="members-list" class="<?php bp_nouveau_loop_classes(); ?>">

	  <?php while ( bp_members() ) : bp_the_member(); ?>

	    <li class="item-entry">
        <div class="item-avatar">
          <a href="<?php bp_member_permalink();?>" class="avatar">
            <?php bp_member_avatar("type=full&width=150&height=150"); ?>
          </a>
        </div>

        <div class="item">
          <div class="item-title"><p class="item-title" href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></p></div>

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
          <div class="item-meta"><?php hibuddy_send_private_message_button(); ?></div>
          <div class="item-meta"><?php bp_add_friend_button(bp_get_member_user_id(),array( 'button_attr' => array( 'class' => 'ncs4-button ncs4-button__blue')))?></div>
          <div class="action"><?php do_action( 'bp_directory_members_actions' ); ?></div>

      </div> <!---items--->

        <div class="clear"></div>
      </li>
	  <?php endwhile; ?>
	</ul>


<?php
else :

	bp_nouveau_user_feedback( 'members-loop-none' );

endif;
?>

<?php bp_nouveau_after_loop(); ?>
