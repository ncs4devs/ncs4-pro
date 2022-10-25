<?php 

/**
 * These functions below are responsible for the send message button on the members directory
 */

function aFunc() {
    return "Hi";
}

/**
 * Get the User Id in the current context
 *
 * @param int $user_id user id.
 *
 * @return int user_id
 */
function hibuddy_get_context_user_id( $user_id = 0 ) {

	if ( bp_is_my_profile() || ! is_user_logged_in() ) {
		return 0;
	}
	// for members loop.
	if ( ! $user_id ) {
		$user_id = bp_get_member_user_id();
	}

	// for user profile.
	if ( ! $user_id && bp_is_user() ) {
		$user_id = bp_displayed_user_id();
	}

	return apply_filters( 'hibuddy_get_context_user_id', $user_id );
}

function hibuddy_get_send_private_message_url() {

	$user_id = hibuddy_get_context_user_id();

	if ( ! $user_id || $user_id == bp_loggedin_user_id() ) {
		return;
	}

	if ( bp_is_my_profile() || ! is_user_logged_in() ) {
		return false;
	}

	return apply_filters( 'hibuddy_get_send_private_message_url', wp_nonce_url( bp_loggedin_user_domain() . bp_get_messages_slug() . '/compose/?r=' . bp_core_get_username( $user_id ) ) );
}

function hibuddy_get_send_private_message_button() {
	// get the user id to whom we are sending the message.
	$user_id = hibuddy_get_context_user_id();

	// don't show the button if the user id is not present or the user id is same as logged in user id.
	if ( ! $user_id || $user_id == bp_loggedin_user_id() ) {
		return;
	}
	$defaults = array(
		'id'                => 'private_message-' . $user_id,
		'component'         => 'messages',
		'must_be_logged_in' => true,
		'block_self'        => true,
		'wrapper_id'        => 'send-private-message-' . $user_id,
		'wrapper_class'     => 'send-private-message',
		'link_href'         => hibuddy_get_send_private_message_url(),
		'link_title'        => __( 'Send a private message to this user.', 'buddypress' ),
		'link_text'         => __( 'Message', 'buddypress' ),
		'link_class'        => 'send-message',
	);

	$btn = bp_get_button( $defaults );

	return apply_filters( 'hibuddy_get_send_private_message_button', $btn );
}

function hibuddy_send_private_message_button() {
	echo hibuddy_get_send_private_message_button();
}

/**
 * Use the appropriate Member header and enjoy a template hierarchy
 *
 * @since 3.0.0
 *
 * @return string HTML Output
 */
function ncs4_pro_member_header_template_part() {
	$template = 'member-header';

	if ( bp_displayed_user_use_cover_image_header() ) {
		$template = 'cover-image-header';
	}

	/**
	 * Fires before the display of a member's header.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_before_member_header' );

	// Get the template part for the header
	bp_nouveau_member_get_template_part( $template );

	/**
	 * Fires after the display of a member's header.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_after_member_header' );

}