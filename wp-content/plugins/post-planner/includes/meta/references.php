<?php
/**
 * Post Planner Plugin References Metabox
 *
 * Create the Post Planner reference metabox
 * @author C.M. Kendrick <cindy@seaserpentstudio.com>
 * @package post-planner
 * @version 1.0
 */
?>
<div class="post-planner-meta-control">

	<?php do_action( 'post_planner_before_reference_metabox' ); ?>

	<p class="post-planner-add"><a href="#" class="docopy-post-planner-refs button"><?php echo apply_filters( 'post_planner_add_new_reference', esc_html__( 'Add New Reference',
	'post-planner' ) ); ?></a></p>

	<?php while ( $mb->have_fields_and_multi( 'post-planner-refs' ) ): ?>

		<?php $mb->the_group_open(); ?>

		<?php $selected = ' selected="selected"'; ?>
		<p>
		<label for="ref_title"><?php echo apply_filters( 'post_planner_link_title', esc_html__( 'Link Title', 'post-planner' ) ); ?>:</label>
		<input type="text" id="ref_title" name="<?php esc_attr( $metabox->the_name( 'title' ) ); ?>" value="<?php sanitize_text_field( $metabox->the_value( 'title' ) ); ?>" />

		<label for="ref_url"><?php echo apply_filters( 'post_planner_url', esc_html__( 'URL', 'post-planner' ) ); ?>:</label>
		<input type="text" id="ref_url" name="<?php esc_attr( $metabox->the_name( 'url' ) ); ?>" value="<?php esc_url( $metabox->the_value( 'url' ) ); ?>" />

		<label for="ref_target"><?php echo apply_filters( 'post_planner_target', esc_html__( 'Target', 'post-planner' ) ); ?>:</label>
		<?php $metabox->the_field( 'target' ); ?>
		<select id="ref_target" name="<?php esc_attr( $metabox->the_name() ); ?>">
			<option value=""></option>
			<option value="_self"<?php if ( $metabox->get_the_value() == '_self' ) echo $selected; ?>>_self</option>
			<option value="_blank"<?php if ( $metabox->get_the_value() == '_blank' ) echo $selected; ?>>_blank</option>
		</select>

		<?php $metabox->the_field( 'nofollow' ); ?>
		<input type="checkbox" name="<?php esc_attr( $metabox->the_name() ); ?>" value="1"<?php if ( $metabox->get_the_value() ) echo ' checked="checked"'; ?> />
			<?php esc_html_e( 'Use', 'post-planner' ); ?> <code>nofollow</code>

		<a href="#" class="dodelete button"><?php esc_html_e( 'Remove', 'post-planner' ); ?></a>
		</p>

		<?php $mb->the_group_close(); ?>

	<?php endwhile; ?>

	<a href="#" class="dodelete-post-planner-refs button post-planner-remove-all"><?php esc_html_e( 'Remove All', 'post-planner' ); ?></a>

	<div class="clear"></div>

	<?php do_action( 'post_planner_after_reference_metabox' ); ?>

</div>