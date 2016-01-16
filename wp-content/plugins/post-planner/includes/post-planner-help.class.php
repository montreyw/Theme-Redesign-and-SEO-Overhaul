<?php
/**
 * Post Planner Plugin Help
 *
 * Creates the help tabs and displays the help content
 * @author C.M. Kendrick <cindy@seaserpentstudio.com>
 * @package post-planner
 * @version 1.4
 */

/**
 * Help tabs class
 * @package post-planner
 * @subpackage includes
 */
class PostPlanner_Help {

	/**
	 * Creates the Help tab
	 * @static
	 * @return mixed
	 */
	public static function help_tab() {
		$screen = get_current_screen();

		$post_planner_help_sidebar = '<p><a href="http://seaserpentstudio.ticksy.com/" target="_blank">' .esc_html__( 'Plugin Support', 'post-planner' ) . '</a></p>
		<p><a href="http://seaserpentstudio.com/post-planner/documentation/" target="_blank">'.esc_html__( 'Plugin Documentation', 'post-planner' ).'</a></p>
		';

		if ( $screen->post_type == 'planner' || $screen->id == 'settings_page_post-planner-settings' ) {

			$screen->add_help_tab( array(
				'id'           => 'post_planner_help_tab',
				'title'        => esc_attr__( 'Post Planner Help', 'post-planner' ),
				'callback'     => __CLASS__.'::post_planner_help',
			) );

			$screen->add_help_tab( array(
				'id'            => 'post_planner_faqs_tab',
				'title'         => esc_attr__( 'FAQs', 'post_planner' ),
				'callback'      => __CLASS__.'::post_planner_faqs_help',
			) );

			$screen->add_help_tab( array(
				'id'       => 'post_planner_customization_tab',
				'title'    => esc_attr__( 'Customization', 'post_planner' ),
				'callback' => __CLASS__.'::post_planner_customization_help',
			) );

			$screen->add_help_tab( array(
				'id'       => 'post_planner_ctdl_tab',
				'title'    => __( 'To-Do List Integration', 'post_planner' ),
				'callback' => __CLASS__.'::post_planner_ctdl_help',
			) );

			$screen->set_help_sidebar( $post_planner_help_sidebar );

		}
	}

	/**
	 * Creates the main help content
	 * @static
	 */
	public static function post_planner_help() {
		?>
	<h3><?php esc_html_e( 'Post Planner', 'post-planner' ); ?></h3>
	<p>There will be a new menu item under Settings after activating the plugin called <strong>Post Planner</strong>. Visit this page first.</p>

		<p>Here you can enable and disable various features, set up what post types and user roles you want to use, set your custom statuses and your custom checklists,
		plus import and export settings from one WordPress installation to another.</p>

		<p>Click on the <strong>Planner</strong> menu item to get started using Post Planner. It should be somewhere near your Posts menu item. Click on Add New and get started.</p>

		<p>After you create your first Planner, you can choose to create a new post or associate an existing post with that Planner. Once a Planner is associated with a post,
		a Post Planner box will appear on the page when you edit that post. It will show up by default underneath the content editor.</p>

		<p>This plugin also includes a Dashboard Widget and a front-end widget. The Dashboard Widget appears automatically on your WordPress Dashboard. You can hide it using the Screen Options
		pull-down menu. Visit Appearance > Widgets to add the front-end widget to your site.</p>
	<?php
	}

	/**
	 * Creates the FAQs help section
	 * @static
	 */
	public static function post_planner_faqs_help() {
		?>
	<h3><?php esc_html_e( 'Frequently Asked Questions', 'post-planner' ); ?></h3>

    <p><strong><?php esc_html_e( 'How can I change who can read/add/edit/delete Planners? ', 'post-planner' ); ?></strong><br />
        If you want to prevent them from access Planners entirely, uncheck the user role from under Settings > Advanced > User Roles Allowed Access.</p>
    <p>If you want to use an external role editor plugin to manage user access, set Settings > Advanced > Disable Default User Roles to Yes and configure your plugin of choice to set the Planner's capabilities. The plugin's capabilities end in _planner or _planners.
        <a href="http://wordpress.org/extend/plugins/members/">Members</a> or <a href="http://wordpress.org/extend/plugins/user-role-editor/">User Role Editor</a> are two plugins that can do this.
    </p>

	<p><strong><?php esc_html_e( 'Why is the checklist not showing up?', 'post-planner' ); ?></strong><br />
		<?php esc_html_e( 'You need to set up the checklist items under Settings > Post Planner > Checklist Items.', 'post-planner' ); ?>
	</p>

	<p><strong><?php esc_html_e( 'How do I change the Status choices?', 'post-planner' ); ?></strong><br />
		<?php esc_html_e( 'You can change the Status choices under Settings > Post Planner > Statuses. The first choice is the default choice.', 'post-planner' ); ?>
	</p>

	<p><strong><?php esc_html_e( 'How I export the Planners or Settings?', 'post-planner' ); ?></strong><br />
		<?php esc_html_e( 'You can export the Settings from Settings > Post Planner > Import/Export.
		You will need to use the default WordPress import/export feature under Tools to export the Post Planners.', 'post-planner' ); ?>
	</p>

	<p><strong><?php esc_html_e( 'What should I do if I find a bug?', 'post-planner' ); ?></strong><br/>
		<?php esc_html_e( 'Visit the ticket support system website.', 'post-planner' ); ?><br/>
		<a href="http://seaserpentstudio.ticksy.com/" target="_blank">http://seaserpentstudio.ticksy.com/</a>
	</p>
	<?php
	}

	/**
	 *Creates the customization help section
	 *@statis
	 *@since 1.4
	 */
	public static function post_planner_customization_help() {
		?>
		<h3><?php esc_html_e( 'Customizing This Plugin', 'post-planner' ); ?></h3>
		<p>I’ve included an number of <a href="http://seaserpentstudio.com/post-planner/hooks-and-filters/">hooks and filters</a> in this plugin to provide you with an opportunity to
			easily customize it.</p>
		<p>Amoung other things, you can easily:
		<ul>
			<li>Rename Various Field Labels</li>
			<li>Add More Status Options</li>
			<li>Add Additional Checklist Items</li>
			<li>Restrict the Posts that are listed in the Associate Content box</li>
			<li>Show Additional Cleverness To-Do List Fields</li>
		</ul></p>
		<p><a href="http://seaserpentstudio.com/post-planner/customizing/">Read more about how to customize this plugin.</a></p>
	<?php
	}

	/**
	 * Creates the to-do list help section
	 * @static
	 * @since 1.1
	 */
	public static function post_planner_ctdl_help() {
		?>
	<h3><?php esc_html_e( 'Cleverness To-Do List Integration', 'post-planner' ); ?></h3>

	<p>You can use my free <a href="http://wordpress.org/extend/plugins/cleverness-to-do-list/">Cleverness To-Do List Plugin</a> to create custom to-do lists for your Post Planners.</p>

	<p>The Cleverness To-Do List plugin provides users with a to-do list feature.</p>

	<p>You can configure the plugin to have private to-do lists for each user, to have all users share a to-do list, or
		to have a master list with individual completion of items. The shared to-do list has a variety of settings
		available. You can assign to-do items to a specific user (includes a setting to email a new to-do item to the
		assigned user) and optionally have those items only viewable by that user. You can also assign different
		permission levels using capabilities. There are also settings to show deadline and progress fields. Category
		support is included as well as front-end administration.</p>

	<p>
		<a href="<?php echo admin_url( 'plugin-install.php?tab=search&type=term&s=Cleverness+To-Do+List&plugin-search-input=Search+Plugins' ); ?>" class="button-secondary"><?php esc_html_e( 'Download Plugin', 'post-planner' ); ?></a>
	</p>
	<?php
	}
}