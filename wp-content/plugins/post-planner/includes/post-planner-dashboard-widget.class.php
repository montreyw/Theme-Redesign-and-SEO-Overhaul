<?php
/**
 * Post Planner Plugin Dashboard Widget
 *
 * Creates the dashboard widget
 * @author C.M. Kendrick <cindy@seaserpentstudio.com>
 * @package post-planner
 * @version 1.4
 */

/**
 * Dashboard widget class
 * @package post-planner
 * @subpackage includes
 */
class PostPlanner_Dashboard_Widget {
	public $dashboard_settings = '';

	public function __construct() {
		add_action( 'wp_dashboard_setup', array( $this, 'dashboard_setup' ) );
	}

	/**
	 * Setup the dashboard widget
	 * @since 1.0
	 */
	public function dashboard_setup() {
		$this->dashboard_settings = get_option( 'PostPlanner_dashboard_settings' );
		wp_add_dashboard_widget( 'post_planner', apply_filters( 'post_planner_dashboard_heading', esc_attr__( 'Post Planner', 'post-planner' ) ), array( $this, 'dashboard_widget' ), array( $this,
		'dashboard_options' ) );
	}

	/**
	 * Creates the dashboard widget
	 * @since 1.0
	 */
	public function dashboard_widget() {
		$limit    = $this->dashboard_settings['dashboard_number'];
		$statuses = ( is_array( $this->dashboard_settings['dashboard_status'] ) ? $this->dashboard_settings['dashboard_status'] : array( $this->dashboard_settings['dashboard_status'] ) );
		$statuses = ( in_array( 0, $statuses ) ? array( 0 ) : $statuses );
		$this->dashboard_settings['dashboard_cat'] = ( isset( $this->dashboard_settings['dashboard_cat'] ) ? $this->dashboard_settings['dashboard_cat'] : 0 );
		$cat_ids  = ( is_array( $this->dashboard_settings['dashboard_cat'] ) ? $this->dashboard_settings['dashboard_cat'] : array( $this->dashboard_settings['dashboard_cat'] ) );
		$items    = '';

		do_action( 'postplanner_before_dashboard_widget' );

		echo '<table id="post-planner-dashboard" class="post-planner-tablesorter widefat">';
		echo '<thead>';
		echo apply_filters( 'post_planner_dashboard_topic_heading', '<th>'.esc_html__( 'Topic', 'post-planner' ).'</th>' );
		echo apply_filters( 'post_planner_dashboard_status_heading', '<th>'.esc_html__( 'Status', 'post-planner' ).'</th>' );
		if ( PostPlanner_Loader::$settings['assignments'] == 1 ) echo apply_filters( 'post_planner_dashboard_assignment_heading', '<th>'.esc_html__( 'Assigned To', 'post-planner' ).'</th>' );
		if ( PostPlanner_Loader::$settings['duedate'] == 1 ) echo apply_filters( 'post_planner_dashboard_duedate_heading', '<th>'.esc_html__( 'Due Date', 'post-planner' ).'</th>' );
		do_action( 'post_planner_dashboard_heading' );
		if ( current_user_can( 'edit_posts' ) ) echo apply_filters( 'post_planner_dashboard_action_heading', '<th class="{sorter: false} no-sort">'.esc_html__( 'Associated', 'post-planner' ).'</th>' );
		echo '</thead>';

		echo '<tbody>';

		foreach ( $cat_ids as $cat_id ) {
			foreach ( $statuses as $status ) {
				$items .= $this->loop_through_planners( $limit, $status, $cat_id );
			}
		}

		if ( $items != '' ) {
			echo $items;
		} else {
			echo apply_filters( 'post_planner_dashboard_no_planners', '<tr><td colspan="100%">'.esc_html__( 'No existing post planners', 'post-planner' ).'</td></tr>' );
		}

		echo '</tbody>';
		echo '</table>';

		do_action( 'postplanner_after_dashboard_widget' );

	}

	/**
	 * Loops through planners
	 * @param $limit
	 * @param int $cat_id
	 * @param int $status
	 * @return array|string
	 * @since 1.0
	 */
	protected function loop_through_planners( $limit = -1, $status = 0, $cat_id = 0 ) {

		$planner_items = PostPlanner_Lib::get_planners( $limit, $status, $cat_id );

		if ( $planner_items->have_posts() ) {
			$items = $this->show_planner_list_items( $planner_items );
		} else {
			return '';
		}

		return $items;

	}

	/**
	 * Shows the planners
	 * @param $planner_items
	 * @return array
	 */
	protected function show_planner_list_items( $planner_items ) {

		$items = '';

		while ( $planner_items->have_posts() ) : $planner_items->the_post();

			$id = get_the_ID();
			list( $assign_meta, $duedate_meta, $status_meta, $associated_meta, $planner_post_type ) = PostPlanner_Lib::get_planner_meta( $id );
			$status_bg = esc_attr( PostPlanner_Loader::$statuses[$status_meta]['color'] );

			$items .= '<tr'.( $status_bg != '' ? ' style="background-color: '.$status_bg.'">' : '>' );

			$items .= apply_filters( 'post_planner_dashboard_topic', '<td class="post-planner-dashboard-topic"><a href="'.admin_url( 'post.php?post='.$id.'&action=edit' ).'">'.get_the_title().'</a></td>', $id, get_the_title() );
			$items .= apply_filters( 'post_planner_dashboard_status', '<td>'.sanitize_text_field( PostPlanner_Loader::$statuses[$status_meta]['name'] ).'</td>', PostPlanner_Loader::$statuses[$status_meta]['name'] );
			if ( PostPlanner_Loader::$settings['assignments'] == 1 ) {
				if ( $assign_meta == -1 || $assign_meta == 0 ) {
					$assignment = esc_html__( 'Unassigned', 'post-planner' );
				} else {
					$assign_user = get_userdata( $assign_meta );
					$assignment = sanitize_text_field( $assign_user->display_name );
				}
				$items .= apply_filters( 'post_planner_dashboard_assignment', '<td class="post-planner-dashboard-author" id="'.$assign_meta.'">'.$assignment.'</td>', $assign_meta, $assignment );
			}
			if ( PostPlanner_Loader::$settings['duedate'] == 1 ) $items .= apply_filters( 'post_planner_dashboard_duedate', '<td>'.sanitize_text_field( $duedate_meta ).'</td>', $duedate_meta );

			do_action( 'post_planner_dashboard_data' );

			if ( $associated_meta != '' ) {
				if ( current_user_can( 'edit_posts' ) ) $action = '<a href="'.admin_url( 'post.php?post='.absint( $associated_meta ).'&action=edit' ).'">'.esc_html__( 'View', 'post-planner' ).'</a>';
			} else {
				if ( current_user_can( 'edit_posts' ) ) $action = '<a href="" class="post-planner-create-post" id="'.absint( $id ).'">'.esc_html__( 'Create', 'post-planner' ).'</a>';
			}
			if ( isset( $action ) ) $items .= apply_filters( 'post_planner_dashboard_action', '<td><span class="post-planner-post-type">'.$planner_post_type.'</span>'.$action.'</td>', $planner_post_type, $action );

			$items .= '</tr>';

		endwhile;

		return $items;
	}

	/**
	 * Dashboard Widget Options
	 * @since 1.0
	 */
	public function dashboard_options() {
		if ( isset( $_POST['post_planner_dashboard_settings'] ) ) {
			$post_planner_dashboard_settings = $_POST['post_planner_dashboard_settings'];
			update_option( 'PostPlanner_dashboard_settings', $post_planner_dashboard_settings );
		}
		settings_fields( 'post_planner-dashboard-settings-group' );
		$options = get_option( 'PostPlanner_dashboard_settings' );
		$cat_id  = ( isset( $options['dashboard_cat'] ) ? $options['dashboard_cat'] : 0 );
		$cat_ids = ( is_array( $cat_id ) ? $cat_id : array( $cat_id ) );
		$status = ( is_array( $options['dashboard_status'] ) ? $options['dashboard_status'] : array( $options['dashboard_status'] ) );
		?>
	<fieldset>
		<p><label for="post_planner_dashboard_settings[dashboard_number]"><?php esc_html_e( 'Number of Items to Show', 'post-planner' ); ?></label>
			<select id="post_planner_dashboard_settings[dashboard_number]" name="post_planner_dashboard_settings[dashboard_number]">
				<option value="1"<?php selected( $options['dashboard_number'], 1 ); ?>><?php esc_attr_e( '1', 'post-planner' ); ?></option>
				<option value="5"<?php selected( $options['dashboard_number'], 5 ); ?>><?php esc_attr_e( '5', 'post-planner' ); ?></option>
				<option value="10"<?php selected( $options['dashboard_number'], 10 ); ?>><?php esc_attr_e( '10', 'post-planner' ); ?></option>
				<option value="15"<?php selected( $options['dashboard_number'], 15 ); ?>><?php esc_attr_e( '15', 'post-planner' ); ?></option>
				<option value="-1"<?php selected( $options['dashboard_number'], -1 ); ?>><?php esc_attr_e( 'All', 'post-planner' ); ?>&nbsp;</option>
			</select>
		</p>

		<p><label for="post_planner_dashboard_settings[dashboard_status][]" class="multiselect"><?php echo apply_filters( 'post_planner_status', esc_html__( 'Status', 'post-planner' ) ); ?></label>
			<select id="post_planner_dashboard_settings[dashboard_status][]" name="post_planner_dashboard_settings[dashboard_status][]" multiple="multiple">
				<option value="0" <?php selected( $status[0], '0' ); ?> ><?php esc_attr_e( 'All', 'post-planner' ); ?></option>
				<?php foreach ( PostPlanner_Loader::$statuses as $key => $value ) : ?>
					<option value="<?php echo esc_attr( $key ); ?>"<?php if ( in_array( $key, $status ) ) echo ' selected="selected"'; ?>><?php echo sanitize_text_field(
							$value['name'] ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		<p><label for="post_planner_dashboard_settings[dashboard_cat][]" class="post-planner-categories-label"><?php echo apply_filters( 'post_planner_category', esc_html__( 'Category',
					'post-planner' ) ); ?></label>
			<ul class="post-planner-categories">
			<?php $args = array(
			'descendants_and_self' => 0,
			'selected_cats'        => $cat_ids,
			'popular_cats'         => false,
			'walker'               => new PostPlannerCategoryWalker(),
			'taxonomy'             => 'plannercategories',
			'checked_ontop'        => true
			); ?>
			<?php wp_terms_checklist( 0, $args ); ?>
			</ul>
		</p>

		<?php do_action( 'post_planner_dashboard_settings' ); ?>

	</fieldset>
	<?php
	}

}

class PostPlannerCategoryWalker extends Walker_Category {

	public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {

		$args = wp_parse_args( array(
			'name'    => 'post_planner_dashboard_settings[dashboard_cat]'
		), $args );

		extract( $args );

		if ( empty( $taxonomy ) )
			$taxonomy = 'category';

		$output .= "\n<li id='{$taxonomy}-{$category->term_id}'>".'<label class="selectit"><input value="'.$category->term_id.'" type="checkbox" name="'.$name.'[]" id="in-'.$taxonomy.'-'
				.$category->term_id.'"'.checked( in_array( $category->term_id, $selected_cats ), true, false ).disabled( empty( $args['disabled'] ), false, false ).' /> '.esc_html( apply_filters( 'the_category', $category->name ) ).'</label>';
	}

	function end_el( &$output, $page, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}

}