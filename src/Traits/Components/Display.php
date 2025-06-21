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
	 * @param bool   $include_css Whether to include built-in CSS
	 *
	 * @return ColorSwatch
	 */
	public static function color_swatch( string $color, array $options = [], array $attributes = [], bool $include_css = true ): ColorSwatch {
		return new ColorSwatch( $color, $options, $attributes, $include_css );
	}

	/**
	 * Create and render a color swatch component
	 *
	 * @param string $color       The color value (hex, rgb, etc.)
	 * @param array  $options     Additional options
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS
	 *
	 * @return void
	 */
	public static function color_swatch_render( string $color, array $options = [], array $attributes = [], bool $include_css = true ): void {
		self::color_swatch( $color, $options, $attributes, $include_css )->output();
	}

	/**
	 * Create a filesize component
	 *
	 * @param int|string $bytes       File size in bytes
	 * @param array      $options     Additional options
	 * @param array      $attributes  Element attributes
	 * @param bool       $include_css Whether to include built-in CSS
	 *
	 * @return FileSize
	 */
	public static function filesize( $bytes, array $options = [], array $attributes = [], bool $include_css = true ): FileSize {
		return new FileSize( $bytes, $options, $attributes, $include_css );
	}

	/**
	 * Create and render a filesize component
	 *
	 * @param int|string $bytes       File size in bytes
	 * @param array      $options     Additional options
	 * @param array      $attributes  Element attributes
	 * @param bool       $include_css Whether to include built-in CSS
	 *
	 * @return void
	 */
	public static function filesize_render( $bytes, array $options = [], array $attributes = [], bool $include_css = true ): void {
		self::filesize( $bytes, $options, $attributes, $include_css )->output();
	}

	/**
	 * Create a number component
	 *
	 * @param float|int|string|null $value       The numeric value
	 * @param array                 $options     Additional options
	 * @param array                 $attributes  Element attributes
	 * @param bool                  $include_css Whether to include built-in CSS
	 *
	 * @return NumberFormat
	 */
	public static function number_format( $value, array $options = [], array $attributes = [], bool $include_css = true ): NumberFormat {
		return new NumberFormat( $value, $options, $attributes, $include_css );
	}

	/**
	 * Create and render a number component
	 *
	 * @param float|int|string|null $value       The numeric value
	 * @param array                 $options     Additional options
	 * @param array                 $attributes  Element attributes
	 * @param bool                  $include_css Whether to include built-in CSS
	 *
	 * @return void
	 */
	public static function number_format_render( $value, array $options = [], array $attributes = [], bool $include_css = true ): void {
		self::number_format( $value, $options, $attributes, $include_css )->output();
	}

}