<?php
namespace PB;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Central registry. Each widget class registers itself here on 'pb_register_widgets'.
 * The editor's REST config endpoint and the frontend renderer both read from this.
 */
class Widget_Registry {

	private static ?Widget_Registry $instance = null;

	private array $widgets = [];

	public static function instance(): Widget_Registry {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'init', [ $this, 'register_all' ] );
	}

	public function register_all(): void {
		/**
		 * Widgets hook into this action to call $registry->register().
		 * Keeps class-plugin.php from needing to know every widget by name.
		 */
		do_action( 'pb_register_widgets', $this );
	}

	public function register( Widgets\Widget_Interface $widget ): void {
		$this->widgets[ $widget->get_name() ] = $widget;
	}

	public function get( string $name ): ?Widgets\Widget_Interface {
		return $this->widgets[ $name ] ?? null;
	}

	public function all(): array {
		return $this->widgets;
	}
}