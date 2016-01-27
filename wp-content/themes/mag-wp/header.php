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
	<!-- Meta Tags -->
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<!-- <title><?php wp_title(''); ?></title> -->
	<!-- <me  ta name="description" content=""> -->
	<!-- <link rel="publisher" href="https://plus.google.com/+earmilk/"> -->
	<!-- <?php if ( is_singular() ) echo '<link rel="canonical" href="' . get_permalink() . '" />'; ?> -->
	<link rel="alternate" href="<?php echo site_url().'/'.get_page_uri(get_the_ID()); ?>" hreflang="x-default">
	<link rel="alternate" href="<?php echo site_url().'/'.get_page_uri(get_the_ID()); ?>" hreflang="en">
	<link rel="alternate" href="<?php echo site_url().'/'.get_page_uri(get_the_ID()); ?>" hreflang="en-us">
	<link rel="alternate" href="<?php echo site_url().'/'.get_page_uri(get_the_ID()); ?>" hreflang="en-gb">
    <script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "Organization",
        "url": "http://earmilk.com",
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "http://earmilk.com/about/"
        },
        "name" : "DankStop",
        "alternateName" : "EARMILK",
        "description": "EARMILK is an online music publication that straddles the line between underground and mainstream. Covering Hip-Hop, Electronic, Indie and the in between. All Milk. No Duds.",
        "brand" : "EARMILK",
        "logo": "http://earmilk.com/wp-content/uploads/2015/05/2.0-Logo-Transparent-Cropped.png",
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
	
    <!-- Title -->
    <?php if ( ! function_exists( '_wp_render_title_tag' ) ) { function theme_slug_render_title() { ?>
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <?php } add_action( 'wp_head', 'theme_slug_render_title' ); } // Backwards compatibility for older versions. ?>  

    <!-- Mobile Device Meta -->
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui' /> 
    
    <!-- The HTML5 Shim for older browsers (mostly older versions of IE). -->
	<!--[if IE]> <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script> <![endif]--><!--[if IE 9]><style type="text/css">.logo, header .sticky .logo  { margin-top: 0 !important; } </style><![endif]--> <!--[if IE 8]><style type="text/css">.logo, header .sticky .logo  { margin-top: 0 !important; } #searchform2  { margin-top: -5px !important;} #searchform2 .buttonicon { margin-top: 5px !important;} </style><![endif]--> 

	<!-- Favicons and rss / pingback -->
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php esc_url(bloginfo('rss2_url')); ?>" />
    <link rel="pingback" href="<?php esc_url(bloginfo('pingback_url')); ?>" />
    <link rel="shortcut icon" type="image/png" href="<?php echo esc_url($favicon); ?>"/>  

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

    <!-- Theme output -->
    <?php wp_head(); ?> 
<!-- <script type="text/javascript" src="/js/jquery.tipTip.minified.js"></script> -->
</head>
<body <?php if ($boxed_version_select == 'Yes') { ?>id="boxed-style"<?php } ?> <?php body_class(); ?>
	itemscope itemtype="http://schema.org/<?php 
	if (is_page(array(48, 'about', 'About'))) { 
		echo 'AboutPage'; 
	} elseif (is_page(array(52, 'contact', 'Contact'))) {
		echo 'ContactPage'; 
	} else {
		echo 'WebPage';
	} 
	?>">
<?php if (!empty($smof_data['background_img'])) { ?>    
    <img id="background" src="<?php echo esc_url($smof_data['background_img']); ?>" alt="background img" />
<?php } // background image ?>

<!-- Begin Header -->
<header role="banner" 
	itemprop="hasPart" itemscope itemtype="http://schema.org/WPHeader"> 
	<meta itemprop="name" content="EARMILK Site Header" />
	<meta itemprop="headline" content="EARMILK.com -- All milk. No duds." />
	<meta itemprop="description" content="This is the masthead for EARMILK.com" />
    <div class="top-navigation">
        <div class="wrap-center">
            <!-- popular words -->
            <div class="popular-words">
                <div id="top-menu">
                    <?php wp_nav_menu( array( 'container' => false, 'items_wrap' => '<ul>%3$s</ul>', 'theme_location' =>   'top-menu' ) ); ?>
                </div>
                <div id="tags2">
                </div>
                <?php /*if (!empty($smof_data['popular-tags-2'])) { ?>
                <div id="tags1">
                    <?php _e('<strong>Popular tags</strong>', 'anthemes'); ?>
                    <?php wp_tag_cloud('number=' .$smof_data['popular-tags-2']. '&orderby=count&order=DESC'); ?>
                </div>
                <?php }*/ ?>
                <?php /*if (!empty($smof_data['popular-tags-3'])) { ?><div id="tags2"><?php _e('<strong>Popular tags</strong>', 'anthemes'); ?> <?php wp_tag_cloud('number=' .$smof_data['popular-tags-3']. '&orderby=count&order=DESC'); ?></div><?php }  */ ?>
            </div>

            <!-- search form get_search_form(); -->
            <form id="searchform2" method="get" action="<?php echo esc_url( home_url( '/' )); ?>">
	            <div class="inputLabel">Live Search ...</div>
                <input type="text" name="s" id="s" /><input type="submit" value="Search" class="buttonicon" />
                <!-- placeholder="<?php _e('Live Search ...', 'anthemes'); ?>" -->
				<div class="inputUnderline"></div>
				<div class="animatedUnderline"></div>
            </form>

            <!-- Top social icons. -->
            <?php if (!empty($smof_data['top_icons'])) { ?>
                <?php echo stripslashes($smof_data['top_icons']); ?>
            <?php } ?>
            <div class="clear"></div>           
        </div>
    </div><div class="clear"></div>
        <div class="main-header">
            <div class="sticky-on">
            <?php if ($logo_align_select == 'Center') { ?>
                <!-- Navigation Menu Left -->
                <nav id="myjquerymenu" class="jquerycssmenu">
                    <?php  wp_nav_menu( array( 'container' => false, 'items_wrap' => '<ul>%3$s</ul>', 'theme_location' =>   'primary-menu' ) ); ?>
                </nav><!-- end #myjquerymenu -->
            <?php } ?>
                <!-- Navigation Menu Right -->
                <nav id="myjquerymenu2" class="jquerycssmenu-right">
                    <?php  wp_nav_menu( array( 'container' => false, 'items_wrap' => '<ul>%3$s</ul>', 'theme_location' =>   'secondary-menu' ) ); ?>
                </nav><!-- end #myjquerymenu -->

                <!-- logo middle -->
                <a class="" href="<?php echo esc_url(home_url( '/' )); ?>"><img id="earmilk-logo" <?php if ($logo_align_select == 'Left') { ?>style="float: left;"<?php } ?> class="logo" src="<?php echo ($site_logo); ?>" alt="<?php bloginfo('sitename'); ?>" /></a>

            </div><!-- end .sticky-on -->
            <div class="clear"></div>
        </div><!-- end .main-header --><div class="clear"></div>
</header><!-- end #header -->

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


    <?php if ( term_exists( 'current', 'post_tag' ) ) { ?>
    <!-- The next big Thing Section -->
    <div id="featured-boxes">
        <div class="wrap-center">
            <?php //echo get_template_part('custom/region/left-big-thing'); ?>

            <div class="big-thing-box hfeed h-feed">
                <div class="line-box">
                    <div class="header_line">
                     <h4 class="top"><span class="gray"><?php _e('Main Stage', 'anthemes'); ?></span></h4>
                    </div>
                </div><!-- end .line-box -->

                <ul class="big-thing" style="display:none;">
                  <?php  query_posts( array( 'post_type' => 'post', 'category_name' => 'mainstage', 'posts_per_page' => $smof_data['current-posts'] ) );  ?> 
                  <?php if (have_posts()) : while (have_posts()) : the_post(); ?> 

                  <li class="hentry h-entry"><?php if ( has_post_thumbnail()) { ?> 

                            <div class="post-date date updated">
                                <span class="month"><?php the_time('M', '', '', true); ?></span> 
                                <span class="day"><?php the_time('d', '', '', true); ?></span>
                            </div><!-- end .post-date -->
                    
                        <a href="<?php the_permalink(); ?>"> <?php echo the_post_thumbnail('thumbnail-widget'); ?> </a> 

                        <div class="article-category"><i></i> <?php $category = get_the_category(); if ($category) 
                          { echo '<a href="' . get_category_link( $category[0]->term_id ) . '" class="tiptipBlog" title="' . sprintf( __( "View all posts in %s", "anthemes" ), $category[0]->name ) . '" rel="tag" ' . '>' . $category[0]->name.'</a> ';}  ?>
                        </div><div class="arrow-down-cat"></div><!-- end .article-category -->  
                      <?php } ?> <div class="clear"></div>  

                      <div class="an-widget-title">
                        <h3 class="article-title entry-title">
	                        <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
	                    </h3>
                          <?php if(function_exists('taqyeem_get_score')) { ?>
                            <?php taqyeem_get_score(); ?>
                          <?php } ?>                    
			            <span><?php _e('written by', 'anthemes'); ?> 
			            	<span class="vcard author p-author h-card">
			            		<span class="fn"><?php the_author_posts_link(); ?></span>
			            	</span>
			            </span>
                      </div>
                  </li>

                <?php endwhile; endif; wp_reset_query();  ?> 
                </ul><!-- end .big-thing -->
            </div><!-- end .big-thing-box -->
        </div><!-- end .wrap-center -->
    </div><!-- end #featured-boxes -->
    <div class="clear"></div>
    <?php } ?>