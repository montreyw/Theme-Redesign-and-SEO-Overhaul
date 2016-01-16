<?php
/**
 * Post Planner Plugin Checklist Metabox
 *
 * Creates the checklist metabox
 * @author C.M. Kendrick <cindy@seaserpentstudio.com>
 * @package post-planner
 * @version 1.0
 */
?>
<div class="post-planner-meta-side-control">

	<?php do_action( 'post_planner_before_checklist_metabox' ); ?>

	<input type="hidden" name="post-planner-id" id="post-planner-checklist-id" value="<?php echo absint( $post->ID ); ?>" />

	<ul id="post-planner-checklist">

	<?php
	$items = PostPlanner_Loader::$checklist;
	foreach ( $items as $item => $text ) : ?>
		<?php if ( $text != '' ) : ?>
			<li class="post-planner-list-item">
				<?php $mb->the_field( $item ); ?>
				<input type="checkbox" id="<?php esc_attr( $mb->the_name() ); ?>" name="<?php esc_attr( $mb->the_name() ); ?>" value="<?php echo esc_attr( $item ); ?>"<?php $mb->the_checkbox_state( $item ); ?> />
				<label for="<?php esc_attr( $mb->the_name() ); ?>"><?php echo sanitize_text_field( $text ); ?></label>
			</li>
		<?php endif; ?>
	<?php endforeach; ?>

	</ul>

	<?php do_action( 'post_planner_after_checklist_metabox' ); ?>

</div>