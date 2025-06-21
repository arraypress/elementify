<?php
/**
 * Elementify Library - Navigation Components Trait
 *
 * A collection of methods for creating navigation-related HTML components.
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

use Elementify\Components\Layout\Breadcrumbs;

/**
 * Navigation Components Trait
 *
 * Provides methods for creating and rendering navigation-related HTML components
 * like breadcrumbs.
 */
trait Navigation {

	/**
	 * Create breadcrumbs component
	 *
	 * @param array  $items       Array of breadcrumb items
	 * @param string $separator   Separator between items
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return Breadcrumbs
	 */
	public static function breadcrumbs( array $items = [], string $separator = '/', array $attributes = [], bool $include_css = true ): Breadcrumbs {
		return new Breadcrumbs( $items, $separator, $attributes, $include_css );
	}

	/**
	 * Create and render breadcrumbs component
	 *
	 * @param array  $items       Array of breadcrumb items
	 * @param string $separator   Separator between items
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return void
	 */
	public static function breadcrumbs_render( array $items = [], string $separator = '/', array $attributes = [], bool $include_css = true ): void {
		self::breadcrumbs( $items, $separator, $attributes, $include_css )->output();
	}

	/**
	 * Create breadcrumbs from a URL path
	 *
	 * @param string $path     URL path
	 * @param string $base_url Base URL for links
	 * @param array  $options  Additional options including 'include_css' to enable/disable CSS
	 *
	 * @return Breadcrumbs
	 */
	public static function breadcrumbs_from_path( string $path, string $base_url = '', array $options = [] ): Breadcrumbs {
		return Breadcrumbs::from_path( $path, $base_url, $options );
	}

	/**
	 * Create and render breadcrumbs from a URL path
	 *
	 * @param string $path     URL path
	 * @param string $base_url Base URL for links
	 * @param array  $options  Additional options including 'include_css' to enable/disable CSS
	 *
	 * @return void
	 */
	public static function breadcrumbs_from_path_render( string $path, string $base_url = '', array $options = [] ): void {
		self::breadcrumbs_from_path( $path, $base_url, $options )->output();
	}

	/**
	 * Create breadcrumbs component from a URL/label map
	 *
	 * @param array  $path_map    Array with URLs as keys and labels as values
	 *                            The last item can be a string for the current page
	 * @param string $separator   Separator between items
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return Breadcrumbs
	 */
	public static function breadcrumbs_map( array $path_map, string $separator = '/', array $attributes = [], bool $include_css = true ): Breadcrumbs {
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

		return self::breadcrumbs( $items, $separator, $attributes, $include_css );
	}

	/**
	 * Create and render breadcrumbs component from a URL/label map
	 *
	 * @param array  $path_map    Array with URLs as keys and labels as values
	 *                            The last item can be a string for the current page
	 * @param string $separator   Separator between items
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return void
	 */
	public static function breadcrumbs_map_render( array $path_map, string $separator = '/', array $attributes = [], bool $include_css = true ): void {
		self::breadcrumbs_map( $path_map, $separator, $attributes, $include_css )->output();
	}

}