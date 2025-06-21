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
 * like breadcrumbs with icon support.
 */
trait Navigation {

	/**
	 * Create breadcrumbs component
	 *
	 * @param array  $items       Array of breadcrumb items
	 * @param string $separator   Separator between items
	 * @param array  $attributes  Element attributes
	 *
	 * @return Breadcrumbs
	 */
	public static function breadcrumbs( array $items = [], string $separator = '/', array $attributes = [] ): Breadcrumbs {
		return new Breadcrumbs( $items, $separator, $attributes );
	}

	/**
	 * Create breadcrumbs with icons using a simplified API
	 *
	 * @param array  $items       Array of items in format: [['icon', 'text', 'url'], ['icon', 'text']] or [['text' =>
	 *                            '', 'icon' => '', 'url' => '']]
	 * @param string $separator   Separator between items
	 * @param array  $attributes  Element attributes
	 *
	 * @return Breadcrumbs
	 */
	public static function breadcrumbs_with_icons( array $items = [], string $separator = '›', array $attributes = [] ): Breadcrumbs {
		return new Breadcrumbs( $items, $separator, $attributes );
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
	 * Create breadcrumbs component from a URL/label map
	 *
	 * @param array  $path_map    Array with URLs as keys and labels as values
	 *                            The last item can be a string for the current page
	 * @param string $separator   Separator between items
	 * @param array  $attributes  Element attributes
	 *
	 * @return Breadcrumbs
	 */
	public static function breadcrumbs_map( array $path_map, string $separator = '/', array $attributes = [] ): Breadcrumbs {
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

		return self::breadcrumbs( $items, $separator, $attributes );
	}

	/**
	 * Create a breadcrumb from a path string (compatible with your existing method)
	 * This method provides backward compatibility with your existing Breadcrumb class API
	 *
	 * @param string      $base_url   Base URL for the breadcrumb links
	 * @param string      $base_label Label for the base URL
	 * @param string|null $base_icon  Optional. Dashicon for the base. Default null.
	 * @param string      $path       Forward slash separated path string
	 * @param string      $separator  Optional. Separator between items. Default '›'.
	 * @param array       $classes    Optional. CSS classes for container. Default empty array.
	 *
	 * @return Breadcrumbs
	 */
	public static function breadcrumbs_legacy(
		string $base_url,
		string $base_label,
		?string $base_icon = null,
		string $path = '',
		string $separator = '›',
		array $classes = []
	): Breadcrumbs {
		return Breadcrumbs::from_path_legacy( $base_url, $base_label, $base_icon, $path, $separator, $classes );
	}

	/**
	 * Create a back button/link component
	 *
	 * @param string      $url     The URL for the back link
	 * @param string      $label   Optional. Label for the back button. Default 'Back'.
	 * @param string|null $icon    Optional. Dashicon class. Default 'arrow-left-alt'.
	 * @param array       $classes Optional. CSS classes. Default empty array.
	 *
	 * @return string HTML for the back button
	 */
	public static function back_button(
		string $url,
		string $label = 'Back',
		?string $icon = 'arrow-left-alt',
		array $classes = []
	): string {
		$button_classes = array_merge( [ 'button' ], $classes );

		$content = '';
		if ( $icon ) {
			$content .= self::span()->add_class( "dashicons dashicons-{$icon}" )->set_attribute( 'style', 'margin-top: 3px;' )->render() . ' ';
		}
		$content .= $label;

		$back_button = self::div(
			self::a( $url, $content, [ 'class' => implode( ' ', $button_classes ) ] ),
			[ 'class' => 'breadcrumb-back-button' ]
		);

		return $back_button->render();
	}

}