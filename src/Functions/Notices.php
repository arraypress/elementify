<?php
/**
 * Elementify Library - Notice Utility Functions
 *
 * Helper functions for creating HTML notice elements.
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
use Elementify\Components\Notice;

if ( ! function_exists( 'el_notice' ) ) {
	/**
	 * Create a notice component.
	 *
	 * @param mixed  $content     Notice content.
	 * @param string $type        Notice type (info, success, warning, error).
	 * @param bool   $dismissible Whether the notice can be dismissed.
	 * @param array  $attributes  Additional attributes.
	 * @param bool   $include_css Whether to include built-in CSS.
	 *
	 * @return Notice
	 */
	function el_notice( $content = null, string $type = 'info', bool $dismissible = false, array $attributes = [], bool $include_css = true ): Notice {
		return Create::notice( $content, $type, $dismissible, $attributes, $include_css );
	}
}

if ( ! function_exists( 'el_notice_render' ) ) {
	/**
	 * Create and render a notice component.
	 *
	 * @param mixed  $content     Notice content.
	 * @param string $type        Notice type (info, success, warning, error).
	 * @param bool   $dismissible Whether the notice can be dismissed.
	 * @param array  $attributes  Additional attributes.
	 * @param bool   $include_css Whether to include built-in CSS.
	 */
	function el_notice_render( $content = null, string $type = 'info', bool $dismissible = false, array $attributes = [], bool $include_css = true ): void {
		Create::notice_render( $content, $type, $dismissible, $attributes, $include_css );
	}
}