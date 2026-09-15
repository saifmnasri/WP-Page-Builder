<?php
namespace PB;
if ( ! defined( 'ABSPATH' ) ) exit;
class Assets {
	private static ?Assets $instance = null;
	public static function instance(): Assets {
		if ( null === self::$instance ) self::$instance = new self();
		return self::$instance;
	}
}
