<?php
/**
 * Post Planner Plugin Files Metabox
 *
 * Create the Post Planner file metabox
 * @author C.M. Kendrick <cindy@seaserpentstudio.com>
 * @package post-planner
 * @version 1.0
 */
global $post_planner_wpalchemy_media_access;
?>

<div class="post-planner-meta-control">

	<?php do_action( 'post_planner_before_file_metabox' ); ?>

	<p class="post-planner-add"><a href="#" class="docopy-post-planner-files button"><?php echo apply_filters( 'post_planner_add_new_file', esc_html__( 'Add New File', 'post-planner' ) ); ?></a></p>

	<?php while ( $mb->have_fields_and_multi( 'post-planner-files' ) ): ?>

		<?php $mb->the_group_open(); ?>

		<p>
		<?php $mb->the_field( 'title' ); ?>
		<label for="file_title"><?php echo apply_filters( 'post_planner_file_title', esc_html__( 'File Title', 'post-planner' ) ); ?>:</label>
		<input type="text" id="file_title" name="<?php esc_attr( $mb->the_name() ); ?>" value="<?php sanitize_text_field( $mb->the_value() ); ?>"/>

		<label><?php echo apply_filters( 'post_planner_file_url', esc_html__( 'File URL', 'post-planner' ) ); ?>:</label>
		<?php $mb->the_field( 'file' ); ?>
		<?php $post_planner_wpalchemy_media_access->setGroupName( 'file-n'.$mb->get_the_index() )->setInsertButtonLabel( apply_filters( 'post_planner_insert_file', esc_attr__( 'Insert File',
			'post-planner' ) ) )->setTab( 'upload' ); ?>

		<?php echo $post_planner_wpalchemy_media_access->getField( array( 'name'  => esc_attr( $mb->get_the_name() ),
		                                                     'value' => esc_url( $mb->get_the_value() ) ) ); ?>
		<?php echo $post_planner_wpalchemy_media_access->getButton( array( 'label' => apply_filters( 'post_planner_upload_file', esc_attr__( 'Upload File', 'post-planner' ) ) ) ); ?>

		<a href="#" class="dodelete button"><?php esc_html_e( 'Remove', 'post-planner' ); ?></a>
		</p>

		<?php $mb->the_group_close(); ?>

	<?php endwhile; ?>

	<?php  ?>

	<a href="#" class="dodelete-post-planner-files button post-planner-remove-all"><?php esc_html_e( 'Remove All', 'post-planner' ); ?></a>

	<div class="clear"></div>

	<?php do_action( 'post_planner_after_file_metabox' ); ?>

</div>