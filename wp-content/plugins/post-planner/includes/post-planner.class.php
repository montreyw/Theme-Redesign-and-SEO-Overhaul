<?php
/**
 * Post Planner Plugin Main Class
 *
 * Display the Post Planner Data when Editing a Post
 * @author C.M. Kendrick <cindy@seaserpentstudio.com>
 * @package post-planner
 * @version 1.0

/**
 * Main class
 * @package post-planner
 * @subpackage includes
 */
class PostPlanner {

	/**
	 * Create a link to create a new Planner
	 * @static
	 * @since 1.0
	 */
	public static function create_planner() {
		global $post;
		echo '<input type="hidden" name="post-type" id="post-type" value="'.esc_attr( get_post_type( $post->ID ) ).'" />';
		echo apply_filters( 'post_planner_create_planner_link', '<p class="alignright"><a href="" class="button-secondary" id="create-new-planner">'.esc_html__( 'Create Planner', 'post-planner' ).'</a></p>' );
	}

	/**
	 * Display a link to view the associated Planner
	 * @static
	 * @param $planner_id
	 * @since 1.0
	 */
	public static function display_planner( $planner_id ) {
		echo apply_filters( 'post_planner_view_planner_link',
			'<p class="alignright"><a href="'.admin_url( 'post.php?post='.absint( $planner_id ).'&action=edit' ).'" class="button-secondary">'.esc_html__( 'View Planner', 'post-planner' ).'</a></p>', absint( $planner_id ) );
	}

	/**
	 * Display the Planner status
	 * @static
	 * @param $planner_id
	 * @since 1.0
	 */
	public static function display_status( $planner_id ) {
		global $post_planner_publish_mb;

		$post_planner_publish_mb->the_meta( $planner_id );

		if ( $post_planner_publish_mb->have_value( 'status' ) ) {
			echo apply_filters( 'post_planner_display_status', '<p class="post-planner-box">'.esc_html__( 'Status', 'post-planner' ).': '
				.sanitize_text_field( PostPlanner_Loader::$statuses[$post_planner_publish_mb->get_the_value( 'status' )]['name'] ).'</p>', PostPlanner_Loader::$statuses[$post_planner_publish_mb->get_the_value( 'status' )]['name'] );
		}
	}

	/**
	 * Display the Planner due date
	 * @static
	 * @param $planner_id
	 * @since 1.0
	 */
	public static function display_duedate( $planner_id ) {
		global $post_planner_publish_mb;

		$post_planner_publish_mb->the_meta( $planner_id );

		if ( $post_planner_publish_mb->have_value( 'duedate' ) ) {
			echo apply_filters( 'post_planner_display_duedate', '<p class="post-planner-box">'.esc_html__( 'Due Date', 'post-planner' ).': '.sanitize_text_field( $post_planner_publish_mb->get_the_value( 'duedate' ) ).'</p>', $post_planner_publish_mb->get_the_value( 'duedate' ) );
		}
	}

	/**
	 * Display the Planner details
	 * @static
	 * @param $planner_id
	 * @since 1.0
	 */
	public static function display_details( $planner_id ) {
		$content = PostPlanner_Lib::get_content( $planner_id );

		echo '<div class="post-planner-box">';
		do_action( 'post_planner_before_details' );
		echo apply_filters( 'post_planner_display_details', $content );
		do_action( 'post_planner_after_details' );
		echo '</div>';
	}

	/**
	 * Display the Planner assignments
	 * @static
	 * @param $planner_id
	 * @since 1.0
	 */
	public static function display_assignments( $planner_id ) {
		global $post_planner_publish_mb;

		$post_planner_publish_mb->the_meta( $planner_id );

		if ( $post_planner_publish_mb->have_value( 'assignment' ) && $post_planner_publish_mb->get_the_value( 'assignment' ) != -1 ) {
			$assign_user = get_userdata( absint( $post_planner_publish_mb->get_the_value( 'assignment' ) ) );
			echo apply_filters( 'post_planner_display_assignment', '<p class="post-planner-box">'.esc_html__( 'Assigned To', 'post-planner' ).': '.sanitize_text_field( $assign_user->display_name ).'</p>', $assign_user->display_name );
		}

	}

	/**
	 * Display the Planner references
	 * @static
	 * @param $planner_id
	 * @since 1.0
	 */
	public static function display_references( $planner_id ) {
		global $post_planner_references_mb;

		$post_planner_references_mb->the_meta( $planner_id );

		echo '<div class="post-planner-box">';

		do_action( 'post_planner_before_references' );

		if ( $post_planner_references_mb->have_value( 'post-planner-refs' ) ) {

			echo apply_filters( 'post_planner_references_description', '<p class="description">'.esc_html__( 'Organize the references in the order you want them to appear by dragging and dropping the items.
			Use the Insert button to add a reference notation for that item. Use Insert List to add a list of all the references.', 'post-planner' ).'</p>' );
			?>

			<ul class="post-planner-sortable references">
				<?php while ( $post_planner_references_mb->have_fields( 'post-planner-refs' ) ) { ?>

				<?php if ( $post_planner_references_mb->have_value( 'url' ) && $post_planner_references_mb->have_value( 'title' ) ) { ?>

					<li class="ui-state-default">
						<a class="reference-info" href="<?php esc_url( $post_planner_references_mb->the_value( 'url' ) ); ?>"
						<?php if ( $post_planner_references_mb->get_the_value( 'target' ) != '' ) echo ' target="'.esc_attr( $post_planner_references_mb->get_the_value( 'target' ) ).'" '; ?>
						<?php if ( $post_planner_references_mb->get_the_value( 'nofollow' ) == '1' ) echo ' rel="nofollow"'; ?>><?php sanitize_text_field( $post_planner_references_mb->the_value( 'title' ) ); ?></a>
						<input type="button" class="button-secondary planner-insert-reference" value="<?php esc_attr_e( 'Insert', 'post-planner' ); ?>" />
					</li>

					<?php } ?>

				<?php } ?>
			</ul>

			<input type="button" class="button-secondary" id="planner-insert-references-list" value="<?php echo apply_filters( 'post_planner_insert_references', esc_attr__( 'Insert References List',
			'post-planner' ) ); ?>"/>

		<?php } else {
			echo '<p>'.apply_filters( 'post_planner_no_references', esc_html__( 'No references found', 'post-planner' ) ).'</p>';
		}

		do_action( 'post_planner_after_references' );

		echo '</div>';

	}

	/**
	 * Display the Planner files
	 * @static
	 * @param $planner_id
	 * @since 1.0
	 */
	public static function display_files( $planner_id ) {
		global $post_planner_files_mb, $post;

		$post_planner_files_mb->the_meta( $planner_id );

		echo '<div class="post-planner-box">';

		do_action( 'post_planner_before_files' );

		if ( $post_planner_files_mb->have_value( 'post-planner-files' ) ) {

			echo apply_filters( 'post_planner_files_description', '<p class="description">'.esc_html__( 'Organize the files in the order you want them to appear by dragging and dropping the items.', 'post-planner' )
				.'<br />'.__( 'Use the Insert button to add only that specific file. Use Insert List to add a list of all the files.', 'post-planner' ).'</p>' );
			?>

			<ul class="post-planner-sortable files">
				<?php while ( $post_planner_files_mb->have_fields( 'post-planner-files' ) ) { ?>

					<?php if ( $post_planner_files_mb->have_value( 'file' ) ) {
						$attachment_id = PostPlanner_Lib::get_attachment_id_from_src( $post_planner_files_mb->get_the_value( 'file' ) );
						$inserted = ( PostPlanner_Lib::is_attached( $attachment_id, $post->ID ) ? ' inserted' : '' );
						?>

						<li class="ui-state-default<?php echo $inserted; ?>" id="<?php echo absint( $attachment_id ); ?>">
							<?php $icon = PostPlanner_Lib::get_attachment_icon( $attachment_id ); ?>
							<img src="<?php echo POSTPLANNER_PLUGIN_URL; ?>/css/images/<?php echo $icon; ?>" alt="" />
							<a href="<?php esc_url( $post_planner_files_mb->the_value( 'file' ) ); ?>" class="file-info"><?php sanitize_text_field( $post_planner_files_mb->the_value( 'title' ) ); ?></a>
							<input type="button" class="button-secondary planner-insert-file" value="<?php esc_attr_e( 'Insert', 'post-planner' ); ?>"/>
						</li>

					<?php } ?>

				<?php } ?>
			</ul>

			<input type="button" class="button-secondary" id="planner-insert-file-list" value="<?php echo apply_filters( 'post_planner_insert_files', esc_attr__( 'Insert File List',
			'post-planner' ) ); ?>"/>

		<?php
		} else {
			echo '<p>'.apply_filters( 'post_planner_no_files', esc_html__( 'No files found', 'post-planner' ) ).'</p>';
		}

		do_action( 'post_planner_after_files' );

		echo '</div>';

	}

	/**
	 * Display the Planner images
	 * @static
	 * @param $planner_id
	 * @since 1.0
	 */
	public static function display_images( $planner_id ) {
		global $post_planner_images_mb, $post;

		$post_planner_images_mb->the_meta( $planner_id );

		echo '<div class="post-planner-box">';

		do_action( 'post_planner_before_images' );

		if ( $post_planner_images_mb->have_value( 'post-planner-images' ) ) {

			echo apply_filters( 'post_planner_images_description', '<p class="description">'.esc_html__( 'Organize the images in the order you want them to appear by dragging and dropping the items.', 'post-planner' )
				.'<br />'.esc_html__( 'Use the Insert button to add only that specific image.', 'post-planner' ).
				( current_theme_supports( 'post-thumbnails' ) ? ' '.esc_html__( 'Use the Star icon to set the image as the Featured Image.', 'post-planner' ) : '' )
				.' '.esc_html__( 'Use Insert All Images to add all of the images.', 'post-planner' ).'</p>' );
			?>

			<ul id="post-planner-sortable-grid" class="images">
				<?php while ( $post_planner_images_mb->have_fields( 'post-planner-images' ) ) { ?>

					<?php if ( $post_planner_images_mb->have_value( 'image' ) ) {
						$attachment_id = PostPlanner_Lib::get_attachment_id_from_src( $post_planner_images_mb->get_the_value( 'image' ) );
						$inserted      = ( PostPlanner_Lib::is_attached( $attachment_id, $post->ID ) ? ' inserted' : '' );
						?>

						<li class="ui-state-default<?php echo $inserted; ?>" id="<?php echo absint( $attachment_id ); ?>">
							<?php $resized_image = PostPlanner_Lib::aq_resize( $post_planner_images_mb->get_the_value( 'image' ), '90', '60', true ); ?>
							<a href="<?php esc_url( $post_planner_images_mb->the_value( 'image' ) ); ?>" class="image-info">
								<img src="<?php echo esc_url( $resized_image ); ?>" alt="<?php esc_attr( $post_planner_images_mb->the_value( 'alt' ) ); ?>" title="<?php esc_attr( $post_planner_images_mb->the_value( 'title' ) ); ?>" />
							</a>
							<input type="button" class="button-secondary planner-insert-image" value="<?php esc_attr_e( 'Insert', 'post-planner' ); ?>" />
							<?php if ( current_theme_supports( 'post-thumbnails' ) ) : ?>
								<img src="<?php echo POSTPLANNER_PLUGIN_URL; ?>/css/images/bookmark.png" alt="" class="planner-insert-featured" />
							<?php endif; ?>
						</li>

					<?php } ?>

				<?php } ?>
			</ul>

			<div class="clear"></div><br />
			<input type="button" class="button-secondary" id="planner-insert-all_images" value="<?php echo apply_filters( 'post_planner_insert_images', esc_attr__( 'Insert All Images',
			'post-planner' ) ); ?>"/>

		<?php
		} else {
			echo '<p>'.apply_filters( 'post_planner_no_images', esc_html__( 'No images found', 'post-planner' ) ).'</p>';
		}

		do_action( 'post_planner_after_images' );

		echo '</div>';

	}

	/**
	 * Display the Planner checklist
	 * @static
	 * @param $planner_id
	 * @since 1.0
	 */
	public static function display_checklist( $planner_id ) {
		global $post_planner_checklist_mb;

		$post_planner_checklist_mb->the_meta( $planner_id );

		echo '<div class="post-planner-box">';

		do_action( 'post_planner_before_checklist' );

		echo '<input type="hidden" name="post-planner-checklist-id" id="post-planner-checklist-id" value="'.absint( $planner_id ).'" />';

		echo '<ul id="post-planner-checklist">';

		$items = PostPlanner_Loader::$checklist;
		foreach ( $items as $item => $text ) : ?>
			<?php if ( $text != '' ) : ?>
				<li class="post-planner-list-item">
					<?php $post_planner_checklist_mb->the_field( $item ); ?>
					<input type="checkbox" id="<?php esc_attr( $post_planner_checklist_mb->the_name() ); ?>" name="<?php esc_attr( $post_planner_checklist_mb->the_name() ); ?>"
						value="<?php echo esc_attr( $item ); ?>"<?php $post_planner_checklist_mb->the_checkbox_state( $item ); ?> />
					<label for="<?php esc_attr( $post_planner_checklist_mb->the_name() ); ?>"><?php echo esc_attr( $text ); ?></label>
				</li>
			<?php endif; ?>
		<?php
		endforeach;

		echo '</ul>';

		do_action( 'post_planner_after_checklist' );

		echo '</div>';
	}

	/**
	 * Displays a To-Do List
	 * @static
	 * @param $planner_id
	 * @since 1.1
	 */
	public static function display_todolist( $planner_id ) {
		global $current_user, $userdata;

		echo '<div class="post-planner-box">';

		do_action( 'post_planner_before_todolist' );

		echo '<ul id="post-planner-todolist">';

		$user = CTDL_Lib::get_user_id( $current_user, $userdata );
		$todo_items = PostPlanner_Lib::get_todos( $planner_id, $user );
		$show_completed = PostPlanner_Loader::$settings['ctdl_completed'];

		if ( $todo_items->have_posts() ) {
			while ( $todo_items->have_posts() ) : $todo_items->the_post();
				$id = get_the_ID();
				?>
				<li class="post-planner-todolist-item" id="todo-<?php echo esc_attr( $id ); ?>">
					<input type="checkbox" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $id ); ?>" <?php if ( $show_completed == 1 ) echo 'class="show-completed"'; ?> value="1" />
					<div><?php echo apply_filters( 'the_content', get_the_content() ); ?><?php do_action( 'post_planner_todo_meta', $id ); ?></div>
				</li>
			<?php
			endwhile;
		} else {
			echo apply_filters( 'post_planner_no_todo_items', esc_html__( 'There are no items to do.', 'post-planner' ) );
		}

		wp_reset_query();

		echo '</ul>';

		$permission = CTDL_Lib::check_permission( 'todo', 'add' );
		if ( $permission == true ) {
			echo '<p><a class="button-secondary floatright" href="'.admin_url( '/admin.php?page=cleverness-to-do-list&planner='.absint( $planner_id ) ).'#addtodo">'.apply_filters(
				'post_planner_add_todo', esc_html__( 'Add New To-Do Item', 'post-planner' ) ).' &raquo;</a></p>';
			echo '<div class="clear"></div>';
		}

	if ( $show_completed == 1 ) : ?>
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
	<?php endif;

		do_action( 'post_planner_after_todolist' );

		echo '</div>';
	}

	/**
	 * Display the Planner comments
	 * @static
	 * @param $planner_id
	 * @since 1.0
	 */
	public static function display_comments( $planner_id ) {
		$current_user = wp_get_current_user();

		echo '<div class="post-planner-box">';

		do_action( 'post_planner_before_comments' );

		$args     = array(
			'post_id' => absint( $planner_id ),
			'order'   => 'ASC',
		);

		$comments = get_comments( $args );
		foreach ( $comments as $comment ) :
			echo '<div class="post-planner-comment-box">';
			if ( get_avatar( $comment->comment_author ) != '' ) echo '<div class="post-planner-avatar">'.get_avatar( $comment->comment_author, '25' ).'</div>';
			echo '<div class="post-planner-display-comment'.( get_avatar( $comment->comment_author ) != '' ? ' post-planner-has-avatar' : '' ).'">'.$comment->comment_content.'</div>'
				.'<span class="post-planner-comment-details description alignright">'.esc_html__( 'posted by', 'post-planner' ).' '.sanitize_text_field( $comment->comment_author ).' '
				.human_time_diff( strtotime( $comment->comment_date ), current_time( 'timestamp' ) ).' '.esc_html__( 'ago', 'post-planner' );
			// check if user is comment author or if they can moderate comments
			if ( current_user_can( 'moderate_comments' ) || $comment->comment_author == $current_user->display_name )
				echo ' - <a href="'.admin_url( 'comment.php?action=editcomment&c='.absint( $comment->comment_ID ) ).'">'.esc_html__( 'edit', 'post-planner' ).'</a>';
			echo '</span></div>';
		endforeach;

		echo '<div class="clear"></div>';

		do_action( 'post_planner_after_comments' );

		echo '</div>';

	}
}