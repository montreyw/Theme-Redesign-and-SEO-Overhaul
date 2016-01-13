<?php 
/* 
Template Name: Template - Full Width
*/ 
?>
<?php get_header(); // add header ?>  

<!-- Begin Content -->
<div class="wrap-fullwidth-bg">

        <article>
            <?php if (have_posts()) : while (have_posts()) : the_post();  ?>
            <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">             

                        <div class="entry">
                          <h1 class="page-title"><?php the_title(); ?></h1>
                          <div class="p-first-letter">
                              <?php the_content(''); // content ?>
                          </div><!-- end .p-first-letter -->
                          <?php wp_link_pages(); // content pagination ?>
                          <div class="clear"></div>
                        </div><!-- end #entry -->
            </div><!-- end .post -->
            <?php endwhile; endif; ?>
        </article>

    <div class="clear"></div>
</div><!-- end .wrap-fullwidth-bg -->

<?php get_footer(); // add footer  ?>