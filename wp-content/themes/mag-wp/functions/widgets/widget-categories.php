<?php
// ------------------------------------------------------
// ------ Categories in 2 columns  ----------------------
// ------ by AnThemes.net -------------------------------
//        http://themeforest.net/user/An-Themes/portfolio
//        http://themeforest.net/user/An-Themes/follow 
// ------------------------------------------------------

class anthemes_categories extends WP_Widget {
     function anthemes_categories() {
	    $widget_ops = array('description' => 'Display Categories in 2 columns.' );
        parent::__construct(false, $name = 'Custom: Categories',$widget_ops);	
    }

   function widget($args, $instance) {  
		extract( $args );
		$title_tw = $instance['title_tw'];
?>		
 
<?php echo $before_widget; ?>	
<?php if ( $title_tw ) echo $before_title . esc_attr($title_tw) . $after_title; ?>

  <ul>
  <?php wp_list_categories('orderby=name&show_count=1&hierarchical=0&title_li='); ?> 
  </ul>

  <?php echo $after_widget; ?>
  
<?php
    }

     function update($new_instance, $old_instance) {				
			$instance = $old_instance;
			$instance['title_tw'] = strip_tags($new_instance['title_tw']);
     return $instance;
    }

 	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance );
?>


         <p>
          <label for="<?php echo $this->get_field_id('title_tw'); ?>">Title:</label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title_tw'); ?>" name="<?php echo $this->get_field_name('title_tw'); ?>" type="text" value="<?php if( isset($instance['title_tw']) ) echo $instance['title_tw']; ?>" />
        </p>
      

<?php  } }
add_action('widgets_init', create_function('', 'return register_widget("anthemes_categories");')); // register widget
?>