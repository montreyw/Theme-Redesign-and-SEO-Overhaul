<?php
/**
 * Post Planner Plugin To-Do List Metabox
 *
 * Creates the to-do list metabox
 * @author C.M. Kendrick <cindy@seaserpentstudio.com>
 * @package post-planner
 * @version 1.4
 * @since 1.1
 */
global $current_user, $userdata;
?>
<div class="post-planner-meta-side-control">

	<?php do_action( 'post_planner_before_todolist_metabox' ); ?>

	<input type="hidden" name="post-planner-id" id="post-planner-checklist-id" value="<?php echo absint( $post->ID ); ?>" />

	<ul id="post-planner-todolist">

		<?php
		$user = CTDL_Lib::get_user_id( $current_user, $userdata );
		$planner_id = $post->ID;
		$todo_items = PostPlanner_Lib::get_todos( $planner_id, $user );
		$show_completed = PostPlanner_Loader::$settings['ctdl_completed'];

		if ( $todo_items->have_posts() ) {

			while ( $todo_items->have_posts() ) : $todo_items->the_post();
				$pp_todo_id = get_the_ID();
		?>
				<li class="post-planner-todolist-item" id="todo-<?php echo esc_attr( $pp_todo_id ); ?>">
					<input type="checkbox" id="<?php echo esc_attr( $pp_todo_id ); ?>" name="<?php echo esc_attr( $pp_todo_id ); ?>"
						<?php if ( $show_completed == 1 ) echo 'class="show-completed"'; ?> value="1" />
					<div><?php echo apply_filters( 'the_content', get_the_content() ); ?><?php do_action( 'post_planner_todo_meta', $pp_todo_id ); ?></div>
				</li>
		<?php
			endwhile;
		} else {
		echo apply_filters( 'post_planner_no_todo_items', esc_html__( 'There are no items to do.', 'post-planner' ) );
	}

		wp_reset_query();
		?>

	</ul>

	<?php
	$permission = CTDL_Lib::check_permission( 'todo', 'add' );
	if ( $permission == true ) {
		echo '<p>
		<a class="button-secondary floatright" href="'.admin_url( '/admin.php?page=cleverness-to-do-list&planner='.absint( $planner_id ) ).'#addtodo">'.apply_filters(
		'post_planner_add_todo', esc_html__( 'Add New To-Do Item', 'post-planner' ) ).' &raquo;</a></p>';
		echo '<div class="clear"></div>';
		}
	?>

	<?php if ( $show_completed == 1 ) : ?>
		<ul id="post-planner-todolist-completed">
		<?php
		$todo_items = PostPlanner_Lib::get_todos( $planner_id, $user, -1, 1 );
		if ( $todo_items->have_posts() ) {

		while ( $todo_items->have_posts() ) : $todo_items->the_post();
		$pp_todo_id = get_the_ID();
		?>
		<li class="post-planner-todolist-item" id="todo-<?php echo esc_attr( $pp_todo_id ); ?>">
			<input type="checkbox" id="<?php echo esc_attr( $pp_todo_id ); ?>" name="<?php echo esc_attr( $pp_todo_id ); ?>"
					<?php if ( $show_completed == 1 ) echo 'class="show-completed"'; ?> value="0" checked="checked" />

			<div><?php echo apply_filters( 'the_content', get_the_content() ); ?><?php do_action( 'post_planner_todo_completed_meta', $pp_todo_id ); ?></div>
		</li>
		<?php
	endwhile;
	} else {
		echo apply_filters( 'post_planner_no_completed_todo_items', esc_html__( 'There are no completed items.', 'post-planner' ) );
	}

		wp_reset_query();
		?>
		</ul>
	<?php endif; ?>

	<?php do_action( 'post_planner_after_todolist_metabox' ); ?>

</div>