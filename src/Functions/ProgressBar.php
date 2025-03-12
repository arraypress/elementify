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
use Elementify\Components\ProgressBar;
use Elementify\Components\Tabs;
use Elementify\Components\Accordion;
use Elementify\Components\Card;
use Elementify\Components\Modal;

if ( ! function_exists( 'el_progress_bar' ) ) {
	/**
	 * Create a progress bar component.
	 *
	 * @param int|float $current     Current value.
	 * @param int|float $total       Total value (maximum).
	 * @param array     $options     Additional options.
	 * @param array     $attributes  Element attributes.
	 * @param bool      $include_css Whether to include built-in CSS.
	 *
	 * @return ProgressBar
	 */
	function el_progress_bar( $current, $total = 100, array $options = [], array $attributes = [], bool $include_css = true ): ProgressBar {
		return Create::progress_bar( $current, $total, $options, $attributes, $include_css );
	}
}

if ( ! function_exists( 'el_progress_bar_render' ) ) {
	/**
	 * Create and render a progress bar component.
	 *
	 * @param int|float $current     Current value.
	 * @param int|float $total       Total value (maximum).
	 * @param array     $options     Additional options.
	 * @param array     $attributes  Element attributes.
	 * @param bool      $include_css Whether to include built-in CSS.
	 */
	function el_progress_bar_render( $current, $total = 100, array $options = [], array $attributes = [], bool $include_css = true ): void {
		Create::progress_bar_render( $current, $total, $options, $attributes, $include_css );
	}
}