<?php
/**
 * Elementify Library - Utility Components Trait
 *
 * A collection of methods for creating utility HTML components.
 *
 * @package     ArrayPress\Elementify
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

namespace Elementify\Traits\Components;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Components\Interactive\Clipboard;

/**
 * Utility Components Trait
 *
 * Provides methods for creating and rendering utility HTML components
 * that enhance usability and provide additional functionality.
 */
trait Utility {

	/**
	 * Create a simple clipboard component for displaying text with a copy button
	 *
	 * @param string $text       The text to copy
	 * @param array  $options    Component options
	 * @param array  $attributes Element attributes
	 *
	 * @return Clipboard
	 */
	public static function clipboard( string $text, array $options = [], array $attributes = [] ): Clipboard {
		return new Clipboard( $text, $options, $attributes );
	}

	/**
	 * Create and render a simple clipboard component
	 *
	 * @param string $text       The text to copy
	 * @param array  $options    Component options
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function clipboard_render( string $text, array $options = [], array $attributes = [] ): void {
		self::clipboard( $text, $options, $attributes )->output();
	}

}