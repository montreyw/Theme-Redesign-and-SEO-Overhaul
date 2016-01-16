<?php
/**
 * Post Planner Plugin Associated Post Metabox
 *
 * Creates the associated post metabox
 * @author C.M. Kendrick <cindy@seaserpentstudio.com>
 * @package post-planner
 * @version 1.0
 */
$planner_permission       = true;
$associated_post_id       = ( get_post_meta( $post->ID, '_pp_postid', true ) ? get_post_meta( $post->ID, '_pp_postid', true ) : false );
$planner_post_type        = ( get_post_meta( $post->ID, '_pp_type', true ) ? get_post_meta( $post->ID, '_pp_type', true ) : PostPlanner_Lib::get_default_post_type() );
$planner_post_type_object = get_post_type_object( $planner_post_type );

if ( $associated_post_id != false ) {

	// check if associated post still exists
	if ( get_post( $associated_post_id ) == null ) {
		$associated_post_id = false;
		delete_post_meta( absint( $post->ID ), '_pp_postid' );
	}

	// check if user can edit associated content
	if ( $planner_post_type == 'post' ) {
		$planner_permission = current_user_can( 'edit_post', $associated_post_id );
	} elseif ( $planner_post_type == 'page' ) {
		$planner_permission = current_user_can( 'edit_page', $associated_post_id );
	} else {
		$planner_permission = apply_filters( 'post_planner_associated_permission', current_user_can( 'edit_post', $associated_post_id ), $planner_post_type );
	}

}

?>
<div class="post-planner-meta-side-control">

	<?php do_action( 'post_planner_before_associated_metabox' ); ?>

	<input type="hidden" name="post-planner-id" id="post-planner-id" value="<?php echo absint( $post->ID ); ?>" />
	<input type="hidden" name="post-planner-type" id="post-planner-type" value="<?php echo esc_attr( $planner_post_type ); ?>" />

	<div class="misc-pub-section post-planner-create-post<?php if ( $associated_post_id != false ) echo ' hide' ?>">
		<?php esc_html_e( 'Create a New', 'post-planner' ); ?> <?php echo $planner_post_type_object->labels->singular_name; ?>:
		<input name="post-planner-create" type="button" class="button-secondary" id="post-planner-create-post" value="<?php esc_attr_e( 'Create', 'post-planner' ) ?>" />
	</div>

	<div class="misc-pub-section post-planner-select-post<?php if ( $associated_post_id != false ) echo ' hide' ?>">
		<label for="post-planner-associate-post"><?php esc_html_e( 'Select an Existing', 'post-planner' ); ?> <?php echo $planner_post_type_object->labels->singular_name; ?>:</label>
		<input name="post-planner-associate" type="button" class="button-secondary" id="post-planner-associate-post" value="<?php esc_attr_e( 'Associate', 'post-planner' ) ?>" />
		<br /><br />

		<?php
		// get all of post type entries
		$args = array(
			'post_type'      => $planner_post_type,
			'posts_per_page' => -1,
			'post_status'    => 'any'
			);
		$items = get_posts( apply_filters( 'post_planner_associated_content_args', $args ) );

		do_action( 'post_planner_get_associated_content' )
		?>

		<?php $mb->the_field( 'postid' ); ?>
		<select name="<?php esc_attr( $mb->the_name() ); ?>" id="post-planner-associated-id">
			<option value=""><?php esc_attr_e( 'Select', 'post-planner' ); ?> <?php echo $planner_post_type_object->labels->singular_name; ?></option>
			<?php
			foreach ( $items as $item ) {
				?>
				<option value="<?php echo absint( $item->ID ); ?>"<?php echo $mb->the_select_state( $item->ID ); ?>><?php echo sanitize_text_field( $item->post_title ); ?></option>
				<?php
			}
			?>
		</select>
	</div>

	<?php if ( $planner_permission == true ) : ?>
		<div id="major-publishing-actions" class="post-planner-existing-associations<?php if ( $associated_post_id == false ) echo ' hide' ?>">
			<a id="post-planner-delete-association" href=""><?php esc_html_e( 'Remove', 'post-planner' ); ?></a>
			<input type="hidden" name="post-planner-post-id" id="post-planner-post-id" value="<?php echo absint( $associated_post_id ); ?>" />
			<input name="post-planner-visit" type="button" class="button-primary" id="post-planner-visit-post" value="<?php esc_attr_e( 'View Associated', 'post-planner' ) ?> <?php echo $planner_post_type_object->labels->singular_name; ?>" />
		</div>
	<?php else : ?>
		<p><?php esc_html_e( 'Associated Post belongs to', 'post-planner' ); ?> <?php echo PostPlanner_Lib::get_post_author( $associated_post_id ); ?>.</p>
	<?php endif; ?>

	<?php do_action( 'post_planner_after_associated_metabox' ); ?>

</div>