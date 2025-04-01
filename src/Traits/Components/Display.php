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
use Elementify\Components\Media\AttachmentImage;
use Elementify\Components\Taxonomy\Taxonomy;
use Elementify\Components\Display\User;

/**
 * Display Components Trait
 *
 * Provides methods for creating and rendering display-oriented HTML components
 * for presenting data and information visually.
 */
trait Display {

	/**
	 * Create a user component
	 *
	 * @param int|string|\WP_User $user        User ID, username, email, or WP_User object
	 * @param array               $options     Additional options
	 * @param array               $attributes  Element attributes
	 * @param bool                $include_css Whether to include built-in CSS
	 *
	 * @return User
	 */
	public static function user( $user, array $options = [], array $attributes = [], bool $include_css = true ): User {
		return new User( $user, $options, $attributes, $include_css );
	}

	/**
	 * Create and render a user component
	 *
	 * @param int|string|\WP_User $user        User ID, username, email, or WP_User object
	 * @param array               $options     Additional options
	 * @param array               $attributes  Element attributes
	 * @param bool                $include_css Whether to include built-in CSS
	 *
	 * @return void
	 */
	public static function user_render( $user, array $options = [], array $attributes = [], bool $include_css = true ): void {
		self::user( $user, $options, $attributes, $include_css )->output();
	}

	/**
	 * Create a taxonomy/terms component
	 *
	 * @param mixed  $source      Post ID, term IDs array, or terms array
	 * @param string $taxonomy    Taxonomy name (category, post_tag, etc.)
	 * @param array  $options     Additional options
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS
	 *
	 * @return Taxonomy
	 */
	public static function taxonomy( $source, string $taxonomy = 'category', array $options = [], array $attributes = [], bool $include_css = true ): Taxonomy {
		return new Taxonomy( $source, $taxonomy, $options, $attributes, $include_css );
	}

	/**
	 * Create and render a taxonomy/terms component
	 *
	 * @param mixed  $source      Post ID, term IDs array, or terms array
	 * @param string $taxonomy    Taxonomy name (category, post_tag, etc.)
	 * @param array  $options     Additional options
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS
	 *
	 * @return void
	 */
	public static function taxonomy_render( $source, string $taxonomy = 'category', array $options = [], array $attributes = [], bool $include_css = true ): void {
		self::taxonomy( $source, $taxonomy, $options, $attributes, $include_css )->output();
	}

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

	/**
	 * Create an attachment image
	 *
	 * @param string|int $source     Image source (attachment ID or URL)
	 * @param array      $options    Image options
	 * @param array      $attributes HTML attributes
	 *
	 * @return AttachmentImage
	 */
	public static function attachment_image( $source, array $options = [], array $attributes = [] ): AttachmentImage {
		return new AttachmentImage( $source, $options, $attributes );
	}

	/**
	 * Render an attachment image directly
	 *
	 * @param string|int $source     Image source (attachment ID or URL)
	 * @param array      $options    Image options
	 * @param array      $attributes HTML attributes
	 *
	 * @return void
	 */
	public static function attachment_image_render( $source, array $options = [], array $attributes = [] ): void {
		self::attachment_image( $source, $options, $attributes )->output();
	}

}