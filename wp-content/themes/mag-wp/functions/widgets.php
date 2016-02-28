<?php
// Register widgetized areas
function theme_widgets_init() {
    register_sidebar( array (
		'name' => 'Default Sidebar (Right)',
		'id' => 'sidebar',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="title">',
		'after_title' => '</h3><div class="clear"></div>',
	) );
    register_sidebar( array (
		'name' => 'Footer Sidebar 1',
		'id' => 'footer1',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="title">',
		'after_title' => '</h3><div class="clear"></div>',
	) );
    register_sidebar( array (
		'name' => 'Footer Sidebar 2',
		'id' => 'footer2',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="title">',
		'after_title' => '</h3><div class="clear"></div>',
	) );
    register_sidebar( array (
		'name' => 'Footer Sidebar 3',
		'id' => 'footer3',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="title">',
		'after_title' => '</h3><div class="clear"></div>',
	) );
    register_sidebar( array (
		'name' => 'Footer Sidebar 4',
		'id' => 'footer4',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="title">',
		'after_title' => '</h3><div class="clear"></div>',
	) );
}
add_action( 'init', 'theme_widgets_init' );
?>