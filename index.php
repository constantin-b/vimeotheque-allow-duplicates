<?php
/*
 Plugin Name: Vimeotheque Import Duplicates
 Plugin URI: https://vimeotheque.com
 Description: Add-on plugin for plugin Vimeotheque which allows the option to import duplicate posts.
 Author: CodeFlavors
 Version: 1.0
 Author URI: https://codeflavors.com
 */

namespace Vimeotheque_Duplicates;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( __NAMESPACE__ . '\VERSION', '1.0' );
define( __NAMESPACE__ . '\FILE', __FILE__ );
define( __NAMESPACE__ . '\PATH', plugin_dir_path( __FILE__ ) );
define( __NAMESPACE__ . '\URL', plugin_dir_url( __FILE__ ) );

/**
 * Minimum Vimeotheque version required by the add-on
 */
define( __NAMESPACE__ . '\ADDON_PLUGIN_COMPAT', '2.1.2' );

/**
 * Check plugin compatibility
 */
function compatibility_check(){
	if( !defined( 'VIMEOTHEQUE_VERSION' ) ){
		add_action( 'admin_notices', __NAMESPACE__ . '\no_plugin' );
	} elseif( !version_compare( VIMEOTHEQUE_VERSION, namespace\ADDON_PLUGIN_COMPAT, '>=' ) ){
		add_action( 'admin_notices', __NAMESPACE__ . '\fail_version' );
	} elseif ( did_action( 'vimeotheque_loaded' ) ){
		require_once namespace\PATH . 'includes/libs/plugin.class.php';
	}
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\compatibility_check' );

/**
 * Add-on required minimum version.
 * @return void
 */
function fail_version(){
	/* translators: %s: WordPress version */
	$message = sprintf(
		esc_html__( '%s requires Vimeotheque version %s+. Because you are using an earlier version, the plugin is currently NOT RUNNING.', 'vimeotheque-allow-duplicates' ),
		'Vimeotheque Import Duplicates',
		namespace\ADDON_PLUGIN_COMPAT
	);
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}

/**
 * Admin notice for missing Vimeotheque PRO plugin.
 * @return void
 */
function no_plugin(){
	/* translators: %s: WordPress version */
	$message = sprintf(
		esc_html__( '%s requires plugin Vimeotheque to be installed. Please install %s plugin to enable the add-on functionality.', 'vimeotheque-allow-duplicates' ),
		'Vimeotheque Import Duplicates',
		sprintf(
			'<a href="%s" target="_blank">%s</a>',
			'https://wordpress.org/plugins/codeflavors-vimeo-video-post-lite/',
			'Vimeotheque'
		)
	);
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}