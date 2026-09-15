<?php
namespace PB;

if ( ! defined( 'ABSPATH' ) ) exit;

class Admin_Page {
	private static ?Admin_Page $instance = null;

	public static function instance(): Admin_Page {
		if ( null === self::$instance ) self::$instance = new self();
		return self::$instance;
	}

	private function __construct() {
		add_action( 'admin_menu', [ $this, 'register_page' ] );
		add_filter( 'post_row_actions', [ $this, 'add_row_action' ], 10, 2 );
		add_filter( 'page_row_actions', [ $this, 'add_row_action' ], 10, 2 );
		add_action( 'edit_form_top', [ $this, 'add_edit_button' ] );
	}

	public function register_page(): void {
		$hook = add_menu_page( 'Page Builder Editor', 'Page Builder Editor', 'edit_posts', 'pb-editor', [ $this, 'render' ], '', 999 );
		remove_menu_page( 'pb-editor' );
		add_action( 'load-' . $hook, [ $this, 'on_load' ] );
	}

	public function on_load(): void {
		add_action( 'admin_enqueue_scripts', [ Assets::instance(), 'enqueue_full_editor' ] );
	}

	public function add_row_action( array $actions, \WP_Post $post ): array {
		if ( ! current_user_can( 'edit_post', $post->ID ) ) return $actions;
		$url = admin_url( 'admin.php?page=pb-editor&post_id=' . $post->ID );
		$actions['pb_edit'] = '<a href="' . esc_url( $url ) . '">Edit with Page Builder</a>';
		return $actions;
	}

	public function add_edit_button( \WP_Post $post ): void {
		if ( ! current_user_can( 'edit_post', $post->ID ) ) return;
		$url = admin_url( 'admin.php?page=pb-editor&post_id=' . $post->ID );
		echo '<p><a href="' . esc_url( $url ) . '" class="button button-primary">Edit with Page Builder</a></p>';
	}

	public function render(): void {
		$post_id = isset( $_GET['post_id'] ) ? absint( $_GET['post_id'] ) : 0;
		if ( ! $post_id || ! current_user_can( 'edit_post', $post_id ) ) {
			wp_die( 'Invalid post.' );
		}
		?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo esc_html( get_the_title( $post_id ) ); ?> — Page Builder</title>
<?php wp_print_styles(); ?>
</head>
<body class="pb-editor-body">
<div id="pb-editor-root" data-post-id="<?php echo esc_attr( $post_id ); ?>"></div>
<?php wp_print_scripts(); ?>
</body>
</html>
		<?php
		exit;
	}
}