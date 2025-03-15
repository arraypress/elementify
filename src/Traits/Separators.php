<?php
/**
 * Elementify Library - Basic Elements Trait
 *
 * A collection of methods for creating basic HTML elements.
 *
 * @package     ArrayPress\Elementify
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

namespace Elementify\Traits;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Element;

/**
 * Basic Elements Trait
 *
 * Provides methods for creating basic HTML elements like divs, spans, paragraphs, etc.
 */
trait Separators {

	/**
	 * Create a horizontal rule element
	 *
	 * @param array $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function hr( array $attributes = [] ): Element {
		return self::element( 'hr', null, $attributes );
	}

	/**
	 * Create and render a horizontal rule element
	 *
	 * @param array $attributes Element attributes
	 *
	 * @return void
	 */
	public static function hr_render( array $attributes = [] ): void {
		self::hr( $attributes )->output();
	}

	/**
	 * Create a line break element or multiple line breaks
	 *
	 * @param int   $count      Number of line breaks to create (default: 1)
	 * @param array $attributes Element attributes (applies to each br element)
	 *
	 * @return Element|string Single br Element or container with multiple br Elements
	 */
	public static function br( int $count = 1, array $attributes = [] ) {
		if ( $count <= 0 ) {
			return '';
		}

		if ( $count === 1 ) {
			return self::element( 'br', null, $attributes );
		}

		// For multiple breaks, wrap in a container
		$container = self::element('span');

		for ( $i = 0; $i < $count; $i++ ) {
			$container->add_child( self::element( 'br', null, $attributes ) );
		}

		return $container;
	}

	/**
	 * Create and render a line break element or multiple line breaks
	 *
	 * @param int   $count      Number of line breaks to create (default: 1)
	 * @param array $attributes Element attributes (applies to each br element)
	 *
	 * @return void
	 */
	public static function br_render( int $count = 1, array $attributes = [] ): void {
		if ( $count <= 0 ) {
			return;
		}

		if ( $count === 1 ) {
			self::element( 'br', null, $attributes )->output();
			return;
		}

		// For multiple breaks, render each one independently
		for ( $i = 0; $i < $count; $i++ ) {
			self::element( 'br', null, $attributes )->output();
		}
	}

}