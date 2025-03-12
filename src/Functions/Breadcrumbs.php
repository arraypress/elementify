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
use Elementify\Components\Breadcrumbs;

if ( ! function_exists( 'el_breadcrumbs' ) ) {
	/**
	 * Create a breadcrumbs component.
	 *
	 * @param array  $items       Array of breadcrumb items.
	 * @param string $separator   Separator between items.
	 * @param array  $attributes  Element attributes.
	 * @param bool   $include_css Whether to include built-in CSS.
	 *
	 * @return Breadcrumbs
	 */
	function el_breadcrumbs( array $items = [], string $separator = '/', array $attributes = [], bool $include_css = true ): Breadcrumbs {
		return Create::breadcrumbs( $items, $separator, $attributes, $include_css );
	}
}

if ( ! function_exists( 'el_breadcrumbs_render' ) ) {
	/**
	 * Create and render a breadcrumbs component.
	 *
	 * @param array  $items       Array of breadcrumb items.
	 * @param string $separator   Separator between items.
	 * @param array  $attributes  Element attributes.
	 * @param bool   $include_css Whether to include built-in CSS.
	 */
	function el_breadcrumbs_render( array $items = [], string $separator = '/', array $attributes = [], bool $include_css = true ): void {
		Create::breadcrumbs_render( $items, $separator, $attributes, $include_css );
	}
}

if ( ! function_exists( 'el_breadcrumbs_from_path' ) ) {
	/**
	 * Create breadcrumbs from a path string.
	 *
	 * @param string $path     Path string to convert to breadcrumbs.
	 * @param string $base_url Base URL for links.
	 * @param array  $options  Additional options including 'include_css' to enable/disable CSS.
	 *
	 * @return Breadcrumbs
	 */
	function el_breadcrumbs_from_path( string $path, string $base_url = '', array $options = [] ): Breadcrumbs {
		return Create::breadcrumbs_from_path( $path, $base_url, $options );
	}
}

if ( ! function_exists( 'el_breadcrumbs_from_path_render' ) ) {
	/**
	 * Create and render breadcrumbs from a path string.
	 *
	 * @param string $path     Path string to convert to breadcrumbs.
	 * @param string $base_url Base URL for links.
	 * @param array  $options  Additional options including 'include_css' to enable/disable CSS.
	 */
	function el_breadcrumbs_from_path_render( string $path, string $base_url = '', array $options = [] ): void {
		Create::breadcrumbs_from_path_render( $path, $base_url, $options );
	}
}

if ( ! function_exists( 'el_breadcrumbs_map' ) ) {
	/**
	 * Create a breadcrumbs component from a URL/label map.
	 *
	 * @param array  $path_map    Array with URLs as keys and labels as values.
	 *                            The last item can be a string for the current page.
	 * @param string $separator   Separator between items.
	 * @param array  $attributes  Element attributes.
	 * @param bool   $include_css Whether to include built-in CSS.
	 *
	 * @return Breadcrumbs
	 */
	function el_breadcrumbs_map( array $path_map, string $separator = '/', array $attributes = [], bool $include_css = true ): Breadcrumbs {
		$items        = [];
		$items_count  = count( $path_map );
		$current_item = 0;

		foreach ( $path_map as $url => $label ) {
			$current_item ++;
			$is_current = ( $current_item === $items_count );

			// If this is a string key and string value, it's a URL/label pair
			if ( is_string( $url ) && is_string( $label ) ) {
				if ( $is_current ) {
					$items[] = $label; // Current page is just a string
				} else {
					$items[] = [
						'text' => $label,
						'url'  => $url
					];
				}
			} // If the value is a string and the key is numeric, it's the current page
			elseif ( is_string( $label ) && is_numeric( $url ) ) {
				$items[] = $label;
			}
		}

		return Create::breadcrumbs( $items, $separator, $attributes, $include_css );
	}
}

if ( ! function_exists( 'el_breadcrumbs_map_render' ) ) {
	/**
	 * Create and render a breadcrumbs component from a URL/label map.
	 *
	 * @param array  $path_map    Array with URLs as keys and labels as values.
	 *                            The last item can be a string for the current page.
	 * @param string $separator   Separator between items.
	 * @param array  $attributes  Element attributes.
	 * @param bool   $include_css Whether to include built-in CSS.
	 */
	function el_breadcrumbs_map_render( array $path_map, string $separator = '/', array $attributes = [], bool $include_css = true ): void {
		el_breadcrumbs_map( $path_map, $separator, $attributes, $include_css )->output();
	}
}