<?php
namespace PB\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface Widget_Interface {

	/** Unique machine name, e.g. 'heading'. Must match src/widgets/<name>. */
	public function get_name(): string;

	/** Render this widget's saved attributes to frontend HTML. */
	public function render( array $attributes ): string;

	/** Sanitize/validate attributes coming from the editor before saving. */
	public function sanitize( array $attributes ): array;
}
