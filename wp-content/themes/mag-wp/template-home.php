<?php
/*
Template Name: Template - Home Grid
*/
?>
<?php get_header(); // add header  ?>
<?php
    // Options from admin panel
    global $smof_data;
?>
<!-- Begin Wrap Content -->
<div class="wrap-fullwidth hfeed h-feed">
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
    <ul class="classic-blog">
        <?php
            if ( get_query_var('paged') )  {  $paged = get_query_var('paged');
            } elseif ( get_query_var('page') ) { $paged = get_query_var('page');
            } else { $paged = 1;  }
            query_posts( array( 'post_type' => 'post', 'paged' => $paged ) );
            if (have_posts()) : while (have_posts()) : the_post();
        ?>
        <li <?php post_class('hentry h-entry') ?> id="post-<?php the_ID(); ?>">
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