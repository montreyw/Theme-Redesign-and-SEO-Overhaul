<?php
/*
Simple:Press Forum
Template Tag(s) - General
$LastChangedDate: 2009-08-16 09:18:18 -0700 (Sun, 16 Aug 2009) $
$Rev: 2336 $
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) {
	die('Access Denied');
}

/* 	=====================================================================================

	sf_sidedash_tag()

	Allows display of a common SPF dashboard on pages

	parameters:

		show_avatar		display user avatar						true/false								true
		show_pm			display pm template tag					true/false								true
		redirect		controls login/logout redirection		1=home, 2=admin, 3=cur page, 4=forum 	4
		show_admin_link	display link to admin dashboard			true/false								true
		show_login_link	display login form and lost pw link		true/false								true
 	===================================================================================*/

function sf_sidedash_tag($show_avatar=true, $show_pm=true, $redirect=4, $show_admin_link=true, $show_login_link=true)
{
	include_once (SF_PLUGIN_DIR.'/template-tags/sf-template-tags-pm.php');
	include_once (SF_PLUGIN_DIR.'/template-tags/sf-template-tags-avatars.php');

	global $current_user, $sfvars;

	sf_initialise_globals($sfvars['forumid']);

	$sflogin=get_option("sflogin");

	if ($redirect == 1)
	{
		$redirect_to = SFSITEURL;
	} else if ($redirect == 2) {
		$redirect_to = SFSITEURL.'wp-admin';
	} else if ($redirect == 3) {
		$redirect_to = $_SERVER['REQUEST_URI'];
	} else {
		$redirect_to = SFURL;
	}

	if($current_user->guest)
	{
	    # are we showing login form and lost password
		if ($show_login_link)
		{
			# display login form
			echo '<form action="'.SFSITEURL.'wp-login.php?action=login" method="post">'."\n";
			echo '<div class="sftagusername"><label for="sftaglog">'.__("Username: ", "sforum").'<input type="text" name="log" id="sftaglog" value="" size="15" /></label></div>'."\n";
			echo '<div class="sftagpassword"><label for="sftagpwd">'.__("Password: ", "sforum").'<input type="password" name="pwd" id="sftagpwd" value="" size="15"  /></label></div>'."\n";
			echo '<div class="sftagremember"><input type="checkbox" id="rememberme" name="rememberme" value="forever" /><label for="rememberme">'.__("Remember me", "sforum").'</label></div>';
			echo '<input type="submit" name="submit" id="submit" value="'.__("Login", "sforum").'" />'."\n";
			echo '<input type="hidden" name="redirect_to" value="'.wp_specialchars($redirect_to).'" />'."\n";
			echo '</form>'."\n";
			echo '<p class="sftagguest"><a href="'.$sflogin['sflostpassurl'].'">'.__("Lost Password", "sforum").'</a>'."\n";

		    # if registrations allowed, display register link
			if (get_option('users_can_register') == TRUE)
			{
				echo '<br /><a href="'.$sflogin['sfregisterurl'].'">'.__("Register", "sforum").'</a></p>'."\n";
			}
		}
	} else {
		echo '<div class="sftagavatar">'.sf_show_avatar().'</div>';
		echo '<p class="sftag-loggedin">'.__("Logged in as", "sforum").' <strong>'.stripslashes($current_user->display_name).'</strong></p>'."\n";
		sf_pm_tag(true, false);
		if ($show_admin_link)
		{
			echo '<p class="sftag-admin"><a href="'.SFSITEURL.'wp-admin'.'">'.__('Dashboard', "sforum").'</a></p>';
		}
		echo '<p class="sftag-logout"><a href="'.wp_nonce_url(SFSITEURL.'wp-login.php?action=logout&amp;redirect_to='.wp_specialchars($redirect_to), 'log-out').'">'.__('Logout', "sforum").'</a></p>'."\n";
	}
}


/* 	=====================================================================================

	sf_admin_mod_status($mod=true, $custom=true)

	displays online status of admins and moderators

	parameters:

		$mod			Display moderator status				true/false		true (default)
		$custom			Display custom status text if set		true/false		true (default)

 	===================================================================================*/

function sf_admin_mod_status($mod=true, $custom=true)
{
	global $wpdb;

	if(!defined('SFTRACK')) {
		sf_setup_sitewide_constants();
	}
	if(!defined('SFRESOURCES')) {
		sf_setup_global_constants();
	}

	sf_initialise_globals();

	$out = "\n";

	if ($mod) $where = ' OR moderator = 1';
	$admins = $wpdb->get_results("SELECT user_id, display_name, admin_options FROM ".SFMEMBERS." WHERE admin = 1".$where);
	if ($admins)
	{
		foreach ($admins as $admin)
		{
			$username = sf_build_name_display($admin->user_id, stripslashes($admin->display_name));
			$out.= '<li class="sfadmin-onlinestatus'."\n";
			$status = $wpdb->get_var("SELECT id FROM ".SFTRACK." WHERE trackuserid=".$admin->user_id);
			if ($status)
			{
				$out.= ' sfadmin-online"><img class="sfonline-icon" src="'.SFRESOURCES.'online.png" alt="" title="'.__("On-Line", "sforum").'" />'.$username."\n";
			} else {
				$out.= ' sfadmin-offline"><img class="sfonline-icon" src="'.SFRESOURCES.'offline.png" alt="" title="'.__("Off-Line", "sforum").'" />'.$username."\n";
				if ($custom)
				{
					$options = unserialize($admin->admin_options);
					if (isset($options['sfstatusmsgtext'])) 
					{
						$msg = stripslashes($options['sfstatusmsgtext']);
						if ($msg != '')
						{
							$out.= '<p class="sfcustom-onlinestatus">'.$msg.'</p>'."\n";
						}
					}
				}
			}
			$out.= '</li>'."\n";
		}
	} else {
		$out.= '<li class="sfadmin-onlinestatus">'."\n";
		$out.= __("No Admins or Moderators", "sforum")."\n";
		$out.= '</li>'."\n";
	}

	echo $out;
	return;
}

/* 	=====================================================================================

	sf_blog_linked_tag($postid, $show_img=true)

	Allows display of forum topic link for blog linked post outside of the post content

	parameters:

		$postid			id of the blog post					number				required
		$show_img		display blog linked image			true/fase			true
 	===================================================================================*/

function sf_blog_linked_tag($postid, $show_img=true)
{
	sf_initialise_globals();

	include_once(SF_PLUGIN_DIR.'/linking/sf-links-forum.php');

    $checkrow = sf_blog_links_postmeta('read', $postid, '');
    if ($checkrow)
    {
        $keys = explode('@', $checkrow->meta_value);

        $sfpostlinking = array();
        $sfpostlinking = get_option('sfpostlinking');
        $text = stripslashes($sfpostlinking['sflinkblogtext']);
        $icon = '<img src="'.SFRESOURCES.'bloglink.png" alt="" />';
        if ($show_img)
        {
        	$text = str_replace('%ICON%', $icon, $text);
       	} else {
        	$text = str_replace('%ICON%', '', $text);
		}

        $postcount = sf_get_posts_count_in_topic($keys[1]);
        $counttext = ' - ('.$postcount.') '.__("Posts", "sforum");
        echo '<span class="sfforumlink"><a href="'.sf_build_url(sf_get_forum_slug($keys[0]), sf_get_topic_slug($keys[1]), 1, 0).'">'.$text.'</a>'.$counttext.'</span>';
    }
}


/* 	=====================================================================================

	sf_new_posts_tag($unreadmsg='', $nonemsg='')

	Displays a message if the current user has unread posts. If a message is not supplied
	a default one is used

	parameters:

		$unreadmsg			message to display when unread			text		optional
		$nonemsg			message to display when no uread		text		optional
 	===================================================================================*/

function sf_new_posts_tag($unreadmsg='', $nonemsg='')
{
	global $current_user, $sfglobals, $wpdb;

	sf_initialise_globals();

	if ($current_user->guest || $sfglobals['member']['newposts'][0] != 0)
	{
		$sfposts[0] = 1;
	} else {
		$checktime = $sfglobals['member']['checktime'];
		$sfposts = $wpdb->get_col("SELECT DISTINCT topic_id FROM ".SFPOSTS." WHERE post_status = 0 AND (post_date > '".$checktime."') AND user_id != ".$current_user->ID." ORDER BY topic_id DESC LIMIT 1;");
	}

	if ($sfposts[0] != 0)
	{
		if ($unreadmsg != '')
		{
			echo $unreadmsg;
		} else {
			echo __('You have Unread Messages in the', 'sforum').' <a href="'.SFURL.'">'.__('Forum', 'sforum').' </a>.';
		}
	} else {
		if ($nonemsg = '')
		{
			echo $nonemsg;
		} else {
			echo __('You have no Unread Messages in the', 'sforum').' <a href="'.SFURL.'">'.__('Forum', 'sforum').' </a>.';
		}
	}

	return;
}
?>