<?php
/**
 * Elementify Library - Heading Elements Trait
 *
 * A collection of methods for creating heading HTML elements.
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
 * Heading Elements Trait
 *
 * Provides methods for creating heading HTML elements (h1-h6).
 */
trait Headings {

	/**
	 * Create a heading element (h1-h6)
	 *
	 * @param int   $level      Heading level (1-6)
	 * @param mixed $content    Element content
	 * @param array $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function heading( int $level, $content = null, array $attributes = [] ): Element {
		$level = max( 1, min( 6, $level ) ); // Ensure valid heading level

		return self::element( 'h' . $level, $content, $attributes );
	}

	/**
	 * Create and render a heading element (h1-h6)
	 *
	 * @param int   $level      Heading level (1-6)
	 * @param mixed $content    Element content
	 * @param array $attributes Element attributes
	 *
	 * @return void
	 */
	public static function heading_render( int $level, $content = null, array $attributes = [] ): void {
		self::heading( $level, $content, $attributes )->output();
	}

	/**
	 * Create h1 element
	 *
	 * @param mixed $content    Element content
	 * @param array $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function h1( $content = null, array $attributes = [] ): Element {
		return self::heading( 1, $content, $attributes );
	}

	/**
	 * Create and render h1 element
	 *
	 * @param mixed $content    Element content
	 * @param array $attributes Element attributes
	 *
	 * @return void
	 */
	public static function h1_render( $content = null, array $attributes = [] ): void {
		self::h1( $content, $attributes )->output();
	}

	/**
	 * Create h2 element
	 *
	 * @param mixed $content    Element content
	 * @param array $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function h2( $content = null, array $attributes = [] ): Element {
		return self::heading( 2, $content, $attributes );
	}

	/**
	 * Create and render h2 element
	 *
	 * @param mixed $content    Element content
	 * @param array $attributes Element attributes
	 *
	 * @return void
	 */
	public static function h2_render( $content = null, array $attributes = [] ): void {
		self::h2( $content, $attributes )->output();
	}

	/**
	 * Create h3 element
	 *
	 * @param mixed $content    Element content
	 * @param array $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function h3( $content = null, array $attributes = [] ): Element {
		return self::heading( 3, $content, $attributes );
	}

	/**
	 * Create and render h3 element
	 *
	 * @param mixed $content    Element content
	 * @param array $attributes Element attributes
	 *
	 * @return void
	 */
	public static function h3_render( $content = null, array $attributes = [] ): void {
		self::h3( $content, $attributes )->output();
	}

	/**
	 * Create h4 element
	 *
	 * @param mixed $content    Element content
	 * @param array $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function h4( $content = null, array $attributes = [] ): Element {
		return self::heading( 4, $content, $attributes );
	}

	/**
	 * Create and render h4 element
	 *
	 * @param mixed $content    Element content
	 * @param array $attributes Element attributes
	 *
	 * @return void
	 */
	public static function h4_render( $content = null, array $attributes = [] ): void {
		self::h4( $content, $attributes )->output();
	}

	/**
	 * Create h5 element
	 *
	 * @param mixed $content    Element content
	 * @param array $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function h5( $content = null, array $attributes = [] ): Element {
		return self::heading( 5, $content, $attributes );
	}

	/**
	 * Create and render h5 element
	 *
	 * @param mixed $content    Element content
	 * @param array $attributes Element attributes
	 *
	 * @return void
	 */
	public static function h5_render( $content = null, array $attributes = [] ): void {
		self::h5( $content, $attributes )->output();
	}

	/**
	 * Create h6 element
	 *
	 * @param mixed $content    Element content
	 * @param array $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function h6( $content = null, array $attributes = [] ): Element {
		return self::heading( 6, $content, $attributes );
	}

	/**
	 * Create and render h6 element
	 *
	 * @param mixed $content    Element content
	 * @param array $attributes Element attributes
	 *
	 * @return void
	 */
	public static function h6_render( $content = null, array $attributes = [] ): void {
		self::h6( $content, $attributes )->output();
	}

}