<?php
	/*-----------------------------------------------------------------------------------*/
	/* Start Header
	/*-----------------------------------------------------------------------------------*/
	/**
	 *
	 * The template for displaying the header
	 *
	 * Displays all of the <head> section and everything up till 
	 *
	 * @package WordPress
	 * @subpackage Profile
	 * @since Earmilk ...
	 */
?>
<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>
<head>
<link rel='stylesheet' href='/css/app.css' type='text/css' media='screen' />
<script type="text/javascript">
    (function () {
        var s = document.createElement('script');
        s.type = 'text/javascript';
        s.async = true;
        s.src = ('https:' == document.location.protocol ? 'https://s' : 'http://i')
          + '.po.st/static/v4/post-widget.js#publisherKey=j7j8ojgvrr2ot0gfaopt';
        var x = document.getElementsByTagName('script')[0];
        x.parentNode.insertBefore(s, x);
     })();
</script>
<?php
    // Options from admin panel
    global $smof_data;
    
    $favicon = $smof_data['custom_favicon'];
    if (empty($favicon)) { $favicon = get_template_directory_uri().'/images/web-icon.png'; }
    
    $site_logo = $smof_data['site_logo'];
    if (empty($site_logo)) { $site_logo = get_template_directory_uri().'/images/logo.png'; }

    if (empty($smof_data['featured-posts'])) { $smof_data['featured-posts'] = '4'; }
    if (empty($smof_data['current-posts'])) { $smof_data['current-posts'] = '8'; }
    $boxed_version_select = (isset($smof_data['boxed_version_select'])) ? $smof_data['boxed_version_select'] : 'Yes';
    $logo_align_select = (isset($smof_data['logo_align_select'])) ? $smof_data['logo_align_select'] : 'Left';
?>
	
    <!-- Title -->
    <?php if ( ! function_exists( '_wp_render_title_tag' ) ) { function theme_slug_render_title() { ?>
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <?php } add_action( 'wp_head', 'theme_slug_render_title' ); } // Backwards compatibility for older versions. ?>  

	<!-- Meta Tags -->
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<!-- <title><?php wp_title(''); ?></title> -->
	<!-- <me  ta name="description" content=""> -->
	<!-- <link rel="publisher" href="https://plus.google.com/+earmilk/"> -->
	<!-- <?php if ( is_singular() ) echo '<link rel="canonical" href="' . get_permalink() . '" />'; ?> -->
	<link rel="alternate" href="<?php echo get_permalink(); ?>" hreflang="x-default">
	<link rel="alternate" href="<?php echo get_permalink(); ?>" hreflang="en">
	<link rel="alternate" href="<?php echo get_permalink(); ?>" hreflang="en-us">
	<link rel="alternate" href="<?php echo get_permalink(); ?>" hreflang="en-gb">
	<meta name="contact" content="businessv@earmilk.com" />
	<meta name="copyright" content="Copyright (c) 2009-2016 EARMILK Inc. All Rights Reserved." />
    <!-- Mobile Device Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" /> 
	<meta name="theme-color" content="#e34848" />	
    <script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "Organization",
        "url": "http://earmilk.com",
        "name" : "EARMILK",
        "alternateName" : "EARMILK.com",
        "description": "EARMILK is an online music publication that straddles the line between underground and mainstream. Covering Hip-Hop, Electronic, Indie and the in between. All Milk. No Duds.",
        "brand" : "EARMILK",
        "logo": "http://earmilk.com/wp-content/uploads/2016/02/EARMILK_logo_3.png",
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "http://earmilk.com/about/"
        },
        "sameAs": [
            "https://facebook.com/earmilk",
            "https://twitter.com/earmilk",
            "https://plus.google.com/+earmilk",
            "https://instagram.com/earmilkdotcom",
            "https://www.youtube.com/c/earmilk"
        ],
		"address": {
			"@type": "PostalAddress",
			"addressLocality": "San Francisco",
			"addressRegion": "CA",
			"postalCode": "94115",
			"streetAddress": "2443 Fillmore St #242"
		},
        "potentialAction": {
            "@type": "SearchAction",
            "target": "http://earmilk.com/?s={search_query}",
            "query-input": "required name=search_query"
        }
    }
    </script>
	<!-- Custom Favicons -->
	<link rel="apple-touch-icon" sizes="57x57" href="/favicons/apple-touch-icon-57x57.png?v=KmmqjE3jwP">
	<link rel="apple-touch-icon" sizes="60x60" href="/favicons/apple-touch-icon-60x60.png?v=KmmqjE3jwP">
	<link rel="apple-touch-icon" sizes="72x72" href="/favicons/apple-touch-icon-72x72.png?v=KmmqjE3jwP">
	<link rel="apple-touch-icon" sizes="76x76" href="/favicons/apple-touch-icon-76x76.png?v=KmmqjE3jwP">
	<link rel="apple-touch-icon" sizes="114x114" href="/favicons/apple-touch-icon-114x114.png?v=KmmqjE3jwP">
	<link rel="apple-touch-icon" sizes="120x120" href="/favicons/apple-touch-icon-120x120.png?v=KmmqjE3jwP">
	<link rel="apple-touch-icon" sizes="144x144" href="/favicons/apple-touch-icon-144x144.png?v=KmmqjE3jwP">
	<link rel="apple-touch-icon" sizes="152x152" href="/favicons/apple-touch-icon-152x152.png?v=KmmqjE3jwP">
	<link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon-180x180.png?v=KmmqjE3jwP">
	<link rel="icon" type="image/png" href="/favicons/favicon-32x32.png?v=KmmqjE3jwP" sizes="32x32">
	<link rel="icon" type="image/png" href="/favicons/favicon-194x194.png?v=KmmqjE3jwP" sizes="194x194">
	<link rel="icon" type="image/png" href="/favicons/favicon-96x96.png?v=KmmqjE3jwP" sizes="96x96">
	<link rel="icon" type="image/png" href="/favicons/android-chrome-192x192.png?v=KmmqjE3jwP" sizes="192x192">
	<link rel="icon" type="image/png" href="/favicons/favicon-16x16.png?v=KmmqjE3jwP" sizes="16x16">
	<link rel="manifest" href="/favicons/manifest.json?v=KmmqjE3jwP">
	<link rel="mask-icon" href="/favicons/safari-pinned-tab.svg?v=KmmqjE3jwP" color="#5bbad5">
	<link rel="shortcut icon" href="/favicons/favicon.ico?v=KmmqjE3jwP">
	<meta name="apple-mobile-web-app-title" content="EARMILK">
	<meta name="application-name" content="EARMILK">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-TileImage" content="/favicons/mstile-144x144.png?v=KmmqjE3jwP">
	<meta name="msapplication-config" content="/favicons/browserconfig.xml?v=KmmqjE3jwP">
	<meta name="theme-color" content="#e34848">
    
    <!-- The HTML5 Shim for older browsers (mostly older versions of IE). -->
	<!--[if IE]> <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script> <![endif]--><!--[if IE 9]><style type="text/css">.logo, header .sticky .logo  { margin-top: 0 !important; } </style><![endif]--> <!--[if IE 8]><style type="text/css">.logo, header .sticky .logo  { margin-top: 0 !important; } #searchform2  { margin-top: -5px !important;} #searchform2 .buttonicon { margin-top: 5px !important;} </style><![endif]--> 

	<!-- Favicons and rss / pingback -->
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php esc_url(bloginfo('rss2_url')); ?>" />
    <link rel="pingback" href="<?php esc_url(bloginfo('pingback_url')); ?>" />
<!--     <link rel="shortcut icon" type="image/png" href="<?php echo esc_url($favicon); ?>"/>   -->

    <!-- Custom style -->
    <?php echo get_template_part('custom-style'); ?>

	<!-- Google Analytics -->
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-1088092-11', 'auto');
	  ga('send', 'pageview');
	
	</script>

<!-- 	Google DFP -->
	<script type='text/javascript'>
	  (function() {
	    var useSSL = 'https:' == document.location.protocol;
	    var src = (useSSL ? 'https:' : 'http:') +
	        '//www.googletagservices.com/tag/js/gpt.js';
	    document.write('<scr' + 'ipt src="' + src + '"></scr' + 'ipt>');
	  })();
	</script>
	
	<script type='text/javascript'>
	  googletag.cmd.push(function() {
		googletag.defineSlot('/11347700/EM_ATF_ATB_900x90', [[728, 90], [970, 90]], 'div-gpt-ad-1455694346925-0').addService(googletag.pubads());
		googletag.defineSlot('/11347700/Leaderboard', [[970, 90], [970, 250], [728, 90]], 'div-gpt-ad-1455698643418-1').addService(googletag.pubads());
		googletag.defineSlot('/11347700/Hybrid_MPU', [[300, 250], [300, 600]], 'div-gpt-ad-1455698643418-2').addService(googletag.pubads());
		googletag.defineSlot('/11347700/Wallpaper', [1, 1], 'div-gpt-ad-1455698643418-3').addService(googletag.pubads());
/*
	    googletag.defineSlot('/11347700/Leaderboard', [[970, 250], [728, 90], [970, 90]], 'div-gpt-ad-1454727873765-0').setTargeting('Redirect', ['false']).addService(googletag.pubads());
	    googletag.defineSlot('/11347700/Leaderboard2', [[970, 250], [728, 90], [970, 90]], 'div-gpt-ad-1454727873765-1').addService(googletag.pubads());
	    googletag.defineSlot('/11347700/Hybrid_MPU', [[300, 250], [300, 600]], 'div-gpt-ad-1454727873765-2').addService(googletag.pubads());
	    googletag.defineSlot('/11347700/MPU', [300, 250], 'div-gpt-ad-1454727873765-3').addService(googletag.pubads());
	    googletag.defineSlot('/11347700/Wallpaper', [1, 1], 'div-gpt-ad-1454727873765-4').addService(googletag.pubads());
*/
	    googletag.pubads().enableSingleRequest();
	    googletag.pubads().collapseEmptyDivs();
	    googletag.pubads().setTargeting('Redirect', ['false']);
	    googletag.pubads().enableSyncRendering();
	    googletag.enableServices();
	  });
	</script>

    <!-- Theme output -->
    <?php wp_head(); ?> 
<!-- <script type="text/javascript" src="/js/jquery.tipTip.minified.js"></script> -->
</head>
<body <?php if ($boxed_version_select == 'Yes') { ?>id="boxed-style"<?php } ?> <?php body_class(); ?>
	itemscope itemtype="http://schema.org/<?php 
	if (is_page(array(248463, 'about', 'About'))) { 
		echo 'AboutPage'; 
	} elseif ( (is_archive()) || (is_author()) || ( is_page_template('archive-album_review.php') ) ) {
		echo 'CollectionPage';
	} elseif (is_page(array(248509, 'contact-us', 'Contact Us'))) {
		echo 'ContactPage'; 
	} else {
		echo 'WebPage';
	} 
	?>">
<?php if (!empty($smof_data['background_img'])) { ?>    
    <img id="background" src="<?php echo esc_url($smof_data['background_img']); ?>" alt="background img" />
<?php } // background image ?>

<!-- Begin Header -->
<div id="fixed-header">

	<?php 
		$genre_bar_args = array(
			'menu'=>'genre-bar',
			'container'=>'nav',
			'container_class'=>'genrebar',
			'items_wrap' => '<ul class="mainmenu">%3$s</ul>'
		);
		wp_nav_menu( $genre_bar_args ); ?>

	<div id="inner-header">
		<div id="logo-cont">
			<header id="logo-header" role="banner" 
				itemprop="hasPart" itemscope itemtype="http://schema.org/WPHeader"> 
				<meta itemprop="name" content="EARMILK Site Header" />
				<meta itemprop="headline" content="EARMILK.com -- All milk. No duds." />
				<meta itemprop="description" content="This is the masthead for EARMILK.com" />
				<a id="earmilk-logo" href="<?php echo esc_url(home_url( '/' )); ?>">
					<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
						<meta itemprop="name" content="EARMILK">
						<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
							<img id="earmilk-logo-img" src="<?php echo ($site_logo); ?>" alt="<?php bloginfo('sitename'); ?>" />
							<meta itemprop="url" content="http://earmilk.com/wp-content/uploads/2016/02/EARMILK_logo_3.png">
							<meta itemprop="width" content="229">
							<meta itemprop="height" content="50">
						</div>
					</div>
				</a>
			</header>
		</div>

		<div id="search-cont">
			<form id="searchform" method="get" action="<?php echo esc_url( home_url( '/' )); ?>">
			    <div class="inputLabel">Search for...</div>
			    <input type="text" name="s" id="s" />
			    <button type="submit" value="Search" class="buttonicon"><i class="fa fa-search"></i></button>
				<div class="inputUnderline"></div>
				<div class="animatedUnderline"></div>
			</form>
		</div>

		<div id="nav-cont">
		    <nav id="myjquerymenu" class="jquerycssmenu" 
				role="navigation" itemprop="hasPart" itemscope itemtype="http://schema.org/SiteNavigationElement">
		        <?php  wp_nav_menu( array( 'container' => false, 'items_wrap' => '<ul>%3$s</ul>', 'theme_location' =>   'primary-menu' ) ); ?>
		    </nav>
		</div>

	</div>
</div>
<div id="header-filler"></div>



<div id="ta-search-container">
	<div id="ta-search">
		<span id="esc-to-exit">Press <kbd id="escape-key">Esc</kbd> key to exit.</span>
		<form id="ta-searchform" method="get" action="http://earmilk.com/">
			<label id="ta-label" for="ta-searchtext">search: </label>
			<input id="ta-searchtext" name="s" type="text" />
		</form>
	</div>
</div>




<div id="ajax-content">




<!-- /11347700/Wallpaper -->
<!--
<div id='div-gpt-ad-1454727873765-4' style='height:1px; width:1px;'>
	<script type='text/javascript'>
		googletag.cmd.push(function() { googletag.display('div-gpt-ad-1454727873765-4'); });
	</script>
</div>
-->



<?php if ( term_exists( 'featured', 'post_tag' ) ) { ?>
    <?php if ( is_page_template( 'template-home.php' ) || is_page_template( 'template-home-2.php' ) ) { ?>
    <?php if ( function_exists( 'rwmb_meta' ) ) {  
    // If Meta Box plugin is activate ?>
    <!-- Featured Slider Section -->
    <div id="featured-slider" style="display:none;">
      <?php  query_posts( array( 'post_type' => 'post', 'tag' => 'featured', 'posts_per_page' => $smof_data['featured-posts'] ) );  ?> 
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?> 

		<?php 
            $fullslider = rwmb_meta('anthemes_fullslider', true );
            $slider_title = rwmb_meta('anthemes_slider_title', true );
        ?> 

        <div class="item">
            <?php
            $images = rwmb_meta( 'anthemes_fullslider', 'type=image&size=thumbnail-featured-slider' );
            foreach($images as $key =>$fullslider) { ?>
            <img src="<?php echo $fullslider['url']; ?>" width="<?php echo $fullslider['width']; ?>" height="<?php echo $fullslider['height']; ?>" alt="<?php echo $fullslider['alt']; ?>" />
            <?php } ?>
            <div class="content">
              <?php if(!empty($slider_title) ) { ?> 
                <h2><a href="<?php the_permalink(); ?>"><?php echo stripslashes_deep($slider_title); ?></a></h2>
                <?php } else { ?>
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
              <?php } ?>
              <a href="<?php the_permalink(); ?>" class="btn-featured"> <?php _e('Read more', 'anthemes'); ?> <i class="fa fa-chevron-right"></i></a>
            </div><!-- end .conten -->
        </div><!-- end .item -->

      <?php endwhile; endif; wp_reset_query();  ?>    
    </div><!-- end #featured-slider -->
    <?php if ($boxed_version_select == 'Yes') { ?><div class="clear2" style="margin-bottom: 620px;"></div><?php } ?>
    <?php } // Meta Box Plugin 
    } // Template Home ?>
<?php } ?>



<?php if ( is_home() ) { ?>
    <?php if ( term_exists( 'current', 'post_tag' ) ) { ?>
    <!-- The next big Thing Section -->
    <div id="featured-boxes">

		<!-- /11347700/Leaderboard -->
<!--
		<div id='div-gpt-ad-1454727873765-0'>
			<script type='text/javascript'>
				googletag.cmd.push(function() { googletag.display('div-gpt-ad-1454727873765-0'); });
			</script>
		</div>
-->
		<div id="atf-970x90-ad-slot" class="ad-slot">
			<!-- /11347700/EM_ATF_ATB_900x90 -->
			<div id="div-gpt-ad-1455694346925-0">
				<script type="text/javascript">
					googletag.cmd.push(function() { googletag.display('div-gpt-ad-1455694346925-0'); });
				</script>
			</div>
		</div>

		<div class="wrap-center">
			<?php //echo get_template_part('custom/region/left-big-thing'); ?>

			<div id="main-stage-split">

				<div class="main-stage-left">

					<div class="main-stage-latest latest-news hfeed h-feed">
						<div class="line-box">
							<div class="header_line">
								<h2 class="top"><a href="/news/" title="VOICES">SCOOPS</a></h2>
							</div>
						</div>
						<ul>
							<?php  
								$args = array(
							    'post_type' => array( 'news' ),
							    'numberposts' => 3,
							    'posts_per_page' => 3,
							    'offset' => 0,
							    'category' => 0,
							    'orderby' => 'post_date',
							    'order' => 'DESC');
								query_posts( $args );  
								$category = get_the_category(); 
								if ($category) { $cat_name = 'genre-' . preg_replace('/\s+/', '', strtolower($category[0]->name)); };
							?> 
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?> 
								<li class="hentry h-entry <?php echo $cat_name; ?>">
									<div class="entry-thumbnail"> 
										<a href="<?php the_permalink(); ?>"> 
											<?php echo the_post_thumbnail('medium'); ?>
										</a>
									</div>
									<div class="entry-title">
										<h3>
											<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
										</h3>
									</div>
						            <div class="entry-author-meta">
							            <span class="time date updated"><?php echo time_ago_anthemes(); ?> <?php _e('ago', 'anthemes'); ?></span>
							            <span class="author-meta-byline"><?php _e('by', 'anthemes'); ?>
							            	<span class="vcard author p-author h-card">
							            		<span class="fn"><?php the_author_posts_link(); ?></span>
							            	</span>
							            </span>
						            </div>
								</li>
							<?php endwhile; endif; wp_reset_query();  ?> 
						</ul>
					</div>
					<div class="main-stage-latest latest-voices hfeed h-feed">
						<div class="line-box">
							<div class="header_line">
								<h2 class="top"><a href="/voices/" title="VOICES">VOICES</a></h2>
							</div>
						</div>
						<ul>
							<?php  
								$args = array(
							    'post_type' => array( 'opinion_post' ),
							    'numberposts' => 3,
							    'posts_per_page' => 3,
							    'offset' => 0,
							    'category' => 0,
							    'orderby' => 'post_date',
							    'order' => 'DESC');
								query_posts( $args );  
								$category = get_the_category(); 
								if ($category) { $cat_name = 'genre-' . preg_replace('/\s+/', '', strtolower($category[0]->name)); };
							?> 
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
								<li class="hentry h-entry <?php echo $cat_name ?>">
									<div class="entry-thumbnail"> 
										<a href="<?php the_permalink(); ?>"> 
											<?php echo the_post_thumbnail('medium'); ?>
										</a>
									</div>
									<div class="entry-title">
										<h3>
											<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
										</h3>
							            <div class="entry-author-meta">
								            <span class="time date updated"><?php echo time_ago_anthemes(); ?> <?php _e('ago', 'anthemes'); ?></span>
								            <span class="author-meta-byline"><?php _e('by', 'anthemes'); ?>
								            	<span class="vcard author p-author h-card">
								            		<span class="fn"><?php the_author_posts_link(); ?></span>
								            	</span>
								            </span>
							            </div>
									</div>
								</li>
							<?php endwhile; endif; wp_reset_query();  ?> 
						</ul>
					</div>
				</div><!-- end .main-stage-left -->

	            <div class="big-thing-box hfeed h-feed">
					<img id="main-stage-loader" src="http://earmilk.com/wp-content/uploads/equalizer_bw.gif" alt="EARMILK Main Stage loading music equalizer">
					<div class="line-box">
						<div class="header_line">
							<h1 class="top"><a href="/category/mainstage/" title="Main Stage"><?php _e('Main Stage', 'anthemes'); ?></a></h1>
						</div>
					</div>
		
	                <ul class="big-thing" style="display:none;">
						<?php  
							$slider_args = array( 
								'post_type' => array( 'post', 'opinion_post', 'news'), 
								'category_name' => 'mainstage', 
								'posts_per_page' => $smof_data['current-posts'] 
								);
							query_posts( $slider_args );  ?> 
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?> 
						
						<li class="hentry h-entry"><?php if ( has_post_thumbnail()) { ?> 
							<div class="entry-thumb-cont">
					            <a href="<?php the_permalink(); ?>" class="entry-thumbnail"> 
									<span class="vertical-height-helper"></span>
						            <?php echo the_post_thumbnail('large'); ?>
					            </a> 
								<div class="article-category">
									<div class="post-date date updated">
										<?php if ( get_the_time('Y') == date('Y')) { ?> 
											<meta itemprop="datePublished" content="<?php the_time('c'); ?>"/>
											<meta itemprop="dateModified" content="<?php the_time('c'); ?>"/>
											<a href="<?php echo '/' . get_the_time('Y') . '/' . get_the_time('m') . '/'  ?>" 
												title="<?php echo get_the_time('F') . ' ' . get_the_time('Y') . ' Archives'  ?>">
												<span class="month"><?php the_time('M', '', '', true); ?></span> 
												<span class="day"><?php the_time('d', '', '', true); ?></span>
											</a>
										<?php } else { ?> 
											<meta itemprop="datePublished" content="<?php the_time('c'); ?>"/>
											<meta itemprop="dateModified" content="<?php the_time('c'); ?>"/>
											<a href="<?php echo '/' . get_the_time('Y') . '/' . get_the_time('m') . '/'  ?>" 
												title="<?php echo get_the_time('F') . ' ' . get_the_time('Y') . ' Archives'  ?>">
												<span class="month"><?php the_time('M', '', '', true); ?></span> 
												<span class="day"><?php the_time('d', '', '', true); ?></span>
												<span class="year">'<?php the_time('y', '', '', true); ?></span>
											</a>
										<?php } ?>
									</div>
									<span class="vcard author p-author h-card">
										<span class="fn">
											<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" 
												title="View all posts by <?php the_author_meta('first_name'); ?>">
												<span class="entry-author-first given-name"><?php the_author_meta('first_name'); ?></span>
												<span class="entry-author-last family-name"><?php the_author_meta('last_name'); ?></span>
											</a>
										</span>
									</span>
									<?php 
										$category = get_the_category(); 
										if ($category) { $cat_name = 'genre-' . preg_replace('/\s+/', '', strtolower($category[0]->name)); };
							            echo '<a href="' . get_category_link( $category[0]->term_id ) . '" class="tiptipBlog ' . $cat_name . '" title="' . sprintf( __( "View all posts in %s", "anthemes" ), $category[0]->name ) . '" rel="tag" ' . '>' . $category[0]->name.'</a> ';
									?>
								</div>
							</div>
							<div class="an-widget-title">
								<h3 class="article-title entry-title">
									<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
								</h3>
							</div>
							<?php } ?> <div class="clear"></div>  
						</li>
	
	                <?php endwhile; endif; wp_reset_query();  ?> 
	                </ul><!-- end .big-thing -->
				</div><!-- end .big-thing-box -->
			</div><!-- end main-stage-split -->
        </div><!-- end .wrap-center -->
    </div><!-- end #featured-boxes -->
    <div class="clear"></div>
	<?php } ?>
<?php } ?>
