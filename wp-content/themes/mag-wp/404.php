<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
get_header(); ?>
	<div id="primary" class="content-area">

		<style>
			@media (min-width: 992px) {
				.container {
				max-width: 955px;
				}
				.col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11 {
				float: left;
				}
				.col-md-4 {
				width: 33.33333333333333%;
				}
				.col-md-8 {
				width: 66.66666666666666%;
				}
				.col-md-offset-5 {
				margin-left: 41.66666666666667%;
				}
			}
			@media (min-width: 1200px) {
				.container {
				max-width: 1115px;
				}
				.row {
				margin-left: -30px;
				}
			}
			*, *:before, *:after {
				-ms-box-sizing: border-box;
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-sizing: border-box;
			}
			.container {
				margin-right: auto;
				margin-left: auto;
				padding-left: 7.5px;
				padding-right: 7.5px;
			}
			hr {
				-moz-box-sizing: content-box;
				box-sizing: content-box;
				height: 0;
				padding: 0;
				margin: 15px 0 15px 0;
				margin-top: 20px;
				margin-bottom: 20px;
/* 				border: 0; */
				border-top: 1px solid #eee;
			}
			.post_content {
				background: url("http://www.pixeljoint.com/files/icons/full/mangawar.png") no-repeat left bottom;
				background-position: 19px 113px;
			}
			.post_content li {
				list-style: circle;
				margin-bottom: 5px;
				margin-left: 15px;
				list-style-position: inside;
			}
			#box {
				margin: 0 auto;
	/* 			background: url(/images/bg_body.gif) repeat; */
				clear: both;
			}
			#layout-content-wrapper {
				clear: both
			}
			#search-string {
				color: #e34848;
			}
			#helpbox_left_content h3,
			.common_fullbox h3,#result_box h3,
			.popular_box h3 {
				font-size: 14px;
				color: #e34848;
				text-transform: uppercase;
				padding: 0 0 12px 5px
			}
			#helpbox {
				width: 100%
			}
			#helpbox_left {
				background: #262626;
				float: left;
				margin: 0 31px 0 0
			}
			#helpbox_left .logo_box {
				width: 100%;
				text-align: left;
				padding: 0 0 15px 0;
				height: 284px;
				overflow: hidden;
				background-position: right;
				background-repeat: no-repeat
			}
			#helpbox_left .tab_area {
				width: 645px;
				height: 20px;
				padding: 0 0 0 15px;
				margin-top: -35px;
				position: absolute
			}
			#helpbox_left_content {
				background: #262626;
				width: 565px;
				padding: 15px;
				padding-top: 4px;
				overflow: hidden
			}
			#helpbox_left_content h3,.common_fullbox h3,
			#result_box h3 {
				color: #fff;
				padding: 0
			}
			#helpbox_left_content p,.common_fullbox p,
			#result_box p {
				font-size: 12px;
				color: #808080;
				line-height: 18px;
				padding: 0 0 15px 0;
				text-shadow: 0 1px 1px #555
			}
			#helpbox_left_content .link_area,
			.common_fullbox .link_area,
			#result_box .link_area,#helpbox_left2 .link_area {
				width: 600px;
				font-size: 12px;
				line-height: 18px;
				color: #8c8c8c;
				padding: 10px
			}
			.link_area span {
				padding: 8px 0 0 0;
				display: block
			}
			.link_area strong {
				color: #ddd;
				padding: 0 0 0 10px
			}
			.post-featured #helpbox_right {
				width: 350px;
				float: left
			}
			.post-featured .vertical-icons {
				width: 40px;
				float: right
			}
			.vertical-icons a {
				float: left;
				margin-bottom: 5px;
				height: 32px;
				width: 32px
			}
			#facebook_box {
				width: 300px;
				padding: 0 0 12px 0;
				height: 250px
			}
			#helpbox_right .mpu #gpt-mpu,#helpbox_right .skyscraper #gpt-skyscraper {
				border: 5px #191919 solid
			}
			.page-error #helpbox_left2 .post_content h1 {
				display: none
			}
			.page-error #err-human-poem {
				color: #000;
				font-size: 13px;
				line-height: 17px;
/* 				background: url(http://www.pixeljoint.com/files/icons/full/mangawar.png) no-repeat left top; */
				min-height: 600px;
				background-position: 19px -183px
			}
			.page-error #err-human-poem h3 {
				color: #e34848;
				margin: 0 0 16px;
				padding: 0;
			}
			.page-error #err-human-poem em {
				color: #585858
			}
			.page-error #err-human-poem em a {
				color: #585858;
				text-decoration: none;
				font-weight: normal
			}
			.page-error #err-human-poem em a:hover {
				text-decoration: underline
			}
			#err-human-poem .col-md-3 {
				margin: 26px 0 0 0;
			}
			.row:before, .row:after {
				content: " ";
				display: table;
			}
			.row {
				margin-left: -20px;
			}
			.row {
				margin-left: -7.5px;
				margin-right: -7.5px;
			}
			.col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .article-main .post_content .review .review_cover, .article-main .post_content .review .review_info {
				position: relative;
				min-height: 1px;
				padding-left: 7.5px;
				padding-right: 7.5px;
			}
		</style>	

		<div id="box" class="container">
			<div class="row">
			<div class="col-xs-12 col-md-12">
			<!-- Leaderboard -->
			<div id="div-gpt-ad-1376440575818-0" style="width:728px; height:90px;">
			<script type="text/javascript">
			googletag.cmd.push(function() { googletag.display('div-gpt-ad-1376440575818-0'); });
			</script>
			<div id="google_ads_iframe_/11347700/Leaderboard_0__container__" style="border: 0pt none;"><iframe id="google_ads_iframe_/11347700/Leaderboard_0" name="google_ads_iframe_/11347700/Leaderboard_0" width="728" height="90" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" src="javascript:&quot;<html><body style='background:transparent'></body></html>&quot;" style="border: 0px; vertical-align: bottom;"></iframe></div><iframe id="google_ads_iframe_/11347700/Leaderboard_0__hidden__" name="google_ads_iframe_/11347700/Leaderboard_0__hidden__" width="0" height="0" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" src="javascript:&quot;<html><body style='background:transparent'></body></html>&quot;" style="border: 0px; vertical-align: bottom; visibility: hidden; display: none;"></iframe></div>      </div>
			</div>
		<div id="layout-content-wrapper">
		<div class="page-error action-error page-static">
			<div id="helpbox">
				<div id="helpbox_left2" style="">
					<div class="post_content">
						<div class="row">
							<div class="col-md-8">
								<h3 class="vagrund color-indie">Sorry - but your page can't be found!</h3>
								<hr>
								<strong>Your Options:</strong>
								<ul>
									<?php
										$path=$_SERVER['REQUEST_URI'];
										$URI='http://earmilk.com'.$path;
										$path=ltrim($path, '/');
									?>
									<li><a href="/?s=<?php echo $path ?>">Search for missing page related to "<!--
										--><span id="search-string"><?php echo $path ?></span>"</a> <em>(recommended!)</em></li>
									<li>Check for typos</li>
									<li>Enjoy the poem</li>
								</ul>
							</div>
							<div class="col-md-4">
								<!-- MPU -->
							<div id="div-gpt-ad-1376440575818-1" style="width:300px; height:250px;">
							<script type="text/javascript">
							googletag.cmd.push(function() { googletag.display('div-gpt-ad-1376440575818-1'); });
							</script>
							<div id="google_ads_iframe_/11347700/MPU_0__container__" style="border: 0pt none;"><iframe id="google_ads_iframe_/11347700/MPU_0" name="google_ads_iframe_/11347700/MPU_0" width="300" height="250" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" src="javascript:&quot;<html><body style='background:transparent'></body></html>&quot;" style="border: 0px; vertical-align: bottom;"></iframe></div></div>	</div>
						</div>
						<p></p>
						<hr>

						<div id="err-human-poem" class="row">
							<div class="col-md-offset-5 col-md-4">
								<h3 class="vagrund">It is said, "To err is human,"</h3>
								That quote from alt.times.lore,<br>
								Alas, you have made an error,<br>
								So I say, “404.”<br><br>
								Double-check your URL,<br>
								As we all have heard before.<br>
								You ask for an invalid filename,<br>
								And I respond, “404.”<br><br>
								Perhaps you made a typo—<br>
								Your fingers may be sore—<br>
								But until you type it right,<br>
								You’ll only get 404.<br><br>
								Maybe you followed a bad link,<br>
								Surfing a foreign shore;<br>
								You’ll just have to tell that author<br>
								About this 404.<br><br>
								<em>pxart by <a href="http://hearteclipse.deviantart.com/gallery/" target="_blank">Genzo Himawari</a></em>
							</div>
							<div class="col-md-3">
								I’m just a lowly server<br>
								(Who likes to speak in metaphor),<br>
								So for a request that I don’t know,<br>
								I must return 404.<br><br>
								Be glad I’m not an old mainframe<br>
								That might just dump its core,<br>
								Because then you’d get a ten-meg file<br>
								Instead of this 404.<br><br>
								I really would like to help you,<br>
								But I don’t know what you’re looking for,<br>
								And since I don’t know what you want,<br>
								I give you 404.<br><br>
								Remember Poe, insane with longing<br>
								For his tragically lost Lenore.<br>
								Instead, you quest for files.<br>
								Quoth the Raven, "404!"
							</div>
						</div>      
					</div>
			    </div>
			</div>
		</div>
		</div>
		</div>

	</div><!-- .content-area -->
<?php get_footer(); ?>
