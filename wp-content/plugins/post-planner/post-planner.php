<?php
/*
Plugin Name: Post Planner
Version: 1.4
Description: Plan your upcoming posts
Author: C.M. Kendrick
Author URI: http://seaserpentstudio.com
Plugin URI: http://seaserpentstudio.com/plugins/post-planner
*/

add_action( 'init', 'postplanner_todo_loader' );
include_once plugin_dir_path( __FILE__ ).'includes/post-planner-widget.class.php';

/**
 * Define constants and load the plugin
 * @since 1.0
 */
function postplanner_todo_loader() {

	if ( is_admin() ) {

		require( 'update-notifier.php' );

		if ( !defined( 'POSTPLANNER_PLUGIN_VERSION' ) ) define( 'POSTPLANNER_PLUGIN_VERSION', '1.4' );
		if ( !defined( 'POSTPLANNER_FILE' ) )           define( 'POSTPLANNER_FILE', __FILE__ );
		if ( !defined( 'POSTPLANNER_BASENAME' ) )       define( 'POSTPLANNER_BASENAME', plugin_basename( __FILE__ ) );
		if ( !defined( 'POSTPLANNER_PLUGIN_DIR' ) )     define( 'POSTPLANNER_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		if ( !defined( 'POSTPLANNER_PLUGIN_URL' ) )     define( 'POSTPLANNER_PLUGIN_URL', plugins_url( '', __FILE__ ) );

		$languages_path = plugin_basename( dirname( __FILE__ ) . '/languages' );
		load_plugin_textdomain( 'post-planner', '', $languages_path );

		include_once 'includes/post-planner-loader.class.php';
		PostPlanner_Loader::init();

	}

}

/**
 * Install plugin
 */
function postplanner_activation() {
	global $wp_version;

	$exit_msg = esc_html__( 'Post Planner requires WordPress 3.3 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress">Please update.</a>', 'post-planner' );
	if ( version_compare( $wp_version, "3.3", "<" ) ) {
		exit( $exit_msg );
	}

	if ( !defined( 'POSTPLANNER_DB_VERSION' ) ) define( 'POSTPLANNER_DB_VERSION', '1.4' );
	if ( !defined( 'POSTPLANNER_FILE' ) )       define( 'POSTPLANNER_FILE', __FILE__ );
	include_once 'includes/post-planner-library.class.php';

	if ( get_option( 'PostPlanner_db_version' ) ) {
		$installed_ver = get_option( 'PostPlanner_db_version' );
	} else {
		$installed_ver = 0;
	}

	// if the installed version is not the same as the current version, run the install function
	if ( POSTPLANNER_DB_VERSION != $installed_ver ) {
		PostPlanner_Lib::install_plugin( $installed_ver );
	}
}

register_activation_hook( __FILE__, 'postplanner_activation' );