<?php
/**
 * Elementify Library - Core Utility Functions
 *
 * Helper functions for creating base HTML elements.
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
use Elementify\Element;

if ( ! function_exists( 'el_create_element' ) ) {
	/**
	 * Create a generic HTML element.
	 *
	 * @param string $tag        HTML tag name.
	 * @param mixed  $content    Element content.
	 * @param array  $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_create_element( string $tag, $content = null, array $attributes = [] ): Element {
		return Create::element( $tag, $content, $attributes );
	}
}

if ( ! function_exists( 'el_create_link' ) ) {
	/**
	 * Create a link element (alias for el_a).
	 *
	 * @param string $href       URL.
	 * @param mixed  $content    Element content.
	 * @param array  $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_create_link( string $href, $content = null, array $attributes = [] ): Element {
		return Create::a( $href, $content, $attributes );
	}
}