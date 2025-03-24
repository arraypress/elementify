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
use Elementify\Components\Interactive\Tooltip;

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

	/**
	 * Create a tooltip component
	 *
	 * @param mixed  $target      Target element or content
	 * @param string $tooltip     Tooltip content
	 * @param array  $options     Options for the tooltip (position, trigger, etc.)
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return Tooltip
	 */
	public static function tooltip( $target, string $tooltip, array $options = [], array $attributes = [], bool $include_css = true ): Tooltip {
		return new Tooltip( $target, $tooltip, $options, $attributes, $include_css );
	}

	/**
	 * Create and render a tooltip component
	 *
	 * @param mixed  $target      Target element or content
	 * @param string $tooltip     Tooltip content
	 * @param array  $options     Options for the tooltip (position, trigger, etc.)
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return void
	 */
	public static function tooltip_render( $target, string $tooltip, array $options = [], array $attributes = [], bool $include_css = true ): void {
		self::tooltip( $target, $tooltip, $options, $attributes, $include_css )->output();
	}

	/**
	 * Create a tooltip triggered by click
	 *
	 * @param mixed  $target      Target element or content
	 * @param string $tooltip     Tooltip content
	 * @param array  $options     Additional options
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return Tooltip
	 */
	public static function click_tooltip( $target, string $tooltip, array $options = [], array $attributes = [], bool $include_css = true ): Tooltip {
		$options['trigger'] = 'click';

		return self::tooltip( $target, $tooltip, $options, $attributes, $include_css );
	}

	/**
	 * Create and render a tooltip triggered by click
	 *
	 * @param mixed  $target      Target element or content
	 * @param string $tooltip     Tooltip content
	 * @param array  $options     Additional options
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return void
	 */
	public static function click_tooltip_render( $target, string $tooltip, array $options = [], array $attributes = [], bool $include_css = true ): void {
		self::click_tooltip( $target, $tooltip, $options, $attributes, $include_css )->output();
	}

	/**
	 * Create a tooltip triggered by focus
	 *
	 * @param mixed  $target      Target element or content
	 * @param string $tooltip     Tooltip content
	 * @param array  $options     Additional options
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return Tooltip
	 */
	public static function focus_tooltip( $target, string $tooltip, array $options = [], array $attributes = [], bool $include_css = true ): Tooltip {
		$options['trigger'] = 'focus';

		return self::tooltip( $target, $tooltip, $options, $attributes, $include_css );
	}

	/**
	 * Create and render a tooltip triggered by focus
	 *
	 * @param mixed  $target      Target element or content
	 * @param string $tooltip     Tooltip content
	 * @param array  $options     Additional options
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return void
	 */
	public static function focus_tooltip_render( $target, string $tooltip, array $options = [], array $attributes = [], bool $include_css = true ): void {
		self::focus_tooltip( $target, $tooltip, $options, $attributes, $include_css )->output();
	}

}