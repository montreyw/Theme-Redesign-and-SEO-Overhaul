<?php
// ------------------------------------------------------
// ------ Comments --------------------------------------
// ------ by AnThemes.net -------------------------------
//        http://themeforest.net/user/An-Themes/portfolio
// ------------------------------------------------------
if ( ! function_exists( 'anthemes_comment' ) ) :
function anthemes_comment( $comment, $args, $depth ) {
$GLOBALS['comment'] = $comment;
switch ( $comment->comment_type ) :
case '' :
?>
      <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
            <div id="<?php comment_ID(); ?>">
            <div class="comment-body">
                  <?php comment_text(); ?>
                  <?php if ( $comment->comment_approved == '0' ) : ?>
                  <div style="display:block; color:red;"><?php _e('Your comment is awaiting moderation.', 'anthemes'); ?></div>
                  <?php endif; ?>
            </div>
            <span class="comm-avatar"><?php echo get_avatar( $comment, 20); ?></span>
            <span class="comment-author"><?php echo get_comment_author_link(); ?></span>
            <span class="comment-date"><?php echo get_comment_date(); ?> <?php echo get_comment_time(); ?></span>
            <span style="margin-left: 10px; font-size:12px;"><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></span>
            <div class="clear"></div>
          </div><!-- #comment- -->
<?php break; case 'pingback'  :  case 'trackback' : ?>
<li class="post pingback"> <p><?php _e('Pingback:', 'anthemes'); ?> <?php comment_author_link(); ?></p> </li>
<?php break; endswitch; } endif; ?>