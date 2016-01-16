<?php
/**
 * Post Planner Plugin Comments Metabox
 *
 * Create the Post Planner comments metabox
 * @author C.M. Kendrick <cindy@seaserpentstudio.com>
 * @package post-planner
 * @version 1.2
 */
global $post;
$current_user = wp_get_current_user();
?>
<div class="post-planner-meta-control">

	<?php do_action( 'post_planner_before_comments_metabox' ); ?>

	<input type="hidden" name="post-planner-id" id="post-planner-comment-id" value="<?php echo absint( $post->ID ); ?>" />

	<?php
	echo '<p class="alignright"><a class="button-secondary" href="#post-planner-add-comment">'.apply_filters( 'post_planner_add_new_comment', esc_html__( 'Add New Comment',
		'post-planner' ) ).'</a></p>';

	$args = array(
		'post_id' => absint( $post->ID ),
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

	echo '<a name="post-planner-add-comment" id="post-planner-add-comment"></a>';

	wp_editor( '', 'postplannercommenttext', array( 'textarea_name' => 'post-planner-comment-text', 'textarea_rows' => 1, 'media_buttons' => false,
	              'editor_css'  => '<style>.wp_themeSkin iframe {background-color: #fff;}</style>', 'tinymce' => false ) );

	echo '<p class="alignright"><input class="button-primary" id="post-planner-add-comment" type="button" value="'.apply_filters( 'post_planner_add_comment', esc_attr__( 'Add Comment',
		'post-planner' ) ).'" /></p><div class="clear"></div>';
	?>

	<?php do_action( 'post_planner_after_comments_metabox' ); ?>

</div>