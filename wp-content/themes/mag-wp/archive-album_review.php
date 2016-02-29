<?php 
/* 
Template Name: Album Reviews - Archive
*/ 
?>
<?php get_header(); // add header  ?>
<?php
    // Options from admin panel
    global $smof_data;
?>

<div class="archive-header">
	<h1><?php _e( 'Album Reviews', 'anthemes' ); ?></h1>
</div>

<!-- Begin Wrap Content -->
<div class="wrap-fullwidth hfeed h-feed">

	<!-- Begin Main Home Content 950px -->
	<div class="home-content" 
		itemprop="mainContentOfPage" itemscope itemtype="http://schema.org/WebPageElement">

		<div class="section-top-title">
			<h3><?php _e('Latest Album Reviews', 'anthemes'); ?></h3>
			<!-- Top social icons. -->
			<?php if (!empty($smof_data['top_icons'])) { ?>
				<?php echo stripslashes($smof_data['top_icons']); ?>
			<?php } ?>
		</div>
		<div class="clear"></div><!-- end .section-top-title -->

		<ul id="masonry_list" class="classic-blog js-masonry"  data-masonry-options='{ "columnWidth": 0 }'> 
			<?php
				if ( get_query_var('paged') )  { $paged = get_query_var('paged'); } 
				elseif ( get_query_var('page') )  { $paged = get_query_var('page'); } 
				else { $paged = 1; }
				query_posts( array( 'post_type' => 'album_review', 'paged' => $paged ) );
				if (have_posts()) : while (have_posts()) : the_post();
			?>
        
			<li <?php post_class('hentry h-entry') ?> id="post-<?php the_ID(); ?>" itemscope itemprop="hasPart" itemtype="http://schema.org/BlogPosting">
				<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php the_permalink(); ?>"/>
				<span itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
					<meta itemprop="name" content="EARMILK">
					<span itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
						<meta itemprop="url" content="http://earmilk.com/wp-content/uploads/2016/02/EARMILK_logo_3.png">
						<meta itemprop="width" content="229">
						<meta itemprop="height" content="50">
					</span>
				</span>
	
				<div class="entry-thumb-cont">
					<a href="<?php the_permalink(); ?>" class="entry-thumbnail">
						<span itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
							<?php
								$post_thumbnail_id = get_post_thumbnail_id();
								$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
								$review_rating = get_field('review_rating');
							?>
							<?php if ( has_post_thumbnail() ) { ?> 
								<?php if ( get_the_post_thumbnail() ) { ?> 
									<?php echo the_post_thumbnail('large'); ?>
									<meta itemprop="url" content="<?php echo $post_thumbnail_url; ?>" />
								<?php } else { ?>
									<?php echo fallback_thumbnail_image(); ?>
									<meta itemprop="url" content="<?php echo fallback_thumbnail_image('src'); ?>" />
								<?php } // Post with messed up Thumbnail ?>
							<?php } else { ?>
								<!-- post has no thumbnail -->
								<?php echo fallback_thumbnail_image(); ?>
								<meta itemprop="url" content="<?php echo fallback_thumbnail_image('src'); ?>" />
							<?php } // Post Thumbnail ?> 
							<meta itemprop="width" content="283" />
							<meta itemprop="height" content="133" />
						</span>
					</a> 
	
					<div class="article-category">
						<div class="post-date date updated">
							<?php if ( get_the_time('Y') == date('Y')) { ?> 
								<meta itemprop="datePublished" content="<?php the_time('c'); ?>"/>
								<meta itemprop="dateModified" content="<?php the_time('c'); ?>"/>
								<a href="<?php echo '/' . get_the_time('Y') . '/' . get_the_time('m') . '/'  ?>" title="">
									<span class="month"><?php the_time('M', '', '', true); ?></span> 
									<span class="day"><?php the_time('d', '', '', true); ?></span>
								</a>
							<?php } else { ?> 
								<meta itemprop="datePublished" content="<?php the_time('c'); ?>"/>
								<meta itemprop="dateModified" content="<?php the_time('c'); ?>"/>
								<a href="<?php echo '/' . get_the_time('Y') . '/' . get_the_time('m') . '/'  ?>" title="">
									<span class="month"><?php the_time('M', '', '', true); ?></span> 
									<span class="day"><?php the_time('d', '', '', true); ?></span>
									<span class="year">'<?php the_time('y', '', '', true); ?></span>
								</a>
							<?php } ?>
						</div>
						<span class="vcard author p-author h-card" itemprop="author" itemscope itemtype="https://schema.org/Person">
							<span class="fn" itemprop="name">
								<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" itemprop="url">
									<spam class="entry-author-first given-name"><?php the_author_meta('first_name'); ?></spam>
									<span class="entry-author-last family-name"><?php the_author_meta('last_name'); ?></span>
								</a>
							</span>
						</span>
						<?php 
							$category = get_the_category(); 
							if ($category) { $cat_name = 'genre-' . preg_replace('/\s+/', '', strtolower($category[0]->name)); };
							echo '<a href="' . get_category_link( $category[0]->term_id ) . '" class="tiptipBlog ' . $cat_name . '" title="' . sprintf( __( "View all posts in %s", "anthemes" ), $category[0]->name ) . '" rel="tag" ' . '>' . $category[0]->name.'</a> ';
						?>
					</div>
					<div class="earmilk-rating-bottle rating-<?php echo round($review_rating); ?>">
						<i class="earmilk-rating-<?php echo round($review_rating); ?>"><?php echo $review_rating; ?></i>
					</div>
				</div>
			
				<div class="an-content">
					<h2 class="article-title entry-title" itemprop="name headline">
						<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h2>
					<p class="article-summary entry-summary" itemprop="description">
						<?php echo anthemes_excerpt(strip_tags(strip_shortcodes(get_the_excerpt())), 137); ?>
					</p>
					<div class="entry-footer">
						<div class="entry-comment-count">
							<a href="<?php the_permalink(); ?>#comments">
								<i class="fa fa-comments-o"></i>&nbsp;&nbsp;&nbsp;
								<?php comments_number( 'add 2 cents', '1 comment', '% comments' ) ?>
							</a>
						</div>
						<div class="entry-read-more">
							<a href="<?php the_permalink(); ?>" title="Read the whole article.">Read More...</a>
						</div>
						<div class="entry-empty-box">&nbsp;</div>
					</div>
		
					<?php if(function_exists('taqyeem_get_score')) { ?>
						<?php taqyeem_get_score(); ?>
					<?php } ?>                   
				</div><!-- end .an-content -->
			</li>
			<?php endwhile; endif; ?>
		</ul><!-- end .classic-blog -->

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
