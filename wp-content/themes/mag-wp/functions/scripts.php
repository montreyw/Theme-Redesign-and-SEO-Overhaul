<?php
// ----------------------------------------------
// ------------ JavaScrips Files ----------------
// ----------------------------------------------
if( !function_exists( 'anthemes_enqueue_scripts' ) ) {
    function anthemes_enqueue_scripts() {
		// Register css files
        wp_register_style( 'style', get_stylesheet_uri(), false);
		wp_register_style( 'default', get_template_directory_uri() . '/css/colors/default.css', TRUE);
		wp_register_style( 'responsive', get_template_directory_uri() . '/css/responsive.css', TRUE);
        wp_register_style( 'fancyboxcss', get_template_directory_uri() . '/fancybox/jquery.fancybox-1.3.4.css', TRUE);
        wp_register_style( 'google-font', '//fonts.googleapis.com/css?family=Ruda:400,700|Lato:100,300,700', TRUE);
        wp_register_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome-4.4.0/css/font-awesome.min.css', TRUE);
        wp_register_style( 'owl-carousel-css', get_template_directory_uri() . '/owl-carousel/owl.carousel.css', TRUE);
		// Register scripts
		wp_register_script( 'customjs', get_template_directory_uri() . '/js/custom.js', 'jquery', '', TRUE);
        wp_register_script( 'validatecontact', get_template_directory_uri() . '/js/jquery.validate.min.js', 'jquery', '', TRUE);
        wp_register_script( 'mainfiles',  get_template_directory_uri() . '/js/jquery.main.js', 'jquery', '', TRUE);
        wp_register_script( 'fancyboxjs', get_template_directory_uri() . '/fancybox/jquery.fancybox-1.3.4.pack.js', 'jquery', '', TRUE);
        wp_register_script( 'owl-carouseljs', get_template_directory_uri() . '/owl-carousel/owl.carousel.min.js', 'jquery', '', TRUE);
        // Display js files in Header via wp_head();
        wp_enqueue_style('style');
        wp_enqueue_style('default');
        wp_enqueue_style('owl-carousel-css');
        wp_enqueue_style('responsive');
        wp_enqueue_style('google-font');
        wp_enqueue_style('font-awesome');
        wp_enqueue_script('jquery');
        // Load Comments & .js files.
        if( is_single() ) {
            wp_enqueue_style('fancyboxcss');
            wp_enqueue_script('comment-reply');
            wp_enqueue_script('fancyboxjs');
         }
        // Load js validate in contact and job page.
        if( is_page_template( 'template-contact.php' ) ) {
            wp_enqueue_script('validatecontact');
         }
        // Display js files in Footer via wp_footer();
        wp_enqueue_script('owl-carouseljs');
        wp_enqueue_script('mainfiles'); // masonry style for sidebar(all pages).
        wp_enqueue_script('customjs');
    }
    add_action('wp_enqueue_scripts', 'anthemes_enqueue_scripts');
}
?>