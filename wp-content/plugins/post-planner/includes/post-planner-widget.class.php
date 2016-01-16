<?php
/**
 * Post Planner Plugin Widget
 *
 * Creates the widget
 * @author C.M. Kendrick <cindy@seaserpentstudio.com>
 * @package post-planner
 * @version 1.0
 */

/**
 * Widget class
 * @package post-planner
 * @subpackage includes
 */
class PostPlanner_Widget extends WP_Widget {
	public $settings;
	public $statuses;

	function __construct() {
        $widget_ops = array( 'description' => esc_attr__( 'Displays Upcoming Posts', 'post-planner' ) );
		parent::__construct( 'post-planner-widget', esc_attr__( 'Post Planner', 'post-planner' ), $widget_ops );
		include_once 'post-planner-library.class.php';
		include_once 'post-planner-loader.class.php';
		$general_options  = ( get_option( 'PostPlanner_general' ) ? get_option( 'PostPlanner_general' ) : array() );
		$advanced_options = ( get_option( 'PostPlanner_advanced' ) ? get_option( 'PostPlanner_advanced' ) : array() );
		$this->settings   = array_merge( $general_options, $advanced_options );
		$this->statuses   = PostPlanner_Loader::setup_statuses();
	}

	/**
	 * Creates the widget
	 * @param $args
	 * @param $instance
	 *
	 */
	function widget( $args, $instance ) {
		extract( $args );
		$title       = apply_filters( 'widget_title', $instance['title'] );
		$limit       = $instance['number'];
		$category    = $instance['category'];

		/** @var $before_widget WP_Widget */
		echo $before_widget;

		if ( $title ) {
			/** @var $before_title string */
			echo $before_title;
			echo $title;
			/** @var $after_title string */
			echo $after_title;
		}

		$items = '';
		$items = $this->loop_through_planners( $limit, $category, $args, $instance );
		echo $items;

		/** @var $after_widget WP_Widget */
		echo $after_widget;
	}

	/**
	 * Loops through planners
	 * @param $limit
	 * @param int $cat_id
	 * @param $args
	 * @param $instance
	 * @return array|string
	 * @since 1.0
	 */
	protected function loop_through_planners( $limit = -1, $cat_id = 0, $args, $instance ) {

		$planner_items = PostPlanner_Lib::get_planners( $limit, 0, $cat_id );

		if ( $planner_items->have_posts() ) {
			$items = $this->show_planner_list_items( $planner_items, $args, $instance );
		} else {
			$items = esc_attr__( 'None found', 'post-planner' );
		}

		return $items;
	}

	/**
	 * Shows the planners
	 * @param $planner_items
	 * @param $args
	 * @param $instance
	 * @return array
	 */
	protected function show_planner_list_items( $planner_items, $args, $instance ) {
		extract( $args );
		$assigned_to = $instance['assigned_to'];
		$duedate     = $instance['duedate'];
		$status      = $instance['status'];

		$items = '';

		while ( $planner_items->have_posts() ) : $planner_items->the_post();

			$id = get_the_ID();
			list( $assign_meta, $duedate_meta, $status_meta ) = PostPlanner_Lib::get_planner_meta( $id );

			$items .= '<li>';

			$items .= get_the_title();
			if ( $status == 1 ) $items .= '<br />'.apply_filters( 'post_planner_status', esc_attr__( 'Status', 'post-planner' ) ).': '.sanitize_text_field( $this->statuses[$status_meta]['name'] );
			if ( $this->settings['assignments'] == 1 && $assigned_to == 1 ) {
				if ( $assign_meta == -1 || $assign_meta == 0 ) {
					$assignment = esc_attr__( 'Unassigned', 'post-planner' );
				} else {
					$assign_user = get_userdata( absint( $assign_meta ) );
					$assignment  = sanitize_text_field( $assign_user->display_name );
				}
				$items .= '<br />'.apply_filters( 'post_planner_assignments', esc_attr__( 'Assigned To', 'post-planner' ) ).': '.$assignment;
			}
			if ( $this->settings['duedate'] == 1 && $duedate == 1  && $duedate_meta != '' ) $items .= '<br />'.apply_filters( 'post_planner_duedate', esc_attr__( 'Due Date',
				'post-planner' ) ).': '.sanitize_text_field( $duedate_meta);

			$items .= '</li>';

		endwhile;

		return $items;
	}

	/**
	 * Updates the widget settings
	 * @param $new_instance
	 * @param $old_instance
	 * @return array
	 */
	function update( $new_instance, $old_instance ) {
		$instance                = $old_instance;
		$instance['title']       = strip_tags( $new_instance['title'] );
		$instance['number']      = $new_instance['number'];
		$instance['assigned_to'] = $new_instance['assigned_to'];
		$instance['duedate']     = $new_instance['duedate'];
		$instance['status']      = $new_instance['status'];
		$instance['category']    = $new_instance['category'];
		return $instance;
	}

	/**
	 * Creates the form for the widget settings
	 * @param $instance
	 * @return string|void
	 */
	function form( $instance ) {
		$defaults = array( 'title'       => esc_attr__( 'Upcoming Posts', 'post-planner' ),
		                   'number'      => '5',
						   'status'      => false,
		                   'assigned_to' => false,
		                   'duedate'     => false,
		                   'category'    => 'All' );
		$instance = wp_parse_args( ( array )$instance, $defaults ); ?>

	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_attr_e( 'Title', 'post-planner' ); ?>:</label>
		<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>"
			value="<?php echo $instance['title']; ?>" style="width:100%;"/>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_attr_e( 'Number of Items to Display', 'post-planner' ); ?>:</label>
		<select id="<?php echo $this->get_field_id( 'number' ); ?>"
			name="<?php echo $this->get_field_name( 'number' ); ?>">
			<option <?php if ( '1' == $instance['number'] ) echo 'selected="selected"'; ?>>1</option>
			<option <?php if ( '5' == $instance['number'] ) echo 'selected="selected"'; ?>>5</option>
			<option <?php if ( '10' == $instance['number'] ) echo 'selected="selected"'; ?>>10</option>
			<option <?php if ( '15' == $instance['number'] ) echo 'selected="selected"'; ?>>15</option>
			<option <?php if ( '20' == $instance['number'] ) echo 'selected="selected"'; ?>>20</option>
			<option <?php if ( '-1' == $instance['number'] ) echo 'selected="selected"'; ?> value="-1"><?php esc_attr_e( 'All', 'post-planner' ); ?></option>
		</select>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_attr_e( 'Category', 'post-planner' ); ?>:</label>
		<?php wp_dropdown_categories( 'taxonomy=plannercategories&echo=1&orderby=name&hide_empty=0&show_option_none=None&show_option_all=' .esc_attr__( 'All', 'post-planner' ) .
			'&id='.$this->get_field_id( 'category' ).'&name='.$this->get_field_name( 'category' ).'&selected='.$instance['category'] ); ?>
	</p>

	<p>
		<input class="checkbox" type="checkbox" <?php checked( $instance['status'], true ); ?> value="1"
			id="<?php echo $this->get_field_id( 'status' ); ?>"
			name="<?php echo $this->get_field_name( 'status' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'status' ); ?>"><?php esc_attr_e( 'Show Status', 'post-planner' ); ?></label>
		<br />
		<input class="checkbox" type="checkbox" <?php checked( $instance['assigned_to'], true ); ?> value="1"
			id="<?php echo $this->get_field_id( 'assigned_to' ); ?>"
			name="<?php echo $this->get_field_name( 'assigned_to' ); ?>"/>
		<label for="<?php echo $this->get_field_id( 'assigned_to' ); ?>"><?php esc_attr_e( 'Show Assigned To', 'post-planner' ); ?></label>
		<br/>
		<input class="checkbox" type="checkbox" <?php checked( $instance['duedate'] ); ?> value="1"
			id="<?php echo $this->get_field_id( 'duedate' ); ?>"
			name="<?php echo $this->get_field_name( 'duedate' ); ?>"/>
		<label for="<?php echo $this->get_field_id( 'duedate' ); ?>"><?php esc_attr_e( 'Show Due Date', 'post-planner' ); ?></label>
	</p>
	<?php
	}
}

add_action( 'widgets_init', create_function( '', 'register_widget( "PostPlanner_Widget" );' ) );
?>