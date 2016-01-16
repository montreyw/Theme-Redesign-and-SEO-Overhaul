<?php
/**
 * Post Planner Plugin Publish Metabox
 *
 * Recreates the Publish metabox
 * @author C.M. Kendrick <cindy@seaserpentstudio.com>
 * @package post-planner
 * @version 1.0
 */

global $action, $post;

$post_type        = $post->post_type;
$post_type_object = get_post_type_object( $post_type );
$can_publish      = current_user_can( $post_type_object->cap->publish_posts );
?>
<div id="submitdiv">
<div class="submitbox" id="submitpost">

	<?php do_action( 'post_planner_before_publish_metabox' ); ?>

	<div id="minor-publishing">

		<div id="misc-publishing-actions">

			<?php if ( PostPlanner_Loader::$settings['duedate'] == 1 ) : ?>
			<div class="misc-pub-section">
				<label for="<?php esc_attr( $mb->the_name( 'duedate' ) ); ?>"><?php echo apply_filters( 'post_planner_duedate', esc_html__( 'Due Date', 'post-planner' ) ); ?>:</label>
				<input type="text" id="<?php esc_attr( $mb->the_name( 'duedate' ) ); ?>" class="post-planner post-planner-datepicker" name="<?php esc_attr( $mb->the_name( 'duedate' ) ); ?>"
					value="<?php sanitize_text_field( $mb->the_value( 'duedate' ) ); ?>" />
			</div>
			<?php endif; ?>

			<div class="misc-pub-section">
				<?php $mb->the_field( 'status' ); ?>
				<label for="<?php esc_attr( $mb->the_name() ); ?>"><?php echo apply_filters( 'post_planner_status', esc_html__( 'Status', 'post-planner' ) ); ?>
					:</label>
				<select id="<?php esc_attr( $mb->the_name() ); ?>" name="<?php esc_attr( $mb->the_name() ); ?>" class="post-planner-status">
					<?php foreach ( PostPlanner_Loader::$statuses as $key => $value ) : ?>
					<option value="<?php echo absint( $key ); ?>"<?php echo $mb->the_select_state( $key ); ?>><?php echo sanitize_text_field( $value['name'] ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<?php if ( PostPlanner_Loader::$settings['assignments'] == 1 ) : ?>
			<div class="misc-pub-section">
				<label for="assignment"><?php echo apply_filters( 'post_planner_assignments', esc_html__( 'Assign To', 'post-planner' ) ); ?>:</label>
				<?php $mb->the_field( 'assignment' ); ?>
				<select name="<?php esc_attr( $mb->the_name( 'assignment' ) ); ?>" class="post-planner-assignment">
					<option value="-1"<?php echo $mb->the_select_state( -1 ); ?>><?php esc_attr_e( 'None', 'post-planner' ); ?></option>
					<?php
					if ( PostPlanner_Loader::$settings['user_roles'] == '' ) {
						$roles = array( 'contributor', 'author', 'editor', 'administrator' );
					} else {
						$roles = explode( ',', PostPlanner_Loader::$settings['user_roles'] );
					}
					foreach ( $roles as $role ) {
						$role_users = PostPlanner_Lib::get_users( $role );
						foreach ( $role_users as $role_user ) {
							$user_info = get_userdata( $role_user->ID ); ?>
							<option value="<?php echo absint( $role_user->ID ); ?>"<?php echo $mb->the_select_state( $role_user->ID ); ?>><?php echo sanitize_text_field( $user_info->display_name ); ?></option>
							<?php
						}
					}
					?>
				</select>
			</div>
			<?php endif; ?>

			<?php
			if ( isset( PostPlanner_Loader::$settings['post_types'] ) ) {
				$planner_post_types = explode( ',', PostPlanner_Loader::$settings['post_types'] );
				$mb->the_field( 'type' );
				if ( count( $planner_post_types ) > 1 ) : ?>
                    <div class="misc-pub-section">
                        <label for="<?php esc_attr( $mb->the_name() ); ?>"><?php echo apply_filters( 'post_planner_post_type', esc_html__( 'Post Type', 'post-planner' ) ); ?>:</label>
                        <select name="<?php esc_attr( $mb->the_name() ); ?>" id="<?php esc_attr( $mb->the_name() ); ?>" class="post-planner-type">
							<?php
							foreach ( $planner_post_types as $planner_post_type ) {
								$planner_type = get_post_type_object( $planner_post_type );
								if ( is_object( $planner_type ) ) {
									echo '<option value="'.esc_attr( $planner_post_type ).'"'.$mb->get_the_select_state( $planner_post_type ).'>'.$planner_type->labels->singular_name.'</option>';
								}
							}
							?>
                        </select>
                    </div>
				<?php else : ?>
                    <input type="hidden" name="<?php esc_attr( $mb->the_name() ); ?>" value="<?php echo $planner_post_types[0]; ?>" />
				<?php endif;
			}
            ?>

		</div>
		<div class="clear"></div>
	</div>

	<div id="major-publishing-actions">
		<?php do_action( 'post_submitbox_start' ); ?>
		<div id="delete-action">
			<?php
			if ( current_user_can( "delete_post", $post->ID ) ) {
				if ( !EMPTY_TRASH_DAYS )
					$delete_text = __( 'Delete Permanently' );
				else
					$delete_text = __( 'Move to Trash' );
				?>
				<a class="submitdelete deletion"
						href="<?php echo get_delete_post_link( $post->ID ); ?>"><?php echo $delete_text; ?></a><?php
			} ?>
		</div>

		<div id="publishing-action">
			<img src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" class="ajax-loading" id="ajax-loading" alt="" />
			<?php
			if ( !in_array( $post->post_status, array( 'publish', 'future', 'private' ) ) || 0 == $post->ID ) {
				if ( $can_publish ) :
					if ( !empty( $post->post_date_gmt ) && time() < strtotime( $post->post_date_gmt.' +0000' ) ) : ?>
						<input name="original_publish" type="hidden" id="original_publish"
								value="<?php esc_attr_e( 'Schedule' ) ?>" />
						<?php submit_button( __( 'Schedule' ), 'primary', 'publish', false, array( 'tabindex'  => '5',
						                                                                           'accesskey' => 'p' ) ); ?>
						<?php else : ?>
						<input name="original_publish" type="hidden" id="original_publish"
								value="<?php esc_attr_e( 'Save', 'post-planner' ) ?>" />
						<?php submit_button( __( 'Save', 'post-planner' ), 'primary', 'publish', false, array( 'tabindex'  => '5',
						                                                                                       'accesskey' => 'p' ) ); ?>
						<?php    endif;
				else : ?>
					<input name="original_publish" type="hidden" id="original_publish"
							value="<?php esc_attr_e( 'Submit for Review' ) ?>" />
					<?php submit_button( __( 'Submit for Review' ), 'primary', 'publish', false, array( 'tabindex'  => '5',
					                                                                                    'accesskey' => 'p' ) ); ?>
					<?php
				endif;
			} else {
				?>
				<input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e( 'Update' ) ?>" />
				<input name="save" type="submit" class="button-primary" id="publish" tabindex="5" accesskey="p"
						value="<?php esc_attr_e( 'Update' ) ?>" />
				<?php
			} ?>
		</div>
		<div class="clear"></div>
	</div>

	<?php do_action( 'post_planner_after_publish_metabox' ); ?>

</div>
</div>