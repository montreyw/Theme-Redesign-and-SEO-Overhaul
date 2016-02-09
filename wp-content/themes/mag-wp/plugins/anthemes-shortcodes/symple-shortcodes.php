<?php
/*
Plugin Name: Shortcodes Plugin
Description: Enable shortcodes plugin to be used on this Theme
Author: An-Themes
Author URI: http://themeforest.net/user/An-Themes/portfolio
Version: 1.1
License: GNU General Public License version 2.0
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Include functions */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
// Adds plugin JS and CSS
require_once( dirname(__FILE__) . '/includes/scripts.php' );
// Main shortcode functions
require_once( dirname(__FILE__) . '/includes/shortcode-functions.php');
// Adds mce buttons to post editor
require_once( dirname(__FILE__) . '/includes/mce/symple_shortcodes_tinymce.php');