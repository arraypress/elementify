<?php
/**
 * Elementify Library - Core Utility Functions
 *
 * Helper functions for creating HTML elements.
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

if ( ! function_exists( 'el_div' ) ) {
	/**
	 * Create a div element.
	 *
	 * @param mixed $content    Element content.
	 * @param array $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_div( $content = null, array $attributes = [] ): Element {
		return Create::div( $content, $attributes );
	}
}

if ( ! function_exists( 'el_div_render' ) ) {
	/**
	 * Create and render a div element.
	 *
	 * @param mixed $content    Element content.
	 * @param array $attributes Element attributes.
	 */
	function el_div_render( $content = null, array $attributes = [] ): void {
		Create::div_render( $content, $attributes );
	}
}

if ( ! function_exists( 'el_span' ) ) {
	/**
	 * Create a span element.
	 *
	 * @param mixed $content    Element content.
	 * @param array $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_span( $content = null, array $attributes = [] ): Element {
		return Create::span( $content, $attributes );
	}
}

if ( ! function_exists( 'el_span_render' ) ) {
	/**
	 * Create and render a span element.
	 *
	 * @param mixed $content    Element content.
	 * @param array $attributes Element attributes.
	 */
	function el_span_render( $content = null, array $attributes = [] ): void {
		Create::span_render( $content, $attributes );
	}
}

if ( ! function_exists( 'el_p' ) ) {
	/**
	 * Create a paragraph element.
	 *
	 * @param mixed $content    Element content.
	 * @param array $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_p( $content = null, array $attributes = [] ): Element {
		return Create::p( $content, $attributes );
	}
}

if ( ! function_exists( 'el_p_render' ) ) {
	/**
	 * Create and render a paragraph element.
	 *
	 * @param mixed $content    Element content.
	 * @param array $attributes Element attributes.
	 */
	function el_p_render( $content = null, array $attributes = [] ): void {
		Create::p_render( $content, $attributes );
	}
}

if ( ! function_exists( 'el_a' ) ) {
	/**
	 * Create an anchor (a) element.
	 *
	 * @param string $href       URL.
	 * @param mixed  $content    Element content.
	 * @param array  $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_a( string $href, $content = null, array $attributes = [] ): Element {
		return Create::a( $href, $content, $attributes );
	}
}

if ( ! function_exists( 'el_a_render' ) ) {
	/**
	 * Create and render an anchor (a) element.
	 *
	 * @param string $href       URL.
	 * @param mixed  $content    Element content.
	 * @param array  $attributes Element attributes.
	 */
	function el_a_render( string $href, $content = null, array $attributes = [] ): void {
		Create::a_render( $href, $content, $attributes );
	}
}

if ( ! function_exists( 'el_h' ) ) {
	/**
	 * Create a heading element (h1-h6).
	 *
	 * @param int   $level      Heading level (1-6).
	 * @param mixed $content    Element content.
	 * @param array $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_h( int $level, $content = null, array $attributes = [] ): Element {
		return Create::heading( $level, $content, $attributes );
	}
}

if ( ! function_exists( 'el_h_render' ) ) {
	/**
	 * Create and render a heading element (h1-h6).
	 *
	 * @param int   $level      Heading level (1-6).
	 * @param mixed $content    Element content.
	 * @param array $attributes Element attributes.
	 */
	function el_h_render( int $level, $content = null, array $attributes = [] ): void {
		Create::heading_render( $level, $content, $attributes );
	}
}