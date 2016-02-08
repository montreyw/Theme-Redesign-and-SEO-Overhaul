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
remove_action( 'admin_notices', array( Yoast_Notification_Center::get(), 'display_notifications' ) );
remove_action( 'all_admin_notices', array( Yoast_Notification_Center::get(), 'display_notifications' ) );

// ------------------------------------------------------------------------------ 
// Register and initialize Custom Admin CSS file - Andre
// ------------------------------------------------------------------------------ 
function registerCustomAdminCss() {
	$src = "/wp-content/themes/mag-wp/css/custom-admin-css.css";
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
