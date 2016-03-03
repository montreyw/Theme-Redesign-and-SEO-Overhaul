<?php
/*
Template Name: Template - EVENTS Archive List Page
*/
?>
<?php get_header(); // add header ?>
<!-- Begin Content - Template - EVENTS Archive List Page archive-events.php -->
<div class="wrap-fullwidth">
	<div class="single-content">
		<div class="entry">
			<?php if (have_posts()) : while (have_posts()) : the_post();  ?>
				<?php the_content(''); // content ?>
			<?php endwhile; endif; ?>
		</div>
<!--
		<article>
				<div class="<?php echo andre_get_post_class_without_hentry(); ?>" id="post-<?php the_ID(); ?>">
						<div class="p-first-letter entry-content">
						</div>
						<?php wp_link_pages(); // content pagination ?>
						<div class="clear"></div><br />
				</div>
		</article>
-->
	</div><!-- end .single-content -->
	<!-- Begin Sidebar (right) -->
	<?php  get_sidebar(); // add sidebar ?>
	<!-- end #sidebar  (right) -->
	<div class="clear"></div>

    <?php custom_breadcrumbs(); ?>
    <div class="clear"></div>

</div><!-- end .wrap-fullwidth -->
<?php get_footer(); // add footer  ?>