<?php
/**
 * Post Planner Plugin Loader
 *
 * Loads the plugin
 * @author C.M. Kendrick <cindy@seaserpentstudio.com>
 * @package post-planner
 * @version 1.1
 */

/**
 * Loader class
 * @package post-planner
 * @subpackage includes
 */
class PostPlanner_Loader {
	public static $settings;
	public static $statuses;
	public static $checklist;

	/**
	 * Plugin Loader init
	 * @static
	 * @since 1.0
	 */
	public static function init() {
		global $PostPlannerSettings;

		self::check_for_upgrade();
		$general_options   = ( get_option( 'PostPlanner_general' ) ? get_option( 'PostPlanner_general' ) : array() );
		$advanced_options  = ( get_option( 'PostPlanner_advanced' ) ? get_option( 'PostPlanner_advanced' ) : array() );
		self::$settings    = array_merge( $general_options, $advanced_options );
		self::$statuses    = self::setup_statuses();
		if ( PostPlanner_Loader::check_plugin_access() == false ) return;
		if ( PostPlanner_Loader::$settings['checklist'] == 1 ) self::$checklist = get_option( 'PostPlanner_checklist' );
		self::include_files();
		if ( !post_type_exists( 'planner' ) ) self::setup_custom_post_type();
		if ( !taxonomy_exists( 'plannercategories' ) ) self::create_taxonomies();
		$PostPlannerSettings = new PostPlanner_Settings();

		if ( !defined( 'PP_CTDL' ) ) {
			if ( in_array( 'cleverness-to-do-list/cleverness-to-do-list.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && PostPlanner_Loader::$settings['ctdl'] == 1 ) {
				define( 'PP_CTDL', true );
			} else {
				define( 'PP_CTDL', false );
			}
		}

		self::setup_metaboxes();
		self::call_wp_hooks();

		new PostPlanner_Dashboard_Widget();

	}

	/**
	 * Check to see if plugin has an upgrade
	 * @static
	 * @since 1.0
	 */
	private static function check_for_upgrade() {
		global $wp_version;

		$exit_msg = esc_html__( 'Post Planner requires WordPress 3.3 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress">Please update.</a>', 'post-planner' );
		if ( version_compare( $wp_version, "3.3", "<" ) ) {
			exit( $exit_msg );
		}

		postplanner_activation();
	}

	/**
	 * Calls the plugin files for inclusion
	 * @static
	 * @since 1.0
	 */
	private static function include_files() {
		include_once POSTPLANNER_PLUGIN_DIR.'includes/post-planner-library.class.php';
		include_once POSTPLANNER_PLUGIN_DIR.'includes/post-planner-settings.class.php';
		include_once POSTPLANNER_PLUGIN_DIR.'includes/post-planner-help.class.php';
		include_once POSTPLANNER_PLUGIN_DIR.'includes/post-planner.class.php';
		include_once POSTPLANNER_PLUGIN_DIR.'includes/post-planner-dashboard-widget.class.php';

		// include the WPAlchemy files to create metaboxes
		include_once POSTPLANNER_PLUGIN_DIR.'wpalchemy/MetaBox.php';
		include_once POSTPLANNER_PLUGIN_DIR.'wpalchemy/MediaAccess.php';
	}

	/**
	 * Adds WordPress hooks for actions and filters
	 * @static
	 * @since 1.0
	 */
	private static function call_wp_hooks() {
		add_action( 'admin_init', array( __CLASS__, 'set_roles' ) );
		if ( PostPlanner_Loader::$settings['disable_user_roles'] == 0 ) {
			add_filter( 'map_meta_cap', array( __CLASS__, 'planner_map_meta_cap' ), 10, 4 );
		}
		add_action( 'admin_print_scripts-index.php', array( __CLASS__, 'enqueue_scripts_styles' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_scripts_styles' ) );
		add_action( 'admin_head', array( __CLASS__, 'admin_menu_css' ) );
		add_action( 'add_meta_boxes', array( 'PostPlanner_Lib', 'remove_post_meta_boxes' ) );
		add_action( 'restrict_manage_posts', array( 'PostPlanner_Lib', 'add_custom_filters' ) );
		add_action( 'load-edit.php', array( 'PostPlanner_Lib', 'load_planner_listings' ) );
		add_action( 'manage_planner_posts_custom_column', array( 'PostPlanner_Lib', 'manage_planner_columns' ), 10, 2 );
		add_action( 'quick_edit_custom_box', array( 'PostPlanner_Lib', 'add_assignment_quick_edit' ), 10, 2 );
		add_action( 'save_post', array( 'PostPlanner_Lib', 'save_assignment_quick_edit_data' ) );
		add_action( 'quick_edit_custom_box', array( 'PostPlanner_Lib', 'add_status_quick_edit' ), 10, 2 );
		add_action( 'save_post', array( 'PostPlanner_Lib', 'save_status_quick_edit_data' ) );
		if ( self::$settings['email_assigned'] == 1 ) add_action( 'add_post_meta', array( 'PostPlanner_Lib', 'save_new_assignment' ), 10, 3 );
		if ( self::$settings['email_assigned'] == 1 ) add_action( 'update_post_meta', array( 'PostPlanner_Lib', 'save_assignment' ), 10, 4 );
		if ( self::$settings['admin_bar'] == 1 && current_user_can( 'edit_posts' ) ) add_action( 'admin_bar_menu', array( 'PostPlanner_Lib', 'add_to_toolbar' ), 999 );

		add_filter( 'plugin_action_links', array( 'PostPlanner_Lib', 'add_settings_link' ), 10, 2 );
		add_filter( 'post_row_actions', array( 'PostPlanner_Lib', 'customize_row_actions' ), 10, 1 );
		add_filter( 'manage_edit-planner_columns', array( 'PostPlanner_Lib', 'planner_columns' ) );
		add_filter( 'manage_edit-planner_sortable_columns', array( 'PostPlanner_Lib', 'planner_sortable_columns' ) );
		add_filter( 'parse_query', array( 'PostPlanner_Lib', 'sort_by_custom' ) );
		add_filter( 'wp_insert_post_data', array( 'PostPlanner_Lib', 'change_author' ), 99, 2 );

		add_action( 'wp_ajax_post_planner_update_todolist', array( 'PostPlanner_Lib', 'update_todolist_callback' ) );
		add_action( 'wp_ajax_post_planner_update_checklist', array( 'PostPlanner_Lib', 'update_checklist_callback' ) );
		add_action( 'wp_ajax_post_planner_insert_comment', array( 'PostPlanner_Lib', 'insert_comment_callback' ) );
		add_action( 'wp_ajax_post_planner_insert_file', array( 'PostPlanner_Lib', 'insert_file_callback' ) );
		add_action( 'wp_ajax_post_planner_insert_file_list', array( 'PostPlanner_Lib', 'insert_file_list_callback' ) );
		add_action( 'wp_ajax_post_planner_insert_image', array( 'PostPlanner_Lib', 'insert_image_callback' ) );
		add_action( 'wp_ajax_post_planner_insert_featured_image', array( 'PostPlanner_Lib', 'insert_featured_image_callback' ) );
		add_action( 'wp_ajax_post_planner_insert_all_images', array( 'PostPlanner_Lib', 'insert_all_images_callback' ) );
		add_action( 'wp_ajax_post_planner_create_new_planner', array( 'PostPlanner_Lib', 'create_new_planner_callback' ) );
		add_action( 'wp_ajax_post_planner_associate_post', array( 'PostPlanner_Lib', 'associate_post_callback' ) );
		add_action( 'wp_ajax_post_planner_remove_associated_post', array( 'PostPlanner_Lib', 'remove_associated_post_callback' ) );
		add_action( 'wp_ajax_post_planner_create_associated_post', array( 'PostPlanner_Lib', 'create_associated_post_callback' ) );
	}

	/**
	 * Add icon and hover icon to the menu, set page icon
	 * @static
	 * @since 1.0
	 */
	public static function admin_menu_css() {
		?>
	<style>
		#menu-posts-planner .wp-menu-image {
			background: url(<?php echo POSTPLANNER_PLUGIN_URL; ?>/images/notebook.png) no-repeat 6px 0 !important;
		}

		#menu-posts-planner:hover .wp-menu-image, #menu-posts-planner.wp-has-current-submenu .wp-menu-image {
			background-position: 6px -33px !important;
		}

		#icon-edit.icon32-posts-planner {
			background: url(<?php echo POSTPLANNER_PLUGIN_URL; ?>/images/notebook-32.png) no-repeat;
		}
	</style>
	<?php
	}

	/**
	 * Load the plugin CSS, JS and Help tab
	 * @static
	 * @since 1.0
	 */
	public static function enqueue_scripts_styles() {
		$screen = get_current_screen();
		if ( isset( PostPlanner_Loader::$settings['post_types'] ) ) {
			$planner_post_types = explode( ',', PostPlanner_Loader::$settings['post_types'] );
		} else {
			$planner_post_types = array();
		}

		// if on the dashboard
		if ( $screen->id == 'dashboard' ) {
			wp_enqueue_style( 'post_planner_dashboard_css', POSTPLANNER_PLUGIN_URL.'/css/post-planner-dashboard-widget.css', false, POSTPLANNER_PLUGIN_VERSION );

			wp_register_script( 'post_planner_dashboard_js', POSTPLANNER_PLUGIN_URL.'/js/post-planner-dashboard-widget.js', array( 'jquery' ), POSTPLANNER_PLUGIN_VERSION );
			wp_register_script( 'post_planner_tablesorter_js', POSTPLANNER_PLUGIN_URL.'/js/jquery.tablesorter.min.js', array( 'jquery' ), POSTPLANNER_PLUGIN_VERSION );
			wp_register_script( 'post_planner_metadata_js', POSTPLANNER_PLUGIN_URL.'/js/jquery.metadata.js', array( 'jquery' ), POSTPLANNER_PLUGIN_VERSION );
			wp_enqueue_script( 'post_planner_dashboard_js' );
			wp_enqueue_script( 'post_planner_tablesorter_js' );
			wp_enqueue_script( 'post_planner_metadata_js' );
			wp_localize_script( 'post_planner_dashboard_js', 'plannerdash', PostPlanner_Loader::get_js_vars() );
		}

		// if on a Planner custom post type page or on the Post Planner settings page
		if ( $screen->post_type == 'planner' || $screen->id == 'settings_page_post-planner-settings' ) {
			wp_enqueue_style( 'post-planner_css', POSTPLANNER_PLUGIN_URL.'/css/post-planner-admin.css', false, POSTPLANNER_PLUGIN_VERSION );
			wp_enqueue_style( 'jquery.ui.theme', POSTPLANNER_PLUGIN_URL.'/css/post-planner-jquery-ui-1.8.21.custom.css', false, POSTPLANNER_PLUGIN_VERSION );
			wp_enqueue_style( 'farbtastic' );

			wp_register_script( 'post-planner_js', POSTPLANNER_PLUGIN_URL.'/js/post-planner-admin.js', array( 'jquery' ), POSTPLANNER_PLUGIN_VERSION );

			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_script( 'farbtastic' );
			wp_enqueue_script( 'json2' );
			wp_enqueue_script( 'post-planner_js' );
			wp_localize_script( 'post-planner_js', 'postplanner', PostPlanner_Loader::get_js_vars() );

			PostPlanner_Help::help_tab();
		}

		// if on the Planner custom post type listings page
		if ( $screen->id == 'edit-planner' ) {
			wp_register_script( 'post-planner-quickedit_js', POSTPLANNER_PLUGIN_URL.'/js/post-planner-quickedit.js', false, POSTPLANNER_PLUGIN_VERSION );
			wp_enqueue_script( 'post-planner-quickedit_js' );
		}

		// if on an allowed post type editing page
		if ( in_array( $screen->post_type, $planner_post_types ) && in_array( $screen->id, $planner_post_types ) ) {
			wp_enqueue_style( 'jquery.ui.theme', POSTPLANNER_PLUGIN_URL.'/css/post-planner-jquery-ui-1.8.21.custom.css', false, POSTPLANNER_PLUGIN_VERSION );
			wp_enqueue_style( 'post-planner-post_css', POSTPLANNER_PLUGIN_URL.'/css/post-planner-post.css', false, POSTPLANNER_PLUGIN_VERSION );

			wp_register_script( 'post-planner-post_js', POSTPLANNER_PLUGIN_URL.'/js/post-planner-post.js', false, POSTPLANNER_PLUGIN_VERSION );
			wp_register_script( 'jquery-insertatcaret', POSTPLANNER_PLUGIN_URL.'/js/jquery.insertatcaret.min.js', false, POSTPLANNER_PLUGIN_VERSION );
			wp_enqueue_script( 'post-planner-post_js' );
			wp_enqueue_script( 'jquery-ui-tabs' );
			wp_enqueue_script( 'jquery-insertatcaret' );
			wp_localize_script( 'post-planner-post_js', 'planner', PostPlanner_Loader::get_post_js_vars() );
		}
	}

	/**
	 * Localize JS variables for posts
	 * @static
	 * @since 1.0
	 * @return array
	 */
	public static function get_post_js_vars() {
		return array(
			'VIEW_PLANNER'                              => esc_attr__( 'View Planner', 'post-planner' ),
			'PLANNER_ERROR_MSG'                         => esc_attr__( 'Unable to Create New Planner', 'post-planner' ),
			'PLANNER_CREATED_MSG'                       => esc_attr__( 'Planner Created', 'post-planner' ),
			'CREATE_PLANNER_CONFIRMATION_MSG'           => esc_html__( "Are you sure you want to create a new Planner? \n 'Cancel' to stop, 'OK' to continue.", 'post-planner' ),
			'CHECKLIST_ERROR_MSG'                       => esc_attr__( 'Unable to update checklist', 'post-planner' ),
			'FILES_ERROR_MSG'                           => esc_attr__( 'Unable to insert file', 'post-planner' ),
			'FILES_SUCCESS_MSG'                         => esc_attr__( 'File Inserted into Content', 'post-planner' ),
			'FILES_LIST_ERROR_MSG'                      => esc_attr__( 'Unable to insert file list', 'post-planner' ),
			'FILES_LIST_SUCCESS_MSG'                    => esc_attr__( 'File List Inserted into Content', 'post-planner' ),
			'IMAGES_ERROR_MSG'                          => esc_attr__( 'Unable to insert image', 'post-planner' ),
			'IMAGES_SUCCESS_MSG'                        => esc_attr__( 'Image Inserted into Content', 'post-planner' ),
			'IMAGES_LIST_ERROR_MSG'                     => esc_attr__( 'Unable to insert images', 'post-planner' ),
			'IMAGES_LIST_SUCCESS_MSG'                   => esc_attr__( 'Images Inserted into Content', 'post-planner' ),
			'IMAGES_FEATURED_ERROR_MSG'                 => esc_attr__( 'Unable to set Featured Image', 'post-planner' ),
			'IMAGES_FEATURED_SUCCESS_MSG'               => esc_attr__( 'Featured Image Set. It will be displayed on this page once you Save this page.', 'post-planner' ),
			'REFERENCES'                                => esc_attr__( 'References', 'post-planner' ),
			'REFERENCES_SUCCESS_MSG'                    => esc_attr__( 'Reference Inserted into Content', 'post-planner' ),
			'REFERENCES_LIST_SUCCESS_MSG'               => esc_attr__( 'Reference List Inserted into Content', 'post-planner' ),
			'SHOW_DETAILS'                              => esc_attr__( 'Show Details', 'post-planner' ).' &raquo;',
			'HIDE_DETAILS'                              => '&laquo; '.esc_attr__( 'Hide Details', 'post-planner' ),
			'NONCE'                                     => wp_create_nonce( 'postplanner' ),
			'AJAX_URL'                                  => admin_url( 'admin-ajax.php' ),
			'ADMIN_URL'                                 => admin_url(),
			);
	}

	/**
	 * Localize JS variables
	 * @static
	 * @return array
	 * @since 1.0
	 */
	public static function get_js_vars() {
		return array(
			'VIEW_POST'                 => esc_attr__( 'View', 'post-planner' ),
			'ASSOC_DASHBOARD_ERROR_MSG' => esc_attr__( 'Error', 'post-planner' ),
			'CREATE_POST'               => esc_attr__( 'Create', 'post-planner' ),
			'CHECKLIST_ERROR_MSG'       => esc_attr__( 'Unable to update checklist', 'post-planner' ),
			'EDIT'                      => esc_attr__( 'edit', 'post-planner' ),
			'POSTED_BY'                 => esc_attr__( 'posted by', 'post-planner' ),
			'COMMENT_ERROR_MSG'         => esc_attr__( 'Unable to add comment', 'post-planner' ),
			'ASSOC_SUCCESS_MSG'         => esc_attr__( 'Association Successful', 'post-planner' ),
			'ASSOC_ERROR_MSG'           => esc_attr__( 'Association Unsuccessful', 'post-planner' ),
			'ASSOC_DUPLICATE_MSG'       => esc_attr__( 'Associated with Another Planner', 'post-planner' ),
			'ASSOC_ALREADY_MSG'         => esc_attr__( 'Planner Already Associated with an Entry', 'post-planner' ),
			'ASSOC_REMOVED_MSG'         => esc_attr__( 'Association Removed', 'post-planner' ),
			'ASSOC_NOT_REMOVED_MSG'     => esc_attr__( 'Unable to Remove Association', 'post-planner' ),
			'ASSOC_CREATED_MSG'         => esc_attr__( 'Associated Content Created', 'post-planner' ),
			'ASSOC_NOT_CREATED_MSG'     => esc_attr__( 'Unable to Create Associated Content', 'post-planner' ),
			'CREATE_CONFIRMATION_MSG'   => esc_html__( "Are you sure you want to create a new entry based on this Planner? \n 'Cancel' to stop, 'OK' to continue.", 'post-planner' ),
			'CONFIRMATION_MSG'          => esc_html__( "Are you sure you want to associate this Planner? \n 'Cancel' to stop, 'OK' to continue.", 'post-planner' ),
			'REMOVE_CONFIRMATION_MSG'   => esc_html__( "Are you sure you want to remove this association? \n 'Cancel' to stop, 'OK' to continue.", 'post-planner' ),
			'DATE_FORMAT'               => PostPlanner_Lib::dateFormatTojQueryUIDatePickerFormat( PostPlanner_Loader::$settings['date_format'] ),
			'NONCE'                     => wp_create_nonce( 'postplanner' ),
			'AJAX_URL'                  => admin_url( 'admin-ajax.php' ),
			'ADMIN_URL'                 => admin_url(),
		);
	}

	/**
	 * Set up the planner custom post type
	 * @static
	 * @since 1.0
	 */
	private static function setup_custom_post_type() {

		$labels = array(
			'name'               => apply_filters( 'post_planner_name', _x( 'Planner', 'post type general name', 'post-planner' ) ),
			'singular_name'      => apply_filters( 'post_planner_singular_name', _x( 'Planner', 'post type singular name', 'post-planner' ) ),
			'add_new'            => _x( 'Add New', 'post type add new', 'post-planner' ),
			'add_new_item'       => apply_filters( 'post_planner_add_new', __( 'Add New Planner', 'post-planner' ) ),
			'edit_item'          => apply_filters( 'post_planner_edit', __( 'Edit Planner', 'post-planner' ) ),
			'new_item'           => apply_filters( 'post_planner_new', __( 'New Planner', 'post-planner' ) ),
			'view_item'          => apply_filters( 'post_planner_view', __( 'View Planner', 'post-planner' ) ),
			'search_items'       => apply_filters( 'post_planner_search', __( 'Search Planners', 'post-planner' ) ),
			'not_found'          => __( 'Nothing found', 'post-planner' ),
			'not_found_in_trash' => __( 'Nothing found in Trash', 'post-planner' ),
			'parent_item_colon'  => ''
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'query_var'          => true,
			'rewrite'            => true,
			'capability_type'    => 'planner',
			'capabilities' => array(
				'publish_posts'       => 'publish_planners',
				'edit_posts'          => 'edit_planners',
				'edit_others_posts'   => 'edit_others_planners',
				'delete_posts'        => 'delete_planners',
				'delete_others_posts' => 'delete_others_planners',
				'read_private_posts'  => 'read_private_planners',
				'edit_post'           => 'edit_planner',
				'delete_post'         => 'delete_planner',
				'read_post'           => 'read_planner',
			),
			'hierarchical'       => false,
			'menu_position'      => 5,
			'supports'           => array( 'title', 'editor' )
		);

		register_post_type( 'planner', $args );

	}

	/**
	 * Map Planner Meta Capabilities
	 * @static
	 * @param $caps
	 * @param $cap
	 * @param $user_id
	 * @param $args
	 * @return array
	 * @since 1.0
	 */
	public static function planner_map_meta_cap( $caps, $cap, $user_id, $args ) {

		/* If editing, deleting, or reading an planner, get the post and post type object. */
		if ( 'edit_planner' == $cap || 'delete_planner' == $cap || 'read_planner' == $cap ) {
			$post      = get_post( $args[0] );
			$post_type = get_post_type_object( $post->post_type );
			$caps      = array();

			switch ( $cap ) {
				case 'edit_planner':
					$caps[] = ( $user_id == $post->post_author ) ? $post_type->cap->edit_posts : $post_type->cap->edit_others_posts;
					break;
				case 'delete_planner':
					$caps[] = ( $user_id == $post->post_author ) ? $post_type->cap->delete_posts : $post_type->cap->delete_others_posts;
					break;
				case 'read_planner':
					$caps[] = ( 'private' != $post->post_status || $user_id == $post->post_author ) ? $caps[] = 'read_planner' : $post_type->cap->read_private_posts;
					break;
			}
		}

		return $caps;
	}

	/**
	 * Set Planner Role Capabilities
	 * @static
	 * @since 1.0
	 */
	public static function set_roles() {
		global $wp_roles;

		if ( PostPlanner_Loader::$settings['disable_user_roles'] == 0 ) {
			$roles = explode( ',', PostPlanner_Loader::$settings['allowed_roles'] );

			foreach ( $roles as $role ) {
				if ( $role != '' ) {
					$role = get_role( $role );
					if ( is_object( $role ) ) {
						$role->add_cap( 'publish_planners' );
						$role->add_cap( 'edit_planners' );
						$role->add_cap( 'edit_others_planners' );
						$role->add_cap( 'delete_others_planners' );
						$role->add_cap( 'read_private_planners' );
						$role->add_cap( 'delete_planners' );
					}
				}
			}
		} else {
			$wp_roles = new WP_Roles();
			$wp_roles->add_cap( 'administrator', 'edit_planner' );
			$wp_roles->add_cap( 'administrator', 'read_planner' );
			$wp_roles->add_cap( 'administrator', 'delete_planner' );
			$wp_roles->add_cap( 'administrator', 'publish_planners' );
			$wp_roles->add_cap( 'administrator', 'edit_planners' );
			$wp_roles->add_cap( 'administrator', 'edit_others_planners' );
			$wp_roles->add_cap( 'administrator', 'edit_private_planners' );
			$wp_roles->add_cap( 'administrator', 'edit_others_planners' );
			$wp_roles->add_cap( 'administrator', 'delete_others_planners' );
			$wp_roles->add_cap( 'administrator', 'delete_private_planners' );
			$wp_roles->add_cap( 'administrator', 'delete_published_planners' );
			$wp_roles->add_cap( 'administrator', 'read_private_planners' );
			$wp_roles->add_cap( 'administrator', 'delete_planners' );
		}

		do_action( 'post_planner_set_roles' );
	}

	/**
	 * Setup custom category taxonomy for planner custom post type
	 * @static
	 * @since 1.0
	 */
	private static function create_taxonomies() {

		$labels = array(
			'name'          => apply_filters( 'post_planner_categories_name', _x( 'Categories', 'taxonomy general name', 'post-planner' ) ),
			'singular_name' => apply_filters( 'post_planner_categories_singular', _x( 'Category', 'taxonomy singular name', 'post-planner' ) ),
		);

		register_taxonomy( 'plannercategories', array( 'planner' ), array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'query_var'         => true,
			'rewrite'           => false,
			'show_in_nav_menus' => false,
			'show_tagcloud'     => false,
		) );

	}

	/**
	 * Set up metaboxes for the planner custom post type using WPAlchemy
	 * @static
	 * @since 1.0
	 */
	private static function setup_metaboxes() {
		global $post_planner_wpalchemy_media_access, $post_planner_publish_mb, $post_planner_references_mb, $post_planner_files_mb, $post_planner_images_mb, $post_planner_checklist_mb;
		$post_planner_wpalchemy_media_access = new Post_Planner_WPAlchemy_MediaAccess();

		$post_planner_publish_mb = new Post_Planner_WPAlchemy_MetaBox( array
		(
			'id'                 => '_pp_submitdiv',
			'title'              => apply_filters( 'post_planner_publish_metabox_title', esc_attr__( 'Publish', 'post-planner' ) ),
			'template'           => POSTPLANNER_PLUGIN_DIR.'includes/meta/publish.php',
			'types'              => array( 'planner' ),
			'context'            => 'side',
			'priority'           => 'high',
			'autosave'           => TRUE,
			'mode'               => POST_PLANNER_WPALCHEMY_MODE_EXTRACT,
			'prefix'             => '_pp_',
			'view'               => POST_PLANNER_WPALCHEMY_VIEW_ALWAYS_OPENED,
			'lock'               => POST_PLANNER_WPALCHEMY_LOCK_TOP,
			'hide_screen_option' => TRUE
		) );

		if ( PostPlanner_Loader::$settings['references'] == 1 ) {
			$post_planner_references_mb = new Post_Planner_WPAlchemy_MetaBox( array
			(
				'id'       => '_pp_refs',
				'title'    => apply_filters( 'post_planner_references_metabox_title', esc_attr__( 'References', 'post-planner' ) ),
				'template' => POSTPLANNER_PLUGIN_DIR.'includes/meta/references.php',
				'types'    => array( 'planner' ),
				'context'  => 'normal',
				'priority' => 'low',
				'autosave' => TRUE,
				'mode'     => POST_PLANNER_WPALCHEMY_MODE_ARRAY,
				'prefix'   => '_pp_',
				'view'     => POST_PLANNER_WPALCHEMY_VIEW_START_OPENED
			) );
		}

		if ( PostPlanner_Loader::$settings['files'] == 1 ) {
			$types = ( current_user_can( 'upload_files' ) ? array( 'planner' ) : array() );
			$post_planner_files_mb = new Post_Planner_WPAlchemy_MetaBox( array
			(
				'id'       => '_pp_files',
				'title'    => apply_filters( 'post_planner_files_metabox_title', esc_attr__( 'Files', 'post-planner' ) ),
				'template' => POSTPLANNER_PLUGIN_DIR.'includes/meta/files.php',
				'types'    => $types,
				'context'  => 'normal',
				'priority' => 'low',
				'autosave' => TRUE,
				'mode'     => POST_PLANNER_WPALCHEMY_MODE_ARRAY,
				'prefix'   => '_pp_',
				'view'     => POST_PLANNER_WPALCHEMY_VIEW_START_OPENED
			) );
		}


		if ( PostPlanner_Loader::$settings['images'] == 1 ) {
			$types = ( current_user_can( 'upload_files' ) ? array( 'planner' ) : array() );
			$post_planner_images_mb = new Post_Planner_WPAlchemy_MetaBox( array
			(
				'id'       => '_pp_images',
				'title'    => apply_filters( 'post_planner_images_metabox_title', esc_attr__( 'Images', 'post-planner' ) ),
				'template' => POSTPLANNER_PLUGIN_DIR.'includes/meta/images.php',
				'types'    => $types,
				'context'  => 'normal',
				'priority' => 'low',
				'autosave' => TRUE,
				'mode'     => POST_PLANNER_WPALCHEMY_MODE_ARRAY,
				'prefix'   => '_pp_',
				'view'     => POST_PLANNER_WPALCHEMY_VIEW_START_OPENED
			) );
		}

		if ( PostPlanner_Loader::$settings['comments'] == 1 ) {
			new Post_Planner_WPAlchemy_MetaBox( array
			(
				'id'       => '_pp_comments',
				'title'    => apply_filters( 'post_planner_comments_metabox_title', esc_attr__( 'Comments', 'post-planner' ) ),
				'template' => POSTPLANNER_PLUGIN_DIR.'includes/meta/comments.php',
				'types'    => array( 'planner' ),
				'context'  => 'normal',
				'priority' => 'high',
				'autosave' => TRUE,
				'mode'     => POST_PLANNER_WPALCHEMY_MODE_ARRAY,
				'prefix'   => '_pp_',
				'view'     => POST_PLANNER_WPALCHEMY_VIEW_START_OPENED
			) );
		}

		if ( PostPlanner_Loader::$settings['checklist'] == 1 && implode( '', PostPlanner_Loader::$checklist ) ) {
			$post_planner_checklist_mb = new Post_Planner_WPAlchemy_MetaBox( array
			(
				'id'       => '_pp_checklist',
				'title'    => apply_filters( 'post_planner_checklist_metabox_title', esc_attr__( 'Checklist', 'post-planner' ) ),
				'template' => POSTPLANNER_PLUGIN_DIR.'includes/meta/checklist.php',
				'types'    => array( 'planner' ),
				'context'  => 'side',
				'priority' => 'low',
				'autosave' => TRUE,
				'mode'     => POST_PLANNER_WPALCHEMY_MODE_ARRAY,
				'prefix'   => '_pp_',
				'view'     => POST_PLANNER_WPALCHEMY_VIEW_START_OPENED
			) );
		}

		if ( current_user_can( 'edit_posts' ) && isset( PostPlanner_Loader::$settings['post_types'] ) ) {
			new Post_Planner_WPAlchemy_MetaBox( array
			(
				'id'       => '_pp_associated',
				'title'    => apply_filters( 'post_planner_associated_metabox_title', esc_attr__( 'Associated Content', 'post-planner' ) ),
				'template' => POSTPLANNER_PLUGIN_DIR.'includes/meta/associated-post.php',
				'types'    => array( 'planner' ),
				'context'  => 'side',
				'priority' => 'low',
				'autosave' => TRUE,
				'mode'     => POST_PLANNER_WPALCHEMY_MODE_EXTRACT,
				'prefix'   => '_pp_',
				'view'     => POST_PLANNER_WPALCHEMY_VIEW_START_OPENED,
			) );
		}

		if ( isset( PostPlanner_Loader::$settings['post_types'] ) ) {
			$planner_post_types = explode( ',', PostPlanner_Loader::$settings['post_types'] );
			new Post_Planner_WPAlchemy_MetaBox( array
			(
				'id'       => '_pp_planner',
				'title'    => apply_filters( 'post_planner_planner_metabox_title', esc_attr__( 'Post Planner', 'post-planner' ) ),
				'template' => POSTPLANNER_PLUGIN_DIR.'includes/meta/planner.php',
				'types'    => $planner_post_types,
				'context'  => 'normal',
				'priority' => 'high',
				'autosave' => TRUE,
				'mode'     => POST_PLANNER_WPALCHEMY_MODE_ARRAY,
				'prefix'   => '_pp_',
				'view'     => POST_PLANNER_WPALCHEMY_VIEW_START_OPENED
			) );
		}

		if ( PP_CTDL == true ) {
			new Post_Planner_WPAlchemy_MetaBox( array
			(
				'id'       => '_pp_todolist',
				'title'    => apply_filters( 'post_planner_todolist_metabox_title', esc_attr__( 'To-Do List', 'post-planner' ) ),
				'template' => POSTPLANNER_PLUGIN_DIR.'includes/meta/todolist.php',
				'types'    => array( 'planner' ),
				'context'  => 'side',
				'priority' => 'low',
				'autosave' => TRUE,
				'mode'     => POST_PLANNER_WPALCHEMY_MODE_ARRAY,
				'prefix'   => '_pp_',
				'view'     => POST_PLANNER_WPALCHEMY_VIEW_START_OPENED
			) );
		}

	}

	/**
	 * Check if user's role is permitted to access the plugin
	 * @static
	 * @return bool
	 * @since 1.0
	 */
	public static function check_plugin_access() {
		global $user_ID;

		$default = array(
			'roles' => array( 'administrator' )
		);

		$options = explode( ',', PostPlanner_Loader::$settings['allowed_roles'] );
		if ( !empty( $options ) ) {
			$default = array_merge( $options, array( 'administrator' ) );
		}

		if ( !empty( $user_ID ) ) {
			$user = new WP_User( $user_ID );
			if ( !is_array( $user->roles ) ) $user->roles = array( $user->roles );
			foreach ( $user->roles as $role ) {
				if ( in_array( $role, $default ) ) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Get status options put into an array
	 * @static
	 * @return array
	 * @since 1.0
	 */
	public static function setup_statuses() {
		$status_options = ( get_option( 'PostPlanner_status' ) ? get_option( 'PostPlanner_status' ) : array() );

		$statuses = array();
		if ( $status_options['status1'] != '' ) $statuses[1] = array(
																	'color'  => $status_options['status1_color'],
																	'name'   => $status_options['status1'] );
		if ( $status_options['status2'] != '' ) $statuses[2] = array(
																	'color'  => $status_options['status2_color'],
																	'name'   => $status_options['status2'] );
		if ( $status_options['status3'] != '' ) $statuses[3] = array(
																	'color'  => $status_options['status3_color'],
																	'name'   => $status_options['status3'] );
		if ( $status_options['status4'] != '' ) $statuses[4] = array(
																	'color'  => $status_options['status4_color'],
																	'name'   => $status_options['status4'] );
		if ( $status_options['status5'] != '' ) $statuses[5] = array(
																	'color'  => $status_options['status5_color'],
																	'name'   => $status_options['status5'] );
		if ( $status_options['status6'] != '' ) $statuses[6] = array(
																	'color'  => $status_options['status6_color'],
																	'name'   => $status_options['status6'] );

		return apply_filters( 'post_planner_setup_statuses', $statuses );
	}

}