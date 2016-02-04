<?php
	/*-----------------------------------------------------------------------------------*/
	/* Start Footer
	/*-----------------------------------------------------------------------------------*/
	/**
	 *
	 * The template for displaying the footer
	 *
	 * Displays all of the <head> section and everything up till <div id="main">
	 *
	 * @package WordPress
	 * @subpackage Earmilk Theme
	 * @since Earmilk ...
	 */
?>
<?php
    // Options from admin panel
    global $smof_data;

?> 

<!-- Begin Footer -->
<footer  role="contentinfo" 
	itemprop="hasPart" itemscope itemtype="http://schema.org/WPFooter">
	<meta itemprop="name" content="EARMILK Site Footer" />
	<meta itemprop="description" content="This is the footer for EARMILK.com" />
  <div class="footer-section"> 
	<div class="social-section">
	    <!-- footer social icons. -->
	    <?php if (!empty($smof_data['bottom_icons'])) { ?>
	        <?php echo stripslashes($smof_data['bottom_icons']); ?>
	    <?php } ?>
	</div>

	<div class="wrap-footer">
        <div class="one_fourth">
            <?php if ( ! dynamic_sidebar( 'footer1' ) ) : endif; ?><!-- #1st footer -->
        </div>
        <div class="one_fourth">
            <?php if ( ! dynamic_sidebar( 'footer2' ) ) : endif; ?><!-- #2nd footer -->
        </div>
        <div class="one_fourth">
            <?php if ( ! dynamic_sidebar( 'footer3' ) ) : endif; ?><!-- #3rd footer -->
        </div>
        <div class="one_fourth_last">
            <?php if ( ! dynamic_sidebar( 'footer4' ) ) : endif; ?><!-- #4th footer -->
        </div><div class="clear"></div> 
    </div>


    <div class="copyright">
        <?php if (!empty($smof_data['copyright_footer'])) { ?>
            <?php echo stripslashes($smof_data['copyright_footer']); ?>
        <?php } ?>  
		<img id="earmilky" src="/wp-content/uploads/Milky-V1-shadow-73px.png" title="Click me! Weee!" alt="Milky form Blur's Coffee and TV" >
    </div>

	<p id="back-top" style="display: block;"><a href="#top"><span></span></a></p>
  </div>
</footer><!-- end #footer -->

<!-- Facebook Like Button -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
	fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
<!-- Google+ Place this tag in your head or just before your close body tag. -->
<script src="https://apis.google.com/js/platform.js" async defer></script>

<!-- Menu & link arrows -->
<script type="text/javascript">var jquerycssmenu={fadesettings:{overduration:0,outduration:100},buildmenu:function(b,a){jQuery(document).ready(function(e){var c=e("#"+b+">ul");var d=c.find("ul").parent();d.each(function(g){var h=e(this);var f=e(this).find("ul:eq(0)");this._dimensions={w:this.offsetWidth,h:this.offsetHeight,subulw:f.outerWidth(),subulh:f.outerHeight()};this.istopheader=h.parents("ul").length==1?true:false;f.css({top:this.istopheader?this._dimensions.h+"px":0});h.children("a:eq(0)").css(this.istopheader?{paddingRight:a.down[2]}:{}).append('<img src="'+(this.istopheader?a.down[1]:a.right[1])+'" class="'+(this.istopheader?a.down[0]:a.right[0])+'" style="border:0;" />');h.hover(function(j){var i=e(this).children("ul:eq(0)");this._offsets={left:e(this).offset().left,top:e(this).offset().top};var k=this.istopheader?0:this._dimensions.w;k=(this._offsets.left+k+this._dimensions.subulw>e(window).width())?(this.istopheader?-this._dimensions.subulw+this._dimensions.w:-this._dimensions.w):k;i.css({left:k+"px"}).fadeIn(jquerycssmenu.fadesettings.overduration)},function(i){e(this).children("ul:eq(0)").fadeOut(jquerycssmenu.fadesettings.outduration)})});c.find("ul").css({display:"none",visibility:"visible"})})}};var arrowimages={down:['downarrowclass', '<?php echo get_template_directory_uri(); ?>/images/menu/arrow-down.png'], right:['rightarrowclass', '<?php echo get_template_directory_uri(); ?>/images/menu/arrow-right.png']}; jquerycssmenu.buildmenu("myjquerymenu", arrowimages); jquerycssmenu.buildmenu("myjquerymenu2", arrowimages);</script>

<?php if ( ! is_singular() || is_page_template( 'template-home-2.php' ) ) { ?>
<!-- Masonry Style -->
<script>jQuery( window ).load( function( $ ) {"use strict"; var $container = jQuery('#masonry_list'); $container.imagesLoaded( function(){ $container.masonry({ itemSelector : '' }); });});</script>
<?php } ?>

<!-- Google analytics  -->
<?php if( !empty( $smof_data['google_analytics']) ) { echo stripslashes($smof_data['google_analytics']); } ?>

<!-- Footer Theme output -->
<?php wp_footer();?>
</body>
</html>