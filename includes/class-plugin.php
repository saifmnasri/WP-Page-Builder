<?php
namespace PB;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Plugin {

	private static ?Plugin $instance = null;

	public static function instance(): Plugin {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		$this->includes();
		$this->init_hooks();
	}

	private function includes(): void {
		// Widget registry boots first, widgets self-register into it.
		Widget_Registry::instance();
	}

	private function init_hooks(): void {
		Assets::instance();
		Rest_Api::instance();
		Frontend\Frontend_Render::instance();
	}
}