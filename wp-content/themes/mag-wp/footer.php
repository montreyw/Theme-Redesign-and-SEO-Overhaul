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

</div><!-- end #ajax-content -->

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
		<div class="earmilk-copyright">
			<span itemprop="creator copyrightHolder" itemscope itemtype="http://schema.org/Organization">
			<span itemprop="name">EARMILK, Inc.</span><link itemprop="sameAs" href="//earmilk.com" />
			</span> Trusted Since <span itemprop="copyrightYear">2009</span>
		<img id="earmilky" src="/wp-content/themes/mag-wp/images/Milky-V3-shadow-73px.png" title="Turn down your speakers and Click me! Weee!" alt="Milky form Blur's Coffee and TV" >
		</div>
		<div class="hosted-by">
			<span>
				Hosted by <a href="http://www.komputerking.com/" target="_blank">Komputer King LLC</a>
			</span>
		</div>
    </div>

	<p id="back-top" style="display: block;"><a href="#top"><span></span></a></p>
  </div>
</footer><!-- end #footer -->

<!-- Start Alexa Certify Javascript -->
<script type="text/javascript">
_atrk_opts = { atrk_acct:"PBGOm1aMp4Z3Y8", domain:"earmilk.com",dynamic: true};
(function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://d31qbv1cthcecs.cloudfront.net/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
</script>
<noscript><img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=PBGOm1aMp4Z3Y8" style="display:none" height="1" width="1" alt="" /></noscript>
<!-- End Alexa Certify Javascript -->  

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
<script type="text/javascript">var jquerycssmenu={fadesettings:{overduration:0,outduration:100},buildmenu:function(b,a){jQuery(document).ready(function(e){var c=e("#"+b+">ul");var d=c.find("ul").parent();d.each(function(g){var h=e(this);var f=e(this).find("ul:eq(0)");this._dimensions={w:this.offsetWidth,h:this.offsetHeight,subulw:f.outerWidth(),subulh:f.outerHeight()};this.istopheader=h.parents("ul").length==1?true:false;f.css({top:this.istopheader?this._dimensions.h+"px":0});h.hover(function(j){var i=e(this).children("ul:eq(0)");this._offsets={left:e(this).offset().left,top:e(this).offset().top};var k=this.istopheader?0:this._dimensions.w;k=(this._offsets.left+k+this._dimensions.subulw>e(window).width())?(this.istopheader?-this._dimensions.subulw+this._dimensions.w:-this._dimensions.w):k;i.css({left:k+"px"}).fadeIn(jquerycssmenu.fadesettings.overduration)},function(i){e(this).children("ul:eq(0)").fadeOut(jquerycssmenu.fadesettings.outduration)})});c.find("ul").css({display:"none",visibility:"visible"})})}};var arrowimages={down:['downarrowclass', '<?php echo get_template_directory_uri(); ?>/images/menu/arrow-down.png'], right:['rightarrowclass', '<?php echo get_template_directory_uri(); ?>/images/menu/arrow-right.png']}; jquerycssmenu.buildmenu("myjquerymenu"); jquerycssmenu.buildmenu("myjquerymenu2");</script>

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