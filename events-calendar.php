<?php
/**
 * Plugin Name: WP Events Calendar
 * Plugin URI: http://www.wp-eventscalendar.com
 * Description: Events Calendar is a versatile calendar for your WordPress site with many useful functions to keep track of your events.
 * Version: 7.0
 * Author: Luke Howell
 * Author URI: http://www.lukehowell.com
 * License: GPLv2
 *
 * Copyright 2012  Luke Howell (email : luke.howell@gmail.com)
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * events-calendar.php
 * @internal Description needed.
 * @package events-calendar
 * @since 7.0
 * @author Luke Howell <luke.howell@gmail.com>
 * @copyright Copyright (c) 2007-2012 Luke Howell
 * @license GPLv2 {@link http://www.gnu.org/licenses/gpl-2.0.html}
 */

/**#@+
 * Define necessary constants
 */

/**
 * Absolute path to the plugin directory
 */
define( 'WPEC_ROOT_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Absolute url to the plugin directory
 */
define( 'WPEC_ROOT_URL', plugin_dir_url( __FILE__ ) );

/**
 * Absolute url to the img directory
 */
define( 'WPEC_IMG_URL', WPEC_ROOT_URL . 'img/');

/**
 * Absolute url to the css directory
 */
define( 'WPEC_CSS_URL', WPEC_ROOT_URL . 'css/');

/**
 * Absolute url to the js directory
 */
define( 'WPEC_JS_URL', WPEC_ROOT_URL . 'js/');

/**
 * Localization
 */
define( 'WPEC_L10N', 'events-calendar' );

/**#@-*/

/**#@+
 * Inclue required files
 */

/**
 * Plugin settings
 */
require_once( WPEC_ROOT_PATH . 'class-plugin-settings.php' );

/**
 * Event post type
 */
require_once( WPEC_ROOT_PATH . 'class-event-post-type.php' );

/**
 * Large calendar shortcode
 */
require_once( WPEC_ROOT_PATH . 'class-large-calendar-shortcode.php' );

/**#@-*/

/**#@+
 * Instantiate classes
 */

/**
 * Plugin settings
 */
new WPEC_Plugin_Settings;

/**
 * Event post type
 */
new WPEC_Event_Post_Type;

/**
 * Large calendar shortcode
 */
new WPEC_Large_Calendar_Shortcode;

/**#@-*/

/**#@+
 * Hooks
 */

/**
 * Plugin is activated
 */
/**
 * Default settings
 * @internal Complete description
 * @since 7.0
 * @author Luke Howell <luke.howell@gmail.com>
 */
function wpec_default_settings()
{

	$default_options = array(
		'post_type_slug' => 'event'
	);
	
	update_option( 'wpec_options', $default_options );
	
}
register_activation_hook( __FILE__, 'wpec_default_settings' );

/**#@-*/
