<?php
/*
Simple:Press Forum
Template Tag(s) - Pages
$LastChangedDate: 2009-05-26 12:35:14 -0700 (Tue, 26 May 2009) $
$Rev: 1946 $
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) {
	die('Access Denied');
}

/* 	=====================================================================================

	sf_is_groupview()

	returns true if the current page being viewed is the spf group view (ie list of forums)

	parameters:

		none
 	===================================================================================*/

function sf_is_groupview()
{
	global $sfvars;

	sf_initialise_globals();
	return $sfvars['pageview'] == 'group';
}

/* 	=====================================================================================

	sf_is_forumview()

	returns true if the current page being viewed is the spf forum view (ie list of topics)

	parameters:

		none
 	===================================================================================*/

function sf_is_forumview()
{
	global $sfvars;

	sf_initialise_globals();
	return $sfvars['pageview'] == 'forum';
}

/* 	=====================================================================================

	sf_is_topicview()

	returns true if the current page being viewed is the spf topic view (ie list of posts)

	parameters:

		none
 	===================================================================================*/

function sf_is_topicview()
{
	global $sfvars;

	sf_initialise_globals();
	return $sfvars['pageview'] == 'topic';
}

/* 	=====================================================================================

	sf_is_profileview()

	returns true if the current page being viewed is the spf profile view

	parameters:

		none
 	===================================================================================*/

function sf_is_profileview()
{
	global $sfvars;

	sf_initialise_globals();
	return $sfvars['pageview'] == 'profile';
}

/* 	=====================================================================================

	sf_is_pmview()

	returns true if the current page being viewed is a spf private messaging page

	parameters:

		none
 	===================================================================================*/

function sf_is_pmview()
{
	global $sfvars;

	sf_initialise_globals();
	return $sfvars['pageview'] == 'pm';
}

/* 	=====================================================================================

	sf_is_listview()

	returns true if the current page being viewed is a spf members list page

	parameters:

		none
 	===================================================================================*/

function sf_is_listview()
{
	global $sfvars;

	sf_initialise_globals();
	return $sfvars['pageview'] == 'list';
}

/* 	=====================================================================================

	sf_is_searchview()

	returns true if the current page being viewed is the spf is from search results

	parameters:

		none
 	===================================================================================*/

function sf_is_searchview()
{
	global $sfvars;

	sf_initialise_globals();
	return $sfvars['searchpage'] == 1;
}

/* 	=====================================================================================

	sf_is_forumpage()

	returns true if the current page being viewed is an spf page

	parameters:

		none
 	===================================================================================*/

function sf_is_forumpage()
{
	global $sfvars;

	sf_initialise_globals();
	return $sfvars['page'] == 1;
}

?>