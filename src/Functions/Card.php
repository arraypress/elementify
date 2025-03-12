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
use Elementify\Components\Card;

if ( ! function_exists( 'el_card' ) ) {
	/**
	 * Create a card component.
	 *
	 * @param mixed  $content     Card content (body content).
	 * @param string $title       Optional header title.
	 * @param mixed  $footer      Optional footer content.
	 * @param array  $attributes  Element attributes.
	 * @param bool   $include_css Whether to include built-in CSS.
	 * @param string $variant     Card style variant (default, compact, borderless, no-padding).
	 *
	 * @return Card
	 */
	function el_card( $content = null, string $title = '', $footer = null, array $attributes = [], bool $include_css = true, string $variant = 'no-padding' ): Card {
		return Create::card( $content, $title, $footer, $attributes, $include_css, $variant );
	}
}

if ( ! function_exists( 'el_card_render' ) ) {
	/**
	 * Create and render a card component.
	 *
	 * @param mixed  $content     Card content (body content).
	 * @param string $title       Optional header title.
	 * @param mixed  $footer      Optional footer content.
	 * @param array  $attributes  Element attributes.
	 * @param bool   $include_css Whether to include built-in CSS.
	 * @param string $variant     Card style variant (default, compact, borderless, no-padding).
	 */
	function el_card_render( $content = null, string $title = '', $footer = null, array $attributes = [], bool $include_css = true, string $variant = 'no-padding' ): void {
		Create::card_render( $content, $title, $footer, $attributes, $include_css, $variant );
	}
}

if ( ! function_exists( 'el_card_advanced' ) ) {
	/**
	 * Create a card component with image support and reordered parameters.
	 *
	 * @param string $title       Card title.
	 * @param mixed  $content     Card content.
	 * @param string $image_src   Optional image source URL.
	 * @param string $footer      Optional footer content.
	 * @param array  $attributes  Card attributes.
	 * @param bool   $include_css Whether to include built-in CSS.
	 * @param string $variant     Card style variant (default, compact, borderless, no-padding).
	 *
	 * @return Card
	 */
	function el_card_advanced( string $title, $content, string $image_src = '', $footer = '', array $attributes = [], bool $include_css = true, string $variant = 'default' ): Card {
		// Create the card using the Component class
		$card = Create::card( $content, $title, $footer, $attributes, $include_css, $variant );

		// Add image if provided
		if ( ! empty( $image_src ) ) {
			$card->set_image( $image_src, $title );
		}

		return $card;
	}
}

if ( ! function_exists( 'el_card_advanced_render' ) ) {
	/**
	 * Create and render a card component with image support and reordered parameters.
	 *
	 * @param string $title       Card title.
	 * @param mixed  $content     Card content.
	 * @param string $image_src   Optional image source URL.
	 * @param string $footer      Optional footer content.
	 * @param array  $attributes  Card attributes.
	 * @param bool   $include_css Whether to include built-in CSS.
	 * @param string $variant     Card style variant (default, compact, borderless, no-padding).
	 */
	function el_card_advanced_render( string $title, $content, string $image_src = '', $footer = '', array $attributes = [], bool $include_css = true, string $variant = 'default' ): void {
		el_card_advanced( $title, $content, $image_src, $footer, $attributes, $include_css, $variant )->output();
	}
}