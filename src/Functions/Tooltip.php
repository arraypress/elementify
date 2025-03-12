<?php
/**
 * Elementify Library - Tooltip Utility Functions
 *
 * Helper functions for creating tooltip elements.
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
use Elementify\Components\Tooltip;

if ( ! function_exists( 'el_tooltip' ) ) {
	/**
	 * Create a tooltip component.
	 *
	 * @param mixed  $target      Target element or content
	 * @param string $tooltip     Tooltip content
	 * @param array  $options     Options for the tooltip (position, trigger, etc.)
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS
	 *
	 * @return Tooltip
	 */
	function el_tooltip( $target, string $tooltip, array $options = [], array $attributes = [], bool $include_css = true ): Tooltip {
		return Create::tooltip( $target, $tooltip, $options, $attributes, $include_css );
	}
}

if ( ! function_exists( 'el_tooltip_render' ) ) {
	/**
	 * Create and render a tooltip component.
	 *
	 * @param mixed  $target      Target element or content
	 * @param string $tooltip     Tooltip content
	 * @param array  $options     Options for the tooltip (position, trigger, etc.)
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS
	 */
	function el_tooltip_render( $target, string $tooltip, array $options = [], array $attributes = [], bool $include_css = true ): void {
		Create::tooltip_render( $target, $tooltip, $options, $attributes, $include_css );
	}
}

/**
 * Create themed tooltips with pre-configured settings
 */
if ( ! function_exists( 'el_info_tooltip' ) ) {
	/**
	 * Create an info tooltip component.
	 *
	 * @param mixed  $target     Target element or content
	 * @param string $tooltip    Tooltip content
	 * @param array  $attributes Element attributes
	 *
	 * @return Tooltip
	 */
	function el_info_tooltip( $target, string $tooltip, array $attributes = [] ): Tooltip {
		return el_tooltip( $target, $tooltip, [ 'theme' => 'info' ], $attributes );
	}
}

if ( ! function_exists( 'el_warning_tooltip' ) ) {
	/**
	 * Create a warning tooltip component.
	 *
	 * @param mixed  $target     Target element or content
	 * @param string $tooltip    Tooltip content
	 * @param array  $attributes Element attributes
	 *
	 * @return Tooltip
	 */
	function el_warning_tooltip( $target, string $tooltip, array $attributes = [] ): Tooltip {
		return el_tooltip( $target, $tooltip, [ 'theme' => 'warning' ], $attributes );
	}
}

if ( ! function_exists( 'el_error_tooltip' ) ) {
	/**
	 * Create an error tooltip component.
	 *
	 * @param mixed  $target     Target element or content
	 * @param string $tooltip    Tooltip content
	 * @param array  $attributes Element attributes
	 *
	 * @return Tooltip
	 */
	function el_error_tooltip( $target, string $tooltip, array $attributes = [] ): Tooltip {
		return el_tooltip( $target, $tooltip, [ 'theme' => 'error' ], $attributes );
	}
}

/**
 * Create position-specific tooltips
 */
if ( ! function_exists( 'el_tooltip_top' ) ) {
	/**
	 * Create a tooltip that appears above the target.
	 *
	 * @param mixed  $target     Target element or content
	 * @param string $tooltip    Tooltip content
	 * @param array  $options    Additional options
	 * @param array  $attributes Element attributes
	 *
	 * @return Tooltip
	 */
	function el_tooltip_top( $target, string $tooltip, array $options = [], array $attributes = [] ): Tooltip {
		$options['position'] = 'top';

		return el_tooltip( $target, $tooltip, $options, $attributes );
	}
}

if ( ! function_exists( 'el_tooltip_right' ) ) {
	/**
	 * Create a tooltip that appears to the right of the target.
	 *
	 * @param mixed  $target     Target element or content
	 * @param string $tooltip    Tooltip content
	 * @param array  $options    Additional options
	 * @param array  $attributes Element attributes
	 *
	 * @return Tooltip
	 */
	function el_tooltip_right( $target, string $tooltip, array $options = [], array $attributes = [] ): Tooltip {
		$options['position'] = 'right';

		return el_tooltip( $target, $tooltip, $options, $attributes );
	}
}

if ( ! function_exists( 'el_tooltip_bottom' ) ) {
	/**
	 * Create a tooltip that appears below the target.
	 *
	 * @param mixed  $target     Target element or content
	 * @param string $tooltip    Tooltip content
	 * @param array  $options    Additional options
	 * @param array  $attributes Element attributes
	 *
	 * @return Tooltip
	 */
	function el_tooltip_bottom( $target, string $tooltip, array $options = [], array $attributes = [] ): Tooltip {
		$options['position'] = 'bottom';

		return el_tooltip( $target, $tooltip, $options, $attributes );
	}
}

if ( ! function_exists( 'el_tooltip_left' ) ) {
	/**
	 * Create a tooltip that appears to the left of the target.
	 *
	 * @param mixed  $target     Target element or content
	 * @param string $tooltip    Tooltip content
	 * @param array  $options    Additional options
	 * @param array  $attributes Element attributes
	 *
	 * @return Tooltip
	 */
	function el_tooltip_left( $target, string $tooltip, array $options = [], array $attributes = [] ): Tooltip {
		$options['position'] = 'left';

		return el_tooltip( $target, $tooltip, $options, $attributes );
	}
}

/**
 * Create trigger-specific tooltips
 */
if ( ! function_exists( 'el_click_tooltip' ) ) {
	/**
	 * Create a tooltip triggered by click.
	 *
	 * @param mixed  $target     Target element or content
	 * @param string $tooltip    Tooltip content
	 * @param array  $options    Additional options
	 * @param array  $attributes Element attributes
	 *
	 * @return Tooltip
	 */
	function el_click_tooltip( $target, string $tooltip, array $options = [], array $attributes = [] ): Tooltip {
		$options['trigger'] = 'click';

		return el_tooltip( $target, $tooltip, $options, $attributes );
	}
}

if ( ! function_exists( 'el_focus_tooltip' ) ) {
	/**
	 * Create a tooltip triggered by focus.
	 *
	 * @param mixed  $target     Target element or content
	 * @param string $tooltip    Tooltip content
	 * @param array  $options    Additional options
	 * @param array  $attributes Element attributes
	 *
	 * @return Tooltip
	 */
	function el_focus_tooltip( $target, string $tooltip, array $options = [], array $attributes = [] ): Tooltip {
		$options['trigger'] = 'focus';

		return el_tooltip( $target, $tooltip, $options, $attributes );
	}
}