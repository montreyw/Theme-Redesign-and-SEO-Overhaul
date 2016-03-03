<?php
// ------------------------------------------------ 
// ---------- Options Framework Theme -------------
// ------------------------------------------------
 require_once ('admin/index.php');

// ----------------------------------------------
// --------------- Load Scripts -----------------
// ----------------------------------------------
 include("functions/scripts.php");

// ---------------------------------------------- 
// --------------- Load Custom Widgets ----------
// ----------------------------------------------
 include("functions/widgets.php");
 include("functions/widgets/widget-tags.php");
 include("functions/widgets/widget-posts.php");
 include("functions/widgets/widget-top-posts.php");
 include("functions/widgets/widget-cat.php");
 include("functions/widgets/widget-feedburner.php");
 include("functions/widgets/widget-review.php");
 include("functions/widgets/widget-review-rand.php");
 include("functions/widgets/widget-review-recent.php");
 include("functions/widgets/widget-categories.php");
 include("functions/widgets/widget-banner.php");

 
// ----------------------------------------------
// --------------- Load Custom ------------------
// ---------------------------------------------- 
   include("functions/custom/comments.php");
  

// ----------------------------------------------
// ------ Content width -------------------------
// ----------------------------------------------
if ( ! isset( $content_width ) ) $content_width = 950;


// ----------------------------------------------
// ------ Post thumbnails ----------------------- 
// ----------------------------------------------
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
    add_image_size( 'thumbnail-blog', 283, 133, true ); // Blog thumbnails
    add_image_size( 'thumbnail-masonry', 283, '', true ); // Blog thumbnails
    add_image_size( 'thumbnail-featured-slider', 800, 550, true ); // Blog thumbnails home featured posts
    add_image_size( 'thumbnail-widget', 250, 130, true ); // Sidebar Widget thumbnails
    add_image_size( 'thumbnail-widget-small', 55, 55, true ); // Sidebar Widget thumbnails small
    add_image_size( 'thumbnail-small-gallery', 180, 180, true ); // Blog thumbnails home small
	add_image_size( 'thumbnail-single-image', 950, '', true ); // Single thumbnails
}


// ----------------------------------------------
// ------ title tag ----------------------------
// ----------------------------------------------
 add_theme_support( 'title-tag' );


// ----------------------------------------------
// ------ feed links ----------------------------
// ----------------------------------------------
 add_theme_support( 'automatic-feed-links' );
 

// ----------------------------------------------
// ---- Makes Theme available for translation ---
// ----------------------------------------------
load_theme_textdomain( 'anthemes', get_template_directory() . '/languages' );

// ----------------------------------------------
// -------------- Register Menu -----------------
// ----------------------------------------------

add_theme_support( 'nav-menus' );
add_action( 'init', 'register_my_menus_anthemes' );

function register_my_menus_anthemes() {
    register_nav_menus(
        array(
            'primary-menu' => 'Header Navigation Left',
            'secondary-menu' => 'Header Navigation right',
        )
    );
}


// ------------------------------------------------ 
// ---- Add  rel attributes to embedded images ----
// ------------------------------------------------ 
function insert_rel_anthemes($content) {
    $pattern = '/<a(.*?)href="(.*?).(bmp|gif|jpeg|jpg|png)"(.*?)>/i';
    $replacement = '<a$1href="$2.$3" class=\'wp-img-bg-off\' rel=\'mygallery\'$4>';
    $content = preg_replace( $pattern, $replacement, $content );
    return $content;
}
add_filter( 'the_content', 'insert_rel_anthemes' );

// ---- Add  rel attributes to gallery images ----
add_filter('wp_get_attachment_link', 'add_gallery_id_rel_anthemes');
function add_gallery_id_rel_anthemes($link) {
    global $post;
    return str_replace('<a href', '<a rel="mygallery" class="wp-img-bg-off" href', $link);
}


// ------------------------------------------------ 
// ------------ Nr of Topics for Tags -------------
// ------------------------------------------------  
add_filter ( 'wp_tag_cloud', 'tag_cloud_count_anthemes' );
function tag_cloud_count_anthemes( $return ) {
return preg_replace('#(<a[^>]+\')(\d+)( topics?\'[^>]*>)([^<]*)<#imsU','$1$2$3$4 <span>($2)</span><',$return);
}


// ------------------------------------------------ 
// --- Pagination class/style for entry articles --
// ------------------------------------------------ 
function custom_nextpage_links_anthemes($defaults) {
$args = array(
'before' => '<div class="my-paginated-posts"><p>' . '<span>',
'after' => '</span></p></div>',
);
$r = wp_parse_args($args, $defaults);
return $r;
}
add_filter('wp_link_pages_args','custom_nextpage_links_anthemes');



// ------------------------------------------------ 
// --------------- Posts Time Ago -----------------
// ------------------------------------------------  

function time_ago_anthemes( $type = 'post' ) {
    $d = 'comment' == $type ? 'get_comment_time' : 'get_post_time';
    return human_time_diff($d('U'), current_time('timestamp')) . " ";
}


// ------------------------------------------------ 
// --------------- Author Social Links ------------
// ------------------------------------------------ 
function anthemes_contactmethods( $contactmethods ) {
    $contactmethods['twitter']   = 'Twitter Username';
    $contactmethods['facebook']  = 'Facebook Username';
    $contactmethods['google']    = 'Google+ Username';
    return $contactmethods;
}
add_filter('user_contactmethods','anthemes_contactmethods',10,1);


// ----------------------------------------------
// ---------- excerpt length adjust -------------
// ----------------------------------------------

function anthemes_excerpt($str, $length, $minword = 3)
{
    $sub = '';
    $len = 0;
    
    foreach (explode(' ', $str) as $word)
    {
        $part = (($sub != '') ? ' ' : '') . $word;
        $sub .= $part;
        $len += strlen($part);
        
        if (strlen($word) > $minword && strlen($sub) >= $length)
        {
            break;
        }
    }
    
    return $sub . (($len < strlen($str)) ? ' ..' : '');
}



// ------------------------------------------------ 
// ------------ Meta Box --------------------------
// ------------------------------------------------
$prefix = 'anthemes_';
global $meta_boxes;
$meta_boxes = array();

// 1st meta box
$meta_boxes[] = array(
    'id' => 'standard',
    'title' => __( 'Article Page Options', 'rwmb' ),
    'context' => 'normal',
    'priority' => 'high',
    'autosave' => true,

    // Youtube
    'fields' => array(
        // TEXT
        array(
            // Field name - Will be used as label
            'name'  => __( 'Video Youtube', 'rwmb' ),
            // Field ID, i.e. the meta key
            'id'    => "{$prefix}youtube",
            // Field description (optional)
            'desc'  => __( 'Add Youtube code ex: HIrMIeN5ttE', 'rwmb' ),
            'type'  => 'text',
            // Default value (optional)
            'std'   => __( '', 'rwmb' ),
            // CLONES: Add to make the field cloneable (i.e. have multiple value)
            'clone' => false,
        ),


    // Vimeo
        // TEXT
        array(
            // Field name - Will be used as label
            'name'  => __( 'Video Vimeo', 'rwmb' ),
            // Field ID, i.e. the meta key
            'id'    => "{$prefix}vimeo",
            // Field description (optional)
            'desc'  => __( 'Add Vimeo code ex: 7449107', 'rwmb' ),
            'type'  => 'text',
            // Default value (optional)
            'std'   => __( '', 'rwmb' ),
            // CLONES: Add to make the field cloneable (i.e. have multiple value)
            'clone' => false,
        ),

    // Gallery
        // IMAGE UPLOAD
        array(
            'name' => __( 'Gallery', 'rwmb' ),
            'id'   => "{$prefix}slider",
            // Field description (optional)
            'desc'  => __( 'Image with any size!', 'rwmb' ),            
            'type' => 'image_advanced',
        ),

    // Hide Featured Image
        // CheckBox
        array(
            'name' => __( 'Featured Image', 'rwmb' ),
            'id'   => "{$prefix}hideimg",
            'desc'  => __( 'Hide Featured Image on single page for this article', 'rwmb' ),
            'type' => 'checkbox',
        ),


    ),

);




// 2nd meta box
$meta_boxes[] = array(
    'title' => __( 'Featured Article - Slider', 'rwmb' ),
    // List of meta fields
    'fields' => array(
        // IMAGE UPLOAD
        array(
            'name' => __( 'Slider Image', 'rwmb' ),
            'id'   => "{$prefix}fullslider",
            // Field description (optional)
            'desc'  => __( 'Image recomendable size: 800x550. You can upload a bigger image, and the theme will crop the image to have the recomendable size.', 'rwmb' ),              
            'type' => 'image_advanced',
        ),

        array(
            // Field name - Will be used as label
            'name'  => __( 'Slider Title ', 'rwmb' ),
            // Field ID, i.e. the meta key
            'id'    => "{$prefix}slider_title",
            // Field description (optional)
            'desc'  => __( 'Optional, if the box is left in blank, the post title will be used. ', 'rwmb' ),
            'type'  => 'textarea',
            // Default value (optional)
            'std'   => __( '', 'rwmb' ),
            // CLONES: Add to make the field cloneable (i.e. have multiple value)
            'clone' => false,
        ),       
    ),
);




/**
 * Register meta boxes
 *
 * @return void
 */
function anthemes_register_meta_boxes()
{
    // Make sure there's no errors when the plugin is deactivated or during upgrade
    if ( !class_exists( 'RW_Meta_Box' ) )
        return;

    global $meta_boxes;
    foreach ( $meta_boxes as $meta_box )
    {
        new RW_Meta_Box( $meta_box );
    }
}
// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', 'anthemes_register_meta_boxes' );


// ------------------------------------------------ 
// ---------- TGM_Plugin_Activation -------------
// ------------------------------------------------ 
require_once dirname( __FILE__ ) . '/functions/custom/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );

function my_theme_register_required_plugins() {

    $plugins = array(
        array(
            'name'                  => 'Meta Box', // The plugin name
            'slug'                  => 'meta-box', // The plugin slug (typically the folder name)
            'source'                => get_stylesheet_directory() . '/plugins/meta-box.zip', // The plugin source
            'required'              => true, // If false, the plugin is only 'recommended' instead of required
            'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'          => '', // If set, overrides default API URL and points to an external URL
        ),

        array(
            'name'                  => 'Shortcodes', // The plugin name
            'slug'                  => 'anthemes-shortcodes', // The plugin slug (typically the folder name)
            'source'                => get_stylesheet_directory() . '/plugins/anthemes-shortcodes.zip', // The plugin source
            'required'              => false, // If false, the plugin is only 'recommended' instead of required
            'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'          => '', // If set, overrides default API URL and points to an external URL
        ),

        array(
            'name'                  => 'Reviews', // The plugin name
            'slug'                  => 'anthemes-reviews', // The plugin slug (typically the folder name)
            'source'                => get_stylesheet_directory() . '/plugins/anthemes-reviews.zip', // The plugin source
            'required'              => false, // If false, the plugin is only 'recommended' instead of required
            'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'          => '', // If set, overrides default API URL and points to an external URL
        ),

        array(
            'name'                  => 'Custom Sidebars',
            'slug'                  => 'custom-sidebars',
            'required'              => false,
            'version'               => '',
        ),

        array(
            'name'                  => 'Daves WordPress Live Search',
            'slug'                  => 'daves-wordpress-live-search',
            'required'              => false,
            'version'               => '',
        ),

        array(
            'name'                  => 'Multi-column Tag Map',
            'slug'                  => 'multi-column-tag-map',
            'required'              => false,
            'version'               => '',
        ),

        array(
            'name'                  => 'Responsive Menu',
            'slug'                  => 'responsive-menu',
            'required'              => false,
            'version'               => '',
        ),

        array(
            'name'                  => 'Social Count Plus',
            'slug'                  => 'social-count-plus',
            'required'              => false,
            'version'               => '',
        ),


        array(
            'name'                  => 'WP-PageNavi',
            'slug'                  => 'wp-pagenavi',
            'required'              => false,
            'version'               => '',
        ),

    );

    // Change this to your theme text domain, used for internationalising strings
    $theme_text_domain = 'tgmpa';
    $config = array(
        'domain'            => $theme_text_domain,          // Text domain - likely want to be the same as your theme.
        'default_path'      => '',                          // Default absolute path to pre-packaged plugins
        'parent_menu_slug'  => 'themes.php',                // Default parent menu slug
        'parent_url_slug'   => 'themes.php',                // Default parent URL slug
        'menu'              => 'install-required-plugins',  // Menu slug
        'has_notices'       => true,                        // Show admin notices or not
        'is_automatic'      => false,                       // Automatically activate plugins after installation or not
        'message'           => '',                          // Message to output right before the plugins table
        'strings'           => array(
            'page_title'                                => esc_html__( 'Install Required Plugins', 'anthemes' ),
            'menu_title'                                => esc_html__( 'Install Plugins', 'anthemes' ),
            'installing'                                => esc_html__( 'Installing Plugin: %s', 'anthemes' ), // %1$s = plugin name
            'oops'                                      => esc_html__( 'Something went wrong with the plugin API.', 'anthemes' ),
            'return'                                    => esc_html__( 'Return to Required Plugins Installer', 'anthemes' ),
            'plugin_activated'                          => esc_html__( 'Plugin activated successfully.', 'anthemes' ),
            'complete'                                  => esc_html__( 'All plugins installed and activated successfully. %s', 'anthemes' ), // %1$s = dashboard link
            'nag_type'                                  => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
        )
    );

    tgmpa( $plugins, $config );

}

// ------------------------------------------------------------------------------ 
// Disable Yoast schema meta -- Andre custom, to turn off Yoast meta/schema.org 
// ------------------------------------------------------------------------------ 
function amt_schemaorg_skip_front_page( $default ) {
    if ( is_front_page() || is_home() ) {
        return array();
    }
    return $default;
}
add_filter( 'disable_wpseo_json_ld_output', '__return_true' );
add_filter( 'wpseo_json_ld_output', '__return_false' );

// ------------------------------------------------------------------------------ 
// Suppress Yoast's Spammy notices and wrnings - Andre
// ------------------------------------------------------------------------------ 
function disable_yoast_notifications() {
	if ( class_exists( 'Yoast' ) ) {
		remove_action( 'admin_notices', array( Yoast_Notification_Center::get(), 'display_notifications' ) );
		remove_action( 'all_admin_notices', array( Yoast_Notification_Center::get(), 'display_notifications' ) );
	}
}
add_action( 'plugins_loaded', 'disable_yoast_notifications' );

// ------------------------------------------------------------------------------ 
// Register and initialize Custom Admin CSS file - Andre
// ------------------------------------------------------------------------------ 
function registerCustomAdminCss() {
	$src = "/wp-content/themes/mag-wp/custom/custom-admin-css.css";
	$handle = "customAdminCss";
	wp_register_script($handle, $src);
	wp_enqueue_style($handle, $src, array(), false, false);
}
add_action('admin_head', 'registerCustomAdminCss');

// ------------------------------------------------------------------------------ 
// Remove auto injection of hEntry class into wrong place in author posts - Andre
// ------------------------------------------------------------------------------ 
function andre_get_post_class_without_hentry() {
	$classes = get_post_class('post');
	if (($key = array_search('hentry', $classes)) !== false) {
		unset($classes[$key]);
	}; 
	return implode(" ", $classes);
}

// ------------------------------------------------------------------------------ 
// Add all custom post types to RSS feed - Andre
// ------------------------------------------------------------------------------ 
function myfeed_request($qv) {
	if (isset($qv['feed']))
		$qv['post_type'] = array('news', 'opinion_post', 'gear_post', 'album_review', 'post');
	return $qv;
}
add_filter('request', 'myfeed_request');

// ---------------------------------------------------------------------------------------------------- 
// Remove unnecessary JSON+LD schema block being added by The Events Calendar to Events pages - Andre
// ---------------------------------------------------------------------------------------------------- 
add_filter( 'tribe_google_data_markup_json', '__return_empty_string', 20 );

// ---------------------------------------------------------------------------------------------------- 
// Register Genre Bar Navigation Manu to enable dynamic functionality - Andre
// ---------------------------------------------------------------------------------------------------- 
function register_genre_bar_menu() {
	register_nav_menus(
		array(
			'genre-bar-menu' => __( 'Genre Bar Menu' )
		)
	);
}
add_action( 'init', 'register_genre_bar_menu' );

// ---------------------------------------------------------------------------------------------------- 
// Comments Evolved comment functions - Andre
// ---------------------------------------------------------------------------------------------------- 
// Block Comments Evolved sneaky comment activity tracking
remove_action('wp_insert_comment', 'track_comment_posted_event');
function andre_comments_evolved_number( $count ) {
	// Override the comment count
	if( function_exists( 'comments_evolved_get_total_count' ) )
		$count = comments_evolved_get_total_count();
	// We must then return the value:
	return $count;
}
//add_filter( 'get_comments_number', 'andre_comments_evolved_number');

// ---------------------------------------------------------------------------------------------------- 
// Album Review titles -- append "Album Review:" to titles - Andre
// ---------------------------------------------------------------------------------------------------- 
function append_album_review_to_title( $title, $id = NULL ) {
	if ($id) {
		if ( get_post_type( $id ) == 'album_review' ){
		    return 'Album Review: ' . $title;
		} else {
		    return $title;
		}
	} else {
	    return 'Album Review: ' . $title;
	};
}
add_filter('the_title', 'append_album_review_to_title', 10, 2);

// ---------------------------------------------------------------------------------------------------- 
// Fallback thumbnail image tag and src function  - Andre
// ---------------------------------------------------------------------------------------------------- 
function fallback_thumbnail_image( $tag_or_src = 'tag' ) {
	$thumbnail_fallback_tag = '<img src="http://images.earmilk.com/delivery.png" alt="Really hot thumbnail for this article post!" />';
	$thumbnail_fallback_src = 'http://images.earmilk.com/delivery.png';
	$response = '';
	if ( $tag_or_src == 'src' ) {
		$response = $thumbnail_fallback_src;
	} elseif ( $tag_or_src == 'tag' ) {
		$response = $thumbnail_fallback_tag;
	} else {
		$response = $thumbnail_fallback_tag;
	}
	return $response;
}

// ---------------------------------------------------------------------------------------------------- 
// Modify to get_users author with published post count of >= 1 - via SQL query modification - Andre
// ---------------------------------------------------------------------------------------------------- 
function filter_users_have_posted( $user_query ) {
	$user_query->query_from = str_replace( 'LEFT OUTER', 'INNER', $user_query->query_from );
	remove_action( current_filter(), __FUNCTION__ );
}
//add_action( 'pre_user_query', 'filter_users_have_posted' );

// ---------------------------------------------------------------------------------------------------- 
// Function to add shortcode for dislaying WordPress user meta data in pages and posts - Andre
// ---------------------------------------------------------------------------------------------------- 
function earmilk_staff_shortcode_handler( $atts ) {
	/**
	 * User Meta Shortcode handler
	 * usage: [USER_META user_id=1 meta="first_name"]
	 * @param  array $atts   
	 * @param  string $content
	 * @return stirng
	 */
    //return esc_html(print_r(get_users($atts['user_id'], $atts['meta'], true)));

	$atts = shortcode_atts(
		array(
			'id' => 1,
			'role' => 'Awesome Person',
		), $atts, 'EARMILK_Staff' );

	$user_id = $atts['id'];
	$user_role = $atts['role'];

	$args = array(
		'include' => $user_id
	);

	$this_user = get_users( $args );
	$u_out = '';
	foreach ($this_user as $user) {
		$u_out .= '<div>';
			$u_out .= '<a href="' . $user->user_url . '" title="' . $user->display_name . ', ' . ucwords($user_role) . '">';
				$u_out .= ''. get_avatar( $user_id, 213, $default, "Photo of " . $user->display_name . "" ) .'';
				$u_out .= '<span>' . $user->display_name . '</span>';
				$u_out .= '<span>' . $user_role . '</span>';
			$u_out .= '</a>';
		$u_out .= '</div>';
	};
	return $u_out;
}
add_shortcode('EARMILK_Staff', 'earmilk_staff_shortcode_handler');
// ---------------------------------------------------------------------------------------------------- 
// Function to add shortcode for dislaying WordPress user avatar - Andre
// ---------------------------------------------------------------------------------------------------- 
if ( function_exists( 'get_avatar' ) ) {
	function candid_user_gravatar_shortcode ( $attributes ) {
		global $current_user;
		get_currentuserinfo();
		extract(shortcode_atts(array(
			"id" => $current_user->ID,
			//"size" => 32,
			"default" => 'mystery',
			"alt" => '',
			"class" => '',
			"style" => '',
		), $attributes, 'get_avatar' ));
		$get_avatar= get_avatar( $id, $size, $default, $alt );
		return $get_avatar;
	}
	add_shortcode ('get_avatar', 'candid_user_gravatar_shortcode');
}

// ---------------------------------------------------------------------------------------------------- 
// TinyMCE functions to change around some buttons and menu options on post editor - Andre
// ---------------------------------------------------------------------------------------------------- 
add_action('admin_head', 'andres_edits_to_tinymce');
function andres_edits_to_tinymce() {
	global $typenow;
	// check user permissions
	if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) return;
	// verify the post type
	if( ! in_array( $typenow, array( 'post', 'page' ) ) ) return;
	// check if WYSIWYG is enabled
	if ( get_user_option('rich_editing') == 'true') {
		add_filter("mce_external_plugins", "andres_add_tinymce_plugin");
		add_filter('mce_buttons', 'andres_tinymce_button_register');
	}
}
function andres_add_tinymce_plugin($plugin_array) {
	$plugin_array['andres_interview_buttons'] = get_bloginfo('template_directory') . '/custom/andres-tinymce-buttons.js'; 
	return $plugin_array;
}
function andres_tinymce_button_register($buttons) {
	array_push($buttons, 'andres_interview_question', 'andres_interview_answer' );
	return $buttons;
}

// ---------------------------------------------------------------------------------------------------- 
// Show image in RSS feed - Andre
// ---------------------------------------------------------------------------------------------------- 
function featured_image_in_feed( $content ) {
	global $post;
	if( is_feed() ) {
		if ( has_post_thumbnail( $post->ID ) ){
			$output = get_the_post_thumbnail( $post->ID, 'large' );
			$content = $output . $content;
		}
	}
	return $content;
}
add_filter( 'the_content_feed', 'featured_image_in_feed' );
add_filter( 'the_excerpt_rss', 'featured_image_in_feed');

// ---------------------------------------------------------------------------------------------------- 
// Pull out SRC URLs from posts in the loop for use with iFrame embeds - Andre
// ---------------------------------------------------------------------------------------------------- 
function andre_get_iframe_src( $input ) {
	preg_match_all("/<iframe[^>]*src=[\"|']([^'\"]+)[\"|'][^>]*>/i", $input, $output );
	$return = array();
	if( isset( $output[1][0] ) )
		$return = $output[1];
	return $return;
}

// ---------------------------------------------------------------------------------------------------- 
// Breadcrumbs with Schema - Andre
// ---------------------------------------------------------------------------------------------------- 
function custom_breadcrumbs() {
       
    // Settings
    $separator          = '&gt;';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumbs';
    $home_title         = 'Homepage';
    $prefix = '';
    $current_uri = home_url( add_query_arg( NULL, NULL ) );
      
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'post, opinion_post, gear_post, album_review, news';
       
    // Get the query & post information
    global $post,$wp_query;
       
    // Do not display on the homepage
    if ( !is_front_page() ) {
       
        // Build the breadcrums
        echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '" itemprop="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">';
           
        // Home page
        echo '<li class="item-home" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '" itemprop="item"><span itemprop="name">' . $home_title . '</span></a></li>';
        echo '<li class="separator separator-home"> ' . $separator . ' </li>';
           
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() && !is_month() && !is_year() ) {
              
            echo '<li class="item-current item-archive" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><strong><a href="' . get_post_type_archive_link( get_post_type( get_the_ID() ) ) . '" class="bread-current bread-archive" itemprop="item"><span itemprop="name">' . post_type_archive_title($prefix, false) . '<span></a><strong></li>';
              
        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() && !is_month() && !is_year() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '" itemprop="item"><span itemprop="name">' . $post_type_object->labels->name . '</span></a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><strong class="bread-current bread-archive"><span itemprop="name">' . $custom_tax_name . '</span></strong></li>';
              
        } else if ( is_single() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '" itemprop="item"><span itemprop="name">' . $post_type_object->labels->name . '</span></a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            // Get post category info
            $category = get_the_category();
             
            if(!empty($category)) {
              
                // Get last category post is in
                $arr_vals = array_values($category);
                $last_category = end($arr_vals);
                  
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, false, ','),',');
                $cat_parents = explode(',',$get_cat_parents);
                  
                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . get_category_link( $last_category->term_id ) . '" itemprop="item"><span itemprop="name">'.$parents.'</span></a></li>';
                    $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                }
             
            }
              
            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
                   
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
               
            }
              
            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '"><a href="' . get_permalink() . '" itemprop="item"><span itemprop="name">' . get_the_title() . '</span></a></strong></li>';
                  
            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {
                  
                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '" itemprop="item"><span itemprop="name">' . $cat_name . '</span></a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '"><a href="' . get_permalink() . '" itemprop="item"><span itemprop="name">' . get_the_title() . '</span></a></strong></li>';
              
            } else {
                  
                echo '<li class="item-current item-' . $post->ID . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '"><a href="' . get_permalink() . '" itemprop="item"><span itemprop="name">' . get_the_title() . '</span></a></strong></li>';
                  
            }
              
        } else if ( is_category() && !is_archive() ) {
               
            // Category page
            echo '<li class="item-current item-cat"><strong class="bread-current bread-cat" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . get_permalink() . '" itemprop="item"><span itemprop="name">' . single_cat_title('', false) . '</span></a></strong></li>';
               
        } else if ( is_category() ) {
	        
            // Category page
            echo '<li class="item-current item-cat"><strong class="bread-current bread-cat" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . $current_uri . '" itemprop="item"><span itemprop="name">' . single_cat_title('', false) . '</span></a></strong></li>';
               
        } else if ( is_page() ) {
               
            // Standard page
            if( $post->post_parent ){
                   
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                   
                // Get parents in the right order
                $anc = array_reverse($anc);
                   
                // Parent page loop
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '"> itemprop="item"><span itemprop="name">' . get_the_title($ancestor) . '</span></a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }
                   
                // Display parent pages
                echo $parents;
                   
                // Current page
                echo '<li class="item-current item-' . $post->ID . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><strong title="' . get_the_title() . '"><a href="' . get_permalink() . '" itemprop="item"><span itemprop="name">' . get_the_title() . '</span></a></strong></li>';
                   
            } else {
                   
                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><strong class="bread-current bread-' . $post->ID . '"><a href="' . get_permalink() . '" itemprop="item"><span itemprop="name">' . get_the_title() . '</span></a></strong></li>';
                   
            }
               
        } else if ( is_tag() ) {
               
            // Tag page
               
            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;
               
            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . get_permalink() . '" itemprop="item"><span itemprop="name"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</span></a></strong></li>';
           
        } elseif ( is_day() ) {
               
            // Day archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '" itemprop="item"><span itemprop="name">' . get_the_time('Y') . ' Archives</span></a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month link
            echo '<li class="item-month item-month-' . get_the_time('F') . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a class="bread-month bread-month-' . get_the_time('F') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('F') ) . '" title="' . get_the_time('F') . '" itemprop="item"><span itemprop="name">' . get_the_time('F') . ' Archives</span></a></li>';
            echo '<li class="separator separator-' . get_the_time('F') . '"> ' . $separator . ' </li>';
               
            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><strong class="bread-current bread-' . get_the_time('j') . '"><a class="bread-year bread-year-' . get_the_time('j') . '" href="' . get_year_link( get_the_time('j') ) . '" title="' . get_the_time('j') . '" itemprop="item"><span itemprop="name">' . get_the_time('jS') . ' ' . get_the_time('F') . ' Archives</span></a></strong></li>';
               
        } else if ( is_month() ) {
               
            // Month Archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '" itemprop="item"><span itemprop="name">' . get_the_time('Y') . ' Archives</span></a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month display
            echo '<li class="item-month item-month-' . get_the_time('F') . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a class="bread-year bread-year-' . get_the_time('F') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('F') . '" itemprop="item"><strong class="bread-month bread-month-' . get_the_time('F') . '" title="' . get_the_time('F') . '"><span itemprop="name">' . get_the_time('F') . ' Archives</span></strong></a></li>';
               
        } else if ( is_year() ) {
               
            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '" itemprop="item"><span itemprop="name">' . get_the_time('Y') . ' Archives</span></strong></li>';
               
        } else if ( is_author() ) {
               
            // Auhor archive
               
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
               
            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '"><span itemprop="name">' . 'Author: ' . $userdata->display_name . '</span></strong></li>';
           
        } else if ( get_query_var('paged') ) {
               
            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '"><span itemprop="name">'.__('Page') . ' ' . get_query_var('paged') . '</span></strong></li>';
               
        } else if ( is_search() ) {
           
            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '"><span itemprop="name">Search results for: ' . get_search_query() . '</span></strong></li>';
           
        } elseif ( is_404() ) {
               
            // 404 page
            echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . 'Error 404' . '</span></li>';
        }
       
        echo '</ul>';
	}
}

// ---------------------------------------------------------------------------------------------------- 
// New function for Related Posts 
// -- It picks from tags first, then categories, and excludes all posts from Recent Posts query - Andre
// ---------------------------------------------------------------------------------------------------- 
function get_max_related_posts( $recent_posts = '', $taxonomy_1 = 'post_tag', $taxonomy_2 = 'category', $total_posts = 4 ) {
	// First, make sure we are on a single page, if not, bail
	if ( !is_single() )
	    return false;
	
	// Sanitize and vaidate our incoming data
	if ( 'post_tag' !== $taxonomy_1 ) {
	    $taxonomy_1 = filter_var( $taxonomy_1, FILTER_SANITIZE_STRING );
	    if ( !taxonomy_exists( $taxonomy_1 ) )
	        return false;
	}
	
	if ( 'category' !== $taxonomy_2 ) {
	    $taxonomy_2 = filter_var( $taxonomy_2, FILTER_SANITIZE_STRING );
	    if ( !taxonomy_exists( $taxonomy_2 ) )
	        return false;
	}
	
	if ( 4 !== $total_posts ) {
	    $total_posts = filter_var( $total_posts, FILTER_VALIDATE_INT );
	        if ( !$total_posts )
	            return false;
	}
	
	// Everything checks out and is sanitized, lets get the current post
	$current_post = sanitize_post( $GLOBALS['wp_the_query']->get_queried_object() );
	
	// Lets get the first taxonomy's terms belonging to the post
	$terms_1 = get_the_terms( $current_post, $taxonomy_1 );
	
	// Set a varaible to hold the post count from first query
	$count = 0;
	// Set a variable to hold the results from query 1
	$q_1   = [];
	
	// Make sure we have terms
	if ( $terms_1 ) {
	    // Lets get the term ID's
	    $term_1_ids = wp_list_pluck( $terms_1, 'term_id' );
	    
	    $exclude = array_merge( [$current_post->ID], $recent_posts );
	
	    // Lets build the query to get related posts
	    $args_1 = [
	        'post_type'      => $current_post->post_type,
	        'post__not_in'   => $exclude,
	        'posts_per_page' => $total_posts,
	        'fields'         => 'ids',
	        'tax_query'      => [
	            [
	                'taxonomy'         => $taxonomy_1,
	                'terms'            => $term_1_ids,
	                'include_children' => false
	            ]
	        ],
	    ];
	    $q_1 = get_posts( $args_1 );
	    // Count the total amount of posts
	    $q_1_count = count( $q_1 );
	
	    // Update our counter
	    $count = $q_1_count;
	}
	
	// We will now run the second query if $count is less than $total_posts
	if ( $count < $total_posts ) {
	    $terms_2 = get_the_terms( $current_post, $taxonomy_2 );
	    // Make sure we have terms
	    if ( $terms_2 ) {
	        // Lets get the term ID's
	        $term_2_ids = wp_list_pluck( $terms_2, 'term_id' );
	
	        // Calculate the amount of post to get
	        $diff = $total_posts - $count;
	
	        // Create an array of post ID's to exclude
	        if ( $q_1 ) {
	            $exclude = array_merge( $exclude, $q_1 );
	        }
	
	        $args_2 = [
	            'post_type'      => $current_post->post_type,
	            'post__not_in'   => $exclude,
	            'posts_per_page' => $diff,
	            'fields'         => 'ids',
	            'tax_query'      => [
	                [
	                    'taxonomy'         => $taxonomy_2,
	                    'terms'            => $term_2_ids,
	                    'include_children' => false
	                ]
	            ],
	        ];
	        $q_2 = get_posts( $args_2 );
	
	        if ( $q_2 ) {
	            // Merge the two results into one array of ID's
	            $q_1 = array_merge( $q_1, $q_2 );
	        }
	    }
	}
	
	// Make sure we have an array of ID's
	if ( !$q_1 )
	    return false;
	
	// Run our last query, and output the results
	$final_args = [
	    'ignore_sticky_posts' => 1,
	    'post_type'           => $current_post->post_type,
	    'posts_per_page'      => count( $q_1 ),
	    'post__in'            => $q_1,
	    'order'               => 'ASC',
	    'orderby'             => 'post__in',
	    'suppress_filters'    => true,
	    'no_found_rows'       => true
	];
	$final_query = new WP_Query( $final_args );
	
	return $final_query;
}