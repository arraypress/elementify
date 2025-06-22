<?php
/**
 * Elementify Library - Display Components Trait
 *
 * A collection of methods for creating display-oriented HTML components.
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

use Elementify\Components\Display\ColorSwatch;
use Elementify\Components\Display\FileSize;
use Elementify\Components\Display\NumberFormat;
use Elementify\Components\Display\User;

/**
 * Display Components Trait
 *
 * Provides methods for creating and rendering display-oriented HTML components
 * for presenting data and information visually.
 */
trait Display {

	/**
	 * Create a color swatch component
	 *
	 * @param string $color       The color value (hex, rgb, etc.)
	 * @param array  $options     Additional options
	 * @param array  $attributes  Element attributes
	 *
	 * @return ColorSwatch
	 */
	public static function color_swatch( string $color, array $options = [], array $attributes = [] ): ColorSwatch {
		return new ColorSwatch( $color, $options, $attributes );
	}

	/**
	 * Create a filesize component
	 *
	 * @param int|string $bytes       File size in bytes
	 * @param array      $options     Additional options
	 * @param array      $attributes  Element attributes
	 *
	 * @return FileSize
	 */
	public static function filesize( $bytes, array $options = [], array $attributes = [] ): FileSize {
		return new FileSize( $bytes, $options, $attributes );
	}

	/**
	 * Create a number component
	 *
	 * @param float|int|string|null $value       The numeric value
	 * @param array                 $options     Additional options
	 * @param array                 $attributes  Element attributes
	 *
	 * @return NumberFormat
	 */
	public static function number_format( $value, array $options = [], array $attributes = [] ): NumberFormat {
		return new NumberFormat( $value, $options, $attributes );
	}

	/**
	 * Create a user display component
	 *
	 * @param int|string|\WP_User $user        User ID, username, email, or WP_User object
	 * @param array               $options     Additional options
	 * @param array               $attributes  Element attributes
	 *
	 * @return User
	 */
	public static function user( $user, array $options = [], array $attributes = [] ): User {
		return new User( $user, $options, $attributes );
	}

}