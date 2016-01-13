<?php 
/* 
Template Name: Page - Earmilk with Sidebar
*/ 
?>
<?php get_header(); // add header ?>  

<!-- Begin Content -->
<div class="wrap-fullwidth">

    <div class="single-content">
        <article>
            <?php if (have_posts()) : while (have_posts()) : the_post();  ?>
            <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">             

                        <div class="entry">
                          <h1 class="page-title"><?php the_title(); ?></h1>
                          <div class="p-first-letter">
                              <?php the_content(''); // content ?>
                          </div><!-- end .p-first-letter -->
                          <?php wp_link_pages(); // content pagination ?>
                          <div class="clear"></div><br />
                        </div><!-- end #entry -->
            </div><!-- end .post -->
            <?php endwhile; endif; ?>
        </article>
    </div><!-- end .single-content -->

    <!-- Begin Sidebar (right) -->
    <?php  get_sidebar(); // add sidebar ?>
    <!-- end #sidebar  (right) -->    

    <div class="clear"></div>
</div><!-- end .wrap-fullwidth -->

<?php get_footer(); // add footer  ?>