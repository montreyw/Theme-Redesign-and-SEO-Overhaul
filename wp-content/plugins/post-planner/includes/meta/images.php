<?php
/**
 * Post Planner Plugin Images Metabox
 *
 * Create the Post Planner image metabox
 * @author C.M. Kendrick <cindy@seaserpentstudio.com>
 * @package post-planner
 * @version 1.0
 */
global $post_planner_wpalchemy_media_access;
?>

<div class="post-planner-meta-control">

	<?php do_action( 'post_planner_before_image_metabox' ); ?>

	<p class="post-planner-add"><a href="#" class="docopy-post-planner-images button"><?php echo apply_filters( 'post_planner_add_new_image', esc_html__( 'Add New Image',
		'post-planner' ) ); ?></a></p>

	<?php while ( $mb->have_fields_and_multi( 'post-planner-images' ) ): ?>

		<?php $mb->the_group_open(); ?>

		<p>
		<?php $mb->the_field( 'title' ); ?>
		<label for="image_title"><?php echo apply_filters( 'post_planner_image_title', esc_html__( 'Image Title', 'post-planner' ) ); ?>:</label>
		<input type="text" id="image_title" name="<?php esc_attr( $mb->the_name() ); ?>" value="<?php sanitize_text_field( $mb->the_value() ); ?>"/>

		<?php $mb->the_field( 'alt' ); ?>
		<label for="image_alt"><?php echo apply_filters( 'post_planner_image_alt', esc_html__( 'Image Alt', 'post-planner' ) ); ?>:</label>
		<input type="text" id="image_alt" name="<?php esc_attr( $mb->the_name() ); ?>" value="<?php sanitize_text_field( $mb->the_value() ); ?>"/>

		<label><?php echo apply_filters( 'post_planner_image_url', esc_html__( 'Image URL', 'post-planner' ) ); ?>:</label>
		<?php $mb->the_field( 'image' ); ?>
		<?php $post_planner_wpalchemy_media_access->setGroupName( 'image-n'.$mb->get_the_index() )->setInsertButtonLabel( apply_filters( 'post_planner_insert_image', esc_attr__( 'Insert Image',
			'post-planner' ) ) )->setTab( 'upload' ); ?>

		<?php echo $post_planner_wpalchemy_media_access->getField( array( 'name'  => esc_attr( $mb->get_the_name() ),
		                                                     'value' => esc_url( $mb->get_the_value() ) ) ); ?>
		<?php echo $post_planner_wpalchemy_media_access->getButton( array( 'label' => apply_filters( 'post_planner_upload_image', esc_attr__( 'Upload Image', 'post-planner' ) ) ) ); ?>

		<a href="#" class="dodelete button"><?php esc_html_e( 'Remove', 'post-planner' ); ?></a>
		</p>

		<?php $mb->the_group_close(); ?>

	<?php endwhile; ?>

	<?php  ?>

	<a href="#" class="dodelete-post-planner-images button post-planner-remove-all"><?php esc_html_e( 'Remove All', 'post-planner' ); ?></a>

	<div class="clear"></div>

	<?php do_action( 'post_planner_after_image_metabox' ); ?>

</div>