<?php
/**
 * Elementify Library - Component Utility Functions
 *
 * Helper functions for creating component HTML elements.
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
use Elementify\Components\StatusBadge;

if ( ! function_exists( 'el_badge' ) ) {
	/**
	 * Create a status badge.
	 *
	 * @param string $status      Status type (success, warning, error, info, etc.).
	 * @param string $label       Badge label text.
	 * @param array  $options     Additional options including:
	 *                            - icon: Custom icon identifier
	 *                            - position: Icon position ('before' or 'after')
	 *                            - dashicon: Whether to use Dashicons (true) or custom icon class (false)
	 *                            - size: Badge size ('small', 'medium', 'large')
	 *                            - pill: Whether to use pill-shaped badge (rounded corners)
	 * @param array  $attributes  Element attributes.
	 * @param bool   $include_css Whether to include built-in CSS.
	 *
	 * @return StatusBadge
	 */
	function el_badge( string $status = 'default', string $label = '', array $options = [], array $attributes = [], bool $include_css = true ): StatusBadge {
		// If label is empty, use capitalized status as label
		if ( empty( $label ) ) {
			$label = ucfirst( str_replace( [ '_', '-' ], ' ', $status ) );
		}

		return Create::badge( $label, $status, $options, $attributes, $include_css );
	}
}

if ( ! function_exists( 'el_badge_render' ) ) {
	/**
	 * Create and render a status badge.
	 *
	 * @param string $status      Status type (success, warning, error, info, etc.).
	 * @param string $label       Badge label text.
	 * @param array  $options     Additional options including:
	 *                            - icon: Custom icon identifier
	 *                            - position: Icon position ('before' or 'after')
	 *                            - dashicon: Whether to use Dashicons (true) or custom icon class (false)
	 *                            - size: Badge size ('small', 'medium', 'large')
	 *                            - pill: Whether to use pill-shaped badge (rounded corners)
	 * @param array  $attributes  Element attributes.
	 * @param bool   $include_css Whether to include built-in CSS.
	 */
	function el_badge_render( string $status = 'default', string $label = '', array $options = [], array $attributes = [], bool $include_css = true ): void {
		echo el_badge( $status, $label, $options, $attributes, $include_css )->render();
	}
}