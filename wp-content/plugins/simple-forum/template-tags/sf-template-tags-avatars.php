<?php
/*
Simple:Press Forum
Avatar Template Tag(s)
$LastChangedDate: 2009-09-10 13:49:02 -0700 (Thu, 10 Sep 2009) $
$Rev: 2473 $
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) {
	die('Access Denied');
}

/* 	=====================================================================================

	sf_show_avatar($size=0)

	displays avatar of current user

	parameters:
		$size:			Size to display avatar (applied to width) Leave as 0
						to use size of graphic.

	returns:		<img> class = 'sfavatartag'
 	===================================================================================*/


function sf_show_avatar($size=0)
{
	global $current_user;

	if($current_user->guest) $icon='guest';
	if($current_user->member) $icon='user';
	if($current_user->forumadmin) $icon='admin';

	echo sf_render_avatar($icon, $current_user->ID, $current_user->user_email, $current_user->guestemail, sf_get_member_item($current_user->ID, 'avatar'), true, $size);
	return;
}

/* 	=====================================================================================

	sf_show_members_avatar($userid, $size=0)

	displays avatar of current user

	parameters:
		$userid:		Requires the userid whose avatar is being requested.
		$size:			Size to display avatar (applied to width) Leave as 0
						to use size of graphic.

	returns:		<img> class = 'sfavatartag'
 	===================================================================================*/

function sf_show_members_avatar($userid, $size=0)
{
	global $wpdb;

	if(empty($userid)) return;

	$user = $wpdb->get_row("SELECT user_email FROM ".SFUSERS." WHERE ID = ".$userid);
	if ($user)
	{
		if (sf_is_forum_admin($userid) ? $icon='admin' : $icon='user');
		echo sf_render_avatar($icon, $userid, $user->user_email, sf_get_member_item($userid, 'avatar'), '', true, $size);
	}
	return;
}

/* 	=====================================================================================

	sf_show_forum_avatar($email, $size=0)

	displays avatar of current user or guest oulled form the forum

	parameters:
		$email:			Requires the email address whose avatar is being requested.
		$size:			Size to display avatar (applied to width) Leave as 0
						to use size of graphic.

	returns:		<img> class = 'sfavatartag'
 	===================================================================================*/

function sf_show_forum_avatar($email, $size=0)
{
	global $wpdb;

	$userid = $wpdb->get_var("SELECT ID FROM ".SFUSERS." WHERE user_email = '".$email."'");
	if ($userid)
	{
		$icon = 'user';
		if (sf_is_forum_admin($userid)) $icon='admin';
		echo sf_render_avatar($icon, $userid, $email, '', sf_get_member_item($userid, 'avatar'), true, $size);
	} else {
		$icon = 'guest';
		echo sf_render_avatar($icon, 0, '', $email, '', true, $size);
	}
	return;
}


?>