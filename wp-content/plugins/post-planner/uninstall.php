<?php
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

if ( current_user_can( 'delete_plugins' ) ) {

	// delete options
	delete_option( 'PostPlanner_general' );
	delete_option( 'PostPlanner_advanced' );
	delete_option( 'PostPlanner_status' );
	delete_option( 'PostPlanner_checklist' );
	delete_option( 'PostPlanner_dashboard_settings' );
	delete_option( 'PostPlanner_db_version' );

	// delete planners
	$args = array(
		'post_type'      => 'planner',
		'posts_per_page' => -1,
		'post_status'    => 'any'
	);

	$planner_items = new WP_Query( $args );

	while ( $planner_items->have_posts() ) : $planner_items->the_post();
		$id = get_the_ID();
		wp_delete_post( absint( $id ), true );
	endwhile;

	wp_reset_query();

	// delete planner meta from posts
	$args = array(
		'post_type'      => 'post',
		'posts_per_page' => -1,
		'post_status'    => 'any'
	);

	$post_items = new WP_Query( $args );

	while ( $post_items->have_posts() ) : $post_items->the_post();
		$id = get_the_ID();
		delete_post_meta( absint( $id ), '_postplanner' );
	endwhile;

	wp_reset_query();

	// delete taxonomy
	if ( !taxonomy_exists( 'plannercategories' ) ) {
		$labels = array(
			'name'          => _x( 'Categories', 'taxonomy general name' ),
			'singular_name' => _x( 'Category', 'taxonomy singular name' ),
		);

		register_taxonomy( 'plannercategories', array( 'planner' ), array(
			'hierarchical' => true,
			'labels'       => $labels,
			'show_ui'      => false,
			'query_var'    => false,
			'rewrite'      => false,
		) );
	}

	$terms = get_terms( 'plannercategories', '&hide_empty=0' );
	$count = count( $terms );
	if ( $count > 0 ) {
		foreach ( $terms as $term ) {
			wp_delete_term( $term->term_id, 'plannercategories' );
		}
	}
}