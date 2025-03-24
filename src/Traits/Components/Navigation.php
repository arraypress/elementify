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
use Elementify\Components\Interactive\Tabs;

/**
 * Navigation Components Trait
 *
 * Provides methods for creating and rendering navigation-related HTML components
 * like tabs and breadcrumbs.
 */
trait Navigation {

	/**
	 * Create a tabs component
	 *
	 * @param array  $tabs        Array of tabs with 'id', 'title', and 'content' keys
	 * @param string $active_tab  ID of the active tab
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return Tabs
	 */
	public static function tabs( array $tabs = [], string $active_tab = '', array $attributes = [], bool $include_css = true ): Tabs {
		return new Tabs( $tabs, $active_tab, $attributes, $include_css );
	}

	/**
	 * Create and render a tabs component
	 *
	 * @param array  $tabs        Array of tabs with 'id', 'title', and 'content' keys
	 * @param string $active_tab  ID of the active tab
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return void
	 */
	public static function tabs_render( array $tabs = [], string $active_tab = '', array $attributes = [], bool $include_css = true ): void {
		self::tabs( $tabs, $active_tab, $attributes, $include_css )->output();
	}

	/**
	 * Create a tabbed interface component with flexible input format
	 *
	 * @param array  $tabs        Array of tabs with ID as key and array with 'title' and 'content' as value
	 * @param string $active_tab  ID of the tab that should be active by default
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return Tabs
	 */
	public static function tabs_flexible( array $tabs, string $active_tab = '', array $attributes = [], bool $include_css = true ): Tabs {
		$tabs_array = [];

		// Transform our associative array format to the format expected by self::tabs
		foreach ( $tabs as $id => $tab ) {
			if ( is_array( $tab ) && isset( $tab['title'] ) && isset( $tab['content'] ) ) {
				$tabs_array[] = [
					'id'      => $id,
					'title'   => $tab['title'],
					'content' => $tab['content']
				];
			}
		}

		// Default to first tab if no active tab specified
		if ( empty( $active_tab ) && ! empty( $tabs ) ) {
			reset( $tabs );
			$active_tab = key( $tabs );
		}

		return self::tabs( $tabs_array, $active_tab, $attributes, $include_css );
	}

	/**
	 * Create and render a tabbed interface component with flexible input format
	 *
	 * @param array  $tabs        Array of tabs with ID as key and array with 'title' and 'content' as value
	 * @param string $active_tab  ID of the tab that should be active by default
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return void
	 */
	public static function tabs_flexible_render( array $tabs, string $active_tab = '', array $attributes = [], bool $include_css = true ): void {
		self::tabs_flexible( $tabs, $active_tab, $attributes, $include_css )->output();
	}

	/**
	 * Create tabs with common action buttons added to each tab
	 *
	 * @param array  $tabs_content   Array of tabs with ID as key and array with 'title' and 'content' as value
	 * @param array  $common_actions Array of action buttons to add to each tab
	 *                               Each action should have 'text' and optionally 'class' and 'action' keys
	 * @param string $active_tab     ID of the tab that should be active by default
	 * @param array  $attributes     Element attributes
	 * @param bool   $include_css    Whether to include built-in CSS (default: true)
	 *
	 * @return Tabs The tabs component with action buttons
	 */
	public static function action_tabs( array $tabs_content, array $common_actions = [], string $active_tab = '', array $attributes = [], bool $include_css = true ): Tabs {
		$tabs = [];

		foreach ( $tabs_content as $id => $tab ) {
			$content = $tab['content'];

			// Add common actions to each tab if provided
			if ( ! empty( $common_actions ) ) {
				$actions_html = '<div class="tab-actions">';

				foreach ( $common_actions as $action ) {
					$actions_html .= self::button(
						$action['text'],
						'button',
						[
							'class'       => 'action-button ' . ( $action['class'] ?? '' ),
							'data-action' => $action['action'] ?? ''
						]
					)->render();
				}

				$actions_html .= '</div>';

				$content .= $actions_html;
			}

			$tabs[ $id ] = [
				'title'   => $tab['title'],
				'content' => $content
			];
		}

		return self::tabs_flexible( $tabs, $active_tab, $attributes, $include_css );
	}

	/**
	 * Create and render tabs with common action buttons added to each tab
	 *
	 * @param array  $tabs_content   Array of tabs with ID as key and array with 'title' and 'content' as value
	 * @param array  $common_actions Array of action buttons to add to each tab
	 *                               Each action should have 'text' and optionally 'class' and 'action' keys
	 * @param string $active_tab     ID of the tab that should be active by default
	 * @param array  $attributes     Element attributes
	 * @param bool   $include_css    Whether to include built-in CSS (default: true)
	 *
	 * @return void
	 */
	public static function action_tabs_render( array $tabs_content, array $common_actions = [], string $active_tab = '', array $attributes = [], bool $include_css = true ): void {
		self::action_tabs( $tabs_content, $common_actions, $active_tab, $attributes, $include_css )->output();
	}

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