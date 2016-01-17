<?php
/*
Simple:Press Forum
Template Tag(s) - Lists
$LastChangedDate: 2009-08-28 16:14:48 -0700 (Fri, 28 Aug 2009) $
$Rev: 2419 $
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) {
	die('Access Denied');
}

/* 	=====================================================================================

	sf_recent_posts_tag($limit, $forum, $user, $postdate, $listtags, $forumids)

	displays the most recent topics to have received a new post

	parameters:

		$limit			How many items to show in the list		number			5
		$forum			Show the Forum Title					true/false		false
		$user			Show the Users Name						true/false		true
		$postdate		Show date of posting					true/false		false
		$listtags		Wrap in <li> tags (li only)				true/false		true
		$forumids		comma delimited list of forum id's		optional		0
		$posttime		Show time of posting (reqs postdate)	true/false		false

 	===================================================================================*/

function sf_recent_posts_tag($limit=5, $forum=false, $user=true, $postdate=false, $listtags=true, $forumids=0, $posttime=false)
{
	global $wpdb, $current_user, $sfvars;

	sf_initialise_globals($sfvars['forumid']);

	$out = '';

	# are we passing forum ID's?
	if ($forumids == 0)
	{
		$where = '';
	} else {
		$flist = explode(",", $forumids);
		$where = ' WHERE ';
		$x = 0;
		for ($x; $x<count($flist); $x++)
		{
			$where.= 'forum_id = '.$flist[$x];
			if ($x != count($flist)-1) $where.= " OR ";
		}
	}

	# limit to viewable forums based on permissions
	if (!$current_user->forumadmin)
	{
		$allforums = sf_get_forum_memberships($current_user->ID);
		if ($allforums)
		{
			$forum_ids = '';
			foreach ($allforums as $thisforum)
			{
				if (sf_can_view_forum($thisforum->forum_id))
				{
					$forum_ids[] = $thisforum->forum_id;
				}
			}
		} else {
			return '';
		}
	
		# create where clause based on forums that current user can view
		if ($forum_ids != '')
		{
			if ($where == '')
			{
				$where = ' WHERE ';
			} else {
				$where.= ' AND ';
			}
			$where .= SFPOSTS.".forum_id IN (" . implode(",", $forum_ids) . ") ";
		}
	}
	
	$sfposts = $wpdb->get_results("SELECT DISTINCT forum_id, topic_id FROM ".SFPOSTS.$where." ORDER BY post_id DESC LIMIT ".$limit);
	if($sfposts)
	{
		foreach($sfposts as $sfpost)
		{
			$thisforum = sf_get_forum_record($sfpost->forum_id);
			$p=false;
			$postdetails = sf_get_last_post_in_topic($sfpost->topic_id);

			# Start contruction
			if($listtags) $out.="<li class='sftagli'>\n";

			$out.=sf_get_topic_url_newpost($thisforum->forum_slug, $sfpost->topic_id, $postdetails->post_id, $postdetails->post_index);

			if($forum)
			{
				$out.="<p class='sftagp'>".__("posted in forum", "sforum").' '.stripslashes($thisforum->forum_name)."&nbsp;"."\n";
				$p=true;
			}

			if($user)
			{
				if($p == false) $out.="<p class='sftagp'>";
				$poster = sf_build_name_display($postdetails->user_id, stripslashes($postdetails->display_name));
				if(empty($poster)) $poster = apply_filters('sf_show_post_name', stripslashes($postdetails->guest_name));
				$out.=__("by", "sforum").' '.$poster.' '."\n";
				$p=true;
			}

			if($postdate)
			{
				if($p == false) $out.="<p class='sftagp'>";
				$out.=__("on", "sforum").' '.mysql2date(SFDATES, $postdetails->post_date)."\n";
				if ($posttime)
				{
					$out.=' '.__("at", "sforum").' '.mysql2date(SFTIMES, $postdetails->post_date)."\n";
				}
				$p=true;
			}

			if($p) $out.="</p>\n";

			if($listtags) $out.="</li>\n";
		}
	} else {
		if($listtags) $out.="<li class='sftagli'>\n";
		$out.='<p>'.__("No Topics to Display", "sforum").'</p>'."\n";
		if($listtags) $out.="</li>\n";
	}
	echo($out);
	return;
}

/* 	=====================================================================================

	sf_recent_posts_alt_tag($limit, $forum, $user, $postdate, $listtags, $forumids)

	displays the most recent topics to have received a new post in an alternate method

	parameters:

		$limit			How many items to show in the list		number			5
		$forum			Show the Forum Title					true/false		false
		$user			Show the Users Name						true/false		true
		$postdate		Show date of posting					true/false		false
		$listtags		Wrap in <li> tags (li only)				true/false		true
		$posttime		Show time of posting (reqs postdate)	true/false		false

 	===================================================================================*/

function sf_recent_posts_alt_tag($limit=5, $forum=false, $user=true, $postdate=false, $listtags=true, $posttime=false)
{
	global $wpdb, $current_user, $sfvars;

	sf_initialise_globals($sfvars['forumid']);

	$out = '';

	$where = " WHERE post_status = 0";
	
	# limit to viewable forums based on permissions
	if (!$current_user->forumadmin)
	{
		$allforums = sf_get_forum_memberships($current_user->ID);
		if ($allforums)
		{
			$forum_ids = '';
			foreach ($allforums as $thisforum)
			{
				if (sf_can_view_forum($thisforum->forum_id))
				{
					$forum_ids[] = $thisforum->forum_id;
				}
			}
		} else {
			return '';
		}
	
		# create where clause based on forums that current user can view
		if ($forum_ids != '')
		{
			$where .= " AND forum_id IN (" . implode(",", $forum_ids) . ") ";
		}
	}

	$sfposts = $wpdb->get_results("SELECT DISTINCT forum_id, topic_id FROM ".SFPOSTS.$where." ORDER BY post_id DESC LIMIT ".$limit);
	if ($sfposts)
	{
		foreach ($sfposts as $sfpost)
		{
			$thisforum = sf_get_forum_record($sfpost->forum_id);
			$p = false;

			$postdetails = sf_get_last_post_in_topic($sfpost->topic_id);

			# Start contruction
			if ($listtags) $out.="<li class='sftagli'>\n";

			$out .= '<a href="'.sf_build_url($thisforum->forum_slug, sf_get_topic_slug($sfpost->topic_id), 1, $postdetails->post_id, $postdetails->post_index).'">';

			$out.= sf_get_topic_name(sf_get_topic_slug($sfpost->topic_id));

			if ($forum)
			{
				$out.= ' '.__("posted in", "sforum").' '.stripslashes($thisforum->forum_name);
				$p = true;
			}

			if ($user)
			{ 
				$out.= ' '.__("by ", "sforum").' ';
				$poster = sf_build_name_display($postdetails->user_id, stripslashes($postdetails->display_name));
				if (empty($poster)) $poster = apply_filters('sf_show_post_name', stripslashes($postdetails->guest_name));
				$out.= $poster;
				$p = true;
			}

			if ($postdate)
			{
				$out.= ' '.__("on", "sforum").' '.mysql2date(SFDATES, $postdetails->post_date);
				if ($posttime)
				{
					$out.= ' '.__("at", "sforum").' '.mysql2date(SFTIMES, $postdetails->post_date)."\n";
				}
				$p = true;
			}

			$out.= '</a>';
			if ($listtags) $out.= "</li>\n";
		}
	} else {
		if ($listtags) $out.= "<li class='sftagli'>\n";
		$out.= __("No Topics to Display", "sforum")."\n";
		if ($listtags) $out.= "</li>\n";
	}
	echo $out;
	
	return;
}

/* 	=====================================================================================

	sf_latest_posts($limit)

	displays the most recent topics to have received a new post

	parameters:

		$limit			How many items to show in the list		number			5=default

 	===================================================================================*/

function sf_latest_posts($limit=5)
{
	global $wpdb, $current_user, $sfvars;

	sf_initialise_globals($sfvars['forumid']);

	$out = '';

	$where = " WHERE ".SFPOSTS.".post_status = 0";

	# limit to viewable forums based on permissions
	if (!$current_user->forumadmin)
	{
		$allforums = sf_get_forum_memberships($current_user->ID);
		if ($allforums)
		{
			$forum_ids = '';
			foreach ($allforums as $thisforum)
			{
				if (sf_can_view_forum($thisforum->forum_id))
				{
					$forum_ids[] = $thisforum->forum_id;
				}
			}
		} else {
			return '';
		}
	
		# create where clause based on forums that current user can view
		if ($forum_ids != '')
		{
			$where .= " AND forum_id IN (" . implode(",", $forum_ids) . ") ";
		}
	}

	$posts = $wpdb->get_results(
			"SELECT post_id, topic_id, forum_id, post_content, post_index, ".sf_zone_datetime('post_date').",
			 ".SFPOSTS.".user_id, guest_name, ".SFMEMBERS.".display_name FROM ".SFPOSTS."
			 LEFT JOIN ".SFMEMBERS." ON ".SFPOSTS.".user_id = ".SFMEMBERS.".user_id
			 ".$where."
			 ORDER BY post_date DESC
			 LIMIT ".$limit);

	$out.='<div class="sf-latest">';

	if ($posts) {
		foreach ($posts as $post)
		{
			$thisforum = sf_get_forum_record($post->forum_id);
			$poster = sf_build_name_display($post->user_id, stripslashes($post->display_name));
			if (empty($poster)) $poster = apply_filters('sf_show_post_name', stripslashes($post->guest_name));
			$topic = sf_get_topic_record($post->topic_id);
			$out.='<div class="sf-latest-header">';
			$out.=$poster.__(' posted ', "sforum");
			$out.='<a href="'.sf_build_url($thisforum->forum_slug, $topic->topic_slug, 1, $post->post_id, $post->post_index).'">';
			$out.=stripslashes($topic->topic_name).'</a>';
			$out.=__(' in ', "sforum");
			$out.='<a href="'.sf_build_url($thisforum->forum_slug, '', 1, 0).'">'.sf_get_forum_name($thisforum->forum_slug).'</a>';
			$out.='<br />'.mysql2date(SFDATES, $post->post_date);
			$out.='</div>';
			$out.='<div class="sf-latest-content">';
			$text=sf_filter_content(stripslashes($post->post_content), '');
			$text=sf_rss_excerpt($text);
			$out.=$text;
			$out.='</div>';
			$out.='<br />';
		}
	} else {
		$out.='<div class="sf-latest-header">';
		$out.='<p>'.__("No Topics to Display", "sforum").'</p>'."\n";
		$out.='</div>';
	}

	$out.='</div>';

	echo($out);
	return;
}

/* 	=====================================================================================

	sf_new_post_announce()

	displays the latest forum post in  the sidebar - updated every XX seconds

	parameters: None

	The option to use this tag MUST be turned on in the forum options

 	===================================================================================*/

function sf_new_post_announce()
{
	if(get_option('sfuseannounce'))
	{
		$url=SF_PLUGIN_URL."/forum/ahah/sf-ahah-announce.php?target=announce";

		if(get_option('sfannounceauto'))
		{
			$timer = (get_option('sfannouncetime') * 1000);
			echo '<script type="text/javascript">';
			echo 'sfjNewPostCheck("'.$url.'", "sfannounce", "'.$timer.'");';
			echo '</script>';
		}
		echo '<div id="sfannounce">';
		sf_new_post_announce_display();
		echo '</div>';
	}
	return;
}

function sf_new_post_announce_display()
{
	global $wpdb, $current_user, $sfvars;

	sf_initialise_globals($sfvars['forumid']);

	$aslist = get_option('sfannouncelist');
	$out = '';

	$sfposts = sf_get_users_new_post_list(get_option('sfannouncecount'));

	if($sfposts)
	{
		$sfposts = sf_combined_new_posts_list($sfposts);
		if($aslist)
		{
			$out = '<ul><li>'.stripslashes(get_option('sfannouncehead')).'<ul>';
		} else {
			$out = '<p>'.stripslashes(get_option('sfannouncehead')).'<br /></p>';
			$out.= '<table id="sfannouncetable" cellpadding="4" cellspacing="0" border="0">';
		}
		foreach($sfposts as $sfpost)
		{
			# GET LAST POSTER DETAILS
			$last = sf_get_last_post_in_topic($sfpost['topic_id']);

			$poster = sf_build_name_display($last->user_id, stripslashes($last->display_name));
			if(empty($poster)) $poster = apply_filters('sf_show_post_name', stripslashes($last->guest_name));

			if(!$aslist)
			{
				$out.= '<tr><td class="sfannounceicon" valign="top" align="left">';
				# DISPLAY TOPIC ENTRY
				$topicicon = 'announceold.png';
				if($current_user->member && $current_user->ID != $sfpost['user_id'])
				{
					if(sf_is_in_users_newposts($sfpost['topic_id'])) $topicicon = 'announcenew.png';
				} else {
					if(($current_user->lastvisit > 0) && ($current_user->lastvisit < $last->udate)) $topicicon = 'announcenew.png';
				}
				$out.= '<img src="'. SFRESOURCES . $topicicon. '" alt="" />'."\n";
			}

			if($aslist)
			{
				$out.= '<li>';
			} else {
				$out.='</td><td class="sfannounceentry" valign="top">';
			}
			$out.= '<a href="'.sf_build_url($sfpost['forum_slug'], $sfpost['topic_slug'], 1, $last->post_id, $last->post_index).'">'.sf_format_announce_tag($sfpost['forum_name'], $sfpost['topic_name'], $poster, $last->post_date).'</a>';

			if($aslist)
			{
				$out.= '</li>';
			} else {
				$out.='</td></tr>';
			}
		}
		if($aslist)
		{
			$out.= '</ul></li></ul>';
		} else {
			$out.='</table>';
		}
	}
	echo $out;
	return;
}

function sf_format_announce_tag($forumname, $topicname, $poster, $postdate)
{
	$text=stripslashes(get_option('sfannouncetext'));

	$text = str_replace('%TOPICNAME%', stripslashes($topicname), $text);
	$text = str_replace('%FORUMNAME%', stripslashes($forumname), $text);
	$text = str_replace('%POSTER%', stripslashes($poster), $text);
	$text = str_replace('%DATETIME%', mysql2date(SFDATES, $postdate)." - ".mysql2date(SFTIMES,$postdate), $text);
	return $text;
}

/* 	=====================================================================================

	sf_hot_topics($limit, $days, $forum, $listtags, $forumids)

	displays online status of admins and moderators

	parameters:

		$limit			How many items to show in the list		number			5
		$days			Number of days to include				number			30
		$forum			Show the Forum Title					true/false		false
		$listtags		Wrap in <li> tags (li only)				true/false		true
		$forumids		comma delimited list of forum id's		optional		0

 	===================================================================================*/

function sf_hot_topics($limit=10, $days=30, $forum=true, $listtags=true, $forumids=0)
{
	global $wpdb, $current_user;

	sf_initialise_globals();

	$out = '';

	# are we passing forum ID's?
	$where = '';
	if($forumids != 0)
	{
		$flist = explode(",", $forumids);
		$x = 0;
		$where = ' AND (';
		for($x; $x<count($flist); $x++)
		{
			$where.= ' '.SFTOPICS.'.forum_id = '.$flist[$x];
			if ($x != count($flist)-1) $where.= " OR ";
		}
		$where.= ')';
	}

	# limit to viewable forums based on permissions
	if (!$current_user->forumadmin)
	{
		$allforums = sf_get_forum_memberships($current_user->ID);
		if ($allforums)
		{
			$forum_ids = '';
			foreach ($allforums as $thisforum)
			{
				if (sf_can_view_forum($thisforum->forum_id))
				{
					$forum_ids[] = $thisforum->forum_id;
				}
			}
		} else {
			return '';
		}
	
		# create where clause based on forums that current user can view
		if ($forum_ids != '')
		{
			$where .= " AND ".SFPOSTS.".forum_id IN (" . implode(",", $forum_ids) . ") ";
		}
	}

	# get any posts that meeet date criteria
	$posts = $wpdb->get_results("
		SELECT ".SFPOSTS.".topic_id, DATEDIFF(CURDATE(), post_date) AS delta, ".SFPOSTS.".forum_id, forum_name, forum_slug, forum_slug, topic_name, topic_slug
		FROM ".SFPOSTS."
		JOIN ".SFTOPICS." ON ".SFTOPICS.".topic_id = ".SFPOSTS.".topic_id
		JOIN ".SFFORUMS." ON ".SFFORUMS.".forum_id = ".SFPOSTS.".forum_id
		WHERE DATE_SUB(CURDATE(),INTERVAL ".$days." DAY) <= post_date".$where);
	if ($posts)
	{
		# give each topic with posts a score - currently ln(cur date - post date) for each post
		$score = $forum_id = $forum_name = $forum_slug = $topic_slug = $topic_name = array();
		foreach ($posts as $post)
		{
			if ($post->delta != $days)
			{
				$score[$post->topic_id] = $score[$post->topic_id] + log($days - $post->delta);
				$forum_id[$post->topic_id] = $post->forum_id;
				$forum_name[$post->topic_id] = $post->forum_name;
				$forum_slug[$post->topic_id] = $post->forum_slug;
				$topic_slug[$post->topic_id] = $post->topic_slug;
				$topic_name[$post->topic_id] = $post->topic_name;
			}
		}
		# reverse sort the posts and limit to number to display
		arsort($score);
		$topics = array_slice($score, 0, $limit, true);

		# now output the popular topics
		foreach ($topics as $id => $topic)
		{
			$p = false;

			# Start contruction
			if ($listtags) $out.= "<li class='sftagli'>\n";
			$out.= sf_get_topic_url($forum_slug[$id], $topic_slug[$id], $topic_name[$id]);

			if ($forum)
			{
				$out.= "<p class='sftagp'>".__("posted in forum", "sforum").' '.stripslashes($forum_name[$id])."&nbsp;"."\n";
				$p = true;
			}

			if ($p) $out.= "</p>\n";
			if ($listtags) $out.= "</li>\n";
		}

	} else {
		if ($listtags) $out.="<li class='sftagli'>\n";
		$out.='<p>'.__("No Topics to Display", "sforum").'</p>'."\n";
		if ($listtags) $out.="</li>\n";
	}

	echo $out;
	return;
}

/* 	=====================================================================================

	sf_author_posts($author_id, $showforum=true, $showdate=true)

	displays all the posts for the specified author id - forum visability rules apply

	parameters:

		$author_id			author to show the posts for
		$showforum			show the forum name							true/false
		$showdate			show the date of the latest post			true/false
		$limit				number of posts to return					0 (all)

 	===================================================================================*/

function sf_author_posts($author_id, $showforum=true, $showdate=true, $limit=0)
{
	global $wpdb, $current_user, $sfvars;

	sf_initialise_globals($sfvars['forumid']);

	$posts = 0;

	$out = '<div class="sf-authortopics">';

	if ($limit > 0)
	{
		$limit = 'LIMIT '.$limit;
	} else {
		$limit = '';
	}

	# limit to viewable forums based on permissions
	$where = ' WHERE user_id = '.$author_id.' ';
	if (!$current_user->forumadmin)
	{
		$allforums = sf_get_forum_memberships($current_user->ID);
		if ($allforums)
		{
			$forum_ids = '';
			foreach ($allforums as $thisforum)
			{
				if (sf_can_view_forum($thisforum->forum_id))
				{
					$forum_ids[] = $thisforum->forum_id;
				}
			}
		} else {
			return '';
		}
	
		# create where clause based on forums that current user can view
		if ($forum_ids != '')
		{
			$where .= " AND forum_id IN (" . implode(",", $forum_ids) . ") ";
		}
	}

	$sql = "SELECT DISTINCT post_id, forum_id, topic_id, post_date, post_index FROM ".SFPOSTS.$where."ORDER BY post_date DESC $limit";
	$sfposts = $wpdb->get_results($sql);

	if ($sfposts) {
		foreach ($sfposts as $sfpost)
		{
			$forum = $wpdb->get_row("SELECT forum_name, forum_slug FROM ".SFFORUMS." WHERE forum_id = $sfpost->forum_id");
			$posts = 1;
			if ($showforum)
			{
				$out .= '<div class="sf-authorforum">';
				$out .= $forum->forum_name;
				$out .= '</div>';
			}

			$out .= '<div class="sf-authorlink">';
			$out .= sf_get_topic_url_newpost($forum->forum_slug, $sfpost->topic_id, $sfpost->post_id, $sfpost->post_index);
			$out .= '</div>';

			if ($showdate)
			{
				$out .= '<div class="sf-authordate">';
				$out .= mysql2date(SFDATES, $sfpost->post_date);
				$out .= '</div>';
			}
		}
	}

	if (!$posts) {
		$out .= __('No posts by this author', 'sforum');
	}

	$out .= '</div>';
	echo $out;
	return;
}

/* 	=====================================================================================

	sf_highest_rated_posts($limit, $forum, $user, $postdate, $listtags, $forumids)

	displays the highest rated posts

	parameters:

		$limit			How many items to show in the list		number			10
		$forum			Show the Forum Title					true/false		false
		$user			Show the Users Name						true/false		true
		$postdate		Show date of posting					true/false		false
		$listtags		Wrap in <li> tags (li only)				true/false		true
		$forumids		comma delimited list of forum id's		optional		0

 	===================================================================================*/

function sf_highest_rated_posts($limit=10, $forum=true, $user=true, $postdate=true, $listtags=true, $forumids=0)
{
	global $wpdb, $current_user, $sfvars;

	sf_initialise_globals($sfvars['forumid']);

	$out = '';

	$postratings = get_option('sfpostratings');
	if (!$postratings['sfpostratings'])
	{
		if ($listtags) $out.= "<li class='sftagli'>\n";
		$out.= __("Post Rating is not Enabled!", "sforum")."\n";
		if ($listtags) $out.= "</li>\n";
		return;
	}

	# are we passing forum ID's?
	if ($forumids == 0)
	{
		$where = '';
	} else {
		$flist = explode(",", $forumids);
		$where=' WHERE ';
		$x=0;
		for($x; $x<count($flist); $x++)
		{
			$where.= SFPOSTS.".forum_id = ".$flist[$x];
			if($x != count($flist)-1) $where.= " OR ";
		}
	}

	# limit to viewable forums based on permissions
	if (!$current_user->forumadmin)
	{
		$allforums = sf_get_forum_memberships($current_user->ID);
		if ($allforums)
		{
			$forum_ids = '';
			foreach ($allforums as $thisforum)
			{
				if (sf_can_view_forum($thisforum->forum_id))
				{
					$forum_ids[] = $thisforum->forum_id;
				}
			}
		} else {
			return '';
		}
	
		# create where clause based on forums that current user can view
		if ($forum_ids != '')
		{
			if ($where == '')
			{
				$where = ' WHERE ';
			} else {
				$where.= ' AND ';
			}
			$where .= SFPOSTS.".forum_id IN (" . implode(",", $forum_ids) . ") ";
		}
	}

	# how to order
	if ($postratings['sfratingsstyle'] == 1)  # thumb up/down
	{
		$order = "ORDER BY ratings_sum DESC";
	} else {
		$order = "ORDER BY (ratings_sum / vote_count) DESC";
	}

	$sfposts = $wpdb->get_results(
			"SELECT ".SFPOSTRATINGS.".post_id, ratings_sum, vote_count, ".SFPOSTS.".topic_id, ".SFPOSTS.".forum_id, ".SFPOSTS.".user_id, post_date, post_index, topic_slug, topic_name, forum_slug, forum_name, display_name, guest_name
			FROM ".SFPOSTRATINGS."
			JOIN ".SFPOSTS." ON ".SFPOSTRATINGS.".post_id = ".SFPOSTS.".post_id
			JOIN ".SFTOPICS." ON ".SFPOSTS.".topic_id = ".SFTOPICS.".topic_id
			JOIN ".SFFORUMS." ON ".SFPOSTS.".forum_id = ".SFFORUMS.".forum_id
			LEFT JOIN ".SFMEMBERS." ON ".SFPOSTS.".user_id = ".SFMEMBERS.".user_id
			".$where."
			".$order."
			LIMIT ".$limit);

	if ($sfposts)
	{
		foreach ($sfposts as $sfpost)
		{
			# Start contruction
			if ($listtags) $out.= "<li class='sftagli'>\n";

			$out .= '<a href="'.sf_build_url($sfpost->forum_slug, $sfpost->topic_slug, 1, $sfpost->post_id, $sfpost->post_index).'">';

			$out.= $sfpost->topic_name;
			if ($forum)
			{
				$out.= ' '.__("posted in", "sforum").' '.stripslashes($sfpost->forum_name);
				$p = true;
			}

			if ($user)
			{
				$out.= ' '.__("by", "sforum").' ';
				$poster = sf_build_name_display($sfpost->user_id, stripslashes($sfpost->display_name));
				if (empty($poster)) $poster = apply_filters('sf_show_post_name', stripslashes($sfpost->guest_name));
				$out.= $poster;
				$p = true;
			}

			if ($postdate)
			{
				$out.= ' '.__("on", "sforum").mysql2date(SFDATES, $sfpost->post_date);
				$p=true;
			}

			$out.='</a>';
			if ($listtags) $out.= "</li>\n";
		}
	} else {
		if ($listtags) $out.= "<li class='sftagli'>\n";
		$out.= __("No Rated Posts to Display", "sforum")."\n";
		if ($listtags) $out.= "</li>\n";
	}
	echo ($out);
	return;
}

/* 	=====================================================================================

	sf_most_rated_posts($limit, $forum, $user, $postdate, $listtags, $forumids)

	displays the highest rated posts

	parameters:

		$limit			How many items to show in the list		number			10
		$forum			Show the Forum Title					true/false		false
		$user			Show the Users Name						true/false		true
		$postdate		Show date of posting					true/false		false
		$listtags		Wrap in <li> tags (li only)				true/false		true
		$forumids		comma delimited list of forum id's		optional		0

 	===================================================================================*/

function sf_most_rated_posts($limit=10, $forum=true, $user=true, $postdate=true, $listtags=true, $forumids=0)
{
	global $wpdb, $current_user, $sfvars;

	sf_initialise_globals($sfvars['forumid']);

	$out = '';

	$postratings = get_option('sfpostratings');
	if (!$postratings['sfpostratings'])
	{
		if ($listtags) $out.= "<li class='sftagli'>\n";
		$out.= __("Post Rating is not Enabled!", "sforum")."\n";
		if ($listtags) $out.= "</li>\n";
		return;
	}

	# are we passing forum ID's?
	if ($forumids == 0)
	{
		$where = '';
	} else {
		$flist = explode(",", $forumids);
		$where=' WHERE ';
		$x=0;
		for($x; $x<count($flist); $x++)
		{
			$where.= SFPOSTS.".forum_id = ".$flist[$x];
			if($x != count($flist)-1) $where.= " OR ";
		}
	}

	# limit to viewable forums based on permissions
	if (!$current_user->forumadmin)
	{
		$allforums = sf_get_forum_memberships($current_user->ID);
		if ($allforums)
		{
			$forum_ids = '';
			foreach ($allforums as $thisforum)
			{
				if (sf_can_view_forum($thisforum->forum_id))
				{
					$forum_ids[] = $thisforum->forum_id;
				}
			}
		} else {
			return '';
		}
	
		# create where clause based on forums that current user can view
		if ($forum_ids != '')
		{
			if ($where == '')
			{
				$where = ' WHERE ';
			} else {
				$where.= ' AND ';
			}
			$where .= SFPOSTS.".forum_id IN (" . implode(",", $forum_ids) . ") ";
		}
	}

	$sfposts = $wpdb->get_results(
			"SELECT ".SFPOSTRATINGS.".post_id, ratings_sum, vote_count, ".SFPOSTS.".topic_id, ".SFPOSTS.".forum_id, ".SFPOSTS.".user_id, post_date, post_index, topic_slug, topic_name, forum_slug, forum_name, display_name, guest_name
			FROM ".SFPOSTRATINGS."
			JOIN ".SFPOSTS." ON ".SFPOSTRATINGS.".post_id = ".SFPOSTS.".post_id
			JOIN ".SFTOPICS." ON ".SFPOSTS.".topic_id = ".SFTOPICS.".topic_id
			JOIN ".SFFORUMS." ON ".SFPOSTS.".forum_id = ".SFFORUMS.".forum_id
			LEFT JOIN ".SFMEMBERS." ON ".SFPOSTS.".user_id = ".SFMEMBERS.".user_id
			".$where."
			ORDER BY vote_count DESC
			LIMIT ".$limit);

	if ($sfposts)
	{
		foreach ($sfposts as $sfpost)
		{
			if (sf_can_view_forum($sfpost->forum_id))
			{
				# Start contruction
				if ($listtags) $out.= "<li class='sftagli'>\n";

				$out .= '<a href="'.sf_build_url($sfpost->forum_slug, $sfpost->topic_slug, 1, $sfpost->post_id, $sfpost->post_index).'">';

				$out.= $sfpost->topic_name;
				if ($forum)
				{
					$out.= ' '.__("posted in", "sforum").' '.stripslashes($sfpost->forum_name);
					$p = true;
				}

				if ($user)
				{
					$out.= ' '.__("by", "sforum").' ';
					$poster = sf_build_name_display($sfpost->user_id, stripslashes($sfpost->display_name));
					if (empty($poster)) $poster = apply_filters('sf_show_post_name', stripslashes($sfpost->guest_name));
					$out.= $poster;
					$p = true;
				}

				if ($postdate)
				{
					$out.= ' '.__("on", "sforum").' '.mysql2date(SFDATES, $sfpost->post_date);
					$p=true;
				}

				$out.='</a>';
				if ($listtags) $out.= "</li>\n";
			}
		}
	} else {
		if ($listtags) $out.= "<li class='sftagli'>\n";
		$out.= __("No Rated Posts to Display", "sforum")."\n";
		if ($listtags) $out.= "</li>\n";
	}
	echo ($out);
	return;
}

?>