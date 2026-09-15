<?php
namespace PB;
if ( ! defined( 'ABSPATH' ) ) exit;
class Rest_Api {
	private static ?Rest_Api $instance = null;
	public static function instance(): Rest_Api {
		if ( null === self::$instance ) self::$instance = new self();
		return self::$instance;
	}
}
