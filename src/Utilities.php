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

if ( ! function_exists( 'el_element' ) ) {
	/**
	 * Create a generic HTML element.
	 *
	 * @param string $tag        HTML tag name.
	 * @param mixed  $content    Element content.
	 * @param array  $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_element( string $tag, $content = null, array $attributes = [] ): Element {
		return Create::element( $tag, $content, $attributes );
	}
}

if ( ! function_exists( 'el_element_render' ) ) {
	/**
	 * Create and render a generic HTML element.
	 *
	 * @param string $tag        HTML tag name.
	 * @param mixed  $content    Element content.
	 * @param array  $attributes Element attributes.
	 */
	function el_element_render( string $tag, $content = null, array $attributes = [] ): void {
		Create::element_render( $tag, $content, $attributes );
	}
}

if ( ! function_exists( 'el_link' ) ) {
	/**
	 * Create a link element (alias for el_a).
	 *
	 * @param string $href       URL.
	 * @param mixed  $content    Element content.
	 * @param array  $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_link( string $href, $content = null, array $attributes = [] ): Element {
		return Create::a( $href, $content, $attributes );
	}
}

if ( ! function_exists( 'el_link_render' ) ) {
	/**
	 * Create and render a link element (alias for el_a_render).
	 *
	 * @param string $href       URL.
	 * @param mixed  $content    Element content.
	 * @param array  $attributes Element attributes.
	 */
	function el_link_render( string $href, $content = null, array $attributes = [] ): void {
		Create::a_render( $href, $content, $attributes );
	}
}