<?php
/*
Simple:Press Forum
Recent Posts Widget
$LastChangedDate: 2009-06-06 16:03:53 -0700 (Sat, 06 Jun 2009) $
$Rev: 2004 $
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) {
	die('Access Denied');
}

if (class_exists('WP_Widget'))
{
	# ===== RECENT FOUM POST WIDGET WP >= 2.8  ======================================================================

	class WP_Widget_SPF extends WP_Widget {
		function WP_Widget_SPF()
		{
			$widget_ops = array('classname' => 'widget_spf', 'description' => __('A Widget to display the latest Simple:Press Forum posts'));
			$this->WP_Widget('spf', __('Recent Forum Posts', 'sforum'), $widget_ops);
		}

		function widget($args, $instance)
		{
			extract($args);
			$title = empty($instance['title']) ? __("Recent Forum Posts", "sforum") : $instance['title'];
			$limit = empty($instance['limit']) ? 5 : $instance['limit'];
			$forum = empty($instance['forum']) ? 0 : $instance['forum'];
			$user = empty($instance['user']) ? 0 : $instance['user'];
			$postdate = empty($instance['postdate']) ? 0 : $instance['postdate'];
			$posttime = empty($instance['posttime']) ? 0 : $instance['posttime'];
			$idlist = empty($instance['idlist']) ? 0 : $instance['idlist'];

			# generate output
			echo $before_widget . $before_title . $title . $after_title . "<ul class='sftagul'>";
			sf_recent_posts_tag($limit, $forum, $user, $postdate, true, $idlist, $posttime);
			echo "</ul>".$after_widget;
		}

		function update($new_instance, $old_instance)
		{
			$instance = $old_instance;
			$instance['title'] = strip_tags(stripslashes($new_instance['title']));
			$instance['limit'] = strip_tags(stripslashes($new_instance['limit']));
			if (isset($new_instance['forum']))
			{
				$instance['forum'] = 1;
			} else {
				$instance['forum'] = 0;
			}
			if (isset($new_instance['user']))
			{
				$instance['user'] = 1;
			} else {
				$instance['user'] = 0;
			}
			if (isset($new_instance['postdate']))
			{
				$instance['postdate'] = 1;
			} else {
				$instance['postdate'] = 0;
			}
			if (isset($new_instance['posttime']))
			{
				$instance['posttime'] = 1;
			} else {
				$instance['posttime'] = 0;
			}
			$instance['idlist'] = strip_tags(stripslashes($new_instance['idlist']));
			return $instance;
		}

		function form($instance)
		{
			global $wpdb;
			$instance = wp_parse_args((array) $instance, array('title' => __('Recent Forum Posts', 'sforum'), 'limit' => 5, 'forum' => 1, 'user' => 1, 'postdate' => 1, 'idlist' => 0, 'posttime' => 1));
			$title = htmlspecialchars($instance['title'], ENT_QUOTES);
			$limit = htmlspecialchars($instance['limit'], ENT_QUOTES);
			$forum = $instance['forum'];
			$user = $instance['user'];
			$postdate = $instance['postdate'];
			$posttime = $instance['posttime'];
			$idlist = htmlspecialchars($instance['idlist'], ENT_QUOTES);
	?>
			<!--title-->
			<p style="text-align:right;">
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'sforum')?>
				<input style="width: 200px;" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title ?>"/>
			</label></p>

			<!--how many to show -->
			<p style="text-align:right;">
			<label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('List how many posts:', 'sforum')?>
				<input style="width: 50px;" type="text" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" value="<?php echo $limit ?>"/>
			</label></p>

			<!--include forum name-->
			<p style="text-align:right;">
			<label for="sfforum-<?php echo $this->get_field_id('forum'); ?>"><?php _e('Show forum name:', 'sforum')?>
				<input type="checkbox" id="sfforum-<?php echo $this->get_field_id('forum'); ?>" name="<?php echo $this->get_field_name('forum'); ?>"
				<?php if($instance['forum'] == TRUE) {?> checked="checked" <?php } ?> />
			</label></p>

			<!--include user name-->
			<p style="text-align:right;">
			<label for="sfforum-<?php echo $this->get_field_id('user'); ?>"><?php _e('Show users name:', 'sforum')?>
				<input type="checkbox" id="sfforum-<?php echo $this->get_field_id('user'); ?>" name="<?php echo $this->get_field_name('user'); ?>"
				<?php if($instance['user'] == TRUE) {?> checked="checked" <?php } ?> />
			</label></p>

			<!--include post date-->
			<p style="text-align:right;">
			<label for="sfforum-<?php echo $this->get_field_id('postdate'); ?>"><?php _e('Show date of post:', 'sforum')?>
				<input type="checkbox" id="sfforum-<?php echo $this->get_field_id('postdate'); ?>" name="<?php echo $this->get_field_name('postdate'); ?>"
				<?php if($instance['postdate'] == TRUE) {?> checked="checked" <?php } ?> />
			</label></p>

			<!--include post time-->
			<p style="text-align:right;">
			<label for="sfforum<?php echo $this->get_field_id('posttime'); ?>"><?php _e('Show time of post (requires post date):', 'sforum')?>
				<input type="checkbox" id="sfforum-<?php echo $this->get_field_id('posttime'); ?>" name="<?php echo $this->get_field_name('posttime'); ?>"
				<?php if($instance['posttime'] == TRUE) {?> checked="checked" <?php } ?> />
			</label></p>

			<!--forum id list (comma separated)-->
			<p style="text-align:right;">
			<label for="<?php echo $this->get_field_id('idlist'); ?>"><?php _e('Forum IDs:', 'sforum')?>
				<input style="width: 100px;" type="text" id="<?php echo $this->get_field_id('idlist'); ?>" name="<?php echo $this->get_field_name('idlist'); ?>" value="<?php echo $idlist ?>"/>
			</label></p>
			<small><?php _e("If specified, Forum ID's must be separated by commas. To use ALL forums, enter a value of zero", 'sforum')?></small>
<?php
		}
	}

	add_action('widgets_init', 'widget_sf_init', 5);
	function widget_sf_init()
	{
		new WP_Widget_SPF();
		register_widget('WP_Widget_SPF');
	}
} else {
	# ===== RECENT FOUM POST WIDGET ======================================================================

	add_action('widgets_init', 'sf_post_widget_init');

	function sf_post_widget_init()
	{
		# Check for the required plugin functions.
		if(!function_exists('register_sidebar_widget'))
		{
			return;
		}

		function sf_post_widget($args)
		{
			# $args: before_widget, before_title, after_widget, after_title are the array keys. Default tags: li and h2.
			extract($args);

			$options = get_option('widget_sforum');
			$title = empty($options['title']) ? __("Recent Forum Posts", "sforum") : $options['title'];
			$limit = empty($options['limit']) ? 5 : $options['limit'];
			$forum = empty($options['forum']) ? 0 : $options['forum'];
			$user = empty($options['user']) ? 0 : $options['user'];
			$postdate = empty($options['postdate']) ? 0 : $options['postdate'];
			$posttime = empty($options['posttime']) ? 0 : $options['posttime'];
			$idlist = empty($options['idlist']) ? 0 : $options['idlist'];

			# generate output
			echo $before_widget . $before_title . $title . $after_title . "<ul class='sftagul'>";
			sf_recent_posts_tag($limit, $forum, $user, $postdate, true, $idlist, $posttime);
			echo "</ul>".$after_widget;
		}

		function sf_post_widget_control()
		{
			# Get our options and see if we're handling a form submission.
			$options = get_option('widget_sforum');
			if(!is_array($options))
			{
				$options = array('title'=>'', 'limit'=>0, 'forum'=>0, 'user'=>0, 'postdate'=>0, 'posttime'=>0, 'idlist'=>0);
			}

			if ($_POST['sfpostwidget-submit'])
			{
				$options['title'] = strip_tags(stripslashes($_POST['forum-title']));
				$options['limit'] = strip_tags(stripslashes($_POST['forum-limit']));
				if(isset($_POST['forum-forum']))
				{
					$options['forum'] = 1;
				} else {
					$options['forum'] = 0;
				}
				if(isset($_POST['forum-user']))
				{
					$options['user'] = 1;
				} else {
					$options['user'] = 0;
				}
				if(isset($_POST['forum-postdate']))
				{
					$options['postdate'] = 1;
				} else {
					$options['postdate'] = 0;
				}
				if(isset($_POST['forum-posttime']))
				{
					$options['posttime'] = 1;
				} else {
					$options['posttime'] = 0;
				}
				$options['idlist'] = strip_tags(stripslashes($_POST['forum-idlist']));

				update_option('widget_sforum', $options);
			}

			$title = htmlspecialchars($options['title'], ENT_QUOTES);
			$limit = htmlspecialchars($options['limit'], ENT_QUOTES);
			$forum = $options['forum'];
			$user = $options['user'];
			$postdate = $options['postdate'];
			$posttime = $options['posttime'];
			$idlist = htmlspecialchars($options['idlist'], ENT_QUOTES);

			# The option form
			?>

			<!--title-->
			<p style="text-align:right;">
			<label for="forum-title"><?php _e('Title:', 'sforum')?>
				<input style="width: 200px;" type="text" id="forum-title" name="forum-title" value="<?php echo $title?>"/>
			</label></p>

			<!--how many to show -->
			<p style="text-align:right;">
			<label for="forum-limit"><?php _e('List how many posts:', 'sforum')?>
				<input style="width: 50px;" type="text" id="forum-limit" name="forum-limit" value="<?php echo $limit?>"/>
			</label></p>

			<!--include forum name-->
			<p style="text-align:right;">
			<label for="sfforum-forum"><?php _e('Show forum name:', 'sforum')?>
				<input type="checkbox" id="sfforum-forum" name="forum-forum"
				<?php if($options['forum'] == TRUE) {?> checked="checked" <?php } ?> />
			</label></p>

			<!--include user name-->
			<p style="text-align:right;">
			<label for="sfforum-user"><?php _e('Show users name:', 'sforum')?>
				<input type="checkbox" id="sfforum-user" name="forum-user"
				<?php if($options['user'] == TRUE) {?> checked="checked" <?php } ?> />
			</label></p>

			<!--include post date-->
			<p style="text-align:right;">
			<label for="sfforum-postdate"><?php _e('Show date of post:', 'sforum')?>
				<input type="checkbox" id="sfforum-postdate" name="forum-postdate"
				<?php if($options['postdate'] == TRUE) {?> checked="checked" <?php } ?> />
			</label></p>

			<!--include post time-->
			<p style="text-align:right;">
			<label for="sfforum-posttime"><?php _e('Show time of post (requires post date):', 'sforum')?>
				<input type="checkbox" id="sfforum-posttime" name="forum-posttime"
				<?php if($options['posttime'] == TRUE) {?> checked="checked" <?php } ?> />
			</label></p>

			<!--forum id list (comma separated)-->
			<p style="text-align:right;">
			<label for="forum-idlist"><?php _e('Forum IDs:', 'sforum')?>
				<input style="width: 100px;" type="text" id="forum-idlist" name="forum-idlist" value="<?php echo $idlist?>"/>
			</label></p>
			<small><?php _e("If specified, Forum ID's must be separated by commas. To use ALL forums, enter a value of zero", 'sforum')?></small>

			<input type="hidden" id="sfpostwidget-submit" name="sfpostwidget-submit" value="1" />
			<?php
		}

		$name = "Simple:Press Forum";

	    # Register the widget
	    register_sidebar_widget(array($name, 'widgets'), 'sf_post_widget');

	    # Registers the widget control form
	    register_widget_control(array($name, 'widgets'), 'sf_post_widget_control', 300, 230);
	}
}

?>