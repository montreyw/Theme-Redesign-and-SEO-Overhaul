<div id="rtt-slideout">
	<style type="text/css">
	#rtt-slideout {
		background:#ffffff;
		bottom:53px;
		position:fixed;
		right:-300px;
		width:296px;
		z-index: 1;
	}
	#rtt-slideout .close {
		color:#222222;
		cursor:pointer;
		font-family:Arial, sans-serif;
		font-size:26px;
		font-weight: bold;
		line-height:1;
		position:absolute;
		right:8px;
		top:1px;
		z-index: 99;
	}	
	@media(max-width:300px), (max-height:479px){
		#rtt-slideout { display:none; }
	}
	</style>
	<div class="close">&times;</div>
	<div class="fb-page" data-href="https://www.facebook.com/EARMILK" data-width="250" data-height="432" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/EARMILK"><a href="https://www.facebook.com/EARMILK">EARMILK</a></blockquote></div></div>
	<script type="text/javascript" async>
		jQuery(function($) {
			var hideSlideout = function(){
				$('#rtt-slideout').stop(true).animate({'right':'-300px'}, 100);
			}

			$(window).scroll(function(){
				var docHeight = $(document).height(),
		        scrollTop = $(window).scrollTop(),
		        windowHeight = $(window).height();
		    	slideHeight = 0.4 * docHeight;
		    
				if(docHeight - (scrollTop + windowHeight) < slideHeight) {
					$('#rtt-slideout').animate({'right': '0px'}, 300);
				}
				else if(docHeight - (scrollTop + windowHeight) > slideHeight) {
					hideSlideout();
				}
			});
			
			$('#rtt-slideout .close').on('mousedown touchstart', function(){
				hideSlideout();
				$('#rtt-slideout').hide();
			})
		});
	</script>
</div>