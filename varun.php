<?php
/**
 * Plugin Name:       varun
 * Plugin URI:        https://awesomemotive.com
 * Description:       miusage data fetch plugin
 * Author:            Varun
 * Author URI:        https://awesomemotive.com
 * Version:           1.0.0
 * Text Domain:       varun
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'VARUN_VERSION' ) ) {
	/**
	 * Plugin version.
	 *
	 * @since 1.0.0
	 */
	define( 'VARUN_VERSION', '1.0.0' );
}

// Folder URL.
if ( ! defined( 'VARUN_PLUGIN_URL' ) ) {
	define( 'VARUN_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

// Folder Path.
if ( ! defined( 'VARUN_PLUGIN_DIR' ) ) {
	define( 'VARUN_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

// Plugin Root File.
if ( ! defined( 'VARUN_PLUGIN_FILE' ) ) {
	define( 'VARUN_PLUGIN_FILE', __FILE__ );
}

if ( ! defined( 'VARUN_PLUGIN_SLUG' ) ) {
	define( 'VARUN_PLUGIN_SLUG', 'varun' );
}

// Define the class and the function.
require_once dirname( __FILE__ ) . '/src/Varun.php';
require_once dirname( __FILE__ ) . '/src/WP-cli.php';

varun();
