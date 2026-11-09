<?php
/**
 * Plugin Name: MT Dosei Core
 * Plugin URI:  http://themeforest.net/user/maarcin
 * Description: Core functionality for Dosei Theme: shortcodes, custom post types, widgets and custom functions.
 * Version:     1.2
 * Author:      Marcin Michalak
 * Author URI:  http://themeforest.net/user/maarcin
 * Text Domain: mt-dosei-core
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Portfolio CPT registration
 */
require_once plugin_dir_path( __FILE__ ) . 'portfolio/portfolio-register.php';

/**
 * Gallery CPT registration
 */
require_once plugin_dir_path( __FILE__ ) . 'gallery/gallery-register.php';

/**
 * Shortcodes
 */
require_once plugin_dir_path( __FILE__ ) . 'mthemes-shortcodes/mthemes-shortcodes.php';

/**
 * Visual Composer config
 */
require_once plugin_dir_path( __FILE__ ) . 'vc/config.php';

/**
 * Widgets
 */
require_once plugin_dir_path( __FILE__ ) . 'widgets/widgets.php';

/**
 * Elementor migration support
 */
require_once plugin_dir_path( __FILE__ ) . 'elementor/shortcode-migrator.php';

/**
 * Load plugin textdomain
 */
add_action( 'plugins_loaded', 'mt_dosei_core_load_textdomain' );

if ( ! function_exists( 'mt_dosei_core_load_textdomain' ) ) :
	function mt_dosei_core_load_textdomain() {
		load_plugin_textdomain( 'mt-dosei-core', FALSE, dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages' );
	}
endif;

/**
 * Add new user fields
 * https://codex.wordpress.org/Plugin_API/Filter_Reference/user_contactmethods
 */
function dosei_contactmethods( $contactmethods ) {
	$contactmethods['facebook']   = esc_html__( 'Facebook link', 'mt-dosei-core' );
	$contactmethods['twitter'] 	  = esc_html__( 'Twitter link', 'mt-dosei-core' );
	$contactmethods['dribbble']   = esc_html__( 'Dribbble link', 'mt-dosei-core' );
	$contactmethods['youtube']    = esc_html__( 'YouTube link', 'mt-dosei-core' );
	$contactmethods['instagram']  = esc_html__( 'Instagram link', 'mt-dosei-core' );
	$contactmethods['behance']    = esc_html__( 'Behance link', 'mt-dosei-core' );
	$contactmethods['vimeo']   	  = esc_html__( 'Vimeo link', 'mt-dosei-core' );
	$contactmethods['linkedin']   = esc_html__( 'LinkedIn link', 'mt-dosei-core' );
	$contactmethods['google']     = esc_html__( 'Google link', 'mt-dosei-core' );

	return $contactmethods;
}
add_filter( 'user_contactmethods', 'dosei_contactmethods', 10, 1 );