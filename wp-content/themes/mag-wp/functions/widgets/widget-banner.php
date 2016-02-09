<?php
// ------------------------------------------------------
// ------ Widget Banner  -------------------------------
// ------ by AnThemes.net -------------------------------
//        http://themeforest.net/user/An-Themes/portfolio
//        http://themeforest.net/user/An-Themes/follow
// ------------------------------------------------------
class anthemes_300px extends WP_Widget {
     function anthemes_300px() {
	    $widget_ops = array('description' => 'Advertisement - Paste your HTML or JavaScript code.' );
        parent::__construct(false, $name = 'Custom: Advertisement 300px',$widget_ops);
    }
   function widget($args, $instance) {
		extract( $args );
		$title_tw = $instance['title_tw'];
		$bcode = $instance['bcode'];
?>
<?php echo $before_widget; ?>
<?php if ( $title_tw ) echo $before_title . esc_attr( $title_tw ) . $after_title; ?>
<div class="img-300"><?php echo stripslashes_deep($bcode); // esc_attr() if is added will be shown as a text ?></div>
  <?php echo $after_widget; ?>
<?php
    }
     function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title_tw'] = strip_tags($new_instance['title_tw']);
			$instance['bcode'] = stripslashes($new_instance['bcode']);
     return $instance;
    }
 	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance );
?>
        <p>
          <label for="<?php echo $this->get_field_id('bcode'); ?>">Paste your HTML or JavaScript code here:</label>
          <textarea style="height:100px;" class="widefat" id="<?php echo $this->get_field_id('bcode'); ?>" name="<?php echo $this->get_field_name('bcode'); ?>" ><?php if( isset($instance['bcode']) ) echo stripslashes($instance['bcode']); ?></textarea>
        </p>
<?php  } }
add_action('widgets_init', create_function('', 'return register_widget("anthemes_300px");')); // register widget
?>