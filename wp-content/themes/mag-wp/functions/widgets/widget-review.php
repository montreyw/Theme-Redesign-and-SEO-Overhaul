<?php
// ------------------------------------------------------
// ------ Best Reviews  ---------------------------------
// ------ by AnThemes.net -------------------------------
//        http://themeforest.net/user/An-Themes/portfolio
//        http://themeforest.net/user/An-Themes/follow
// ------------------------------------------------------
class anthemes_bestreviews extends WP_Widget {
    function anthemes_bestreviews() {
      $widget_ops = array('description' => 'Your site\'s Best Reviews.' );
      parent::__construct(false, $name = 'Custom: Best Reviews',$widget_ops);
    }
    function widget($args, $instance) {
    extract( $args );
    $number = $instance['number'];
    $title = $instance['title'];
?>
<?php echo $before_widget; ?>
<?php if ( $title ) echo $before_title . esc_attr($title) . $after_title; ?>
<ul class="article_list">
<?php $anposts = new WP_Query(array('meta_key' => 'taq_review_score', 'orderby' => 'meta_value_num', 'order' => 'DESC', 'posts_per_page' => esc_attr($number) )); // number to display more / less ?>
<?php $c=0; while ( $anposts->have_posts() ) : $anposts->the_post(); ?>
<?php $c++;
if($c == 1) : ?>
  <li><?php if ( has_post_thumbnail()) { ?>
        <div class="post-date">
          <span class="month"><?php the_time('M', '', '', true); ?></span>
          <span class="day"><?php the_time('d', '', '', true); ?></span>
        </div><!-- end .post-date -->
        <a href="<?php the_permalink(); ?>"> <?php echo the_post_thumbnail('thumbnail-widget'); ?> </a>
        <div class="clear"></div>
        <div class="article-category"><i></i> <?php $category = get_the_category(); if ($category)
            { echo '<a href="' . get_category_link( $category[0]->term_id ) . '" class="tiptipBlog" title="' . sprintf( __( "View all posts in %s", "anthemes" ), $category[0]->name ) . '" ' . '>' . $category[0]->name.'</a> ';}  ?>
        </div><div class="arrow-down-cat"></div><!-- end .article-category -->
      <?php } ?> <div class="clear"></div>
      <div class="an-widget-title">
        <h3 class="article-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
          <?php if(function_exists('taqyeem_get_score')) { ?>
            <?php taqyeem_get_score(); ?>
          <?php } ?>
        <span><?php _e('Written by', 'anthemes'); ?> <?php the_author_posts_link(); ?></span>
      </div>
  </li>
<?php else : ?>
  <li>
      <a href="<?php the_permalink(); ?>"> <?php echo the_post_thumbnail('thumbnail-widget-small'); ?> </a>
      <div class="an-widget-title" <?php if ( has_post_thumbnail()) { ?> style="margin-left:70px;" <?php } ?>>
        <h4 class="article-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
          <?php if(function_exists('taqyeem_get_score')) { ?>
            <?php taqyeem_get_score(); ?>
          <?php } ?>
        <span><?php _e('by', 'anthemes'); ?> <?php the_author_posts_link(); ?></span>
      </div>
  </li>
<?php endif;?>
<?php endwhile; wp_reset_query(); ?>
</ul>
<?php echo $after_widget; ?>
<?php
    }
    function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['number'] = strip_tags($new_instance['number']);
    return $instance;
    }
  function form( $instance ) {
    $instance = wp_parse_args( (array) $instance );
?>
        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php if( isset($instance['title']) ) echo $instance['title']; ?>" />
        </p>
         <p>
          <label for="<?php echo $this->get_field_id('number'); ?>">Number of Posts:</label>
          <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php if( isset($instance['number']) ) echo $instance['number']; ?>" />
         </p>
<?php  } }
add_action('widgets_init', create_function('', 'return register_widget("anthemes_bestreviews");')); // register widget
?>