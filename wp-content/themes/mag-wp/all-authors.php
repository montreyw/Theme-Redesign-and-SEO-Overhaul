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
	<h1>All Authors at EARMILK</h1>
</div>

<!-- Begin Wrap Content -->
<div class="wrap-fullwidth hfeed h-feed">

	<!-- Begin Main Home Content 950px -->
	<div class="home-content">

		<div class="section-top-title">
			<h3>All Authors at EARMILK</h3>
		</div>

<?php

// Get the authors from the database ordered by user nicename
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

	// If user level is above 0 or login name is "admin", display profile
		if($curauth->user_level > 0 || $curauth->user_login == 'admin') :
		
		$post_count = count_user_posts( $curauth->ID );
		// Move on if user has not published a post (yet).
		if ( ! $post_count ) {
			continue;
		}

		// Get link to author page
			$user_link = get_author_posts_url($curauth->ID);

		// Set default avatar (values = default, wavatar, identicon, monsterid)
			$avatar = 'identicon';
?>

<div class="main authorbox">
<div class="authbox_left">
<a href="<?php echo $user_link; ?>" title="Articles by <?php echo $curauth->display_name; ?>">
<?php echo get_avatar($curauth->user_email, '96', $avatar); ?></a>
</div>
<div class="authbox_right">
<h2>
<a href="<?php echo $user_link; ?>" title="Articles by <?php echo $curauth->display_name; ?>"><?php echo $curauth->display_name; ?></a>
</h2>
<p style="margin-bottom:0;"><strong>Website:</strong> <a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->user_url; ?></a></p>
<p style="margin-bottom:4px;"><strong>Twitter: </strong><a href="<?php echo $curauth->jabber; ?>"><?php echo $curauth->jabber; ?></a></p>
<p style="margin-bottom:0;"><?php echo $curauth->description; ?></p>
<p style="margin-bottom:0;">$post_count == <?php echo $post_count; ?></p>
</div>		
<div style="clear:both;"></div>
</div> <!-- end post -->
<div style="clear:both;"></div>
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