<?php
namespace PB;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueues the editor bundle only on the screen we control (a 'pb_edit' query var
 * on post edit screens, added in a later step). For now: loads on all post edit
 * screens so we have a mount point to verify the build works.
 */
class Assets {

	private static ?Assets $instance = null;

	public static function instance(): Assets {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_editor' ] );
		add_action( 'admin_footer', [ $this, 'print_mount_point' ] );
	}

	public function enqueue_editor( string $hook ): void {
		if ( ! in_array( $hook, [ 'post.php', 'post-new.php' ], true ) ) {
			return;
		}

		$asset_file = PB_PLUGIN_DIR . 'build/editor.asset.php';

		if ( ! file_exists( $asset_file ) ) {
			return; // Build hasn't run yet.
		}

		$asset = require $asset_file;

		wp_enqueue_script(
			'pb-editor',
			PB_PLUGIN_URL . 'build/editor.js',
			$asset['dependencies'],
			$asset['version'],
			true
		);

		wp_enqueue_style(
			'pb-editor',
			PB_PLUGIN_URL . 'build/editor.css',
			[],
			$asset['version']
		);

		wp_localize_script( 'pb-editor', 'pbData', [
			'restUrl' => esc_url_raw( rest_url( 'pb/v1' ) ),
			'nonce'   => wp_create_nonce( 'wp_rest' ),
			'postId'  => get_the_ID(),
		] );
	}

	public function print_mount_point(): void {
		$screen = get_current_screen();
		if ( ! $screen || ! in_array( $screen->base, [ 'post' ], true ) ) {
			return;
		}
		echo '<div id="pb-editor-root"></div>';
	}
}