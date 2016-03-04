<?php get_header(); // add header ?>
<?php
	// Options from admin panel
	global $smof_data;
	$site_logo = $smof_data['site_logo'];
	if (empty($site_logo)) { $site_logo = get_template_directory_uri().'/images/logo.png'; }
?>
<!-- Begin Content -->
<div class="wrap-fullwidth hfeed h-feed" role="main">
    <div class="single-content hentry h-entry" 
	itemprop="mainEntity" itemscope itemtype="http://schema.org/BlogPosting">
        <span class="schema-meta">
			<?php 
				$post_date_human = get_the_date("F j, Y"); 
				$post_date_iso = get_the_date("c");
				$post_modified_date_human = get_the_modified_date("F j, Y");
				$post_modified_date_iso = get_the_modified_date("c");
				$post_tags_array = wp_get_post_tags($post->ID);
				$post_kyewords = '';
				foreach( $post_tags_array as $tag ) {
					if ( $post_kyewords == '' ) { $post_kyewords .= $tag->name; } else { $post_kyewords .= ', ' . $tag->name; };
				};
				$post_categories_array = wp_get_post_categories($post->ID);
				$post_sections = ''; 
				foreach( $post_categories_array as $cats ) {
					$cat = get_category( $cats );
					if ( $post_sections == '' ) { $post_sections .= $cat->name; } else { $post_sections .= ', ' . $cat->name; };
				};
			?>
            <meta itemprop="name headline" content="<?php the_title(); ?>" />
			<?php 
				if ( class_exists('WPSEO_Frontend') ) { 
	 				$wp_seo_object = WPSEO_Frontend::get_instance();
	 				$post_description = htmlentities( $wp_seo_object->metadesc( false ) ); 
					echo '<meta itemprop="description" content="' . $post_description . '" />'; }
			?>
			<meta itemprop="datePublished" content="<?php echo $post_date_iso ?>" />
			<span class="date published"><?php echo $post_date_iso ?></span>
			<meta itemprop="dateModified" content="<?php echo $post_modified_date_iso ?>" />
			<span class="date updated"><?php echo $post_modified_date_iso ?></span>
			<meta itemprop="url" content="<?php the_permalink(); ?>" />
			<meta itemprop="mainEntityOfPage" content="<?php the_permalink(); ?>" />
			<span itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
				<meta itemprop="name" content="EARMILK">
				<span itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
					<meta itemprop="url" content="<?php echo $site_logo; ?>">
					<meta itemprop="width" content="229">
					<meta itemprop="height" content="50">
				</span>
			</span>
			<span itemprop="author" itemscope itemtype="http://schema.org/Person">
				<meta itemprop="url" content="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" />
				<meta itemprop="image" content="<?php echo get_avatar_url( get_the_author_meta( 'user_email' ) ); ?>" />
				<meta itemprop="name" content="<?php echo get_the_author_meta( 'display_name' ); ?>" />
			</span>
			<meta itemprop="articleSection" content="<?php echo $post_sections; ?>" />
			<meta itemprop="keywords" content="<?php echo $post_kyewords; ?>" />
        </span>
        <?php if (have_posts()) : while (have_posts()) : the_post();  ?>
        <div class="entry-top">
            <h1 class="article-title entry-title p-name"><?php the_title(); ?></h1>
            <div class="entry-author-meta">
	            <span class="time date updated"><?php echo time_ago_anthemes(); ?> <?php _e('ago', 'anthemes'); ?></span>
	            <span class="author-meta-byline"><?php _e('by', 'anthemes'); ?>
	            	<span class="vcard author p-author h-card">
	            		<span class="fn"><?php the_author_posts_link(); ?></span>
	            	</span>
	            </span>
                <a class="author-photo" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
	                <?php echo get_avatar( get_the_author_meta( 'user_email' ), 70 ); ?>
	            </a>
                <ul class="author-social-inline">
                    <?php if(get_the_author_meta('facebook')) { ?><li class="facebook"><a target="_blank" href="//facebook.com/<?php echo the_author_meta('facebook'); ?>"><i class="fa fa-facebook"></i></a></li><?php } ?>
                    <?php if(get_the_author_meta('twitter')) { ?><li class="twitter"><a target="_blank" href="//twitter.com/<?php echo the_author_meta('twitter'); ?>"><i class="fa fa-twitter"></i></a></li><?php } ?>
                    <?php if(get_the_author_meta('google')) { ?><li class="google"><a target="_blank" href="//plus.google.com/<?php echo the_author_meta('google'); ?>?rel=author"><i class="fa fa-google-plus"></i></a></li><?php } ?>
                </ul>
            </div>
        </div><div class="clear"></div>
        <?php endwhile; endif; ?>
        <article class="entry-content">
            <?php if (have_posts()) : while (have_posts()) : the_post();  ?>
            <div class="<?php echo andre_get_post_class_without_hentry(); ?>" id="post-<?php the_ID(); ?>">
            <div class="media-single-content">
            <?php if ( function_exists( 'rwmb_meta' ) ) {
            // If Meta Box plugin is activate ?>
                <?php
                $youtubecode = rwmb_meta('anthemes_youtube', true );
                $vimeocode = rwmb_meta('anthemes_vimeo', true );
                $image = rwmb_meta('anthemes_slider', true );
                $hideimg = rwmb_meta('anthemes_hideimg', true );
                ?>
                <?php if(!empty($image)) { ?>
                    <!-- #### Single Gallery #### -->
                    <div class="single-gallery">
                        <?php
                        $images = rwmb_meta( 'anthemes_slider', 'type=image&size=thumbnail-small-gallery' );
                        foreach($images as $key =>$image)
                         { echo "<a href='{$image['full_url']}' rel='mygallery'><img src='{$image['url']}'  alt='{$image['alt']}' width='{$image['width']}' height='{$image['height']}' /></a>";
                        } ?>
                    </div><!-- end .single-gallery -->
                <?php } ?>
                <?php if(!empty($youtubecode)) { ?>
                    <!-- #### Youtube video #### -->
                    <iframe class="single_iframe" width="720" height="420" src="//www.youtube.com/embed/<?php echo $youtubecode; ?>?wmode=transparent" frameborder="0" allowfullscreen></iframe>
                <?php } ?>
                <?php if(!empty($vimeocode)) { ?>
                    <!-- #### Vimeo video #### -->
                    <iframe class="single_iframe" src="//player.vimeo.com/video/<?php echo $vimeocode; ?>?portrait=0" width="720" height="420" frameborder="0" allowFullScreen></iframe>
                <?php } ?>
                <?php if(!empty($image) || !empty($youtubecode) || !empty($vimeocode)) { ?>
                <?php } elseif ( has_post_thumbnail() ) { ?> 
					<?php
						$post_thumbnail_id = get_post_thumbnail_id();
						$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
					?>
					<div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
						<?php if ( get_the_post_thumbnail() ) { ?> 
							<?php echo the_post_thumbnail('thumbnail-single-image'); ?>
							<meta itemprop="url" content="<?php echo $post_thumbnail_url; ?>" />
						<?php } else { ?>
							<?php echo fallback_thumbnail_image(); ?>
							<meta itemprop="url" content="<?php echo fallback_thumbnail_image('src'); ?>" />
						<?php } // Post with messed up Thumbnail ?>
						<meta itemprop="width" content="950" />
						<meta itemprop="height" content="451" />
					</div>
				<?php } else { ?>
					<div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
						<?php echo fallback_thumbnail_image(); ?>
						<meta itemprop="url" content="<?php echo fallback_thumbnail_image('src'); ?>" />
						<meta itemprop="width" content="950" />
						<meta itemprop="height" content="451" />
					</div>
				<?php } // Post Thumbnail ?> 
            <?php } ?>
				<div class="clear"></div>
				<div id="single-share"></div>
				<!-- end #single-share -->
			</div><!-- end .media-single-content -->
                    <div class="entry">
                        <!-- entry content -->
                        <div class="p-first-letter" itemprop="articleBody">
                            <?php if (!empty($smof_data['ads_entry_top'])) { ?>
                            <?php } ?>
                            <?php if ( !empty( $post->post_excerpt ) ) : the_excerpt(); else : false; endif;  ?>
                            <?php the_content(''); // content ?>
                        </div><!-- end .p-first-letter -->
                        <?php wp_link_pages(); // content pagination ?>
                        <div class="clear"></div>
                        <!-- tags -->
                        <?php $tags = get_the_tags();
                        if ($tags): ?>
                            <div class="ct-size"><?php the_tags(__('<div class="entry-btn">Tags:</div>', 'anthemes'),' &middot; '); // tags ?></div><div class="clear"></div>
                        <?php endif; ?>
                        <!-- categories -->
                        <?php $categories = get_the_category();
                        if ($categories): ?>
                            <div class="ct-size"><?php _e( '<div class="entry-btn">Categories:</div>', 'anthemes' ); ?> <?php the_category(' &middot; '); // categories ?></div><div class="clear"></div>
                        <?php endif; ?>
                        <div class="clear"></div>

				        <!-- Comments -->
				        <div class="comments">
					        <?php if (get_comments_number()==0) { 
					        } else { ?>
					        <?php } ?>            
				            <h3 class="title">Comments</h3>
				            <?php comments_template('', true); // comments ?>
				        </div>

                    </div><!-- end .entry -->
                    <div class="clear"></div>
            </div><!-- end #post -->
            <?php endwhile; endif; ?>
        </article><!-- end article -->
        <!-- Recent and related Articles -->
        <div class="related-box">
            <!-- Recent -->
            <div class="one_half">
            <h3 class="title"><?php _e( 'Recent Articles', 'anthemes' ); ?></h3><div class="arrow-down-related"></div><div class="clear"></div>
            <ul class="article_list">
            <?php 
	            $anposts = new WP_Query(array('post_type' => 'post', 'posts_per_page' => 4 )); 
	            $post_ids = wp_list_pluck( $anposts->posts, 'ID' ); 
	        ?>
            <?php while ( $anposts->have_posts() ) : $anposts->the_post(); ?>
              <li>
                  <a href="<?php the_permalink(); ?>"> <?php echo the_post_thumbnail('thumbnail-widget-small'); ?> </a>
                  <div class="an-widget-title" <?php if ( has_post_thumbnail()) { ?> style="margin-left:70px;" <?php } ?>>
                    <h4 class="article-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                      <?php if(function_exists('taqyeem_get_score')) { ?>
                        <?php taqyeem_get_score(); ?>
                      <?php } ?>
                    <span><?php _e('by', 'anthemes'); ?> <?php the_author_posts_link(); ?></span>
                  </div>
              </li>
            <?php endwhile; wp_reset_query(); ?>
            </ul>
            </div><!-- end .one_half Recent -->
            <!-- Related -->
            <div class="one_half_last">
            <h3 class="title"><?php _e( 'Related Articles', 'anthemes' ); ?></h3><div class="arrow-down-related"></div><div class="clear"></div>
            <ul class="article_list">
                <?php
					$related_query = get_max_related_posts( $post_ids );
                    while( $related_query->have_posts() ) {
                    $related_query->the_post();
                ?>
              <li>
                  <a href="<?php the_permalink(); ?>"> <?php echo the_post_thumbnail('thumbnail-widget-small'); ?> </a>
                  <div class="an-widget-title" <?php if ( has_post_thumbnail()) { ?> style="margin-left:70px;" <?php } ?>>
                    <h4 class="article-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                      <?php if(function_exists('taqyeem_get_score')) { ?>
                        <?php taqyeem_get_score(); ?>
                      <?php } ?>
                    <span><?php _e('by', 'anthemes'); ?> <?php the_author_posts_link(); ?></span>
                  </div>
              </li>
            <?php } wp_reset_query(); ?>
            </ul>
            </div><!-- end .one_half_last Related -->
            <div class="clear"></div>
        </div><!-- end .related-box -->
        <!-- Comments -->
        <div class="entry-bottom">
            <script type="text/javascript">
            var wb = window.wb || (window.wb = {});
            wb.q || (wb.q = []);
            wb.q.push(['addGrid', {siteId: '113761', id : "wb-ad-grid"}])
            </script>
            <script async src='https://d2szg1g41jt3pq.cloudfront.net/'></script>
            <div id="wb-ad-grid"></div>
        </div><!-- end .entry-bottom -->
    </div><!-- end .single-content -->
    <!-- Begin Sidebar (right) -->
    <?php  get_sidebar(); // add sidebar ?>
    <!-- end #sidebar  (right) -->
    <div class="clear"></div>

    <?php custom_breadcrumbs(); ?>
    <div class="clear"></div>

</div><!-- end .wrap-fullwidth -->
<?php get_footer(); // add footer  ?>