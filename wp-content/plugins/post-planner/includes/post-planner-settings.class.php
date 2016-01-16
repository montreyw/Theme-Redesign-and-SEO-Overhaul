<?php
/**
 * Post Planner Plugin Settings
 *
 * Creates the settings and page to manage the plugin settings
 * @author C.M. Kendrick <cindy@seaserpentstudio.com>
 * @package post-planner
 * @version 1.0
 */

/**
 * Settings class, based on class from Theme.fm (see link)
 * @package post-planner
 * @subpackage includes
 * @link http://theme.fm/2011/10/how-to-create-tabs-with-the-settings-api-in-wordpress-2590/
 */
class PostPlanner_Settings {

	public $general_key        = 'PostPlanner_general';
	public $advanced_key       = 'PostPlanner_advanced';
	public $status_key         = 'PostPlanner_status';
	public $checklist_key      = 'PostPlanner_checklist';
	public $plugin_key         = 'post-planner-settings';
	public $plugin_tabs        = array();
	public $general_settings   = array();
	public $advanced_settings  = array();
	public $status_settings    = array();
	public $checklist_settings = array();

	function __construct() {
		add_action( 'admin_init', array( $this, 'load_settings' ) );
		add_action( 'admin_init', array( $this, 'register_general_settings' ) );
		add_action( 'admin_init', array( $this, 'register_advanced_settings' ) );
		add_action( 'admin_init', array( $this, 'register_status_settings' ) );
		if ( PostPlanner_Loader::$settings['checklist'] == 1 ) add_action( 'admin_init', array( $this, 'register_checklist_settings' ) );
		add_action( 'admin_init', array( $this, 'register_importexport_settings' ) );
		add_action( 'admin_menu', array( $this, 'add_admin_menus' ) );
	}

	function load_settings() {
		$this->general_settings    = get_option( $this->general_key );
		$this->advanced_settings   = get_option( $this->advanced_key );
		$this->status_settings     = get_option( $this->status_key );
		$this->checklist_settings  = get_option( $this->checklist_key );
	}

	function section_general_desc() {

	}

	function section_general_modules_desc() {
		echo '<strong>';
		esc_html_e( 'Choose which features you would like to be enabled.', 'post_planner' );
		echo '</strong>';
	}

	function section_advanced_desc() {
		echo '<strong>';
		esc_html_e( 'Customize your Planner', 'post-planner' );
		echo '</strong>';
	}

	function section_advanced_email_desc() {
		echo '<strong>';
		esc_html_e( 'Configure these settings to be able to email Planner assignments to assigned users.', 'post-planner' );
		echo '</strong>';
	}

	function section_status_desc() {
		esc_html_e( 'If you need less than six statuses, leave some of the fields blank. You can also assign a color to each status that will be used in the Dashboard Widget.', 'post-planner' );
	}

	function section_checklist_desc() {
		esc_html_e( 'These will be used for each Planner. If you need less than 10 items, leave some of the fields blank.', 'post-planner' );
	}

	function register_general_settings() {
		$this->plugin_tabs[$this->general_key] = esc_attr__( 'Post Planner Settings', 'post-planner' );
		$completed_label = ( is_plugin_active( 'cleverness-to-do-list/cleverness-to-do-list.php' ) ? __( 'Show Completed Cleverness To-Do List Items', 'post-planner') : '' );

		register_setting( $this->general_key, $this->general_key, array( $this, 'validate_input' ) );
		add_settings_section( 'section_general', esc_attr__( 'Post Planner Settings', 'post-planner' ), array( $this, 'section_general_desc' ), $this->general_key );
		add_settings_field( 'post_types', esc_attr__( 'Use for these Post Types', 'post-planner' ), array( $this, 'post_types_option' ), $this->general_key, 'section_general' );
		add_settings_field( 'admin_bar', esc_attr__( 'Show Admin Bar Menu', 'post-planner' ), array( $this, 'admin_bar_option' ), $this->general_key, 'section_general' );

		add_settings_section( 'section_general_modules', esc_attr__( 'Configure Modules', 'post-planner' ), array( $this, 'section_general_modules_desc' ), $this->general_key );
		add_settings_field( 'duedate', esc_attr__( 'Due Date', 'post-planner' ), array( $this, 'module_option' ), $this->general_key, 'section_general_modules', array( 'label_for' => 'duedate' ) );
		add_settings_field( 'assignments', esc_attr__( 'Assignments', 'post-planner' ), array( $this, 'module_option' ), $this->general_key, 'section_general_modules', array( 'label_for' => 'assignments' ) );
		add_settings_field( 'references', esc_attr__( 'References', 'post-planner' ), array( $this, 'module_option' ), $this->general_key, 'section_general_modules', array( 'label_for' => 'references' ) );
		add_settings_field( 'files', esc_attr__( 'Files', 'post-planner' ), array( $this, 'module_option' ), $this->general_key, 'section_general_modules', array( 'label_for' => 'files' ) );
		add_settings_field( 'images', esc_attr__( 'Images', 'post-planner' ), array( $this, 'module_option' ), $this->general_key, 'section_general_modules', array( 'label_for' => 'images' ) );
		add_settings_field( 'checklist', esc_attr__( 'Post Checklist', 'post-planner' ), array( $this, 'module_option' ), $this->general_key, 'section_general_modules', array( 'label_for' => 'checklist' ) );
		add_settings_field( 'comments', esc_attr__( 'Comments', 'post-planner' ), array( $this, 'module_option' ), $this->general_key, 'section_general_modules', array( 'label_for' => 'comments' ) );
		add_settings_field( 'ctdl', __( 'Integrate with Cleverness To-Do List', 'post-planner' ), array( $this, 'ctdl_option' ), $this->general_key, 'section_general' );
		add_settings_field( 'ctdl_completed', $completed_label, array( $this, 'ctdl_completed_option' ), $this->general_key, 'section_general' );
		do_action( 'post_planner_settings_general' );
	}

	function post_types_option() {
		$excluded_types = apply_filters( 'post_planner_types_array', array( 'planner' ) );
		$settings = ( isset( $this->general_settings['post_types'] ) ? $this->general_settings['post_types'] : '' );
		$args = array(
			'public'   => true,
			'show_ui'  => true,
		);
		$post_types = get_post_types( $args, 'objects' );
		foreach ( $post_types as $post_type ) {
			if ( !in_array( $post_type->name, $excluded_types ) ) {
				echo '<input type="checkbox" name="'.$this->general_key.'[post_types][]"';
				if ( in_array( $post_type->name, explode( ',', $settings ) ) ) echo ' checked="checked"';
				echo ' value="'.esc_attr( $post_type->name ).'" /> '.$post_type->labels->singular_name.' &nbsp; ';
			}
		}
	}

	function admin_bar_option() {
		?>
	<select name="<?php echo $this->general_key; ?>[admin_bar]">
		<option value="1"<?php if ( $this->general_settings['admin_bar'] == 1 ) echo ' selected="selected"'; ?>><?php esc_attr_e( 'Yes', 'post-planner' ); ?>&nbsp;</option>
		<option value="0"<?php if ( $this->general_settings['admin_bar'] == 0 ) echo ' selected="selected"'; ?>><?php esc_attr_e( 'No', 'post-planner' ); ?></option>
	</select>
	<?php
	}

	function module_option( $args ) { ?>
		<select name="<?php echo $this->general_key; ?>[<?php echo $args['label_for']; ?>]" id="<?php echo $this->general_key; ?>[<?php echo $args['label_for']; ?>]" class="post-planner-module-option">
			<option value="0"<?php if ( $this->general_settings[$args['label_for']] == 0 ) echo ' selected="selected"'; ?>><?php esc_attr_e( 'Disabled', 'post-planner' ); ?></option>
			<option value="1"<?php if ( $this->general_settings[$args['label_for']] == 1 ) echo ' selected="selected"'; ?>><?php esc_attr_e( 'Enabled', 'post-planner' ); ?></option>
		</select>
	<?php }

	function ctdl_option() {
		if ( is_plugin_active( 'cleverness-to-do-list/cleverness-to-do-list.php' ) ) :
			?>
		<select name="<?php echo $this->general_key; ?>[ctdl]">
			<option value="1" <?php selected( $this->general_settings['ctdl'], 1 ); ?>><?php _e( 'Yes', 'post-planner' ); ?>
				&nbsp;</option>
			<option value="0" <?php selected( $this->general_settings['ctdl'], 0 ); ?>><?php _e( 'No', 'post-planner' ); ?></option>
		</select>
		<?php else : ?>
			<input type="hidden" name="<?php echo $this->general_key; ?>[ctdl]" value="0" />
			<a href="<?php echo admin_url( 'plugin-install.php?tab=search&type=term&s=Cleverness+To-Do+List&plugin-search-input=Search+Plugins' ); ?>" class="button-secondary"><?php esc_html_e( 'Download Plugin', 'post-planner' ); ?></a>
			<span class="description">Learn about my free <a href="http://wordpress.org/extend/plugins/cleverness-to-do-list/">To-Do List plugin</a></span>
		<?php
		endif;
	}

	function ctdl_completed_option() {
		if ( is_plugin_active( 'cleverness-to-do-list/cleverness-to-do-list.php' ) ) :
			?>
			<select name="<?php echo $this->general_key; ?>[ctdl_completed]">
				<option value="1" <?php selected( $this->general_settings['ctdl_completed'], 1 ); ?>><?php _e( 'Yes', 'post-planner' ); ?>
					&nbsp;</option>
				<option value="0" <?php selected( $this->general_settings['ctdl_completed'], 0 ); ?>><?php _e( 'No', 'post-planner' ); ?></option>
			</select>
		<?php else : ?>
			<input type="hidden" name="<?php echo $this->general_key; ?>[ctdl_completed]" value="0" />
		<?php
		endif;
	}

	function register_advanced_settings() {
		$this->plugin_tabs[$this->advanced_key] = esc_attr__( 'Advanced', 'post-planner' );

		register_setting( $this->advanced_key, $this->advanced_key, array( $this, 'validate_input' ) );
		add_settings_section( 'section_advanced', esc_attr__( 'Post Planner Advanced Settings', 'post-planner' ), array( $this, 'section_advanced_desc' ), $this->advanced_key );
		add_settings_field( 'date_format', esc_attr__( 'Date Format', 'post-planner' ), array( $this, 'date_format_option' ), $this->advanced_key, 'section_advanced' );
		add_settings_field( 'allowed_roles', esc_attr( 'User Roles Allowed Access', 'post-planner' ), array( $this, 'roles_option' ), $this->advanced_key, 'section_advanced', array( 'label_for' => 'allowed_roles' ) );
		add_settings_field( 'user_roles', esc_attr__( 'User Roles for Assignment Field', 'post-planner' ), array( $this, 'roles_option' ), $this->advanced_key, 'section_advanced', array( 'label_for' => 'user_roles' ) );
		add_settings_field( 'disable_user_roles', esc_attr__( 'Disable Default User Roles', 'post-planner' ), array( $this, 'disable_user_roles_option' ), $this->advanced_key, 'section_advanced' );
		do_action( 'post_planner_settings_advanced' );

		add_settings_section( 'section_advanced_email', esc_attr__( 'Email Settings', 'post-planner' ), array( $this, 'section_advanced_email_desc' ), $this->advanced_key );
		add_settings_field( 'email_assigned', esc_attr__( 'Email Assignments to User', 'post-planner' ), array( $this, 'email_assigned_option' ), $this->advanced_key, 'section_advanced_email' );
		add_settings_field( 'email_category', esc_attr__( 'Add Category to Subject', 'post-planner' ), array( $this, 'email_category_option' ), $this->advanced_key, 'section_advanced_email' );
		add_settings_field( 'email_show_assigned_by', esc_attr__( 'Show Planner Creator in Email', 'post-planner' ), array( $this, 'email_show_assigned_by_option' ), $this->advanced_key, 'section_advanced_email' );
		add_settings_field( 'email_from', esc_attr__( 'From Field', 'post-planner' ), array( $this, 'email_from_option' ), $this->advanced_key, 'section_advanced_email' );
		add_settings_field( 'email_from_email', esc_attr__( 'From Email', 'post-planner' ), array( $this, 'email_from_email_option' ), $this->advanced_key, 'section_advanced_email' );
		add_settings_field( 'email_subject', esc_attr__( 'Subject Field', 'post-planner' ), array( $this, 'email_subject_option' ), $this->advanced_key,
			'section_advanced_email' );
		add_settings_field( 'email_text', esc_attr__( 'Email Text', 'post-planner' ), array( $this, 'email_text_option' ), $this->advanced_key, 'section_advanced_email' );
	}

	function date_format_option() {
		?>
	<input class="small-text" type="text" name="<?php echo $this->advanced_key; ?>[date_format]" value="<?php echo sanitize_text_field( $this->advanced_settings['date_format'] ); ?>" /><br />
	<a href="http://codex.wordpress.org/Formatting_Date_and_Time"><?php esc_attr_e( 'Documentation on Date Formatting', 'post-planner' ); ?></a>
	<?php
	}

	function roles_option( $args ) {
		$editable_roles = get_editable_roles();
		foreach ( $editable_roles as $role => $details ) {
			$name = translate_user_role( $details['name'] );
			echo '<input type="checkbox" name="'.$this->advanced_key.'['.$args['label_for'].'][]"';
			if ( in_array( $role, explode( ',', $this->advanced_settings[$args['label_for']] ) ) ) echo ' checked="checked"';
			echo ' value="'.esc_attr( $role ).'" /> '.$name.' &nbsp; ';
		}
		?>
		<br /><a href="http://codex.wordpress.org/Roles_and_Capabilities"><?php esc_attr_e( 'Documentation on User Roles', 'post-planner' ); ?></a>
	<?php
	}

	function disable_user_roles_option() {
		?>
        <select name="<?php echo $this->advanced_key; ?>[disable_user_roles]">
            <option value="1" <?php selected( $this->advanced_settings['disable_user_roles'], 1 ); ?>><?php _e( 'Yes', 'post-planner' ); ?>
                &nbsp;</option>
            <option value="0" <?php selected( $this->advanced_settings['disable_user_roles'], 0 ); ?>><?php _e( 'No', 'post-planner' ); ?></option>
        </select>
        <span class="description"><?php _e( 'If set to Yes, you must use a separate plugin to manage user role access for non-admin users.<br />By default, this plugin allows all users to have the same access.<br />
        You can use a plugin such as <a href="http://wordpress.org/extend/plugins/members/">Members</a> or <a href="http://wordpress.org/extend/plugins/user-role-editor/">User Role Editor</a> to set up custom access.', 'post-planner' ); ?></span>
	<?php
	}

	function email_assigned_option() {
		?>
	<select name="<?php echo $this->advanced_key; ?>[email_assigned]">
		<option value="0"<?php if ( $this->advanced_settings['email_assigned'] == 0 ) echo ' selected="selected"'; ?>><?php esc_attr_e( 'No', 'post-planner' ); ?>
			&nbsp;</option>
		<option value="1"<?php if ( $this->advanced_settings['email_assigned'] == 1 ) echo ' selected="selected"'; ?>><?php esc_attr_e( 'Yes', 'post-planner' ); ?></option>
	</select>
	<?php
	}

	function email_category_option() {
		?>
	<select name="<?php echo $this->advanced_key; ?>[email_category]">
		<option value="0"<?php if ( $this->advanced_settings['email_category'] == 0 ) echo ' selected="selected"'; ?>><?php esc_attr_e( 'No', 'post-planner' ); ?>
			&nbsp;</option>
		<option value="1"<?php if ( $this->advanced_settings['email_category'] == 1 ) echo ' selected="selected"'; ?>><?php esc_attr_e( 'Yes', 'post-planner' ); ?></option>
	</select>
	<?php
	}

	function email_show_assigned_by_option() {
		?>
	<select name="<?php echo $this->advanced_key; ?>[email_show_assigned_by]">
		<option value="0"<?php if ( $this->advanced_settings['email_show_assigned_by'] == 0 ) echo ' selected="selected"'; ?>><?php esc_attr_e( 'No', 'post-planner' ); ?>
			&nbsp;</option>
		<option value="1"<?php if ( $this->advanced_settings['email_show_assigned_by'] == 1 ) echo ' selected="selected"'; ?>><?php esc_attr_e( 'Yes', 'post-planner' ); ?></option>
	</select>
	<?php
	}

	function email_from_option() {
		?>
	<input class="regular-text" type="text" name="<?php echo $this->advanced_key; ?>[email_from]" value="<?php echo sanitize_text_field( $this->advanced_settings['email_from'] ); ?>" />
	<?php
	}

	function email_from_email_option() {
		?>
		<input class="regular-text" type="text" name="<?php echo $this->advanced_key; ?>[email_from_email]" value="<?php echo sanitize_text_field( $this->advanced_settings['email_from_email'] ); ?>" />
	<?php
	}

	function email_subject_option() {
		?>
	<input class="regular-text" type="text" name="<?php echo $this->advanced_key; ?>[email_subject]" value="<?php echo sanitize_text_field( $this->advanced_settings['email_subject'] ); ?>" />
	<?php
	}

	function email_text_option() {
		?>
	<textarea name="<?php echo $this->advanced_key; ?>[email_text]" rows="3" cols="70"><?php echo esc_textarea( $this->advanced_settings['email_text'] ); ?></textarea>
	<?php
	}

	function register_status_settings() {
		$this->plugin_tabs[$this->status_key] = esc_attr__( 'Statuses', 'post-planner' );

		register_setting( $this->status_key, $this->status_key, array( $this, 'validate_input' ) );
		add_settings_section( 'section_status', esc_attr__( 'Setup Custom Planner Statuses', 'post-planner' ), array( $this, 'section_status_desc' ), $this->status_key );
		add_settings_field( 'status1', esc_attr__( 'Status #1', 'post-planner' ), array( $this, 'status_option' ), $this->status_key, 'section_status', array( 'label_for' => 'status1' ) );
		add_settings_field( 'status1_color', '', array( $this, 'status_color_option' ), $this->status_key, 'section_status', array( 'label_for' => 'status1_color' ) );
		add_settings_field( 'status2', esc_attr__( 'Status #2', 'post-planner' ), array( $this, 'status_option' ), $this->status_key, 'section_status', array( 'label_for' => 'status2' ) );
		add_settings_field( 'status2_color', '', array( $this, 'status_color_option' ), $this->status_key, 'section_status', array( 'label_for' => 'status2_color' ) );
		add_settings_field( 'status3', esc_attr__( 'Status #3', 'post-planner' ), array( $this, 'status_option' ), $this->status_key, 'section_status', array( 'label_for' => 'status3' ) );
		add_settings_field( 'status3_color', '', array( $this, 'status_color_option' ), $this->status_key, 'section_status', array( 'label_for' => 'status3_color' ) );
		add_settings_field( 'status4', esc_attr__( 'Status #4', 'post-planner' ), array( $this, 'status_option' ), $this->status_key, 'section_status', array( 'label_for' => 'status4' ) );
		add_settings_field( 'status4_color', '', array( $this, 'status_color_option' ), $this->status_key, 'section_status', array( 'label_for' => 'status4_color' ) );
		add_settings_field( 'status5', esc_attr__( 'Status #5', 'post-planner' ), array( $this, 'status_option' ), $this->status_key, 'section_status', array( 'label_for' => 'status5' ) );
		add_settings_field( 'status5_color', '', array( $this, 'status_color_option' ), $this->status_key, 'section_status', array( 'label_for' => 'status5_color' ) );
		add_settings_field( 'status6', esc_attr__( 'Status #6', 'post-planner' ), array( $this, 'status_option' ), $this->status_key, 'section_status', array( 'label_for' => 'status6' ) );
		add_settings_field( 'status6_color', '', array( $this, 'status_color_option' ), $this->status_key, 'section_status', array( 'label_for' => 'status6_color' ) );
		do_action( 'post_planner_settings_statuses' );
	}

	function status_option( $args ) {
		?>
		<input class="all-options" type="text" name="<?php echo $this->status_key; ?>[<?php echo $args['label_for']; ?>]" value="<?php echo sanitize_text_field( $this->status_settings[$args['label_for']] ); ?>" />
	<?php
	}

	function status_color_option( $args ) {
		?>
		<div class="post-planner-color-picker-div">
			<div class="post-planner-color-sample" style="background-color: <?php echo $this->status_settings[$args['label_for']]; ?>;"></div>
			<input type="text" name="<?php echo $this->status_key; ?>[<?php echo $args['label_for']; ?>]" value="<?php echo sanitize_text_field( $this->status_settings[$args['label_for']] ); ?>" />
			<input type="button" class="post-planner-pickcolor button-secondary" value="<?php esc_attr_e( 'Select Color' ) ?>" />
			<div class="post-planner-colorpicker"></div>
		</div>
	<?php
	}

	function register_checklist_settings() {
		$this->plugin_tabs[$this->checklist_key] = esc_attr__( 'Checklist Items', 'post-planner' );

		register_setting( $this->checklist_key, $this->checklist_key, array( $this, 'validate_input' ) );
		add_settings_section( 'section_checklist', esc_attr__( 'Setup Checklist Items', 'post-planner' ), array( $this, 'section_checklist_desc' ), $this->checklist_key );
		add_settings_field( 'checklist1', esc_attr__( 'Checklist Item #1', 'post-planner' ), array( $this, 'checklist_option' ), $this->checklist_key, 'section_checklist', array( 'label_for' => 'checklist1' ) );
		add_settings_field( 'checklist2', esc_attr__( 'Checklist Item #2', 'post-planner' ), array( $this, 'checklist_option' ), $this->checklist_key, 'section_checklist', array( 'label_for' => 'checklist2' ) );
		add_settings_field( 'checklist3', esc_attr__( 'Checklist Item #3', 'post-planner' ), array( $this, 'checklist_option' ), $this->checklist_key, 'section_checklist', array( 'label_for' => 'checklist3' ) );
		add_settings_field( 'checklist4', esc_attr__( 'Checklist Item #4', 'post-planner' ), array( $this, 'checklist_option' ), $this->checklist_key, 'section_checklist', array( 'label_for' => 'checklist4' ) );
		add_settings_field( 'checklist5', esc_attr__( 'Checklist Item #5', 'post-planner' ), array( $this, 'checklist_option' ), $this->checklist_key, 'section_checklist', array( 'label_for' => 'checklist5' ) );
		add_settings_field( 'checklist6', esc_attr__( 'Checklist Item #6', 'post-planner' ), array( $this, 'checklist_option' ), $this->checklist_key, 'section_checklist', array( 'label_for' => 'checklist6' ) );
		add_settings_field( 'checklist7', esc_attr__( 'Checklist Item #7', 'post-planner' ), array( $this, 'checklist_option' ), $this->checklist_key, 'section_checklist', array( 'label_for' => 'checklist7' ) );
		add_settings_field( 'checklist8', esc_attr__( 'Checklist Item #8', 'post-planner' ), array( $this, 'checklist_option' ), $this->checklist_key, 'section_checklist', array( 'label_for' => 'checklist8' ) );
		add_settings_field( 'checklist9', esc_attr__( 'Checklist Item #9', 'post-planner' ), array( $this, 'checklist_option' ), $this->checklist_key, 'section_checklist', array( 'label_for' => 'checklist9' ) );
		add_settings_field( 'checklist10', esc_attr__( 'Checklist Item #10', 'post-planner' ), array( $this, 'checklist_option' ), $this->checklist_key, 'section_checklist', array( 'label_for' => 'checklist10' ) );
		do_action( 'post_planner_settings_checklist' );
	}

	function checklist_option( $args ) {
		?>
	<input class="all-options" type="text" name="<?php echo $this->checklist_key; ?>[<?php echo $args['label_for']; ?>]" value="<?php echo sanitize_text_field( $this->checklist_settings[$args['label_for']] ); ?>" />
	<?php
	}

	function register_importexport_settings() {
		$this->plugin_tabs['importexport'] = esc_attr__( 'Import/Export', 'post-planner' );

		if ( isset( $_GET['planner_message'] ) ) {
			switch ( $_GET['planner_message'] ) {
				case 1:
					$planner_message = esc_attr__( 'Settings Imported', 'post-planner' );
					break;
				case 2:
					$planner_message = esc_attr__( 'Invalid Settings File', 'post-planner' );
					break;
				case 3:
					$planner_message = esc_attr__( 'No Settings File Selected', 'post-planner' );
					break;
				default:
					$planner_message = '';
					break;
			}
		}

		if ( isset( $planner_message ) && $planner_message != '' ) {
			echo '<div class="updated"><p>'.$planner_message.'</p></div>';
		}

		// export settings
		if ( isset( $_GET['post-planner-settings-export'] ) ) {
			header( "Content-Disposition: attachment; filename=post-planner-settings.txt" );
			header( 'Content-Type: text/plain; charset=utf-8' );
			$general   = get_option( 'PostPlanner_general' );
			$advanced  = get_option( 'PostPlanner_advanced' );
			$status    = get_option( 'PostPlanner_status' );
			$checklist = get_option( 'PostPlanner_checklist' );

			echo "[START=POST PLANNER SETTINGS]\n";
			foreach ( $general as $id => $text )
				echo "g:$id\t".json_encode( $text )."\n";
			foreach ( $advanced as $id => $text )
				echo "a:$id\t".json_encode( $text )."\n";
			foreach ( $status as $id => $text )
				echo "s:$id\t".json_encode( $text )."\n";
			foreach ( $checklist as $id => $text )
				echo "c:$id\t".json_encode( $text )."\n";
			echo "[STOP=POST PLANNER SETTINGS]";
			exit;
		}

		// import settings
		if ( isset( $_POST['post-planner-settings-import'] ) ) {
			$message = '';
			if ( $_FILES['post-planner-settings-import-file']['tmp_name'] ) {
				$import = explode( "\n", file_get_contents( $_FILES['post-planner-settings-import-file']['tmp_name'] ) );
				if ( array_shift( $import ) == "[START=POST PLANNER SETTINGS]" && array_pop( $import ) == "[STOP=POST PLANNER SETTINGS]" ) {
					foreach ( $import as $import_option ) {
						list( $key, $value ) = explode( "\t", $import_option );
						list( $prefix, $option ) = explode( ':', $key );
						switch ( $prefix ) {
							case 'g':
								$general_options[$option] = json_decode( sanitize_text_field( $value ) );
								break;
							case 'a':
								$advanced_options[$option] = json_decode( sanitize_text_field( $value ) );
								break;
							case 's':
								$status_options[$option] = json_decode( sanitize_text_field( $value ) );
								break;
							case 'c':
								$checklist_options[$option] = json_decode( sanitize_text_field( $value ) );
								break;
							default:
								break;
						}
					}
					update_option( 'PostPlanner_general', $general_options );
					update_option( 'PostPlanner_advanced', $advanced_options );
					update_option( 'PostPlanner_status', $status_options );
					update_option( 'PostPlanner_checklist', $checklist_options );

					$planner_message = 1;
				} else {
					$planner_message = 2;
				}
			}
			else {
				$planner_message = 3;
			}

			wp_redirect( admin_url( '/options-general.php?page=post-planner-settings&tab=importexport&planner_message='.$planner_message ) );
			exit;
		}
	}

	function validate_input( $input ) {
		$output = array();

		foreach ( $input as $key => $value ) {

			if ( isset( $input[$key] ) ) {
				if ( $key == 'user_roles' || $key == 'allowed_roles' || $key == 'post_types' ) {
					if ( is_array( $value ) ) {
						$output[$key] = implode( ',', $input[$key] );
					} else {
						$output[$key] = strip_tags( stripslashes( $input[$key] ) );
					}
				} else {
					$output[$key] = strip_tags( stripslashes( $input[$key] ) );
				}
			}
		}

		return $output;
	}

	function add_admin_menus() {
		add_options_page( esc_attr__( 'Post Planner', 'post-planner' ), esc_attr__( 'Post Planner', 'post-planner' ), 'manage_options', 'post-planner-settings', array( $this, 'plugin_options_page' ) );
	}

	/*
	 * Plugin Options page rendering goes here, checks
	 * for active tab and replaces key with the related
	 * settings key. Uses the plugin_options_tabs method
	 * to render the tabs.
	 */
	function plugin_options_page() {
		$tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $this->general_key;
		?>
	<div class="wrap">
		<?php $this->plugin_options_tabs(); ?>
		<form method="post" action="options.php" enctype="multipart/form-data">
			<?php wp_nonce_field( 'update-options' ); ?>
			<?php settings_fields( $tab ); ?>
			<?php do_settings_sections( $tab ); ?>
			<?php if ( $tab == 'importexport' ) $this->importexport_fields(); ?>
			<?php if ( $tab != 'importexport' ) submit_button(); ?>
		</form>
	</div>
	<?php
		add_action( 'in_admin_footer', 'PostPlanner_Lib::admin_footer' );
	}

	/*
	 * Renders our tabs in the plugin options page,
	 * walks through the object's tabs array and prints
	 * them one by one. Provides the heading for the
	 * plugin_options_page method.
	 */
	function plugin_options_tabs() {
		$current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $this->general_key;

		echo '<div class="icon32"><img src="' . POSTPLANNER_PLUGIN_URL . '/images/notebook-32.png" alt="" /></div>';
		echo '<h2 class="nav-tab-wrapper">';
		foreach ( $this->plugin_tabs as $tab_key => $tab_caption ) {
			$active = $current_tab == $tab_key ? 'nav-tab-active' : '';
			echo '<a class="nav-tab ' . $active . '" href="?page=' . $this->plugin_key . '&amp;tab=' . $tab_key . '">' . $tab_caption . '</a>';
		}
		echo '</h2>';
	}

	function importexport_fields() {
		?>
		<h3><?php esc_html_e( 'Import/Export Settings', 'post-planner' ); ?></h3>

		<p><a class="submit button" href="?post-planner-settings-export"><?php esc_attr_e( 'Export Settings', 'post-planner' ); ?></a></p>

		<p>
			<input type="hidden" name="post-planner-settings-import" id="post-planner-settings-import" value="true" />
			<?php submit_button( esc_attr__( 'Import Settings', 'post-planner' ), 'button', 'post-planner-settings-submit', false ); ?>
			<input type="file" name="post-planner-settings-import-file" id="post-planner-settings-import-file" />
		</p>

	<?php
	}

}