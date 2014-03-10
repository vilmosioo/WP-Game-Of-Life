<?php
/*
Plugin Name: WP Game Of Life
Plugin URI: http://vilmosioo.co.uk/project/game-of-life/
Description: A game of life simulation using HTML5 canvas. 
Version: 0.0.1
Author: Vilmos Ioo
Author URI: http://vilmosioo.co.uk
License: GPL2

	Copyright 2014 TODO  (email : TODO)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	
*/

// Define constants
define('WP_GAME_OF_LIFE_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WP_GAME_OF_LIFE_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WP_GAME_OF_LIFE_PLUGIN_WORDPRESS_VERSION', get_bloginfo( 'version' ));

// Includes
// require_once(WP_GAME_OF_LIFE_PLUGIN_DIR.'bower_components/wordpress-tools-.php');

class WPGameOfLife_Plugin {
	
	static function init(){
		return new WPGameOfLife_Plugin();
	}

	const ID = 'WP_GAME_OF_LIFE';

	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	private function __construct() {
		register_activation_hook(__FILE__, array( &$this, 'activate' ) );
		register_deactivation_hook(__FILE__, array( &$this, 'deactivate' ) );
		
		// TODO write more functionality here
		wp_register_script( 'game-of-life', WP_GAME_OF_LIFE_PLUGIN_URL.'js/game-of-life.min.js', array( 'jquery' ), '@@version', true );
		add_shortcode('gol', array(&$this, 'print_canvas'));
	} 

	// Add Shortcode
	function print_canvas( $atts ) {
		// Load the JS library
		wp_enqueue_script( 'game-of-life' );

		// set JS settings
    wp_localize_script( 'game-of-life', 'VI_GOL_SETTINGS', shortcode_atts(array(
    	'ID' => self::ID,
			'width' => '1000',
			'cells' => '125',
			'background' => '#aaa',
			'cell_active_color' => '#fff',
			'cell_inactive_color' => '#000',
			'cell_transition_color' => 'rgb(65,180,255)'
		), $atts ));

		return "<canvas id=".self::ID."></canvas>";
	}
	/**
	 * Fired when the plugin is activated.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function activate( $network_wide ) {

	} 

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	function deactivate( $network_wide ) {

	} 

} // end class

add_action( 'plugins_loaded', array('WPGameOfLife_Plugin', 'init' ) );

?>