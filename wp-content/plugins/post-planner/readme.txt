=== Post Planner ===
Contributors: Cindy Kendrick (support@seaserpentstudio.com)
Author URI: http://seaserpentstudio.com
Plugin URI: http://seaserpentstudio.com/plugins/post-planner
Requires at least: 3.3
Tested up to: 3.6
Stable tag: 1.4

== Description ==

This plugin provides users with an editorial assignment feature and post planning utility.

http://seaserpentstudio.com/plugins/post-planner/

== Installation ==

1. Upload the folder '/post-planner/' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure the settings on the Settings page under the Post Planner menu

== License ==

This file is part of Post Planner.

Post Planner is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

Post Planner is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this plugin. If not, see <http://www.gnu.org/licenses/>.

== Frequently Asked Questions ==

= Why is the checklist not showing up? =
You need to set up the checklist items under Settings > Post Planner > Checklist Items.

= How do I change the Status choices? =
You can change the Status choices under Settings > Post Planner > Statuses. The first choice is the default choice.

= How I export the Planners or Settings? =
You can export the Settings from Settings > Post Planner > Import/Export.
You will need to use the default WordPress import/export feature under Tools to export the Post Planners.

= What should I do if I find a bug? =

Visit the ticket support system (http://seaserpentstudio.ticksy.com/)

== Changelog ==

= 1.4 =
* Fixed missed jQuery 1.9 incompatibility
* Added From Email setting
* Added filters for Cleverness To-Do List items: post_planner_todo_meta, post_planner_todo_completed_meta
* Added ability for multiple statuses and categories to be selected in the Dashboard Widget
* Updated Help tab
* Updated Aqua Resizer script
* Updated Upgrade Notifier script

= 1.3 =
* Fixed a bug in the Dashboard for creating an associated post
* Updated to remove deprecated functions for compatibility with jQuery 1.9
* Added option to show completed items for Cleverness To-Do List items

= 1.2.2 =
* Fix label for Type filter
* Fix passing Planner ID to Cleverness To-Do List Plugin
* Fix quickedit plugin fields not saving

= 1.2.1=
* CSS adjustments for WordPress 3.5
* Fix for WPAlchemy docopy for jQuery 1.8.2
* Fix for tabs not opening with jQueryUI 1.9
* Fix setting featured image
* Move labels for filters to dropdown boxes on planner listing
* Add global variable for settings
* Add version to script and style enqueues
* Add filters for important strings that were missing
* Change settings variable to public instead of private

= 1.2 =
* Changed Comment form to use wp_editor
* Changed the default Associated Content post type from post to one based on the Post Type setting
* Fixed Planner showing up on Post screen still even though Planner was deleted
* Fixed error when trying to associate a Post when previously associated Planner was deleted
* Fixed the Associated Content metabox showing up even when no Post Types were selected in Settings
* Added pass Planner ID to Cleverness To-Do List plugin
* Added post_planner_associated_content_args filter to get_posts arguments for Associated Content
* Added the Planner post author being set to the assigned user
* Added setting to disable non-admin user roles being set by the plugin

= 1.1 =
* Fixed bug with saving arrays when exporting Settings
* Fixed issue with undefined function get_current_screen when saving
* Added integration with Cleverness To-Do List plugin

= 1.0.1 =
* Fixed File List and References insert into post JS

= 1.0 =
* First version

== Upgrade Notice ==

= 1.2.1 =
Compatibility with WordPress 3.5, bug fix

= 1.2 =
New features

= 1.1 =
Bug fixes and new feature

= 1.0.1 =
Bug fix

= 1.0 =
First version

== Credits ==

Upgrade Notifier by Pippin Williamson (https://github.com/pippinsplugins/WordPress-Plugin-Update-Notifier-for-Code-Canyon)
Icon by Momentum Design Lab (http://momentumdesignlab.com/resources/downloads/)
WPAlchemy Metabox PHP Class by Dimas Begunoff (http://www.farinspace.com/wpalchemy-metabox/)
File Type Icons by Everaldo Coelho (http://www.everaldo.com/crystal/)
Aqua Resizer by Syamil MJ (http://aquagraphite.com)

== Filters and Hooks ==

= Dashboard Widget =
do_action( 'postplanner_before_dashboard_widget' )
do_action( 'postplanner_after_dashboard_widget' )
do_action( 'post_planner_dashboard_heading' )
do_action( 'post_planner_dashboard_data' )
do_action( 'post_planner_dashboard_settings' )

apply_filters( 'post_planner_dashboard_heading', esc_attr__( 'Post Planner', 'post-planner' ) )
apply_filters( 'post_planner_dashboard_topic_heading', '<th>'.esc_html__( 'Topic', 'post-planner' ).'</th>' )
apply_filters( 'post_planner_dashboard_status_heading', '<th>'.esc_html__( 'Status', 'post-planner' ).'</th>' )
apply_filters( 'post_planner_dashboard_assignment_heading', '<th>'.esc_html__( 'Assigned To', 'post-planner' ).'</th>' )
apply_filters( 'post_planner_dashboard_duedate_heading', '<th>'.esc_html__( 'Due Date', 'post-planner' ).'</th>' )
apply_filters( 'post_planner_dashboard_action_heading', '<th class="{sorter: false} no-sort">'.esc_html__( 'Associated', 'post-planner' ).'</th>' )
apply_filters( 'post_planner_dashboard_topic', '<td class="planner-dashboard-topic"><a href="'.admin_url( 'post.php?post='.$id.'&action=edit' ).'">'.get_the_title().'</a></td>', $id, get_the_title() )
apply_filters( 'post_planner_dashboard_status', '<td>'.sanitize_text_field( PostPlanner_Loader::$statuses[$status_meta]['name'] ).'</td>', PostPlanner_Loader::$statuses[$status_meta]['name'] )
apply_filters( 'post_planner_dashboard_assignment', '<td class="planner-dashboard-author" id="'.$assign_meta.'">'.$assignment.'</td>', $assign_meta, $assignment )
apply_filters( 'post_planner_dashboard_duedate', '<td>'.sanitize_text_field( $duedate_meta ).'</td>', $duedate_meta )
apply_filters( 'post_planner_dashboard_action', '<td><span class="planner-post-type">'.$planner_post_type.'</span>'.$action.'</td>', $planner_post_type, $action )
apply_filters( 'post_planner_dashboard_no_planners', '<tr><td>'.esc_html__( 'No existing post planners', 'post-planner' ).'</td></tr>' );

= Planner Metabox =
do_action( 'post_planner_before_planner_metabox' )
do_action( 'post_planner_after_planner_metabox' )
do_action( 'post_planner_before_details' )
do_action( 'post_planner_after_details' )
do_action( 'post_planner_before_references' )
do_action( 'post_planner_after_references' )
do_action( 'post_planner_before_files' )
do_action( 'post_planner_after_files' )
do_action( 'post_planner_before_images' )
do_action( 'post_planner_after_images' )
do_action( 'post_planner_before_checklist' )
do_action( 'post_planner_after_checklist' )
do_action( 'post_planner_before_comments' )
do_action( 'post_planner_after_comments' )
do_action( 'post_planner_before_reference_metabox' )
do_action( 'post_planner_after_reference_metabox' )
do_action( 'post_planner_before_file_metabox' )
do_action( 'post_planner_after_file_metabox' )
do_action( 'post_planner_before_image_metabox' )
do_action( 'post_planner_after_image_metabox' )
do_action( 'post_planner_before_associated_metabox' )
do_action( 'post_planner_after_associated_metabox' )
do_action( 'post_planner_before_publish_metabox' )
do_action( 'post_planner_after_publish_metabox' )
do_action( 'post_planner_before_checklist_metabox' )
do_action( 'post_planner_after_checklist_metabox' )
do_action( 'post_planner_before_comments_metabox' )
do_action( 'post_planner_after_comments_metabox' )
do_action( 'post_planner_remove_post_meta_boxes' )
do_action( 'post_planner_before_todolist' )
do_action( 'post_planner_after_todolist' )
do_action( 'post_planner_before_todolist_metabox' )
do_action( 'post_planner_after_todolist_metabox' )

apply_filters( 'post_planner_planner_metabox_title', esc_attr__( 'Post Planner', 'post-planner' ) )
apply_filters( 'post_planner_publish_metabox_title', esc_attr__( 'Publish', 'post-planner' ) )
apply_filters( 'post_planner_details_metabox_title', esc_html__( 'Details', 'post-planner' ) )
apply_filters( 'post_planner_images_metabox_title', esc_attr__( 'Images', 'post-planner' ) )
apply_filters( 'post_planner_references_metabox_title', esc_attr__( 'References', 'post-planner' ) )
apply_filters( 'post_planner_files_metabox_title', esc_attr__( 'Files', 'post-planner' ) )
apply_filters( 'post_planner_comments_metabox_title', esc_attr__( 'Comments', 'post-planner' ) )
apply_filters( 'post_planner_checklist_metabox_title', esc_attr__( 'Checklist', 'post-planner' ) )
apply_filters( 'post_planner_todolist_metabox_title', esc_attr__( 'To-Do List', 'post-planner' ) )
apply_filters( 'post_planner_associated_metabox_title', esc_attr__( 'Associated Content', 'post-planner' ) )
apply_filters( 'post_planner_create_planner_link', '<p class="alignright"><a href="" class="button-secondary" id="create-new-planner">'.esc_html__( 'Create Planner', 'post-planner' ).'</a></p>' )
apply_filters( 'post_planner_view_planner_link', '<p class="alignright"><a href="'.admin_url( 'post.php?post='.absint( $planner_id ).'&action=edit' ).'" class="button-secondary">'.esc_html__( 'View Planner', 'post-planner' ).'</a></p>', absint( $planner_id ) )
apply_filters( 'post_planner_display_status', '<p class="post-planner-box">'.esc_html__( 'Status', 'post-planner' ).': '.sanitize_text_field( PostPlanner_Loader::$statuses[$post_planner_publish_mb->get_the_value( 'status' )]['name'] ).'</p>', PostPlanner_Loader::$statuses[$post_planner_publish_mb->get_the_value( 'status' )]['name'] )
apply_filters( 'post_planner_display_duedate', '<p class="post-planner-box">'.esc_html__( 'Due Date', 'post-planner' ).': '.sanitize_text_field( $post_planner_publish_mb->get_the_value( 'duedate' ) ).'</p>', $post_planner_publish_mb->get_the_value( 'duedate' ) );
apply_filters( 'post_planner_display_details', $content )
apply_filters( 'post_planner_display_assignment', '<p class="planner-box">'.esc_html__( 'Assigned To', 'post-planner' ).': '.sanitize_text_field( $assign_user->display_name ).'</p>', $assign_user->display_name )
apply_filters( 'post_planner_references_description', '<p class="description">'.esc_html__( 'Organize the references in the order you want them to appear by dragging and dropping the items. Use the Insert button to add a reference notation for that item. Use Insert List to add a list of all the references.', 'post-planner' ).'</p>' );
apply_filters( 'post_planner_files_description', '<p class="description">'.esc_html__( 'Organize the files in the order you want them to appear by dragging and dropping the items.', 'post-planner' ).'<br />'.__( 'Use the Insert button to add only that specific file. Use Insert List to add a list of all the files.', 'post-planner' ).'</p>' )
apply_filters( 'post_planner_images_description', '<p class="description">'.esc_html__( 'Organize the images in the order you want them to appear by dragging and dropping the items.', 'post-planner' ).'<br />'.esc_html__( 'Use the Insert button to add only that specific image.', 'post-planner' ).( current_theme_supports( 'post-thumbnails' ) ? ' '.esc_html__( 'Use the Star icon to set the image as the Featured Image.', 'post-planner' ) : '' ).' '.esc_html__( 'Use Insert All Images to add all of the images.', 'post-planner' ).'</p>' )
apply_filters( 'post_planner_no_todo_items', esc_html__( 'There are no items to do.', 'post-planner' ) )
apply_filters( 'post_planner_add_todo', esc_html__( 'Add New To-Do Item', 'post-planner' ) )

= Settings =
do_action( 'post_planner_settings_general' )
do_action( 'post_planner_settings_advanced' )
do_action( 'post_planner_settings_statuses' )
do_action( 'post_planner_settings_checklist' )

= Miscellaneous =
do_action( 'post_planner_set_roles' )

apply_filters( 'post_planner_associate_files', true )
apply_filters( 'post_planner_associate_images', true )
apply_filters( 'post_planner_listing_no_duedate', esc_attr__( 'No Due Date', 'post-planner' ) )
apply_filters( 'post_planner_listing_no_assignment', esc_attr__( 'Unassigned', 'post-planner' ) )
apply_filters( 'post_planner_listing_checklist', $completed.'/'.count( PostPlanner_Loader::$checklist ), $completed, PostPlanner_Loader::$checklist )
apply_filters( 'post_planner_setup_statuses', $statuses )
apply_filters( 'post_planner_columns', $columns )
apply_filters( 'post_planner_sortable_columns', $columns )
apply_filters( 'post_planner_category_query', $args )
apply_filters( 'post_planner_query', $args )
apply_filters( 'post_planner_types_array', array( 'planner' ) )
apply_filters( 'post_planner_associated_permission', current_user_can( 'edit_post', $associated_post_id ), $planner_post_type )
apply_filters( 'post_planner_associated_permissions', current_user_can( 'edit_posts' ), $type )
apply_filters( 'post_planner_email_from', get_bloginfo( 'admin_email' ) )
apply_filters( 'post_planner_associated_content_args', $args )
apply_filters( 'post_planner_topic', __( 'Topic', 'post-planner' ) )
apply_filters( 'post_planner_comments', esc_attr__( 'Comments', 'post-planner' ) )
apply_filters( 'post_planner_checklist', esc_attr__( 'Checklist', 'post-planner' ) )
apply_filters( 'post_planner_duedate', esc_html__( 'Due Date', 'post-planner' ) )
apply_filters( 'post_planner_status', esc_html__( 'Status', 'post-planner' ) )
apply_filters( 'post_planner_assignments', esc_html__( 'Assign To', 'post-planner' ) )
apply_filters( 'post_planner_post_type', esc_html__( 'Post Type', 'post-planner' ) )
apply_filters( 'post_planner_category', esc_html__( 'Category', 'post-planner' ) )
apply_filters( 'post_planner_name', _x( 'Planner', 'post type general name', 'post-planner' ) )
apply_filters( 'post_planner_singular_name', _x( 'Planner', 'post type singular name', 'post-planner' ) )
apply_filters( 'post_planner_add_new', __( 'Add New Planner', 'post-planner' ) )
apply_filters( 'post_planner_edit', __( 'Edit Planner', 'post-planner' ) )
apply_filters( 'post_planner_new', __( 'New Planner', 'post-planner' ) )
apply_filters( 'post_planner_view', __( 'View Planner', 'post-planner' ) )
apply_filters( 'post_planner_search', __( 'Search Planners', 'post-planner' ) )
apply_filters( 'post_planner_categories_name', _x( 'Categories', 'taxonomy general name', 'post-planner' ) )
apply_filters( 'post_planner_categories_singular', _x( 'Category', 'taxonomy singular name', 'post-planner' ) )
apply_filters( 'post_planner_add_new_comment', esc_html__( 'Add New Comment', 'post-planner' ) )
apply_filters( 'post_planner_add_comment', esc_attr__( 'Add Comment', 'post-planner' ) )
apply_filters( 'post_planner_add_new_file', esc_html__( 'Add New File', 'post-planner' ) )
apply_filters( 'post_planner_file_title', esc_html__( 'File Title', 'post-planner' ) )
apply_filters( 'post_planner_file_url', esc_html__( 'File URL', 'post-planner' ) )
apply_filters( 'post_planner_insert_file', esc_attr__( 'Insert File', 'post-planner' ) )
apply_filters( 'post_planner_upload_file', esc_attr__( 'Upload File', 'post-planner' ) )
apply_filters( 'post_planner_add_new_image', esc_html__( 'Add New Image', 'post-planner' ) )
apply_filters( 'post_planner_image_title', esc_html__( 'Image Title', 'post-planner' ) )
apply_filters( 'post_planner_image_url', esc_html__( 'Image URL', 'post-planner' ) )
apply_filters( 'post_planner_insert_image', esc_attr__( 'Insert Image', 'post-planner' ) )
apply_filters( 'post_planner_upload_image', esc_attr__( 'Upload Image', 'post-planner' ) )
apply_filters( 'post_planner_add_new_reference', esc_html__( 'Add New Reference', 'post-planner' ) )
apply_filters( 'post_planner_link_title', esc_html__( 'Link Title', 'post-planner' ) )
apply_filters( 'post_planner_url', esc_html__( 'URL', 'post-planner' ) )
apply_filters( 'post_planner_target', esc_html__( 'Target', 'post-planner' ) )
apply_filters( 'post_planner_listing_no_status', esc_attr__( 'No Status', 'post-planner' ) )
apply_filters( 'post_planner_view_all_statuses', esc_attr__( 'View All Statuses', 'post-planner' ) )
apply_filters( 'post_planner_view_all_assignments', esc_attr__( 'View All Assignments', 'post-planner' ) )
apply_filters( 'post_planner_type', esc_attr__( 'Type', 'post-planner' ) )
apply_filters( 'post_planner_email_url', esc_html__( 'Planner URL', 'post-planner' ) )
apply_filters( 'post_planner_insert_files', esc_attr__( 'Insert File List', 'post-planner' ) )
apply_filters( 'post_planner_no_files', esc_html__( 'No files found', 'post-planner' ) )
apply_filters( 'post_planner_insert_references', esc_attr__( 'Insert References List', 'post-planner' ) )
apply_filters( 'post_planner_no_references', esc_html__( 'No references found', 'post-planner' ) )
apply_filters( 'post_planner_insert_images', esc_attr__( 'Insert All Images', 'post-planner' ) )
apply_filters( 'post_planner_no_images', esc_html__( 'No images found', 'post-planner' ) )