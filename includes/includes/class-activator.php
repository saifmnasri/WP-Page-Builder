<?php
namespace PB;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Activator {
	public static function activate(): void {
		flush_rewrite_rules();
	}
}