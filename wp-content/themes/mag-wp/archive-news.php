<?php 
/* 
Template Name: News - Archive
*/ 
?>
<?php get_header(); // add header  ?>
<?php
    // Options from admin panel
    global $smof_data;
?>

<div class="archive-header">
	<h1>News</h1>
</div>

<!-- Begin Wrap Content -->
<div class="wrap-fullwidth hfeed h-feed">

  <!-- Begin Main Home Content 950px -->
  <div class="home-content">

    <div class="section-top-title">
      <h3><?php _e('EARMILK News', 'anthemes'); ?></h3>
      <!-- Top social icons. -->
      <?php if (!empty($smof_data['top_icons'])) { ?>
        <?php echo stripslashes($smof_data['top_icons']); ?>
      <?php } ?>
    </div><div class="arrow-down-widget"></div>
    <div class="clear"></div><!-- end .section-top-title -->

    <ul id="masonry_list" class="classic-blog js-masonry"  data-masonry-options='{ "columnWidth": 0 }'> 
        <?php
            if ( get_query_var('paged') )  {  $paged = get_query_var('paged'); 
            } elseif ( get_query_var('page') ) { $paged = get_query_var('page');
            } else { $paged = 1;  }
            query_posts( array( 'post_type' => 'news', 'paged' => $paged ) );
            if (have_posts()) : while (have_posts()) : the_post();
        ?>
        
		<li <?php post_class('hentry h-entry') ?> id="post-<?php the_ID(); ?>">
			<?php if ( has_post_thumbnail()) { ?> 
				<div class="entry-thumb-cont">
					<a href="<?php the_permalink(); ?>" class="entry-thumbnail"> 
						<?php echo the_post_thumbnail('thumbnail-masonry'); ?>
					</a> 
			<?php } else { ?>
				<a href="<?php the_permalink(); ?>" class="entry-thumbnail">
					<img src="<?php echo get_template_directory_uri(); ?>/images/article-img.png" alt="article image" />
				</a>               
			<?php } // Post Thumbnail ?> <div class="clear"></div> 
          <div class="clear"></div> 

				<div class="article-category">
					<div class="post-date date updated">
						<span class="month"><?php the_time('M', '', '', true); ?></span> 
						<span class="day"><?php the_time('d', '', '', true); ?></span>
					</div>
					<span class="vcard author p-author h-card">
						<span class="fn">
							<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
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

          <div class="an-content">
            <h2 class="article-title entry-title">
	            <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
	        </h2>
            <p class="article-summary entry-summary"><?php echo anthemes_excerpt(strip_tags(strip_shortcodes(get_the_excerpt())), 130); ?></p>
			<div class="entry-footer">
				<div class="entry-comment-count">
					<i class="fa fa-comments-o"></i>&nbsp;&nbsp;&nbsp;<div class="facebook-comment-count"><fb:comments-count href="<?php echo get_permalink($post->ID); ?>"></fb:comments-count></div>
				</div>
				<div class="entry-read-more">
					<a href="<?php the_permalink(); ?>" title="Read the whole article.">Read More...</a>
				</div>
				<div class="entry-empty-box">&nbsp;
					<?php if(function_exists('taqyeem_get_score')) { ?>
						<?php taqyeem_get_score(); ?>
					<?php } ?>                   
				</div>
			</div>

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

      <?php if (!empty($smof_data['home728'])) { ?>
      <div class="home-728">
          <div class="img728">
          <?php echo stripslashes($smof_data['home728']); ?>
          </div>
      </div>
      <?php } ?>
  </div><!-- end .home-content -->


    <!-- Begin Sidebar 1 (default right) -->
    <?php get_sidebar(); // add sidebar ?>
    <!-- end #sidebar 1 (default right) --> 

        
<div class="clear"></div>
</div><!-- end .wrap-fullwidth -->

<?php get_footer(); // add footer  ?>