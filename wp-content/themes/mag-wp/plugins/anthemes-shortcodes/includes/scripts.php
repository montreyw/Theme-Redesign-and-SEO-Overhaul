<?php
/**
 * This file loads the CSS and JS necessary for your shortcodes display
 */
if( !function_exists ('symple_shortcodes_scripts') ) :
	function symple_shortcodes_scripts() {
		$scripts_dir = plugin_dir_url( __FILE__ );
		// Make sure jquery is loaded
		wp_enqueue_script( 'jquery' );
		// Enqueue CSS
		wp_enqueue_style('anthemes_shortcode_styles', plugin_dir_url( __FILE__ ) . 'css/anthemes-shortcodes.css');
	}
	add_action('wp_enqueue_scripts', 'symple_shortcodes_scripts');
endif;