<?php
/**
 * Elementify Library - Component Utility Functions
 *
 * Helper functions for creating component HTML elements.
 *
 * @package     ArrayPress\Elementify
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Create;
use Elementify\Components\Accordion;

if ( ! function_exists( 'el_accordion' ) ) {
	/**
	 * Create an accordion component.
	 *
	 * @param array $sections       Array of sections with 'title', 'content', and optional 'active' keys.
	 * @param bool  $allow_multiple Whether multiple sections can be open at once.
	 * @param array $attributes     Element attributes.
	 * @param bool  $include_css    Whether to include built-in CSS.
	 *
	 * @return Accordion
	 */
	function el_accordion( array $sections = [], bool $allow_multiple = false, array $attributes = [], bool $include_css = true ): Accordion {
		return Create::accordion( $sections, $allow_multiple, $attributes, $include_css );
	}
}

if ( ! function_exists( 'el_accordion_render' ) ) {
	/**
	 * Create and render an accordion component.
	 *
	 * @param array $sections       Array of sections with 'title', 'content', and optional 'active' keys.
	 * @param bool  $allow_multiple Whether multiple sections can be open at once.
	 * @param array $attributes     Element attributes.
	 * @param bool  $include_css    Whether to include built-in CSS.
	 */
	function el_accordion_render( array $sections = [], bool $allow_multiple = false, array $attributes = [], bool $include_css = true ): void {
		Create::accordion_render( $sections, $allow_multiple, $attributes, $include_css );
	}
}