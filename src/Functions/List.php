<?php
/**
 * Elementify Library - List Utility Functions
 *
 * Helper functions for creating HTML list elements.
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
use Elementify\Element;

if ( ! function_exists( 'el_ul' ) ) {
	/**
	 * Create an unordered list element.
	 *
	 * @param array $items      List items.
	 * @param array $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_ul( array $items = [], array $attributes = [] ): Element {
		return Create::ul( $items, $attributes );
	}
}

if ( ! function_exists( 'el_ul_render' ) ) {
	/**
	 * Create and render an unordered list element.
	 *
	 * @param array $items      List items.
	 * @param array $attributes Element attributes.
	 */
	function el_ul_render( array $items = [], array $attributes = [] ): void {
		Create::ul_render( $items, $attributes );
	}
}

if ( ! function_exists( 'el_ol' ) ) {
	/**
	 * Create an ordered list element.
	 *
	 * @param array $items      List items.
	 * @param array $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_ol( array $items = [], array $attributes = [] ): Element {
		return Create::ol( $items, $attributes );
	}
}

if ( ! function_exists( 'el_ol_render' ) ) {
	/**
	 * Create and render an ordered list element.
	 *
	 * @param array $items      List items.
	 * @param array $attributes Element attributes.
	 */
	function el_ol_render( array $items = [], array $attributes = [] ): void {
		Create::ol_render( $items, $attributes );
	}
}

if ( ! function_exists( 'el_li' ) ) {
	/**
	 * Create a list item element.
	 *
	 * @param mixed $content    Element content.
	 * @param array $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_li( $content = null, array $attributes = [] ): Element {
		return Create::li( $content, $attributes );
	}
}

if ( ! function_exists( 'el_li_render' ) ) {
	/**
	 * Create and render a list item element.
	 *
	 * @param mixed $content    Element content.
	 * @param array $attributes Element attributes.
	 */
	function el_li_render( $content = null, array $attributes = [] ): void {
		Create::li_render( $content, $attributes );
	}
}

if ( ! function_exists( 'el_dl' ) ) {
	/**
	 * Create a definition list.
	 *
	 * @param array $items      Array of terms and definitions.
	 * @param array $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_dl( array $items = [], array $attributes = [] ): Element {
		return Create::dl( $items, $attributes );
	}
}

if ( ! function_exists( 'el_dl_render' ) ) {
	/**
	 * Create and render a definition list.
	 *
	 * @param array $items      Array of terms and definitions.
	 * @param array $attributes Element attributes.
	 */
	function el_dl_render( array $items = [], array $attributes = [] ): void {
		Create::dl_render( $items, $attributes );
	}
}

if ( ! function_exists( 'el_menu' ) ) {
	/**
	 * Create a menu (navigation list).
	 *
	 * @param array $items      Array of menu items.
	 * @param array $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_menu( array $items, array $attributes = [] ): Element {
		return Create::menu( $items, $attributes );
	}
}

if ( ! function_exists( 'el_menu_render' ) ) {
	/**
	 * Create and render a menu (navigation list).
	 *
	 * @param array $items      Array of menu items.
	 * @param array $attributes Element attributes.
	 */
	function el_menu_render( array $items, array $attributes = [] ): void {
		Create::menu_render( $items, $attributes );
	}
}

if ( ! function_exists( 'el_dropdown' ) ) {
	/**
	 * Create a dropdown menu.
	 *
	 * @param string $label      Dropdown label.
	 * @param array  $items      Array of dropdown items.
	 * @param array  $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_dropdown( string $label, array $items, array $attributes = [] ): Element {
		return Create::dropdown( $label, $items, $attributes );
	}
}

if ( ! function_exists( 'el_dropdown_render' ) ) {
	/**
	 * Create and render a dropdown menu.
	 *
	 * @param string $label      Dropdown label.
	 * @param array  $items      Array of dropdown items.
	 * @param array  $attributes Element attributes.
	 */
	function el_dropdown_render( string $label, array $items, array $attributes = [] ): void {
		Create::dropdown_render( $label, $items, $attributes );
	}
}

/**
 * Create a list of links with flexible input format.
 *
 * @param array $links      Array of links in various formats:
 *                          - Associative array with keys as URLs and values as link text
 *                          - Array of arrays with 'href' and 'text' keys
 *                          - Array of arrays with additional attributes
 * @param array $list_attrs Attributes for the list element
 * @param bool  $ordered    Whether to create an ordered list (true) or unordered list (false)
 *
 * @return Element
 */
function el_link_list( array $links, array $list_attrs = [], bool $ordered = false ): Element {
	$items = [];

	foreach ( $links as $key => $value ) {
		if ( is_string( $key ) && is_string( $value ) ) {
			$items[] = el_a( $key, $value );
		} elseif ( is_array( $value ) && isset( $value['href'], $value['text'] ) ) {
			$attributes = $value;
			$href       = $attributes['href'];
			$text       = $attributes['text'];

			// Remove href and text from attributes
			unset( $attributes['href'], $attributes['text'] );

			$items[] = el_a( $href, $text, $attributes );
		} elseif ( $value instanceof Element && $value->get_tag() === 'a' ) {
			$items[] = $value;
		}
	}

	// Create ordered or unordered list based on preference
	return $ordered ? el_ol( $items, $list_attrs ) : el_ul( $items, $list_attrs );
}

/**
 * Create and render a list of links with flexible input format.
 *
 * @param array $links      Array of links in various formats:
 *                          - Associative array with keys as URLs and values as link text
 *                          - Array of arrays with 'href' and 'text' keys
 *                          - Array of arrays with additional attributes
 * @param array $list_attrs Attributes for the list element
 * @param bool  $ordered    Whether to create an ordered list (true) or unordered list (false)
 */
function el_link_list_render( array $links, array $list_attrs = [], bool $ordered = false ): void {
	el_link_list( $links, $list_attrs, $ordered )->output();
}

if ( ! function_exists( 'el_list' ) ) {
	/**
	 * Create either an ordered or unordered list element.
	 *
	 * @param array $items      List items.
	 * @param bool  $ordered    Whether to create an ordered list (true) or unordered list (false).
	 * @param array $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_list( array $items = [], bool $ordered = false, array $attributes = [] ): Element {
		return $ordered ? el_ol( $items, $attributes ) : el_ul( $items, $attributes );
	}
}

if ( ! function_exists( 'el_list_render' ) ) {
	/**
	 * Create and render either an ordered or unordered list element.
	 *
	 * @param array $items      List items.
	 * @param bool  $ordered    Whether to create an ordered list (true) or unordered list (false).
	 * @param array $attributes Element attributes.
	 */
	function el_list_render( array $items = [], bool $ordered = false, array $attributes = [] ): void {
		el_list( $items, $ordered, $attributes )->output();
	}
}