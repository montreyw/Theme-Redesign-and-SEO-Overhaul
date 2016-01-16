<?php
/**
 * Post Planner Plugin Planner Metabox
 *
 * Create the Post Planner metabox in Posts
 * @author C.M. Kendrick <cindy@seaserpentstudio.com>
 * @package post-planner
 * @version 1.1
 */

global $post;

$planner_id = get_post_meta( $post->ID, '_postplanner', true );
$planner_exists = PostPlanner_Lib::planner_exists( $planner_id );

echo '<div class="post-planner-meta-control post-planner">';

echo '<input type="hidden" id="post-planner-post-id" value="'.absint( $post->ID ).'" />';

do_action( 'post_planner_before_planner_metabox' );

if ( $planner_id != '' && $planner_exists == true ) {

	$planner_type = get_post_meta( $planner_id, '_pp_type', true );

	echo '<input type="hidden" id="post-planner-id" value="'.absint( $planner_id ).'" />';
	echo '<input type="hidden" id="post-planner-type" value="'.esc_attr( $planner_type ).'" />';

	PostPlanner::display_planner( $planner_id );
	PostPlanner::display_status( $planner_id );
	if ( PostPlanner_Loader::$settings['duedate'] == 1 ) PostPlanner::display_duedate( $planner_id );
	if ( PostPlanner_Loader::$settings['assignments'] == 1 ) PostPlanner::display_assignments( $planner_id );

	echo '<div class="clear"></div>';

	if ( PostPlanner_Lib::check_for_content( $planner_id ) || PostPlanner_Loader::$settings['images'] == 1 || PostPlanner_Loader::$settings['files'] == 1 || PostPlanner_Loader::$settings['references'] == 1
		|| PostPlanner_Loader::$settings['checklist'] == 1 || PostPlanner_Loader::$settings['comments'] == 1 ) {
	?>
	<div id="post-planner-tabs" class="ui-tabs post-planner">
		<ul class="ui-tabs-nav"><?php
			if ( PostPlanner_Lib::check_for_content( $planner_id ) ) echo '<li><a href="#tabs-details"> '.apply_filters( 'post_planner_details_metabox_title', esc_html__( 'Details', 'post-planner' ) ).' </a></li>';
			if ( PostPlanner_Loader::$settings['images'] == 1 ) echo '<li><a href="#tabs-images"> '.apply_filters( 'post_planner_images_metabox_title', esc_attr__( 'Images', 'post-planner' ) ).' </a></li>';
			if ( PostPlanner_Loader::$settings['files'] == 1 ) echo '<li><a href="#tabs-files"> '.apply_filters( 'post_planner_files_metabox_title', esc_attr__( 'Files', 'post-planner' ) ).' </a></li>';
			if ( PostPlanner_Loader::$settings['references'] == 1 ) echo '<li><a href="#tabs-references"> '.apply_filters( 'post_planner_references_metabox_title', esc_attr__( 'References', 'post-planner' ) ).' </a></li>';
			if ( PostPlanner_Loader::$settings['checklist'] == 1 && implode( '', PostPlanner_Loader::$checklist ) ) echo '<li><a href="#tabs-checklist"> '.apply_filters( 'post_planner_checklist_metabox_title', esc_attr__( 'Checklist', 'post-planner' ) ).' </a></li>';
			if ( PP_CTDL == true ) echo '<li><a href="#tabs-todolist"> '.apply_filters( 'post_planner_todolist_metabox_title', esc_attr__( 'To-Do List', 'post-planner' ) ).' </a></li>';
			if ( PostPlanner_Loader::$settings['comments'] == 1 ) echo '<li><a href="#tabs-comments"> '.apply_filters( 'post_planner_comments_metabox_title', esc_attr__( 'Comments', 'post-planner' ) ).' </a></li>';
			?>
		</ul>
		<?php
		if ( PostPlanner_Lib::check_for_content( $planner_id ) ) {
			echo '<div id="tabs-details">';
			PostPlanner::display_details( $planner_id );
			echo '</div>';
		}
		if( PostPlanner_Loader::$settings['images'] == 1 ) {
			echo '<div id="tabs-images">';
			PostPlanner::display_images( $planner_id );
			echo '</div>';
		}
		if ( PostPlanner_Loader::$settings['files'] == 1 ) {
			echo '<div id="tabs-files">';
			PostPlanner::display_files( $planner_id );
			echo '</div>';
		}
		if ( PostPlanner_Loader::$settings['references'] == 1 ) {
			echo '<div id="tabs-references">';
			PostPlanner::display_references( $planner_id );
			echo '</div>';
		}
		if ( PostPlanner_Loader::$settings['checklist'] == 1 && implode( '', PostPlanner_Loader::$checklist ) ) {
			echo '<div id="tabs-checklist">';
			PostPlanner::display_checklist( $planner_id );
			echo '</div>';
		}
		if ( PP_CTDL == true ) {
			echo '<div id="tabs-todolist">';
			PostPlanner::display_todolist( $planner_id );
			echo '</div>';
		}
		if ( PostPlanner_Loader::$settings['comments'] == 1 ) {
			echo '<div id="tabs-comments">';
			PostPlanner::display_comments( $planner_id );
			echo '</div>';
		}
		?>
	</div>

	<?php

	}

} else {

	PostPlanner::create_planner();

	echo '<div class="clear"></div>';

}

do_action( 'post_planner_after_planner_metabox' );

echo '</div>';