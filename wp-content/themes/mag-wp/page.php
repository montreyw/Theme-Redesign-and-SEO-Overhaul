<?php
/*
Template Name: Template - Default with Sidebar
*/
?>
<?php get_header(); // add header ?>
<!-- Begin Content - Template - Default with Sidebar page.php -->
<div class="wrap-fullwidth hfeed h-feed" role="main" 
	itemprop="mainContentOfPage" itemscope itemtype="http://schema.org/WebPageElement">
	<div class="single-content hentry h-entry">
		<article>
			<?php if (have_posts()) : while (have_posts()) : the_post();  ?>
				<div class="<?php echo andre_get_post_class_without_hentry(); ?>" id="post-<?php the_ID(); ?>">
					<div class="entry">
						<h1 class="page-title entry-title"><?php the_title(); ?></h1>
						<div class="p-first-letter entry-content">
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