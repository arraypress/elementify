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

if ( ! function_exists( 'el_hr' ) ) {
	/**
	 * Create a horizontal rule element.
	 *
	 * @param array $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_hr( array $attributes = [] ): Element {
		return Create::hr( $attributes );
	}
}

if ( ! function_exists( 'el_hr_render' ) ) {
	/**
	 * Create and render a horizontal rule element.
	 *
	 * @param array $attributes Element attributes.
	 */
	function el_hr_render( array $attributes = [] ): void {
		Create::hr_render( $attributes );
	}
}

if ( ! function_exists( 'el_br' ) ) {
	/**
	 * Create a line break element or multiple line breaks.
	 *
	 * @param int   $count      Number of line breaks to create.
	 * @param array $attributes Element attributes (applies to each br element).
	 *
	 * @return Element|string
	 */
	function el_br( int $count = 1, array $attributes = [] ) {
		if ( $count <= 0 ) {
			return '';
		}

		if ( $count === 1 ) {
			return Create::br( $attributes );
		}

		// For multiple breaks, wrap in a container
		$container = el_element('span');

		for ( $i = 0; $i < $count; $i++ ) {
			$container->add_child( Create::br( $attributes ) );
		}

		return $container;
	}
}

if ( ! function_exists( 'el_br_render' ) ) {
	/**
	 * Create and render a line break element or multiple line breaks.
	 *
	 * @param int   $count      Number of line breaks to create.
	 * @param array $attributes Element attributes (applies to each br element).
	 */
	function el_br_render( int $count = 1, array $attributes = [] ): void {
		if ( $count <= 0 ) {
			return;
		}

		for ( $i = 0; $i < $count; $i++ ) {
			Create::br_render( $attributes );
		}
	}
}