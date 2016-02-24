<?php get_header(); // add header  ?>
<?php
    // Options from admin panel
    global $smof_data;

    $home_select = (isset($smof_data['home_select'])) ? $smof_data['home_select'] : 'Grid Style';
?>



		<?php
			$musicgenre = array('dance', 'house', 'electro', 'bass-dance', 'deep-house', 'techno', 'progressive-dance', 'electro-house', 'hiphop', 'rap', 'rb', 'soul', 'reggae', 'trip-hop', 'jazz-hop', 'glitch-hop', 'indie', 'alternative', 'rock', 'indie-synth', 'chillout', 'folk', 'funk', 'soft-rock', 'electronic', 'dubstep', 'trap-electronic', 'electronica', 'mash-up', 'chillstep-electronic', 'future-funk', 'drum-and-bass-dance', 'experimental', 'downtempo', 'chillwave', 'ambient', 'psychedelic', 'jazz', 'lo-fi', 'dub', 'pop', 'synthpop', 'electro-pop', 'dreampop', 'dark-pop', 'surf-pop', 'noise-pop-2', 'oldies'); 
			if (is_category( $musicgenre )) { ?> 
			<div class="archive-header">
				<div class="line-box">
					<div class="header_line">
						<h1 class="top">
							<a href="/category/mainstage/" titles="<?php single_cat_title(''); ?> Stage">
								<?php single_cat_title(''); ?><?php _e( ' Stage', 'anthemes' ); ?>
							</a>
						</h1>
					</div>
				</div>
				<?php echo category_description(); ?>				
				<?php 
					$earmilk_json = file_get_contents( "custom/EARMILK_data.json", true );
					$earmilk_array = json_decode($earmilk_json);
					$cat_slug = get_category(get_query_var('cat'))->slug;
					$genre_playlists = $earmilk_array->EARMILK->genre->$cat_slug->header->playlists;
					if ( $genre_playlists != NULL ) : ?>
						<div class="genre-playlists">
							<div class="genre-spotify-playlist">
								<h3>Hotter Singles</h3>
								<?php echo $genre_playlists[0] ?>
							</div>				
							<div class="genre-spotify-playlist">
								<div class="playlist-tabs">
									<ul>
										<li><a href="#hot-singles"><h3>Hot Singles</h3></a></li>
										<li><a href="#dope-albums"><h3>Dope Albums</h3></a></li>
									</ul>
									<div id="hot-singles">
										<?php echo $genre_playlists[2] ?>
									</div>
									<div id="dope-albums">
										<?php echo $genre_playlists[1] ?>
									</div>
								</div>
								<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
								<script>
								jQuery( ".playlist-tabs" ).tabs();
								</script>
							</div>
						</div>
				<?php endif; ?>
			</div>
		<?php } elseif (is_category()) { ?> 
			<div class="archive-header">
				<h1><strong rel="tag"><?php single_cat_title(''); ?></strong></h1><?php echo category_description(); ?>
			</div>
		<?php } elseif (is_tag()) { ?>
			<div class="archive-header">
				<h1><strong rel="tag"><?php single_tag_title(''); ?></strong></h1>
			</div>
		<?php } elseif (is_search()) { ?>
			<div class="archive-header">
				<h1><?php printf( __( 'Search Results for: %s', 'anthemes' ), '<strong rel="tag">' . get_search_query() . '</strong>' ); ?></h1>
			</div>
		<?php } elseif (is_author()) { ?>
			<?php  
				$user_id = get_the_author_meta( 'ID' );
				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				$args = array(
					'posts_per_page' => 12,
					'paged'          => $paged,
					'post_type'      => array( 'post', 'opinion_post', 'gear_post', 'album_review', 'news'),
					'author__in'     => $user_id
			);
			query_posts( $args );  ?> 
				<?php if(get_the_author_meta('description') ): ?>
				<div class="archive-header" 
					itemprop="mainEntity" itemscope itemtype="https://schema.org/Person">
					<h1 rel="tag" itemprop="name"><?php the_author_posts_link(); ?></h1>
					<div class="author-meta">
						<div class="entry">
							<div class="author-photo-cont">
								<a href="<?php echo get_author_posts_url( $user_id ); ?>" class="author-nrposts">
									<?php echo number_format_i18n( get_the_author_posts() ); ?>
								</a>
								<a href="<?php echo get_author_posts_url( $user_id ); ?>" class="author-photo-anchor">
									<?php 
										$wp_avatar_profile    = get_user_meta( $user_id, 'wp_avatar_profile', true );
										$wp_fb_profile        = get_user_meta( $user_id, 'wp_fb_profile', true );
										$wp_avatar_capability = get_option( 'wp_avatar_capability', 'read' );
										$size = '300';
										$atts = array( 'extra_attr' => 'itemprop="image"' );
										if ( user_can( $user_id, $wp_avatar_capability ) ) {
											if ( 'wp-facebook' == $wp_avatar_profile && ! empty( $wp_fb_profile ) ) {
												$fb = 'https://graph.facebook.com/' . $wp_fb_profile . '/picture?width='. $size . '&height=' . $size;
												echo "<img alt='facebook-profile-picture' src='{$fb}' height='{$size}' width='{$size}' itemprop='image' />";
											} else {
												echo get_avatar( get_the_author_meta( 'user_email' ), 300, '', '', $atts );
											}
										} else {
											echo get_avatar( get_the_author_meta( 'user_email' ), 300, '', '', $atts );
										}
									?>
								</a>
							</div>
							<div class="author-info">
								<ul class="author-social-top">
									<?php if(get_the_author_meta('facebook')) { ?><li class="facebook">
										<a target="_blank" href="//facebook.com/<?php echo the_author_meta('facebook'); ?>">
											<i class="fa fa-facebook"></i></a></li><?php } ?>
									<?php if(get_the_author_meta('twitter')) { ?><li class="twitter">
										<a target="_blank" href="//twitter.com/<?php echo the_author_meta('twitter'); ?>">
											<i class="fa fa-twitter"></i></a></li><?php } ?>
									<?php if(get_the_author_meta('google')) { ?><li class="google">
										<a target="_blank" href="//plus.google.com/<?php echo the_author_meta('google'); ?>?rel=author">
											<i class="fa fa-google-plus"></i></a></li><?php } ?>                            
								</ul>
								<a class="author-link" href="<?php the_author_meta('url'); ?>" target="_blank"><?php the_author_meta('url'); ?></a><br />
								<p><?php the_author_meta('description'); ?></p>
							</div><!-- end .autor-info -->
						</div><!-- end .entry -->
						<div class="clear"></div>
					</div><!-- end .author-meta -->
				</div>
				<?php else: ?>
                <div class="archive-header"><h3><?php _e( 'All posts by:', 'anthemes' ); ?> <strong rel="tag"><?php the_author(); ?></strong></h3></div>
            <?php endif; ?>
        <?php } elseif (is_404()) { ?> 
            <div class="archive-header"><h3><?php _e('Error 404 - Not Found. <br />Sorry, but you are looking for something that isn\'t here.', 'anthemes'); ?></h3></div>
        <?php } ?> 



<!-- Begin Wrap Content -->
<div class="wrap-fullwidth hfeed h-feed" role="main" 
	itemprop="mainContentOfPage" itemscope itemtype="http://schema.org/WebPageElement">

	<!-- Begin Main Home Content 950px -->
	<div class="home-content">
		<div class="section-top-title">
			<?php if (is_author()): ?> 
				<h3><?php _e('Freshest Pieces by', 'anthemes'); ?> <?php the_author(); ?></h3>
			<?php elseif (is_search()): ?>
				<h3><?php _e('Freshest Search Results', 'anthemes'); ?></h3>
			<?php else: ?>
				<h3><?php _e('Freshest Content', 'anthemes'); ?></h3>
			<?php endif ?>
			<!-- Top social icons. -->
			<?php if (!empty($smof_data['top_icons'])) { ?>
				<?php echo stripslashes($smof_data['top_icons']); ?>
			<?php } ?>
		</div>
		<div class="arrow-down-widget"></div>
		<div class="clear"></div><!-- end .section-top-title -->



<?php if ($home_select == 'Grid Style') { ?>
	<ul class="classic-blog">  
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<li <?php post_class('hentry h-entry') ?> id="post-<?php the_ID(); ?>" itemscope itemprop="hasPart" itemtype="http://schema.org/BlogPosting">
			<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php the_permalink(); ?>"/>
			<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
				<meta itemprop="name" content="EARMILK">
				<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
					<meta itemprop="url" content="http://earmilk.com/wp-content/uploads/2016/02/EARMILK_logo_3.png">
					<meta itemprop="width" content="229">
					<meta itemprop="height" content="50">
				</div>
			</div>

			<div class="entry-thumb-cont">
				<a href="<?php the_permalink(); ?>" class="entry-thumbnail">
					<div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
						<?php
							$post_thumbnail_id = get_post_thumbnail_id();
							$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
						?>
						<?php if ( has_post_thumbnail() ) { ?> 
							<?php if ( get_the_post_thumbnail() ) { ?> 
								<?php echo the_post_thumbnail('thumbnail-blog'); ?>
								<meta itemprop="url" content="<?php echo $post_thumbnail_url; ?>" />
							<?php } else { ?>
								<?php echo fallback_thumbnail_image('tag'); ?>
								<meta itemprop="url" content="<?php echo fallback_thumbnail_image('src'); ?>" />
							<?php } // Post with messed up Thumbnail ?>
						<?php } else { ?>
							<!-- post has no thumbnail -->
							<?php echo fallback_thumbnail_image('tag'); ?>
							<meta itemprop="url" content="<?php echo fallback_thumbnail_image('src'); ?>" />
						<?php } // Post Thumbnail ?> 
						<meta itemprop="width" content="283" />
						<meta itemprop="height" content="133" />
					</div>
				</a> 

				<div class="article-category">
					<div class="post-date date updated">
						<?php if ( get_the_time('Y') == date('Y')) { ?> 
							<meta itemprop="datePublished" content="<?php the_time('c'); ?>"/>
							<meta itemprop="dateModified" content="<?php the_time('c'); ?>"/>
							<span class="month"><?php the_time('M', '', '', true); ?></span> 
							<span class="day"><?php the_time('d', '', '', true); ?></span>
						<?php } else { ?> 
							<meta itemprop="datePublished" content="<?php the_time('c'); ?>"/>
							<meta itemprop="dateModified" content="<?php the_time('c'); ?>"/>
							<span class="month"><?php the_time('M', '', '', true); ?></span> 
							<span class="day"><?php the_time('d', '', '', true); ?></span>
							<span class="year">'<?php the_time('y', '', '', true); ?></span>
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
						if ($category) { 
			            	echo '<a href="' . get_category_link( $category[0]->term_id ) . '" class="tiptipBlog" title="' . sprintf( __( "View all posts in %s", "anthemes" ), $category[0]->name ) . '" rel="tag" ' . '>' . $category[0]->name.'</a> ';}  
					?>
				</div>
			</div>
		
			<div class="clear"></div> 

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

<?php } else { ?>

    <ul id="masonry_list" class="classic-blog js-masonry"  data-masonry-options='{ "columnWidth": 1 }'>  
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<li <?php post_class('hentry h-entry') ?> id="post-<?php the_ID(); ?>" itemscope itemprop="hasPart" itemtype="http://schema.org/BlogPosting">
				<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php the_permalink(); ?>"/>
				<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
					<meta itemprop="name" content="EARMILK">
					<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
						<meta itemprop="url" content="http://earmilk.com/wp-content/uploads/2016/02/EARMILK_logo_3.png">
						<meta itemprop="width" content="229">
						<meta itemprop="height" content="50">
					</div>
				</div>
	
				<div class="entry-thumb-cont">
					<a href="<?php the_permalink(); ?>" class="entry-thumbnail">
						<div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
							<?php
								$post_thumbnail_id = get_post_thumbnail_id();
								$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
							?>
							<?php if ( has_post_thumbnail() ) { ?> 
								<?php if ( get_the_post_thumbnail() ) { ?> 
									<?php echo the_post_thumbnail('thumbnail-blog'); ?>
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
						</div>
					</a> 
	
					<div class="article-category">
						<div class="post-date date updated">
							<?php if ( get_the_time('Y') == date('Y')) { ?> 
								<meta itemprop="datePublished" content="<?php the_time('c'); ?>"/>
								<meta itemprop="dateModified" content="<?php the_time('c'); ?>"/>
								<span class="month"><?php the_time('M', '', '', true); ?></span> 
								<span class="day"><?php the_time('d', '', '', true); ?></span>
							<?php } else { ?> 
								<meta itemprop="datePublished" content="<?php the_time('c'); ?>"/>
								<meta itemprop="dateModified" content="<?php the_time('c'); ?>"/>
								<span class="month"><?php the_time('M', '', '', true); ?></span> 
								<span class="day"><?php the_time('d', '', '', true); ?></span>
								<span class="year">'<?php the_time('y', '', '', true); ?></span>
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
							if ($category) { 
				            	echo '<a href="' . get_category_link( $category[0]->term_id ) . '" class="tiptipBlog" title="' . sprintf( __( "View all posts in %s", "anthemes" ), $category[0]->name ) . '" rel="tag" ' . '>' . $category[0]->name.'</a> ';}  
						?>
					</div>
				</div>
			
				<div class="clear"></div> 
	
				<div class="an-content">
					<h2 class="article-title entry-title" itemprop="headline">
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
		<?php } ?>


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