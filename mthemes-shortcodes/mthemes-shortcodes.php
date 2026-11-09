<?php
/**
 * Plugin Name: MThemes Shortcodes
 * Plugin URI: http://www.m-themes.eu
 * Description: Shortcode generator used for MThemes
 * Version: 1.0
 * Author: Marcin Michalak
 * Author URI: http://www.m-themes.eu
 */

class MThemesShortcodes {

	function __construct() {
		define( 'MTSC_VERSION', '1.0' );

		// Plugin folder path
		if ( ! defined( 'MTSC_PLUGIN_DIR' ) ) {
			define( 'MTSC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		}

		// Plugin folder URL
		if ( ! defined( 'MTSC_PLUGIN_URL' ) ) {
			define( 'MTSC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		// Shortcodes
		require_once( MTSC_PLUGIN_DIR .'includes/shortcodes.php' );

		// Aqua resizer
		require_once( MTSC_PLUGIN_DIR .'includes/aqua-resizer.php' );

		add_action( 'admin_init', array(&$this, 'admin_init') );
	}

	/**
	 * Enqueue Scripts and Styles
	 *
	 * @return	void
	 */
	function admin_init() {
		include_once( MTSC_PLUGIN_DIR . 'includes/class-mtsc-admin.php' );

		// css
		wp_enqueue_style( 'mtsc-magnific', MTSC_PLUGIN_URL . 'assets/css/magnific-popup.css' );
		wp_enqueue_style( 'mtsc-popup', MTSC_PLUGIN_URL . 'assets/css/admin.css' );
		wp_enqueue_style( 'mtsc-icons', MTSC_PLUGIN_URL . 'assets/css/icon-font.css' );
		wp_enqueue_style( 'wp-color-picker' );

		// js
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'mtsc-magnific', MTSC_PLUGIN_URL . 'assets/js/magnific-popup.js', array( 'jquery' ) );
		wp_enqueue_script( 'mtsc-popup', MTSC_PLUGIN_URL . 'assets/js/popup.js', array( 'jquery' ) );
	}
}
new MThemesShortcodes();
