<?php get_header(); // add header  ?>
<?php
    // Options from admin panel
    global $smof_data;

    $home_select = (isset($smof_data['home_select'])) ? $smof_data['home_select'] : 'Grid Style';
?>


<!-- Begin Wrap Content -->
<div class="wrap-fullwidth">

  <!-- Begin Main Home Content 950px -->
  <div class="home-content">

    <div class="section-top-title">
      <h3><?php _e('Latest Articles', 'anthemes'); ?></h3>
      <!-- Top social icons. -->
      <?php if (!empty($smof_data['top_icons'])) { ?>
        <?php echo stripslashes($smof_data['top_icons']); ?>
      <?php } ?>
    </div><div class="arrow-down-widget"></div>
    <div class="clear"></div><!-- end .section-top-title -->



        <?php if (is_category()) { ?> 
            <div class="archive-header"><h3><?php _e( 'All posts in:', 'anthemes' ); ?> <strong><?php single_cat_title(''); ?></strong></h3><?php echo category_description(); ?></div>
        <?php } elseif (is_tag()) { ?>
            <div class="archive-header"><h3><?php _e( 'All posts tagged in:', 'anthemes' ); ?> <strong><?php single_tag_title(''); ?></strong></h3></div>
        <?php } elseif (is_search()) { ?>
            <div class="archive-header"><h3><?php printf( __( 'Search Results for: %s', 'anthemes' ), '<strong>' . get_search_query() . '</strong>' ); ?></h3></div>
        <?php } elseif (is_author()) { ?>
            <?php if(get_the_author_meta('description') ): ?>
            <div class="archive-header"><h3><?php _e( 'All posts by:', 'anthemes' ); ?> <strong><?php the_author(); ?></strong></h3></div>
            <div class="author-meta">
                <div class="entry">
                    <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" class="author-nrposts"><?php echo number_format_i18n( get_the_author_posts() ); ?></a>
                    <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_avatar( get_the_author_meta( 'user_email' ), 100 ); ?></a>
                    <div class="author-info">
                        <strong><?php the_author_posts_link(); ?></strong> &rsaquo; <a class="author-link" href="<?php the_author_meta('url'); ?>" target="_blank"><?php the_author_meta('url'); ?></a><br />
                        <p><?php the_author_meta('description'); ?></p>
                        <ul class="author-social-top">
                            <?php if(get_the_author_meta('facebook')) { ?><li class="facebook"><a target="_blank" href="//facebook.com/<?php echo the_author_meta('facebook'); ?>"><i class="fa fa-facebook"></i></a></li><?php } ?>
                            <?php if(get_the_author_meta('twitter')) { ?><li class="twitter"><a target="_blank" href="//twitter.com/<?php echo the_author_meta('twitter'); ?>"><i class="fa fa-twitter"></i></a></li><?php } ?>
                            <?php if(get_the_author_meta('google')) { ?><li class="google"><a target="_blank" href="//plus.google.com/<?php echo the_author_meta('google'); ?>?rel=author"><i class="fa fa-google-plus"></i></a></li><?php } ?>                            
                        </ul><div class="clear"></div>
                    </div><!-- end .autor-info -->
                </div><!-- end .entry -->
                <div class="clear"></div>
            </div><!-- end .author-meta -->
            <?php else: ?>
                <div class="archive-header"><h3><?php _e( 'All posts by:', 'anthemes' ); ?> <strong><?php the_author(); ?></strong></h3></div>
            <?php endif; ?>
        <?php } elseif (is_404()) { ?> 
            <div class="archive-header"><h3><?php _e('Error 404 - Not Found. <br />Sorry, but you are looking for something that isn\'t here.', 'anthemes'); ?></h3></div>
        <?php } ?> 

    
<?php if ($home_select == 'Grid Style') { ?>
    <ul class="classic-blog">  
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <li <?php post_class('') ?> id="post-<?php the_ID(); ?>">

          <?php if ( has_post_thumbnail()) { ?> 
            <div class="post-date">
              <span class="month"><?php the_time('M', '', '', true); ?></span> 
              <span class="day"><?php the_time('d', '', '', true); ?></span>
            </div><!-- end .post-date -->
                
            <a href="<?php the_permalink(); ?>"> <?php echo the_post_thumbnail('thumbnail-blog'); ?></a> 
            <div class="article-category"><i></i> <?php $category = get_the_category(); if ($category) 
              { echo '<a href="' . get_category_link( $category[0]->term_id ) . '" class="tiptipBlog" title="' . sprintf( __( "View all posts in %s", "anthemes" ), $category[0]->name ) . '" ' . '>' . $category[0]->name.'</a> ';}  ?>
            </div><div class="arrow-down-cat"></div><!-- end .article-category --> 
          <?php } else { ?>
            <div class="post-date">
              <span class="month"><?php the_time('M', '', '', true); ?></span> 
              <span class="day"><?php the_time('d', '', '', true); ?></span>
            </div><!-- end .post-date -->          
            <a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/article-img.png" alt="article image" /></a> 
            <div class="article-category"><i></i> <?php $category = get_the_category(); if ($category) 
              { echo '<a href="' . get_category_link( $category[0]->term_id ) . '" class="tiptipBlog" title="' . sprintf( __( "View all posts in %s", "anthemes" ), $category[0]->name ) . '" ' . '>' . $category[0]->name.'</a> ';}  ?>
            </div><div class="arrow-down-cat"></div><!-- end .article-category -->                 
          <?php } // Post Thumbnail ?> <div class="clear"></div> 

          <div class="an-content">
            <h2 class="article-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

            <?php if(function_exists('taqyeem_get_score')) { ?>
              <?php taqyeem_get_score(); ?>
            <?php } ?>                   
            <span><?php _e('Written by', 'anthemes'); ?> <?php the_author_posts_link(); ?></span>
          </div><!-- end .an-content -->

        </li>
        <?php endwhile; endif; ?>
    </ul><!-- end .classic-blog -->

<?php } else { ?>
    <ul id="masonry_list" class="classic-blog js-masonry"  data-masonry-options='{ "columnWidth": 1 }'>  
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <li <?php post_class('') ?> id="post-<?php the_ID(); ?>">

          <?php if ( has_post_thumbnail()) { ?> 
            <div class="post-date">
              <span class="month"><?php the_time('M', '', '', true); ?></span> 
              <span class="day"><?php the_time('d', '', '', true); ?></span>
            </div><!-- end .post-date -->
                
            <a href="<?php the_permalink(); ?>"> <?php echo the_post_thumbnail('thumbnail-masonry'); ?></a> 
          <?php } else { ?>
            <div class="post-date">
              <span class="month"><?php the_time('M', '', '', true); ?></span> 
              <span class="day"><?php the_time('d', '', '', true); ?></span>
            </div><!-- end .post-date -->          
            <a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/article-img.png" alt="article image" /></a>               
          <?php } // Post Thumbnail ?> <div class="clear"></div> 

          <div class="an-content">
            <h2 class="article-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

            <?php if(function_exists('taqyeem_get_score')) { ?>
              <?php taqyeem_get_score(); ?>
            <?php } ?>                    
            <span><?php _e('by', 'anthemes'); ?> <?php the_author_posts_link(); ?></span>
            <span><?php _e('in', 'anthemes'); ?> <?php $category = get_the_category(); if ($category) { echo '<a href="' . get_category_link( $category[0]->term_id ) . '">' . $category[0]->name.'</a> ';}  ?></span>
            <p><?php echo anthemes_excerpt(strip_tags(strip_shortcodes(get_the_excerpt())), 105); ?></p>
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

      <div class="home-728" style="margin-left:-1.5em">
          <?php echo get_template_part('custom/advertisement/unit/leaderboard2'); ?>
      </div>
  </div><!-- end .home-content -->


    <!-- Begin Sidebar 1 (default right) -->
    <?php get_sidebar(); // add sidebar ?>
    <!-- end #sidebar 1 (default right) --> 

        
<div class="clear"></div>
</div><!-- end .wrap-fullwidth -->

<?php get_footer(); // add footer  ?>