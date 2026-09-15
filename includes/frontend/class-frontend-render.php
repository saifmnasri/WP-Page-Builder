<?php
namespace PB\Frontend;
if ( ! defined( 'ABSPATH' ) ) exit;
class Frontend_Render {
	private static ?Frontend_Render $instance = null;
	public static function instance(): Frontend_Render {
		if ( null === self::$instance ) self::$instance = new self();
		return self::$instance;
	}
}
