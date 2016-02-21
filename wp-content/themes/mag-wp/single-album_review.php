<?php get_header(); // add header ?>
<?php
    // Options from admin panel
    global $smof_data;
?>
<!-- Begin Content -->
<div class="wrap-fullwidth hfeed h-feed" role="main">
    <div class="single-content hentry h-entry" 
		itemprop="mainContentOfPage" itemscope itemtype="http://schema.org/WebPageElement">
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
        <article class="entry-content" itemprop="hasPart" itemscope itemtype="http://schema.org/MusicAlbum">
	        <div class="earmilk-album-review-meta" style="display:none;">
				<?php 
					$artist_name = get_field('artist_name');
					$album_name = get_field('album_name');					
					$date = get_field('release_date');
					$date_human = date("F j, Y", strtotime($date)); 
					$date_iso = date("c", strtotime($date)); 
					$record_label_name = get_field('labels')[0]['label_name']; 
					$record_label_location = get_field('labels')[0]['label_location']; 
					$record_label_url = get_field('labels')[0]['label_url']; 
					$review_rating = get_field('review_rating');
					$review_links = get_field('links');
				?>							
				<meta itemprop="name" content="<?php echo $album_name; ?>" />
				<meta itemprop="albumReleaseType" content="<?php echo get_field('release_type'); ?>" />
				<span itemprop="byArtist" itemscope itemtype="http://schema.org/MusicGroup">
					<meta itemprop="name" content="<?php echo $artist_name; ?>" />
				</span>
				<div itemprop="dateCreated">
					<time datetime="<?php echo $date_iso ?>">
						<?php echo $date_human; ?>
					</time>
				</div>
				<meta itemprop="url" content="<?php the_permalink(); ?>" />
				<meta itemprop="image" content="<?php echo wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ); ?>" />
				<span itemprop="sourceOrganization" itemscope itemtype="http://schema.org/Organization">
					<meta itemprop="name" content="<?php echo $record_label_name; ?>">
					<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
						<meta itemprop="addressLocality addressRegion" content="<?php echo $record_label_location; ?>" />
					</span>
					<meta itemprop="url" content="<?php echo $record_label_url; ?>" />
				</span>
	        </div>
				
            <?php if (have_posts()) : while (have_posts()) : the_post();  ?>
			<div class="<?php echo andre_get_post_class_without_hentry(); ?>" id="post-<?php the_ID(); ?>"
				itemprop="review" itemscope itemtype="http://schema.org/Review">
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
                <?php } elseif ( has_post_thumbnail()) { ?>
                    <?php if(!empty($hideimg)) { } else { ?>
                     <?php the_post_thumbnail('thumbnail-single-image'); ?>
                    <?php } // disable featured image ?>
                <?php } ?>
            <?php } else {
            // Meta Box Plugin ?>
                <?php the_post_thumbnail('thumbnail-single-image'); ?>
            <?php } ?>
                <div class="clear"></div>
                <div id="single-share"></div>
				<!-- end #single-share -->
            </div><!-- end .media-single-content -->
                    <div class="entry">
						<div class="earmilk-album-review" style="display:none;">
							<meta itemprop="name" content="EARMILK Review of <?php the_title(); ?>" />
							<table class="table table-condensed table-hover">
<!--
								<caption>
									Detail's of EARMILK Review of <?php the_title(); ?>
								</caption>
-->
								<thead>
									<tr>
										<th colspan="4">Detail's of EARMILK Review of <?php the_title(); ?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th scope="row">Artist Name:</th>
										<td>
											<div class="earmilk-review-artist">
												<?php echo $artist_name; ?>
											</div>
										</td>
										<th>Album Name:</th>
										<td>
											<div class="earmilk-review-album">
												<?php echo $album_name; ?> <?php the_post_thumbnail( array( 18, 18 ) ); ?>
											</div>
										</td>
									</tr>
									<tr>
										<th scope="row">Release Type:</th>
										<td>
											<div class="earmilk-review-release">
												<?php echo get_field('release_type'); ?>
											</div>
										</td>
										<th>Release Date:</th>
										<td>
											<div class="earmilk-review-album-release-date">
												<time datetime="<?php echo $date_iso ?>">
													<?php echo $date_human; ?>
												</time>
											</div>
										</td>
									</tr>
									<tr class="earmilk-review-label" itemprop="sourceOrganization" itemscope itemtype="http://schema.org/Organization">
										<th scope="row">Record Label:</th>
										<td>
											<div class="earmilk-review-label-name" itemprop="name">
												<a class="earmilk-review-label-url" href="<?php echo $record_label_url; ?>" itemprop="url">
													<?php echo $record_label_name; ?>
												</a>
											</div>
										</td>
										<th>Record Label Location:</th>
										<td>
											<div class="earmilk-review-label-location" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
												<span itemprop="addressLocality addressRegion">
													<?php echo $record_label_location; ?>
												</span>
											</div>
										</td>
									</tr>
									<tr>
										<th scope="row">Review Author:</th>
										<td>
											<div class="earmilk-review-author" itemprop="author" itemscope itemtype="http://schema.org/Person">
												<meta itemprop="url" content="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" />
												<meta itemprop="image" content="<?php echo get_avatar_url( get_the_author_meta( 'user_email' ) ); ?>" />
								                <a class="author-photo" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
													<span itemprop="name"><?php echo get_the_author_meta( 'display_name' ); ?></span>
									                <?php echo get_avatar( get_the_author_meta( 'user_email' ), 18 ); ?>
									            </a>
											</div>
										</td>
										<th>Review Date:</th>
										<td>
											<div class="earmilk-review-created-time" itemprop="dateCreated">
												<time datetime="<?php echo get_the_date('c'); ?>">
													<?php echo get_the_date('F j, Y'); ?>
												</time>
											</div>
										</td>
									</tr>
								</tbody>
								<tfoot>
									<?php 
										if ( $review_links !== NULL ) { 
											foreach ( $review_links as $review_link ) { ?>
												<tr class="earmilk-review-links" style="display:none;">
													<th colspan=""><?php echo $review_link['link_display_text']; ?></th>
													<td colspan="3">
														<a href="<?php echo $review_link['link_url']; ?>" 
															title="<?php echo $artist_name . ' on ' . $review_link['link_display_text']; ?>">
															<?php echo $review_link['link_url']; ?>
														</a>
													</td>
												</tr>
									<?php 
											};
										}; ?>
									<tr>
										<td></td>
										<th>Review Rating:</th>
										<td>
											<div class="earmilk-review-rating" 
												itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
												<meta itemprop="name" content="EARMILK Rating">
												<meta itemprop="bestRating" content="10">
												<meta itemprop="worstRating" content="1">
					                        	<div itemprop="ratingValue">
													<?php echo $review_rating; ?>
					                        	</div>
											</div>
										</td>
										<td></td>
									</tr>
								</tfoot>
							</table>

                        </div>


                        <!-- entry content -->
                        <div class="p-first-letter" itemprop="reviewBody">
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
            <?php $anposts = new WP_Query(array('post_type' => 'post', 'posts_per_page' => 4 )); // number to display more / less ?>
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
                    $orig_post = $post;
                    global $post;
                    $tags = wp_get_post_tags($post->ID);
                    if ($tags) {
                    $tag_ids = array();
                    foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
                    $args=array(
                    'tag__in' => $tag_ids,
                    'post__not_in' => array($post->ID),
                    'posts_per_page'=>4, // Number of related posts to display.
                    'ignore_sticky_posts'=>1
                    );
                    $my_query = new wp_query( $args );
                    while( $my_query->have_posts() ) {
                    $my_query->the_post();
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
            <?php } } $post = $orig_post; wp_reset_query(); ?>
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
</div><!-- end .wrap-fullwidth  -->
<?php get_footer(); // add footer  ?>