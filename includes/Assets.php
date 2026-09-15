<?php
namespace PB;

if ( ! defined( 'ABSPATH' ) ) exit;

class Assets {
	private static ?Assets $instance = null;

	public static function instance(): Assets {
		if ( null === self::$instance ) self::$instance = new self();
		return self::$instance;
	}

	private function __construct() {}

	public function enqueue_full_editor(): void {
		$asset_file = PB_PLUGIN_DIR . 'build/editor.asset.php';
		if ( ! file_exists( $asset_file ) ) return;

		$asset = require $asset_file;

		wp_enqueue_script( 'pb-editor', PB_PLUGIN_URL . 'build/editor.js', $asset['dependencies'], $asset['version'], true );
		wp_enqueue_style( 'pb-editor', PB_PLUGIN_URL . 'build/editor.css', [], $asset['version'] );

		$post_id = isset( $_GET['post_id'] ) ? absint( $_GET['post_id'] ) : 0;

		wp_localize_script( 'pb-editor', 'pbData', [
			'restUrl' => esc_url_raw( rest_url( 'pb/v1' ) ),
			'nonce'   => wp_create_nonce( 'wp_rest' ),
			'postId'  => $post_id,
		] );
	}
}