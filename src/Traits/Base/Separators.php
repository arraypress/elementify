<?php
/**
 * Elementify Library - Separators Trait
 *
 * A collection of methods for creating HTML separator elements.
 *
 * @package     ArrayPress\Elementify
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

namespace Elementify\Traits\Base;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Element;

/**
 * Separators Trait
 *
 * Provides methods for creating HTML separator elements like horizontal rules and line breaks.
 * These elements help structure content by creating visual or logical divisions.
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

}