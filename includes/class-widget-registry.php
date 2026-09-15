<?php
namespace PB;
if ( ! defined( 'ABSPATH' ) ) exit;
class Widget_Registry {
	private static ?Widget_Registry $instance = null;
	public static function instance(): Widget_Registry {
		if ( null === self::$instance ) self::$instance = new self();
		return self::$instance;
	}
}
