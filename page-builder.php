<?php
/**
 * Plugin Name: WP Page Builder
 * Description: Lightweight, high-performance visual page builder.
 * Version: 0.1.0
 * Author: Saifeddne Mnasri
 * Text Domain: wp-page-builder
 * Requires PHP: 7.4
 * Requires at least: 6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access.
}

define( 'PB_VERSION', '0.1.0' );
define( 'PB_PLUGIN_FILE', __FILE__ );
define( 'PB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once PB_PLUGIN_DIR . 'vendor/autoload.php';

register_activation_hook( __FILE__, [ 'PB\\Activator', 'activate' ] );
register_deactivation_hook( __FILE__, [ 'PB\\Deactivator', 'deactivate' ] );

add_action( 'plugins_loaded', function () {
	\PB\Plugin::instance();
} );