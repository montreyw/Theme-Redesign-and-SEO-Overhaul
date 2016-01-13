<?php
/**
 * This file has all the main shortcode functions
 */
/*
 * Allow shortcodes in widgets
 * @since v1.0
 */
add_filter('widget_text', 'do_shortcode');



/*
 * Fix Shortcodes
 * @ANT
 */
if( !function_exists('symple_fix_shortcodes') ) {
	function symple_fix_shortcodes($content){   
		$array = array (
			'<p>['		=> '[', 
			']</p>'		=> ']', 
			']<br />'	=> ']'
		);
		$content = strtr($content, $array);
		return $content;
	}
	add_filter('the_content', 'symple_fix_shortcodes');
}



/*
 * Clear
 * @ANT
 */
if( !function_exists('symple_clear_shortcode') ) {
	function symple_clear_shortcode() {
	   return '<div class="clear"></div>';
	}
	add_shortcode( 'symple_clear', 'symple_clear_shortcode' );
}


/*
 * Buttons
 * @ANT
 */
if( !function_exists('symple_button_shortcode') ) {
	function symple_button_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'color'			=> 'blue',
			'url'			=> 'http://www.anthemes.net',
			'button_target' => '',
			'title'			=> 'Visit Site'
		), $atts ) );
		
		$button = NULL;
		$button .= '<a href="' . $url . '" class="simplebtn ' . $color . '" target="'. $button_target .'">';
				    $button .= $content;		
		$button .= '</a>';
		return $button;
	}
	add_shortcode('symple_button', 'symple_button_shortcode');
}




/*
 * Boxes
 * @ANT
 *
 */
if( !function_exists('symple_box_shortcode') ) { 
	function symple_box_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'style'			=> 'boxinfo'
		  ), $atts ) );
		  
		  $alert_content = '';
		  $alert_content .= '<div class="' . $style . '">';
		  $alert_content .= ''. do_shortcode($content) .'</div>';
		  return $alert_content;
	}
	add_shortcode('symple_box', 'symple_box_shortcode');
}




/*
 * Lists
 * @ANT
 *
 */
if( !function_exists('symple_ul_shortcode') ) { 
	function symple_ul_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'style'			=> 'simplelist'
		  ), $atts ) );

		  return '<ul class="' . $style . '">' . do_shortcode($content) . '</ul>';	

	}
	add_shortcode('symple_ul', 'symple_ul_shortcode');
}

/*
 * Li
 * @ANT
 */
if( !function_exists('symple_li_shortcode') ) {
	function symple_li_shortcode( $atts, $content = null ) {

	return '<li>' . do_shortcode($content) . '</li>';
	}
	add_shortcode( 'symple_li', 'symple_li_shortcode' );
}





/*
 * Columns
 * @ANT
 *
 */
if( !function_exists('symple_column_shortcode') ) {
	function symple_column_shortcode( $atts, $content = null ){
		extract( shortcode_atts( array(
			'size'		=> 'one-third',
		  ), $atts ) );
		  return '<div class="' . $size . '">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('symple_column', 'symple_column_shortcode');
}





/*
 * Accordion
 * @ANT
 *
 */

// Main
if( !function_exists('symple_accordion_main_shortcode') ) {
	function symple_accordion_main_shortcode( $atts, $content = null  ) {

		extract( shortcode_atts( array(
			'title'	=> 'Title',
		), $atts ) );		
		return '<div class="accordionButton">'. $title .'</div>';
	}
	add_shortcode( 'symple_accordion', 'symple_accordion_main_shortcode' );
}

// Section
if( !function_exists('symple_accordion_section_shortcode') ) {
	function symple_accordion_section_shortcode( $atts, $content = null  ) {
		  
	   return '<div class="accordionContent">' . do_shortcode($content) . '</div>';
	}
	
	add_shortcode( 'symple_accordion_section', 'symple_accordion_section_shortcode' );
}




