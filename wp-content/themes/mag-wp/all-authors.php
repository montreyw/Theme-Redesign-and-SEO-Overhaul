<?php 
/* 
Template Name: All Authors Page
*/ 
?>
<?php get_header(); // add header  ?>
<?php
    // Options from admin panel
    global $smof_data;
?>

<div class="archive-header">
	<h1><?php _e('All Authors at EARMILK', 'anthemes'); ?></h1>
</div>

<!-- Begin Wrap Content -->
<div class="wrap-fullwidth hfeed h-feed">

	<!-- Begin Main Home Content 950px -->
	<div class="home-content">
		<div class="section-top-title">
			<h3><?php _e('All Authors at EARMILK', 'anthemes'); ?></h3>
		</div>

	<?php
		// Get the authors from the database ordered by user nicename
		$current_month = date('m');
		$current_year = date('Y');
		$args = array(
			//'role'         => 'author',
			'role__in'     => [ 'administrator', 'editor', 'author', 'contributor', 'aamrole_53856fd146ba3' ],
			'orderby'      => 'display_name'
		);
		$authors = get_users( $args );
		// Loop through each author
		foreach($authors as $author) :
			// Get user data
			$curauth = get_userdata($author->ID);
			$userID = $curauth->ID;
			// If user level is above 0 or login name is "admin", display profile
			if($curauth->user_level > 0 || $curauth->user_login == 'admin') :
				$post_count = count_user_posts( $userID );
				// Move on if user has not published a post (yet).
				if ( ! $post_count ) {
					continue;
				}
				// Get link to author page
				$user_link = get_author_posts_url( $userID );
				// Set default avatar (values = default, wavatar, identicon, monsterid)
				$avatar = 'default';

				$posts_this_month = count( get_posts('year=' . $current_year . '&monthnum=' . $current_month . '&author=' . $userID . '&posts_per_page=-1') );

	?>

				<div class="main authorbox">
					<div class="authbox_left">
						<a href="<?php echo $user_link; ?>" title="Articles by <?php echo $curauth->display_name; ?>">
						<?php echo get_avatar($userID, '300'); ?></a>
					</div>
					<div class="authbox_right">
						<h2>
							<a href="<?php echo $user_link; ?>" title="Articles by <?php echo $curauth->display_name; ?>"><?php echo $curauth->display_name; ?></a>
						</h2>
						<div class="author-info">
							<ul class="author-social-top">
								<?php if(get_the_author_meta('facebook', $userID)) { ?><li class="facebook">
									<a target="_blank" href="//facebook.com/<?php echo the_author_meta('facebook', $userID); ?>">
										<i class="fa fa-facebook"></i></a></li><?php } ?>
								<?php if(get_the_author_meta('twitter', $userID)) { ?><li class="twitter">
									<a target="_blank" href="//twitter.com/<?php echo the_author_meta('twitter', $userID); ?>">
										<i class="fa fa-twitter"></i></a></li><?php } ?>
								<?php if(get_the_author_meta('google', $userID)) { ?><li class="google">
									<a target="_blank" href="//plus.google.com/<?php echo the_author_meta('google', $userID); ?>?rel=author">
										<i class="fa fa-google-plus"></i></a></li><?php } ?>
							</ul>
							<a class="author-link" href="<?php the_author_meta('url', $userID); ?>" target="_blank"><?php the_author_meta('url', $userID); ?></a><br />
							<p><?php the_author_meta('description'); ?></p>
						</div><!-- end .autor-info -->

<!--
						<p><strong>Website:</strong> <a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->user_url; ?></a></p>
						<p><strong>Twitter: </strong><a href="<?php echo $curauth->jabber; ?>"><?php echo $curauth->jabber; ?></a></p>
-->
						<p><?php echo $curauth->description; ?></p>
						<span class="author-post-count">Published Posts: <span><?php echo $post_count; ?></span></span>
						<span class="author-monthly-post-count">Posts this month: <span><?php echo $posts_this_month; ?></span></span>
					</div>		
					<div style="clear:both;"></div>
				</div> <!-- end post -->
				<div></div>
			<?php endif; ?>
		<?php endforeach; ?>

		<!-- Pagination -->    
		<div class="line-bottom"></div>
		<div class="clear"></div>
		<?php if(function_exists('wp_pagenavi')) { ?>
			<?php wp_pagenavi(); ?>
		<?php } else { ?>
			<div class="defaultpag">
				<div class="sright"><?php next_posts_link('' . __('Older Entries', 'anthemes') . ' &rsaquo;'); ?></div>
				<div class="sleft"><?php previous_posts_link('&lsaquo; ' . __('Newer Entries', 'anthemes') . ''); ?></div>
			</div>
		<?php } ?>
		<!-- pagination -->

	</div><!-- end .home-content -->

	<!-- Begin Sidebar 1 (default right) -->
	<?php get_sidebar(); // add sidebar ?>
	<!-- end #sidebar 1 (default right) --> 

<div class="clear"></div>
</div><!-- end .wrap-fullwidth -->

<?php get_footer(); // add footer  ?>