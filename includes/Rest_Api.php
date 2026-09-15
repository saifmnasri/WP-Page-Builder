<?php
namespace PB;

if ( ! defined( 'ABSPATH' ) ) exit;

class Rest_Api {
	private static ?Rest_Api $instance = null;
	const NS = 'pb/v1';

	public static function instance(): Rest_Api {
		if ( null === self::$instance ) self::$instance = new self();
		return self::$instance;
	}

	private function __construct() {
		add_action( 'rest_api_init', [ $this, 'register_routes' ] );
	}

	public function register_routes(): void {
		register_rest_route( self::NS, '/layout/(?P<id>\d+)', [
			[
				'methods'             => 'GET',
				'callback'            => [ $this, 'get_layout' ],
				'permission_callback' => [ $this, 'can_edit' ],
			],
			[
				'methods'             => 'POST',
				'callback'            => [ $this, 'save_layout' ],
				'permission_callback' => [ $this, 'can_edit' ],
			],
		] );
	}

	public function can_edit( \WP_REST_Request $request ): bool {
		return current_user_can( 'edit_post', (int) $request->get_param( 'id' ) );
	}

	public function get_layout( \WP_REST_Request $request ): \WP_REST_Response {
		$post_id = (int) $request->get_param( 'id' );
		$layout  = get_post_meta( $post_id, '_pb_layout', true );
		return new \WP_REST_Response( [ 'layout' => $layout ? json_decode( $layout, true ) : null ], 200 );
	}

	public function save_layout( \WP_REST_Request $request ): \WP_REST_Response {
		$post_id = (int) $request->get_param( 'id' );
		$data    = $request->get_json_params();

		if ( ! isset( $data['layout'] ) || ! is_array( $data['layout'] ) ) {
			return new \WP_REST_Response( [ 'error' => 'Invalid layout data.' ], 400 );
		}

		update_post_meta( $post_id, '_pb_layout', wp_json_encode( $data['layout'] ) );
		return new \WP_REST_Response( [ 'success' => true ], 200 );
	}
}