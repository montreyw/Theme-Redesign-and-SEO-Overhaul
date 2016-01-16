<?php
/**
 * Post Planner Plugin Library
 *
 * Method library
 * @author C.M. Kendrick <cindy@seaserpentstudio.com>
 * @package post-planner
 * @version 1.4
 */

/**
 * Library class
 * @package post-planner
 * @subpackage includes
 */
class PostPlanner_Lib {

	/**
	 * Customize the action links on the Planner listings
	 * @static
	 * @param $actions
	 * @return array
	 * @since 1.0
	 */
	public static function customize_row_actions( $actions ) {
		if ( get_post_type() == 'planner' ) {
			global $post;

			// remove the view link
			unset( $actions['view'] );

			// show the associated post link
			$id = get_post_meta( $post->ID, '_pp_postid', true );
			if ( $id != '' ) {
				$actions['associated_post'] = '<a href="'.esc_url( admin_url( 'post.php?post='.absint( $id ).'&action=edit' ) ).'">'.esc_html__( 'View Associated Content', 'post-planner' ).'</a>';
			}
		}
		return $actions;
	}

	/**
	 * Set up the columns that are displayed on the Planner listings
	 * @static
	 * @param $columns
	 * @return array
	 * @since 1.0
	 */
	public static function planner_columns( $columns ) {
		$columns = array(
			'cb'     => '<input type="checkbox" />',
			'title'  => apply_filters( 'post_planner_topic', __( 'Topic', 'post-planner' ) ),
			'status' => apply_filters( 'post_planner_status', __( 'Status', 'post-planner' ) ),
		);

		if ( PostPlanner_Loader::$settings['assignments'] == 1 ) $columns['assignments'] = apply_filters( 'post_planner_assignments', esc_attr__( 'Assigned To', 'post-planner' ) );
		if ( PostPlanner_Loader::$settings['duedate'] == 1 ) $columns['duedate'] = apply_filters( 'post_planner_duedate', esc_attr__( 'Due Date', 'post-planner' ) );
		if ( PostPlanner_Loader::$settings['checklist'] == 1 ) $columns['checklist'] = apply_filters( 'post_planner_checklist', esc_attr__( 'Checklist', 'post-planner' ) );
		if ( PostPlanner_Loader::$settings['comments'] == 1 ) $columns['comments'] = '<img src="'.esc_url( admin_url( 'images/comment-grey-bubble.png' ) ).'"
		 alt="'.apply_filters( 'post_planner_comments', esc_attr__( 'Comments', 'post-planner' ) ).'" />';

		return apply_filters( 'post_planner_columns', $columns );
	}

	/**
	 * Set up what is displayed in the Planner listings columns
	 * @static
	 * @param $column
	 * @param $post_id
	 * @since 1.0
	 */
	public static function manage_planner_columns( $column, $post_id ) {

		switch ( $column ) {

			case 'status' :
				$status = get_post_meta( $post_id, '_pp_status', true );
				if ( empty( $status ) ) {
					echo apply_filters( 'post_planner_listing_no_status', esc_attr__( 'No Status', 'post-planner' ) );
				} else {
					echo '<div id="post-planner-status-'.absint( $post_id ).'"><span class="hide">'.absint( $status ).'</span>'.sanitize_text_field( PostPlanner_Loader::$statuses[$status]['name'] ).'</div>';
				}
				break;

			case 'assignments' :
				$assignment = get_post_meta( $post_id, '_pp_assignment', true );
				if ( empty( $assignment ) || $assignment == -1 ) {
					echo '<div id="post-planner-assignment-'.absint( $post_id ).'"><span class="hide">-1</span>'.apply_filters( 'post_planner_listing_no_assignment', esc_attr__( 'Unassigned', 'post-planner' ) ).'</div>';
				} else {
					$assign_user = get_userdata( $assignment );
					echo '<div id="post-planner-assignment-'.absint( $post_id ).'"><span class="hide">'.absint( $assignment ).'</span>'.sanitize_text_field( $assign_user->display_name ).'</div>';
				}
				break;

			case 'duedate' :
				$duedate = get_post_meta( $post_id, '_pp_duedate', true );
				if ( empty( $duedate ) ) {
					echo apply_filters( 'post_planner_listing_no_duedate', esc_attr__( 'No Due Date', 'post-planner' ) );
				} else {
					echo sanitize_text_field( $duedate );
				}
				break;

			case 'checklist' :
				$checklist = get_post_meta( $post_id, '_pp_checklist', true );
				if ( is_array( $checklist ) ) {
					 $completed = count( $checklist );
				} else {
					$completed = 0;
				}
				echo apply_filters( 'post_planner_listing_checklist', absint( $completed ).'/'.absint( count( PostPlanner_Loader::$checklist ) ), $completed, count( PostPlanner_Loader::$checklist ) );
				break;

			default :
				break;

		}
	}

	/**
	 * Define what Planner listing columns are sortable
	 * @static
	 * @param $columns
	 * @return array
	 * @since 1.0
	 */
	public static function planner_sortable_columns( $columns ) {
		$columns['status']      = 'status';
		$columns['assignments'] = 'assignments';
		$columns['duedate']     = 'duedate';

		return apply_filters( 'post_planner_sortable_columns', $columns );
	}

	/**
	 * Call the filter to sort the Planner listings
	 * @static
	 * @since 1.0
	 */
	public static function load_planner_listings() {
		add_filter( 'request', array( __CLASS__, 'sort_planner_listings' ) );
	}

	/**
	 * Sort the Planner listings
	 * @static
	 * @param $vars
	 * @return array
	 * @since 1.0
	 */
	public static function sort_planner_listings( $vars ) {

		if ( isset( $vars['post_type'] ) && 'planner' == $vars['post_type'] ) {

			// if sorting by the due date
			if ( isset( $vars['orderby'] ) && 'duedate' == $vars['orderby'] ) {
				$vars = array_merge(
					$vars,
					array(
						'meta_key' => '_pp_duedate',
						'orderby'  => 'meta_value_num'
					)
				);

			// if sorting by the status
			} elseif ( isset( $vars['orderby'] ) && 'status' == $vars['orderby'] ) {
				$vars = array_merge(
					$vars,
					array(
						'meta_key' => '_pp_status',
						'orderby'  => 'meta_value_num'
					)
				);

			// if sorting by the assigned user
			} elseif ( isset( $vars['orderby'] ) && 'assignments' == $vars['orderby'] ) {
				$vars = array_merge(
					$vars,
					array(
						'meta_key' => '_pp_assignment',
						'orderby'  => 'meta_value_num'
					)
				);
			}

		}

		return $vars;

	}

	/**
	 * Add filters to Planner listings
	 * @static
	 * @since 1.0
	 */
	public static function add_custom_filters() {
		global $typenow, $wpdb;

		if ( $typenow == "planner" ) {

			// category filter
			$filters = get_object_taxonomies( $typenow );
			foreach ( $filters as $tax_slug ) {
				$tax_obj  = get_taxonomy( $tax_slug );
				$tax_name = $tax_obj->labels->name;
				$terms    = get_terms( $tax_slug );
				echo '<select name="'.esc_attr( $tax_slug ).'" id="'.esc_attr( $tax_slug ).'" class="postform">';
				echo '<option value="">'.esc_attr__( 'View All', 'post-planner' ).' '.sanitize_text_field( $tax_name ).'</option>';
				foreach ( $terms as $term ) {
					echo '<option value=' . esc_attr( $term->slug ), isset( $_GET[$tax_slug] ) && $_GET[$tax_slug] == $term->slug ?
						' selected="selected"' : '', '>'.sanitize_text_field( $term->name ).' ('.absint( $term->count ).')</option>';
				}
				echo '</select>';
			}

			// status filter
			echo '<select name="status" id="status" class="postform">';
			echo '<option value="Any">'.apply_filters( 'post_planner_view_all_statuses', esc_attr__( 'View All Statuses', 'post-planner' ) ).'</option>';
			foreach ( PostPlanner_Loader::$statuses as $key => $value ) {
				echo '<option value='.esc_attr( $key ), isset( $_GET['status'] ) && $_GET['status'] == $key ? ' selected="selected"' : '', '>'.sanitize_text_field( $value['name'] ).'</option>';
			}
			echo '</select>';

			// assignment filter
			echo '<select name="assignments" id="assignments" class="postform">';
			echo '<option value="Any">'.apply_filters( 'post_planner_view_all_assignments', esc_attr__( 'View All Assignments', 'post-planner' ) ).'</option>';
			$results = $wpdb->get_results( $wpdb->prepare( "
                SELECT DISTINCT pm.meta_value AS name, count(*) AS count  FROM {$wpdb->postmeta} pm
                LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
                WHERE pm.meta_key = '%s'
                AND pm.meta_value != ''
                AND p.post_type = '%s'
                AND p.post_status != 'trash'
                GROUP BY pm.meta_value
                ORDER BY pm.meta_value
                ", '_pp_assignment', 'planner' )
			);
			foreach ( $results as $meta ) {
				if ( $meta->name == -1  ) {
					echo '<option value='.esc_attr( $meta->name ), isset( $_GET['assignments'] ) && $_GET['assignments'] == $meta->name ?
						' selected="selected"' : '', '>'.apply_filters( 'post_planner_listing_no_assignment', esc_attr__( 'Unassigned', 'post-planner' ) ).' ('.absint( $meta->count ).')</option>';
				} elseif ( $meta->name != 0 ) {
					$assign_user = get_userdata( $meta->name );
					echo '<option value='.esc_attr( $meta->name ), isset( $_GET['assignments'] ) && $_GET['assignments'] == $meta->name ?
						' selected="selected"' : '', '>'.sanitize_text_field( $assign_user->display_name ).' ('.absint( $meta->count ).')</option>';
				}
			}
			echo '</select>';

			// type filter
			$planner_post_types = explode( ',', PostPlanner_Loader::$settings['post_types'] );
			if ( count( $planner_post_types ) > 1 ) {
				echo '<select name="type" id="type" class="postform">';
				echo '<option value="Any">'.esc_attr__( 'View All Types', 'post-planner' ).'</option>';
				foreach ( $planner_post_types as $planner_post_type ) {
					$planner_type = get_post_type_object( $planner_post_type );
					if ( is_object( $planner_type) ) {
						echo '<option value='.esc_attr( $planner_post_type ), isset( $_GET['type'] ) && $_GET['type'] == $planner_post_type ? ' selected="selected"' : '', '>'.$planner_type->labels->singular_name.'</option>';
					}
				}
				echo '</select>';
			}

		}
	}

	/**
	 * Sort the Planner listings by custom meta values
	 * @param $query
	 * @since 1.0
	 */
	public static function sort_by_custom( $query ) {
		global $pagenow, $typenow;

		// if the page is edit.php and the type is planner
		if ( is_admin() && $pagenow == 'edit.php' && $typenow == 'planner' && isset( $_GET['post_type'] ) && $_GET['post_type'] == 'planner' ) {
			$vars = array();

			// set query vars for assignment
			if ( isset( $_GET['assignments'] ) && $_GET['assignments'] != 'Any' ) {
				$vars = array_merge( $vars, array( array(
					'key'   => '_pp_assignment',
					'value' => intval( $_GET['assignments'] )
				) ) );
			}

			// set query vars for status
			if ( isset( $_GET['status'] ) && $_GET['status'] != 'Any' ) {
				$vars = array_merge( $vars, array( array(
					'key'   => '_pp_status',
					'value' => absint( $_GET['status'] )
				) ) );
			}

			// set query vars for type
			if ( isset( $_GET['type'] ) && $_GET['type'] != 'Any' ) {
				$vars = array_merge( $vars, array( array(
					'key'   => '_pp_type',
					'value' => esc_attr( $_GET['type'] )
				) ) );
			}

			$query->query_vars['orderby'] = 'meta_value';
			set_query_var( 'meta_query', $vars );
		}
	}

	/**
	 * Set up the Status Quick Edit field for Planner listings
	 * @static
	 * @param $column_name
	 * @param $post_type
	 * @return mixed
	 * @since 1.0
	 */
	public static function add_status_quick_edit( $column_name, $post_type ) {
		if ( $column_name != 'status' || $post_type != 'planner') return;
		static $printNonce = TRUE;
		if ( $printNonce ) {
			$printNonce = FALSE;
			wp_nonce_field( plugin_basename( __FILE__ ), 'planner_edit_nonce' );
		}
		?>
		<fieldset class="inline-edit-col-left inline-edit-custom"">
			<div class="inline-edit-col">
				<span class="title"><?php echo apply_filters( 'post_planner_status', esc_attr__( 'Status', 'post-planner' ) ); ?></span>
				<select name="_pp_status" class="status" id="_pp_status">
					<?php foreach ( PostPlanner_Loader::$statuses as $key => $value ) : ?>
						<option value="<?php echo absint( $key ); ?>"><?php echo sanitize_text_field( $value['name'] ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</fieldset>
	<?php
	}

	/**
	 * Save the Status Quick Edit data for Planner listings
	 * @static
	 * @param $post_id
	 * @return string|void
	 * @since 1.0
	 */
	public static function save_status_quick_edit_data( $post_id ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		$slug = 'planner';
		if ( isset( $_POST['post_type'] ) && $slug !== $_POST['post_type'] ) {
			return $post_id;
		}
		if ( !current_user_can( 'edit_planner', $post_id ) ) {
			return $post_id;
		}
		$_POST += array( "{$slug}_edit_nonce" => '' );
		if ( !wp_verify_nonce( $_POST["{$slug}_edit_nonce"],
			plugin_basename( __FILE__ ) )
		) {
			return $post_id;
		}

		if ( isset( $_REQUEST['_pp_status'] ) ) {
			$status = absint( $_REQUEST['_pp_status'] );
			update_post_meta( $post_id, '_pp_status', $status );
		}

	}

	/**
	 * Set up the Assignment Quick Edit field for Planner listings
	 * @static
	 * @param $column_name
	 * @param $post_type
	 * @return mixed
	 * @since 1.0
	 */
	public static function add_assignment_quick_edit( $column_name, $post_type ) {
		if ( $column_name != 'assignments' || $post_type != 'planner' ) return;
		static $printNonce = TRUE;
		if ( $printNonce ) {
			$printNonce = FALSE;
			wp_nonce_field( plugin_basename( __FILE__ ), 'planner_edit_nonce' );
		}
		?>
		<fieldset class="inline-edit-col-left inline-edit-custom">
			<div class="inline-edit-col">
				<span class="title"><?php echo apply_filters( 'post_planner_assignments', esc_attr__( 'Assign To', 'post-planner' ) ); ?></span>
				<select name="_pp_assignment" class="assignment" id="_pp_assignment">
					<option value="-1"><?php esc_attr_e( 'None', 'post-planner' ); ?></option>
					<?php
					if ( PostPlanner_Loader::$settings['user_roles'] == '' ) {
						$roles = array( 'contributor', 'author', 'editor', 'administrator' );
					} else {
						$roles = explode( ",", PostPlanner_Loader::$settings['user_roles'] );
					}
					foreach ( $roles as $role ) {
						$role_users = PostPlanner_Lib::get_users( $role );
						foreach ( $role_users as $role_user ) {
							$user_info = get_userdata( $role_user->ID ); ?>
							<option value="<?php echo absint( $role_user->ID ); ?>"><?php echo sanitize_text_field( $user_info->display_name ); ?></option>
							<?php
						}
					}
					?>
				</select>
			</div>
		</fieldset>
	<?php
	}

	/**
	 * Save the Assignment Quick Edit data for Planner listings
	 * @static
	 * @param $post_id
	 * @return string|void
	 * @since 1.0
	 */
	public static function save_assignment_quick_edit_data( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		$slug = 'planner';
		if ( isset( $_POST['post_type'] ) && $slug !== $_POST['post_type'] ) {
			return $post_id;
		}
		if ( !current_user_can( 'edit_planner', $post_id ) ) {
			return $post_id;
		}
		$_POST += array( "{$slug}_edit_nonce" => '' );
		if ( !wp_verify_nonce( $_POST["{$slug}_edit_nonce"],
			plugin_basename( __FILE__ ) )
		) {
			return $post_id;
		}

		if ( isset( $_REQUEST['_pp_assignment'] ) ) {
			$assignment = intval( $_REQUEST['_pp_assignment'] );
			update_post_meta( $post_id, '_pp_assignment', $assignment );
		}

	}

	/**
	 * Save Assignment Functions
	 *
	 * Call Email Function when Updating Assignment Meta if Applicable
	 * Change Planner author to Assigned User
	 * @static
	 * @param $meta_id
	 * @param $post_id
	 * @param $meta_key
	 * @param $meta_value
	 * @since 1.0
	 */
	public static function save_assignment( $meta_id, $post_id, $meta_key, $meta_value ) {
		if ( '_pp_assignment' == $meta_key ) {
			$current_user = wp_get_current_user();

			if ( PostPlanner_Loader::$settings['email_assigned'] == 1 && $meta_value != -1 && $current_user->ID != $meta_value ) {
				$old_assignment = ( get_post_meta( $post_id, '_pp_assignment', true ) ? get_post_meta( $post_id, '_pp_assignment', true ) : 0 );
				if ( $meta_value != $old_assignment ) {
					self::send_email( $post_id, $meta_value );
				}
			}

		}
	}

	/**
	 * Call Email Function when Adding Assignment Meta if Applicable
	 * @static
	 * @param $post_id
	 * @param $meta_key
	 * @param $meta_value
	 * @since 1.0
	 */
	public static function save_new_assignment( $post_id, $meta_key, $meta_value ) {
		if ( '_pp_assignment' == $meta_key ) {
			$current_user = wp_get_current_user();

			if ( PostPlanner_Loader::$settings['email_assigned'] == 1 && $meta_value != -1 && $current_user->ID != $meta_value ) {
				$old_assignment = ( get_post_meta( $post_id, '_pp_assignment', true ) ? get_post_meta( $post_id, '_pp_assignment', true ) : 0 );
				if ( $meta_value != $old_assignment ) {
					self::send_email( $post_id, $meta_value );
				}
			}
		}
	}

	/**
	 * Change post author if assignment is set to the assigned user
	 * @param $data
	 * @param $postarr
	 * @return mixed
	 */
	public static function change_author( $data, $postarr ) {
		if ( $data['post_type'] == 'planner' && ( isset( $postarr['_pp_submitdiv']['assignment'] ) && $postarr['_pp_submitdiv']['assignment'] != '-1' ) ) {
			$data['post_author'] = $postarr['_pp_submitdiv']['assignment'];
		}
		return $data;
	}

	/**
	 * Send Notification Email
	 * @static
	 * @param $post_id
	 * @param $assignment
	 * @since 1.0
	 */
	public static function send_email( $post_id, $assignment ) {
		$current_user = wp_get_current_user();

		$topic      = get_the_title( $post_id );
		$status     = get_post_meta( $post_id, '_pp_status', true );
		$categories = get_the_terms( $post_id, 'plannercategories' );
		$url        = admin_url( 'post.php?post='.absint( $post_id ).'&action=edit' );
		$cats       = array();
		if ( $categories != '' ) {
			foreach ( $categories as $term ) {
				$cats[] = $term->name;
			}
			$category = implode( ", ", $cats );
		} else {
			$category = '';
		}
		if ( PostPlanner_Loader::$settings['duedate'] == 1 ) $due_date = get_post_meta( $post_id, '_pp_duedate', true );

		$headers = 'From: '.PostPlanner_Loader::$settings['email_from'].' <'.PostPlanner_Loader::$settings['email_from_email'].'>'."\r\n\\";
		$subject = PostPlanner_Loader::$settings['email_subject'];
		if ( PostPlanner_Loader::$settings['email_category'] == 1 && $category != '' ) $subject .= ' - '.$category;

		$assign_user   = get_userdata( $assignment );
		$email         = $assign_user->user_email;
		$email_message = PostPlanner_Loader::$settings['email_text']."\r\n";
		if ( PostPlanner_Loader::$settings['email_show_assigned_by'] == 1 ) $email_message .= "\r\n".__( 'From', 'post-planner' ).': '.$current_user->display_name.' ('.$current_user->user_email.')'."\r\n";
		if ( PostPlanner_Loader::$settings['email_category'] == 1 && $category != '' ) $email_message .= apply_filters( 'post_planner_category', __( 'Category',
			'post-planner' ) ).': '.$category."\r\n";
		if ( isset( $due_date ) && $due_date != '' ) $email_message .= apply_filters( 'post_planner_duedate', __( 'Due Date', 'post-planner' ) ).': '.$due_date."\r\n";
		$email_message .= apply_filters( 'post_planner_status', __( 'Status', 'post-planner' ) ).': '.PostPlanner_Loader::$statuses[$status]['name']."\r\n";
		$email_message .= apply_filters( 'post_planner_topic', __( 'Topic', 'post-planner' ) ).': '.$topic."\r\n";
		$email_message .= apply_filters( 'post_planner_email_url', esc_html__( 'Planner URL', 'post-planner' ) ).': '.$url."\r\n";
		wp_mail( $email, $subject, $email_message, $headers );

	}

	/**
	 * Remove meta boxes for Planner custom post type
	 * @static
	 * @since 1.0
	 */
	public static function remove_post_meta_boxes() {
		remove_meta_box( 'slugdiv', 'planner', 'normal' );
		remove_meta_box( 'commentstatusdiv', 'planner', 'normal' );
		remove_meta_box( 'submitdiv', 'planner', 'side' );
		do_action( 'post_planner_remove_post_meta_boxes' );
	}

	/**
	 * Create New Planner based on Post
	 * @static
	 * @since 1.0
	 */
	public static function create_new_planner_callback() {
		check_ajax_referer( 'postplanner' );

		if ( current_user_can( 'edit_planners' ) ) {
			$current_user = wp_get_current_user();
			$post_id      = absint( $_POST['postplanner_post_id'] );

			$args = array(
				'post_type'        => 'planner',
				'post_title'       => wp_strip_all_tags( $_POST['postplanner_topic'] ),
				'post_status'      => 'publish',
				'post_author'      => absint( $current_user->ID ),
			);

			$planner_id = wp_insert_post( $args );

			// if there an error, return error message
			if ( $planner_id == 0 || !is_int( $planner_id ) ) {

				$response = json_encode( array( 'status' => -1 ) );
			// else update the post meta to associate the new planner with the post and return the planner id
			} elseif ( is_int( $planner_id ) ) {
				$submit_array = array(
					'_pp_assignment',
					'_pp_status',
					'_pp_type'
				);

				if ( isset( $_POST['postplanner_author'] ) ) {
					$author = absint( $_POST['postplanner_author'] );
				} else {
					$author = $current_user->ID;
				}

				update_post_meta( $planner_id, '_pp_type', $_POST['postplanner_type'] );
				update_post_meta( $planner_id, '_pp_status', 1 );
				update_post_meta( $planner_id, '_pp_assignment', $author );
				update_post_meta( $planner_id, '_pp_submitdiv_fields', $submit_array );
				update_post_meta( $post_id, '_postplanner', $planner_id );
				update_post_meta( $planner_id, '_pp_postid', $post_id );
				$response = json_encode( array( 'status'     => 1,
				                                'planner_id' => $planner_id ) );
			// or if something else went wrong, return error message
			} else {
				$response = json_encode( array( 'status' => -1 ) );
			}
		} else {
			$response = json_encode( array( 'status' => -1 ) );
		}

		header( "Content-Type: application/json" );

		echo $response;

		die(); // this is required to return a proper result
	}

	/**
	 * Create Post Ajax Callback
	 * @static
	 * @since 1.0
	 */
	public static function create_associated_post_callback() {
		check_ajax_referer( 'postplanner' );
		$current_user = wp_get_current_user();
		$type = esc_attr( $_POST['postplanner_type'] );

		if ( $type == 'post' ) {
			$permission = current_user_can( 'edit_posts' );
		} elseif ( $type == 'page' ) {
			$permission = current_user_can( 'edit_pages' );
		} else {
			$permission = apply_filters( 'post_planner_associated_permissions', current_user_can( 'edit_posts' ), $type );
		}

		if ( $permission == true ) {

			$planner_id = absint( $_POST['postplanner_planner_id'] );
			$existing   = get_post_meta( $planner_id, '_pp_postid', true );

			// if there is already a post associated with this planner, return error message
			if ( $existing != '' ) {

				$response = json_encode( array( 'status' => -2 ) );

			// else, create a new post and associate it with the planner
			} else {

				$assigned = ( isset( $_POST['postplanner_assigned'] ) && $_POST['postplanner_assigned'] != -1 && $_POST['postplanner_assigned'] != '' ? absint( $_POST['postplanner_assigned'] ) : $current_user->ID );

				$my_post = array(
					'post_type'        => $type,
					'post_title'       => wp_strip_all_tags( $_POST['postplanner_topic'] ),
					'post_status'      => 'draft',
					'post_author'      => absint( $assigned ),
				);

				$post_id = wp_insert_post( $my_post );

				// if there an error, return error message
				if ( $post_id == 0 || !is_int( $post_id ) ) {

					$response = json_encode( array( 'status' => -1 ) );

				// else update the post meta to associate planner with the new post and return the post id
				} elseif ( is_int( $post_id ) ) {

					update_post_meta( $post_id, '_postplanner', $planner_id );
					update_post_meta( $planner_id, '_pp_postid', $post_id );
					$response = json_encode( array( 'status'  => 1,
					                                'post_id' => $post_id ) );

				// or if something else went wrong, return error message
				} else {
					$response = json_encode( array( 'status' => -1 ) );
				}
			}
		} else {
			$response = json_encode( array( 'status' => -1 ) );
		}

		header( "Content-Type: application/json" );

		echo $response;

		die(); // this is required to return a proper result
	}

	/**
	 * Associate Post Ajax Callback
	 * @static
	 * @since 1.0
	 */
	public static function associate_post_callback() {
		check_ajax_referer( 'postplanner' );
		$type = esc_attr( $_POST['postplanner_type'] );

		if ( $type == 'post' ) {
			$permission = current_user_can( 'edit_posts' );
		} elseif ( $type == 'page' ) {
			$permission = current_user_can( 'edit_pages' );
		} else {
			$permission = apply_filters( 'post_planner_associated_permissions', current_user_can( 'edit_posts' ), $type );
		}

		if ( $permission == true ) {
			$planner_id = absint( $_POST['postplanner_planner_id'] );
			$post_id    = absint( $_POST['postplanner_post_id'] );
			$existing   = get_post_meta( $post_id, '_postplanner', true );

			// if the post is already associated with another planner, return error message
			if ( $existing != '' && $existing != $planner_id ) {
				// check to make sure that the planner still exists
				$exists = PostPlanner_Lib::planner_exists( $existing );
				if ( $exists == true ) {
					$status = 2;
					// else associate the post with the planner
				} else {
					$status = update_post_meta( $post_id, '_postplanner', $planner_id );
					if ( $status == true ) $status = update_post_meta( $planner_id, '_pp_postid', $post_id );
					$status = ( $status == true ? 1 : -1 );
				}
				// else associate the post with the planner
			} else {
				$status = update_post_meta( $post_id, '_postplanner', $planner_id );
				if ( $status == true ) $status = update_post_meta( $planner_id, '_pp_postid', $post_id );
				$status = ( $status == true ? 1 : -1 );
			}
		} else {
			$status = -1;
		}

		echo $status;
		die(); // this is required to return a proper result
	}

	/**
	 * Remove Associated Post Ajax Callback
	 * @static
	 * @since 1.0
	 */
	public static function remove_associated_post_callback() {
		check_ajax_referer( 'postplanner' );
		$type = esc_attr( $_POST['postplanner_type'] );

		if ( $type == 'post' ) {
			$permission = current_user_can( 'edit_posts' );
		} elseif ( $type == 'page' ) {
			$permission = current_user_can( 'edit_pages' );
		} else {
			$permission = apply_filters( 'post_planner_associated_permissions', current_user_can( 'edit_posts' ), $type );
		}

		if ( $permission == true ) {
			$planner_id = absint( $_POST['postplanner_planner_id'] );
			$post_id    = absint( $_POST['postplanner_post_id'] );

			delete_post_meta( $post_id, '_postplanner' );
			$status = delete_post_meta( $planner_id, '_pp_postid' );
			$status = ( $status == true ? 1 : -1 );
		} else {
			$status = -1;
		}

		echo $status;
		die(); // this is required to return a proper result
	}

	/**
	 * Update checklist Ajax Callback
	 * @static
	 * @since 1.0
	 */
	public static function update_checklist_callback() {
		check_ajax_referer( 'postplanner' );
		$planner_id = absint( $_POST['postplanner_planner_id'] );
		$checklist  = $_POST['postplanner_checklist'];

		if ( current_user_can( 'edit_planner', $planner_id ) )  {
			foreach ( $checklist as $item ) {
				$item        = esc_attr( $item );
				$list[$item] = $item;
			}

			$status = update_post_meta( $planner_id, '_pp_checklist', $list );
			$status = ( $status == true ? 1 : -1 );
		} else {
			$status = -1;
		}

		echo $status;
		die(); // this is required to return a proper result
	}

	/**
	 * Update to-do list Ajax callback
	 * @static
	 * @since 1.1
	 */
	public static function update_todolist_callback() {
		check_ajax_referer( 'postplanner' );
		$todo_id = absint( $_POST['postplanner_item_id'] );
		$todo_status = absint( $_POST['postplanner_item_status'] );

		$permission = CTDL_Lib::check_permission( 'todo', 'complete' );

		if ( $permission === true ) {
			CTDL_Lib::complete_todo( absint( $todo_id ), $todo_status );
			$status = 1;
		} else {
			$status = -1;
		}

		echo $status;
		die(); // this is required to return a proper result
	}

	/**
	 * Insert a file into a Post Ajax Callback
	 *
	 * Changes the post parent of the file attachment from the ID of the Planner to the ID of the Associated Post.
	 * This can be prevented by using the post_planner_associate_files filter and setting it to false.
	 * @static
	 * @since 1.0
	 */
	public static function insert_file_callback() {
		check_ajax_referer( 'postplanner' );

		$associate = apply_filters( 'post_planner_associate_files', true );

		if ( $associate == true ) {
			$file_id    = absint( $_POST['post_planner_file_id'] );
			$post_id    = absint( $_POST['post_planner_post_id'] );
			$planner_id = absint( $_POST['post_planner_planner_id'] );
			$type       = esc_attr( $_POST['postplanner_type'] );

			if ( $type == 'post' ) {
				$permission = current_user_can( 'edit_post', $post_id );
			} elseif ( $type == 'page' ) {
				$permission = current_user_can( 'edit_page', $post_id );
			} else {
				$permission = apply_filters( 'post_planner_associated_permissions', current_user_can( 'edit_post', $post_id ), $type );
			}

			if ( $permission == true ) {

				// if the file is attached to the Planner, change the post parent to the Associated Post
				if ( PostPlanner_Lib::is_attached( $file_id, $planner_id ) ) {
					$args = array(
						'ID'           => $file_id,
						'post_parent'  => $post_id,
					);

					$updated_post_id = wp_update_post( $args );
					$status          = ( $updated_post_id == 0 ? -1 : 1 );
				} else {
					$status = 1;
				}

			} else {
				$status = -1;
			}

		} else {
			$status = 1;
		}

		echo $status;
		die(); // this is required to return a proper result
	}

	/**
	 * Insert file list into a Post Ajax Callback
	 *
	 * Changes the post parent of the file attachments from the ID of the Planner to the ID of the Associated Post.
	 * This can be prevented by using the post_planner_associate_files filter and setting it to false.
	 * @static
	 * @since 1.0
	 */
	public static function insert_file_list_callback() {
		check_ajax_referer( 'postplanner' );

		$associate = apply_filters( 'post_planner_associate_files', true );

		if ( $associate == true ) {
			$file_ids   = $_POST['post_planner_file_ids'];
			$post_id    = absint( $_POST['post_planner_post_id'] );
			$planner_id = absint( $_POST['post_planner_planner_id'] );
			$type       = esc_attr( $_POST['postplanner_type'] );

			if ( $type == 'post' ) {
				$permission = current_user_can( 'edit_post', $post_id );
			} elseif ( $type == 'page' ) {
				$permission = current_user_can( 'edit_page', $post_id );
			} else {
				$permission = apply_filters( 'post_planner_associated_permissions', current_user_can( 'edit_post', $post_id ), $type );
			}

			if ( $permission == true ) {

				foreach ( $file_ids as $key => $id ) {

					// if the file is attached to the Planner, change the post parent to the Associated Post
					if ( PostPlanner_Lib::is_attached( $id, $planner_id ) ) {
						$args = array(
							'ID'           => absint( $id ),
							'post_parent'  => $post_id,
						);

						$updated_post_id = wp_update_post( $args );
						$status          = ( $updated_post_id == 0 ? -1 : 1 );
					} else {
						$status = 1;
					}
				}

			} else {
				$status = -1;
			}

		} else {
			$status = 1;
		}

		echo $status;
		die(); // this is required to return a proper result
	}

	/**
	 * Insert an image into a Post Ajax Callback
	 *
	 * Changes the post parent of the image attachment from the ID of the Planner to the ID of the Associated Post.
	 * This can be prevented by using the post_planner_associate_images filter and setting it to false.
	 * @static
	 * @since 1.0
	 */
	public static function insert_image_callback() {
		check_ajax_referer( 'postplanner' );

		$associate = apply_filters( 'post_planner_associate_images', true );

		if ( $associate == true ) {
			$image_id   = absint( $_POST['post_planner_image_id'] );
			$post_id    = absint( $_POST['post_planner_post_id'] );
			$planner_id = absint( $_POST['post_planner_planner_id'] );
			$type       = esc_attr( $_POST['postplanner_type'] );

			if ( $type == 'post' ) {
				$permission = current_user_can( 'edit_post', $post_id );
			} elseif ( $type == 'page' ) {
				$permission = current_user_can( 'edit_page', $post_id );
			} else {
				$permission = apply_filters( 'post_planner_associated_permissions', current_user_can( 'edit_post', $post_id ), $type );
			}

			if ( $permission == true ) {

				// if the image is attached to the Planner, change the post parent to the Associated Post
				if ( PostPlanner_Lib::is_attached( $image_id, $planner_id ) ) {
					$args = array(
						'ID'           => $image_id,
						'post_parent'  => $post_id,
					);

					$updated_post_id = wp_update_post( $args );
					$status          = ( $updated_post_id == 0 ? -1 : 1 );
				} else {
					$status = 1;
				}
			} else {
				$status = 1;
			}

		} else {
			$status = 1;
		}

		echo $status;
		die(); // this is required to return a proper result
	}

	/**
	 * Insert a featured image into a Post Ajax Callback
	 * @static
	 * @since 1.0
	 */
	public static function insert_featured_image_callback() {
		check_ajax_referer( 'postplanner' );
		$image_id   = absint( $_POST['post_planner_image_id'] );
		$post_id    = absint( $_POST['post_planner_post_id'] );
		$type       = esc_attr( $_POST['postplanner_type'] );

		if ( $type == 'post' ) {
			$permission = current_user_can( 'edit_post', $post_id );
		} elseif ( $type == 'page' ) {
			$permission = current_user_can( 'edit_page', $post_id );
		} else {
			$permission = apply_filters( 'post_planner_associated_permissions', current_user_can( 'edit_post', $post_id ), $type );
		}

		if ( $permission == true ) {
			$status = set_post_thumbnail( $post_id, $image_id );
			if ( $status == true ) {
				$status = 1;
			} else {
				$status = -1;
			}
		} else {
			$status = -1;
		}

		echo $status;
		die(); // this is required to return a proper result
	}

	/**
	 * Insert all images into a Post Ajax Callback
	 *
	 * Changes the post parent of the image attachments from the ID of the Planner to the ID of the Associated Post.
	 * This can be prevented by using the post_planner_associate_images filter and setting it to false.
	 * @static
	 * @since 1.0
	 */
	public static function insert_all_images_callback() {
		check_ajax_referer( 'postplanner' );

		$associate = apply_filters( 'post_planner_associate_images', true );

		if ( $associate == true ) {
			$image_ids  = $_POST['post_planner_image_ids'];
			$post_id    = absint( $_POST['post_planner_post_id'] );
			$planner_id = absint( $_POST['post_planner_planner_id'] );
			$type       = esc_attr( $_POST['postplanner_type'] );

			if ( $type == 'post' ) {
				$permission = current_user_can( 'edit_post', $post_id );
			} elseif ( $type == 'page' ) {
				$permission = current_user_can( 'edit_page', $post_id );
			} else {
				$permission = apply_filters( 'post_planner_associated_permissions', current_user_can( 'edit_post', $post_id ), $type );
			}

			if ( $permission == true ) {

				foreach ( $image_ids as $key => $id ) {

					// if the image is attached to the Planner, change the post parent to the Associated Post
					if ( PostPlanner_Lib::is_attached( $id, $planner_id ) ) {
						$args = array(
							'ID'           => absint( $id ),
							'post_parent'  => $post_id,
						);

						$updated_post_id = wp_update_post( $args );
						$status          = ( $updated_post_id == 0 ? -1 : 1 );
					} else {
						$status = 1;
					}
				}

			} else {
				$status = 1;
			}

		} else {
			$status = 1;
		}

		echo $status;
		die(); // this is required to return a proper result
	}

	/**
	 * Insert Comment Ajax Callback
	 * @static
	 * @since 1.0
	 */
	public static function insert_comment_callback() {
		check_ajax_referer( 'postplanner' );

		if ( current_user_can( 'edit_planners' ) ) {

			$planner_id   = absint( $_POST['post_planner_planner_id'] );
			$comment_text = $_POST['post_planner_comment_text'];
			$current_user = wp_get_current_user();

			$data       = array(
				'comment_post_ID'      => $planner_id,
				'comment_author'       => sanitize_text_field( $current_user->display_name ),
				'comment_author_email' => sanitize_email( $current_user->user_email ),
				'comment_author_url'   => esc_url_raw( $current_user->user_url ),
				'comment_content'      => wp_kses_data( $comment_text ),
				'comment_type'         => 'comment',
				'comment_approved'     => '1'
			);
			$comment_id = wp_insert_comment( $data );

			if ( $comment_id != 0 ) {
				$response = json_encode( array( 'status'         => 1,
				                                'comment_id'     => absint( $comment_id ),
				                                'comment_author' => sanitize_text_field( $current_user->display_name ),
				                                'comment_avatar' => get_avatar( $current_user->display_name, '25' ),
				) );
			} else {
				$response = json_encode( array( 'status' => -1 ) );
			}

		} else {
			$response = json_encode( array( 'status' => -1 ) );
		}

		header( "Content-Type: application/json" );

		echo $response;
		die(); // this is required to return a proper result
	}

	/**
	 * Get the default post type
	 * @return mixed
	 */
	public static function get_default_post_type() {
		if ( isset( PostPlanner_Loader::$settings['post_types'] ) ) {
			$post_type = explode( ',', PostPlanner_Loader::$settings['post_types'] );
			$post_type = $post_type[0];
		} else {
			$post_type = 'post';
		}
		return $post_type;
	}

	/**
	 * Check to see if a Planner has content
	 * @static
	 * @param $planner_id
	 * @return bool
	 * @since 1.0
	 */
	public static function check_for_content( $planner_id ) {
		$content_post = get_post( $planner_id );
		$content      = $content_post->post_content;
		$status       = ( $content != '' ? true : false );
		return $status;
	}

	/**
	 * Get a list of users
	 * @static
	 * @param $role
	 * @return array
	 * @since 1.0
	 */
	public static function get_users( $role ) {
		$wp_user_search = new WP_User_Query( array( 'role' => $role ) );
		return $wp_user_search->get_results();
	}

	/**
	 * Get Post Content by ID
	 * @static
	 * @param $id
	 * @return mixed|void
	 * @since 1.0
	 */
	public static function get_content( $id ) {
		$content_post = get_post( $id );
		$content      = $content_post->post_content;
		$content      = apply_filters( 'the_content', $content );
		$content      = str_replace( ']]>', ']]>', $content );
		return $content;
	}

	/**
	 * Get Planners
	 * @static
	 * @param $limit
	 * @param int $status
	 * @param int $cat_id
	 * @return WP_Query
	 * @since 1.0
	 */
	public static function get_planners( $limit = -1, $status = 0, $cat_id = 0 ) {

		// set up meta_query if getting a specific status
		if ( $status != '0' ) {
			$metaquery = array(
				array(
					'key'   => '_pp_status',
					'value' => absint( $status ),
				) );
		} else {
			$metaquery = '';
		}

		// if a category id has been defined
		if ( $cat_id != 0  && $cat_id != -1 ) {

			$args    = array(
				'post_type'      => 'planner',
				'posts_per_page' => intval( $limit ),
				'orderby'        => 'post_date',
				'order'          => 'DESC',
				'tax_query'      => array(
					array(
						'taxonomy' => 'plannercategories',
						'field'    => 'id',
						'terms'    => absint( $cat_id ),
					) ),
				'meta_query'     => $metaquery
			);
			$results = new WP_Query( apply_filters( 'post_planner_category_query', $args ) );

		// if no category id has been defined
		} else {

			$args    = array(
				'post_type'      => 'planner',
				'posts_per_page' => intval( $limit ),
				'orderby'        => 'post_date',
				'order'          => 'DESC',
				'meta_query'     => $metaquery,
			);
			$results = new WP_Query( apply_filters( 'post_planner_query', $args ) );
		}

		wp_reset_query();

		return $results;
	}

	/**
	 * Get the Planner post meta and assign to variables
	 * @static
	 * @param $id
	 * @return array
	 * @since 1.0
	 */
	public static function get_planner_meta( $id ) {
		$post_meta       = get_post_custom( absint( $id ) );
		$assign_meta     = ( isset( $post_meta['_pp_assignment'][0] ) ? $post_meta['_pp_assignment'][0] : 0 );
		$duedate_meta    = ( isset( $post_meta['_pp_duedate'][0] ) ? $post_meta['_pp_duedate'][0] : '' );
		$status_meta     = ( isset( $post_meta['_pp_status'][0] ) ? $post_meta['_pp_status'][0] : '' );
		$associated_meta = ( isset( $post_meta['_pp_postid'][0] ) ? $post_meta['_pp_postid'][0] : '' );
		$type_meta       = ( isset( $post_meta['_pp_type'][0] ) ? $post_meta['_pp_type'][0] : '' );
		return array( $assign_meta, $duedate_meta, $status_meta, $associated_meta, $type_meta );
	}

	/**
	 * Get the To-Do List items
	 * @static
	 * @param $planner_id
	 * @param $user
	 * @param $limit
	 * @param int $status
	 * @param int $cat_id
	 * @param array $to_exclude
	 * @return WP_Query
	 * @since 1.1
	 */
	public static function get_todos( $planner_id, $user, $limit = -1, $status = 0, $cat_id = 0, $to_exclude = array() ) {
		/* Sort Order */
		// if sort_order is post_date, order by that first
		if ( CTDL_Loader::$settings['sort_order'] == 'post_date' ) {
			$orderby = 'post_date';
			$metakey = '';
			// if sort order is deadline, progress, or assigned user, order by that
		} elseif ( CTDL_Loader::$settings['sort_order'] == '_deadline' || CTDL_Loader::$settings['sort_order'] == '_progress' || CTDL_Loader::$settings['sort_order'] == '_assign' ) {
			$orderby = 'meta_value title';
			$metakey = CTDL_Loader::$settings['sort_order'];
			// otherwise, order first by priority
		} else {
			$orderby = 'meta_value '.CTDL_Loader::$settings['sort_order'].' title';
			$metakey = '_priority';
		}

		/* Author */
		if ( CTDL_Loader::$settings['list_view'] == 0 && $user != 0 ) {
			$author = $user;
		} else {
			$author = NULL;
		}

		/* View Settings */

		// In Group View, Show Only Tasks Assigned to That User when Set
		if ( CTDL_Loader::$settings['list_view'] == '1' && $user != 0 && CTDL_Loader::$settings['show_only_assigned'] == '0' && ( !current_user_can( CTDL_Loader::$settings['view_all_assigned_capability'] ) ) ) {
			$metaquery = array(
				array(
					'key'   => '_status',
					'value' => $status,
				),
				array(
					'key'   => '_assign',
					'value' => $user,
				),
				array(
					'key'   => '_planner',
					'value' => $planner_id,
				)
			);

		} else {
			$metaquery = array(
				array(
					'key'   => '_status',
					'value' => $status,
				),
				array(
					'key'   => '_planner',
					'value' => $planner_id,
				) );
		}

		// if a category id has been defined
		if ( $cat_id != 0 ) {
			$args    = array(
				'post_type'      => 'todo',
				'author'         => $author,
				'post_status'    => 'publish',
				'posts_per_page' => $limit,
				'orderby'        => $orderby,
				'order'          => 'ASC',
				'post__not_in'   => $to_exclude,
				'tax_query'      => array(
					array(
						'taxonomy' => 'todocategories',
						'field'    => 'id',
						'terms'    => $cat_id
					) ),
				'meta_query'     => $metaquery
			);
			$results = new WP_Query( $args );
			// if no category id has been defined
		} else {
			$args    = array(
				'post_type'      => 'todo',
				'author'         => $author,
				'post_status'    => 'publish',
				'posts_per_page' => $limit,
				'orderby'        => $orderby,
				'meta_key'       => $metakey,
				'order'          => 'ASC',
				'meta_query'     => $metaquery,
				'post__not_in'   => $to_exclude,
			);
			$results = new WP_Query( $args );
		}

		return $results;
	}

	/**
	 * Check to see if an attachment is attached to post
	 * @static
	 * @param $attached_id
	 * @param $post_id
	 * @return bool
	 * @since 1.0
	 */
	public static function is_attached( $attached_id, $post_id ) {
		$post = get_post( $attached_id );
		if ( $post->post_parent == $post_id ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Get the Post ID from an attachment URL
	 * @static
	 * @param $src
	 * @return mixed
	 * @since 1.0
	 */
	public static function get_attachment_id_from_src( $src ) {
		global $wpdb;
		$link  = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', esc_url_raw( $src ) );
		$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$link'";
		$id    = $wpdb->get_var( $query );
		return $id;
	}

	/**
	 * Get the Post Author for a specific Post
	 * @static
	 * @param $post_id
	 * @return string
	 * @since 1.0
	 */
	public static function get_post_author( $post_id ) {
		$post = get_post( $post_id );
		$author_id = $post->post_author;
		$author = get_the_author_meta( 'display_name', $author_id );
		return $author;
	}

	/**
	 * Set an attachment icon
	 * @static
	 * @param $post_id
	 * @return string
	 * @since 1.0
	 */
	public static function get_attachment_icon( $post_id ) {
		$type = get_post_mime_type( absint( $post_id ) );

		switch ( $type ) {
			case 'image/jpeg':
			case 'image/png':
			case 'image/gif':
			case 'image/bmp':
			case 'image/tiff':
			case 'image/x-icon':
				return "image.png";
				break;
			case 'video/quicktime':
				return 'quicktime.png';
				break;
			case 'video/mpeg':
			case 'video/mp4':
			case 'video/asf':
			case 'video/avi':
			case 'video/divx':
			case 'video/x-flv':
			case 'video/x-matroska':
			case 'video/mpeg':
				return "video.png";
				break;
			case 'text/csv':
			case 'text/plain':
			case 'text/xml':
			case 'text/css':
			case 'application/javascript':
				return "txt.png";
				break;
			case 'application/x-tar':
			case 'application/zip':
			case 'application/x-gzip':
			case 'application/rar':
			case 'application/x-7z-compressed':
			case 'application/x-msdownload':
				return 'zip.png';
				break;
			case 'application/pdf':
				return 'pdf.png';
				break;
			case 'application/msword':
			case 'application/rtf':
			case 'application/vnd.ms-word':
			case 'application/vnd.openxmlformats-officedocument.wordprocessingml':
			case 'application/vnd.oasis.opendocument.text':
			case 'application/wordperfect':
			case 'application/vnd.ms-write':
			case 'application/vnd.ms-access':
			case 'application/vnd.ms-project':
			case 'application/vnd.oasis.opendocument.database':
			case 'application/vnd.oasis.opendocument.formula':
			case 'application/onenote':
				return 'doc.png';
				break;
			case 'text/html':
				return 'html.png';
				break;
			case 'application/x-shockwave-flash':
				return 'swf.png';
				break;
			case 'audio/x-realaudio':
			case 'audio/wav':
			case 'audio/ogg':
			case 'video/ogg':
			case 'audio/midi':
			case 'audio/wma':
			case 'audio/x-matroska':
				return 'midi.png';
				break;
			case 'application/vnd.openxmlformats-officedocument.presentationml':
			case 'application/vnd.openxmlformats-officedocument.spreadsheetml':
			case 'application/vnd.ms-powerpoint':
			case 'application/vnd.ms-excel':
			case 'application/vnd.oasis.opendocument.presentation':
			case 'application/vnd.oasis.opendocument.spreadsheet':
			case 'application/vnd.oasis.opendocument.graphics':
			case 'application/vnd.oasis.opendocument.chart':
				return 'spreadsheet.png';
				break;
			case 'application/java':
				return 'java_src.png';
				break;
			default:
				return "empty.png";

		}
	}

	/**
	 * Check to see if there is actually a Planner for the ID
	 * @static
	 * @param $id
	 * @return mixed
	 * @since 1.2
	 */
	public static function planner_exists( $id ) {
		$planner = get_post( $id );

		if ( null == $planner || 'trash' == $planner->post_status ) {
			return false;
		}

		return true;
	}

	/**
	 * Add Settings link to plugin's entry on the Plugins page
	 * @static
	 * @param $links
	 * @param $file
	 * @return array
	 * @since 1.0
	 */
	public static function add_settings_link( $links, $file ) {
		static $this_plugin;
		if ( !$this_plugin ) $this_plugin = POSTPLANNER_BASENAME;

		if ( $file == $this_plugin ) {
			$settings_link = '<a href="'.admin_url( 'options-general.php?page=post-planner-settings' ).'">'.esc_attr__( 'Settings', 'post-planner' ).'</a>';
			array_unshift( $links, $settings_link );
		}

		return $links;
	}

	/**
	 * Add Post Planner Menu to the Admin Menu Bar
	 * @param $wp_admin_bar
	 * @since 1.0
	 */
	public static function add_to_toolbar( $wp_admin_bar ) {
		$wp_admin_bar->add_node( array(
			'id'     => 'postplanner',
			'title'  => esc_attr__( 'Post Planner', 'post-planner' ),
			'href'   => admin_url( 'edit.php?post_type=planner' ),
			'parent' => false
		) );

		$wp_admin_bar->add_node( array(
			'id'     => 'postplanner-add',
			'title'  => esc_attr__( 'Add New Post Planner', 'post-planner' ),
			'parent' => 'postplanner',
			'href'   => admin_url( 'post-new.php?post_type=planner' ),
		) );
	}

	/**
	 * Add plugin info to admin footer
	 * @static
	 * @since 1.0
	 */
	public static function admin_footer() {
		$plugin_data = get_plugin_data( POSTPLANNER_FILE );
		echo $plugin_data['Title'].' | '.esc_attr__( 'Version', 'post-planner' ).' '.$plugin_data['Version'].' | '.$plugin_data['Author'].
			' | <a href="http://seaserpentstudio.ticksy.com/" target="_blank">'.esc_attr__( 'Support', 'post-planner' ).'</a> | <a href="http://seaserpentstudio
			.com/post-planner/documentation/" target="_blank">'.esc_attr__( 'Documentation', 'post-planner' ).'<br />';
	}

	/**
	 * Create database table and add default options
	 * @static
	 * @since 1.0
	 */
	public static function install_plugin( $installed_version) {
		// check if the db version is the same as the db version constant
		if ( $installed_version != POSTPLANNER_DB_VERSION ) {
			// update options
			self::set_options( $installed_version );
			update_option( 'PostPlanner_db_version', POSTPLANNER_DB_VERSION );
		}
	}

	/**
	 * Install or Upgrade Options
	 * @static
	 * @param $version
	 * @since 1.0
	 */
	public static function set_options( $version ) {

		if ( $version == 0 ) {
			// add default options
			$general_options = array(
				'post_types'              => 'post',
				'admin_bar'               => 1,
				'duedate'                 => 1,
				'assignments'             => 1,
				'references'              => 1,
				'files'                   => 1,
				'images'                  => 1,
				'checklist'               => 1,
				'comments'                => 1,
				'ctdl'                    => 0,
				'ctdl_completed'          => 0
			);

			$advanced_options = array(
				'date_format'               => 'm/d/Y',
				'allowed_roles'             => 'contributor,author,editor,administrator',
				'user_roles'                => 'contributor,author,editor,administrator',
				'email_assigned'            => 0,
				'email_from'                => html_entity_decode( get_bloginfo( 'name' ) ),
				'email_subject'             => html_entity_decode( get_bloginfo( 'name' ) ).': '.esc_attr__( 'A topic has been assigned to you', 'post-planner' ),
				'email_text'                => esc_attr__( 'The following topic has been assigned to you:', 'post-planner' ),
				'email_category'            => 1,
				'email_show_assigned_by'    => 0,
				'show_id'                   => 0,
				'show_date_added'           => 0,
				'disable_user_roles'        => 0,
				'email_from_email'          => get_bloginfo( 'admin_email' ),
			);

			$status_options = array(
				'status1'       => esc_attr__( 'Pitch', 'post-planner' ),
				'status1_color' => '#fff',
				'status2'       => esc_attr__( 'Assigned', 'post-planner' ),
				'status2_color' => '#fff',
				'status3'       => esc_attr__( 'In Progress', 'post-planner' ),
				'status3_color' => '#fff',
				'status4'       => esc_attr__( 'Pending Review', 'post-planner' ),
				'status4_color' => '#fff',
				'status5'       => esc_attr__( 'Ready for Publication', 'post-planner' ),
				'status5_color' => '#fff',
				'status6'       => esc_attr__( 'On Hold', 'post-planner' ),
				'status6_color' => '#fff',
			);

			$checklist_options = array(
				'checklist1'  => '',
				'checklist2'  => '',
				'checklist3'  => '',
				'checklist4'  => '',
				'checklist5'  => '',
				'checklist6'  => '',
				'checklist7'  => '',
				'checklist8'  => '',
				'checklist9'  => '',
				'checklist10' => '',
			);

			$dashboard_options = array(
				'dashboard_number' => '-1',
				'dashboard_status' => 0,
				'dashboard_cat'    => 0,
			);

			add_option( 'PostPlanner_general', $general_options );
			add_option( 'PostPlanner_advanced', $advanced_options );
			add_option( 'PostPlanner_status', $status_options );
			add_option( 'PostPlanner_checklist', $checklist_options );
			add_option( 'PostPlanner_dashboard_settings', $dashboard_options );

		} else {

			if ( $version < 1.1 ) {
				$general_options = get_option( 'PostPlanner_general' );
				$general_options['ctdl'] = 0;
				update_option( 'PostPlanner_general', $general_options );
			}

			if ( $version < 1.2 ) {
				$advanced_options = get_option( 'PostPlanner_advanced' );
				$advanced_options['disable_user_roles'] = 0;
				update_option( 'PostPlanner_advanced', $advanced_options );
			}

			if ( $version < 1.3 ) {
				$general_options         = get_option( 'PostPlanner_general' );
				$general_options['ctdl_completed'] = 0;
				update_option( 'PostPlanner_general', $general_options );
			}

			if ( $version < 1.4 ) {
				$advanced_options                       = get_option( 'PostPlanner_advanced' );
				$advanced_options['email_from_email'] = get_bloginfo( 'admin_email' );
				update_option( 'PostPlanner_advanced', $advanced_options );
			}

		}
	}

	/**
	 * Convert PHP date to jQuery date
	 * @static
	 * @param $dateFormat
	 * @return string
	 * @since 1.0
	 */
	public static function dateFormatTojQueryUIDatePickerFormat( $dateFormat ) {

		$chars = array(
			// Day
			'd' => 'dd',
			'j' => 'd',
			'l' => 'DD',
			'D' => 'D',
			// Month
			'm' => 'mm',
			'n' => 'm',
			'F' => 'MM',
			'M' => 'M',
			// Year
			'Y' => 'yy',
			'y' => 'y',
		);

		return strtr( (string)$dateFormat, $chars );
	}

	/**
	 * Title : Aqua Resizer
	 * Description : Resizes WordPress images on the fly
	 * Version : 1.1.6
	 * Author : Syamil MJ
	 * Author URI : http://aquagraphite.com
	 * License : WTFPL - http://sam.zoy.org/wtfpl/
	 * Documentation : https://github.com/sy4mil/Aqua-Resizer/
	 *
	 * @param string $url - (required) must be uploaded using wp media uploader
	 * @param int $width - (required)
	 * @param int $height - (optional)
	 * @param bool $crop - (optional) default to soft crop
	 * @param bool $single - (optional) returns an array if false
	 * @uses wp_upload_dir()
	 * @uses image_resize_dimensions() | image_resize()
	 * @uses wp_get_image_editor()
	 *
	 * @return str|array
	 */

	public static function aq_resize( $url, $width, $height = null, $crop = null, $single = true ) {

		//validate inputs
		if ( !$url OR !$width ) return false;

		//define upload path & dir
		$upload_info = wp_upload_dir();
		$upload_dir  = $upload_info['basedir'];
		$upload_url  = $upload_info['baseurl'];

		//check if $img_url is local
		if ( strpos( $url, $upload_url ) === false ) return false;

		//define path of image
		$rel_path = str_replace( $upload_url, '', $url );
		$img_path = $upload_dir.$rel_path;

		//check if img path exists, and is an image indeed
		if ( !file_exists( $img_path ) OR !getimagesize( $img_path ) ) return false;

		//get image info
		$info = pathinfo( $img_path );
		$ext  = $info['extension'];
		list( $orig_w, $orig_h ) = getimagesize( $img_path );

		//get image size after cropping
		$dims  = image_resize_dimensions( $orig_w, $orig_h, $width, $height, $crop );
		$dst_w = $dims[4];
		$dst_h = $dims[5];

		//use this to check if cropped image already exists, so we can return that instead
		$suffix       = "{$dst_w}x{$dst_h}";
		$dst_rel_path = str_replace( '.'.$ext, '', $rel_path );
		$destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";

		if ( !$dst_h ) {
		//can't resize, so return original url
			$img_url = $url;
			$dst_w   = $orig_w;
			$dst_h   = $orig_h;
		} //else check if cache exists
		elseif ( file_exists( $destfilename ) && getimagesize( $destfilename ) ) {
			$img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
		} //else, we resize the image and return the new resized image url
		else {

		// Note: This pre-3.5 fallback check will edited out in subsequent version
			if ( function_exists( 'wp_get_image_editor' ) ) {

				$editor = wp_get_image_editor( $img_path );

				if ( is_wp_error( $editor ) || is_wp_error( $editor->resize( $width, $height, $crop ) ) )
					return false;

				$resized_file = $editor->save();

				if ( !is_wp_error( $resized_file ) ) {
					$resized_rel_path = str_replace( $upload_dir, '', $resized_file['path'] );
					$img_url          = $upload_url.$resized_rel_path;
				} else {
					return false;
				}
			} else {

				$resized_img_path = image_resize( $img_path, $width, $height, $crop ); // Fallback foo
				if ( !is_wp_error( $resized_img_path ) ) {
					$resized_rel_path = str_replace( $upload_dir, '', $resized_img_path );
					$img_url          = $upload_url.$resized_rel_path;
				} else {
					return false;
				}
			}
		}

		//return the output
		if ( $single ) {
		//str return
			$image = $img_url;
		} else {
		//array return
			$image = array(
				0 => $img_url,
				1 => $dst_w,
				2 => $dst_h
			);
		}

		return $image;
	}

}
